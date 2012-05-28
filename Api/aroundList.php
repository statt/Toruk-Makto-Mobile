<?php
/*
 * Created on 2012. 5. 16.
=================================================
aroundList
# �ֺ� ����� �˻��ϱ�
	request :
		token		#������ū
		lon			#�浵(Longitude)
		lat			#����(Latitude)
	response :
		list[]
			uuid	#�۰�����ȣ
			name	#�̸�
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
	raise_error(102, "token�� ��ȿ���� �ʽ��ϴ�.");
	return;
}
$uuid = $HTTP_SESSION_VARS['uuid'];
if(!$uuid){
	raise_error(106, "session�� ��ȿ���� �ʽ��ϴ�.");
	return;
}

// �ݰ� 1km ���� �ִ� 30���� �˻��� 
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
