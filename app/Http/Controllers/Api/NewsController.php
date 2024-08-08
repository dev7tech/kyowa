<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\NewsCategory;
use App\NewsTitle;
use App\NewsContent;
use App\ReadNews;
use Exception;

class NewsController extends Controller
{
    public function getCategory(Request $request)
    {
        try {
            $categories = NewsCategory::select('id', 'name')
                                        ->orderBy('id', 'ASC')
                                        ->get();

            return response()
                   ->json(['message'=>'Categories Successful','data'=>$categories],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function getNewsTitlesByCategoryId($id)
    {
        try {
            $newsTitles = NewsTitle::where('category_id', $id)->orderBy('created_at', 'DESC')->get();

            return response()->json(['message'=>'News Titles Successful','data'=>$newsTitles],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function getNewsContentById(Request $request, $id)
    {
        try {
            $news = NewsContent::select('content', 'image', 'media', 'product_id')
                                ->where('title_id', $id)
                                ->get();
            
            if ($news) {
                return response()->json(['message'=>'News Content Successful','data'=>$news],200);
            } else {
                return response()->json(['message'=>'No data found'],400);
            }
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function getNewsTitles(Request $request)
    {
        try {
            $newstitles = NewsTitle::select('id', 'category_id')->where('category_id', '1')->get();

            return response()
                   ->json(['message'=>'NewsTitles Successful','data'=>$newstitles],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }
}
