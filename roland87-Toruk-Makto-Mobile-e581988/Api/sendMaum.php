<?php
/*
 * Created on 2012. 5. 11.
=================================================
sendMaum
# 마음 보내기
	request :
		token		#인증토큰
		uuid		#상대방uuid
		mcode		#마음코드
		mstring		#마음문자열(마음코드가 800일 때, 즉 사용자정의 문자열 일때만 사용)
		item		#아이템 번호(0-사용안함, 1-지연알림, 2-나에게만알림)
		delay		#지연알림 시간(item 값이 1일때만 사용됨. 단위는 시간) 
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
	$item = $_REQUEST["item"];
	$delay = $_REQUEST["delay"];
}else{
	$token = $_POST["token"];
	$fid = $_POST["uuid"];
	$mcode = $_POST["mcode"];
	$mstring = $_POST["mstring"];
	$item = $_POST["item"];
	$delay = $_POST["delay"];
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
if($item!=1){ // 사용안함 또는 나에게만 알림. delay값이 필요 없음
	$delay = 0;
}

// 그사람이 나에게 같은 마음을 가지고 있었다면?
if($uuid < $fid)
	$where = "WHERE (uuidA='".$uuid."' OR uuidB='".$fid."')";
else
	$where = "WHERE (uuidA='".$fid."' OR uuidB='".$uuid."')";
	
if($mcode==800){
	$where .= "AND mcode=800 AND mstring='".$mstring."'";
}else{
	$where .= "AND mcode=".$mcode;
}
$result = db_query("SELECT * FROM maum " . $where);

if(mysql_num_rows($result)>0){
	// 기존 마음을 update!
	$row = mysql_fetch_array($result);
	$uuidA = $row[0];
	$uuidB = $row[2];
	$delay = $delay + $row[10];
	$query = "UPDATE maum SET"; 
	if($uuidA == $uuid){	// 내가 A, 상대방이 B
		$query .= "AtoB=true, itemA=".$item.", delay=".$delay." dateInf=".($row[11]+$delay);
	}else if($uuidB == $uuid){	// 상대방이 A, 내가 B
		$query .= "BtoA=true, itemB=".$item.", delay=".$delay." dateInf=".($row[12]+$delay);
	}
	$query .= " ".$where;
	db_query($query);
}else{
	// 새로운 마음을 insert!
	$result = db_query("SELECT uname FROM user WHERE uuid='".$fid."'");
	$row = mysql_fetch_array($result);
	$fname = $row[0];
	
	$result = db_query("SELECT uname FROM user WHERE uuid='".$uuid."'");
	$row = mysql_fetch_array($result);
	$uname = $row[0];
	
	$query = "INSERT INTO maum VALUES(";
	if($uuid<$fid){
		$query .= "'".$uuid."', '".$uname."', '".$fid."', '".$fname."'";
	}else{
		$query .= "'".$fid."', '".$fname."', '".$uuid."', '".$uname."'";
	}
	$query .= ", '".$mcode."', '".$mstring."'";
	if($uuid<$fid){	// AtoB, BtoA
		$query .= ", true, false, ".$item.", 0, ";
	}else{
		$query .= ", false, true, 0, ".$item.", ";
	}
	$query .=$delay.", ,,,false, false)";
	$result = db_query($query);
}
echo "{code:1}";
?>
