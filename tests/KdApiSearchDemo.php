<?php
/**
 * @技术QQ群: 可登录官网https://www.kdniao.com/右侧查看技术群号
 * @see: https://kdniao.com/api-track
 * @copyright: 深圳市快金数据技术服务有限公司
 * ID和Key请到官网申请：https://kdniao.com/reg



 * 即时查询接口
 * 此接口用于向快递公司实时查询物流轨迹信息。该功能支持情况需查看技术文档。
 * 正式地址：https://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx
 *
 *
 * 系统级参数
 * RequestData	   String	R	请求内容为JSON格式 详情可参考接口技术文档：https://www.kdniao.com/documents
 * EBusinessID	   String	R	用户ID
 * RequestType	   String	R	请求接口指令
 * DataSign	       String	R	数据内容签名，加密方法为：把(请求内容(未编码)+ApiKey)进行MD5加密--32位小写，然后Base64编码，最后进行URL(utf-8)编码
 * DataType	       String	R	DataType=2，请求、返回数据类型均为JSON格式


 * 应用级参数
 * R-必填（Required），O-可选（Optional），C-报文中该参数在一定条件下可选（Conditional）
 * OrderCode	  String(30)	O	订单编号
 * ShipperCode	  String(10)	R	快递公司编码  详细编码参考《快递鸟接口支持快递公司编码.xlsx》 https://www.kdniao.com/documents
 * LogisticCode	  String(30)	R	快递单号
 * CustomerName	  String(50)	C	ShipperCode为SF时必填，对应寄件人/收件人手机号后四位；ShipperCode为其他快递时，可不填或保留字段，不可传值

 * 请求示例
 * ZTO请求示例：
 * {
 * "OrderCode": "",
 * "ShipperCode": "ZTO",
 * "LogisticCode": "638650888018",
 * }
 *
 * JD请求示例：
 * {
 * "OrderCode": "",
 * "CustomerName": "",
 * "ShipperCode": "JD",
 * "LogisticCode": "JDVA00003618100",
 * }
 *
 * SF请求示例：
 * {
 * "OrderCode": "",
 * "CustomerName": "1234",
 * "ShipperCode": "SF",
 * "LogisticCode": "SF00003618100",
 * }
 */



//用户ID，快递鸟提供，注意保管，不要泄漏
defined('EBusinessID') or define('EBusinessID', '1237100');//即用户ID，登录快递鸟官网会员中心获取 https://www.kdniao.com/UserCenter/v4/UserHome.aspx 
//API key，快递鸟提供，注意保管，不要泄漏
defined('ApiKey') or define('ApiKey', '56da2cf8-c8a2-44b2-b6fa-476cd7d1ba17');//即API key，登录快递鸟官网会员中心获取 https://www.kdniao.com/UserCenter/v4/UserHome.aspx
//请求url，正式地址
defined('ReqURL') or define('ReqURL', 'https://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx');


$logisticResult = getOrderTracesByJson();
echo $logisticResult;


function getOrderTracesByJson(){
  // 组装应用级参数
	$requestData= "{".
    "'CustomerName': '',".
    "'OrderCode': '',".
    "'ShipperCode': 'YTO',".
    "'LogisticCode': 'YT00003618100',".
    "}";
  // 组装系统级参数
	$datas = array(
        'EBusinessID' => EBusinessID,
        'RequestType' => '1002', //免费即时查询接口指令1002/在途监控即时查询接口指令8001/地图版即时查询接口指令8003
        'RequestData' => urlencode($requestData) ,
        'DataType' => '2',
    );
    $datas['DataSign'] = encrypt($requestData, ApiKey);
  //以form表单形式提交post请求，post请求体中包含了应用级参数和系统级参数
	$result=sendPost(ReqURL, $datas);	
	
	//根据公司业务处理返回的信息......
	
	return $result;
}
 
/**
 *  post提交数据 
 * @param  string $url 请求Url
 * @param  array $datas 提交的数据 
 * @return url响应返回的html
 */
function sendPost($url, $datas) {
    $postdata = http_build_query($datas);
    $options = array(
      'http' => array(
        'method' => 'POST',
        'header' => 'Content-type:application/x-www-form-urlencoded',
        'content' => $postdata,
        'timeout' => 15 * 60 // 超时时间（单位:s）
      )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}

/**
 * 电商Sign签名生成
 * @param data 内容   
 * @param ApiKey ApiKey
 * @return DataSign签名
 */
function encrypt($data, $ApiKey) {
    return urlencode(base64_encode(md5($data.$ApiKey)));
}

?>