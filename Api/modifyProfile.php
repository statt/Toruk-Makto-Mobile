<?php
/*
 * Created on 2012. 5. 16.
 * 
=================================================
modifyProfile
# 프로필 변경
	request :
		token		#인증토큰
		name		#이름
		message		#남김말
		imgFlag		#프로필사진 변경 여부; 0이면 변경안함, 1이면 업로드&변경, 2이면 삭제
		image		#프로필사진
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
	raise_error(102, "token이 유효하지 않습니다.");
	return;
}
$uuid = $HTTP_SESSION_VARS['uuid'];
if(!$uuid){
	raise_error(106, "session이 유효하지 않습니다.");
	return;
}


// 기존 프로필 사진파일 삭제
if($imgFlag==1 || $imgFlag ==2){	// 파일 변경 또는 삭제 모드?
	$profileImgSrc = "/Api/profileImg/".$uuid; 
	if(is_file($profileImgSrc))	unlink($profileImgSrc);	// 원래 있던 파일 삭제
}
if($imgFlag==1){ //파일 변경 모드?
	//파일이 HTTP POST 방식을 통해 정상적으로 업로드되었는지 확인한다.
	if(is_uploaded_file($_FILES["image"]["tmp_name"])){  
		//echo "업로드한 파일명 : " . $_FILES["myFile"]["name"] . "<br />";
		//echo "업로드한 파일의 크기 : " . $_FILES["myFile"]["size"] . "<br />";    
		//echo "업로드한 파일의 MIME Type : " . $_FILES["myFile"]["type"] . "<br />";    
		//echo "임시 디렉토리에 저장된 파일명 : " . $_FILES["myFile"]["tmp_name"] . "<br />";    
      	//이미지 파일 테스트를 위한 코드 - 이미지 파일 테스트가 아니면 다음 라인은 삭제나 주석 후 실행    
      	//echo '<img src="' . $save_dir . $_FILES["myFile"]["name"] . '" alt="" />';
      
		//파일을 지정한 디렉토리에 저장    
		if(!move_uploaded_file($_FILES["image"]["tmp_name"], $profileImgSrc)){
			raise_error(605, "프로필 사진 복사를 실패하였습니다.");
			return;
		}    
	}else{
		raise_error(605, "프로필 사진이 업로드 되지 않았습니다.");
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
