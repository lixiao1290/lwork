<?php
namespace common\lib;
class HttpGet
{
	public static function msg($msg=array())
	{
		echo isset($msg['status'])
		?($msg['status']!=0
			?'<div class="alert alert-error"><button data-dismiss="alert" class="close" type="button">×</button><strong>注意：</strong> '.$msg['desc'].'</div>'
			:'<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">×</button>'.$msg['desc'].'</div>'
			):'';
	}
	
	
	/**
	 * curl发起http请求
	 * @param  [type]  $url         [description]
	 * @param  string  $args        [description]
	 * @param  string  $method      [description]
	 * @param  boolean $cookiejar   [description]
	 * @param  boolean $cookiefrash [description]
	 * @return [type]               [description]
	 */
	public static function http_get($url,$args='',$method='post',$cookiejar=false,$cookiefrash=false,$header=null)
	{
	   
		if($method=='get')
		{
			if(is_array($args))
			{
				foreach($args as $k=>$v)
					$url.='&'.$k.'='.urlencode($v);
			}
			else
				$url.='?'.$args;
		}
//		echo $url;die;
		$ch = curl_init($url);
		if($cookiejar)
		{
			if($cookiefrash)
				curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiejar);
			else
				curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiejar);
		}
		if($header)
		{
//		   var_dump($header);
		    curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
		 //   curl_setopt($ch, CURLOPT_HEADER, 1);
		}
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_FAILONERROR, 0);
	
		if($method=='post')
		{
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
		}
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);

		$response = curl_exec($ch);
//		var_dump($response);die;
		curl_close($ch);
		return $response;
	}
	
	//获取params
	public static function  get_params($paramsName,$paramsPsw,$num,$type = 0,$status)
	{
	   $params = array();
	    $params = [
	          "paramsName" => $paramsName,
	          "paramsPsw"  => $paramsPsw,
	          "paramsTime" => strtotime("now"),
	    ];
	    if(2 == $status)
	    {
	        $params["type"] = $type;
	        $params["userId"] = $num;
	    }elseif (1 == $status)
	    {
	        $params["pushId"] = $num;
	    }
	    return $params;
	}
	
	//获取头部信息
	public static function  get_headers($headerk,$headers)
	{
	    $push_headers = [
	        "headerk" => $headerk,
	        "headers" => $headers,
	        "Content-type" => "application/x-www-form-urlencoded"
	    ];
	    $headerArray = array();
	     foreach ($push_headers as $n =>$k)
	     {
	        $headerArray[] = $n.":".$k;
	     }
	    return $headerArray;
	}
	
	
	/**
	 * 对象数组转为普通数组
	 *
	 * AJAX提交到后台的JSON字串经decode解码后为一个对象数组，
	 * 为此必须转为普通数组后才能进行后续处理，
	 * 此函数支持多维数组处理。
	 *
	 * @param array
	 * @return array
	 */
  public static function objarray_to_array($obj) {
	    $ret = array();
	    foreach ($obj as $key => $value) {
	        if (gettype($value) == "array" || gettype($value) == "object"){
	            $ret[$key] =  objarray_to_array($value);
	        }else{
	            $ret[$key] = $value;
	        }
	    }
	    return $ret;
	}
	
}

class PicWordMessage
{
}
use callmez\wechat\components\AdminController;

class PicMsg extends AdminController
{
}
