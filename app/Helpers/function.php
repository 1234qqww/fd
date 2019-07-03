<?php
/**
 * 设置中国时区
 */
date_default_timezone_set('PRC');
/**
 * Created by PhpStorm.
 * User: lord
 * Date: 2018/8/15
 * Time: 下午6:34
 */

/**
 * 计算几分钟前、几小时前、几天前、几月前、几年前。
 * $agoTime string Unix时间
 * @author tangxinzhuan
 * @version 2016-10-28
 */
function time_ago($agoTime)
{
    $agoTime = (int)$agoTime;

    // 计算出当前日期时间到之前的日期时间的毫秒数，以便进行下一步的计算
    $time = time() - $agoTime;

    if ($time >= 31104000) { // N年前
        $num = (int)($time / 31104000);
        return $num.'年前';
    }
    if ($time >= 2592000) { // N月前
        $num = (int)($time / 2592000);
        return $num.'月前';
    }
    if ($time >= 86400) { // N天前
        $num = (int)($time / 86400);
        return $num.'天前';
    }
    if ($time >= 3600) { // N小时前
        $num = (int)($time / 3600);
        return $num.'小时前';
    }
    if ($time > 60) { // N分钟前
        $num = (int)($time / 60);
        return $num.'分钟前';
    }
    return '1分钟前';
}


function startEndTime(){
    /**
     * 获取今日开始时间戳和结束时间戳
     */
    $beginToday = mktime(0,0,0,date('m'),date('d'),date('Y'));
    $endToday = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
    /**
     * 获取昨日起始时间戳和结束时间戳
     */
    $beginYesterday = mktime(0,0,0,date('m'),date('d')-1,date('Y'));
    $endYesterday = mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
    /**
     * 获取本周起始时间
     */
    $beginWeek = mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"));
    $endWeek = mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y"));

    /**
     * 获取上周起始时间戳和结束时间戳
     */
    $beginLastweek = mktime(0,0,0,date('m'),date('d')-date('w')+1-7,date('Y'));
    $endLastweek = mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'));
    /**
     * 获取本月起始时间戳和结束时间戳
     */
    $beginThismonth = mktime(0,0,0,date('m'),1,date('Y'));
    $endThismonth = mktime(23,59,59,date('m'),date('t'),date('Y'));

    return ['beginToday'=>$beginToday,"endToday"=>$endToday,'beginYesterday'=>$beginYesterday,'endYesterday'=>$endYesterday,
        'beginWeek'=>$beginWeek,'endWeek'=>$endWeek,'beginLastweek'=>$beginLastweek,'endLastweek'=>$endLastweek,
        'beginThismonth'=>$beginThismonth,'endThismonth'=>$endThismonth];
}

/**
 * 計算多長時間后的時間
 */
function howLongTime(){
    /**今天*/
    $today = date("Y-m-d",time());
    /**昨天*/
    $yesterday = date("Y-m-d",strtotime("-1 day"));
    /**明天*/
    $tomorrow = date("Y-m-d",strtotime("+1 day"));
    /**一周后*/
    $week = date("Y-m-d",strtotime("+1 week"));
    /**一周零两天四小时两秒后*/
//    date("Y-m-d G:H:s",strtotime("+1 week 2 days 4 hours 2 seconds"))
    /**下个星期四*/
//    date("Y-m-d",strtotime("next Thursday"))
    /**上个周一*/
//    date("Y-m-d",strtotime("last Monday"))
    /**一個月前*/
    $lastMonth = date("Y-m-d",strtotime("last month"));
    /**一個月后*/
    $month = date("Y-m-d",strtotime("+1 month"));
    /**一年後*/
    /**十年後*/
    $tenYear = date("Y-m-d",strtotime("+10 year"));

}

/**
 * 返回值
 */
function state($code,$msg,$data,$count=0){
    return ['code'=>$code,'msg'=>$msg,'data'=>$data,'count'=>$count];
}


/**
 * @return array|false|mixed|string
 * u获取ip地址
 */
