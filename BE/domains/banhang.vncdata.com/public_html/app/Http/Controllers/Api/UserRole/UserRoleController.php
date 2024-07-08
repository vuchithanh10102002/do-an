<?php

namespace App\Http\Controllers\Api\UserRole;

use App\CusstomPHP\Response;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Routing\Controller;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userroles=\DB::table(Tables::$tb_user_roles)->get();
        return Response::json_return($userroles,true);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $fields = Tables::getColumns(Tables::$tb_user_roles);
            $data = array();
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            $data['id'] = null;

            $id=\DB::table(Tables::$tb_user_roles)->insertGetId($data);
            $userroles=\DB::table(Tables::$tb_user_roles)->where('id','=',$id)->first();
            return Response::json_return($userroles,true);
        } catch (\Exception $ex) {
            return Response::json_return($ex->getMessage(),false);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userroles=\DB::table(Tables::$tb_user_roles)->where('id','=',$id)->first();
        return Response::json_return($userroles,true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        try {
            $fields = Tables::getColumns(Tables::$tb_user_roles);
            $data = array();
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            if (\DB::table(Tables::$tb_user_roles)->where('id', '=', $id)->update($data)) {
                return Response::json_return(null,true);
            } else {
                return Response::json_return(null,false);
            }
        } catch (\Exception $ex) {
            return Response::json_return($ex->getMessage(),false);
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
        try {
            if (\DB::table(Tables::$tb_user_roles)->where('id', '=', $id)->delete()) {
                return Response::json_return(null,true);
            } else {
                return Response::json_return(null,false);
            }
        } catch (\Exception $ex) {
            return Response::json_return($ex->getMessage(),false);
        }
    }
}
