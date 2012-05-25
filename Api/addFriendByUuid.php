<?php
/*
 * Created on 2012. 5. 16.
 * 
=================================================
addFriendByUuid
# uuid로 친구 추가
	request :
		token		#인증토큰
		uuid		#친구앱고유번호
	response :
=================================================
 */
 
include 'lib/common.php';

if($debug_mode){
	// allow GET method
	$token = $_REQUEST["token"];
	$fid = $_REQUEST["uuid"];
}else{
	// do not allow GET method
	$token = $_POST["token"];
	$fid = $_POST["uuid"];
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

if($fid!=null && $fid!=""){
	//$result = ("SELECT name, message FROM user WHERE uuid='".$fid."'");
	//$row = mysql_fetch_row($result);
	//echo "{code:1,uuid:\"".$fid."\",name:\"".$row[0]."\",message:\"".$row[1]."\"}";
	db_query("INSERT INTO friend(uuid, fid) VALUES('".$uuid."','".$fid."')");
	echo "{code:1}";
}else{
	echo "{code:0}";
}
?>
