<?php

namespace App\Http\Controllers\Api\User;

use App\CusstomPHP\Response;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    /**
     * Display a information by token
     *
     * @return \Illuminate\Http\Response
     */
    public function information_users(Request $request)
    {
        $user=\DB::table(Tables::$tb_User)->where('access_token','=',$request->get('access_token'))->first([
            'id',
            'username',
            'name',
            'email',
            'level' ,
            'phone',
            'branch',
            'created_at',
            'updated_at',
            'state',
            'expire_token'
        ]);
        return Response::json_return($user,true);
    }
    /**
     * Display a listing of the level users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_level_users()
    {
        $levels=\App\Http\Controllers\UserController::$levels;
        return Response::json_return($levels,true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = \DB::table(Tables::$tb_User)->orderBy('created_at', 'asc')->get();
        return Response::json_return($users,true);
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
        try {
            $fields = Tables::getColumns(Tables::$tb_User);
            $data = array();
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            $data['id'] = null;
            $data['access_token'] = '';
            $data['password'] = \Hash::make($data['password']);
            $data['created_at'] = Time::now();
            $data['updated_at'] = Time::now();

            if (\DB::table(Tables::$tb_User)->insert($data)) {
                return Response::json_return(null, true);
            } else {
                return Response::json_return(null, false);
            }
        } catch (\Exception $ex) {
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
        $user = \DB::table(Tables::$tb_User)->where('id', '=', $id)->first();
        return Response::json_return($user, true);
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
            //If request logout
            if($request->exists('logout')){
                if (\DB::table(Tables::$tb_User)->where('id', '=', $id)->update([
                    'access_token'=>'',
                    'remember_token'=>''
                ])) {
                    return Response::json_return(null, true);
                } else {
                    return Response::json_return(null, false);
                }
            }
            //If request update
            $fields = Tables::getColumns(Tables::$tb_User);
            $data = array();
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            if($request->exists('password')){
                if ($data['password'] == '') {
                    unset($data['password']);
                } else {
                    $data['password'] = \Hash::make($data['password']);
                }
            }else{
                unset($data['password']);
            }
            unset($data['created_at']);
            unset($data['access_token']);
            $data['updated_at'] = Time::now();

            if (\DB::table(Tables::$tb_User)->where('id', '=', $id)->update($data)) {
                return Response::json_return(null, true);
            } else {
                return Response::json_return(null, false);
            }
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
        try {
            if (\DB::table(Tables::$tb_User)->where('id', '=', $id)->delete()) {
                return Response::json_return(null, true);
            } else {
                return Response::json_return(null, false);
            }
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

            $user = \DB::table(Tables::$tb_User)->where('name', 'like', '%' . $s . '%')->orWhere('phone', 'like', '%' . $s . '%')->get();
            return Response::json_return($user, true);
        } catch (\Exception $ex) {
            return Response::json_return($ex->getMessage(), false);
        }
    }
}
