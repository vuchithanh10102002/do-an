<?php

namespace App\Http\Controllers\Api\Sale;

use App\CusstomPHP\Response;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Routing\Controller;

class SaleController extends Controller {
	public function store( Request $request ) {
		\DB::beginTransaction();
		//Thêm hóa đơn mới
		try {
			//Lấy tất cả các trường của hóa đơn
			$fields = Tables::getColumns( Tables::$tb_invoices );
			$data   = array();
			foreach ( $fields as $item ) {
				if ( $request->exists( $item ) ) {
					$data[ $item ] = $request->get( $item );
				}
			}

			//Cập nhật thời gian
			$data['create_at'] = time();
			$data['update_at'] = time();

			//Tạo mã hóa đơn
			$today_max = \DB::table( Tables::$tb_invoices )->where( 'create_at', 'LIKE', '%' . Time::Datenow() )->count();
			$code      = $data['code'] . Time::DatenowCODE() . $today_max;
			$data['code'] = $code;

			//Thêm hóa đơn vào bảng hóa đơn
			$id_invoice = \DB::table( Tables::$tb_invoices )->insertGetId( $data );
			$invoice    = \DB::table( Tables::$tb_invoices )->where( 'id', '=', $id_invoice )->first();


			if ( SaleController::updateProduct( $invoice ) ) {
				//Add point customer
				// SaleController::checkPoint( $invoice );

				\DB::commit();

				//Trả về thông tin hóa đơn
				return Response::json_return( $invoice, true );
			} else {
				return Response::json_return( null, false );
			}
		} catch ( \Exception $ex ) {
			\DB::rollBack();

			return Response::json_return( $ex->getMessage(), false );
		}
	}

	public static function updateProduct( $invoice ) {
		\DB::beginTransaction();
		try {
			//Lưu thông tin hàng mua
			$products_pay = json_decode( $invoice->products );
			foreach ( $products_pay as $item ) {
				$sanpham_goc = \DB::table( Tables::$tb_products_list )->where( [
					[ 'code', 'LIKE', $item->code ],
					[ 'branch', 'LIKE', $invoice->branch ]
				] )->first();

				//Cập nhật bản ghi logs
				\DB::table( Tables::$tb_product_logs )->insert( [
					'invoice'       => $invoice->code,
					'product_list'  => $item->code,
					'type'          => $invoice->type,
					'branch'        => $invoice->branch,
					'customer'      => $invoice->customer,
					'customer_name' => $invoice->customer_name,
					'number'        => - ( $item->number ),
					'price'         => $item->price,
					'price_import'  => intval( $sanpham_goc->price_import ) * intval( $item->number ),
					'finance_cat'   => $invoice->finance_cat,
					'create_at'     => time(),
				] );

				//Trừ số lượng trong product_list
				\DB::table( Tables::$tb_products_list )
				   ->where( 'id', '=', $sanpham_goc->id )
				   ->decrement( 'number', $item->number );
			}
			// tính tiền nợ cho khách
			$debt = intval( $invoice->total_price ) - intval( $invoice->discount ) + intval( $invoice->other_price ) - intval( $invoice->total_pay );
			\DB::table( Tables::$tb_customer )->where( 'code', 'LIKE', $invoice->customer )
			   ->increment( "debt", $debt );
			//Tính tiền mua hàng
			\DB::table( Tables::$tb_customer )->where( 'code', 'LIKE', $invoice->customer )
			   ->increment( "price", $invoice->total_price );
			//Lượt mua hàng
			\DB::table( Tables::$tb_customer )->where( 'code', 'LIKE', $invoice->customer )
			   ->increment( "hit", 1 );
			\DB::commit();

			return true;
		} catch ( \Exception $exception ) {
			\DB::rollBack();

			return false;
		}
	}

