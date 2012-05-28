<?php
/*
 * Created on 2012. 5. 18.
=================================================
receivingMaum
# 받고있는 마음 수/이뤄진 마음 목록보기
	request :
		token		#인증토큰
	response :
		count		#받고있는 마음 수
		list[]		#연결된 마음
			uuid	#상대방 앱고유번호
			mcode	#마음코드
			mstring	#마음문자열(마음코드가 800일 때, 즉 사용자정의 문자열 일때만 사용)
			sndDate	#입력한 날짜
			rcvDate	#이뤄진 날짜
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
$result = db_query("SELECT cntMaum FROM user WHERE uuid='".$uuid."'");
$row = mysql_fetch_row($result);
$count = $row[0];
$result = db_query("SELECT uuidA, uuidB, nameA, nameB, mcode, mstring, dateA, dateB, dateInf FROM maum WHERE AtoB=true AND BtoA=true AND dateInf>NOW() AND" .
		"((uuidA='".$uuid."' AND (itemB!=2 OR (itemA=2 AND itemB=2)) AND hideA=false)" .
		" OR (uuidB='".$uuid."' AND (itemA!=2 OR (itemA=2 AND itemB=2)) AND hideB=false))");
$ret = "";
while($row=mysql_fetch_row($result)){
	if($row[0]==$uuid){
		$fid=$row[1];
		$name=$row[3];
		$sndDate=$row[6];
	}else{
		$fid=$row[0];
		$name=$row[2];
		$sndDate=$row[7];
	}
	$mcode = $row[4];
	$mstring = $row[5];
	$rcvDate = $row[8];
	$ret.="{uuid='".$fid."', mcode=".$mcode.", mstring='".$mstring."', sndDate='".$sndDate."', rcvDate='".$rcvDate."'},";
}
if(strlen($ret)>0) $ret = substr($ret, 0, strlen($ret)-1);
echo "{code:1,list:[".$ret."]}";
?>
