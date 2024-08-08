<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Address;
use Exception;

class AddressController extends Controller
{
    public function list(Request $request)
    {
        try {
            $addresses = Address::select('id', 'name', 'phone', 'email_number', 'area_name', 'building_name', 'created_at', 'is_verified', 'freight')
                                ->where('user_id', $request->user->id)
                                ->where('is_verified', '!=', 0)
                                ->get();

            return response()->json(['message'=>'Address List Successful','data'=>$addresses],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $address = Address::select('name', 'phone', 'email_number', 'area_name', 'building_name', 'is_verified', 'freight')
                            ->where('user_id', $request->user->id)
                            ->where('id', $id)
                            // ->where('is_verified', '1')
                            ->get();

            return response()->json(['message'=>'Address Successful','data'=>$address],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }

    }

    public function addressphone(Request $request)
    {
        try {
            $phone = Address::where('phone', $request->phone)->first();
            if ($phone) {
                return response()->json(['message'=> 'Phone is already', 'data'=>$phone->identification], 200);
            } else {
                $address = new Address;
                $address->user_id = $request->user->id;
                $address->phone = $request->phone;
                $otp = rand(100000, 999999);
                $address->identification = $otp;
                $address->save();

                return response()->json(['message'=>'Return SignNumber','data'=>$address->identification],200);
            }

        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function addresssign(Request $request)
    {
        try {
            $sign = Address::where('identification', $request->sign)->first();

            if ($sign) {
                return response()->json(['message'=>'Sign is correct','phone'=>$sign->phone],200);
            } else {
                return response()->json(['message'=>'Sign is incorrect'],400);
            }
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $address = Address::where('phone', $request->phone)->first();

            // $address = Address::where('user_id', $request->user->id)->first();
            if ($address) {
                $address->name = $request->name;
                $address->email_number = $request->email_number;
                $address->area_name = $request->area_name;
                $address->building_name = $request->building_name;
                $address->is_verified = '1';
                $address->delivery_type = $request->delivery_type;
                $address->save();

                return response()->json(['message'=>'Address is successful','data'=>$address],200);
            } else {
                return response()->json(['message'=>'Unsigned'],400);
            }
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $address = Address::where('id', $id)
                            ->where('phone', $request->phone)
                            ->where('is_verified', '1')->first();

            if ($address) {
                $address->name = $request->name;
                $address->email_number = $request->email_number;
                $address->area_name = $request->area_name;
                $address->building_name = $request->building_name;
                $address->is_verified = '1';
                $address->save();

                return response()->json(['message'=>'Address is Updated','data'=>$address],200);
            } else {
                return response()->json(['message'=>'Cannot Update'],400);
            }

        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function readstatus(Request $request)
    {
        try {
            $unread = Address::where('user_id', $request->user->id)->where('is_verified', '2')->where('read', '0')->first();
            if ($unread) {
                return response()->json(['message'=>'Address Signed', 'data'=>$unread],200);
            } else {
                return response()->json(['message'=>'No Address Signed', 'data'=>$unread],200);
            }
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }

    public function setread(Request $request)
    {
        try {
            Address::where('id', $request->id)->update(['read'=>'1']);
            return response()->json(['message'=>'Address read'],200);
        } catch (Exception $err) {
            return response()->json($err, 500);
        }
    }
}
