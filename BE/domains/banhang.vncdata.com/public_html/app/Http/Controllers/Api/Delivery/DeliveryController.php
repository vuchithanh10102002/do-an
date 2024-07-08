<?php

namespace App\Http\Controllers\Api\Delivery;

use App\CusstomPHP\Response;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Routing\Controller;

class DeliveryController extends Controller{
    /**
     *
     * For update products invoice
     * @return \Illuminate\Http\Response
     */
    public function updateProductInvoice(Request $request)
    {
        $id_invoice=$request->get('id_invoice');
        $list_products=$request->get('list_products');

        $invoice=\DB::table(Tables::$tb_invoices)->where('id','=',$id_invoice)->first();

        if($invoice->type=="INVOICE"){
             return DeliveryController::xulyHoadonBanhang($list_products,$id_invoice);
        }
        if($invoice->type=="MOVE"){
             return DeliveryController::xulyHoadonChuyenhang($list_products,$id_invoice);
        }
        if($invoice->type=="RETURNIMPORT"){
             return DeliveryController::xulyHoadonTraNCC($list_products,$id_invoice);
        }
        if($invoice->type=="RETURN"){
            return DeliveryController::xulyHoadonTraHang($list_products,$id_invoice);
        }
        return Response::json_return($invoice, true);
    }

    //Xử lý nếu là sản phẩm hóa đơn bán hàng
    public static function xulyHoadonBanhang($list_products,$id_invoice){
        //Khai báo ban đầu
        $soluong_mua=0;
        $soluong_chuyen=0;

        //Giải mã các sản phẩm được gửi lên
        $list_products=json_decode($list_products);

        //Lấy thông tin hóa đơn
        $invoice=\DB::table(Tables::$tb_invoices)->where('id','=',$id_invoice)->first();

        //Kiểm tra trạng thái hóa đơn
        if($invoice->state=="SUCCESS" || $invoice->state=="ERROR"){
            //Đã hoàn thành hoặc lỗi thì không làm gì
            return Response::json_return($invoice, false);
        }
        if($invoice->state=="WAITING"){
            //Nếu là hóa đơn mới thì
            // tính tiền nợ cho khách
            $debt=intval($invoice->total_price)-intval($invoice->discount)+intval($invoice->other_price)-intval($invoice->total_pay);
            \DB::table(Tables::$tb_customer)->where('code','LIKE',$invoice->customer)
                ->increment("debt",$debt);
            //Tính tiền mua hàng
            \DB::table(Tables::$tb_customer)->where('code','LIKE',$invoice->customer)
                ->increment("price",$invoice->total_price);
            //Lượt mua hàng
            \DB::table(Tables::$tb_customer)->where('code','LIKE',$invoice->customer)
                ->increment("hit",1);
            //Cập nhật bản ghi logs
            $products_pay=json_decode($invoice->products);
            foreach($products_pay as $item){
                //Lấy giá nhập
                $sanpham_goc=\DB::table(Tables::$tb_products_list)->where([
                    ['code','LIKE',$item->code],
                    ['branch','LIKE',$invoice->branch]
                ])->first();
                \DB::table(Tables::$tb_product_logs)->insert([
                    'invoice'=>$invoice->code,
                    'product_list'=>$item->code,
                    'type'=>$invoice->type,
                    'branch'=>$invoice->branch,
                    'customer'=>$invoice->customer,
                    'customer_name'=>$invoice->customer_name,
                    'number'=>-($item->number),
                    'price'=>$item->price,
                    'price_import'=>intval($sanpham_goc->price_import)*intval($item->number),
                    'finance_cat'=>$invoice->finance_cat,
                    'create_at'=>Time::Datenow(),
                ]);
                //Tăng số lượng mua
                $soluong_mua+=intval($item->number);
            }
        }

        //Trừ số lượng sản phẩm
        foreach($list_products as $item){
            //Trừ số lượng trong product_list
            \DB::table(Tables::$tb_products_list)
                ->where([
                    ['code','LIKE',$item->pcode],
                    ['branch','LIKE',$invoice->branch]
                ])
                ->decrement('number',1);

            //Thay đổi thông tin sản phẩm products
            $id_product=substr($item->code,strripos($item->code,"/")+1,strlen($item->code));
            \DB::table(Tables::$tb_products)->where('id','=',$id_product)->update([
                'invoice'=>$invoice->code,
                'state'=>1,
                'customer'=>$invoice->customer
            ]);
        }

        //Kiểm tra số lượng đã đủ chưa, nếu chưa đủ thì chuyển trạng thái đã giao 1 phần, xong thì chuyển thành đã hoàn thành
        //Tính số lượng chuyển cho khách
        $soluong_chuyen=\DB::table(Tables::$tb_products)->where('invoice','LIKE',$invoice->code)->count();
        if($soluong_chuyen<$soluong_mua && $soluong_chuyen!=0){
            \DB::table(Tables::$tb_invoices)->where('id','=',$invoice->id)->update([
                'state'=>'SENDING'
            ]);
        }
        if ($soluong_chuyen==$soluong_mua){
            \DB::table(Tables::$tb_invoices)->where('id','=',$invoice->id)->update([
                'state'=>'SUCCESS'
            ]);
        }
        if ($soluong_chuyen>$soluong_mua){
            \DB::table(Tables::$tb_invoices)->where('id','=',$invoice->id)->update([
                'state'=>'ERROR'
            ]);
        }

        return Response::json_return($invoice, true);
    }


