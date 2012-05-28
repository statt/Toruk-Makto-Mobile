<?php
/*
 * Created on 2012. 5. 16.
=================================================
hideMaum
#이루어진 마음 그만보기
#더이상 receiveMaum의 결과에서 나타나지 않는다
	request :
		token		#인증토큰
		uuid		#상대방 앱고유번호
		mcode		#마음코드
		mstring		#마음문자열(mcode가 800, 즉 직접입력일 때만 사용
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

$query = "UPDATE maum SET ";
if($uuid<$fid){
	$query .= "hideA = true WHERE uuidA=".$uuid." AND uuidB=".$fid." AND mcode=".$mcode;
}else{
	$query .= "hideB = true WHERE uuidA=".$fid." AND uuidB=".$uuid." AND mcode=".$mcode;
}
if($mcode==800) $query .=  " AND mstring='".$mstring."'";
db_query($query);
db_query("DELETE FROM maum WHERE hideA=true AND hideB=true");
echo "{code:1}";
?>