function getIp(){
    $onlineip='';
    if(getenv('HTTP_CLIENT_IP')&&strcasecmp(getenv('HTTP_CLIENT_IP'),'unknown')){
        $onlineip=getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR')&&strcasecmp(getenv('HTTP_X_FORWARDED_FOR'),'unknown')){
        $onlineip=getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR')&&strcasecmp(getenv('REMOTE_ADDR'),'unknown')){
        $onlineip=getenv('REMOTE_ADDR');
    } elseif(isset($_SERVER['REMOTE_ADDR'])&&$_SERVER['REMOTE_ADDR']&&strcasecmp($_SERVER['REMOTE_ADDR'],'unknown')){
        $onlineip=$_SERVER['REMOTE_ADDR'];
    }
    return $onlineip;
}

/**
 * @param $file
 * @param $path
 * @return string
 * 图片上传
 */
function upload($file,$file_path){
    // 判断文件是否上传
    if ($file) {
        // 获取后缀名
        $ext=$file->getClientOriginalExtension();
        // 新的文件名
        $newFile=date('YmdHis',time()).'_'.rand().".".$ext;
        // 上传文件操作
        $url = nowUrl().'/'.$file_path.$newFile;
        $path = public_path().'/'.$file_path;
        if($file->move($path,$newFile)){
            return json_encode(['code'=>0,'msg'=>'图片信息','url'=>$url]);
        }
    }
}
/**
 * @param $url
 * @return mixed
 * curl模拟get请求
 */
function curlGet($url){
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
    $tmpInfo = curl_exec($curl);     //返回api的json对象
    //关闭URL请求
    curl_close($curl);
    return $tmpInfo;    //返回json对象
}

/**
 * @param $url
 * @param $xml
 * @return mixed
 * curl 模拟post请求
 */
function curlPost($url, $xml)
{
    $ch = curl_init();
    //设置抓取的url
    curl_setopt($ch, CURLOPT_URL, $url);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //设置post方式提交
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

    $tmpInfo = curl_exec($ch);

    //返回api的json对象
    //关闭URL请求
    curl_close($ch);
    return $tmpInfo;    //返回json对象
}

/**
 * @param $address
 * @return string
 * 腾讯地图
 * 通过地址解析经纬度
 */
function tencentMap_address($key,$address){
    $url = "https://apis.map.qq.com/ws/geocoder/v1/?address={$address}&key={$key}";
    $data = curlGet($url);
    $result = json_decode($data,true);
    if(isset($result['result'])){
        return ['code'=>0,'msg'=>'获取成功','data'=>$result['result']['location']];
    }else{
        return ['code'=>1,'msg'=>'获取失败','data'=>''];
    }
}

/**
 * @param $key
 * @param $location
 * @return string
 * 通过经纬度返回地址
 */
function tencentMap_location($key,$location){
    $url = "https://apis.map.qq.com/ws/geocoder/v1/?location={$location}&key={$key} ";
    $data = curlGet($url);
    if($data){
        $result = json_decode($data,true);
        return $result['result']['ad_info'];
    }else{
        return '获取失败!';
    }
}

/**
 * @return bool
 * 主动判断是否HTTPS
 */
function isHTTPS()
{
    if (defined('HTTPS') && HTTPS) return true;
    if (!isset($_SERVER)) return FALSE;
    if (!isset($_SERVER['HTTPS'])) return FALSE;
    if ($_SERVER['HTTPS'] === 1) {  //Apache
        return TRUE;
    } elseif ($_SERVER['HTTPS'] === 'on') { //IIS
        return TRUE;
    } elseif ($_SERVER['SERVER_PORT'] == 443) { //其他
        return TRUE;
    }
    return FALSE;
}

/**
 * 返回当前域名
 */
function nowUrl(){
    $host = (isHTTPS() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']; //获取域名
    return $host;
}
/**
 * @param $appid
 * @param $secret
 * @return mixed
 * 小程序获取accesstoken
 */
function accessToken($appid,$secret){
    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}&grant_type=client_credential";
    $result = curlGet($url);
    $data = json_decode($result,true);
    return $data['access_token'];
}
/**
 * @param $filePath
 * @param $smallPath
 * @return string
 * 生成小程序二维码
 */
