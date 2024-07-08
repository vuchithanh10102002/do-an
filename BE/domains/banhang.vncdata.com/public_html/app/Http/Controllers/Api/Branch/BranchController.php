<?php

namespace App\Http\Controllers\Api\Branch;

use App\CusstomPHP\Response;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Routing\Controller;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branch=\DB::table(Tables::$tb_branch)->get();
        return Response::json_return($branch,true);
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
            $fields = Tables::getColumns(Tables::$tb_branch);
            $data = array();
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            $data['id'] = null;
            $data['create_at'] = Time::now();
            $data['update_at'] = Time::now();

            if (\DB::table(Tables::$tb_branch)->insert($data)) {
                return Response::json_return(null,true);
            } else {
                return Response::json_return(null,false);
            }
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
        $branch=\DB::table(Tables::$tb_branch)->where('id','=',$id)->orWhere('code', '=',  $id)->first();
        return Response::json_return($branch,true);
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
            $fields = Tables::getColumns(Tables::$tb_branch);
            $data = array();
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            unset($data['create_at']);
            $data['update_at'] = Time::now();

            if (\DB::table(Tables::$tb_branch)->where('id', '=', $id)->update($data)) {
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
            if (\DB::table(Tables::$tb_branch)->where('id', '=', $id)->delete()) {
                return Response::json_return(null,true);
            } else {
                return Response::json_return(null,false);
            }
        } catch (\Exception $ex) {
            return Response::json_return($ex->getMessage(),false);
        }
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

            $branch = \DB::table(Tables::$tb_branch)
                ->where(Tables::$tb_branch . '.name', 'like', '%' . $s . '%')
                ->orWhere(Tables::$tb_branch . '.phone', 'like', '%' . $s . '%')
                ->get();

        
            return Response::json_return($branch, true);
        } catch (\Exception $ex) {
            return Response::json_return($ex->getMessage(), false);
        }
    }
}
