<?php

namespace App\Facades\Express;
use Illuminate\Support\Facades\Http;
class Express
{
//商户ID
protected $EBusinessID;
//API KEY
protected $ApiKey;
//模式
protected $mode;

public function __construct()
{
    $config = config('express');
    $this->EBusinessID = $config['EBusinessID'];
    $this->ApiKey = $config['ApiKey'];
    $this->mode = $config['mode'] ?? 'product';

}

//即时查询快递足迹
public function track($ShipperCode,$LogisticCode){

        //准备请求参数
	$requestData= "{".
        "'CustomerName': '12344',".
        "'OrderCode': '',".
        "'ShipperCode': '{$ShipperCode}',".
        "'LogisticCode': '{$LogisticCode}',".
        "}";

        //发送请求
       $result= Http::asForm()->post(
           $this->url('track'),
           $this->formatReqData($requestData,1002));

        return $this->formatResData($result);
}

/**
 * 格式化请求参数
 */
protected function formatReqData($requestData,$RequestType)
{
    $datas = array(
        'EBusinessID' => $this->EBusinessID,
        'RequestType' => $RequestType, //免费即时查询接口指令1002/在途监控即时查询接口指令8001/地图版即时查询接口指令8003
        'RequestData' => urlencode($requestData) ,
        'DataType' => '2',
    );
    $datas['DataSign'] = $this->encrypt($requestData);
    return $datas;
}

/**
 * 格式化响应参数
 */
protected function formatResData($result)
{
    $result=json_decode($result,true);
    //Api服务器报错
    if ($result['Success']==false) {
        return $result['ResponseData'];
    }

    $result2 = json_decode($result['ResponseData'],true);
    //请求成功，但未请求到数据，请求的参数有问题
    if ($result2['Success']==false) {
        return $result2['Reason'];
    }
        return $result2;
}
/**
 * 返回api的url
 */
protected function url($type)
{
    $url = [
        'track'=>[
            'product'=>'',
            'dev'=>'http://www.kdniao.com/UserCenter/v2/SandBox/SandboxHandler.ashx?action=CommonExcuteInterface'
        ]
    ];
    return $url[$type][$this->mode];
}
 /**
 * 电商Sign签名生成
 *
 */
protected function encrypt($data) {
    return urlencode(base64_encode(md5($data.$this->ApiKey)));
}
}
