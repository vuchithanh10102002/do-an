<?php

namespace App\Http\Controllers\Api\Setting;

use App\CusstomPHP\Response;
use App\CusstomPHP\Tables;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SettingController extends Controller
{
    /**
     * Display a getSetting of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSetting($name, $branch)
    {
        try {
            $setting = \DB::table(Tables::$tb_setting)->where([
                ['name', '=', $name],
                ['branch', '=', $branch]
            ])->first();
            return Response::json_return($setting, true);
        } catch (\Exception $ex) {
            return Response::json_return($ex->getMessage(), false);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        try {
            //Get all columns table product
            $fields = Tables::getColumns(Tables::$tb_setting);
            $data = array();
            //Get all fled submit form
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }

            $id_setting = \DB::table(Tables::$tb_setting)->insertGetId($data);
            $setting = \DB::table(Tables::$tb_setting)->where('id', '=', $id_setting)->first();
            return Response::json_return($setting, true);

        } catch (\Exception $ex) {
            return Response::json_return($ex->getLine(), false);
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
        //
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
        try {
            $setting = \DB::table(Tables::$tb_setting)->where([
                ['name', 'LIKE', $request->get('name')],
                ['branch', 'LIKE', $request->get('branch')]
            ])->update([
                'value'=>$request->get('value'),
                'name'=> $request->get('name'),
                'branch'=> $request->get('branch')
            ]);
            return Response::json_return($setting, true);
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
    public function destroy($id)
    {
        //
    }
}
