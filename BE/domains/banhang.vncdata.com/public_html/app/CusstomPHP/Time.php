<?php
/**
 * Created by PhpStorm.
 * User: Hoang Dai
 * Date: 21/03/2017
 * Time: 15:11
 */
namespace App\CusstomPHP;

use Carbon\Carbon;

class Time{
    //Default timestamp
    public static $timestamp = 'Asia/Ho_Chi_Minh';
    public static $format_time_full='H:i:s';
    public static $format_time='H:i';
    public static $format_date='d/m/Y';
    public static $format_date_CODE='ymd';
    public static $format_date_time='H:i d/m/Y';
    public static $format_date_time_full='H:i:s d/m/Y';

    public static function now()
    {
        return Carbon::now(Time::$timestamp)->format(Time::$format_date_time);
    }

    public static function tomorrow()
    {
        return Time::time_now().' '.Carbon::tomorrow(Time::$timestamp)->format(Time::$format_date);
    }

    public static function time_now()
    {
        return Carbon::now(Time::$timestamp)->format(Time::$format_time_full);
    }

    public static function hom30day()
    {
        $now=Carbon::now(Time::$timestamp);
        $next=$now->addMonth();
        $next=$next->addMonth();
        return Time::Timenow().' '.$next->format("d/m/Y");
    }

    public static function homsau24h()
    {
        return Time::Timenow().' '.Carbon::tomorrow(Time::$timestamp)->format("d/m/Y");
    }
    public static function Datenow()
    {
        return Carbon::now(Time::$timestamp)->format("d/m/Y");
    }
	public static function DatenowCODE()
	{
		return Carbon::now(Time::$timestamp)->format(Time::$format_date_CODE);
	}
    public static function DatenowFILE()
    {
        return Carbon::now(Time::$timestamp)->format("d_m_Y_H_i");
    }
    public static function Timenow()
    {
        return Carbon::now(Time::$timestamp)->format("H:i");
    }
}