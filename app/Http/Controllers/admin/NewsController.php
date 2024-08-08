<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\NewsCategory;
use App\NewsTitle;
use App\NewsContent;
use App\Product;
use Validator;
class NewsController extends Controller
{
    public function index()
    {
        try {
            $newscategories = NewsCategory::with('newstitles')->get();
            return view('news',compact('newscategories'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function categorylist()
    {
        try {
            $newscategories = NewsCategory::all();
            return view('theme.newscategorytable',compact('newscategories'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function subNews($cate_id)
    {
        try {
            $newstitles = NewsTitle::where('category_id', $cate_id)->get();
            $category = NewsCategory::where('id', $cate_id)->first();
            return view('newstitle',compact('newstitles', 'category'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function titlelist(Request $request)
    {
        try {
            $newstitles = NewsTitle::where('category_id', $request->id)->get();
            $category = NewsCategory::where('id', $request->id)->first();
            return view('theme.newstitletable',compact('newstitles', 'category'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function subTitles($cate_id, $id)
    {
        try {
            $newstitle = NewsTitle::where('id', $id)->first();
            $category = NewsCategory::where('id', $cate_id)->first();
            $newscontents = NewsContent::where('title_id', $id)->with('product')->get();
            $products = Product::all();
            return view('newscontent',compact('newscontents', 'newstitle', 'category', 'products'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function contentlist(Request $request)
    {
        try {
            $newscontents = NewsContent::where('title_id', $request->id)->with('product')->get();
            return view('theme.newscontenttable',compact('newscontents'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function categoryStore(Request $request)
    {
        try {
            $validation = Validator::make($request->all(),[
                'newscategory' => 'required',
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
                $news = new NewsCategory;
                $news->name = $request->newscategory;
                $news->save();
                $success_output = 'News category Add Successful';
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

    public function categoryShow(Request $request)
    {
        try {
            $category = NewsCategory::where('id',$request->id)->first();
            return response()->json(['message' => 'News category fetch successfully', 'category' => $category], 200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function categoryUpdate(Request $request)
    {
        try {
            $validation = Validator::make($request->all(),[
                'editnewscategory' => 'required',
              ]);
              $error_array = array();
              $success_output = '';
              if ($validation->fails())
              {
                    foreach($validation->messages()->getMessages() as $field_name => $messages){
                        $error_array[] = $messages;
                    }
              } else {
                  $news = NewsCategory::where('id', $request->id)->first();
                  $news->name =$request->editnewscategory;
                  $news->save();
                  $success_output = 'News category Update Successful!';
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

    public function categoryDelete(Request $request)
    {
        try {
            $id = $request->ids;
            $newscategories = NewsCategory::where('id', $id)->delete();
            return 1;
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function titleStore(Request $request)
    {
        try {
            $validation = Validator::make($request->all(),[
                'title' => 'required',
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
                $news = new NewsTitle;
                $news->category_id = $request->cate_id;
                $news->title = $request->title;
                $news->save();
                $success_output = 'News title Add Successful';
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

    public function titleShow(Request $request)
    {
        try {
            $title = NewsTitle::where('id',$request->id)->first();
            return response()->json(['message' => 'News title fetch successfully', 'title' => $title], 200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function titleUpdate(Request $request)
    {
        try {
            $validation = Validator::make($request->all(),[
                'title' => 'required',
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
                  $news = NewsTitle::where('id', $request->id)->first();
                  $news->title =$request->title;
                  $news->category_id = $request->id;
                  $news->save();
                  $success_output = 'News Title Update Successful!';
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

    public function titleDelete(Request $request)
    {
        try {
            $ids = $request->ids;
            $newstitles = NewsTitle::where('id', $ids)->delete();
            return 1;
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function contentStore(Request $request)
    {
        try {
            $validation = Validator::make($request->all(),[
                'content' => 'required',
                'image' => 'mimes:jpeg,png,jpg',
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
                if ($request->image) {
                    $image = 'news-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
                    $request->image->move('public/images/news', $image);
                }
                if ($request->video) {
                    $video = 'news-' . uniqid() . '.' . $request->video->getClientOriginalExtension();
                    $request->video->move('public/videos/news', $video);
                }
    
                $news = new NewsContent;
                $news->title_id = $request->title_id;
                $news->content = $request->content;
                if ($request->related_product) {
                    $news->product_id = $request->related_product;
                }
                $news->image = $request->image ? $image : null;
                $news->media = $request->video ? $video : null;
                $news->save();
                $success_output = 'News Content Add Successful';
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

    public function contentShow(Request $request)
    {
        try {
            $content = NewsContent::where('id',$request->id)->first();
            return response()->json(['message' => 'News Content fetch successfully', 'content' => $content], 200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function contentUpdate(Request $request)
    {
        try {
            $validation = Validator::make($request->all(),[
                'editcontent' => 'required',
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
                  $image=null; $video=null;
                if ($request->image) {
                    $image = 'news-' . uniqid() . '.' . $request->image->getClientOriginalExtension();
                    $request->image->move('public/images/news', $image);
                }
                if ($request->video) {
                    $video = 'news-' . uniqid() . '.' . $request->video->getClientOriginalExtension();
                    $request->video->move('public/videos/news', $video);
                }

                $news = NewsContent::where('id', $request->id)->first();
                $news->content =$request->editcontent;
                if ($request->related_product) {
                    $news->product_id = $request->related_product;
                }
                if(!json_decode($request->removeimg)){
                    if( !is_null($image) ){
                        $news->image = $image;
                    } else {
                        $news->image = $news->image;
                    }
                } else {
                    $news->image = null;
                }

                if(!json_decode($request->removevideo) && !is_null($video)){
                    if( !is_null($video) ){
                        $news->media = $video;
                    } else {
                        $news->media = $news->media;
                    }
                } else {
                    $news->media = null;
                }

                $news->save();
                $success_output = 'News Content Update Successful!';
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

    public function contentDelete(Request $request)
    {
        try {
            $ids = $request->ids;
            foreach($ids as $id) {
                $newscontents = NewsContent::where('id', $id)->delete();
            }
            return 1;
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }
    
}
