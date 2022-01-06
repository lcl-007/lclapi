
{{-- @component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent --}}
<p>您订单号为{{$order->order_no}}的订单已发货</p>

<h4>其中包含的商品为</h4>

<ul>
@foreach($order->orderDetails()->with('goods')->get() as $details )
    <li>{{$details->goods->title}},单价为:{{$details->price}},数量为:{{$details->num}}</li>
@endforeach
</ul>

<h5>总付款为:{{$order->amount}}</h5>

