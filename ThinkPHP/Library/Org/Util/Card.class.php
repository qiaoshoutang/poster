<?php
//header("Content-type: text/html; charset=utf-8");


/**
* 作者：山猫 http://shanmao.me 
* 2015-6-22
* 传入参数： C('APPID')  C('SCRETID')
* 
* 
* 使用 
* $card = new \Org\Util\Card(C('APPID'),C('SCRETID'));
		$cardid = 'pYKCus3ae8VZBONzrtZxBydVNFqI';
		$cardimgurl = $card->getcardewm($cardid);

* 
* 
* 
* //html5 js api 卡卷投放  URL参数必须带  &wechat_card_js=1
		$card = new \Org\Util\Card('wx374******2a3ae8','6854f901ef86******84c34f9a3');
		$cardid = 'pYKCus4Tmp_sBh6eiqfG-hN_ySzc';
		$data['card_id']=$cardid;
		$data['code']='';
		$data['openid']='';
		$data2 = $card->get_h5_card($data);
		$this->assign('carddata',json_encode($data2));//输出到前台
		//dump(($data2));
		$this->siteDisplay ( 'card' );
		* 
		* 
		* 
		* 以下是前台js
<script>
var readyFunc = function onBridgeReady() {
document.querySelector('#batchAddCard').addEventListener('click',
function(e) {
WeixinJSBridge.invoke('batchAddCard', {
"card_list": [
{$carddata}//后台输出的
]
},
function(res) {

});
}); }
if (typeof WeixinJSBridge === "undefined") {
document.addEventListener('WeixinJSBridgeReady', readyFunc, false);
} else {
readyFunc(); }
</script>
		* 
		* 
		* 
* 
*/





namespace Org\Util;







class Card
{
	
private  $appid;
private  $appsecret;	
	
	
 function __construct($appid,$appsecret)
{
		
$this->appid = $appid;
$this->appsecret = $appsecret;
}	
	
	


public function createcard(){//新建卡卷
	$appid=$this->appid;
     	 $appsecret=$this->appsecret;
		$asstonek = $this->get_token($appid,$appsecret);
		$url = "https://api.weixin.qq.com/card/create?access_token=".$asstonek;
		$pjson ='{ "card": {
"card_type": "GROUPON",
"groupon": {
"base_info": {
"logo_url":
"http://mmbiz.qpic.cn/mmbiz/ibkgH5qOticpLRCYTKmibPW028nOv2YYg42UsK8MWV5fVLRUUTrNyrg3nJgxThaP9tNg1JZXHk88FdLqxmmNq4CHg/0?wx_fmt=jpeg",
"brand_name":"海底捞123",
"code_type":" CODE_TYPE_TEXT ",
"title": "132 元双人火锅套餐",
"sub_title": "",
"color": "Color010",
"notice": "使用时向服务员出示此券",
"service_phone": "020-88888888",
"description": "不可与其他优惠同享\n 如需团购券发票， 请在消费时向商户提出\n 店内均可
使用，仅限堂食\n 餐前不可打包，餐后未吃完，可打包\n 本团购券不限人数，建议 2 人使用，超过建议人
数须另收酱料费 5 元/位\n 本单谢绝自带酒水饮料",
"date_info": {
"type": 2,
"fixed_term": 30,
"fixed_begin_term": 0
},
"sku": {
"quantity": 500000
},
"get_limit": 3,
"use_custom_code": false,
"bind_openid": false,
"can_share": true,
"can_give_friend": true,
"location_id_list" : [123, 12321, 345345],
"custom_url_name": "立即使用",
"custom_url": "http://www.qq.com",
"custom_url_sub_title": "6 个汉字 tips",
"promotion_url_name": "更多优惠",
"promotion_url": "http://www.qq.com",
"source": "大众点评"
},
"deal_detail": "以下锅底 2 选 1（有菌王锅、麻辣锅、大骨锅、番茄锅、清补凉锅、酸菜鱼锅可
选）：\n 大锅 1 份 12 元\n 小锅 2 份 16 元\n 以下菜品 2 选 1\n 特级肥牛 1 份 30 元\n 洞庭鮰鱼卷 1 份
20 元\n 其他\n 鲜菇猪肉滑 1 份 18 元\n 金针菇 1 份 16 元\n 黑木耳 1 份 9 元\n 娃娃菜 1 份 8 元\n 冬
瓜 1 份 6 元\n 火锅面 2 个 6 元\n 欢乐畅饮 2 位 12 元\n 自助酱料 2 位 10 元"}
}
}';


$re3 = $this->curlp($url,$pjson);
		$re3arr = json_decode($re3,true);
		dump($re3arr);
	
	}	
	
	
	
	
	

