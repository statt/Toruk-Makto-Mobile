<?php
/*
Created on 2012. 5. 14.
=================================================
register
# ����� ����� ���ִ� API.
# ���α׷� ��ġ�� ���ʽ��� 1ȸ�� ȣ��.
	request :
		uuid		#�۰�����ȣ	(UUID, http://huewu.blog.me/110107222113 ����. �����ID�� ���� ����)
		phoneNum	#�����ڵ�+��ȭ��ȣ (��ȭ��ȣ ���� ���� �׳� �� ���ڿ�)
		nums[]		#�ּҷϿ� ����Ǿ��ִ� ������� �����ڵ�+��ȭ��ȣ ����Ʈ
	response :
		appKey		#����Ű��
=================================================
*/
include 'lib/common.php';

if($debug_mode){
	// allow GET method
	$uuid = $_REQUEST["uuid"];
	$phoneNum = $_REQUEST["phoneNum"];
	$nums = $_REQUEST["nums"];
}else{
	// do not allow GET method
	$uuid = $_POST["uuid"];
	$phoneNum = $_POST["phoneNum"];
	$nums = $_POST["nums"];
}
//echo $uuid;
//foreach($nums as $value){
//	echo $value;
//}
$appKey = $HTTP_COOKIE_VARS["PHPSESSID"];

$result = db_query("SELECT * FROM user WHERE phoneNum='".$phoneNum."'")
//db_query("INSERT INTO user(uuid, phoneNum, appKey, name, image, imageTs, message, lon, lat, maxMaum, cntMaum, itm1, itm2, itm3) " .
//		"VALUES()"
//		);


//echo $appKey;
?>
