<?php

namespace App\Http\Controllers\Api\Report;

use App\CusstomPHP\Response;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_sale_log(Request $request)
    {
        $branch = $request->get('branch');
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        if($branch != '') {
            $query = \DB::table(Tables::$tb_product_logs)
            ->where('type',  '=' , 'INVOICE')
            ->where('branch', '=', $branch);
        } else {
            $query = \DB::table(Tables::$tb_product_logs)
            ->where('type',  '=' , 'INVOICE');
        }

        if ($date1 && $date2) {
            $query->whereBetween('create_at', [$date1, $date2]);
        }
        $product_log =  $query->get();
        return Response::json_return($product_log, true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_salereturn_log(Request $request)
    {
        $branch = $request->get('branch');
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        if($branch != '') {
            $query = \DB::table(Tables::$tb_product_logs)
            ->where('type',  '=' , 'RETURN')
            ->where('branch', '=', $branch);
        } else {
            $query = \DB::table(Tables::$tb_product_logs)
            ->where('type',  '=' , 'RETURN');
        }

        if ($date1 && $date2) {
            $query->whereBetween('create_at', [$date1, $date2]);
        }
        $product_log =  $query->get();
        return Response::json_return($product_log, true);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
     public function get_product_sale(Request $request)
    {
        $branch = $request->get('branch');
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        $query = \DB::table(Tables::$tb_product_logs)
            ->join(Tables::$tb_products_list, Tables::$tb_products_list . '.code', '=', Tables::$tb_product_logs . '.product_list')
            ->select(
                // Tables::$tb_product_logs . '.phone',
                Tables::$tb_products_list . '.*',
                \DB::raw('SUM(' . Tables::$tb_product_logs . '.number) as total_quantity'),
                \DB::raw('SUM(' . Tables::$tb_product_logs . '.price) as total_price')
            )
            ->where('type', '=', 'INVOICE');

        if ($branch != '') {
            $query->where(Tables::$tb_product_logs . '.branch', '=', $branch);
        }

        if ($date1 && $date2) {
            $query->whereBetween(Tables::$tb_product_logs . '.create_at', [$date1, $date2]);
        }

        $query->groupBy(Tables::$tb_product_logs . '.product_list');

        $product_log = $query->get();
        return Response::json_return($product_log, true);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_report_receipt(Request $request)
    {
        $branch = $request->get('branch');
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        // Đếm số phiếu trong bảng invoice
        $invoiceQuery = \DB::table(Tables::$tb_invoices);
        if ($branch) {
            $invoiceQuery->where('branch', $branch);
        }
        if ($date1 && $date2) {
            $invoiceQuery->whereBetween('create_at', [$date1, $date2]);
        }
        $invoiceCount = $invoiceQuery->where('type', '=', 'IMPORT')->count();

        // Đếm số sản phẩm không trùng nhau và tính tổng tiền trong bảng product_logs
        $productLogQuery = \DB::table(Tables::$tb_product_logs)
            ->join(Tables::$tb_products_list, Tables::$tb_products_list . '.code', '=', Tables::$tb_product_logs . '.product_list')
            ->select(
                \DB::raw('COUNT(DISTINCT ' . Tables::$tb_product_logs . '.product_list) as unique_products'),
                \DB::raw('SUM(' . Tables::$tb_product_logs . '.price) as total_price')
            )
            ->where('type', '=', 'IMPORT');

        if ($branch) {
            $productLogQuery->where(Tables::$tb_product_logs . '.branch', $branch);
        }
        if ($date1 && $date2) {
            $productLogQuery->whereBetween(Tables::$tb_product_logs . '.create_at', [$date1, $date2]);
        }

        $productLogReport = $productLogQuery->first();

        return Response::json_return([
            'invoice_count' => $invoiceCount,
            'unique_products' => $productLogReport->unique_products,
            'total_price' => $productLogReport->total_price
        ], true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_report_sale(Request $request)
    {
        $branch = $request->get('branch');
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        // Đếm số phiếu trong bảng invoice
        $invoiceQuery = \DB::table(Tables::$tb_invoices);
        if ($branch) {
            $invoiceQuery->where('branch', $branch);
        }
        if ($date1 && $date2) {
            $invoiceQuery->whereBetween('create_at', [$date1, $date2]);
        }
        $invoiceCount = $invoiceQuery->where('type', '=', 'INVOICE')->count();

        // Đếm số sản phẩm không trùng nhau và tính tổng tiền trong bảng product_logs
        $productLogQuery = \DB::table(Tables::$tb_product_logs)
            ->join(Tables::$tb_products_list, Tables::$tb_products_list . '.code', '=', Tables::$tb_product_logs . '.product_list')
            ->select(
                \DB::raw('COUNT(DISTINCT ' . Tables::$tb_product_logs . '.product_list) as unique_products'),
                \DB::raw('SUM(' . Tables::$tb_product_logs . '.price) as total_price')
            )
            ->where(Tables::$tb_product_logs . '.type', '=', 'INVOICE');

        if ($branch) {
            $productLogQuery->where(Tables::$tb_product_logs . '.branch', $branch);
        }
        if ($date1 && $date2) {
            $productLogQuery->whereBetween(Tables::$tb_product_logs . '.create_at', [$date1, $date2]);
        }

        $productLogReport = $productLogQuery->first();

        return Response::json_return([
            'invoice_count' => $invoiceCount,
            'unique_products' => $productLogReport->unique_products,
            'total_price' => $productLogReport->total_price
        ], true);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_report_move(Request $request)
    {
        $branch = $request->get('branch');
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        // Đếm số phiếu trong bảng invoice
        $invoiceQuery = \DB::table(Tables::$tb_invoices);
        if ($branch) {
            $invoiceQuery->where('branch', $branch);
        }
        if ($date1 && $date2) {
            $invoiceQuery->whereBetween('create_at', [$date1, $date2]);
        }
        $invoiceCount = $invoiceQuery->where('type', '=', 'MOVE')->count();

        return Response::json_return([
            'invoice_count' => $invoiceCount
        ], true);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_report_receiptreturn(Request $request)
    {
        $branch = $request->get('branch');
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        // Đếm số phiếu trong bảng invoice
        $invoiceQuery = \DB::table(Tables::$tb_invoices);
        if ($branch) {
            $invoiceQuery->where('branch', $branch);
        }
        if ($date1 && $date2) {
            $invoiceQuery->whereBetween('create_at', [$date1, $date2]);
        }
        $invoiceCount = $invoiceQuery->where('type', '=', 'RETURNIMPORT')->count();

        // Đếm số sản phẩm không trùng nhau và tính tổng tiền trong bảng product_logs
        $productLogQuery = \DB::table(Tables::$tb_product_logs)
            ->join(Tables::$tb_products_list, Tables::$tb_products_list . '.code', '=', Tables::$tb_product_logs . '.product_list')
            ->select(
                \DB::raw('COUNT(DISTINCT ' . Tables::$tb_product_logs . '.product_list) as unique_products'),
                \DB::raw('SUM(' . Tables::$tb_product_logs . '.price) as total_price')
            )
            ->where(Tables::$tb_product_logs . '.type', '=', 'RETURNIMPORT');

        if ($branch) {
            $productLogQuery->where(Tables::$tb_product_logs . '.branch', $branch);
        }
        if ($date1 && $date2) {
            $productLogQuery->whereBetween(Tables::$tb_product_logs . '.create_at', [$date1, $date2]);
        }

        $productLogReport = $productLogQuery->first();

        return Response::json_return([
            'invoice_count' => $invoiceCount,
            'unique_products' => $productLogReport->unique_products,
            'total_price' => $productLogReport->total_price
        ], true);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_report_productreturn(Request $request)
    {
        $branch = $request->get('branch');
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        // Đếm số phiếu trong bảng invoice
        $invoiceQuery = \DB::table(Tables::$tb_invoices);
        if ($branch) {
            $invoiceQuery->where('branch', $branch);
        }
        if ($date1 && $date2) {
            $invoiceQuery->whereBetween('create_at', [$date1, $date2]);
        }
        $invoiceCount = $invoiceQuery->where('type', '=', 'RETURN')->count();

        // Đếm số sản phẩm không trùng nhau và tính tổng tiền trong bảng product_logs
        $productLogQuery = \DB::table(Tables::$tb_product_logs)
            ->join(Tables::$tb_products_list, Tables::$tb_products_list . '.code', '=', Tables::$tb_product_logs . '.product_list')
            ->select(
                \DB::raw('COUNT(DISTINCT ' . Tables::$tb_product_logs . '.product_list) as unique_products'),
                \DB::raw('SUM(' . Tables::$tb_product_logs . '.price) as total_price')
            )
            ->where(Tables::$tb_product_logs . '.type', '=', 'RETURN');

        if ($branch) {
            $productLogQuery->where(Tables::$tb_product_logs . '.branch', $branch);
        }
        if ($date1 && $date2) {
            $productLogQuery->whereBetween(Tables::$tb_product_logs . '.create_at', [$date1, $date2]);
        }

        $productLogReport = $productLogQuery->first();

        return Response::json_return([
            'invoice_count' => $invoiceCount,
            'unique_products' => $productLogReport->unique_products,
            'total_price' => $productLogReport->total_price
        ], true);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_report_total(Request $request) {
        $branch = $request->get('branch');
        $query_product = \DB::table(Tables::$tb_products_list)
        ->select(
            \DB::raw('SUM(' . Tables::$tb_products_list . '.number) as total_quantity'),
            \DB::raw('SUM(' . Tables::$tb_products_list . '.price_main) as total_price')
        );
    
        $query_customer = \DB::table(Tables::$tb_customer)
        ->where(Tables::$tb_customer . '.debt', '>', 0);

        $query_customer_debt = \DB::table(Tables::$tb_customer)
        ->select(
            \DB::raw('SUM(' . Tables::$tb_customer . '.debt) as total_debt')
        );

        if ($branch) {
            $products = $query_product->where(Tables::$tb_products_list . '.branch', $branch)->first();
            $customers = $query_customer->where(Tables::$tb_customer . '.id_branch', $branch)->count();
            $customers_debt = $query_customer_debt->where(Tables::$tb_customer . '.id_branch', $branch)->first();
        } else {
            $products = $query_product->first();
            $customers = $query_customer->count();
            $customers_debt = $query_customer_debt->first();
        }

        $suppliers = \DB::table(Tables::$tb_supplier)
        ->where(Tables::$tb_supplier . '.total_owe', '>', 0)->count();

        $suppliers_debt = \DB::table(Tables::$tb_supplier)
        ->select(
            \DB::raw('SUM(' . Tables::$tb_supplier . '.total_owe) as total_owe')
        )->first();


        return Response::json_return([
            'total_quantity' => $products->total_quantity,
            'total_price' => $products->total_price,
            'total_customer' => $customers,
            'total_customer_debt' => $customers_debt->total_debt,
            'total_suppliers' => $suppliers,
            'total_suppliers_debt' => $suppliers_debt->total_owe
        ], true);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Add new product
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Update product
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete produc
    }
}
