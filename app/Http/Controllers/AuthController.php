<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\JResponse;
use App\User;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller{

  private $expirationTime = 300;

  public function authenticate(Request $request){
      if($request->has('email')){
          $credentials = $request->only('email', 'password');
      }else{
          $credentials = $request->only('username', 'password');
      }
      try{
          if(!$token = JWTAuth::attempt($credentials)){
              return response()->json(JResponse::set(false, 'invalid credentials'), 401); //,401
          }
      }catch(JWTException $e){
          return response()->json(JResponse::set(false, 'could not create token'), 500); //,500
      }
      return response()->json(
          JResponse::set(true,'Token successfully created', ['token' => $token,
                                                             'ttl' => $this->expirationTime,
                                                             'user' => JWTAuth::toUser($token)
                                                           ]), 200);
  }

  public static function getUserFromToken($token){
      $user = JWTAuth::toUser($token);
      return $user;
  }
}
