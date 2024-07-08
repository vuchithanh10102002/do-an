<?php
/**
 * Created by PhpStorm.
 * User: Hoang Dai
 * Date: 19/03/2017
 * Time: 16:38
 */
namespace App\CusstomPHP;

class CustomURL{
    public static $SSL=false;

    public static function route($routername)
    {
        if(!CustomURL::$SSL){
            return \URL::route($routername);
        }else{
            return str_replace('http://','https://',\URL::route($routername));
        }
    }

    public static function routeApi($nameAPI)
    {
        if(!CustomURL::$SSL){
            return \URL::route('api.'.$nameAPI.'.index');
        }else{
            return str_replace('http://','https://',\URL::route('api.'.$nameAPI.'.index'));
        }
    }
    public static function routeApiParameters($nameAPI,$parameters)
    {
        if(!CustomURL::$SSL){
            return \URL::route('api.'.$nameAPI.'.index',$parameters);
        }else{
            return str_replace('http://','https://',\URL::route('api.'.$nameAPI.'.index',$parameters));
        }
    }

}