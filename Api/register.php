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
		name		#����� �̸�(����Ʈ���� ����� �� ���)
// ���� signature ����� �߰��Ͽ�
// register �ݷ� ������ ����� ������ �����ϴ� ������ ����ؾ� �� ***************
	response :
		appKey		#����Ű��
=================================================
�ش� phoneNum�� ���� uuid�� ã�Ƽ� user�������� ����
�ߺ��� ��ȣ�� ������ ����� ������ �������� ����
�ߺ��� ��ȣ�� ������ user ���� ����
maum ���� ����(��Ī �ȵȰ� �Ǵ� �Ѵ� �εǴ°Ÿ� �׳� ����������, ��Ī �ȰŸ� set null)
friend ���� delete
user���̺� �� ������ ����
��ȣ������κ��� ģ������Ʈ ����
Ŭ���̾�Ʈ���� appKey �ο�
*/
include 'lib/common.php';

if($debug_mode){
	// allow GET method
	$uuid = $_REQUEST["uuid"];
	$phoneNum = $_REQUEST["phoneNum"];
	$name = $_REQUEST["name"];
}else{
	// do not allow GET method
	$uuid = $_POST["uuid"];
	$phoneNum = $_POST["phoneNum"];
	$name = $_POST["name"];
	if(!$uuid){
		raise_error(0, "�� ������ȣ�� null�Դϴ�.");
		return;
	}
}


// Ŭ���̾�Ʈ���� ���� Ű�� �ο��� �ش�.
$appKey = sha1($uuid.$phoneNum."�ð����帥�ٿ�ų����ų������ų��ްų����ų�");


// �ߺ��� ��ȣ�� ������ ����� ������ �ʱ�ȭ ��Ŵ
if($phoneNum){
	// ��ȭ����� ���� ����� ���� ��ȭ��ȣ�� �����Ƿ� �� ������ ����
	
	// �ߺ��� ��ȣ�� ������ uuid�� ȹ��
	$result = db_query("SELECT uuid FROM user WHERE phoneNum='".$phoneNum."'");
	$old_uuid_set = mysql_fetch_row($result);
	$old_uuid = $old_uuid_set[0];
	
	// �ߺ��� ��ȣ�� ������ ����� ������ �������� ����
	$profileImgSrc = "/Api/profileImg/".$old_uuid; 
	if(is_file($profileImgSrc))	unlink($profileImgSrc);
	
	// �ߺ��� ��ȣ�� ������ user ���� ����
	db_query("DELETE FROM user WHERE uuid='".$old_uuid."'");
	
	// maum ���� ����
	// ��Ī �ȵȰ� �Ǵ� �Ѵ� �εǴ°Ÿ� �׳� ����������,
	db_query("DELETE FROM maum WHERE " .
			"(uuidA='".$old_uuid."' AND uuidB=null) OR " .
					"(uuidB='".$old_uuid."' AND uuidA=null) OR " .
							"( (uuidA='".$old_uuid."' OR uuidB='".$old_uuid."') AND ((AtoB=true AND BtoA=false) OR (BtoA=true AND AtoB=false)) )");
	// ��Ī �ȰŸ� set null
	db_query("UPDATE maum SET uuidA=null WHERE uuidA='".$old_uuid."'");
	db_query("UPDATE maum SET uuidB=null WHERE uuidB='".$old_uuid."'");
	
	// friend ���� delete
	db_query("DELETE FROM friend WHERE uuid='".$old_uuid."' OR fid='".$old_uuid."'");	
}


// ���ο� user ���
db_query("INSERT INTO user(uuid, phoneNum, appKey, name, message, maxMaum, cntMaum, itm1, itm2, itm3) " .
	"VALUES('".$uuid."', '".$phoneNum."', '".$appKey."', '".$name."', '', 3, 0, 0, 0, 0)");


// ��ȯ�� ���
echo "{code:1, appKey:'".$appKey."'}";
?>
