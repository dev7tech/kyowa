<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Favorite;
use App\Product;
use Exception;


class FavoriteController extends Controller
{
    public function favorite(Request $request, $id)
    {
        try {
            $product = Product::select('id')->where('id', $id)->first();

            $favoriteproduct = Favorite::where('user_id', $request->user->id)
                                        ->where('product_id', $id)->get()->first();
            if ($favoriteproduct) {
                // return response()->json(['message'=>'Already Favorite Successful'],200);
                $del_product = Favorite::where('id', $favoriteproduct->id)->delete();
                if ($del_product) {
                    return response()->json(['message'=>'Favorite Remove Successful'],200);
                } else {
                    return response()->json(['message'=>'Favorite Remove Unsuccessful'],500);
                }
            } else {
                $favorite = new Favorite;
                $favorite->user_id = $request->user->id;
                $favorite->product_id = $product->id;
                $favorite->save();

                return response()->json(['message'=>'Favorite Successful'],200);
            }
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function list(Request $request)
    {
        try {
            $products = Favorite::select('id', 'product_id', 'created_at')
                                ->where('user_id', $request->user->id)
                                ->with('product')->get();

            return response()->json(['message'=>'Favorite List Successful', 'data'=>$products],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }

    }

    public function delete($id)
    {
        try {
            $product = Favorite::where('id', $id)->delete();

            if ($product) {
                return response()->json(['message'=>'Favorite Delete Successful'],200);
            } else {
                return response()->json(['message'=>'Nothing Favorite Delete'],200);
            }

        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }
}
