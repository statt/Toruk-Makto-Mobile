<?php
/*
 * Created on 2012. 5. 14.
=================================================
friendList
# ģ����� �޾ƿ���
# ���α׷��� Ȱ��ȭ �� ������ ȣ��.
	request :
		token		#������ū
	response(JSON) :
		list[]
			uuid	#ģ���� �۰�����ȣ
			name	#�̸�
			imageTs	#�����ʻ��� �ٲ� ��¥(TimeStamp)
			message	#���踻
# �����ʻ����� "Api/profileImg/" + uuid �� �����ϸ�� 
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

$result = db_query("SELECT fid, name, imageTs, message FROM friend, user WHERE friend.uuid='".$uuid."' AND fid=user.uuid");
$ret="";
while($row=mysql_fetch_row($result)){
	$ret .= "{uuid:'".$row[0]."'";
	$ret .= ", name:'".$row[1]."'";
	$ret .= ", imageTs:'".$row[2]."'";
	$ret .= ", message:'".$row[3]."'},";
}
if(strlen($ret)>0) $ret = substr($ret, 0, strlen($ret)-1);
echo "{code:1,list:[".$ret."]}";
?>
