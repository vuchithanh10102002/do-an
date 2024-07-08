<?php

namespace App\Http\Controllers\Api\Customer;

use App\CusstomPHP\Response;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Routing\Controller;
use Mockery\Undefined;
use Symfony\Component\Console\Helper\Table;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = \DB::table(Tables::$tb_customer)
        ->join(Tables::$tb_branch, Tables::$tb_branch . '.code', '=', Tables::$tb_customer . '.id_branch')
        ->select(
            Tables::$tb_branch . '.name as branch',
            Tables::$tb_customer . '.*'
        )
        ->orderBy(Tables::$tb_customer . '.id', 'desc')
        ->get();
        return Response::json_return($customer, true);
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
            $fields = Tables::getColumns(Tables::$tb_customer);
            $data = array();
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            unset($data['id']);
            $id = '';
            $data['create_at'] = Time::now();
            $data['update_at'] = Time::now();

            if (!\DB::table(Tables::$tb_customer)->where('phone', 'LIKE', $data['phone'])->exists()) {
                $id = \DB::table(Tables::$tb_customer)->insertGetId($data);
                \DB::table(Tables::$tb_customer)->where('id', '=', $id)->update([
                    'code' => 'KH' . $id
                ]);
                if ($id != null) {
                    $customer = \DB::table(Tables::$tb_customer)->where('id', '=', $id)->first();
                    \DB::commit();
                    return Response::json_return($customer, true);
                }
            }
        } catch (\Exception $ex) {
        }
        \DB::rollBack();
        return Response::json_return(null, false);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = \DB::table(Tables::$tb_customer)
        ->where('id', '=', $id)
        ->orWhere('phone', '=', $id)
        ->orWhere('code', '=', $id)
        ->first();
        return Response::json_return($customer, true);
    }

    /**
     * Display the specified resource.
     *
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function show_by_code($code)
    {
        // dd($code);
        $customer = \DB::table(Tables::$tb_customer)
        ->where('code', '=', $code)->first();
        return Response::json_return($customer, true);
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
            $fields = Tables::getColumns(Tables::$tb_customer);
            $data = array();
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            unset($data['id']);
            $data['update_at'] = Time::now();

            if (\DB::table(Tables::$tb_customer)->where('id', '=', $id)->update($data)) {
                \DB::commit();
                $data = \DB::table(Tables::$tb_customer)->where('id', '=', $id)->first();
                return Response::json_return($data, true);
            }
        } catch (\Exception $ex) {
        }
        \DB::rollBack();
        return Response::json_return(null, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $customer = \DB::table(Tables::$tb_customer)->where('id', '=', $id)->delete();
            return Response::json_return(null, true);
        } catch (\Exception $ex) {
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

            $customer = \DB::table(Tables::$tb_customer)->where('name', 'like', '%' . $s . '%')->orWhere('phone', 'like', '%' . $s . '%')->orWhere('code', 'like', '%' . $s . '%')->get();
            return Response::json_return($customer, true);
        } catch (\Exception $ex) {
            return Response::json_return($ex->getMessage(), false);
        }
    }

}
