<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use Validator;
use Exception;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::where('p_id', '0')->with('p_products')->orderBy('order', 'ASC')->get();
            $type = 0;
            $pid = 0;
            $name = '';
            return view('category',compact('categories', 'type', 'pid', 'name'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function subcategory($id)
    {
        try {
            $category = Category::where('id', $id)->first();
            if ($category->type == 0) {
                $pid = $id;
                $categories = Category::where('p_id', $id)->orderBy('order', 'ASC')->get();
                if ($category) {
                    $name = $category->name;
                }
                $type = 1;
                return view('category',compact('categories', 'type', 'pid', 'name'));
            }
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function list(Request $request)
    {
        try {
            $type = $request->type;
            $pid = $request->pid;
            $categories = Category::where('type', $type)->where('p_id', $pid)->orderBy('order', 'ASC')->get();
            $type = 0;
            
            return view('theme.categorytable',compact('categories','type'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(),[
                'category_name' => 'required',
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
                $category = new Category;
                $category->name =$request->category_name;
                $category->p_id = $request->pid;
                if ($request->pid == 0) {
                    $category->type = $request->type;
                } else {
                    $pcategory = Category::where('id', $request->pid)->first();
                    $category->type = 1;
                    $category->parent_name = $pcategory->name;
                }
    
                $lastCategory = Category::orderBy('order', "DESC")->first();
                if ($lastCategory) {
                    $category->order = $lastCategory->order + 1;
                } else {
                    $category->order = 1;
                }
    
                $category->save();
                $success_output = 'Category Add Successful';
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

    public function show(Request $request)
    {
        try {
            $category = Category::where('id',$request->id)->first();
            return response()->json(['category'=>$category], 200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $validation = Validator::make($request->all(),[
                'category_name' => 'required',
              ]);
      
              $error_array = array();
              $success_output = '';
              $checkname = Category::where('name', $request->category_name)->where('id', '<>', $request->id)->get();
              if ($validation->fails())
              {
                  foreach($validation->messages()->getMessages() as $field_name => $messages)
                  {
                      $error_array[] = $messages;
                  }
              } else if (count($checkname) > 0) {
                  $error_array[] = "No data";
              } else {
                  $category = Category::where('id', $request->id)->first();
                  $category->name =$request->category_name;
                  $category->p_id = $request->pid;
                  $category->save();
                  $success_output = 'Category Update Successful!';
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

    public function status(Request $request)
    {
        try {
            $category = Category::where('id', $request->id)->first();
            if ($category) {
                $category->is_available = 1- $category->is_available;
                $category->save();
                return 1;
            }
            return 0;
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            $ids = $request->ids;
            foreach($ids as $id) {
                $category = Category::where('id', $id)->delete();
                $smallCategory = Category::where('p_id', $id)->delete();
                $product = Product::where('category_id', $id)->delete();
            }
            return 1;
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function swap(Request $request) {
        $src_category = Category::where('id', $request->id)->first();
        $tar_category = Category::where('id', $request->nid)->where('p_id', $request->pid)->first();
        if ($tar_category) {
            if ($request->method == '0') {
                $tar_categories = Category::where('p_id', $request->pid)->where('order', '>=', $tar_category->order)->orderBy('order', 'ASC')->increment('order', 1);
                $src_category->order = $tar_category->order;
                if ($tar_categories) {
                    $src_category->save();
                    return 1;
                }
            } else {
                $src_category->order = $tar_category->order + 1;
                $tar_categories = Category::where('p_id', $request->pid)->where('order', '>', $tar_category->order)->orderBy('order', 'ASC')->increment('order', 1);
                $src_category->save();
                return 1;
            }
        }
        return 0;
    }
}
