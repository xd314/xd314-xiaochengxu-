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
$whn_xd314=new   whn_xd;
if(!empty($headers[pass])){
$u=explode('a',$headers[pass]);
$xiaochxu= DB::fetch_all("SELECT *  FROM ".DB::table('xiaochxu')." WHERE  yid=".$u[0])[0];
if((strtotime('-15 minute',$_G[timestamp])<$u[1])&&!empty($xiaochxu[yid])){
$dlt=$u[0].'a'.$_G[timestamp];
header('yanzheng:'.$dlt);
$a= DB::query("UPDATE ".DB::table('xiaochxu')."   SET  x22='".$dlt."'   WHERE yid=".$u[0]);
switch ($headers['contrl']){
case 'shouye'://---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------首页
$array0= DB::fetch_all("SELECT * FROM ".DB::table('chpk')."  WHERE     x14='1'" ); 
$arrayz= DB::fetch_all("SELECT * FROM ".DB::table('chpk')."  WHERE      x=0  AND     x14='1'" ); 
$fy=$whn_xd314->body_fy($arrayz,$headers[page],10);//---------------------------------------列表(输出区间限制数组array($t2,$t3,$t,$t1,$y,$y1))   参数：array $array  列表数据,$y1  页码(固定为$_GET[ft0]),$t1每页条数
$array=DB::fetch_all("SELECT * FROM ".DB::table('chpk')." WHERE       x=0  AND      x14='1' LIMIT   ".$fy[0].",".$fy[3]);
foreach($array0 as $key =>$value){
$zhonglei[$key]=$value[x];
}
foreach($array as $key =>$value){
if(!empty($value[x8])){
$array[$key][x8]='https://www.woheni99.com/chpk/ch/'.$value[cid].'/'.$value[x8];
}
}
$zhonglei= array_unique($zhonglei);
//$array2=array('全部','健康食品','小型厨具','保洁用品及个人护理品','化妆品','优惠促销');
$array1=array(a=>$array,b=>$zhonglei,c=>$whn_xd314->body_fy($arrayz,$headers[page],10));//a为数据  b为数据种类，c为页码信息
$array=array_iconv('gbk','utf-8',$array1);
echo json_encode($array);
break;
case 'shouye1'://---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------改变种类
$array0= DB::fetch_all("SELECT * FROM ".DB::table('chpk')."  WHERE    x=".$post[leibie]."  AND    x14='1'" ); 
$array= DB::fetch_all("SELECT * FROM ".DB::table('chpk')."  WHERE  x=".$post[leibie]."  AND  x14='1'" ); 
$fy=$whn_xd314->body_fy($array,$headers[page],10);//---------------------------------------列表(输出区间限制数组array($t2,$t3,$t,$t1,$y,$y1))   参数：array $array  列表数据,$y1  页码(固定为$_GET[ft0]),$t1每页条数
$array=DB::fetch_all("SELECT * FROM ".DB::table('chpk')." WHERE    x=".$post[leibie]."  AND      x14='1' LIMIT   ".$fy[0].",".$fy[3]);

foreach($array as $key =>$value){
if(!empty($value[x8])){
$array[$key][x8]='https://www.woheni99.com/chpk/ch/'.$value[cid].'/'.$value[x8];
}
}
//$zhonglei= array_unique($zhonglei);
//$array2=array('全部','健康食品','小型厨具','保洁用品及个人护理品','化妆品','优惠促销');
//$array1=array(a=>$array,b=>$zhonglei);
$array1=array(a=>$array,c=>$whn_xd314->body_fy($array0,$headers[page],10));//a为数据  b为数据种类，c为页码信息
$array=array_iconv('gbk','utf-8',$array1);
echo json_encode($array);
break;
case 'xiangqing'://----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------详情
$xiaochxu_dingdan= DB::fetch_all("SELECT * FROM ".DB::table('xiaochxu_dingdan')."   WHERE  x='".$u[0]."'  AND    x2='".$post[cid]."'    ORDER BY  yid  DESC" )[0]; 
if(empty($xiaochxu_dingdan[yid])){
$array= DB::fetch_all("SELECT * FROM ".DB::table('chpk')."  WHERE   cid='".$post[cid]."'  " )[0]; 
$array[x8]='https://www.woheni99.com/chpk/ch/'.$array[cid].'/'.$array[x8];
$array[geshu]=0;
$array[zongjiage]=0;
}else{
$array[x3]=$xiaochxu_dingdan[x23];
$array[x4]=$xiaochxu_dingdan[x21];
$array[x8]=$xiaochxu_dingdan[x22];
$array[geshu]=$xiaochxu_dingdan[x4];
$array[zongjiage]=$xiaochxu_dingdan[x5];
}

$array=array_iconv('gbk','utf-8',$array);
//echo 'aaa';
echo json_encode($array);
break;
case 'xuanhaole'://--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------选好了 
$xiaochxu_dingdan= DB::fetch_all("SELECT * FROM ".DB::table('xiaochxu_dingdan')."   WHERE  x='".$u[0]."'  AND    x2='".$post[cid]."'  ORDER BY  yid  DESC")[0]; 
if(empty($xiaochxu_dingdan[yid])){
$chpk= DB::fetch_all("SELECT * FROM ".DB::table('chpk')."  WHERE   cid='".$post[cid]."'  " )[0]; 
$array= DB::fetch_all("SELECT * FROM ".DB::table('xiaochxu_dingdan')."   ORDER BY  yid  DESC")[0];
$yid=$array[yid]+1;
$zehoujiage=$post[zongjiage]*1;
$a= DB::query("INSERT ".DB::table('xiaochxu_dingdan')." VALUES (".$yid.",'".$u[0]."','','".$post[cid]."','','".$post[geshu]."','".$post[zongjiage]."','','1','2','','".$_G['timestamp']."','','','1','','','','','','1','".$zehoujiage."','".$post[danjiage]."','".$post[img]."','".$chpk[x3]."','')");
echo   "ok";
}else{
$zehoujiage=$post[zongjiage]*1;
$a= DB::query("UPDATE ".DB::table('xiaochxu_dingdan')."   SET    x7='1',    x4='".$post[geshu]."',   x5='".$post[zongjiage]."', x20='".$zehoujiage."'   WHERE   yid=".$xiaochxu_dingdan[yid]); 
echo   "ok";
}
break;
case 'jgouwuche'://--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------加入购物车
$xiaochxu_dingdan= DB::fetch_all("SELECT * FROM ".DB::table('xiaochxu_dingdan')."   WHERE  x='".$u[0]."'  AND    x2='".$post[cid]."'  ORDER BY  yid  DESC")[0]; 
if(empty($xiaochxu_dingdan[yid])){
$chpk= DB::fetch_all("SELECT * FROM ".DB::table('chpk')."  WHERE   cid='".$post[cid]."'  " )[0]; 
$array= DB::fetch_all("SELECT * FROM ".DB::table('xiaochxu_dingdan')."   ORDER BY  yid  DESC")[0];
$yid=$array[yid]+1;
$zehoujiage=$post[zongjiage]*1;
$a= DB::query("INSERT ".DB::table('xiaochxu_dingdan')." VALUES (".$yid.",'".$u[0]."','','".$post[cid]."','','".$post[geshu]."','".$post[zongjiage]."','','2','2','','".$_G['timestamp']."','','','1','','','','','','1','".$zehoujiage."','".$post[danjiage]."','".$post[img]."','".$chpk[x3]."','')");
echo   "ok";
}else{
$zehoujiage=$post[zongjiage]*1;
$a= DB::query("UPDATE ".DB::table('xiaochxu_dingdan')."   SET      x7='2',     x4='".$post[geshu]."',   x5='".$post[zongjiage]."', x20='".$zehoujiage."'   WHERE   yid=".$xiaochxu_dingdan[yid]); 
echo   "ok";
}
break;
case 'gouwuche'://--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------购物车
$array= DB::fetch_all("SELECT * FROM ".DB::table('xiaochxu_dingdan')."   WHERE  x8='2'  AND    x='".$u[0]."'" ); 
$selec= DB::fetch_all("SELECT * FROM ".DB::table('xiaochxu_dingdan')."   WHERE x7='2'   AND  x8='2'  AND    x='".$u[0]."'" );
if(count($selec)>0){$select=2;}else{$select=1;}

$array1=array(a=>$array,b=>$select);//b为全选
$array=array_iconv('gbk','utf-8',$array1);
echo json_encode($array);
break;
case 'allSelect'://------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------修改allselect
$a= DB::query("UPDATE ".DB::table('xiaochxu_dingdan')."   SET    x7='".$post[allselect]."'    WHERE  x8='2'  AND       x='".$u[0]."'" ); 
$array= DB::fetch_all("SELECT * FROM ".DB::table('xiaochxu_dingdan')."   WHERE   x8='2'  AND     x='".$u[0]."'" ); 
$array1=array(a=>$array,b=>$post[allselect]);//b为全选
$array=array_iconv('gbk','utf-8',$array1);
echo json_encode($array);
break;
case 'Select'://------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------修改select
$xiaochxu_dingdan= DB::fetch_all("SELECT * FROM ".DB::table('xiaochxu_dingdan')."   WHERE   yid=".$post[dingdanid])[0]; 
if($xiaochxu_dingdan[x7]==1){
$a= DB::query("UPDATE ".DB::table('xiaochxu_dingdan')."   SET    x7='2'    WHERE    yid=".$post[dingdanid]); 
}else{
$a= DB::query("UPDATE ".DB::table('xiaochxu_dingdan')."   SET    x7='1'    WHERE    yid=".$post[dingdanid]); 
}
$array= DB::fetch_all("SELECT * FROM ".DB::table('xiaochxu_dingdan')."   WHERE   x8='2'  AND     x='".$u[0]."'" ); 
$selec= DB::fetch_all("SELECT * FROM ".DB::table('xiaochxu_dingdan')."   WHERE x7='2'   AND  x8='2'  AND    x='".$u[0]."'" );
if(count($selec)>0){$select=2;}else{$select=1;}
$array1=array(a=>$array,b=>$select);//b为全选
$array=array_iconv('gbk','utf-8',$array1);
echo json_encode($array);
break;
case 'xiugaigeshu1'://------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------修改个数(购物车)
if($post[geshu]>=1){
$xiaochxu_dingdan= DB::fetch_all("SELECT * FROM ".DB::table('xiaochxu_dingdan')."   WHERE   yid=".$post[dingdanid])[0]; 
$zongjiage=$xiaochxu_dingdan[x21]*$post[geshu];
$zehoujiage=$zongjiage*1;
$a= DB::query("UPDATE ".DB::table('xiaochxu_dingdan')."   SET    x4='".$post[geshu]."',   x5='".$zongjiage."', x20='".$zehoujiage."'   WHERE   yid=".$post[dingdanid]); 
}else{
$a= DB::query("DELETE  FROM ".DB::table('xiaochxu_dingdan')."  WHERE    yid=".$post[dingdanid]); 
}

$array= DB::fetch_all("SELECT * FROM ".DB::table('xiaochxu_dingdan')."   WHERE     x8='2'   AND     x='".$u[0]."'" ); 
$fy=$whn_xd314->body_fy($array,$headers[page],10);//---------------------------------------列表(输出区间限制数组array($t2,$t3,$t,$t1,$y,$y1))   参数：array $array  列表数据,$y1  页码(固定为$_GET[ft0]),$t1每页条数
$array= DB::fetch_all("SELECT * FROM ".DB::table('xiaochxu_dingdan')."   WHERE    x8='2'   AND    x='".$u[0]."'  LIMIT   ".$fy[0].",".$fy[3]);
$array=array_iconv('gbk','utf-8',$array);
echo json_encode($array);
break;
case 'dingdan'://--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------订单
$array= DB::fetch_all("SELECT * FROM ".DB::table('xiaochxu_dingdan')."   WHERE  x7='1'  AND  x8='2'  AND      x='".$u[0]."'" ); 
$array1=array(a=>$array,b=>'12345678',);
$array=array_iconv('gbk','utf-8',$array1);
echo json_encode($array);
break;
case 'xiugaigeshu'://------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------修改个数
if($post[geshu]>=1){
$xiaochxu_dingdan= DB::fetch_all("SELECT * FROM ".DB::table('xiaochxu_dingdan')."   WHERE   yid=".$post[dingdanid])[0]; 
$zongjiage=$xiaochxu_dingdan[x21]*$post[geshu];
$zehoujiage=$zongjiage*1;
$a= DB::query("UPDATE ".DB::table('xiaochxu_dingdan')."   SET    x4='".$post[geshu]."',   x5='".$zongjiage."', x20='".$zehoujiage."'   WHERE   yid=".$post[dingdanid]); 
}else{
if($xiaochxu_dingdan[x7]==1){
$a= DB::query("UPDATE ".DB::table('xiaochxu_dingdan')."   SET    x7='2'    WHERE    yid=".$post[dingdanid]); 
}else{
$a= DB::query("DELETE  FROM ".DB::table('xiaochxu_dingdan')."  WHERE    yid=".$post[dingdanid]); 
}
}

$array= DB::fetch_all("SELECT * FROM ".DB::table('xiaochxu_dingdan')."   WHERE    x7='1'  AND     x='".$u[0]."'" ); 
$fy=$whn_xd314->body_fy($array,$headers[page],10);//---------------------------------------列表(输出区间限制数组array($t2,$t3,$t,$t1,$y,$y1))   参数：array $array  列表数据,$y1  页码(固定为$_GET[ft0]),$t1每页条数
$array= DB::fetch_all("SELECT * FROM ".DB::table('xiaochxu_dingdan')."   WHERE   x7='1'  AND    x='".$u[0]."'  LIMIT   ".$fy[0].",".$fy[3]);
$array=array_iconv('gbk','utf-8',$array);
echo json_encode($array);
break;
case 'jiesuan'://-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------结算
$xiaochxu_goumai= DB::fetch_all("SELECT * FROM ".DB::table('xiaochxu_goumai')."   WHERE  x='".$u[0]."'  AND    x24='2'  ORDER BY  yid  DESC")[0]; 
if(empty($xiaochxu_goumai[yid])){
$array= DB::fetch_all("SELECT * FROM ".DB::table('xiaochxu_goumai')."   ORDER BY  yid  DESC")[0];
$yid=$array[yid]+1;
$a= DB::query("INSERT ".DB::table('xiaochxu_goumai')." VALUES (".$yid.",'".$u[0]."','','','','','".$post[heji]."','','','','','".$_G['timestamp']."','','".$post[beizhu]."','1','".$post[dianhuahao]."','','','','','1','','','','','2')");
$a= DB::query("UPDATE ".DB::table('xiaochxu_dingdan')."   SET    x8='1',  x24='".$yid."'   WHERE     x7='2'  AND  x='".$u[0]."'" );   
}else{
$a= DB::query("UPDATE ".DB::table('xiaochxu_goumai')."   SET   x5='".$post[heji]."', x12='".$post[beizhu]."', x14='".$post[dianhuahao]."'   WHERE   yid=".$xiaochxu_goumai[yid]); 
$yid=$xiaochxu_goumai[yid];
}
$array=array(a=>$yid,b=>$_G['timestamp']);
$array=array_iconv('gbk','utf-8',$array);
echo json_encode($array);
break;
default:
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
header('yanzheng:'.$arr[value]);
}else{
$arr[value]=$xiaochxu[yid].'a'.$_G[timestamp];
$a= DB::query("UPDATE ".DB::table('xiaochxu')."   SET  x22='".$arr[key]."'   WHERE yid=".$xiaochxu[yid]);
header('yanzheng:'.$arr[value]);
//echo   json_encode($arr);
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