<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Conversation;
use App\Order;
use App\OrderDetail;
use App\Purse;
use App\Cart;
use Exception;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            return DB::transaction(function() use($request){
                $order = new Order;
                $order->order_number = date('Y.m.d h:i');
                $order->user_id = $request->user->id;
                $order->address_id = $request->address_id;
                $order->payment_id = $request->payment_id;
                $order->freight = $request->freight;
                $order->delivery_method = $request->delivery_method;
                $order->delivery_type = $request->delivery_type;
                $order->point = $request->point;
                $order->save();

                $products = $request->products;
                foreach($products as $product)
                {
                    $orderdetail = new OrderDetail;
                    $orderdetail->user_id = $request->user->id;
                    $orderdetail->order_id = $order->id;
                    $orderdetail->product_id = $product['id'];
                    $orderdetail->qty = $product['qty'];
                    $orderdetail->price = $product['price'];
                    $orderdetail->tax = $product['tax'];
                    $orderdetail->unit_id = $product['unit_id'];
                    $orderdetail->point = $product['point'];
                    $orderdetail->cal_price = $product['price']+$product['price']*$product['tax'];
                    $orderdetail->save();
                }

                $purse = Purse::where('user_id', $request->user->id)->first();
                $purse->point = $purse->point - $request->point;
                if ($purse->point-$request->point >= 0) {
                    $purse->save();
                } else {
                    return response()->json(['message'=>'Please want of your point'],400);
                }

                Cart::where('user_id', $request->user->id)->update(['status'=>'1']);
                Conversation::where('unique', $request->unique)->update(['status'=>'2']);
                return response()->json(['message'=>'Order Successful'],200);
            });
        } catch (Exception $err) {
            return response()->json($err, 500);
        }

    }

    public function list(Request $request)
    {
        try {
            $orders = Order::select('id', 'order_number', 'status', 'freight')
                            ->where('user_id', $request->user->id)
                            ->get();
            $orderswithprice = array();
            foreach($orders as $order)
            {
                $orderprice = OrderDetail::where('order_id', $order->id)->sum('cal_price');
                $totalprice = $order->freight + $orderprice;
                $arrayName = array(
                    'order' => $order,
                    'price' => $totalprice,
                );
                array_push($orderswithprice, $arrayName);
            }

            return response()->json(['message'=>'Order List Successful', 'data'=>$orderswithprice],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $order = Order::where('id', $id)->first();
            $orderprice = OrderDetail::where('order_id', $id)->sum('cal_price');
            $getpoint = OrderDetail::where('order_id', $id)->sum('point');
            $totalpoint = Purse::where('user_id', $request->user->id)->first();

            $arrayName = array(
                'orderprice'=>$orderprice,
                'freight'=>$order->freight,
                'totalpoint'=>$totalpoint->point,
                'orderpoint'=>$order->point,
                'getpoint'=>$getpoint*1,
            );

            return response()->json(['message'=>'Order Successful',
                                     'data'=>$arrayName,],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function detail(Request $request, $id)
    {
        try {
            $orderdetail = OrderDetail::where('order_id', $id)
            ->with('product')
            ->get();

            return response()->json(['message'=>'Order Successful', 'data'=>$orderdetail],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function adminlist(Request $request)
    {
        try {
            $orders = Order::where('user_id', $request->user->id)
                            ->get();
            $orderswithprice = array();
            foreach($orders as $order)
            {
                $orderprice = OrderDetail::where('order_id', $order->id)->sum('cal_price');
                $totalprice = $order->freight + $orderprice;
                $arrayName = array(
                    'order' => $order,
                    'price' => $totalprice,
                );
                array_push($orderswithprice, $arrayName);
            }

            return response()->json(['message'=>'Order List Successful', 'data'=>$orderswithprice],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function adminshow(Request $request, $id)
    {
        try {
            $order = Order::where('id', $id)->with('address', 'payment')->first();
            $products = OrderDetail::where('order_id', $id)->with('product')->get();
            $users = User::where('type', '2')->get();

            $arrayName = array(
                'order'=>$order,
                'products'=>$products,
                'users'=>$users
            );

            return response()->json(['message'=>'Order Successful',
                                     'data'=>$arrayName,],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function adminupdate(Request $request, $id)
    {
        try {
            if ($request->freight&&$request->order_from) {
                $result = Order::where('id', $id)->whereBetween('status', [0, 1])
                        ->update(['freight'=>$request->freight, 'order_from'=>$request->order_from, 'status'=>'1']);
            }

            if ($result) {
                return response()->json(['message'=>'Order Update Successful'],200);
            } else {
                return response()->json(['message'=>'Order Update False'],400);

            }
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function reorder(Request $request, $id)
    {
        try {
            return DB::transaction(function() use($id){
                $old_order = Order::find($id);
                $order = new Order;
                $order->order_number = date('Y.m.d h:i');
                $order->user_id = $old_order->user_id;
                $order->address_id = $old_order->address_id;
                $order->payment_id = $old_order->payment_id;
                $order->freight = $old_order->freight;
                $order->delivery_method = $old_order->delivery_method;
                $order->delivery_type = $old_order->delivery_type;
                $order->point = $old_order->point;
                $order->save();

                $order_details = OrderDetail::where('order_id',$id)->get();
                foreach($order_details as $order_detail)
                {
                    $orderdetail = new OrderDetail;
                    $orderdetail->user_id = $old_order->user_id;
                    $orderdetail->order_id = $order->id;
                    $orderdetail->product_id = $order_detail->product_id;
                    $orderdetail->qty = $order_detail->qty;
                    $orderdetail->price = $order_detail->price;
                    $orderdetail->tax = $order_detail->tax;
                    $orderdetail->unit_id = $order_detail->unit_id;
                    $orderdetail->point = $order_detail->point;
                    $orderdetail->cal_price = $order_detail->cal_price;
                    $orderdetail->save();
                    // print_r($orderdetail);exit;
                }

                $purse = Purse::where('user_id', $old_order->user_id)->first();
                $purse->point = $purse->point - $old_order->point;
                if ($purse->point - $old_order->point >= 0) {
                    $purse->save();
                } else {
                    return response()->json(['message'=>'Please want of your point'],400);
                }

                Cart::where('user_id', $old_order->user_id)->update(['status'=>'1']);
                return response()->json(['message'=>'Order Successful'],200);
            });
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }
}
