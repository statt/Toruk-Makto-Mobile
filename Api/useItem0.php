<?php
/*
 * Created on 2012. 5. 16.
=================================================
useItem0
#70%�� ���� ������ ����ϱ�
	request :
		token		#������ū
		uuid		#���� �۰�����ȣ
	response :
		remain		#���� ������ ����
		uuid		#���� �۰�����ȣ
		mcode		#������ ������ ������ �������� �ִ� �����ڵ�(Ȯ���� 70%)
=================================================
���� : ����� ���� ������ �Ⱦ˷���~
*/

include 'lib/common.php';

if($debug_mode){
	// allow GET method
	$token = $_REQUEST["token"];
	$fid = $_REQUEST["uuid"];
}else{
	// do not allow GET method
	$token = $_POST["token"];
	$fid = $_POST["uuid"];
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

$query = "SELECT * FROM maum WHERE mcode!=800 AND ";
if($uuid < $fid)
	$query .= "uuidA='".$uuid."' AND uuidB='".$fid."'";
else
	$query .= "uuidA='".$fid."' AND uuidB='".$uuid."'";

$result = db_query($query);
$count = mysql_num_rows($result);

srand((double)microtime()*1000000);  //������ �ʱ�ȭ
if($count>0){
	for($i=0;$i<$count;$i++){
		$row = mysql_fetch_array($result);
		$list[$i] = $row[4];	//mcode
	}
	for($i=$count; $i<$count*3/7; $i++){
		$list[$i] = rand(0, $maum_max);
	}
	$mcode = $list[rand(0, $count*3/7-1)];
}else{
	// �Էµ� ������ �ϳ��� ���� ��
	$mcode = rand(0, $maum_max);
}

$result = db_query("SELECT * FROM user WHERE uuid='".$uuid."'");
$row = mysql_fetch_array($result);
$remain = $row[12] - 1;
db_query("UPDATE user SET itm3=".($remain-1)." WHERE uuid='".$uuid."'");

echo "{code:1,uuid:'".$fid."',remain:'".$remain."',mcode:".$mcode."}";

?>
