<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(){
      return "login";
    }

    public function register(){
      return "register";
    }

    public function logout(){
      return "logout";
    }
}
