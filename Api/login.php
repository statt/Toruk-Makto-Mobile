<?php
/*
 *  2012-05-14 
=================================================
login
# ���α׷��� ���� �� ������ ȣ��.
	request :
		uuid		#�۰�����ȣ
		timestamp	#����ð�	(���� 2009-02-14 08:31:30�� ��� : =1228548141)
		signature	#����		(=SHA1(timestamp + uuid + appKey)
		lon			#������ġ �浵(Longitude) : 12.5.15 �߰���
		lat			#������ġ ����(Latitude) : 12.5.15 �߰���
	response :
		token		#������ū
=================================================
timestamp�� ��ȿ���� �˻�
signature�� ��ȿ���� �˻�
�ش� user�� lon�� lat�� ����
token ���� �� ��ȯ
*/

include 'lib/common.php';

if($debug_mode){
	// allow GET method
	$uuid = $_REQUEST["uuid"];
	$timestamp = $_REQUEST["timestamp"];
	$signature = $_REQUEST["signature"];
	$lon = $_REQUEST["lon"];
	$lat = $_REQUEST["lat"];
}else{
	// do not allow GET method
	$uuid = $_POST["uuid"];
	$timestamp = $_POST["timestamp"];
	$signature = $_POST["signature"];
	$lon = $_POST["lon"];
	$lat = $_POST["lat"];
	if(!$uuid){
		raise_error(0, "�� ������ȣ�� null�Դϴ�.");
		return;
	}else if($timestamp+5 < time()){
		//timestamp�� ��ȿ���� �˻�
		raise_error(103, "timestamp�� ��ȿ�ð��� �ʰ��Ǿ����ϴ�.");
		return;
	}
}


//signature�� ��ȿ���� �˻�
$result = db_query("SELECT appKey FROM user WHERE uuid='".$uuid."'");
$row = mysql_fetch_row($result);
$appKey = $row[0];
if( (sha1($timestamp.$uuid.$appKey) != $signature) && !$debug_mode){
	raise_error(104, "signature�� ��ȿ���� �ʽ��ϴ�.");
	return;
}


//�ش� user�� lon�� lat�� ����
db_query("UPDATE user SET lat=".$lat.", lon=".$lon." WHERE uuid='".$uuid."'");


//token ���� �� ��ȯ
$token = sha1($uuid . $signature . "������ �����!");

//session�� token�� ����
if(!session_register("uuid", "token")){
	raise_error(105, "session ��Ͽ� �����Ͽ����ϴ�.");
	return;
}
$HTTP_SESSION_VARS['uuid'] = $uuid;
$HTTP_SESSION_VARS['token'] = $token;

echo "{code:1,token:\"".$token."\"}";
?>
