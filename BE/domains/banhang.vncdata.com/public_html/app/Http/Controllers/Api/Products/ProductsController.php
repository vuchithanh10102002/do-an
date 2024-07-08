<?php

namespace App\Http\Controllers\Api\Products;

use App\CusstomPHP\Response;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class Products extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products_package = \DB::table(Tables::$tb_products_package)
        ->orderBy('create_at', 'asc')
        ->get();
        return Response::json_return($products_package, true);
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
            $fields = Tables::getColumns(Tables::$tb_products_package);
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

            //Create QR code
            $code = '';
            do {
                $code = str_random(8);
                $code = 'BAS/' . strtoupper($code);
            } while (\DB::table(Tables::$tb_products_package)->where('code', '=', $code)->exists());
            $data['code'] = $code;

            for($i=0;$i<intval($data['number_import']);$i++){
                \DB::table(Tables::$tb_products)->insert([
                    'code'=>$code."/".$i,
                    'pcode'=>$data['products'],
                    'branch'=>$data['branch'],
                    'customer'=>$data['supplier'],
                    'state'=>'0'
                ]);
            }

            //Insert product
            $id_product = \DB::table(Tables::$tb_products_package)->insertGetId($data);
            $products_package = \DB::table(Tables::$tb_products_package)->where('id', '=', $id_product)->first();
            return Response::json_return($products_package, true);

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
        $product = \DB::table(Tables::$tb_products_package)->where('id', '=', $id)->first();
        return Response::json_return($product, true);
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
        try {
            //Get all columns table product
            $fields = Tables::getColumns(Tables::$tb_products_package);
            $data = array();
            //Get all fled submit form
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            //Update time product
            $data['update_at'] = time();

            //Update product
            if (\DB::table(Tables::$tb_products_package)->where('id', '=', $id)->update($data)) {
                $products_package = \DB::table(Tables::$tb_products_package)->where('id', '=', $id)->first();
                return Response::json_return($products_package, true);
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
        //delete product
        try {
            if (\DB::table(Tables::$tb_products_package)->where('id', '=', $id)->delete()) {
                return Response::json_return(null, true);
            } else {
                return Response::json_return(null, false);
            }
        } catch (\Exception $ex) {
            return Response::json_return($ex->getMessage(), false);
        }
    }
}
