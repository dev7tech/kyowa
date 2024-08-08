<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\deliveryMethod;
use Validator;

class DeliveryMethodController extends Controller
{
    public function index(){
        try {
            $delivery_methods = deliveryMethod::orderBy('created_at', 'ASC')->get();
            return view('delivery',compact('delivery_methods'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function list(){
        try {
            $delivery_methods = deliveryMethod::orderBy('created_at', 'ASC')->get();
            return view('theme.deliverytable',compact('delivery_methods'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function show(Request $request){
        try {
            $method = deliveryMethod::where('id',$request->id)->first();
            return response()->json($method, 200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
        
    }

    public function delete(Request $request){
        try {
            $method = deliveryMethod::where('id',$request->id)->delete();
            return response()->json($method, 200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function store(Request $request){
        try {
            $validation = Validator::make($request->all(),[
                'method_name' => 'required',
                'min_price' => 'required',
                'max_price' => 'required',
                'delivory_fee' => 'required',
            ]);
            if(isset($request->id)) $method = deliveryMethod::where('id', $request->id)->first();
            else $method = new deliveryMethod();

            $method->method_name = $request->method_name;
            $method->min_price = $request->min_price;
            $method->max_price = $request->max_price;
            $method->delivery_fee = $request->delivery_fee;
            $method->save();

            $error_array = array();
            $success_output = '保存成功。';

            $output = array(
                'error'     =>  $error_array,
                'success'   =>  $success_output
            );
            return response()->json($output, 200);

        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }
}
