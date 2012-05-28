<?php
/*
 * Created on 2012. 5. 18.
=================================================
sendingMaum
# 보내고 있는 마음 목록보기
	request :
		token		#인증토큰
	response :
		list[]
			uuid	#상대방 앱고유번호
			mcode	#마음코드
			mstring	#마음문자열(마음코드가 800일 때, 즉 사용자정의 문자열 일때만 사용)
			sndDate	#입력한 날짜
			itmString	#아이템 사용정보(ex: "", "9시간 이후 알림을 받습니다.", "나에게만 매칭 정보가 나타납니다.")
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
$result = db_query("SELECT uuidA, uuidB, mcode, mstring, dateA, dateB, itemA, itemB, delay FROM maum WHERE (uuidA='".$uuid."' AND BtoA=false) OR (uuidB='".$uuid."' AND AtoB=false)");
$row = mysql_fetch_row($result);
$ret = "";
while($row=mysql_fetch_row($result)){
	$itmString="";
	if($row[0]==$uuid){
		$fid=$row[1];
		$sndDate=$row[4];
		$itm=$row[6];
	}else{
		$fid=$row[0];
		$sndDate=$row[5];
		$itm=$row[7];
	}
	$mcode = $row[2];
	$mstring = $row[3];
	$delay = $row[8];
	if($itm==0){
		$itmString="";
	}else if($itm==1){
		$itmString=$delay."시간 이후 알림을 받습니다.";
	}else if($itm==2){
		$itmString="나에게만 매칭 정보가 나타납니다.";
	}
	$ret.="{uuid='".$fid."', mcode=".$mcode.", mstring='".$mstring."', sndDate='".$sndDate."', itmString='".$itmString."'},";
}
if(strlen($ret)>0) $ret = substr($ret, 0, strlen($ret)-1);
echo "{code:1,list:[".$ret."]}";
?>