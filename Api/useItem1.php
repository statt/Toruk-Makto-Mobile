<?php
/*
 * Created on 2012. 5. 16.
=================================================
useItem1
#���� Ȯ���Ű��
	request :
		token		#������ū
	response :
		count		#������ 1�δ� ��밡���� ������
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
	raise_error(102, "token�� ��ȿ���� �ʽ��ϴ�.");
	return;
}
$uuid = $HTTP_SESSION_VARS['uuid'];
if(!$uuid){
	raise_error(106, "session�� ��ȿ���� �ʽ��ϴ�.");
	return;
}

db_query("UPDATE user SET maxMaum=maxMaum+1 WHERE uuid='".$uuid."'");
$result = db_query("SELECT maxMaum FROM user WHERE uuid='".$uuid."'");
$row = mysql_fetch_array($result);
echo "{code:1,count:".$row[0]."}";
?>
