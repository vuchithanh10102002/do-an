<?php
/**
 * Created by PhpStorm.
 * User: HDNET
 * Date: 21/10/2017
 * Time: 14:25ImportSelfProducedController
 */

namespace App\Http\Controllers\Api\ProductImport;

use App\CusstomPHP\Response;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ImportSelfProducedController extends Controller
{
    //Add new import
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

            //Create QR code
            $code = '';
            do {
                $code = str_random(8);
                $code = $data['code'] . strtoupper($code);
            } while (\DB::table(Tables::$tb_invoices)->where('code', 'LIKE', $code)->exists());
            $data['code'] = $code;

            //Insert invoice
            $id_invoice = \DB::table(Tables::$tb_invoices)->insertGetId($data);
            $invoice = \DB::table(Tables::$tb_invoices)->where('id', '=', $id_invoice)->first();

            //add product logs (not waiting)
            if ($invoice->state == 'SUCCESS') {
                $products = json_decode($invoice->products);
                foreach ($products as $product) {
                    //Thêm sản phẩm nếu chưa tồn tại
                    if(!\DB::table(Tables::$tb_products_list)->where([
                            ['code','LIKE',$product->code],
                            ['branch','LIKE',$invoice->branch]]
                    )->exists()){
                        //Lấy thông tin trước
                        $product_a=[
                            'id'=>'',
                            'code'=>$product->code,
                            'name'=>$product->name,
                            'price_import'=>$product->price_import,
                            'price_main'=>$product->price_main,
                            'state'=>'ACTIVE',
                            'branch'=>$invoice->branch,
                            'create_at'=>time(),
                            'update_at'=>time(),
                            'number'=>0,
                            'note'=>'',
                            'price'=>'',
                            'product_cat'=>'',
                        ];

                        $fields_a = Tables::getColumns(Tables::$tb_products_list);
                        $data_a = array();
                        //Get all fled submit form
                        foreach ($fields_a as $item_a) {
                            $data_a[$item_a] = $product_a[$item_a];
                        }
                        unset($data_a['id']);
                        //Thêm vào bảng sản phẩm
                        \DB::table(Tables::$tb_products_list)->insert($data_a);
                    }

                    //Thêm số lượng
                    
                    \DB::table(Tables::$tb_products_list)->where([
                        ['code','LIKE',$product->code],
                        ['branch','LIKE',$invoice->branch]
                    ])->increment('number', $product->number);
                    //Save to logs
                    \DB::table(Tables::$tb_product_logs)->insert([
                        'invoice' => $invoice->code,
                        'product_list' => $product->code,
                        'type' => $invoice->type,
                        'branch' => $invoice->branch,
                        'customer' => $invoice->customer,
                        'customer_name' => $invoice->customer_name,
                        'number' => $product->number,
                        'price' => $product->price,
                        'finance_cat' => $invoice->finance_cat,
                        'create_at' => Time::Datenow(),
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
            // Get old invoice data
            $old_invoice = \DB::table(Tables::$tb_invoices)->where('id', '=', $id)->first();
            $old_products = json_decode($old_invoice->products);

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

                    // dd(\DB::table(Tables::$tb_products_list)->where([
                    //     ['code', 'LIKE', $new_product->code],
                    //     ['branch', 'LIKE', $invoice->branch]
                    // ])->first());

                    // Increment product number
                    \DB::table(Tables::$tb_products_list)->where([
                        ['code', 'LIKE', $new_product->code],
                        ['branch', 'LIKE', $invoice->branch]
                    ])->increment('number', $new_product->number);

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
        // dd($branch);
        if($branch != "" && $branch != null) {
            $sale_list = \DB::table(Tables::$tb_invoices)
            ->where('branch', '=', $branch)
            ->where('type',  'IMPORT')
            ->orderBy('create_at', 'asc')
            ->get();
        } else {
            $sale_list = \DB::table(Tables::$tb_invoices)
            
            ->where('type',  'IMPORT')
            ->orderBy('create_at', 'asc')
            ->get();
        }
        
        return Response::json_return($sale_list, true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = \DB::table(Tables::$tb_invoices)->where('id', '=', $id)->first();
        return Response::json_return($product, true);
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

            $invoice = \DB::table(Tables::$tb_invoices)
            ->where([
				[Tables::$tb_invoices . '.customer_name', 'like', '%' . $s . '%'],
				[Tables::$tb_invoices . '.state', '=', $state],
				[Tables::$tb_invoices . '.type', '=', 'IMPORT'],
				[Tables::$tb_invoices . '.create_at', '>', $date1],
				[Tables::$tb_invoices . '.create_at', '<', $date2],
			])
            ->OrderBy('create_at', 'asc')
            ->get();

            return Response::json_return($invoice, true);
        } catch (\Exception $ex) {
            return Response::json_return($ex->getMessage(),false);
        }
    }
}
