<?php

/**
 * Created by PhpStorm.
 * User: Hoang Dai
 * Date: 09/10/2017
 * Time: 10:38
 */

namespace App\Http\Controllers\Api\ProductData;

use App\CusstomPHP\Response;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Image;

class ProductDataController extends Controller
{
    public function store(Request $request)
    {
        //Get all columns table product
        $fields = Tables::getColumns(Tables::$tb_product_data);
        $data = array();
        //Get all fled submit form
        foreach ($fields as $item) {
            if ($request->exists($item)) {
                $data[$item] = $request->get($item);
            }
        }

        // dd($data);
        //Move image
        // Image::make($data['image'])->save('public/images/products/' . $data['code'] . '.png');
        // $data['image'] = $data['code'] . '.png';
        // dd($data['image']);

        if (\DB::table(Tables::$tb_product_data)->where([
            'code' => $data['code']
        ])->exists()) {
            $id_product_data = \DB::table(Tables::$tb_product_data)->where([
                'code' => $data['code']
            ])->update($data);
        } else {
            //Insert product
            $id_product_data = \DB::table(Tables::$tb_product_data)->insertGetId($data);
        }



        return Response::json_return($id_product_data, true);
    }
}