function QRcode($appid,$secret,$filePath,$smallPath){
    $url = "https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=".accesstoken($appid,$secret);
    $data = [
        'access_token'=>accesstoken($appid,$secret),
        'path'=>$smallPath,
        'width' => "200"
    ];
    $result = curlPost($url,json_encode($data));
    $filename = date('YmdHis',time())."_".rand().".png";
    file_put_contents($filePath.$filename,$result,true);
    return $filename;
}
/**
生成透明小程序码
 */
 function smallQrcode($appid,$secret,$filePath,$smallPath){
    $url = "https://api.weixin.qq.com/wxa/getwxacode?access_token=".accesstoken($appid,$secret);
    $data = [
        'path'=>$smallPath,
        'width' => "200",
        'is_hyaline'=>true,
    ];
    $result = curlPost($url,json_encode($data));
    $filename = date('YmdHis',time())."_".rand().".png";
    file_put_contents($filePath.$filename,$result,true);
    return $filename;
}

/**
 * @param $appid
 * @param $secret
 * @param $code
 * @return mixed
 * 通过小程序的code获取openid
 */
function getOpenid($appid,$secret,$code){
    $url = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code";
    $data = curlGet($url);
    if($data){
        $result = json_decode($data,true);
        return $result;
    }
    die();
}
/**
 * @param $content
 * @param string $path
 * 写日志
 */

function writeLogs($content,$path = 'logs/logs.log'){
    $path = storage_path($path);
    $myfile = fopen($path, "a") or die("Unable to open file!");
    fwrite($myfile, $content);
    fwrite($myfile, "\r\n".date('Y-m-d H:i:s')."\r\n");
}

/**
 * api数据接口
 */
/**
 * 小程序支付
 * @param Request $request
 * @return array
 */
function initiatingPayment($amountmoney, $ordernumber,$openid,$appid,$mch_id,$mer_secret,$notify_url,$body,$attach)
{

    $noncestr = createNonceStr(); //随机字符串

    $ordercode = $ordernumber;//商户订单号
    $totamount = $amountmoney;//金额
//    $attach = json_encode(['ordercode' => $ordercode]);
    $timeStamp = '' . time() . '';
    $data = [
        'openid' => $openid,
        'appid' => $appid,
        'mch_id' => $mch_id,
        'nonce_str' => $noncestr, //随机字符串,
        'body' => $body,
        'attach' => $attach,
        'timeStamp' => $timeStamp,
        'out_trade_no' => $ordercode,
        'total_fee' => intval($totamount * 100),
        'spbill_create_ip' => '127.0.0.1',
        'notify_url' => $notify_url,
        'trade_type' => 'JSAPI'
    ];

    //签名
    $data['sign'] = autograph($data,$mer_secret);

    $result = creatPay($data);
    $rest = xmlToArray($result);
    if(!isset($rest['prepay_id'])){
        return state(3,'获取prepay_id失败',$rest);
    }
    $prepay_id = $rest['prepay_id'];
    $parameters = array(
        'appId' => $appid, //小程序ID
        'timeStamp' => $timeStamp, //时间戳
        'nonceStr' => $noncestr, //随机串
        'package' => 'prepay_id=' . $prepay_id, //数据包
        'signType' => 'MD5'//签名方式
    );
    $sign = autograph($parameters,$mer_secret);

    return ['prepay_id' => 'prepay_id=' . $prepay_id, 'timeStamp' => $timeStamp, 'noncestr' => $noncestr, 'sign' => $sign, 'sign_type' => 'MD5'];
}

/**
 * 创建支付
 */
function creatPay($data)
{
    $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
    $xml = arrayToXml($data);
    $result = curlPost($url, $xml);
//      print_r(htmlspecialchars($xml));
    //$val = $this->doPageXmlToArray($result);
    return $result;
}



/**
 * @param $data
 * @return string
 * 生成签名
 */
function autograph($data,$mer_secret)
{
    $str = '';
    $data = array_filter($data);
    ksort($data);
    foreach ($data as $key => $value) {
        $str .= $key . '=' . $value . '&';
    }
    $str .= 'key=' . $mer_secret;
    return strtoupper(md5($str));
}

function templateMessage($appid,$secret,$templateid,$openid,$path,$formid,$value1,$value2,$value3,$value4)
{
    $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . accesstoken($appid, $secret);
    $data = [
        'touser' => $openid,
        'template_id' => $templateid,
        "page" => "{$path}",
        'form_id' => $formid,
        'data' => [
            "keyword1" => [
                'value' => $value1
            ],
            "keyword2" => [
                'value' => $value2
            ],
            "keyword3" => [
                'value' => $value3
            ],
            "keyword4" => [
                'value' => $value4
            ],
        ],
        "emphasis_keyword"=> "keyword1.DATA"
    ];

    $result = curlPost($url, json_encode($data));
    return $result;
}

