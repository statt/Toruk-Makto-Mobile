<?php
/*
 * Created on 2012. 5. 16.
=================================================
hideMaum
#�̷���� ���� �׸�����
#���̻� receiveMaum�� ������� ��Ÿ���� �ʴ´�
	request :
		token		#������ū
		uuid		#���� �۰�����ȣ
		mcode		#�����ڵ�
		mstring		#�������ڿ�(mcode�� 800, �� �����Է��� ���� ���
=================================================
*/

include 'lib/common.php';

if($debug_mode){
	// allow GET method
	$token = $_REQUEST["token"];
	$fid = $_REQUEST["uuid"];
	$mcode = $_REQUEST["mcode"];
	$mstring = $_REQUEST["mstring"];
}else{
	// do not allow GET method
	$token = $_POST["token"];
	$fid = $_POST["uuid"];
	$mcode = $_POST["mcode"];
	$mstring = $_POST["mstring"];
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

if($mcode!=800) $mstring="";

$query = "UPDATE maum SET ";
if($uuid<$fid){
	$query .= "hideA = true WHERE uuidA=".$uuid." AND uuidB=".$fid." AND mcode=".$mcode;
}else{
	$query .= "hideB = true WHERE uuidA=".$fid." AND uuidB=".$uuid." AND mcode=".$mcode;
}
if($mcode==800) $query .=  " AND mstring='".$mstring."'";
db_query($query);
db_query("DELETE FROM maum WHERE hideA=true AND hideB=true");
echo "{code:1}";
?>
