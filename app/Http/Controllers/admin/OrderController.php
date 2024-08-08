<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Order;
use App\OrderDetail;
use App\Address;
use Validator;
class OrderController extends Controller
{
    public function jingheobian()
    {
        try {
            $orders = Order::with('address')->where('delivery_type',1)->orderBy('status')->orderBy('created_at', 'DESC')->get();
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
            return view('order',compact('orderswithprice'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function yamato()
    {
        try {
            $orders = Order::with('address')->where('delivery_type',0)->orderBy('status', 'DESC')->orderBy('created_at', 'DESC')->get();
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
                
            return view('order',compact('orderswithprice'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function jingheobianlist()
    {
        try {
            $orders = Order::with('address')->where('delivery_type',1)->orderBy('status')->orderBy('created_at', 'DESC')->get();
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
            return view('theme.ordertable',compact('orderswithprice'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function history()
    {
        try {
            $orders = Order::with('address')->orderBy('created_at', 'DESC')->withTrashed()->get();
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
            return view('orderhistory', compact('orderswithprice'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function orderShow($id,Request $request){
        $sellers = User::where('type', 2)->get();
        $order_info = Order::with('address')->with('user')->with('orderDetail')->with('delivery')->where('id', $id)->first();
        $orderprice = OrderDetail::where('order_id', $id)->sum('cal_price');
        $price_total_8  = OrderDetail::where('order_id', $id)->where('tax','0.08')->sum('cal_price');
        $price_8  = OrderDetail::where('order_id', $id)->where('tax','0.08')->sum('price');
        $price_total_10 = OrderDetail::where('order_id', $id)->where('tax','0.1')->sum('cal_price');
        $price_10 = OrderDetail::where('order_id', $id)->where('tax','0.1')->sum('price');
        $order_detail_info = OrderDetail::where('order_id', $id)->get();
        $totalprice = $order_info->freight + $orderprice;
        return view('orderShow',compact('order_info','totalprice','order_detail_info','price_total_8','price_total_10','price_8','price_10','sellers'));
    }

    public function showUserAddress(Request $request){
        try {
            $address = Address::where('user_id',$request->user_id)->get();
            $user = User::where('id', $request->user_id)->first();
            $output = array(
                'address' =>$address,
                'user'=>$user
            );
            return response()->json($output,200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function confirm(Request $request){
        try {
            $order = Order::where('id',$request->order_id)->first();
            $order->status = 1;
            $order->order_from = $request->seller;
            $order->save();
                return 1;
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function finished(Request $request){
        try {
            $order = Order::where('id',$request->order_id)->first();
            $order->status = 2;
            $order->save();
                return 1;
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }
}
