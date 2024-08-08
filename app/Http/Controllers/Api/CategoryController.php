<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Exception;

class CategoryController extends Controller
{
    public function pCategory()
    {
        try {
            $pCategory=Category::select('id','name')
                            ->where('is_available','=','1')
                            ->where('type','=','0')
                            ->orderBy('order', 'asc')
                            ->withCount('p_products')
                            ->get();
            return response()
                   ->json(['message'=>'Parent Category Successful','data'=>$pCategory],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function cCategory($id)
    {
        try {
            $cCategory= Category::select('id', 'name', 'parent_name', 'p_id')
                            ->withCount('c_products')
                            ->where('is_available','=','1')
                            ->where('p_id','=',$id)
                            ->orderBy('order', 'asc')
                            ->get();
            return response()
                        ->json(['message'=>'Child Category Successful','data'=>$cCategory],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }
}
