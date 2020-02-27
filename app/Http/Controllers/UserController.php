<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    //
    public function setting()
    {

        return view('user.settingView');
    }

    public function settingStore(Request $request)
    {
        //验证

        $this->validate(request(),[
            'name' => 'required|min:3|max:10'
        ]);



        //逻辑

        $user = \Auth::user();
        $name = request('name');

        if($name != $user->name){
            if(User::where('name',$name)->count() > 0){
                return redirect()->back()->withErrors('该用户名已经被注册');
            }

            $user->name = $name;
        }
        $user->avatar = '/storage/'.$request->file('avatar')->storePublicly($user->id);
        $user->save();


        //渲染

        return redirect()->back();


    }
}
