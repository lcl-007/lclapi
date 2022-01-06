<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * 用户个人信息
     */
    public function userInfo()
    {
        return $this->response->item(auth('api')->user(),new UserTransformer());
    }

    /**
     * 更新用户信息
     */
    public function updateUserInfo(Request $request)
    {
        $request->validate([
            'name'=>'required|max:16',
        ]);
        $user = auth('api')->user();
        $user->name = $request->input('name');
        $user->save();
        return $this->response->noContent();
    }

    /**
     * 更新用户头像
     */
    public function avatarUpdate(Request $request)
    {
        $request->validate([
            'avatar'=>'required',
        ]);
        $user = auth('api')->user();
        $user->avatar = $request->input('avatar');
        $user->save();
        return $this->response->noContent();
    }
}
