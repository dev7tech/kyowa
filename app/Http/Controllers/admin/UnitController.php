<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Unit;
use Validator;
class UnitController extends Controller
{
    public function index()
    {
        try {
            $units = Unit::all();
            return view('unit',compact('units'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function list()
    {
        try {
            $units = Unit::all();
            return view('theme.unittable', compact('units'));
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(),[
                'name' => 'required',
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
                $unit = new Unit;
                $unit->name =$request->name;
                $unit->save();
                $success_output = 'Unit Add Successful';
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

    public function delete(Request $request)
    {
        try {
            $ids = $request->ids;
            foreach($ids as $id) {
                $unit = Unit::where('id', $id)->delete();
            }
            return 1;
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }
}
