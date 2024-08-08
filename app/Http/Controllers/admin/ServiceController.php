<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Conversation;
use Validator;

class ServiceController extends Controller
{
    public function index()
    {
        try {
            $conversations = Conversation::all();
            $users = User::where('type', '!=', '0')->get();

            $conversation_users = array();
            foreach ($conversations as $conversation) {
                $cur = User::where('id', $conversation->user_one)->first();
                $sal = User::where('id', $conversation->user_two)->first();
                $arrayName = array(
                    'id' => $conversation->id,
                    'cur' => $cur['name'],
                    'sal' => $sal['name'],
                );
                array_push($conversation_users, $arrayName);
            }
            
            return view('service',compact('conversation_users', 'users'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function list(Request $request)
    {
        try {
            $conversations = Conversation::all();
            $users = User::where('type', '!=', '0')->get();

            $conversation_users = array();
            foreach ($conversations as $conversation) {
                $cur = User::where('id', $conversation->user_one)->first();
                $sal = User::where('id', $conversation->user_two)->first();
                $arrayName = array(
                    'id' => $conversation->id,
                    'cur' => $cur['name'],
                    'sal' => $sal['name'],
                );
                array_push($conversation_users, $arrayName);
            }
            
            return view('theme.servicetable',compact('conversation_users', 'users'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function show(Request $request)
    {
        try {
            $conversations = Conversation::where('id', $request->id)->first();
                        
            return response()->json($conversations, 200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $validation = Validator::make($request->all(),[
                'user' => 'required',
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
                $conversation = Conversation::where('id', $request->id)->first();
                $conversation->user_two = $request->user;
                $conversation->save();
                $success_output = 'Change Conversation User Successful';
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
