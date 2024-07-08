<?php

namespace App\Http\Controllers\Api\Supplier;

use App\CusstomPHP\Response;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Routing\Controller;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = \DB::table(Tables::$tb_supplier)->get();
        return Response::json_return($suppliers, true);
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
        \DB::beginTransaction();
        try {
            $fields = Tables::getColumns(Tables::$tb_supplier);
            $data = array();
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            $data['id'] = null;
            $data['create_at'] = Time::now();
            $data['update_at'] = Time::now();

            $id = \DB::table(Tables::$tb_supplier)->insertGetId($data);
            $supplier = \DB::table(Tables::$tb_supplier)->where('id', '=', $id)->first();
            if (trim($supplier->code) == '') {
                \DB::table(Tables::$tb_supplier)->where('id', '=', $supplier->id)->update([
                    'code' => ('NCC' . $supplier->id)
                ]);
            }
            $supplier = \DB::table(Tables::$tb_supplier)->where('id', '=', $id)->first();

            \DB::commit();
            return Response::json_return($supplier, true);
        } catch (\Exception $ex) {
            \DB::rollBack();
            return Response::json_return($ex->getMessage(), false);
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
        $supplier = \DB::table(Tables::$tb_supplier)->where('id', '=', $id)->orWhere('code', '=', $id)->first();
        return Response::json_return($supplier, true);
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
        \DB::beginTransaction();
        try {
            $fields = Tables::getColumns(Tables::$tb_supplier);
            $data = array();
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            unset($data['create_at']);
            $data['update_at'] = Time::now();
            \DB::table(Tables::$tb_supplier)->where('id', '=', $id)->update($data);

            \DB::commit();
            return Response::json_return(null, true);

        } catch (\Exception $ex) {
            \DB::rollBack();
            return Response::json_return($ex->getMessage(), false);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \DB::beginTransaction();
        try {
            \DB::table(Tables::$tb_supplier)->where('id', '=', $id)->delete();
            \DB::commit();
            return Response::json_return(null, true);
        } catch (\Exception $ex) {
            \DB::rollBack();
            return Response::json_return($ex->getMessage(), false);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        try {
            $s = $request->get('s');

            $customer = \DB::table(Tables::$tb_supplier)->where('name', 'like', '%' . $s . '%')->orWhere('phone', 'like', '%' . $s . '%')->get();
            return Response::json_return($customer, true);
        } catch (\Exception $ex) {
            return Response::json_return($ex->getMessage(), false);
        }
    }
}
