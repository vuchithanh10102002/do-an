<?php

namespace App\Http\Controllers\Api\ProductReturn;

use App\CusstomPHP\Response;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use App\Http\Controllers\Api\Sale\SaleController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mockery\Undefined;

class ProductReturnController extends Controller
{

    public function store(Request $request)
    {
        \DB::beginTransaction();
        //Add new invoice
        try {
            //Get all columns table invoice
            $fields = Tables::getColumns(Tables::$tb_invoices);
            $invoice = array();
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
            // $data['products'] = $request->get('products');
            // $data['products2'] = $request->get('products2');
            // $return_price = $request->get('return_price');


            //Create QR code bỏ kiểu đi
            $code = '';
            do {
                $code = str_random(8);
                $code = $data['code'] . strtoupper($code);
            } while (\DB::table(Tables::$tb_invoices)->where('code', 'LIKE', $code)->exists());
            $data['code'] = $code;
            //Insert invoice
            $id_invoice = \DB::table(Tables::$tb_invoices)->insertGetId($data);
            if($data['state'] == 'SUCCESS') {
                $invoice[2] = \DB::table(Tables::$tb_invoices)->where('id', '=', $id_invoice)->first();
                if (!ProductReturnController::updateProduct($invoice[2])) {
                    \DB::rollBack();
                    return Response::json_return('loi', false);
                }
            }
            \DB::commit();
            return Response::json_return($invoice, true);
        } catch (\Exception $ex) {
            \DB::rollBack();
            return Response::json_return($ex->getMessage(), false);
        }
    }

    public function update(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            // Get all columns of the invoice table
            $fields = Tables::getColumns(Tables::$tb_invoices);
            $data = array();

            // Get all fields from the request
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }

            // Update the timestamp
            $data['update_at'] = time();

            // Get the existing invoice
            $existingInvoice = \DB::table(Tables::$tb_invoices)->where('id', $id)->first();
            if (!$existingInvoice) {
                \DB::rollBack();
                return Response::json_return('Invoice not found', false);
            }

            // Update the invoice
            \DB::table(Tables::$tb_invoices)->where('id', $id)->update($data);

            // If the state is 'SUCCESS', update the product information
            if ($data['state'] == 'SUCCESS') {
                $invoice = \DB::table(Tables::$tb_invoices)->where('id', $id)->first();
                if (!ProductReturnController::updateProduct($invoice)) {
                    \DB::rollBack();
                    return Response::json_return('Failed to update product information', false);
                }
            }

            \DB::commit();
            return Response::json_return('Invoice updated successfully', true);
        } catch (\Exception $ex) {
            \DB::rollBack();
            return Response::json_return($ex->getMessage(), false);
        }
    }


    public static function updateProduct($invoice)
    {
        \DB::beginTransaction();
        try {
            //Lưu thông tin hàng mua
            $products_pay = json_decode($invoice->products);
            foreach ($products_pay as $item) {
                $sanpham_goc = \DB::table(Tables::$tb_products_list)->where([
                    ['code', 'LIKE', $item->code],
                    ['branch', 'LIKE', $invoice->branch]
                ])->first();

                //Cập nhật bản ghi logs
                \DB::table(Tables::$tb_product_logs)->insert([
                    'invoice' => $invoice->code,
                    'product_list' => $item->code,
                    'type' => $invoice->type,
                    'branch' => $invoice->branch,
                    'customer' => $invoice->customer,
                    'customer_name' => $invoice->customer_name,
                    'number' => $item->number,
                    'price' => $item->price,
                    'price_import' => intval($sanpham_goc->price_import) * intval($item->number),
                    'finance_cat' => $invoice->finance_cat,
                    'create_at' => time(),
                ]);

                //Tăng số lượng trong product_list
                \DB::table(Tables::$tb_products_list)
                    ->where('id', '=', $sanpham_goc->id)
                    ->increment('number', $item->number);
            }
            // tính tiền nợ cho khách
            $debt = intval($invoice->total_price) - intval($invoice->discount) + intval($invoice->other_price) - intval($invoice->total_pay);
            \DB::table(Tables::$tb_customer)->where('code', 'LIKE', $invoice->customer)
                ->increment("debt", $debt);
            //Tính tiền mua hàng
            \DB::table(Tables::$tb_customer)->where('code', 'LIKE', $invoice->customer)
                ->decrement("price", $invoice->total_price);
            \DB::commit();
            return true;
        } catch (\Exception $exception) {
            \DB::rollBack();
            return false;
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
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        if($branch != '') {
            $query = \DB::table(Tables::$tb_invoices)
                ->join(Tables::$tb_customer, Tables::$tb_customer . '.code', '=', Tables::$tb_invoices . '.customer')
                            ->select(
                                Tables::$tb_customer . '.phone',
                                Tables::$tb_customer . '.address',
                                Tables::$tb_customer . '.email',
                                Tables::$tb_invoices . '.*'
                            )
                ->where(Tables::$tb_invoices . '.branch', '=', $branch);
        } else {

            $query = \DB::table(Tables::$tb_invoices)
            ->join(Tables::$tb_customer, Tables::$tb_customer . '.code', '=', Tables::$tb_invoices . '.customer')
                        ->select(
                            Tables::$tb_customer . '.phone',
                            Tables::$tb_customer . '.address',
                            Tables::$tb_customer . '.email',
                            Tables::$tb_invoices . '.*'
                        );
                
        }

        if ($date1 && $date2 && $date1 != "undefined" &&  $date2 != "undefined") {
            $query->whereBetween(Tables::$tb_invoices . '.create_at', [$date1, $date2]);
        }

        $invoice = $query->where(Tables::$tb_invoices . '.type',  '=' ,'RETURN')->OrderBy(Tables::$tb_invoices . '.create_at', 'asc')->get();


        
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
        $invoice = \DB::table(Tables::$tb_invoices)->where('id', '=', $id)->orderBy('create_at', 'asc')->first();
        return Response::json_return($invoice, true); 
    }

}
