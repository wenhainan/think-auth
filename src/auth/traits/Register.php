<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

namespace yunwuxin\auth\traits;

use yunwuxin\auth\interfaces\Authenticatable;
use think\exception\ValidateException;
use think\Request;
use think\Response;
use think\Validate;

trait Register
{

    /**
     * 注册页面
     * @return \think\response\View
     */
    public function showRegisterForm()
    {
        if (auth()->user()) {
            return redirect($this->redirectPath());
        }

        return view('auth/register');
    }

    public function register(Request $request)
    {
        $this->validate($request);
        $user = $this->create($request);
        auth()->login($user);
        return $this->registered($user)
            ?: redirect($this->redirectPath());
    }

    /**
     * 注册成功后的跳转地址
     * @return string
     */
    protected function redirectPath()
    {
        return '/';
    }

    /**
     *
     * @param Authenticatable $user
     * @return Response
     */
    protected function registered(Authenticatable $user)
    {

    }

    /**
     * @param Request $request
     * @return Authenticatable
     */
    protected function create(Request $request)
    {

    }

    /**
     * 生成验证器
     * @param Request $request
     * @return Validate
     */
    protected function validator(Request $request)
    {
        return Validate::make()->batch(true);
    }

    /**
     * 验证
     * @param Request $request
     */
    protected function validate(Request $request)
    {
        $validator = $this->validator($request);

        if (!$validator->check($request->param())) {
            throw new ValidateException($validator->getError());
        }
    }
}