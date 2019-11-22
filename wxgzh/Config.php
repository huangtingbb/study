<?php
namespace gzh;
/**
 * Created by PhpStorm.
 * User: lj
 * Date: 2019/1/30
 * Time: 10:36
 */
class Config{

    const APPID='wx5b83f9d3c0a59a89';
    const APPSERCT='583252b40cf8d34ff719950556383748';
    const TOKEN='ljstu';


    function __construct(){

    }

    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }


    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = self::TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr);
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    public function request($url, $is_https = true, $method = 'get', $data = null){
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

    function getToken()
    {
		$redis=new \Redis();
		$redis->connect('127.0.0.1','6379');
		$token=$redis->get(':wxToken');
		if($token==false){		
		$content = $this->request("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".self::APPID."&secret=".self::APPSERCT);
		$token=json_decode($content,true)['access_token'];
		$redis->setex(':wxToken',3600,$token);
		}
        return $token;
	}
   

    public function getTicket($expire_seconds,$type='temp',$scene=123){
        $data['action_info']=['scene'=>['scene_id'=>$scene]];
        if($type=="temp"){
            $data['expire_seconds']=$expire_seconds;
            $data['action_name']='QR_SCENE';

        }else{
            $data['action_name']="QR_LIMIT_SCENE";
        }
        $data=json_encode($data);
        return $this->request("https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$this->getToken(),true, "post", $data);
    }


    public function getQrCode($expire_seconds,$type='temp',$scene=123){
        $ret=$this->getTicket($expire_seconds,$type,$scene);
        $ret=json_decode($ret,true);
//        echo $ret['ticket'];
        $image=$this->request('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($ret['ticket']));
        header("Accept-Ranges:bytes");
        header("Cache-control:max-age=604800");
        header("Connection:keep-alive");
        header("Content-Length:".strlen($image));
        header("Content-Type:image/jpg");
        echo  $image;
//        $file='img1.jpg';
//        file_put_contents($file,$image);
//        return $image;
    }

    public function showImg($sence = 123){
        $img=$this->getQrCode(64800,'temp',$sence);
        header("Accept-Ranges:bytes");
        header("Cache-control:max-age=604800");
        header("Connection:keep-alive");
        header("Content-Length:".strlen($img));
        header("Content-Type:image/jpg");
        echo  $img;

    }

    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        if($postObj) {
            switch ($postObj->MsgType) {
                case 'text'  : $this->responseText($postObj) ; break; //处理文字消息
                case 'image' : $this->doutu($postObj) ; break; //处理图片消息,斗图
                case 'event' : $this->doEvent($postObj) ; break; //关注/取消关注事件
				case 'link'  : $this->responseLink($postObj) ; break ;
                default : echo "" ; break;
            }
        }
        exit();
    }

	private function responseLink($postObj){
		$fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $time = time();
      	$textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
					</xml>";
        $content=$postObj->Title."--".$postObj->Description;
		$resultStr=sprintf($textTpl,$fromUsername,$toUsername,$time,'text',$content);
		echo $resultStr;
		exit();
	}

    private function responseText($postObj,$text=''){
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $time = time();
        $msgType = "text";
        //关注没有Content属性
        if(property_exists($postObj,'Content'))
            $keyword = trim($postObj->Content);
        else $keyword='';
        $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
						</xml>";
        $contentStr = '';
        if($text=='') {
            if (!empty($keyword)) {
                if ($keyword == 'PHP') $contentStr = '我是做php开发的';
                else if ($keyword == '图文消息') $this->responseArticle($postObj);
                else $contentStr = $this->autoReply($keyword);
            } else {
                $contentStr = '欢迎关注刘锦的公众号！';
            }
        }else{
            $contentStr=$text;
        }
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
        echo $resultStr;
        exit();
    }

    //回复图片
    private function responseImg($postObj,$media_id=''){
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $time = time();
        $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Image>
							    <MediaId><![CDATA[%s]]></MediaId>
							</Image>
							<FuncFlag>0</FuncFlag>
						</xml>";
        $msgType = "image";
        if(!$media_id) {
            $media_id = $postObj->MediaId;
        }
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $media_id);
        echo $resultStr;

        exit();
    }

    public function doutu($postObj){
        //根据mediaID从微信服务器获取图片
        $imgPath=$this->getImgFromWx($postObj->MediaId);
        //解析图片中的文字信息
        $imgText=$this->pramsImg($imgPath);
        //如果解析文字失败
        if($imgText==false){
           // $this->responseText($postObj,'识别不了图片中的文字');
		   $imgText= '  ';
        }
        //根据文字信息获取自动回复消息
        $replyText=$this->autoReply($imgText);
        //根据文字信息获取表情
        $imgPath=$this->getImgByText($replyText);
        //将图片上传到微信服务器，返回MediaId
        $media_id=$this->uploadImgtoWx($imgPath);
        //将图片返回给用户
        $this->responseImg($postObj,$media_id);
    }

    //将微信服务器的图片下载到本地，返回路径
    public function getImgFromWx($media_id){
        $url="http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$this->getToken().'&media_id='.$media_id;
        //从用户那里接受的图片
        $path='./js.jpg';
        $imgStr=$this->request($url);
        fwrite(fopen($path,'w+'),$imgStr);
        return $path;
    }

    //解析图片中的文字信息
    public function pramsImg($imgPath){
        $data   = file_get_contents($imgPath);
        $base64 = base64_encode($data);
		//$base64=iconv($base64,'utf-8','gbk');
        $appkey = 'HhJToHkPUfwA0Acj';
        $params = array(
            'app_id'     => '2112119415',
            'image'      => $base64,
            'time_stamp' => strval(time()),
            'nonce_str'  => strval(rand()),
            'sign'       => '',
        );
        $params['sign'] = $this->getReqSign($params, $appkey);
        $url = 'https://api.ai.qq.com/fcgi-bin/ocr/ocr_generalocr';
        $result = $this->request($url, 1,'post',$params);
        $text='';
        $result=json_decode($result,true);
        print_r($result);
        if($result['ret']==0) {
            return $result['data']['item_list'][0]['itemstring'];
        }else{
            return false;
        }

    }

    // getReqSign ：根据 接口请求参数 和 应用密钥 计算 请求签名
// 参数说明
//   - $params：接口请求参数（特别注意：不同的接口，参数对一般不一样，请以具体接口要求为准）
//   - $appkey：应用密钥
// 返回数据
//   - 签名结果
    function getReqSign($params /* 关联数组 */, $appkey /* 字符串*/)
    {
        // 1. 字典升序排序
        ksort($params);

        // 2. 拼按URL键值对
        $str = '';
        foreach ($params as $key => $value)
        {
            if ($value !== '')
            {
                $str .= $key . '=' . urlencode($value) . '&';
            }
        }

        // 3. 拼接app_key
        $str .= 'app_key='.$appkey;

        // 4. MD5运算+转换大写，得到请求签名
        $sign = strtoupper(md5($str));
        return $sign;
    }

    //根据文字信息获取图片
    public function getImgByText($text){
		$text=(strlen($text)<=12)?$text.'表情':$text;
        $url="https://image.baidu.com/search/index?tn=baiduimage&ipn=r&ct=201326592&cl=2&lm=&st=-1&fm=result&fr=&sf=1&fmq=1551563295553_R&pv=&ic=&nc=1&z=&hd=&latest=&copyright=&se=1&showtab=0&fb=0&width=&height=&face=0&istype=2&ie=utf-8&word=".$text;
        $result=$this->request($url);
        $regex="/\"hoverURL\":\"\w\S*\"/";
        $imgArr=[];
        preg_match($regex,$result,$imgArr);
        return  $imgPath=str_replace('"','',substr($imgArr[0],strpos($imgArr[0],':')+1));
    }

    //将图片上传到微信服务器，返回MediaId
    public function uploadImgtoWx($imgPath){
        $type='image';
        $token=$this->getToken();
		echo $token;
        $url=$url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=".$token."&type=".$type;

        //图片地址
        if(strpos($imgPath,'http')!==false){
            $path='./tmp.jpg';
            $imgStr=$this->request($imgPath);
            fwrite(fopen($path,'w+'),$imgStr);
        }else{
            $path=$imgPath;
        }
        $data = ['media' => new \CURLFile($path)];
		$result=$this->request($url,1,'post',$data);
	
        $result =  json_decode($result,true);
		return $result['media_id'];
    }

    public function responseArticle($postObj){
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $time = time();
        $textTpl="<xml>
                     <ToUserName><![CDATA[%s]]></ToUserName>
                     <FromUserName><![CDATA[%s]]></FromUserName>
                     <CreateTime>%s</CreateTime>
                     <MsgType><![CDATA[news]]></MsgType>
                     <ArticleCount>1</ArticleCount>
                     <Articles>
                        <item>
                            <Title><![CDATA[%s]]></Title>
                            <Description><![CDATA[%s]]></Description>
                            <PicUrl><![CDATA[%s]]></PicUrl>
                            <Url><![CDATA[%s]]></Url>
                        </item>
                    </Articles>
                  </xml>";
        $resultStr=sprintf($textTpl,$fromUsername,$toUsername,$time,'图文消息标题','这是一个图文消息','http://47.107.44.128/wxgzh/bg.jpg','www.baidu.com');
        echo $resultStr;
    }

    public  function autoReply($keyword){
        $data = '{
            "reqType":0,
            "perception": {
                "inputText": {
                    "text":"'.$keyword.'"
                },  
            },
            "userInfo": {
                "apiKey": "9ba79d0d8b444bddb15532ca2b6d0fd3",
                "userId": "123456"
             }
        }';

        $result=$this->request('http://openapi.tuling123.com/openapi/api/v2',false,'post',$data);
        $result=json_decode($result,true);
        return   $result['results'][0]['values']['text'];

    }

    //推送事件处理
    private function doEvent($postObj){
		file_put_contents('./click.log',json_encode($postObj));	
        switch ($postObj->Event){
            case 'subscribe' : $this->dealscan($postObj);$this->responseText($postObj); break ;//关注回复
            case 'unsubscribe' : $this->unSubscribe($postObj) ; break ; //取消关注
            case 'CLICK' : $this->menuClick($postObj) ; break ;//菜单点击事件
			case 'SCAN' :$this->dealScan($postObj);break;//扫码事件
        }
    }

	//扫码事件
	private function dealScan($postObj){
		$fp = fopen('./scan.log','a+');
		fputs($fp,json_encode($postObj).PHP_EOL);
		$userInfo = $this->getUserInfo($postObj->FromUserName);
		fputs($fp,json_encode($userInfo).PHP_EOL);
		fclose($fp);
	}

	private function getUserInfo($openid){
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->getToken()."&openid=".$openid."&lang=zh_CN";
		$res = $this->request($url);
		return json_decode($res,true);
	}

    //取消订阅
    private function unSubscribe($postObj){
        //删除用户信息
        $resultStr=$postObj->FromUserName.'用户已取消关注';
        file_put_contents('logs',$resultStr);
        echo "";
        exit();
    }

    //菜单点击事件
    private function menuClick($postObj){
		file_put_contents('./click.log',json_encode($postObj));	
		//将菜单存入数据库，然后根据菜单的key来获取返回的结果
		if($postObj->EventKey=='menu1'){
			$this->responseText($postObj,'你点击了 “What’s menu” 菜单');
		}else{
			$this->responseText($postObj,'该功能正在升级完善，敬请期待');
		}
    }

	//创建菜单
	public function createMenu($menu){
		$url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->getToken();
		$this->request($url,1,'post',$menu);
	}




}

