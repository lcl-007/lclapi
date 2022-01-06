<?php

namespace App\Http\Controllers\Auth;

use App\Events\SendSms;
use App\Http\Controllers\BaseController;
use App\Mail\SendCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;



class BindController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['check.phone.code'])->only(['updatePhone']);
        $this->middleware(['check.email.code'])->only(['updateEmail']);

    }

    /**
     * 获取邮件验证码
     */
   public function emailCode(Request $request)
   {
    $request->validate([
        'email'=>'required|email|unique:users'
    ]);
    //发送验证码到邮件

    Mail::to($request->input('email'))->queue(new SendCode($request->input('email')));
    return $this->response->noContent();
}

    /**
     * 更新邮箱
     */
    public function updateEmail(Request $request){

        $request->validate([
            'email'=>'unique:users'
        ]);
        //更新邮箱
        $user = auth('api')->user();
        $user->email = $request->input('email');
        $user->save();
        return $this->response->noContent();
    }
/**
 * 获取手机验证码
 */
    public function phoneCode(Request $request)
    {   //验证手机号
        $request->validate(['phone'=>'required|regex:/^1[3-9]\d{9}$/|unique:users']);
        //发送短信事件
        SendSms::dispatch($request->input('phone'),'绑定手机');

return $this->response->noContent();
    }
/**
 * 更新手机
 */
    public function updatePhone(Request $request)
    {
        $request->validate([
            'email'=>'unique:users'
        ]);
        //更新手机号
        $user = auth('api')->user();
        $user->phone = $request->input('phone');
        $user->save();
        return $this->response->noContent();
    }
}
