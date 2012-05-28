<?php
/*
 * Created on 2012. 5. 14.
 */
session_start();

include 'lib/config.php';

// ���� �߻��� warning �޽����� �������� ǥ���� ������ ����
if($debug_mode)
	error_reporting();
else
	error_reporting(0);

// ���� �߻��� �α׸� ����� �����ڿ��� ������ ���� �� ȭ�鿣 �����ڵ�� �޽����� �����
function raise_error($errorcode, $message){
    global $debug_mode;
    global $system_operator_mail, $system_from_mail;
	
    $serror.=
    "timestamp: " . Date('m/d/Y H:i:s') . "\r\n" .
    "script:    " . $_SERVER['PHP_SELF'] . "\r\n" .
    "error:     " . $message ."\r\n\r\n";

    // open a log file and write error
    if($debug_mode){
    	echo "<pre>".$serror."</pre>";
    }else{
	    // e-mail error to system operator
	    $fhandle = fopen( '/logs/errors'.date('Ymd').'.txt', 'wa');
	    if($fhandle){
			fwrite( $fhandle, $serror );
			fclose(( $fhandle ));
	    }
	    mail($system_operator_mail, 'error: '.htmlspecialchars($message), $serror, 'From: ' . $system_from_mail );
    }
    echo("{code:" . $errorcode . ", message:\"" . htmlspecialchars($message) . "\"}");
}

// MySQL DB ����
$link = mysql_connect($db_hostname, $db_username, $db_pw);
mysql_query("SET NAMES UTF8");
if(mysql_errno()){
	raise_error(602, mysql_errno() . " : " . mysql_error());
	return;
}
$select = mysql_select_db("dittoapi", $link);
if(mysql_errno()){
	raise_error(603, mysql_errno() . " : " . mysql_error());
	return;
}

// MySQL ��������
function db_query( $query ){
  	global $debug_mode;
  	// Perform Query
  	$result = mysql_query($query);

	// Check result
	// This shows the actual query sent to MySQL, and the error. Useful for debugging.
  	if (!$result) {
   		raise_error(604, mysql_errno() . " " . mysql_error() . " : " . $query);
 	}
	return $result;
}
?>
