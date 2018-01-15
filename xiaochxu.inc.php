<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once (DISCUZ_ROOT .'./source/plugin/xd/function_xd314_xd.inc.php');
$headers=getallheaders();
switch ($headers['type']){
case 'login'://---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------登录
//echo   $headers['type'];
login($headers,$_G,$_POST,$_GET);
break;
default:

first($headers,$_G,$_POST,$_GET);
break;
}


 //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------功能函数
function first(array  $headers,array  $_G,array  $post,array  $get){//-----------------------------------------开始   参数：$_G
if(!empty($headers[pass])){
$whn_xd314=new   whn_xd;
$u=explode('a',$headers[pass]);//登录者验证信息
$dlt=$u[0].'a'.$_G[timestamp];
$a= DB::query("UPDATE ".DB::table('xiaochxu')."   SET  x22='".$dlt."'   WHERE yid=".$u[0]);
if(strtotime('-15 minute',$_G[timestamp])<$u[1]){
switch ($headers['contrl']){
case 'shouye'://---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------首页
$array= DB::fetch_all("SELECT * FROM ".DB::table('whn_shangchenga')."  WHERE    x14='1'      AND   x16='".$headers[shop]."'  " ); 
$fy=$whn_xd314->body_fy($array,$headers[page],6);//---------------------------------------列表(输出区间限制数组array($t2,$t3,$t,$t1,$y,$y1))   参数：array $array  列表数据,$y1  页码(固定为$_GET[ft0]),$t1每页条数
$array=DB::fetch_all("SELECT * FROM ".DB::table('whn_shangchenga')." WHERE      x14='1'      AND   x16='".$headers[shop]."'       LIMIT   ".$fy[0].",".$fy[3]);
foreach($array as $key =>$value){
if(!empty($value[x8])){
$x8=explode('|',$value[x8]);
$tt= DB::fetch_all("SELECT * FROM ".DB::table('whn_dizhi')." WHERE  yid=".$x8[0])[0];
$array[$key][x8]=$tt[x2];
}
}
$array=array_iconv('gbk','utf-8',$array);
echo json_encode($array);
break;
case 'xiangqing'://--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------详情
$array= DB::fetch_all("SELECT * FROM ".DB::table('whn_shangchenga')."  WHERE   uid='".$post[id]."'  " )[0]; 
$x8=explode('|',$array[x8]);
$tt= DB::fetch_all("SELECT * FROM ".DB::table('whn_dizhi')." WHERE  yid=".$x8[0])[0];
$array[x8]=$tt[x2];
$array=array_iconv('gbk','utf-8',$array);
echo json_encode($array);
break;
default:

first($headers,$_G,$_POST,$_GET);
break;
}
}else{
echo 'off';//---------------------------------------------------没有登录
}
}else{
echo 'off';//---------------------------------------------------没有登录
}
}


function array_iconv($in_charset,$out_charset,$arr){  
        return eval('return '.iconv($in_charset,$out_charset,var_export($arr,true).';'));  
    }  


function login(array  $headers,array  $_G,array  $post,array  $get){//-----------------------------------------登录   参数：$_G
$post_data = array();
$array=json_decode(send_post('https://api.weixin.qq.com/sns/jscode2session?appid=wx4ae0d9cc5bbf8920&secret=4158bcbf59c37b8aea9c2b74cd3ea98a&js_code='.$headers['code'].'&grant_type=authorization_code', $post_data),true);
$openid=$array[openid];
$session_key=$array[session_key];
if(!empty($openid)){
$xiaochxu= DB::fetch_all("SELECT *  FROM ".DB::table('xiaochxu')." WHERE  x23='".$openid."'")[0];
if(empty($xiaochxu[yid])){
$xiaochxu1= DB::fetch_all("SELECT * FROM ".DB::table('xiaochxu')."      ORDER BY  yid  DESC")[0];
$yid=$xiaochxu1[yid]+1;
$dlt=$yid.'a'.$_G[timestamp];
$a= DB::query("INSERT ".DB::table('xiaochxu')." VALUES (".$yid.",'".$session_key."','','".$_G[timestamp]."','','','','','','','','','','','','','','','','','','','','".$dlt."','".$openid."','')");
$arr[value]=$dlt;
$a= DB::query("UPDATE ".DB::table('xiaochxu')."   SET  x22='".$arr[key]."'   WHERE yid=".$xiaochxu[yid]);
//$arr=array_iconv('gbk','utf-8',$arr);
echo   json_encode($arr);
}else{
$arr[value]=$xiaochxu[yid].'a'.$_G[timestamp];
$a= DB::query("UPDATE ".DB::table('xiaochxu')."   SET  x22='".$arr[key]."'   WHERE yid=".$xiaochxu[yid]);
echo   json_encode($arr);
}
}else{
echo "off";//---------------------------------------------------没有登录
}
}

function send_post($url, $post_data) {
  $postdata = http_build_query($post_data);
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
 

?>