<?php
/*
 * Created on 2012. 5. 16.
 * 
=================================================
addFriendByNum
# ��ȭ��ȣ�� ģ�� �߰�
	request :
		token		#������ū
		nums[]		#�ּҷϿ� ����Ǿ��ִ� ������� �����ڵ�+��ȭ��ȣ ����Ʈ
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
	raise_error(102, "token�� ��ȿ���� �ʽ��ϴ�.");
	return;
}
$uuid = $HTTP_SESSION_VARS['uuid'];
if(!$uuid){
	raise_error(106, "session�� ��ȿ���� �ʽ��ϴ�.");
	return;
}

// ��ȣ������κ��� ģ���� �����
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
