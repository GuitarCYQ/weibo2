<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
           'content'    =>  'required|max:140'
        ]);

        //Auth:user()可以获取当前用户的实例
        Auth::user()->statuses()->create([
            'content'   =>  $request['content']
        ]);
        session()->flash('success','发表成功！');
        return redirect()->back();
    }

    public function destroy(Status $status)
    {
        //authorize删除授权的检测
        $this->authorize('destroy',$status);
        $status->delete();
        session()->flash('success','微博已被成功删除！');
        return redirect()->back();
    }
}
