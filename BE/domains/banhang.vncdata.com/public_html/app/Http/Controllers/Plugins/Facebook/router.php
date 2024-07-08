<?php
/**
 * Created by PhpStorm.
 * User: Hoang Dai
 * Date: 15/10/2017
 * Time: 14:20
 */

use App\CusstomPHP\Logs;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Response;
use App\CusstomPHP\Time;
use App\Http\Controllers\UserController;
use Carbon\Carbon;
use Illuminate\Http\Request;

//add from \app\Providers\RouteServiceProvider.php mapFacebookPluginRoutes

const Facebook_slug="Plugins\Facebook\\";
Route::post('facebook/active', Facebook_slug.'FacebookController@active');
Route::post('facebook/active_check', Facebook_slug.'FacebookController@active_check');
Route::any('facebook/sent_message', Facebook_slug.'FacebookController@sent_message')->name('sent_message');
