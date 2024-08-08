<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Category;
use App\Image;
use App\Media;
use App\Unit;
use App\RetailSale;
use App\WholeSale;
use App\Tax;
use Validator;


class ProductController extends Controller
{
    public function subProducts($id)
    {
        try {
            $category = Category::where('id', $id)->first();
            $pcategory = $category;
            if ($category->type == 1) {
                $products = Product::with('images', 'wholesales', 'retailsales','unit')->where('category_id', $id)->orderBy('order', 'ASC')->get();
                $pcategory = Category::where('id', $category->p_id)->first();
            } else {
            }
            $specials = Category::where('is_available','1')->where('type','2')->get();
            $units = Unit::all();
            return view('product', compact('id','products', 'category', 'specials', 'pcategory', 'units'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function createPageIndex($id)
    {
        try {
            $category = Category::where('id', $id)->first();
            $pcategory = $category;
            if ($category->type == 1) {
                $products = Product::with('images', 'wholesales', 'retailsales')->where('category_id', $id)->orderBy('order', 'ASC')->get();
                $pcategory = Category::where('id', $category->p_id)->first();
            } else {
            }
            $specials = Category::where('is_available','1')->where('type','2')->get();
            $units = Unit::all();
            $taxes = Tax::all();
            $CorU=1;//this is flag that the createProduct.blade.php works for create function
            $productId=0;
            return view('createProduct', compact('CorU','productId','products', 'category', 'specials', 'pcategory', 'units','taxes'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function updatePageIndex($id,Request $request)
    {
        try {
            $category = Category::where('id', $id)->first();
            $pcategory = $category;
            if ($category->type == 1) {
                $products = Product::with('images', 'wholesales', 'retailsales')->where('category_id', $id)->orderBy('order', 'ASC')->get();
                $pcategory = Category::where('id', $category->p_id)->first();
            } else {
                // $products = SpecialItem::where('special_items.sp_id', $id)->orderBy('special_items.order', 'ASC')->select('item.*', 'printers.name')->get();
            }
            $specials = Category::where('is_available','1')->where('type','2')->get();
            $units = Unit::all();
            $taxes = Tax::all();
            $CorU=0;//this is flag that the createProduct.blade.php works for update function
            $productId= $request->productId ;
            return view('createProduct', compact('CorU','productId','products', 'category', 'specials', 'pcategory', 'units','taxes'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    
    

    public function list(Request $request)
    {
        try {
            $products = Product::with('images', 'wholesales', 'retailsales')->where('category_id', $request->id)->orderBy('order', 'ASC')->get();

            return view('theme.producttable',compact('products'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function store(Request $request)
    {
        try {
            return DB::transaction(function() use($request){
                $validation = Validator::make($request->all(),[
                    'codeNo' => 'required',
                    'pcat_id' => 'required',
                    'cat_id' => 'required',
                    'product_name' => 'required',
                    'unit' => 'required',
                    'tax_rate'=> 'required',
                    'gauge'=> 'required',
                    'quantity'=> 'required',
                    'point'=> 'required',
                    'image' => 'mimes:jpeg,png,jpg',
                  ]);
                  $error_array = array();
                  $success_output = '';
                  //validate if codeNo exists
                    $tempVariable = Product::where('codeNo', $request->codeNo)->get();
                    
                  //end of the validating
                  if ($validation->fails() || count($tempVariable)!=0 || strlen($request->codeNo) !=5)//
                  {
                        foreach($validation->messages()->getMessages() as $field_name => $messages)
                        {
                            $error_array[] = $messages;
                        }
                        if(count($tempVariable)!=0){
                            $error_array[] = '商品ID exists,Try another number.';
                        }
                        if(strlen($request->codeNo) !=5){
                            $error_array[] = "商品ID's length have to be 5.";
                        }
                  } else {
                      $product = new Product;

                      $img_names = array();

                      $img_ids = explode(",",$request->count_img);

                      foreach ($img_ids as $img_id) {

                        $image = '';
                        if ($request->file('image'.$img_id) != null) {
                            $image = 'product-' . uniqid() . '.' . $request->file('image'.$img_id)->getClientOriginalExtension();
                            array_push($img_names, $image);
                            $request->file('image'.$img_id)->move('public/images/product', $image);
                        }

                      }

                      $video = '';
                      if ($request->video != null) {
                          $video = 'video-' . uniqid() . '.' . $request->video->getClientOriginalExtension();
                          $request->video->move('public/videos/product', $video);
                      }
        
                      $product->category_id =$request->cat_id;
                      if ($request->get('cat_id')) {
                          $product->pcategory_id = $request->pcat_id;
                      } else {
                          $product->pcategory_id = $request->cat_id;
                      }
        
                      $product->name =$request->product_name;
                      $product->codeNo =$request->codeNo;
                      $TaxRow = Tax::where('id',$request->tax_rate)->first();
                      if($TaxRow){
                            $product->tax = $TaxRow->tax;
                        }
                        else{
                            $product->tax=0.08;
                        }

                      $product->gauge = $request->gauge;
                      $product->qty = $request->quantity;
                      $product->unit_id = $request->unit;
                     
                      
                      
                      $product->point = $request->point;
                      $product->mark = $request->mark;
                      if ($request->related_product != null && $request->is_relative != null) {
                        $product->related_id = $request->related_product;
                      }
                      $product->is_irregular = $request->is_irregular == null ? '0' : 1;
                      $product->is_available = $request->is_available == null ? '0' : $request->is_available;
                      $product->description = $request->description ? $request->description : '';
                      $last = Product::where('category_id', $request->cat_id)->orderBy('order', 'desc')->first();
                      if ($last) {
                          $product->order = $last->order + 1;
                      } else {
                          $product->order = 1;
                      }
                      $product->save();
        
                      if ($request->related_product == null) {
                        Product::where('id', $product->id)->update(['related_id'=>$product->id]);
                      }
        
                      $wholesales = new WholeSale;
                      $wholesales->product_id = $product->id;
                      $wholesales->wholesale = $request->wholesales;
                      $wholesales->save();
        
                      $retailsales = new RetailSale;
                      $retailsales->product_id = $product->id;
                      $retailsales->retailsale = $request->retailsales;
                      $retailsales->save();

                      foreach ($img_names as $img_name) {

                        $img =new Image;
                        $img->product_id = $product->id;
                        $img->image_src = $img_name;
                        $img->save();

                      }
        
          

                      if($video)
                      {
                        $media = new Media;
                        $media->product_id = $product->id;
                        $media->media_src = $video;
                        $media->save();
                      }
          
                      $success_output = 'Product Add Successful!';
                  }
                  $output = array(
                      'error'     =>  $error_array,
                      'success'   =>  $success_output
                  );
                  echo json_encode($output);
            });
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function show(Request $request)
    {
        try {
            $category = Product::where('id',$request->id)->with('images', 'retailsales', 'wholesales','medias')->first();
            return response()->json($category, 200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function update(Request $request)
    {
        try {
            return DB::transaction(function() use($request){
                $validation = Validator::make($request->all(),[
                    'codeNo' => 'required',
                    'product_name' => 'required',
                    'unit' => 'required',
                    'image' => 'mimes:jpeg,png,jpg',
                ]);
                $error_array = array();
                $success_output = ''; $temp_array=array();
                $img_ids = array(); $del_array = array();
                //validate if codeNo exists
                $tempVariable = Product::where('codeNo', $request->codeNo)->get();
                //end of the validating
                $product = Product::where('id', $request->productId)->first();
                if ($validation->fails() || (count($tempVariable)!=0 && $product->codeNo != $request->codeNo) || strlen($request->codeNo) !=5)
                {
                    foreach($validation->messages()->getMessages() as $field_name => $messages)
                    {
                        $error_array[] = $messages;
                    }
                    if(count($tempVariable)!=0 && $product->codeNo != $request->codeNo){
                        $error_array[] = '商品ID exists,Try another number.';
                    }
                    if(strlen($request->codeNo) !=5){
                        $error_array[] = "商品ID's length have to be 5.";
                    }
                } else {
                    //insert new images!!!!!
                    if(strlen($request->count_img)>0)
                        $img_ids = explode(",",$request->count_img); 
                    $threshold = (int)$request->threshold;
                    foreach ( $img_ids as $key => $value) {
                        if( (int)$value > $threshold - 1 ){
                            $image = '';
                            if ($request->file('image'.$value) != null) {
                                $image = 'product-' . uniqid() . '.' . $request->file('image'.$value)->getClientOriginalExtension();
                                $request->file('image'.$value)->move('public/images/product', $image);
                                $img_ids[$key] = $image;
                                $img =new Image;
                                $img->product_id = $product->id;
                                $img->image_src = $image;
                                $img->save();
                            }
                        }
                    }

                   
                    
                    $video = '';
                    if ($request->video != null) {
                        $video = 'video-' . uniqid() . '.' . $request->video->getClientOriginalExtension();
                        $request->video->move('public/videos/product', $video);
                    }
                    
                    $product->name =$request->product_name;
                    $TaxRow = Tax::where('id',$request->tax_rate)->first();
                    if($TaxRow){

                        $product->tax = $TaxRow->tax;
                    }
                    else{
                        $product->tax=0.08;
                    }
                    // $product->tax = $request->tax_rate;
                    $product->gauge = $request->gauge;
                    $product->qty = $request->quantity;
                    $product->unit_id = $request->unit;
                    $product->point = $request->point;
                    $product->mark = $request->mark;
                    if ($request->related_product != null && $request->is_relative != null) {
                        $product->related_id = $request->related_product;
                      }
                    $product->is_irregular = $request->is_irregular == null ? '0' : 1;
                    $product->is_available = $request->is_available == null ? '0' : $request->is_available;
                    $product->description = $request->description;
                    $product->save();
        
                    if ($request->related_product == null) {
                        Product::where('id', $product->id)->update(['related_id'=>$product->id]);
                    }

                    $wholesale = WholeSale::where('product_id', $product->id)->where('is_available', '1')->first();
                    if ($wholesale->wholesale != $request->wholesales) {
                        $wholesale->is_available = 0;
                        $wholesale->save();

                        $wholesales = new WholeSale;
                        $wholesales->product_id = $product->id;
                        $wholesales->wholesale = $request->wholesales;
                        $wholesales->save();
                    }

                    $retailsale = RetailSale::where('product_id', $product->id)->where('is_available', '1')->first();
                    if ($retailsale->retailsale != $request->retailsales) {
                        $retailsale->is_available = 0;
                        $retailsale->save();

                        $retailsales = new RetailSale;
                        $retailsales->product_id = $product->id;
                        $retailsales->retailsale = $request->retailsales;
                        $retailsales->save();
                    }

                    $images = Image::where('product_id', $product->id)->orderBy('id', 'asc')->get();
                    if(strlen($request->del_array)>0)
                        $del_array = explode(",",$request->del_array);
                    foreach ($images as $key => $image) {
                        if($key < $threshold){
                            $img_ids[array_search((string)$key,$img_ids)] = $image->image_src;
                            if($key<count($del_array)){
                                $temp = $images[$del_array[$key]]->id;
                                $del_array[$key] = $temp;
                            }
                        }
                    }
                    foreach ($images as $key => $image) {
                        $img =Image::where('id', $image->id)->first();
                        $img->image_src = $img_ids[$key];
                        $img->product_id = $product->id;
                        $img->save();
                    }

                    foreach ($del_array as $key => $value) {
                        $image = Image::where('id', $value)->delete();
                    }
        
                  
                    if(json_decode($request->removevideo)){
                        $media = Media::where('product_id', $product->id)->delete();
                    } else{
                        if($video != "")
                        {
                            $media = Media::where('product_id', $product->id)->first();
                            if ($media) {
                                $media->media_src = $video;
                                $media->product_id = $product->id;
                                $media->save();
                            } else {
                                $media = new Media;
                                $media->product_id = $product->id;
                                $media->media_src = $video;
                                $media->save();
                            }
                        } else{

                        }
                    }                    
        
                    $success_output = 'Product Update Successful!';
                }
                $output = array(
                    'error'     =>  $error_array,
                    'success'   =>  $success_output
                );
                echo json_encode($output);
            });
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function status(Request $request)
    {
        try {
            $product = Product::where('id', $request->id)->first();
            if ($product) {
                $product->is_available = 1- $product->is_available;
                $product->save();
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
                $product = Product::where('id', $id)->delete();
            }
            if ($product) {
                return 1;
            } else {
                return 0;
            }
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function history()
    {
        try {
            $products = Product::withTrashed()->get();
            return view('producthistory', compact('products'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function swap(Request $request) {
        $src_product = Product::where('id', $request->id)->first();
        $tar_product = Product::where('codeNo', $request->nid)->first();
        if ($tar_product) {
            if ($request->method == '0') {
                $tar_products = Product::where('order', '>=', $tar_product->order)->orderBy('order', 'ASC')->increment('order', 1);
                $src_product->order = $tar_product->order;
                if ($tar_products) {
                    $src_product->save();
                    return 1;
                }
            } else {
                $src_product->order = $tar_product->order + 1;
                $tar_products = Product::where('order', '>', $tar_product->order)->orderBy('order', 'ASC')->increment('order', 1);
                if ($tar_products) {
                    $src_product->save();
                    return 1;
                }
            }
        }
        return 0;
    }

    public function wholesalehistory()
    {
        try {
            $wholesales = WholeSale::with('product')->get();
            return view('wholesalehistory', compact('wholesales'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function retailsalehistory()
    {
        try {
            $retailsales = RetailSale::with('product')->get();
            return view('retailsalehistory', compact('retailsales'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

}
