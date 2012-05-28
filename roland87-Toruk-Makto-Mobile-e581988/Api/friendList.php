<?php
/*
 * Created on 2012. 5. 14.
=================================================
friendList
# 친구목록 받아오기
# 프로그램이 활성화 될 때마다 호출.
	request :
		token		#인증토큰
	response(JSON) :
		list[]
			uuid	#친구의 앱고유번호
			name	#이름
			imageTs	#프로필사진 바뀐 날짜(TimeStamp)
			message	#남김말
# 프로필사진은 "Api/profileImg/" + uuid 로 접근하면됨 
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

$result = db_query("SELECT fid, name, imageTs, message FROM friend, user WHERE friend.uuid='".$uuid."' AND fid=user.uuid");
$ret="";
while($row=mysql_fetch_row($result)){
	$ret .= "{uuid:'".$row[0]."'";
	$ret .= ", name:'".$row[1]."'";
	$ret .= ", imageTs:'".$row[2]."'";
	$ret .= ", message:'".$row[3]."'},";
}
if(strlen($ret)>0) $ret = substr($ret, 0, strlen($ret)-1);
echo "{code:1,list:[".$ret."]}";
?>
