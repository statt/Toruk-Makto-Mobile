<?php
/*
 * Created on 2012. 5. 16.
 * 
=================================================
addFriendByNum
# 전화번호로 친구 추가
	request :
		token		#인증토큰
		nums[]		#주소록에 저장되어있는 사람들의 국가코드+전화번호 리스트
	response :
=================================================
 */

include 'lib/common.php';

if($debug_mode){
	// allow GET method
	$token = $_REQUEST["token"];
	$nums = $_REQUEST["nums"];
}else{
	// do not allow GET method
	$token = $_POST["token"];
	$nums = $_POST["nums"];
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

// 번호목록으로부터 친구를 등록함
$query = "SELECT uuid FROM user WHERE";
if($nums!=null){
	foreach($nums as $value){
		if($value!=null AND $value!="") $query = $query." phoneNum='".$value."' OR";
	}
	$query=$query." 1=0";
	$result = db_query($query);
	$query = "INSERT INTO friend(uuid, fid) VALUES('".$uuid."', '";
	while($fid = mysql_fetch_row($result)){
		db_query($query . $fid[0]."')");
	}
}

echo "{code:1}";
?>
