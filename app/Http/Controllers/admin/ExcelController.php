<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Excel;
use App\Category;
use App\Product;
use App\Unit;
use App\RetailSale;
use App\WholeSale;

class ExcelController extends Controller{
    public function index(){
        return view('import');
    }

    public function import(Request $request){
        $error_array = array();
        try {
            $sheets = Excel::toArray([],$request->file('uploaded_file')->store('uploaded_file'));
        
            foreach($sheets as $sheet_num=>$sheet){
                if($sheet_num != 0) continue;
                foreach($sheet as $key=>$data){
                    if($key==0) continue;
                    if(($data[0]!='')&&($data[1]!='')&&($data[2]!='')&&($data[3]!='')&&($data[4]!='')){
                        /**
                         * Check bigCategoryItem exist in Category Table.
                         */
                        $bigCategory_num = Category::where('name', $data[0])->where('p_id', '0')->count();
                        
                        if($bigCategory_num > 0){
                            $bigCategory = Category::where('name', $data[0])->where('p_id', '0')->first()->toArray();
                            $bigCategoryID = $bigCategory['id'];
                        }else{
                            $order_value = array();
                            $special_row_num = Category::where('p_id', '0')->count();
                            if($special_row_num > 0) $order_value = Category::where('p_id', '0')->orderBy('order','desc')->first()->toArray();
                            else $order_value['id'] = 0;
                            
                            $NewBigcategory = new Category;
                            $NewBigcategory->name = $data[0];
                            $NewBigcategory->p_id = 0;
                            $NewBigcategory->type = 0;
                            $NewBigcategory->is_available = 1;
                            $NewBigcategory->order = $order_value['order'] + 1;
                            $NewBigcategory->save();
                            $bigCategoryID = $NewBigcategory->id;
                        }
    
                        /**
                         * Chcek smallCategoryItem exist in Category Table.
                         */
                        $smallCategory_num = Category::where('name', $data[1])->where('p_id', $bigCategoryID)->count();
                        if($smallCategory_num > 0){
                            $smallCategory = Category::where('name', $data[1])->where('p_id', $bigCategoryID)->first()->toArray();
                            $smallCategoryID = $smallCategory['id'];
                        }else{
                            $order_value = array();
                            $special_row_num = Category::where('p_id', $bigCategoryID)->count();
                            if($special_row_num > 0) $order_value = Category::where('p_id', $bigCategoryID)->orderBy('order','desc')->first()->toArray();
                            else $order_value['id'] = 0;

                            $NewSmallcategory = new Category;
                            $NewSmallcategory->name = $data[1];
                            $NewSmallcategory->p_id = $bigCategoryID;
                            $NewSmallcategory->parent_name = $data[0];
                            $NewSmallcategory->type = 1;
                            $NewSmallcategory->is_available = 1;
                            $NewSmallcategory->order = $order_value['id'] + 1;
                            $NewSmallcategory->save();
                            $smallCategoryID = $NewSmallcategory->id;
                        }
    
                        /**
                         * Chcek Unit exist in Unit Table.
                         */
                        $unit_num = Unit::where('name', $data[4])->count();
                        if($unit_num > 0){
                            $unit = Unit::where('name', $data[4])->first();
                            $unitID = $unit['id'];
                        }else{
                            $NewUnit = new Unit;
                            $NewUnit->name = $data[4];
                            $unitID = $NewUnit->save();
                        }
    
                        /**
                         * Check exist in Product Table before Excel content data import to Table.
                         * 
                         */
                        $product = Product::where('name', $data[3])
                                   ->where('pcategory_id', $bigCategoryID)
                                   ->where('category_id', $smallCategoryID)
                                   ->where('unit_id',$unitID)
                                   ->where('codeNo',$data[2]);
                        if($data[5] != '') $product->where('gauge',$data[5]);
                        $product_num = $product->count();
    
                        if($product_num > 0){
                            $product = $product->first();
                            $product->qty = $product->qty + $data[6];
                            $product->tax   = $data[9];
                            $product->mark  = $data[10];
                            $product->save();
                            $productID = $product->id;
                        }else{
                            $order_value = Product::max('order');
                            $NewProduct = new Product;
                            $NewProduct->codeNo = $data[2];
                            $NewProduct->category_id = $smallCategoryID;
                            $NewProduct->pcategory_id = $bigCategoryID;
                            $NewProduct->unit_id = $unitID;
                            $NewProduct->name = $data[3];
                            $NewProduct->gauge = $data[5];
                            $NewProduct->qty = $data[6];
                            $NewProduct->tax = $data[9];
                            $NewProduct->mark = $data[10];
                            $NewProduct->order = $order_value + 1;
                            $NewProduct->save();
                            $productID = $NewProduct->id;
                        }

                        /**
                         * Register WholeSales Price
                         */
                        $WholeSales = new WholeSale;
                        $WholeSales->product_id =$productID;
                        $WholeSales->wholeSale =$data[7];
                        $WholeSales->save();

                        /**
                         * Register RetailSale Price
                         */
                        $RetailSale = new RetailSale;
                        $RetailSale->product_id =$productID;
                        $RetailSale->retailSale =$data[8];
                        $RetailSale->save();
                    }
                }
            }
            
            $success_output = '从 Excel 导入产品成功完成！';
            $output = array(
                'error'     =>  $error_array,
                'success'   =>  $success_output
            );

            echo json_encode($output);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }

    }
}