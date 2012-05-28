<?php
/*
 * Created on 2012. 5. 16.
=================================================
cancelMaum
#보내고 있는 마음 삭제
	request :
		token		#인증토큰
		uuid		#상대방 앱고유번호
		mcode		#마음코드
	response :
=================================================
*/

include 'lib/common.php';

if($debug_mode){
	// allow GET method
	$token = $_REQUEST["token"];
	$fid = $_REQUEST["uuid"];
	$mcode = $_REQUEST["mcode"];
	$mstring = $_REQUEST["mstring"];
}else{
	// do not allow GET method
	$token = $_POST["token"];
	$fid = $_POST["uuid"];
	$mcode = $_POST["mcode"];
	$mstring = $_POST["mstring"];
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

if($mcode!=800) $mstring="";

$query = "DELETE FROM maum WHERE mcode=".$mcode." AND ";
if($mcode==800) $query .=  "mstring='".$mstring."' AND ";
if($uuid<$fid){
	$query .= "uuidA='".$uuid."' AND uuidB='".$fid."' AND AtoB=true AND BtoA=false";
}else{
	$query .= "uuidA='".$fid."' AND uuidB='".$uuid."' AND AtoB=false AND BtoA=true";
}
db_query($query);
echo "{code:1}";
?>