/**
 * @param int $length
 * @return string
 * 生成随机字符串
 */
function createNonceStr($length = 16)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $str = '';
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}

/**
 * @param $arr
 * @return string
 * 数组转xml
 */
function arrayToXml($arr)
{
    $xml = "<xml>";
    foreach ($arr as $key => $val) {
        if (is_array($val)) {
            $xml .= "<" . $key . ">" . arrayToXml($val) . "</" . $key . ">";
        } else {
            $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
        }
    }
    $xml .= "</xml>";
    return $xml;
}

/**
 * @param $xml
 * @return mixed
 * xml转数组
 */
function xmlToArray($xml)
{
    //禁止引用外部xml实体
    libxml_disable_entity_loader(true);

    $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

    $val = json_decode(json_encode($xmlstring), true);

    return $val;
}
/**
 * 判断一个值是否存在于一个二位数组中
 */

function deep_in_array($value, $array)
{
    foreach ($array as $item) {
        if (!is_array($item)) {
            if ($item == $value) {
                return true;
            } else {
                continue;
            }
        }
        if (in_array($value, $item)) {
            return true;
        } else if (deep_in_array($value, $item)) {
            return true;
        }
    }
    return false;
}
/**
 * @param $img
 * @return string
 * 图片转base64
 */
function base64EncodeImage ($img) {
    $img_content = file_get_contents($img);
    $img_encode = base64_encode($img_content);
    $img_info = getimagesize($img);
    $img_encode= "data:{$img_info['mime']};base64,".$img_encode;
    return $img_encode;
}
/**
 * base转图片
 */
function base64_image_content($base64_image_content,$path){
    //匹配出图片的格式
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
        $type = $result[2];
        $new_file = $path."/".date('Ymd',time())."/";
        if(!file_exists($new_file)){
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($new_file, 0700);
        }
        $file_name = time().".{$type}";
        $new_file = $new_file.$file_name;
        if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
            return $file_name;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

/**
 * 阿里云省份证正反面识别
 */
function IdcardDistinguish($appcode,$image,$idCardSide){
    $host = "https://ocridcard.market.alicloudapi.com";
    $path = "/idimages";
    $method = "POST";
    $headers = array();
    array_push($headers, "Authorization:APPCODE " . $appcode);
    //根据API的要求，定义相对应的Content-Type
    array_push($headers, "Content-Type".":"."application/x-www-form-urlencoded; charset=UTF-8");
    $querys = "";
    $bodys = "image={$image}"."&idCardSide={$idCardSide}"; //图片 + 正反面参数 默认正面，背面请传back

    $url = $host . $path;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    if (1 == strpos("$".$host, "https://"))
    {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    }
    curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
    $tmpInfo = curl_exec($curl);     //返回api的json对象
    //关闭URL请求
    curl_close($curl);
    return $tmpInfo;    //返回json对象
}

/**
 *快递
 * $EBusinessID  快递鸟 电商id
 * $AppKey  秘钥
 * $number  快递公司编码
 * $logisticcode 物流编号
 *
 */
function  express_send($EBusinessID,$AppKey,$number,$logisticcode){
    $ReqURL = "http://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx";
    /**
     * 电商id
     */
    $requestData= "{'OrderCode':'','ShipperCode':'$number','LogisticCode':'$logisticcode'}";

    $datas = array(
        'EBusinessID' => $EBusinessID,
        'RequestType' => '1002',
        'RequestData' => urlencode($requestData) ,
        'DataType' => '2-json',
    );
    $datas['DataSign'] = doWebencrypt($requestData,$AppKey);
    $result= doWebsendPost($ReqURL, $datas);

    //根据公司业务处理返回的信息......
    $res = json_decode($result,true);
    if($res['Success'] == true){
        $last_names = array_column($res['Traces'],'AcceptTime');
        array_multisort($last_names,SORT_DESC,$res['Traces']);
    }
    return $res;
}
/**
 *  post提交数据
 * @param  string $url 请求Url
 * @param  array $datas 提交的数据
 * @return url响应返回的html
 */
function  doWebsendPost($url, $datas) {
    $temps = array();
    foreach ($datas as $key => $value) {
        $temps[] = sprintf('%s=%s', $key, $value);
    }
    $post_data = implode('&', $temps);
    $url_info = parse_url($url);
    if(empty($url_info['port']))
    {
        $url_info['port']=80;
    }
    $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
    $httpheader.= "Host:" . $url_info['host'] . "\r\n";
    $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
    $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
    $httpheader.= "Connection:close\r\n\r\n";
    $httpheader.= $post_data;
    $fd = fsockopen($url_info['host'], $url_info['port']);
    fwrite($fd, $httpheader);
    $gets = "";
    $headerFlag = true;
    while (!feof($fd)) {
        if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
            break;
        }
    }
    while (!feof($fd)) {
        $gets.= fread($fd, 128);
    }
    fclose($fd);

    return $gets;
}
/**
 * 电商Sign签名生成
 * @param data 内容
 * @param appkey Appkey
 * @return DataSign签名
 */
