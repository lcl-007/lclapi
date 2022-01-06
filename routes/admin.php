<?php
/*

 * @FilePath: \shopapi\routes\admin.php
 */

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\GoodsController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\UserController;

    $api = app('Dingo\Api\Routing\Router');

    $params = ['middleware'=>
    ['api.throttle',//访问节流器（1分钟可以登录60次）
    'binding',//路由模型注入
    'serializer:array'],//减少transformer的data包裹层
    'limit' => 60,
    'expires' => 1];

    //api.throttle (中间件)訪問節流

    $api->version('v1',$params,function($api){
        $api->group(['prefix'=>'admin'],function($api){
    //需要登陸的路由
    $api->group(['middleware'=>['api.auth','check.permission']],function($api){
    /**
     * 用户管理
     */
    //禁用用户/启用用户
    $api->patch('users/{user}/lock',[UserController::class,'lock'])->name('users.lock');
    //用户管理资源路由
    $api->resource('users',UserController::class,[
        'only'=>['index','show']
    ]);
    /**
     * 分类管理
     */
    //分类禁用和启用
    $api->patch('category/{category}/status',[CategoryController::class,'status'])->name('category.status');
    //分类管理资源路由
    $api->resource('category',CategoryController::class,
    ['except'=>['destroy']
    ]);

    /**
     * 商品管理
     */
    //是否上架
    $api->patch('goods/{good}/on',[GoodsController::class,'isOn'])->name('goods.on');

    //是否推荐
    $api->patch('goods/{good}/recommend',[GoodsController::class,'isRecommend'])->name('goods.recommend');

     //商品管理资源路由
    $api->resource('goods',GoodsController::class,
    ['except'=>['destroy']
    ]);

    /**
     * 评价管理
     */
    $api->get('comments',[CommentController::class,'index'])->name('comments.index');
    //评价详情
    $api->get('comments/{comment}',[CommentController::class,'show'])->name('comments.show');
    //回复评价
    $api->patch('comments/{comment}/reply',[CommentController::class,'reply'])->name('comments.reply');

     /**
     * 订单管理
     */
    //订单列表
    $api->get('orders',[OrderController::class,'index'])->name('order.index');
    //订单详情
    $api->get('orders/{order}',[OrderController::class,'show'])->name('order.show');
    //订单发货
    $api->patch('orders/{order}/post',[OrderController::class,'post'])->name('order.post');
    /**
     * 轮播图管理
     * */
    $api->resource('slides',SlideController::class);
    /**
     * 排序
     */
    $api->patch('slides/{slide}/seq',[SlideController::class,'seq'])->name('slides.seq');
    /**
     * 轮播图禁用和启用
     */
    $api->patch('slides/{slide}/status',[SlideController::class,'status'])->name('slides.status');
    /**
     * 菜单管理
     */
    $api->get('menus',[MenuController::class,'index'])->name('menus.index');

    });
    });
});

