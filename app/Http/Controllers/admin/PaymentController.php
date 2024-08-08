<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Payment;
use Validator;
class PaymentController extends Controller
{
    public function index()
    {
        try {
            $payments = Payment::all();
            return view('payment',compact('payments'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function list()
    {
        try {
            $payments = Payment::all();
            return view('theme.paymenttable',compact('payments'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(),[
                'name' => 'required',
            ]);
    
            $error_array = array();
            $success_output = '';
            
            if ($validation->fails())
            {
                foreach($validation->messages()->getMessages() as $field_name => $messages)
                {
                    $error_array[] = $messages;
                }
            } else {
                $payment = new Payment;
                $payment->name =$request->name;
                $payment->save();
                $success_output = 'Payment Add Successful';
            }
    
            $output = array(
                'error'     =>  $error_array,
                'success'   =>  $success_output
            );
            echo json_encode($output);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function status(Request $request)
    {
        try {
            $payment = Payment::where('id', $request->id)->first();
            if ($payment) {
                $payment->status = 1- $payment->status;
                $payment->save();
                return 1;
            }
            return 0;
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $ids = $request->ids;
            foreach($ids as $id) {
                $payment = Payment::where('id', $id)->delete();
            }
            return 1;
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }
}
