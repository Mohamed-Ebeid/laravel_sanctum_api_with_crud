<?php

namespace App\Http\Controllers\api;
use Illuminate\Support\Facades\Auth;

use App\Traits\HttpResponses;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
  use HttpResponses;

    public function login(LoginUserRequest $request){
      $request->validated($request->all());

      if (!User::where('email', $request->email )->exists()) {
        return $this->error('', 'This email does not exists', 404);
      }
      
      if(!Auth::attempt($request->only(['email','password']))){
        return $this->error('', 'Credentional do not match', 401);
      }

      $user = User::where('email', $request->email)->first();

      return $this->success([
        'user'=> $user,
        'token'=> $user->
          createToken('API token of '. $user->name)->plainTextToken
      ]);
    }



    public function register(StoreUserRequest $request){
      $request->validated($request->all());
      
      $user = User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>Hash::make($request->password)
      ]);
      return $this->success([
        'user'=> $user,
        'token'=> $user->
          createToken('API token of '. $user->name)->plainTextToken
      ]);
    }

    public function logout(){
      return "logout";
    }
}
