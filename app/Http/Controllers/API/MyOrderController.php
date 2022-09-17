<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Order;
use App\Enums\GeneralStatus;
use Illuminate\Database\QueryException;
use Exception;
use App\Http\Resources\MyOrderResource;
use App\Http\Resources\MyOrderDetailResource;

class MyOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $orders = Order::select('id', 'user_id', 'order_no', 'created_at', 'total', 'order_status_id', 'status')->where('user_id', optional(Auth::user())->id)->where('status', GeneralStatus::Enabled)->orderBy('id', 'DESC')->limit(10)->get();
        return MyOrderResource::collection($orders);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {            	            
            $order = Order::where('status', GeneralStatus::Enabled)->findOrFail($id);    
            return new MyOrderDetailResource($order);	

        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return response()->json(['message' => $message], 406);          

        } catch (Exception $e) {

            $message = 'Error in fetching size data.';
            return response()->json(['message' => $message], 406);

        }        
    }    
}