    //Xử lý nếu là sản phẩm hóa đơn chuyển hàng
    public static function xulyHoadonChuyenhang($list_products,$id_invoice){
        //Giải mã các sản phẩm được gửi lên
        $list_products=json_decode($list_products);
        //Lấy thông tin hóa đơn
        $invoice=\DB::table(Tables::$tb_invoices)->where('id','=',$id_invoice)->first();
        if($invoice->state=='WAITING'){
            $customer_sent=\DB::table(Tables::$tb_branch)->where('code','LIKE',$invoice->branch)->first();
            //Chuyển trạng thái hóa đơn
            \DB::table(Tables::$tb_invoices)->where('id','=',$id_invoice)->update([
                'state'=>'SUCCESS'
            ]);
            //Lưu hóa đơn nhận
            $fields_invoice_reci = Tables::getColumns(Tables::$tb_invoices);
            $data_invoice_reci = array();
            foreach ($fields_invoice_reci as $item_invoice_reci) {
                $data_invoice_reci[$item_invoice_reci] = $invoice->$item_invoice_reci;
            }
            unset($data_invoice_reci['id']);
            $data_invoice_reci['code']=str_replace_first('PC/','PNH/',$data_invoice_reci['code']);
            $data_invoice_reci['create_at'] = Time::now();
            $data_invoice_reci['type'] = 'RECEIVE';
            $data_invoice_reci['update_at'] = Time::now();
            $data_invoice_reci['branch'] = $invoice->customer;
            $data_invoice_reci['customer'] = $customer_sent->code;
            $data_invoice_reci['customer_name'] = $customer_sent->name;
            \DB::table(Tables::$tb_invoices)->insert($data_invoice_reci);
            //Trừ số lượng sản phẩm bên gửi
            foreach($list_products as $item){
                //Trừ số lượng trong product_list bên gửi
                \DB::table(Tables::$tb_products_list)->where([
                    ['code','LIKE',$item->pcode],
                    ['branch','LIKE',$invoice->branch]
                ])->decrement('number',1);
                //Tăng số lượng trong product_list bên nhận
                if(\DB::table(Tables::$tb_products_list)->where([
                        ['code','LIKE',$item->pcode],
                        ['branch','LIKE',$invoice->customer]]
                )->exists()){
                    \DB::table(Tables::$tb_products_list)->where([
                        ['code','LIKE',$item->pcode],
                        ['branch','LIKE',$invoice->customer]
                    ])->increment('number',1);
                }else{
                    //Thêm sản phẩm bên nhận
                    //Lấy thông tin trước
                    $product_a=\DB::table(Tables::$tb_products_list)->where([
                        ['code','LIKE',$item->pcode],
                        ['branch','LIKE',$invoice->branch]
                    ])->first();
                    //Cài số lượng mặc định
                    $product_a->number=1;
                    $product_a->branch=$invoice->customer;
                    $product_a->create_at=Time::now();
                    $product_a->update_at=Time::now();

                    $fields_a = Tables::getColumns(Tables::$tb_products_list);
                    $data_a = array();
                    //Get all fled submit form
                    foreach ($fields_a as $item_a) {
                        $data_a[$item_a] = $product_a->$item_a;
                    }
                    unset($data_a['id']);
                    //Thêm vào bên b
                    \DB::table(Tables::$tb_products_list)->insert($data_a);
                }

                //Thay đổi thông tin sản phẩm products
                $id_product=substr($item->code,strripos($item->code,"/")+1,strlen($item->code));
                \DB::table(Tables::$tb_products)->where('id','=',$id_product)->update([
                    'invoice'=>$invoice->code,
                    'state'=>0,
                    'branch'=>$invoice->customer,
                    'customer'=>$invoice->branch
                ]);
            }
            //Cập nhật bản ghi logs
            $products_pay=json_decode($invoice->products);
            foreach($products_pay as $item){
                //Bản log bên gửi
                \DB::table(Tables::$tb_product_logs)->insert([
                    'invoice'=>$invoice->code,
                    'product_list'=>$item->code,
                    'type'=>$invoice->type,
                    'branch'=>$invoice->branch,
                    'customer'=>$invoice->customer,
                    'customer_name'=>$invoice->customer_name,
                    'number'=>-($item->number),
                    'price'=>0, //'price'=>$item->price,
                    'price_import'=>0, //'price'=>$item->price,
                    'finance_cat'=>$invoice->finance_cat,
                    'create_at'=>Time::Datenow(),
                ]);
                //Bản log bên nhận
                \DB::table(Tables::$tb_product_logs)->insert([
                    'invoice'=>$invoice->code,
                    'product_list'=>$item->code,
                    'type'=>$invoice->type,
                    'branch'=>$invoice->customer,
                    'customer'=>$customer_sent->code,
                    'customer_name'=>$customer_sent->name,
                    'number'=>($item->number),
                    'price'=>0,
                    'price_import'=>0,
                    'finance_cat'=>$invoice->finance_cat,
                    'create_at'=>Time::Datenow(),
                ]);
            }
            return Response::json_return($invoice, true);
        }else{
            return Response::json_return($invoice, false);
        }
    }

