<?php

namespace App\Http\Controllers\Api\ProductImport;

use App\CusstomPHP\Response;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ReturnController extends Controller
{
    //Add new return
    public function store(Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get all columns table invoice
            $fields = Tables::getColumns(Tables::$tb_invoices);
            $data = array();
            //Get all fled submit form
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            //Update time invoice
            $data['create_at'] = time();
            $data['update_at'] = time();

            //Tạo mã hóa đơn ngẫu nhiên
            $code = '';
            do {
                $code = str_random(8);
                $code = $data['code'] . strtoupper($code);
            } while (\DB::table(Tables::$tb_invoices)->where('code', '=', $code)->exists());
            $data['code'] = $code;

            //Thêm hóa đơn vào bảng hóa đơn
            $id_invoice = \DB::table(Tables::$tb_invoices)->insertGetId($data);
            $invoice = \DB::table(Tables::$tb_invoices)->where('id', '=', $id_invoice)->first();


            //Giải mã các sản phẩm được gửi lên
            $list_products = json_decode($invoice->products);
            if ($invoice->state == 'SUCCESS') {
                //Trừ số lượng sản phẩm
                foreach ($list_products as $item) {
                    //Trừ số lượng trong product_list
                    \DB::table(Tables::$tb_products_list)
                        ->where([
                            ['code', 'LIKE', $item->code],
                            ['branch', 'LIKE', $invoice->branch]
                        ])
                        ->decrement('number', $item->number);
                }
                //Cập nhật bản ghi logs
                foreach ($list_products as $item) {
                    //Lấy giá nhập
                    $sanpham_goc = \DB::table(Tables::$tb_products_list)->where([
                        ['code', 'LIKE', $item->code],
                        ['branch', 'LIKE', $invoice->branch]
                    ])->first();
                    \DB::table(Tables::$tb_product_logs)->insert([
                        'invoice' => $invoice->code,
                        'product_list' => $item->code,
                        'type' => $invoice->type,
                        'branch' => $invoice->branch,
                        'customer' => $invoice->customer,
                        'customer_name' => $invoice->customer_name,
                        'number' => -($item->number),
                        'price' => $item->price,
                        'price_import' => intval($sanpham_goc->price_import) * intval($item->number),
                        'finance_cat' => $invoice->finance_cat,
                        'create_at' => time(),
                    ]);
                }
            }

            //Trả về thông tin hóa đơn
            \DB::commit();
            return Response::json_return($invoice, true);
        } catch (\Exception $ex) {
            \DB::rollBack();
            return Response::json_return($ex->getMessage(), false);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        \DB::beginTransaction();
        try {

            // Get all columns table invoice
            $fields = Tables::getColumns(Tables::$tb_invoices);
            $data = array();
            // Get all fields submit form
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            // Update time invoice
            $data['update_at'] = time();

            // Update invoice
            \DB::table(Tables::$tb_invoices)->where('id', '=', $id)->update($data);
            $invoice = \DB::table(Tables::$tb_invoices)->where('id', '=', $id)->first();

            // Update product logs (if state is SUCCESS)
            if ($invoice->state == 'SUCCESS') {
                $new_products = json_decode($invoice->products);

                foreach ($new_products as $new_product) {
                    // Check if product exists
                    if (!\DB::table(Tables::$tb_products_list)->where([
                        ['code', 'LIKE', $new_product->code],
                        ['branch', 'LIKE', $invoice->branch]
                    ])->exists()) {
                        // Prepare product data
                        $product_a = [
                            'id' => '',
                            'code' => $new_product->code,
                            'name' => $new_product->name,
                            'price_import' => $new_product->price_import,
                            'price_main' => $new_product->price_main,
                            'state' => 'ACTIVE',
                            'branch' => $invoice->branch,
                            'create_at' => time(),
                            'update_at' => time(),
                            'number' => 0,
                            'note' => '',
                            'price' => '',
                            'product_cat' => '',
                        ];

                        $fields_a = Tables::getColumns(Tables::$tb_products_list);
                        $data_a = array();
                        // Get all fields submit form
                        foreach ($fields_a as $item_a) {
                            $data_a[$item_a] = $product_a[$item_a];
                        }
                        unset($data_a['id']);
                        // Insert into products list
                        \DB::table(Tables::$tb_products_list)->insert($data_a);
                    }

                    // Decrement product number
                    \DB::table(Tables::$tb_products_list)->where([
                        ['code', 'LIKE', $new_product->code],
                        ['branch', 'LIKE', $invoice->branch]
                    ])->decrement('number', $new_product->number);

                    // Save to logs
                    \DB::table(Tables::$tb_product_logs)->insert([
                        'invoice' => $invoice->code,
                        'product_list' => $new_product->code,
                        'type' => $invoice->type,
                        'branch' => $invoice->branch,
                        'customer' => $invoice->customer,
                        'customer_name' => $invoice->customer_name,
                        'number' => $new_product->number,
                        'price' => $new_product->price,
                        'finance_cat' => $invoice->finance_cat,
                        'create_at' => time(),
                    ]);
                }
            }

            \DB::commit();
            return Response::json_return($invoice, true);
        } catch (\Exception $ex) {
            \DB::rollBack();
            return Response::json_return($ex->getLine(), false);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \DB::beginTransaction();
        //Delete invoice
        try {
            //get invoice
            $invoice=\DB::table(Tables::$tb_invoices)->where('id','=',$id)->first();
            //Delete invoice
            \DB::table(Tables::$tb_invoices)->where('id','=',$id)->delete();
            //delete product logs
            \DB::table(Tables::$tb_product_logs)->where('invoice','LIKE',$invoice->code)->delete();

            \DB::commit();
            return Response::json_return(null,true);
        } catch (\Exception $ex) {
            \DB::rollBack();
            return Response::json_return($ex->getMessage(),false);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $branch = $request->get('branch');

        if($branch != "" && $branch != null) {
            $invoice = \DB::table(Tables::$tb_invoices)
            ->where(Tables::$tb_invoices . '.type', '=', 'RETURNIMPORT')
            ->where('branch',  $branch)
            ->get();
        } else {
            $invoice = \DB::table(Tables::$tb_invoices)
            ->where(Tables::$tb_invoices . '.type', '=', 'RETURNIMPORT')
            ->get();
        }

        return Response::json_return($invoice, true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = \DB::table(Tables::$tb_invoices)->where('id', '=', $id)->first();
        return Response::json_return($invoice, true);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        try {
            $s = $request->get('s');
			$state = $request->get('state');
			$date1 = $request->get('date1');
			$date2 = $request->get('date2');
			// dd($date1, $date2);

            $invoice = \DB::table(Tables::$tb_invoices)
			->where([
				[Tables::$tb_invoices . '.customer_name', 'like', '%' . $s . '%'],
				[Tables::$tb_invoices . '.state', '=', $state],
				[Tables::$tb_invoices . '.type', '=', 'RETURNIMPORT'],
				[Tables::$tb_invoices . '.create_at', '>', $date1],
				[Tables::$tb_invoices . '.create_at', '<', $date2],
			])
			->OrderBy(Tables::$tb_invoices . '.create_at', 'asc')
			->get();

            return Response::json_return($invoice, true);
        } catch (\Exception $ex) {
            return Response::json_return($ex->getMessage(),false);
        }
    }
}