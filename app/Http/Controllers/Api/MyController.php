<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Address;
use App\Favorite;
use App\Order;
use App\Purse;
use Exception;

class MyController extends Controller
{
    public function index(Request $request)
    {
        try {
            $addressCount = Address::where('user_id', $request->user->id)->where('is_verified', '!=', '0')->count();
            $favoriteCount = Favorite::where('user_id', $request->user->id)->count();
            $orderCount = Order::where('user_id', $request->user->id)->count();
            $myPoint = Purse::where('user_id', $request->user->id)->first();

            return response()
                    ->json(['message'=>'Data Successful',
                            'addresscount'=>$addressCount,
                            'favoriteCount'=>$favoriteCount,
                            'orderCount'=>$orderCount,
                            'myPoint'=>$myPoint->point,],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }
}
