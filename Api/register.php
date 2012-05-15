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
		nums[]		#주소록에 저장되어있는 사람들의 국가코드+전화번호 리스트
	response :
		appKey		#인증키값
=================================================
*/
include 'lib/config.php';
include 'lib/common.php';

?>
