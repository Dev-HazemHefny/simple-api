<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    //
    public function login(Request $request)
    {
        try{
            $rules =[
                'email'=>'required|email',
                'password'=>'required',
            ];
            $validator =Validator::make($request->all(),$rules);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422); // 422 Unprocessable Entity for validation errors
            }
            $credentials = $request->only(['email','password']);
            $token = Auth::guard("api")->attempt($credentials);
            if (!$token) {
                return response()->json([
                    'message' => 'Invalid email or password',
                    'status' => false
                ], 401); // 401 Unauthorized
            }

            $user =Auth::guard("api")->user();
            $user->token =$token;
            return response()->json(["msg"=>$user]);
        }catch(\Exception $e){
            return $e->getMessage();
        }
        // return response()->json(["msg" => "not found"]);
    }
    public function register(Request $request)
    {
        $rules =[
            'name'=>'required|string|max:255',
            'email'=>'required|email|string|max:255|unique:users',
            'password'=>'required|string|min:6',
        ];
        $validator =Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity for validation errors
        }
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        if($user)
        {
            return $this->login($request);
        }
        return response()->json([
            'message' => 'Register Error',
            'status' => false
        ]); // 401 Unauthorized
    }
    public function logout(Request $request)
    {
    try{
        JWTAuth::invalidate($request->token);
        return response()->json([
            'message' => 'Success',
        ]);
    }catch(JWTException $E){
        return response()->json([
            'message' => $E->getMessage(),
        ]);
    }        
    }
    public function refresh(Request $request)
    {
        $new_token = JWTAuth::refresh($request->token);
        if($new_token){
            return response()->json([
                'message' => $new_token
            ]);
        }
        return response()->json(['message' =>'Error']);
    }
}
