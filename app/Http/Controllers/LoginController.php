<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function login()
    {
        if(\Auth::check()){
            return redirect('/posts');
        }
        return view('login.loginView');
    }

    public function loginStore()
    {

        //验证
        $this->validate(request(),[
            'email' => 'required|email',
            'password' => 'required|min:6',
            'is_remember' => 'integer'
        ]);

        //逻辑
        $email = request('email');
        $password = request('password');

        $is_remember = boolval(request('is_remember'));

        if(\Auth::attempt(['email'=>$email,'password'=>$password],$is_remember)){

            return redirect('/posts');
        }

        //渲染
        return redirect()->back()->withErrors('邮箱或密码不正确');
    }

    public function logout()
    {
        \Auth::logout();

        return redirect('/login');
    }
}
