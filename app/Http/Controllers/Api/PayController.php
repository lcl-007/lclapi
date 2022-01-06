<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yansongda\LaravelPay\Facades\Pay;
class PayController extends BaseController
{
    public function pay(Request $request,Order $order)
    {
        $request->validate([
            'type'=>'required|in:aliyun,wechat'
        ],[
            'type.required'=>'支付类型不能为空',
            'type.in'=>'支付类型只能是 aliyun wechat',
        ]);

        //如果订单状态不是1，直接返回
        if ($order->status !=1) {
            return $this->response->errorBadRequest('订单状态异常');
        }
        if ($request->input('type')=='aliyun') {
            $order = [
                'out_trade_no' => $order->order_no,
                'total_amount' => $order->amount/100,
                'subject' => $order->goods->first()
                ->title . '等'.$order->goods()->count().'件商品',
            ];

            return Pay::alipay()->scan($order);
        }
        if ($request->input('type')=='wechat') {

        }
    }

    public function notifyAliyun(Request $request)
    {
        $alipay = Pay::alipay();
        try {
            $data = $alipay->verify();
            //判断支付状态
            if ($data->trade_status =='TRADE_SUCCESS'||$data->trade_status =='TRADE_FINISHED') {
                //查询订单
                $order = Order::where('order_no',$data->out_trade_no)->first();
                //更新订单
                $order->update([
                    'status'=>2,
                    'pay_type'=>'支付宝',
                    'pay_time'=>$data->gmt_payment,
                    'trade_no'=>$data->trade_no
                ]);
            }
            Log::debug("Alipay notify",$data->all());
        } catch (\Exception $e) {

        }
        return $alipay->success();
    }
/**
 * 轮询查询订单状态，看是否支付完成.
 * 注意：真实项目中使用广播系统会更好，也就是通过长链接通知客户端，支付完成。
 */
    public function payStatus(Order $order)
    {
        return $order->status;
    }
}
