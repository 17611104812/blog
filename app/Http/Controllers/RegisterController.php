<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class RegisterController extends Controller
{
    //
    //
    public function register()
    {
        return view('register.registerView');
    }

    public function registerStore()
    {

        //验证
        $this->validate(request(),[
            'name' => 'required|unique:users|min:3|max:10',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6|confirmed',
        ]);


        //逻辑
        $name = request('name');
        $email = request('email');
        $password = bcrypt(request('password'));
        User::create(compact('name','email','password'));


        //渲染
        return redirect('/login');
    }
}
