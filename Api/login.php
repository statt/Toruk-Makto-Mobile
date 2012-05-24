<?php
/*
 *  2012-05-14 
=================================================
login
# 프로그램이 실행 될 때마다 호출.
	request :
		uuid		#앱고유번호
		timestamp	#현재시간	(현재 2009-02-14 08:31:30일 경우 : =1228548141)
		signature	#서명		(=SHA1(timestamp + uuid + appKey)
		lon			#현재위치 경도(Longitude) : 12.5.15 추가됨
		lat			#현재위치 위도(Latitude) : 12.5.15 추가됨
	response :
		token		#인증토큰
=================================================
timestamp가 유효한지 검사
signature가 유효한지 검사
해당 user의 lon과 lat를 갱신
token 생성 및 반환
*/

include 'lib/common.php';

if($debug_mode){
	// allow GET method
	$uuid = $_REQUEST["uuid"];
	$timestamp = $_REQUEST["timestamp"];
	$signature = $_REQUEST["signature"];
	$lon = $_REQUEST["lon"];
	$lat = $_REQUEST["lat"];
}else{
	// do not allow GET method
	$uuid = $_POST["uuid"];
	$timestamp = $_POST["timestamp"];
	$signature = $_POST["signature"];
	$lon = $_POST["lon"];
	$lat = $_POST["lat"];
	if(!$uuid){
		raise_error(0, "앱 고유번호가 null입니다.");
		return;
	}else if($timestamp+5 < time()){
		//timestamp가 유효한지 검사
		raise_error(103, "timestamp의 유효시간이 초과되었습니다.");
		return;
	}
}


//signature가 유효한지 검사
$result = db_query("SELECT appKey FROM user WHERE uuid='".$uuid."'");
$row = mysql_fetch_row($result);
$appKey = $row[0];
if( (sha1($timestamp.$uuid.$appKey) != $signature) && !$debug_mode){
	raise_error(104, "signature가 유효하지 않습니다.");
	return;
}


//해당 user의 lon과 lat를 갱신
db_query("UPDATE user SET lat=".$lat.", lon=".$lon." WHERE uuid='".$uuid."'");


//token 생성 및 반환
$token = sha1($uuid . $signature . "마음을 열어라!");

//session에 token값 저장
if(!session_register("uuid", "token")){
	raise_error(105, "session 등록에 실패하였습니다.");
	return;
}
$HTTP_SESSION_VARS['uuid'] = $uuid;
$HTTP_SESSION_VARS['token'] = $token;

echo "{code:1,token:\"".$token."\"}";
?>
