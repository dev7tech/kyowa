<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User;
use App\Purse;
use Validator;

class UserController extends Controller
{
    public function index()
    {
        try {
            $offset = 1;
            $users = User::with('address')->where('is_verified', 1)->limit(24)->get();
            $users_cnt = User::with('address')->where('is_verified', 1)->count();
            return view('userinfo',compact('users','users_cnt','offset'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function list(Request $request)
    {
        $search_value = $request->search_value;
        $offset       = ($request->offset-1) * 24;
        try {
            $users = User::with('address')->Where('name', 'like', '%'.$search_value.'%')->orWhere('email', 'like', '%'.$search_value.'%')->where('is_verified', 1)->offset($offset)->limit(24)->get();
            $users_cnt = User::with('address')->Where('name', 'like', '%'.$search_value.'%')->orWhere('email', 'like', '%'.$search_value.'%')->where('is_verified', 1)->count();

            return view('theme.userinfocards',compact('users','users_cnt'));
            // return view('theme.usertable',compact('users'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(),[
                'username' => 'required',
                'email' => 'required',
                'password' => 'required',
                'role' => 'required',
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
                $user = new User;
                $user->name =$request->username;
                $user->email =$request->email;
                $user->password = Hash::make($request->password);
                $user->type =$request->role;
                if($user->save())
                {
                    $purse = new Purse;
                    $purse->user_id = $user->id;
                    $purse->point = '0';
                    $purse->save();
                }
                if($request->role == 0) $user->createConversation(1);

                $success_output = '用户注册成功。';
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

    public function show(Request $request)
    {
        try {
            $user = User::where('id',$request->id)->first();

            return response()->json($user, 200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $validation = Validator::make($request->all(),[
                'username' => 'required',
                'email' => 'required',
                'role' => 'required',
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
                $user = User::where('id', $request->id)->first();
                $user->name =$request->username;
                $user->email =$request->email;
                if($request->password != "") $user->password = Hash::make($request->password);
                $user->type =$request->role;
                $user->vip = $request->vip;
                $user->save();
                $success_output = '用户信息修改成功。';
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
            $user = User::where('id', $request->id)->first();
            if ($user->type == 0) {
                $user->type = 2;
            } elseif ($user->type == 2) {
                $user->type = 0;
            }
            $user->save();
            return 1;
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->id;
            $user = User::where('id', $id)->delete();
            return 1;
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function search(Request $request){
        try {
            $users_cnt = 100;
            $all_user_id = array();
            $user_id = array();
            $search_value = $request->search_value;
            $users = User::with('address')->Where('name', 'like', '%'.$search_value.'%')->orWhere('email', 'like', '%'.$search_value.'%')->where('is_verified', 1)->get();
            return view('theme.userinfocards',compact('users','users_cnt'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }
}
