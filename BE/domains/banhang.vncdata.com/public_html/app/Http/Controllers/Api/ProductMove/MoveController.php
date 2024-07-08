<?php

namespace App\Http\Controllers\Api\ProductMove;

use App\CusstomPHP\Response;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MoveController extends Controller
{
    //Move products from A to B
    public function store(Request $request)
    {
        \DB::beginTransaction();
        //Add new invoice
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
            // $data['state'] = 'SUCCESS';

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


            if($invoice->state == 'SUCCESS') {
                $customer_sent = \DB::table(Tables::$tb_branch)->where('code', 'LIKE', $invoice->branch)->first();
                $list_products = json_decode($invoice->products);
                //Trừ số lượng sản phẩm bên gửi
                foreach ($list_products as $item) {
                    //Trừ số lượng trong product_list bên gửi
                    \DB::table(Tables::$tb_products_list)->where([
                        ['code', 'LIKE', $item->code],
                        ['branch', 'LIKE', $invoice->branch]
                    ])->decrement('number', $item->number);
                    //Tăng số lượng trong product_list bên nhận
                    if (\DB::table(Tables::$tb_products_list)->where([['code', 'LIKE', $item->code], ['branch', 'LIKE', $invoice->customer]])->exists()) {
                        \DB::table(Tables::$tb_products_list)->where([
                            ['code', 'LIKE', $item->code],
                            ['branch', 'LIKE', $invoice->customer]
                        ])->increment('number', $item->number);
                    } else {
                        //Thêm sản phẩm bên nhận
                        //Lấy thông tin trước
                        $product_a = \DB::table(Tables::$tb_products_list)->where([
                            ['code', 'LIKE', $item->code],
                            ['branch', 'LIKE', $invoice->branch]
                        ])->first();
                        //Cài số lượng mặc định
                        $product_a->number = $item->number;
                        $product_a->branch = $invoice->customer;
                        $product_a->create_at = time();
                        $product_a->update_at = time();

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

                }
                //Cập nhật bản ghi logs
                foreach ($list_products as $item) {
                    //Bản log bên gửi
                    \DB::table(Tables::$tb_product_logs)->insert([
                        'invoice' => $invoice->code,
                        'product_list' => $item->code,
                        'type' => $invoice->type,
                        'branch' => $invoice->branch,
                        'customer' => $invoice->customer,
                        'customer_name' => $invoice->customer_name,
                        'number' => -($item->number),
                        'price' => 0, //'price'=>$item->price,
                        'price_import' => 0, //'price'=>$item->price,
                        'finance_cat' => $invoice->finance_cat,
                        'create_at' => time(),
                    ]);
                    //Bản log bên nhận
                    \DB::table(Tables::$tb_product_logs)->insert([
                        'invoice' => $invoice->code,
                        'product_list' => $item->code,
                        'type' => $invoice->type,
                        'branch' => $invoice->customer,
                        'customer' => $customer_sent->code,
                        'customer_name' => $customer_sent->name,
                        'number' => ($item->number),
                        'price' => 0,
                        'price_import' => 0,
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
            
            // Fetch the existing invoice
            $existingInvoice = \DB::table(Tables::$tb_invoices)->where('id', $id)->first();
            if (!$existingInvoice) {
                \DB::rollBack();
                return Response::json_return('Invoice not found', false);
            }

            // Update the invoice
            \DB::table(Tables::$tb_invoices)->where('id', $id)->update($data);
            $invoice = \DB::table(Tables::$tb_invoices)->where('id', $id)->first();


            if($invoice->state == 'SUCCESS') {
                $customer_sent = \DB::table(Tables::$tb_branch)->where('code', 'LIKE', $invoice->branch)->first();
                $list_products = json_decode($invoice->products);

                // Adjust product quantities
                foreach ($list_products as $item) {
                    // Adjust quantities in the sending branch
                    \DB::table(Tables::$tb_products_list)->where([
                        ['code', 'LIKE', $item->code],
                        ['branch', 'LIKE', $invoice->branch]
                    ])->decrement('number', $item->number);

                    // Adjust quantities in the receiving branch
                    if (\DB::table(Tables::$tb_products_list)->where([['code', 'LIKE', $item->code], ['branch', 'LIKE', $invoice->customer]])->exists()) {
                        \DB::table(Tables::$tb_products_list)->where([
                            ['code', 'LIKE', $item->code],
                            ['branch', 'LIKE', $invoice->customer]
                        ])->increment('number', $item->number);
                    } else {
                        $product_a = \DB::table(Tables::$tb_products_list)->where([
                            ['code', 'LIKE', $item->code],
                            ['branch', 'LIKE', $invoice->branch]
                        ])->first();

                        $product_a->number = $item->number;
                        $product_a->branch = $invoice->customer;
                        $product_a->create_at = time();
                        $product_a->update_at = time();

                        $fields_a = Tables::getColumns(Tables::$tb_products_list);
                        $data_a = array();
                        foreach ($fields_a as $item_a) {
                            $data_a[$item_a] = $product_a->$item_a;
                        }
                        unset($data_a['id']);
                        \DB::table(Tables::$tb_products_list)->insert($data_a);
                    }
                }

                // Update product logs
                foreach ($list_products as $item) {
                    \DB::table(Tables::$tb_product_logs)->insert([
                        'invoice' => $invoice->code,
                        'product_list' => $item->code,
                        'type' => $invoice->type,
                        'branch' => $invoice->branch,
                        'customer' => $invoice->customer,
                        'customer_name' => $invoice->customer_name,
                        'number' => -($item->number),
                        'price' => 0,
                        'price_import' => 0,
                        'finance_cat' => $invoice->finance_cat,
                        'create_at' => time(),
                    ]);

                    \DB::table(Tables::$tb_product_logs)->insert([
                        'invoice' => $invoice->code,
                        'product_list' => $item->code,
                        'type' => $invoice->type,
                        'branch' => $invoice->customer,
                        'customer' => $customer_sent->code,
                        'customer_name' => $customer_sent->name,
                        'number' => $item->number,
                        'price' => 0,
                        'price_import' => 0,
                        'finance_cat' => $invoice->finance_cat,
                        'create_at' => time(),
                    ]);
                }
            }
            \DB::commit();
            return Response::json_return('Invoice updated successfully', true);
        } catch (\Exception $ex) {
            \DB::rollBack();
            return Response::json_return($ex->getMessage(), false);
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $branch = $request->get('branch');

        if($branch != "" && $branch != null) {
            $invoice = \DB::table(Tables::$tb_invoices)
                ->join(Tables::$tb_branch, Tables::$tb_branch . '.code', '=', Tables::$tb_invoices . '.branch')
                ->select(
                    Tables::$tb_branch . '.name',
                    Tables::$tb_invoices . '.*'
                )
                ->where(Tables::$tb_invoices . '.type', '=', 'MOVE')
                ->where('branch',  $branch)
                ->get();
        } else {
            $invoice = \DB::table(Tables::$tb_invoices)
            ->join(Tables::$tb_branch, Tables::$tb_branch . '.code', '=', Tables::$tb_invoices . '.branch')
            ->select(
                Tables::$tb_branch . '.name',
                Tables::$tb_invoices . '.*'
            )
            ->where(Tables::$tb_invoices . '.type', '=', 'MOVE')
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
    public function search(Request $request)
    {
        try {
            $s = $request->get('s');
            $s2 = $request->get('s2');
            $date1 = $request->get('date1');
            $date2 = $request->get('date2');

            $query = \DB::table(Tables::$tb_invoices)
                ->join(Tables::$tb_branch, Tables::$tb_branch . '.code', '=', Tables::$tb_invoices . '.branch')
                ->select(
                    Tables::$tb_branch . '.name',
                    Tables::$tb_invoices . '.*'
                )
                ->where(Tables::$tb_invoices . '.type', '=', 'MOVE');

            if ($s) {
                $query->where(Tables::$tb_invoices . '.customer_name', 'like', '%' . $s2 . '%');
            }

            if ($s2) {
                $query->where(Tables::$tb_branch . '.name', 'like', '%' . $s . '%');
            }

            if ($date1 && $date2) {
                $query->whereBetween(Tables::$tb_invoices . '.create_at', [$date1, $date2]);
            }

            $invoice = $query->orderBy('create_at', 'asc')->get();

            return Response::json_return($invoice, true);
        } catch (\Exception $ex) {
            return Response::json_return($ex->getMessage(), false);
        }
    }
}