function  doWebencrypt($data,$appkey) {
    return urlencode(base64_encode(md5($data.$appkey)));
}
/**
 * 手机号
 */
function sms($username,$password,$content,$phone){
    $url='http://zz.shunlianweb.com';//系统接口地址
    $contents=urlencode(iconv("UTF-8", "gb2312",$content));
    $url=$url."/servlet/UserServiceAPI?method=sendSMS&extenno=&isLongSms=1&username=".$username."&password=".$password."&smstype=2&mobile={$phone}&content=".$contents;
    $html = file_get_contents($url);
    if(!strpos($html,"success")){
        return "success";
    }else{
        return "error";
    }
}
/**
 * 退款双向证书curl
 */

function  httpCurlPost($url,$xml,$key_pem,$cert_pem){
    $ch = curl_init();
    // 设置URL和相应的选项
    curl_setopt($ch, CURLOPT_ENCODING, '');                     //设置header头中的编码类型
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);             //返回原生的（Raw）内容
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);            //禁止验证ssl证书
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_HEADER, 0);                        //header头是否设置
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSLCERT, public_path() . '/cert/'.$cert_pem);
    curl_setopt($ch, CURLOPT_SSLKEY, public_path() . '/cert/'.$key_pem);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    $tmpInfo = curl_exec($ch);
    //返回api的json对象
    //关闭URL请求
    curl_close($ch);
    return $tmpInfo;    //返回json对象
}
/**
 * 企业转账到零钱
 */
function transferAccounts($mch_appid,$mchid,$openid,$nonce_str,$desc,$partner_trade_no,$amount,$spbill_create_ip,$secret,$key_pem,$cert_pem){
    $data = [
        'mch_appid' =>$mch_appid,
        'mchid'=> $mchid,
        'openid' => $openid,
        'nonce_str' => $nonce_str, //随机字符串,
        'desc' => $desc,
        'check_name'=>'NO_CHECK',
        'partner_trade_no' => $partner_trade_no,
        'amount' => intval($amount * 100),
        'spbill_create_ip' => $spbill_create_ip,
    ];
    //签名
    $data['sign'] = autograph($data,$secret);
    $url ="https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
    $xml = arrayToXml($data);
    $rest = httpCurlPost($url,$xml,$key_pem,$cert_pem);
    $result = xmlToArray($rest);
    return $result;
}
/**
 * 退款
 */
function refund($appid,$mch_id,$nonce,$ordernumber,$ordernumbers,$amount,$secret,$key_pem,$cert_pem){
    $data = [
        'appid' =>$appid,
        'mch_id'=> $mch_id,
        'nonce_str' => $nonce,
        'out_trade_no' => $ordernumber, //随机字符串,
        'out_refund_no' => $ordernumbers,
        'total_fee'=> intval($amount * 100),
        'refund_fee' =>  intval($amount * 100),
    ];
    $data['sign'] = autograph($data,$secret);
    $url ="https://api.mch.weixin.qq.com/secapi/pay/refund";
    $xml = arrayToXml($data);
    $rest = httpCurlPost($url,$xml,$key_pem,$cert_pem);
    $result = xmlToArray($rest);
    return $result;

}














