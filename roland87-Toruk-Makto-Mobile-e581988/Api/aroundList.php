<?php
/*
 * Created on 2012. 5. 16.
=================================================
aroundList
# 주변 사용자 검색하기
	request :
		token		#인증토큰
		lon			#경도(Longitude)
		lat			#위도(Latitude)
	response :
		list[]
			uuid	#앱고유번호
			name	#이름
=================================================
*/

include 'lib/common.php';

if($debug_mode){
	// allow GET method
	$token = $_REQUEST["token"];
	$lon = $_REQUEST["lon"];
	$lat = $_REQUEST["lat"];
}else{
	// do not allow GET method
	$token = $_POST["token"];
	$lon = $_POST["lon"];
	$lat = $_POST["lat"];
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

// 반경 1km 내에 있는 30명을 검색함 
$result = db_query("SELECT uuid, name, ( 6371 * acos( cos( radians(".$lat.") ) " .
		"* cos( radians( lat ) ) * cos( radians( lon ) - " .
		"radians(".$lon.") ) + sin( radians(".$lat.") ) * " .
				"sin( radians( lat ) ) ) ) AS distance " .
				"FROM user HAVING distance < 1 " .
				"ORDER BY distance LIMIT 0 , 30;");
$ret="";
while($row = mysql_fetch_row($result)){
	$ret .= "{uuid:'".$row[0]."'";
	$ret .= ", name:'".$row[1]."'},";
}
if(strlen($ret)>0) $ret = substr($ret, 0, strlen($ret)-1);
echo "{code:1,list:[".$ret."]}";

?>
