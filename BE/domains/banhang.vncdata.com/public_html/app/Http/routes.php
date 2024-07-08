<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\CusstomPHP\Logs;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Response;
use App\CusstomPHP\Time;
use App\Http\Controllers\UserController;
use Carbon\Carbon;
use Illuminate\Http\Request;

Route::any('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    } else {
        return redirect()->route('main');
    }
});

Route::any('login', 'LoginController@login')->name('login');
Route::any('logout', function () {
    Auth::logout();
    return redirect(\App\CusstomPHP\CustomURL::route('login'));
})->name('logout');


Route::any('view', function (\Illuminate\Http\Request $request) {
    try {
        $view_data = view('page.subviews.' . $request->get('viewname'))->render();
        $view_data = base64_encode($view_data);
        return Response::json_return($view_data, true);
    } catch (Exception $ex) {
        return Response::json_return($ex->getMessage(), false);
    }
})->name('view');

Route::any('main', function (Request $request) {
    if ($request->exists('access_token')) {
        $access_token = $request->get('access_token');
        if (DB::table(Tables::$tb_User)->where('access_token', 'LIKE', $access_token)->exists()) {
            return view('page.main');
        }
    }
    return redirect()->route('login');
})->name('main');


Route::any('main-mobile', function () {
    return view('page.mobile.main');
})->name('main-mobile');
Route::any('mobile_cache.appcache', function () {
    $data = view('page.mobile.main.cache')->render();
    return \response($data, 200, [
        'Content-Type' => 'text/cache-manifest'
    ]);
})->name('mobile-cache');


// Route::get('report_sale' , 'Api\Report\ReportController@get_sale_log');
// Route::get('report_salereturn' , 'Api\Report\ReportController@get_salereturn_log');
Route::get('report_getproductsale' , 'Api\Report\ReportController@get_product_sale');
Route::get('report_receipt' , 'Api\Report\ReportController@get_report_receipt');
Route::get('report_sale' , 'Api\Report\ReportController@get_report_sale');
Route::get('report_move' , 'Api\Report\ReportController@get_report_move');
Route::get('report_receiptreturn' , 'Api\Report\ReportController@get_report_receiptreturn');
Route::get('report_productreturn' , 'Api\Report\ReportController@get_report_productreturn');
Route::get('report_total' , 'Api\Report\ReportController@get_report_total');

Route::group(['prefix' => 'api', 'middleware' => ['access_token', 'cors']], function () {
    Route::get('product-list/search', 'Api\ProductList\ProductListController@search');
    Route::get('customers/search', 'Api\Customer\CustomerController@search');
    Route::get('suppliers/search', 'Api\Supplier\SupplierController@search');
    Route::get('product-import-self-produced/search', 'Api\ProductImport\ImportSelfProducedController@search');
    Route::get('sale/search', 'Api\Sale\SaleController@search');
    Route::get('product-return-import/search', 'Api\ProductImport\ReturnController@search');
    Route::get('customers/show_by_code/{code}', 'Api\Customer\CustomerController@show_by_code');
    Route::get('product-move/search', 'Api\ProductMove\MoveController@search');
    Route::get('branches/search', 'Api\Branch\BranchController@search');
    Route::get('users/search', 'Api\User\UserController@search');

    Route::resource('product-logs', 'Api\Product\ProductController');
    Route::resource('product-cat', 'Api\ProductCat\ProductCatController');
    Route::resource('product-list', 'Api\ProductList\ProductListController');
    Route::resource('product-import', 'Api\ProductImport\ImportController');
    Route::resource('product-return-import', 'Api\ProductImport\ReturnController');
    Route::resource('product-import-self-produced', 'Api\ProductImport\ImportSelfProducedController');
    Route::resource('product-move', 'Api\ProductMove\MoveController');
    Route::resource('product-return', 'Api\ProductReturn\ProductReturnController');
    Route::resource('product-data', 'Api\ProductData\ProductDataController');
    
    

    

    Route::resource('invoices', 'Api\Invoice\InvoiceController');
    Route::resource('finance', 'Api\Finance\FinanceController');
    Route::resource('user-roles', 'Api\UserRole\UserRoleController');

    Route::resource('branches', 'Api\Branch\BranchController');
    // Route::get('branches/{id}', 'Api\Branch\BranchController@show');
    Route::resource('suppliers', 'Api\Supplier\SupplierController');
    Route::resource('supplier-import', 'Api\Supplier\ImportController');
    Route::resource('supplier-return', 'Api\Supplier\ReturnController');
    Route::resource('customers', 'Api\Customer\CustomerController');
    Route::resource('customer-cat', 'Api\Customer\CustomerCatController');
    Route::resource('sale', 'Api\Sale\SaleController');

    Route::resource('settings', 'Api\Setting\SettingController');
    Route::get('setting/{name}/{branch}', 'Api\Setting\SettingController@getSetting');

    Route::resource('finance-cat', 'Api\FinanceCat\FinanceCatController');

    Route::get('get-products-by-package', 'Api\Product\ProductController@indexByPackage')->name('api.get-products-by-package.index');
    Route::get('select', 'Api\SQL\SqlController@getSelect')->name('api.select.index');
    Route::put('update-product-invoice', 'Api\Delivery\DeliveryController@updateProductInvoice')->name('api.update-product-invoice.index');

    Route::get('users-information', 'Api\User\UserController@information_users')->name('api.users-information.index');
    Route::get('users-levels', 'Api\User\UserController@index_level_users')->name('api.users-levels.index');
    Route::resource('login', 'Api\Login\LoginController');
    Route::resource('users', 'Api\User\UserController');

    Route::get('check', function () {
        return Response::json_return(null, true);
    })->name('api.check.index');

    //Sent data
    Route::get('/get-data-stream/{name}', function ($name) {
        $value = Cache::get($name);
        Cache::forget($name);
        return \response("data: {$value}\n\n", 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache'
        ]);
    })->name('api.stream-get.index');
    Route::post('/set-data-stream/{name}', function (Request $request, $name) {
        $value = $request->get('code');
        Cache::put($name, '', 0);
        Cache::put($name, $value, 20);
        return Response::json_return('', true);
    })->name('api.stream-set.index');

    Route::get('/permissions', function () {
        $data = UserController::$permission;
        $quyen = array();
        foreach ($data as $item) {
            array_push($quyen, [
                'code' => $item['name'],
                'name' => $item['title'],
                'des' => $item['des'],
            ]);
        }
        return Response::json_return($quyen, true);
    })->name('api.permissions.index');

    
    
});

//upload image
Route::post('image-upload', 'Api\Image\ImageController@store')->name('upload-image');
Route::get('image-upload', 'Api\Image\ImageController@get')->name('upload-image');



Route::any('test', function () {
    $data = File::allFiles('D:\Xampp\htdocs\phanmembanhang\storage\framework\views');
    // $data = File::allFiles('/home/app.hdnet.top/public_html/storage/framework/views');
    foreach ($data as $file) {
        //echo File::name($file);
        File::delete($file);
    }
    return json_encode($data);
});