    //Xử lý nếu là sản phẩm trả nhà cung cấp
    public static function xulyHoadonTraNCC($list_products,$id_invoice){
        //Giải mã các sản phẩm được gửi lên
        $list_products=json_decode($list_products);
        //Lấy thông tin hóa đơn
        $invoice=\DB::table(Tables::$tb_invoices)->where('id','=',$id_invoice)->first();
        if($invoice->state=='WAITING'){
            //Chuyển trạng thái hóa đơn
            \DB::table(Tables::$tb_invoices)->where('id','=',$id_invoice)->update([
                'state'=>'SUCCESS'
            ]);
            //Trừ số lượng sản phẩm
            foreach($list_products as $item){
                //Trừ số lượng trong product_list
                \DB::table(Tables::$tb_products_list)
                    ->where([
                        ['code','LIKE',$item->pcode],
                        ['branch','LIKE',$invoice->branch]
                    ])
                    ->decrement('number',1);
                //Thay đổi thông tin sản phẩm products
                $id_product=substr($item->code,strripos($item->code,"/")+1,strlen($item->code));
                \DB::table(Tables::$tb_products)->where('id','=',$id_product)->update([
                    'invoice'=>$invoice->code,
                    'state'=>1,
                    'customer'=>$invoice->customer
                ]);
            }
            //Cập nhật bản ghi logs
            $products_pay=json_decode($invoice->products);
            foreach($products_pay as $item){
                //Lấy giá nhập
                $sanpham_goc=\DB::table(Tables::$tb_products_list)->where([
                    ['code','LIKE',$item->code],
                    ['branch','LIKE',$invoice->branch]
                ])->first();
                \DB::table(Tables::$tb_product_logs)->insert([
                    'invoice'=>$invoice->code,
                    'product_list'=>$item->code,
                    'type'=>$invoice->type,
                    'branch'=>$invoice->branch,
                    'customer'=>$invoice->customer,
                    'customer_name'=>$invoice->customer_name,
                    'number'=>-($item->number),
                    'price'=>$item->price,
                    'price_import'=>intval($sanpham_goc->price_import)*intval($item->number),
                    'finance_cat'=>$invoice->finance_cat,
                    'create_at'=>Time::Datenow(),
                ]);
            }
            return Response::json_return($invoice, true);
        }else{
            return Response::json_return($invoice, false);
        }
    }

    //Xử lý trả hàng
    private static function xulyHoadonTraHang($list_products, $id_invoice)
    {
        //Giải mã các sản phẩm được gửi lên
        $list_products=json_decode($list_products);
        //Lấy thông tin hóa đơn
        $invoice=\DB::table(Tables::$tb_invoices)->where('id','=',$id_invoice)->first();
        if($invoice->state=='WAITING'){
            //Chuyển trạng thái hóa đơn
            \DB::table(Tables::$tb_invoices)->where('id','=',$id_invoice)->update([
                'state'=>'SUCCESS'
            ]);
            //Tăng số lượng sản phẩm
            foreach($list_products as $item){
                //Trừ số lượng trong product_list
                \DB::table(Tables::$tb_products_list)
                    ->where([
                        ['code','LIKE',$item->pcode],
                        ['branch','LIKE',$invoice->branch]
                    ])
                    ->increment('number',1);
                //Thay đổi thông tin sản phẩm products
                $id_product=substr($item->code,strripos($item->code,"/")+1,strlen($item->code));
                \DB::table(Tables::$tb_products)->where('id','=',$id_product)->update([
                    'invoice'=>$invoice->code,
                    'state'=>0,
                    'customer'=>$invoice->customer
                ]);
            }
            //Cập nhật bản ghi logs
            $products_pay=json_decode($invoice->products);
            foreach($products_pay as $item){
                //Lấy giá nhập
                $sanpham_goc=\DB::table(Tables::$tb_products_list)->where([
                    ['code','LIKE',$item->code],
                    ['branch','LIKE',$invoice->branch]
                ])->first();
                \DB::table(Tables::$tb_product_logs)->insert([
                    'invoice'=>$invoice->code,
                    'product_list'=>$item->code,
                    'type'=>$invoice->type,
                    'branch'=>$invoice->branch,
                    'customer'=>$invoice->customer,
                    'customer_name'=>$invoice->customer_name,
                    'number'=>($item->number),
                    'price'=>$item->price,
                    'price_import'=>intval($sanpham_goc->price_import)*intval($item->number),
                    'finance_cat'=>$invoice->finance_cat,
                    'create_at'=>Time::Datenow(),
                ]);
            }
            return Response::json_return($invoice, true);
        }else{
            return Response::json_return($invoice, false);
        }
    }
}