<?php

namespace App\Http\Middleware;

use App\CusstomPHP\Response;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use App\Http\Controllers\UserController;
use Carbon\Carbon;
use Closure;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        try {
            //Except
            $except = AccessToken::check_except($request->fullUrl());
            if ($except) {
                return $next($request);
            } else {
                if ($request->exists('access_token')) {
                    $access_token = $request->get('access_token');
                    if (AccessToken::checkToken($access_token)) {
                        if ($this->checkpermission($request, $access_token)) {
                            return $next($request);
                        } else {
                            return Response::json_return('Permission error', false);
                        }
                    }
                }
            }
        } catch (\Exception $ex) {
            return Response::json_return($ex, false);
        }
        return Response::json_return('Login error', false);
    }

    //Check token user token expire
    public static function checkToken($access_token)
    {
        if (\DB::table(Tables::$tb_User)->where('access_token', '=', $access_token)->exists()) {
            $user = \DB::table(Tables::$tb_User)->where('access_token', '=', $access_token)->first();
            if ($user->access_token == $access_token) {
                $time_now = Carbon::now(Time::$timestamp);
                $time_expire = Carbon::createFromFormat(Time::$format_date_time_full, $user->expire_token, Time::$timestamp);
                if ($time_now->lte($time_expire)) {
                    return true;
                }
            }
        }
        return false;
    }

    //Check permission user
    public static function checkpermission(Request $request, $access_token)
    {
        $method = $request->method();
        $link = $request->url();
        $level = \DB::table(Tables::$tb_User)->where('access_token', '=', $access_token)->first(['level'])->level;
        $permission_user = AccessToken::get_permissions_by_code($level);
        $permission_require = AccessToken::get_permission($link, $method);
        //Search
        if ($permission_require != null && $permission_user != null) {
            foreach ($permission_user as $permission) {
                if ($permission == $permission_require) {
                    return true;
                }
            }
        }
        return false;
    }

    //get permissions from code
    public static function get_permissions_by_code($code)
    {
        //$roles = UserController::$levels;
        try {
            $rolos = \DB::table(Tables::$tb_user_roles)->where('code', 'LIKE', $code)->first();
            return json_decode($rolos->roles);
        } catch (\Exception $e) {
            return null;
        }

        //        foreach ($roles as $role) {
        //            if ($role['code'] == $code) {
        //                return $role['permissions'];
        //            }
        //        }

    }

    //get permission from link and method
    public static function get_permission($link, $method)
    {
        $permissions = UserController::$permission;
        $base_url = url('/');
        foreach ($permissions as $permission) {
            $url_permission = $base_url . $permission['link'];
            //echo \URL::route('api.products.index',['*']);
            if (Str::is($url_permission, $link) && $permission['method'] == $method) {
                return $permission['name'];
            }
        }
        return null;
    }


    //Add except login
    public static function check_except($full_url)
    {
        $except = [
            '/api/login',
            '/api/get-data-stream/*',
            '/api/set-data-stream/*'
        ];

        foreach ($except as $item) {
            $item = url('/') . $item;
            if (Str::is($item, $full_url)) {
                return true;
            }
        }
        return false;
    }
}
