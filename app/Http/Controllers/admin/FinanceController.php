<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Order;
use App\OrderDetail;
use App\Profit;
use App\Purse;
use Validator;

class FinanceController extends Controller
{
    public function index()
    {
        try {
            $orders = Order::with('address')->where('status','>', '0')->orderBy('created_at', 'DESC')->get();
            $orderswithprice = array();
            foreach($orders as $order)
            {
                $orderprice = OrderDetail::where('order_id', $order->id)->sum('cal_price');
                $saller = User::where('id', $order->order_from)->first();
                $totalprice = $order->freight + $orderprice;
                $arrayName = array(
                    'order' => $order,
                    'price' => $totalprice,
                    'order_from' => $saller,
                );
                array_push($orderswithprice, $arrayName);
            }
            return view('finance',compact('orderswithprice'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function status(Request $request)
    {
        try {
            return DB::transaction(function() use($request){
                $order = Order::where('id', $request->id)->first();
                $orderproducts = OrderDetail::with('adminproduct')->where('order_id', $order->id)->get();
                if($order->status == 1)
                {
                    $order->status = '2';
                    $order->save();
                    foreach($orderproducts as $product)
                    {
                        $profit = new Profit;
                        $profit->order_id = $order->id;
                        $profit->product_name = $product->product->name;
                        $profit->qty = $product->qty;
                        $profit->profit = $product->price - $product->product->wholesales->wholesale*$product->qty;
                        $profit->save();

                        $purse = Purse::where('user_id',$order->user_id)->first();
                        $purse->point = $purse->point + $product->point;
                        $purse->save();
                    }
                    return 1;
                } else {
                    return 0;
                }
            });
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function list()
    {
        $orders = Order::with('address')->where('status','>', '0')->orderBy('created_at', 'DESC')->get();
        $orderswithprice = array();
            foreach($orders as $order)
            {
                $orderprice = OrderDetail::where('order_id', $order->id)->sum('cal_price');
                $saller = User::where('id', $order->order_from)->first();
                $totalprice = $order->freight + $orderprice;
                $arrayName = array(
                    'order' => $order,
                    'price' => $totalprice,
                    'order_from' => $saller,
                );
                array_push($orderswithprice, $arrayName);
            }
        return view('theme.financetable',compact('orderswithprice'));
    }
}
