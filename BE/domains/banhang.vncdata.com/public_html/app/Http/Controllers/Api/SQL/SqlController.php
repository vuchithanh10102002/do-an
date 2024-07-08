<?php

namespace App\Http\Controllers\Api\SQL;

use App\CusstomPHP\Response;
use App\CusstomPHP\Tables;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Routing\Controller;


class SqlController extends Controller
{
    /**
     * @param Request $request
     */
    public function getSelect(Request $request)
    {
        $access_token = $request->get('access_token');
        $user_get = \DB::table(Tables::$tb_User)->where('access_token', 'LIKE', $access_token)->first();
        //
        try {
            $table = $request->get('table');
            if ($table == Tables::$tb_User) {
                $table = '';
            }
            $data = $request->get('data');
            $select = $request->get('select');
            $result = \DB::select("Select " . $data . " FROM " . $table . " " . $select);

            //Check mutil branch
            if ($user_get->mutil_branch != 'true') {
                //check products_list
                $table = mb_strtoupper($table);
                $table_product_list_check = mb_strtoupper(Tables::$tb_products_list);
                $table_invoice_check = mb_strtoupper(Tables::$tb_invoices);

                $select = mb_strtoupper($select);
                $select_check = mb_strtoupper("branch LIKE '" . $user_get->branch . "'");
                $select_check_all = mb_strtoupper("branch LIKE");
                //Check product_list
                if (str_contains($table, $table_product_list_check)) {
                    if (str_contains($select, $select_check_all)) {
                        if (!str_contains($select, $select_check)) {
                            return Response::json_return('Can not access to other branch data!',false);
                        }
                    }
                }
                //check invoice all
                if (str_contains($table, $table_invoice_check)) {
                    if (str_contains($select, $select_check_all)) {
                        if (!str_contains($select, $select_check)) {
                            return Response::json_return('Can not access to other branch data!',false);
                        }
                    }
                }
            }


            return Response::json_return($result, true);
        } catch (\Exception $ex) {
            return Response::json_return($ex->getMessage(), false);
        }
    }
}
