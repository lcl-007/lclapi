{{-- @component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent --}}
<h3>邮箱验证码是{{$code}}</h3>
<h3>验证码15分钟内有效，请及时使用</h3>
