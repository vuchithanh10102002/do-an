<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;


class LoginController extends Controller
{
    public function login(){
        return view("page.login");
    }
}