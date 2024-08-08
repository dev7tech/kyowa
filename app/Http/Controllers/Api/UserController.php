<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Purse;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            return DB::transaction(function() use($request){
                $checkemail=User::where('email',$request['email'])->first();
                $checkname=User::where('name',$request['name'])->first();

                if($request->email == ""){
                    return response()->json(["is_verified"=>0,"message"=>"Email ID is required"],400);
                }
                if($request->name == ""){
                    return response()->json(["is_verified"=>0,"message"=>"Name is required"],400);
                }

                if($request->password == ""){
                    return response()->json(["is_verified"=>0,"message"=>"Password is required"],400);
                }

                if(!empty($checkemail))
                {
                    return response()->json(['is_verified'=>0,'message'=>'Email already exist in our system.'],400);
                }

                if(!empty($checkname))
                {
                    return response()->json(['is_verified'=>0,'message'=>'Name number already exist in our system.'],400);
                }

                $password = Hash::make($request->get('password'));

                $data['name']=$request->get('name');
                $data['email']=$request->get('email');
                $data['profile_image']='unknown.png';
                $data['password']=$password;

                $user=User::create($data);

                if($user)
                {
                    $purse = new Purse;
                    $purse->user_id = $user->id;
                    $purse->point = '0';
                    $purse->save();

                    $arrayName = array(
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'profile_image' => url('/public/images/profile/'.$user->profile_image),
                    );

                    // $user->createConversation(1);

                    return response()->json(['is_verified'=>0,'message'=>'Registration Successful','data'=>$arrayName],200);
                }
                else
                {
                    return response()->json(['is_verified'=>0,'message'=>'Something went wrong'],400);
                }
            });
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function login(Request $request)
    {
        try {
            if($request->email == ""){
                return response()->json(["message"=>"Email id is required"],400);
            }
            if($request->password == ""){
                return response()->json(["message"=>"Password is required"],400);
            }

            $login=User::where('email',$request['email'])->first();

            if(!empty($login))
            {
                if($login->is_verified)
                {
                    if(Hash::check($request->get('password'),$login->password))
                    {
                        $payload = array(
                            'type' => $login->type,
                            'email' => $login->email,
                        );

                        $encoded = json_encode($payload);
                        $token = Crypt::encryptString($encoded);

                        return response()->json(['message'=>'Login Successful','token'=>$token, 'type'=>$login->type],200);
                    }
                    else
                    {
                        $message='Password is incorrect';
                        return response()->json(['message'=>$message],422);
                    }
                }
                else
                {
                    $message='Your account has been blocked by Admin';
                    return response()->json(['message'=>$message],422);
                }
            } else {
                    $message='Your account not found';
                    return response()->json(['message'=>$message],422);
            }
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function changepassword(Request $request)
    {
        if($request->user_id == ""){
            return response()->json(["is_verified"=>0,"message"=>"User is required"],400);
        }
        if($request->old_password == ""){
            return response()->json(["is_verified"=>0,"message"=>"Old Password is required"],400);
        }
        if($request->new_password == ""){
            return response()->json(["is_verified"=>0,"message"=>"New Password is required"],400);
        }
        if($request['old_password']==$request['new_password'])
        {
            return response()->json(['is_verified'=>0,'message'=>'Old and new password must be different'],400);
        }
        $check_user=User::where('id',$request['user_id'])->first();
        if(Hash::check($request['old_password'],$check_user->password))
        {
            $data['password']=Hash::make($request['new_password']);
            $update=User::where('id',$request['user_id'])->update($data);
            return response()->json(['is_verified'=>1,'message'=>'Password Updated'],200);
        }
        else{
            return response()->json(['is_verified'=>0,'message'=>'Incorrect Password'],400);
        }
    }

    public function forgotPassword(Request $request)
    {
        if($request->email == ""){
            return response()->json(["is_verified"=>0,"message"=>"Email id is required"],400);
        }

        $checklogin=User::where('email',$request['email'])->first();

        if(empty($checklogin))
        {
            return response()->json(['is_verified'=>0,'message'=>'Email does not exist'],400);
        } elseif ($checklogin->google_id != "" OR $checklogin->facebook_id != "") {
            return response()->json(['is_verified'=>0,'message'=>"Your account is registered as social login. Try with that"],200);
        } else {
            try{
                $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 8 );
                $newpassword['password'] = Hash::make($password);
                $update = User::where('email', $request['email'])->update($newpassword);

                $title='Password Reset';
                $email=$checklogin->email;
                $name=$checklogin->name;
                $data=['title'=>$title,'email'=>$email,'name'=>$name,'password'=>$password];

                Mail::send('Email.email',$data,function($message)use($data){
                    $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                    $message->to($data['email']);
                } );
                return response()->json(['is_verified'=>1,'message'=>'New Password Sent to your email address'],200);
            }catch(\Swift_TransportException $e){
                $response = $e->getMessage() ;
                return response()->json(['is_verified'=>0,'message'=>'Something went wrong while sending email. Please try again'],200);
            }
        }

    }

    public function getUserId(Request $request){
        return response()->json(['userid'=>$request->user->id],200);
    }
}
