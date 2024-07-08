<?php

namespace App\Http\Controllers\Api\ProductList;

use App\CusstomPHP\Response;
use App\CusstomPHP\State;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Routing\Controller;

class ProductListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $branch = $request->get('branch');
        if($branch != '') {
            $products_list = \DB::table(Tables::$tb_products_list)
            ->join(Tables::$tb_branch, Tables::$tb_branch . '.code', '=', Tables::$tb_products_list . '.branch')
                            ->select(
                                Tables::$tb_branch . '.name as branch_name',
                                Tables::$tb_products_list . '.*'
                            )
            ->where(Tables::$tb_products_list . '.branch', '=', $branch)
            ->orderBy(Tables::$tb_products_list . '.create_at', 'asc')->get();
        } else {
            $products_list = \DB::table(Tables::$tb_products_list)
            ->join(Tables::$tb_branch, Tables::$tb_branch . '.code', '=', Tables::$tb_products_list . '.branch')
            ->select(
                Tables::$tb_branch . '.name as branch_name',
                Tables::$tb_products_list . '.*'
            )
            ->orderBy(Tables::$tb_products_list . '.create_at', 'asc')->get();
        }
        
        return Response::json_return($products_list, true);
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
            $fields = Tables::getColumns(Tables::$tb_products_list);
            $data = array();
            //Get all fled submit form
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            //Update time product
            $data['create_at'] = time();
            $data['update_at'] = time();

            //Check data submit
            if ($data['code'] == '') {
                //Return error
                return Response::json_return('No codes', false);
            }
            //Check name
            if($data['name']==''){
                $data['name']=$data['code'];
            }

            //Insert product
            $id_product = \DB::table(Tables::$tb_products_list)->insertGetId($data);

            $product = \DB::table(Tables::$tb_products_list)->where('id', '=', $id_product)->first();

            return Response::json_return($product,true);

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
    public function show($id)
    {
        $product = \DB::table(Tables::$tb_products_list)->where('id','=',$id)->orWhere('code', '=', $id)->first();
        return Response::json_return($product, true);
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
        try {
            //Get all columns table product
            $fields = Tables::getColumns(Tables::$tb_products_list);
            $data = array();
            //Get all fled submit form
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            //Update time product
            $data['update_at'] = time();

            //Check data submit
            if (!isset($data['code'])) {
                //Return error
                return Response::json_return('No codes', false);
            }

            //Update product
            if(\DB::table(Tables::$tb_products_list)->where('id','=',$id)->update($data)){
                $product=\DB::table(Tables::$tb_products_list)->where('id','=',$id)->first();
                return Response::json_return($product,true);
            }else{
                return Response::json_return(null,false);
            }

        } catch (\Exception $ex) {
            return Response::json_return($ex->getMessage(),false);
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
        //delete product
        try {
            if(\DB::table(Tables::$tb_products_list)->where('id','=',$id)->delete()){
                return Response::json_return(null,true);
            }else{
                return Response::json_return(null,false);
            }
        } catch (\Exception $ex) {
            return Response::json_return($ex->getMessage(),false);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        //search
        try {
            $s = $request->get('s');
            $branch = $request->get('branch');
            // dd($branch);

            if($branch != "null" && $branch != '' && $branch != "undefined") {
                $product = \DB::table(Tables::$tb_products_list)
                ->join(Tables::$tb_branch, Tables::$tb_branch . '.code', '=', Tables::$tb_products_list . '.branch')
                            ->select(
                                Tables::$tb_branch . '.name as branch_name',
                                Tables::$tb_products_list . '.*'
                            )
                ->where( Tables::$tb_products_list . '.name', 'like', '%' . $s . '%')
                ->where( Tables::$tb_products_list . '.branch', '=', $branch)->get();
            } else {
                $product = \DB::table(Tables::$tb_products_list)->where('name', 'like', '%' . $s . '%')->orWhere('code', 'like', '%' . $s . '%')->get();
            }

            return Response::json_return($product, true);
        } catch (\Exception $ex) {
            return Response::json_return($ex->getMessage(),false);
        }
    }
}
