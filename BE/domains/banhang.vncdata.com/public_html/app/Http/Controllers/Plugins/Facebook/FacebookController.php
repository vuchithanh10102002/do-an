<?php
/**
 * Created by PhpStorm.
 * User: Hoang Dai
 * Date: 15/10/2017
 * Time: 14:08
 */

namespace App\Http\Controllers\Plugins\Facebook;

use App\CusstomPHP\Response;
use App\CusstomPHP\SentHTTP;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FacebookController extends Controller{
    public static $BLOCK_ACTIVE_SUCCESS='Active_Success';
    public static  $BLOCK_ACTIVE_ERROR='Active_Error';
    public static  $BLOCK_ACTIVE_REQUEST='Active_account';
    public static  $BLOCK_MENU='Appmenu';

    public static $URL_SENT='https://api.chatfuel.com/bots/<BOT_ID>/users/<USER_ID>/send?chatfuel_token=<TOKEN>&chatfuel_block_name=<BLOCK_NAME>&<VALUE>';
    public static  $BOT_ID='';
    public static  $CHATFUEL_TOKEN='';
    public static  $BLOCK_SENT_TEXT='Message_text';
    public static  $BLOCK_SENT_TEXT_USER_ATTRIBUTE='message';

    //active account
    public function active(Request $request){
        $code=$request->code;
        $messenger_user_id=$request->messenger_user_id;

        \DB::beginTransaction();
        try{
            //id_facebook
            //$code is code customer
            //check code is customer_code or invoice code
            $code_customer='';
            $container='';
            if(str_contains($code,'HD/')){
                //is invoice
                $data=\DB::table(Tables::$tb_invoices)
                    ->where('code','LIKE',$code)
                    ->first(['customer']);
                $code_customer=$data->customer;
            }else{
                //is code customer
                $code_customer=$code;
            }
            //update id
            $number_row=\DB::table(Tables::$tb_customer)
                ->where('code','LIKE',$code_customer)->update([
                'id_facebook'=>$messenger_user_id
            ]);

            if($number_row==1){
                \DB::commit();
                $container=[
                    'redirect_to_blocks'=>[FacebookController::$BLOCK_ACTIVE_SUCCESS]
                ];
            }else{
                \DB::rollBack();
                $container=[
                    'redirect_to_blocks'=>[FacebookController::$BLOCK_ACTIVE_ERROR]
                ];
            }

        }catch (\Exception $ex){
            \DB::rollBack();
            $container=[
                'redirect_to_blocks'=>[FacebookController::$BLOCK_ACTIVE_ERROR]
            ];
        }
        return json_encode($container);
    }

    //Check active account
    public function active_check(Request $request){
        $container='';
        $messenger_user_id=$request->messenger_user_id;
        if(!\DB::table(Tables::$tb_customer)->where('id_facebook','LIKE',$messenger_user_id)->exists()){
            $container=[
                'redirect_to_blocks'=>[FacebookController::$BLOCK_ACTIVE_REQUEST]
            ];
        }else{
            $container=[
                'redirect_to_blocks'=>[FacebookController::$BLOCK_MENU]
            ];
        }
        return json_encode($container);
    }



    //sent_message
    public function sent_message(Request $request){
        try{
            $message=$request->message;
            $messenger_user_id=$request->messenger_user_id;
            $url=FacebookController::$URL_SENT;
            $url=str_replace('<BLOCK_NAME>',FacebookController::$BLOCK_SENT_TEXT,$url);
            $url=str_replace('<BOT_ID>',FacebookController::$BOT_ID,$url);
            $url=str_replace('<TOKEN>',FacebookController::$CHATFUEL_TOKEN,$url);
            $url=str_replace('<USER_ID>',$messenger_user_id,$url);
            $datax=[
                FacebookController::$BLOCK_SENT_TEXT_USER_ATTRIBUTE=>$message
            ];
            $url=str_replace('<VALUE>',http_build_query($datax),$url);
            $data=SentHTTP::SentPOST($url);
            $data=json_decode($data);
            if($data->success){
                return Response::json_return(null,true);
            }else{
                return Response::json_return(null,false);
            }
        }catch (\Exception $ex){
            return Response::json_return(null,false);
        }
    }
}