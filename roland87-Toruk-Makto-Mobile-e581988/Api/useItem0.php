<?php
/*
 * Created on 2012. 5. 16.
=================================================
useItem0
#70%의 진실 아이템 사용하기
	request :
		token		#인증토큰
		uuid		#상대방 앱고유번호
	response :
		remain		#남은 아이템 갯수
		uuid		#상대방 앱고유번호
		mcode		#상대방이 나에게 가지고 있을수도 있는 마음코드(확률은 70%)
=================================================
예외 : 사용자 정의 마음은 안알려줌~
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

$query = "SELECT * FROM maum WHERE mcode!=800 AND ";
if($uuid < $fid)
	$query .= "uuidA='".$uuid."' AND uuidB='".$fid."'";
else
	$query .= "uuidA='".$fid."' AND uuidB='".$uuid."'";

$result = db_query($query);
$count = mysql_num_rows($result);

srand((double)microtime()*1000000);  //랜덤값 초기화
if($count>0){
	for($i=0;$i<$count;$i++){
		$row = mysql_fetch_array($result);
		$list[$i] = $row[4];	//mcode
	}
	for($i=$count; $i<$count*3/7; $i++){
		$list[$i] = rand(0, $maum_max);
	}
	$mcode = $list[rand(0, $count*3/7-1)];
}else{
	// 입력된 마음이 하나도 없을 때
	$mcode = rand(0, $maum_max);
}

$result = db_query("SELECT * FROM user WHERE uuid='".$uuid."'");
$row = mysql_fetch_array($result);
$remain = $row[12] - 1;
db_query("UPDATE user SET itm3=".($remain-1)." WHERE uuid='".$uuid."'");

echo "{code:1,uuid:'".$fid."',remain:'".$remain."',mcode:".$mcode."}";

?>
