<?php
/*
Created on 2012. 5. 14.
=================================================
register
# 사용자 등록을 해주는 API.
# 프로그램 설치후 최초실행 1회만 호출.
	request :
		uuid		#앱고유번호	(UUID, http://huewu.blog.me/110107222113 참조. 사용자ID와 같은 역할)
		phoneNum	#국가코드+전화번호 (전화번호 없는 기기는 그냥 빈 문자열)
		name		#사용자 이름(스마트폰에 저장된 값 사용)
// 추후 signature 기능을 추가하여
// register 콜로 임의의 사용자 정보를 삭제하는 공격을 방어해야 함 ***************
	response :
		appKey		#인증키값
=================================================
해당 phoneNum의 기존 uuid를 찾아서 user정보에서 삭제
중복된 번호를 가졌던 사용자 프로필 사진파일 삭제
중복된 번호를 가졌던 user 정보 삭제
maum 정보 삭제(매칭 안된거 또는 둘다 널되는거면 그냥 지워버리고, 매칭 된거면 set null)
friend 정보 delete
user테이블에 새 데이터 생성
번호목록으로부터 친구리스트 생성
클라이언트에게 appKey 부여
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
		raise_error(0, "앱 고유번호가 null입니다.");
		return;
	}
}


// 클라이언트에게 고유 키를 부여해 준다.
$appKey = sha1($uuid.$phoneNum."시간은흐른다울거나웃거나아프거나달거나쓰거나");


// 중복된 번호를 가졌던 사용자 정보를 초기화 시킴
if($phoneNum){
	// 전화기능이 없는 모바일 기기는 전화번호가 없으므로 이 과정을 생략
	
	// 중복된 번호를 가졌던 uuid를 획득
	$result = db_query("SELECT uuid FROM user WHERE phoneNum='".$phoneNum."'");
	$old_uuid_set = mysql_fetch_row($result);
	$old_uuid = $old_uuid_set[0];
	
	// 중복된 번호를 가졌던 사용자 프로필 사진파일 삭제
	$profileImgSrc = "/Api/profileImg/".$old_uuid; 
	if(is_file($profileImgSrc))	unlink($profileImgSrc);
	
	// 중복된 번호를 가졌던 user 정보 삭제
	db_query("DELETE FROM user WHERE uuid='".$old_uuid."'");
	
	// maum 정보 삭제
	// 매칭 안된거 또는 둘다 널되는거면 그냥 지워버리고,
	db_query("DELETE FROM maum WHERE " .
			"(uuidA='".$old_uuid."' AND uuidB=null) OR " .
					"(uuidB='".$old_uuid."' AND uuidA=null) OR " .
							"( (uuidA='".$old_uuid."' OR uuidB='".$old_uuid."') AND ((AtoB=true AND BtoA=false) OR (BtoA=true AND AtoB=false)) )");
	// 매칭 된거면 set null
	db_query("UPDATE maum SET uuidA=null WHERE uuidA='".$old_uuid."'");
	db_query("UPDATE maum SET uuidB=null WHERE uuidB='".$old_uuid."'");
	
	// friend 정보 delete
	db_query("DELETE FROM friend WHERE uuid='".$old_uuid."' OR fid='".$old_uuid."'");	
}


// 새로운 user 등록
db_query("INSERT INTO user(uuid, phoneNum, appKey, name, message, maxMaum, cntMaum, itm1, itm2, itm3) " .
	"VALUES('".$uuid."', '".$phoneNum."', '".$appKey."', '".$name."', '', 3, 0, 0, 0, 0)");


// 반환값 출력
echo "{code:1, appKey:'".$appKey."'}";
?>
