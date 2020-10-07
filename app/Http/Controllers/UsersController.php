<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',[
            //除了此处指定的动作以外 其他的动作都必须登录才可以访问
           'except' =>  ['show','create','store']
        ]);

        //只允许未登录的访问
        $this->middleware('guest',[
           'only'   =>  ['create']
        ]);
    }

    public function index()
    {
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        //注册成功后自动登录
        Auth::login($user);
        
        session()->flash('success','欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show',[$user]);
    }

    public function edit(User $user)
    {
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $this->authorize('update',$user);
        $this->validate($request,[
            'name'  =>  'required|max:50',
            'password'  =>  'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password){
            $data['password'] = bcrypt($request->passowrd);
        }
        $user->update($data);

        session()->flash('success','个人资料更新成功！');

        return redirect()->route('users.show',$user);
    }
}
