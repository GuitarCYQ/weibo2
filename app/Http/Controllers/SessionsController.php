<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        //只允许未登录的访问此功能
        $this->middleware('guest',[
           'only' => ['create']
        ]);
    }


    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request,[
            'email' =>  'required|email|max:255',
            'password'  =>  'required'
        ]);

        if (Auth::attempt($credentials,$request->has('remember'))){
            session()->flash('success','欢迎回来!');
            $fallback = route('users.show',Auth::user());
            //intended 方法，该方法可将页面重定向到上一次请求尝试访问的页面上，并接收一个默认跳转地址参数，当上一次请求记录为空时，跳转到默认地址上。
            return redirect()->intended($fallback);
        }else{
            session()->flash('danger','很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
    }

    public function destory()
    {
        Auth::logout();
        session()->flash('success','您已成功退出');
        return redirect('login');
    }

}
