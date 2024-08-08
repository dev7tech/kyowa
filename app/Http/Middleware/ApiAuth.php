<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Crypt;
use App\User;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $is_need)
    {
        $token=$request->header('Authorization');
        $request['token']=$token;
        
        if(!empty($token))
        {
            $decrypt = Crypt::decryptString($token);
            $decoded = json_decode($decrypt);
            
            $checked_user=User::where('email',$decoded->email)->first();
            if(empty($checked_user))
            {
                return response()->json(['status'=>'403','message'=>'Invalid user'],403);
            }

            if($checked_user->type == '1'){
                $request['user']=$checked_user;
                return $next($request);
            }
            if($role == 4){
                $request['user']=$checked_user;
                return $next($request);
            }
            $checked_role=User::where('email',$decoded->email)->where('type', $role)->first();
            
            if(empty($checked_role))
            {
                return response()->json(['status'=>'403','message'=>'Invalid role'],403);
            }
            $request['user']=$checked_role;

            return $next($request);
        } else {
            if($is_need == 'true') {
                return response()->json(['status'=>'401','message'=>'Unauthorized', 'data'=>$is_need],401);
            }
            $request['user']=null;
            return $next($request);
        }
        
        return response()->json(['status'=>'401','message'=>'Unauthorized'],401);
        
    }
}
