<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Product;
use App\RetailSale;
use Exception;

class ProductController extends Controller
{
    public function search(Request $request)
    {
        $category = $request->category;
        $pcategory = $request->pcategory;
        $content = $request->content ?? '';
        $lprice = $request->lprice ?? '0';
        $hprice = $request->hprice ?? '1000000000';

        try {
            $search = Product::select('products.*', 'retailsales.retailsale')
                ->leftJoin('images', 'products.id', '=', 'images.product_id')
                ->where('name', 'like', '%'.$content.'%')
                ->join('retailsales', function ($join) use ($lprice, $hprice, $category, $pcategory) {
                    $join->on('products.id', '=', 'retailsales.product_id')
                        ->where('retailsales.is_available', '1')
                        ->whereBetween('retailsales.retailsale', [$lprice, $hprice]);

                    if ($category) {
                        $join->where('category_id', 'like', '%' . $category . '%');
                    }

                    if ($pcategory) {
                        $join->where('pcategory_id', 'like', '%' . $pcategory . '%');
                    }
                })
                ->orderBy('category_id', 'ASC')
                ->with('category')
                ->groupBy('products.id')
                ->get();

            $search = $search->map(function ($product) {
                $product->images = $product->images->pluck('image_src')->toArray();
                return $product;
            });

            return response()->json(['message' => 'Search Successful', 'data' => $search], 200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function list(Request $request, $id)
    {
        $field = $request->field ? $request->field : 'order';
        $order = $request->order ? $request->order : 'asc';
        if ($field == 'price') $field = 'retailsales.retailsale';
        if ($field == 'order_qty') $field = 'order_qty';
        try {
            $user = $request->user != null ? $request->user->id : null;
            $products=Product::select('products.*', 'retailsales.retailsale',DB::raw('SUM(order_details.qty) as order_qty'))
                            ->where('products.is_available','=','1')
                            ->where('category_id',$id)
                            ->orderBy($field, $order)
                            ->with(['favorites'=>function($query) use ($user){
                                $query->where('user_id', $user);
                            }])
                            ->join('retailsales', function($join) {
                                $join->on('products.id', '=', 'retailsales.product_id')
                                    ->where('retailsales.is_available','1');
                            })
                            ->leftJoin('order_details', function($join) {
                                $join->on('products.id', '=', 'order_details.product_id');
                            })
                            ->groupBy('products.id')
                            ->with('images', 'medias', 'unit')
                            ->paginate($request->per_page);
            return response()
            ->json(['message'=>'Products Successful','data'=>$products],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function details(Request $request, $id)
    {
        try {
            $user = $request->user != null ? $request->user->id : null;
            $product=Product::where('id', $id)
                            ->where('is_available', '1')
                            ->orderBy('order', 'asc')
                            ->with('images', 'medias', 'retailsales','unit')
                            ->withCount(['favorites'=>function($query) use ($user){
                                $query->where('user_id', $user);
                            }])
                            ->first();

            $relatedProducts=Product::where('related_id', $product->related_id)
                                    ->with('retailsales')
                                    ->get();
            return response()
                   ->json(['message'=>'Product Successful',
                           'data'=>$product,
                           'related_data'=>$relatedProducts], 200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }
}
