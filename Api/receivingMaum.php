<?php
/*
 * Created on 2012. 5. 18.
=================================================
receivingMaum
# �ް��ִ� ���� ��/�̷��� ���� ��Ϻ���
	request :
		token		#������ū
	response :
		count		#�ް��ִ� ���� ��
		list[]		#����� ����
			uuid	#���� �۰�����ȣ
			mcode	#�����ڵ�
			mstring	#�������ڿ�(�����ڵ尡 800�� ��, �� ��������� ���ڿ� �϶��� ���)
			sndDate	#�Է��� ��¥
			rcvDate	#�̷��� ��¥
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
