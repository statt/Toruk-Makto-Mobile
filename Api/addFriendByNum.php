<?php
/*
 * Created on 2012. 5. 16.
 * 
=================================================
addFriendByNum
# 전화번호로 친구 추가
	request :
		token		#인증토큰
		phoneNum	#친구전화번호(국가코드+전화번호)
	response :
		uuid		#친구앱고유번호
		name		#이름
		message		#남김말
=================================================
 */
 
include 'lib/common.php';

if($debug_mode){
	// allow GET method
	$token = $_REQUEST["token"];
	$phoneNum = $_REQUEST["phoneNum"];
}else{
	// do not allow GET method
	$token = $_POST["token"];
	$phoneNum = $_POST["phoneNum"];
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
if($phoneNum==null || $phoneNum==""){
	raise_error(0, "올바르지 않은 전화번호 입니다.");
	return;
}

$result = ("SELECT uuid, name, message FROM user WHERE phoneNum='".$phoneNum."'");
$row = mysql_fetch_row($result);
echo "{code:1,uuid:\"".$row[0]."\",name:\"".$row[1]."\",message:\"".$row[2]."\"}";
db_query("INSERT INTO friend(uuid, fid) VALUES('".$uuid."','".$row[0]."')");
?>
