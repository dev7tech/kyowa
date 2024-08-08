<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Purse;
use App\User;
use Validator;
class PurseController extends Controller
{
    public function index()
    {
        try {
            $purse = Purse::with('user')->get();
            $users = User::where('type', '0')->where('is_verified', '1')->get();
            return view('purse',compact('purse', 'users'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function show(Request $request)
    {
        try {
            $purse = Purse::where('id', $request->id)->first();
            return response()->json($purse, 200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function list()
    {
        try {
            $purse = Purse::with('user')->get();
            $users = User::where('type', '0')->where('is_verified', '1')->get();
            return view('theme.pursetable',compact('purse', 'users'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $validation = Validator::make($request->all(),[
                'point' => 'required',
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
                $purse = Purse::where('id', $request->id)->first();
                $purse->point = $request->point;
                $purse->save();
                $success_output = 'Address Approve Successful';
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
}
