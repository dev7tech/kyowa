<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Servicetime;
use Validator;

class ServicetimeController extends Controller
{
    public function index()
    {
        $servicetime = Servicetime::first();
        return view('non_service_time',compact('servicetime'));
    }

    public function store(Request $request){
        try {
            return DB::transaction(function() use($request){
                $validation = Validator::make($request->all(),[
                    'startime' => 'required',
                    'endtime' => 'required',
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
                      $Servicetime = Servicetime::find($request->id);
                      if(!$Servicetime){
                        $Servicetime = new Servicetime;
                      }
                      $Servicetime->fromtime = $request->startime;
                      $Servicetime->totime = $request->endtime;
                      $Servicetime->save();

                      $success_output = 'Service Time Set Successful!';
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
}
?>