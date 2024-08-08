<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Order;
use App\OrderDetail;
use App\Profit;
use Validator;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        try {
            $orders = Order::orderBy('created_at', 'DESC')->get();
            $totalcount = Order::count();
            $canceledcount = Order::where('status', '2')->count();
            $profits = Profit::sum('profit');
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
            return view('report',compact('orderswithprice', 'totalcount', 'canceledcount', 'profits'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function show(Request $request)
    {
        try {
            $orders = Order::whereBetween('created_at', [new Carbon($request->startdate), new Carbon($request->enddate)])
            ->orderBy('created_at', 'DESC')->get();
            $totalcount = $orders->count();
            $canceledcount = $orders->where('status', '2')->count();
            $orderswithprice = array();
            $orderId = array();
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
                    array_push($orderId, $order->id);
                }
            $profits = Profit::whereIn('order_id', $orderId)->sum('profit');

            return view('theme.reporttable',compact('orderswithprice', 'totalcount', 'canceledcount', 'profits'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function year(){
        try {
            $orders = Order::orderBy('created_at', 'DESC')->where(DB::raw('year(created_at)'),date('Y'))->get();
            $totalcount = Order::where(DB::raw('year(created_at)'),date('Y'))->count();
            $profits = Profit::where(DB::raw('year(created_at)'),date('Y'))->sum('profit');
            $canceledcount = Order::where('status', '2')->where(DB::raw('year(created_at)'),date('Y'))->count();
            $orderswithprice = array();
                foreach($orders as $order)
                {
                    $orderprice = OrderDetail::where('order_id', $order->id)->where(DB::raw('year(created_at)'),date('Y'))->sum('cal_price');
                    $saller = User::where('id', $order->order_from)->first();
                    $totalprice = $order->freight + $orderprice;
                    $arrayName = array(
                        'order' => $order,
                        'price' => $totalprice,
                        'order_from' => $saller,
                    );
                    array_push($orderswithprice, $arrayName);
                }
            return view('reportYear',compact('orderswithprice', 'totalcount', 'canceledcount', 'profits'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function showYear(Request $request){
        try {
            $orders = Order::where(DB::raw('year(created_at)'),$request->year)->orderBy('created_at', 'DESC')->get();
            $totalcount = Order::where(DB::raw('year(created_at)'),$request->year)->count();
            $canceledcount = $orders->where(DB::raw('year(created_at)'),$request->year)->where('status', '2')->count();
            $orderswithprice = array();
            $orderId = array();
                foreach($orders as $order)
                {
                    $orderprice = OrderDetail::where('order_id', $order->id)->where(DB::raw('year(created_at)'),$request->year)->sum('cal_price');
                    $saller = User::where('id', $order->order_from)->first();
                    $totalprice = $order->freight + $orderprice;
                    $arrayName = array(
                        'order' => $order,
                        'price' => $totalprice,
                        'order_from' => $saller,
                    );
                    array_push($orderswithprice, $arrayName);
                    array_push($orderId, $order->id);
                }
            $profits = Profit::whereIn('order_id', $orderId)->sum('profit');

            return view('theme.reporttable',compact('orderswithprice', 'totalcount', 'canceledcount', 'profits'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function month(){
        try {
            $orders = Order::orderBy('created_at', 'DESC')->where(DB::raw('year(created_at)'),date('Y'))->where(DB::raw('month(created_at)'),date('m'))->get();
            $totalcount = Order::where(DB::raw('year(created_at)'),date('Y'))->where(DB::raw('month(created_at)'),date('m'))->count();
            $profits = Profit::where(DB::raw('year(created_at)'),date('Y'))->where(DB::raw('month(created_at)'),date('m'))->sum('profit');
            $canceledcount = Order::where('status', '2')->where(DB::raw('year(created_at)'),date('Y'))->where(DB::raw('month(created_at)'),date('m'))->count();
            $orderswithprice = array();
            foreach($orders as $order){
                $orderprice = OrderDetail::where('order_id', $order->id)->where(DB::raw('year(created_at)'),date('Y'))->where(DB::raw('month(created_at)'),date('m'))->sum('cal_price');
                $saller = User::where('id', $order->order_from)->first();
                $totalprice = $order->freight + $orderprice;
                $arrayName = array(
                    'order' => $order,
                    'price' => $totalprice,
                    'order_from' => $saller,
                );
                array_push($orderswithprice, $arrayName);
            }
            return view('reportMonth',compact('orderswithprice', 'totalcount', 'canceledcount', 'profits'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function showMonth(Request $request){
        try {
            $orders = Order::orderBy('created_at', 'DESC')->where(DB::raw('year(created_at)'),$request->year)->where(DB::raw('month(created_at)'),$request->month)->get();
            $totalcount = Order::where(DB::raw('year(created_at)'),$request->year)->where(DB::raw('month(created_at)'),$request->month)->count();
            $canceledcount = Order::where('status', '2')->where(DB::raw('year(created_at)'),$request->year)->where(DB::raw('month(created_at)'),$request->month)->count();
            $orderswithprice = array();
            $orderId = array();
            if(sizeof($orders) > 0){
                foreach($orders as $order){
                    $orderprice = OrderDetail::where('order_id', $order->id)->where(DB::raw('year(created_at)'),$request->year)->where(DB::raw('month(created_at)'),$request->month)->sum('cal_price');
                    $saller = User::where('id', $order->order_from)->first();
                    $totalprice = $order->freight + $orderprice;
                    $arrayName = array(
                        'order' => $order,
                        'price' => $totalprice,
                        'order_from' => $saller,
                    );
                    array_push($orderswithprice, $arrayName);
                    array_push($orderId, $order->id);
                }
            }
            $profits = Profit::whereIn('order_id', $orderId)->sum('profit');
            return view('theme.reporttable',compact('orderswithprice', 'totalcount', 'canceledcount', 'profits'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function day(){
        try {
            $orders = Order::orderBy('created_at', 'DESC')->where('created_at',date('Y-m-d'))->get();
            $totalcount = Order::where('created_at',date('Y-m-d'))->count();
            $canceledcount = Order::where('status', '2')->where('created_at',date('Y-m-d'))->count();
            $profits = Profit::where('created_at',date('Y-m-d'))->sum('profit');
            $orderswithprice = array();
            foreach($orders as $order)
            {
                $orderprice = OrderDetail::where('order_id', $order->id)->where('created_at',date('Y-m-d'))->sum('cal_price');
                $saller = User::where('id', $order->order_from)->first();
                $totalprice = $order->freight + $orderprice;
                $arrayName = array(
                    'order' => $order,
                    'price' => $totalprice,
                    'order_from' => $saller,
                );
                array_push($orderswithprice, $arrayName);
            }
            return view('reportDay',compact('orderswithprice', 'totalcount', 'canceledcount', 'profits'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function showDay(Request $request){
        try {
            $orders = Order::orderBy('created_at', 'DESC')->where('created_at',$request->day)->get();
            $totalcount = Order::where('created_at',$request->day)->count();
            $canceledcount = Order::where('status', '2')->where('created_at',$request->day)->count();
            $orderswithprice = array();
            $orderId = array();
            foreach($orders as $order)
            {
                $orderprice = OrderDetail::where('order_id', $order->id)->where('created_at',$request->day)->sum('cal_price');
                $saller = User::where('id', $order->order_from)->first();
                $totalprice = $order->freight + $orderprice;
                $arrayName = array(
                    'order' => $order,
                    'price' => $totalprice,
                    'order_from' => $saller,
                );
                array_push($orderswithprice, $arrayName);
                array_push($orderId, $order->id);
            }
            $profits = Profit::whereIn('order_id', $orderId)->sum('profit');
            return view('theme.reporttable',compact('orderswithprice', 'totalcount', 'canceledcount', 'profits'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }
}
