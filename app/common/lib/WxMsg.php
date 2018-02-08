<?php
namespace common\lib;

class WxMsg
{

    public static function getAccessToken()
    {
        $api = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . \Yii::$app->params['wechat']['appid'];
        $api .= "&secret=" . \Yii::$app->params['wechat']['secret'];
        // echo $api;
        $rs = HttpGet::http_get($api);
        $rs = json_decode($rs);
        if (null != $rs->access_token) {
            return [
                'token' => $rs->access_token
            ];
        } else {
            return [
                'message' => 'access_token获取失败'
            ];
        }
    }

    public static function sendSolveRs($message, $touser)
    {
        $access_token = self::getAccessToken(); //return var_dump($access_token);
        if (null != $token = $access_token['token']) {
            $api = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=";
            $api .= $token;
            
            
            $data = [
                'touser' => $touser,
                'msgtype' => 'text',
                'text' => [
                    'content' => $message
                ]
            ];
            $data=json_encode($data,JSON_UNESCAPED_UNICODE);
            /* $snoopy=new Snoopy();
            $rs=$snoopy->submit($api,$data) */;
            $rs=HttpGet::http_get($api,$data);
            $rs=json_decode($rs);
            if(0==$rs->errcode) {
                //echo $rs->errmsg;
                return true;
            } else {
                return false;
            }
            //var_dump($rs);
        } else {
            return  $access_token;
        }
    }
}

