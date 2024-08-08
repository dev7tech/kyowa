<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tax;
use Validator;
class TaxController extends Controller
{
    public function index()
    {
        try {
            $taxes = Tax::all();
            return view('tax',compact('taxes'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function list()
    {
        try {
            $taxes = Tax::all();
            return view('theme.taxtable', compact('taxes'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(),[
                'tax' => 'required',
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
                $tax = new Tax;
                $tax->tax =$request->tax;
                $tax->save();
                $success_output = 'tax Add Successful';
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

    public function delete(Request $request)
    {
        try {
            $ids = $request->ids;
            foreach($ids as $id) {
                $tax = Tax::where('id', $id)->delete();
            }
            return 1;
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }
}
