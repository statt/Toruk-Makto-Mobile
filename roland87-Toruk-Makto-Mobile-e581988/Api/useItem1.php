<?php
/*
 * Created on 2012. 5. 16.
=================================================
useItem1
#마음 확장시키기
	request :
		token		#인증토큰
	response :
		count		#앞으로 1인당 사용가능한 마음수
=================================================

*/

include 'lib/common.php';

if($debug_mode){
	// allow GET method
	$token = $_REQUEST["token"];
}else{
	// do not allow GET method
	$token = $_POST["token"];
}
if($token!=$HTTP_SESSION_VARS['token']){
	raise_error(102, "token이 유효하지 않습니다.");
	return;
}
$uuid = $HTTP_SESSION_VARS['uuid'];
if(!$uuid){
	raise_error(106, "session이 유효하지 않습니다.");
	return;
}

db_query("UPDATE user SET maxMaum=maxMaum+1 WHERE uuid='".$uuid."'");
$result = db_query("SELECT maxMaum FROM user WHERE uuid='".$uuid."'");
$row = mysql_fetch_array($result);
echo "{code:1,count:".$row[0]."}";
?>
