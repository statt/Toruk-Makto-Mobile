<?php
/*
 * Created on 2012. 5. 16.
 * 
=================================================
modifyProfile
# ������ ����
	request :
		token		#������ū
		name		#�̸�
		message		#���踻
		imgFlag		#�����ʻ��� ���� ����; 0�̸� �������, 1�̸� ���ε�&����, 2�̸� ����
		image		#�����ʻ���
	response :
=================================================
 */
include 'lib/common.php';

if($debug_mode){
	// allow GET method
	$token = $_REQUEST["token"];
	$name = $_REQUEST["name"];
	$message = $_REQUEST["message"];
	$imgFlag = $_REQUEST["imgFlag"];
//	$image = $_REQUEST["image"];
}else{
	// do not allow GET method
	$token = $_POST["token"];
	$name = $_POST["name"];
	$message = $_POST["message"];
	$imgFlag = $_POST["imgFlag"];
//	$image = $_POST["image"];
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


// ���� ������ �������� ����
if($imgFlag==1 || $imgFlag ==2){	// ���� ���� �Ǵ� ���� ���?
	$profileImgSrc = "/Api/profileImg/".$uuid; 
	if(is_file($profileImgSrc))	unlink($profileImgSrc);	// ���� �ִ� ���� ����
}
if($imgFlag==1){ //���� ���� ���?
	//������ HTTP POST ����� ���� ���������� ���ε�Ǿ����� Ȯ���Ѵ�.
	if(is_uploaded_file($_FILES["image"]["tmp_name"])){  
		//echo "���ε��� ���ϸ� : " . $_FILES["myFile"]["name"] . "<br />";
		//echo "���ε��� ������ ũ�� : " . $_FILES["myFile"]["size"] . "<br />";    
		//echo "���ε��� ������ MIME Type : " . $_FILES["myFile"]["type"] . "<br />";    
		//echo "�ӽ� ���丮�� ����� ���ϸ� : " . $_FILES["myFile"]["tmp_name"] . "<br />";    
      	//�̹��� ���� �׽�Ʈ�� ���� �ڵ� - �̹��� ���� �׽�Ʈ�� �ƴϸ� ���� ������ ������ �ּ� �� ����    
      	//echo '<img src="' . $save_dir . $_FILES["myFile"]["name"] . '" alt="" />';
      
		//������ ������ ���丮�� ����    
		if(!move_uploaded_file($_FILES["image"]["tmp_name"], $profileImgSrc)){
			raise_error(605, "������ ���� ���縦 �����Ͽ����ϴ�.");
			return;
		}    
	}else{
		raise_error(605, "������ ������ ���ε� ���� �ʾҽ��ϴ�.");
		return;
	}
}

$query = "UPDATE user SET name='".$name."', message='".$message."'";
if($imgFlag==1 || $imgFlag==2){
	$query .= ", imageTs=now()";
}
db_query($query);
echo "{code:1}";
?>
