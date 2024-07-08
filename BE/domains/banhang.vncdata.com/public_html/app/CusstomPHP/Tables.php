<?php
namespace App\CusstomPHP;

use DB;

class Tables{
    public static $tb_User='users';
    public static $tb_customer='customer';
    public static $tb_customer_cat='customer_cat';
    public static $tb_branch='branch';
    public static $tb_supplier='supplier';
    public static $tb_supplier_return='supplier_return';
    public static $tb_supplier_import='supplier_import';
    public static $tb_invoices='invoices';
    public static $tb_product_logs='product_logs';
    public static $tb_product_data='product_data';
    public static $tb_products='products';
    public static $tb_products_list='products_list';
    public static $tb_products_package='products_package';
    public static $tb_product_cat='product_cat';
    public static $tb_setting='settings';
    public static $tb_finance_cat='finance_cat';
    public static $tb_user_roles='user_roles';

    public static $tb_logs='logs';

    public static function getValue($column,$table)
    {
        $data=DB::table($table)->first([$column]);
        return $data->$column;
    }

    public static function getColumns($table_name)
    {
        $columns = DB::select('show columns from ' . $table_name);
        $columns_names=[];
        foreach ($columns as $value) {
            array_push($columns_names,$value->Field);
        }
        return $columns_names;
    }

    public static function getDataJquery($table_name)
    {
        $js_data="";
        foreach(Tables::getColumns($table_name) as $item){
            $js_data=$js_data.$item.':'."$('#".$item."').val(), ";
        }
        return $js_data." _token:'".csrf_token()."'";
    }
    public static function setDataJquery($table_name)
    {
        $js_data="";
        foreach(Tables::getColumns($table_name) as $item){
            $js_data=$js_data."$('#".$item."').val(result['".$item."']);";
        }
        return $js_data;
    }
}