	//Check point to customer
	public static function checkPoint( $invoice ) {
		//get settting check point
		$setting = \DB::table( Tables::$tb_setting )->where( [
			'name'   => 'settings',
			'branch' => $invoice->branch
		] )->first( [ 'value' ] );
		$setting = json_decode( $setting->value );
		//Check auto check point
		if ( $setting->auto_check_point ) {
			//Calculate point
			$new_point = intval( $invoice->total_price / 100 * intval( $setting->percent_default ) / intval( $setting->point_to_price ) );
			//Check have customer?
			if ( $invoice->customer != '' ) {
				if ( \DB::table( Tables::$tb_customer )
				        ->where( 'code', 'LIKE', $invoice->customer )->exists() ) {
						\DB::table( Tables::$tb_customer )
					   ->where( 'code', 'LIKE', $invoice->customer )->increment( 'point', $new_point );
				}
			}
		}
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$branch = $request->get('branch');

		if($branch != "" && $branch != null) {
			$sale_list = \DB::table(Tables::$tb_invoices)
			->join(Tables::$tb_customer, Tables::$tb_customer . '.code', '=', Tables::$tb_invoices . '.customer')
			->select(
				Tables::$tb_customer . '.phone',
				Tables::$tb_customer . '.address',
				Tables::$tb_customer . '.email',
				Tables::$tb_invoices . '.*'
			)
			->where('type',  'INVOICE')
			->where('branch',  $branch)
			->orderBy('create_at', 'asc')->get();
		} else {
			$sale_list = \DB::table(Tables::$tb_invoices)
			->join(Tables::$tb_customer, Tables::$tb_customer . '.code', '=', Tables::$tb_invoices . '.customer')
			->select(
				Tables::$tb_customer . '.phone',
				Tables::$tb_customer . '.address',
				Tables::$tb_customer . '.email',
				Tables::$tb_invoices . '.*'
			)
			->where('type',  'INVOICE')
			->orderBy('create_at', 'asc')->get();
		}
        
        return Response::json_return($sale_list, true);
    }

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function show($id)
    {
        $invoice = \DB::table(Tables::$tb_invoices)->where('id', '=', $id)->orWhere('code', '=', $id)->first();
        return Response::json_return($invoice, true);
    }

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function update(Request $request, $id)
    {
        \DB::beginTransaction();
		try {
            $fields = Tables::getColumns(Tables::$tb_invoices);
            $data = array();
            foreach ($fields as $item) {
                if ($request->exists($item)) {
                    $data[$item] = $request->get($item);
                }
            }
            unset($data['id']);
            // $data['update_at'] = time();

            if (\DB::table(Tables::$tb_invoices)->where('id', '=', $id)->update($data)) {
                \DB::commit();
                $data = \DB::table(Tables::$tb_invoices)->where('id', '=', $id)->first();
                return Response::json_return($data, true);
            }
        } catch (\Exception $ex) {
        }
        \DB::rollBack();
        return Response::json_return(null, false);
    }

	/**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($ids)
    {
        if (strpos($ids, ',') !== false) {
            $idArray = explode(',', $ids);

            $deleted = \DB::table(Tables::$tb_invoices)->whereIn('id', $idArray)->delete();
        } else {
            $deleted = \DB::table(Tables::$tb_invoices)->where('id', '=', $ids)->delete();
        }

        if ($deleted) {
            return Response::json_return(null, true);
        } else {
            return Response::json_return(null, false);
        }
    }


	/**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        try {
            $s = $request->get('s');
			$state = $request->get('state');
			$date1 = $request->get('date1');
			$date2 = $request->get('date2');
			// dd($date1, $date2);

            $invoice = \DB::table(Tables::$tb_invoices)
			->join(Tables::$tb_customer, Tables::$tb_customer . '.code', '=', Tables::$tb_invoices . '.customer')
			->select(
				Tables::$tb_customer . '.phone',
				Tables::$tb_invoices . '.*'
			)
			->where([
				[Tables::$tb_invoices . '.customer_name', 'like', '%' . $s . '%'],
				[Tables::$tb_invoices . '.state', '=', $state],
				[Tables::$tb_invoices . '.type', '=', 'INVOICE'],
				[Tables::$tb_invoices . '.create_at', '>', $date1],
				[Tables::$tb_invoices . '.create_at', '<', $date2],
			])
			->orWhere(Tables::$tb_customer . '.phone', 'like', '%' . $s . '%')
			->OrderBy(Tables::$tb_invoices . '.create_at', 'asc')
			->get();

            return Response::json_return($invoice, true);
        } catch (\Exception $ex) {
            return Response::json_return($ex->getMessage(),false);
        }
    }

}