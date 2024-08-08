<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Address;
use Validator;
use Exception;

class AddressController extends Controller
{
    public function index()
    {
        try {
            $addresses = Address::orderBy('is_verified')->get();
            return view('address',compact('addresses'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function show(Request $request)
    {
        try {
            $address = Address::where('id', $request->id)->first();
            return response()->json($address, 200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function list(Request $request)
    {
        try {
            $addresses = Address::orderBy('is_verified')->get();
            return view('theme.addresstable', compact('addresses'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function approve(Request $request)
    {
        try {
            $error_array = array();
            $success_output = '';
            
            $address = Address::where('id', $request->id)->first();
            if ($address->is_verified != 0) {
                $address->is_verified = 2;
                $address->save();
                $success_output = 'Address Approve Successful';
            } else {
                $error_array[] = 'Address Approve Failed';
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

    public function history()
    {
        try {
            $addresses = Address::withTrashed()->get();
            return view('addresshistory', compact('addresses'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }
}
