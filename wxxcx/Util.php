<?php

class Util{
	CONST APPID="wxeedae8f669591864";
	CONST APP_SECRET="729be3aceb162dceb1bc99956b35bf1c";
	public static function request($url, $is_https = true, $method = 'get', $data = null){
        $ch = curl_init();//初始化
        try {
            curl_setopt($ch, CURLOPT_URL, $url);//设置网址
            curl_setopt($ch, CURLOPT_HEADER, false);//设置头信息
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//只获取页面内容，但不输出
            if ($is_https) {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//不做服务器认证
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//不做客户端认证
            }
            if (strtolower($method) == 'post') {
                curl_setopt($ch, CURLOPT_POST, true);//设置请求方式为post
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//设置请求数据
            }

            $str = curl_exec($ch);//执行访问，返回结果
            curl_close($ch);//释放资源
//           echo date('Y-m-d H:m:i') . ': 获取token';
            return $str;
        }catch (\Exception $e){
            echo date('Y-m-d H:m:i'.':'.$e->getMessage());
        }

        $str = curl_exec($ch);//执行访问，返回结果
        curl_close($ch);//关闭curl，释放资源
        return $str;
    }
	
}