public function get_h5_card($data=array()){
	$appid=$this->appid;
    $appsecret=$this->appsecret;
	$asstonek = $this->get_token($appid,$appsecret);		
	$ticket = $this->get_card_ticket($asstonek);
	$data['api_ticket']=$ticket;
	$data['timestamp']=time();
	$data['signature'] = self::getSign($data);	
	//echo $ticket;
	$data2['card_id']=$data['card_id'];
	unset($data['api_ticket']);
	unset($data['card_id']);
	$data2['card_ext']=json_encode($data);
	return $data2;
	dump($data);
}	
	
	
	
public function getcardewm($cardid){//获取卡卷二维码
		$appid=$this->appid;
     	$appsecret=$this->appsecret;
		$asstonek = $this->get_token($appid,$appsecret);		
		//$ticket = $this->get_card_ticket($asstonek);
		$url2 = "https://api.weixin.qq.com/card/qrcode/create?access_token=".$asstonek;
		$fcardjson = '{
"action_name": "QR_CARD",
"action_info": {
"card": {
"card_id": "'.$cardid.'",
"is_unique_code": false ,
}
}
}';
$re2 = $this->curlp($url2,$fcardjson);
$re2arr = json_decode($re2,true);
$ewmticket = $re2arr['ticket'];
if($re2arr['errmsg']!='ok') exit($re2arr['errmsg']);
return 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$ewmticket; //二维码图片链接

dump($re2arr);
echo '<img src="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$ewmticket.'">';
}
	
	
	function get_token($appid,$appsecret){
	//if(S('access_tokens')) return S('access_tokens');
	if($_COOKIE['access_tokens']) return $_COOKIE['access_tokens'];
	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
        $ret_json = $this->curl_get_contents($url);
        $ret = json_decode($ret_json);
       // dump($ret);
        if($ret -> access_token){ 
        setcookie('access_tokens',$ret -> access_token,time()+3600);       	        	
			//S('access_tokens',$ret -> access_token,3600);
			return $ret -> access_token;
			}
}	
	
	function get_card_ticket($asstonek){
//	if(S('card_ticket')) return S('card_ticket');
if($_COOKIE['card_ticket']) return $_COOKIE['card_ticket'];
	if(!$asstonek) return 'assess token error';
	$ticket = $this->curl_get_contents("https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$asstonek."&type=wx_card");
	 $ret = json_decode($ticket);
        if($ret -> ticket){
			//S('card_ticket',$ret -> ticket,3600);
			setcookie('card_ticket',$ret -> ticket,time()+3600);
			return $ret -> ticket;
			}
}
	

	function trimString($value)
	{
		$ret = null;
		if (null != $value) 
		{
			$ret = $value;
			if (strlen($ret) == 0) 
			{
				$ret = null;
			}
		}
		return $ret;
	}
	
	/**
	 * 	作用：产生随机字符串，不长于32位
	 */
	public function createNoncestr( $length = 32 ) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
		$str ="";
		for ( $i = 0; $i < $length; $i++ )  {  
			$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
		}  
		return $str;
	}
	
	/**
	 * 	作用：格式化参数，签名过程需要使用
	 */
	function formatBizQueryParaMap($paraMap, $urlencode)
	{
		$buff = "";
		//ksort($paraMap);
		foreach ($paraMap as $k => $v)
		{
		    if($urlencode)
		    {
			   $v = urlencode($v);
			}
			//$buff .= strtolower($k) . "=" . $v . "&";
			$buff .= $v;
		}
		$reqPar;
		if (strlen($buff) > 0) 
		{
			//$reqPar = substr($buff, 0, strlen($buff)-1);
		}
		return $buff;
	}
	
	/**
	 * 	作用：生成签名
	 */
	public function getSign($Obj)
	{
		foreach ($Obj as $k => $v)
		{
			$Parameters[] = $v;
			//echo $v."<br>";
		}
		
		//签名步骤一：按字典序排序参数
		usort($Parameters,"strcmp");
		$String = $this->formatBizQueryParaMap($Parameters, false);
		//echo $String;
		return sha1($String);
	}
	



	
public function curl_get_contents($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 200);
    curl_setopt($ch, CURLOPT_USERAGENT, _USERAGENT_);
    curl_setopt($ch, CURLOPT_REFERER, _REFERER_);
    @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $r = curl_exec($ch);
    curl_close($ch);
    return $r;
}

public function curlp($post_url,$xjson){//php post
	$ch = curl_init($post_url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS,$xjson);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'Content-Type: application/json',
	'Content-Length: ' . strlen($xjson))
	);
	$respose_data = curl_exec($ch);
	return $respose_data;
	}

	
	
	
	
	

}


?>