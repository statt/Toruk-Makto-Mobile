<?php
/*
 * Created on 2012. 5. 18.
=================================================
sendingMaum
# ������ �ִ� ���� ��Ϻ���
	request :
		token		#������ū
	response :
		list[]
			uuid	#���� �۰�����ȣ
			mcode	#�����ڵ�
			mstring	#�������ڿ�(�����ڵ尡 800�� ��, �� ��������� ���ڿ� �϶��� ���)
			sndDate	#�Է��� ��¥
			itmString	#������ �������(ex: "", "9�ð� ���� �˸��� �޽��ϴ�.", "�����Ը� ��Ī ������ ��Ÿ���ϴ�.")
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
		$itmString=$delay."�ð� ���� �˸��� �޽��ϴ�.";
	}else if($itm==2){
		$itmString="�����Ը� ��Ī ������ ��Ÿ���ϴ�.";
	}
	$ret.="{uuid='".$fid."', mcode=".$mcode.", mstring='".$mstring."', sndDate='".$sndDate."', itmString='".$itmString."'},";
}
if(strlen($ret)>0) $ret = substr($ret, 0, strlen($ret)-1);
echo "{code:1,list:[".$ret."]}";
?>