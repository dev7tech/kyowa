<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Cart;
use App\Servicetime;
use App\Conversation;
use App\Product;
use App\IrregularComment;
use App\Address;
use App\Payment;
use App\RetailSale;
use App\Purse;
use App\deliveryMethod;
use Exception;

class CartController extends Controller
{
    public function add(Request $request)
    {
  		try {
            $data=Cart::where('user_id',$request->user->id)
                    ->where('product_id', $request->product_id)
                    ->where('status', 0)
                    ->with('product')
                    ->first();

  		    if($data) {
                if(!$data->product->is_irregular) {
                    if ($request->qty == "") {
                        $qty = $data->qty+'1';
                        $price = $data->product->retailsales->retailsale*($data->qty+'1');
                    } else {
                        $qty = $data->qty+$request->qty;
                        $price = $data->product->retailsales->retailsale*$qty;
                    }

                    $result = Cart::where('user_id',$data['user_id'])
                                ->where('product_id', $data['product_id'])
                                ->where('status', $data['status'])
                                ->update([
                                    'qty' => $qty,
                                    'price' => $price,
                                ]);
                    return response()->json(['message'=>'Qty has been update'],200);
                } else {
                    return response()->json(['message'=>'Proudct is irregular'],200);
                }
  	        } else {
                $product = Product::with('retailsales')->find($request->product_id);
  	            $cart = new Cart;
                $cart->user_id = $request->user->id;
  	            $cart->product_id =$request->product_id;
  	            $cart->is_irregular =$product->is_irregular;
                $cart->unit_id = $product->unit->id;
  	            $cart->qty =$request->qty;
  	            $cart->save();
                $cart1 = Cart::where('id', $cart->id)->first();
  	            $cart1->price =$product->retailsales->retailsale*$cart1->qty;
                $cart1->save();

  	            return response()->json(['message'=>'Product has been added to your cart', 'data'=>$cart1],200);
  	        }
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
   	}

   	public function getcart(Request $request)
   	{
        $timeinfo = Servicetime::first();
        if($timeinfo){
            $current_time = date("H:i:s");
            if(($timeinfo->fromtime < $current_time) && ($timeinfo->totime > $current_time)){
                $is_service_time = true;
            }else{
                $is_service_time = false;
            }
            $service_time_life = ['start'=>$timeinfo->fromtime,'end'=>$timeinfo->totime];
        }else{
            $is_service_time = true;
            $service_time_life = ['start'=>'00:00:00','end'=>'23:59:59'];
        }
        try {
            $cartdatas=Cart::select('id', 'product_id', 'qty', 'price', 'conversation_id')
                    ->where('status','0')
                    ->where('user_id',$request->user->id)
                    ->with('product', 'irregularComment')
                    ->get();

            $regular = array();
            $irregular = array();

            foreach($cartdatas as $cartdata)
            {
                if (!$cartdata->product->is_irregular) {
                    array_push($regular, $cartdata);
                } else {
                    array_push($irregular, $cartdata);
                }
            }

            if ($cartdatas) {
                $cartdatas=Cart::where('status','0')
                    ->where('user_id',$request->user->id)
                    ->with('product', 'irregularComment')
                    ->get();
                $conv = Conversation::where('status', 1)->where('user_one', $request->user->id)->first();
                $unique = $conv ? $conv->unique : NULL;
                $address = $conv ? Address::where('id', $conv->address_id)->first() : NULL;
                $addresses=Address::where('user_id', $request->user->id)->where('is_verified', '2')->get();
                $delivery=deliveryMethod::orderBy('min_price','DESC')->get();

                $purses=Purse::select('point')->where('user_id', $request->user->id)->get();

                $payments = Payment::select('id', 'name')->get();
                $userId = $request->user->id;

                return response()->json(['message'=>'Cart Data Successful',
                                        'is_service_time'=>$is_service_time,
                                        'service_time_life'=>$service_time_life,
                                        'addresses'=>$addresses,
                                        'user_id'=>$userId,
                                        'address'=>$address,
                                        'unique'=>$unique,
                                        'purses'=>$purses,
                                        'payments'=>$payments,
                                        'delivery'=>$delivery,
                                        'regular'=>$regular,
                                        'irregular'=>$irregular],200);
            } else {
                return response()->json(['message'=>'No data found'],400);
            }
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
   	}

    public function commentConfirmByUser(Request $request)
    {
        try {
            $comment = IrregularComment::where('cart_id', $request->cart_id)->first();
            if ($comment) {
                $comment->comment = $request->comment;
                $comment->save();

                return response()->json(['message'=>'update'],200);
            } else {
                $newcomment = new IrregularComment;
                $newcomment->cart_id = $request->cart_id;
                $newcomment->comment = $request->comment;
                $newcomment->save();

                return response()->json(['message'=>'create'],200);
            }
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function commentCancelByUser(Request $request)
    {
        try {
            return DB::transaction(function() use($request){
                $comment = IrregularComment::where('cart_id', $request->cart_id)->first();
                $cart = Cart::where('id', $request->cart_id)->first();
                $cart->qty = '0';
                $cart->price = '0';
                $cart->save();
                $comment->confirm = '0';
                $comment->save();
                return response()->json(['message'=>'OK'],200);
            });
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function getCommentUserByAdmin(Request $request)
    {
        $user = $request->user->id;
        $conversation_infos = Conversation::select('user_one')->where('user_two',$user)->get()->toArray();
        $sender_ids = array();
        foreach ($conversation_infos as $key => $info) {
            array_push($sender_ids,$info['user_one']);
        }

        try {
            $users = Cart::select('carts.*', 'messages.id AS mid', 'irregular_comments.id AS cid',DB::raw('COUNT(messages.id) as unread'),DB::raw('COUNT(irregular_comments.id) as irregular_comments_count'))
                        ->leftJoin('messages',function($join){
                            $join->on('carts.user_id','=','messages.sender_id')
                                ->where('is_show',0)
                                ->whereNull('messages.deleted_at');
                        })
                        ->with(['user'=>function($query) use($sender_ids){
                            $query->whereIn('id',$sender_ids);
                        }])
                        ->leftJoin('irregular_comments',function($join){
                            $join->on('carts.id','=','irregular_comments.cart_id')
                                ->where('confirm',0)
                                ->whereNull('irregular_comments.deleted_at');
                        })
                        // ->withCount(['irregularComment'=>function($query){
                        //     $query->where('confirm', '0');
                        // }])
                        ->whereIn('user_id', $sender_ids)
                        ->where('status', 0)
                        ->groupBy('messages.conversation_unique')
                        ->get();

            return response()->json(['message'=>'OK','data'=>$users],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function getCommentByAdmin(Request $request, $id)
    {
        try {
            $carts=Cart::where('status', 0)
                ->where('is_irregular', '1')
                ->where('user_id', $id)
                ->with('product', 'irregularComment')
                ->get()->toArray();

            $irregular = array();
            foreach($carts as $cart)
            {
                if ($cart['irregular_comment']!="") {
                    array_push($irregular, $cart);
                }
            }

            return response()->json(['message'=>'OK','data'=>$irregular],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function commentConfirmByAdmin(Request $request)
    {
        try {
            return DB::transaction(function() use($request){
                $cart=Cart::where('id',$request->cart_id)->where('status', 0)->with('product')->first();
                $cart->qty =$request->qty;
                $cart->save();
                $cart1=Cart::where('id',$request->cart_id)->where('status', 0)->with('product')->first();
                $cart1->price =$cart->product->retailsales->retailsale*$cart1->qty;
                $cart1->save();

                $comment = IrregularComment::where('cart_id', $cart1->id)->first();
                $comment->confirm = '1';
                $comment->save();

                return response()->json(['message'=>'OK'],200);
            });
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

   	public function qtyupdate(Request $request)
   	{
        try {
            $cartdata=Cart::where('id', $request->cart_id)->with('retailsales')->first();
            $cartdata->qty = $cartdata->qty+$request->qty;
            $cartdata->price =$cartdata->price+$cartdata->product->retailsales->retailsale*$request->qty;
            $cartdata->save();

            return response()->json(['message'=>'Qty has been update'],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
   	}

    public function deletecartproduct($id)
    {
        try {
            $cart=Cart::where('id', $id)->delete();
            $irregular_comment = IrregularComment::where('cart_id', $id)->delete();
            if($cart) {
                return response()->json(['message'=>'Cart Product has been deleted'],200);
            } else {
                return response()->json(['message'=>'Somethig went wrong'],400);
            }
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function preorders(Request $request)
    {
        try {
            $cartdatas=Cart::where('status','0')
                            ->where('user_id',$request->user->id)
                            ->with('product')
                            ->get();

            $addresses=Address::where('user_id', $request->user->id)->where('is_verified', '2')->get();
            $delivery=deliveryMethod::orderBy('min_price','DESC')->get();

            $purses=Purse::select('point')->where('user_id', $request->user->id)->get();

            $payments = Payment::select('id', 'name')->get();

            return response()->json(['message'=>'Preorder Successful','addresses'=>$addresses,'purses'=>$purses,'payments'=>$payments,"data"=>$cartdatas,'delivery'=>$delivery],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

}