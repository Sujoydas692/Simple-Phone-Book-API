<?php

namespace App\Http\Controllers;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use App\Models\PhoneBookModel;

class PhoneBookController extends Controller
{
    function onInsert(Request $request){

        $key = env('TOKEN_KEY');
        $token = $request->input('access_token');
        $decoded = JWT::decode($token, $key, array('HS256'));
        $decoded_array = (array)$decoded;
        $user = $decoded_array['user'];
        $one = $request->input('phone_number_one');
        $two = $request->input('phone_number_two');
        $name = $request->input('name');
        $email = $request->input('email');

        $result = PhoneBookModel::insert([
            'username'=>$user,
            'phone_number_one'=>$one,
            'phone_number_two'=>$two,
            'name'=>$name,
            'email'=>$email
        ]);

        if ($result==true){
            return response()->json(['Status'=>'Insert Success!']);
        }
        else{
            return response()->json(['Status'=>'Insert Fail!']);
        }
    }

    function onSelect(Request $request){
        $key = env('TOKEN_KEY');
        $token = $request->input('access_token');
        $decoded = JWT::decode($token, $key, array('HS256'));
        $decoded_array = (array)$decoded;
        $user = $decoded_array['user'];

        $result = PhoneBookModel::where('username',$user)->get();

        return $result;
    }

    function onDelete(Request $request){
        $key = env('TOKEN_KEY');
        $email = $request->input('email');
        $token = $request->input('access_token');
        $decoded = JWT::decode($token, $key, array('HS256'));
        $decoded_array = (array)$decoded;
        $user = $decoded_array['user'];

        $result = PhoneBookModel::where(['username'=>$user,'email'=>$email])->delete();

        if ($result==true){
            return response()->json(['Status'=>'Delete Success!']);
        }
        else{
            return response()->json(['Status'=>'Delete Fail!']);
        }
    }

    function onUpdate(Request $request){

        $key = env('TOKEN_KEY');
        $token = $request->input('access_token');
        $decoded = JWT::decode($token, $key, array('HS256'));
        $decoded_array = (array)$decoded;
        $user = $decoded_array['user'];
        $id = $request->input('id');
        $one = $request->input('phone_number_one');
        $two = $request->input('phone_number_two');
        $name = $request->input('name');
        $email = $request->input('email');

        $result = PhoneBookModel::where(['username'=>$user,'id'=>$id])
            ->update([
                'phone_number_one'=>$one,
                'phone_number_two'=>$two,
                'name'=>$name,
                'email'=>$email
            ]);

        if ($result==true){
            return response()->json(['Status'=>'Update Success!']);
        }
        else{
            return response()->json(['Status'=>'Update Fail!']);
        }
    }
}
