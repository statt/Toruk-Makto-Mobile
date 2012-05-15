<?php
/*
 * Created on 2012. 5. 14.
 */
session_start();

include 'lib/config.php';

if($debug_mode)
	error_reporting();	// enable the php warning messages when errors occurred
else
	error_reporting(0);	// disable the one

function raise_error( $message ){
    global $debug_mode;
    global $system_operator_mail, $system_from_mail;

    $serror=
    "timestamp: " . Date('m/d/Y H:i:s') . "\r\n" .
    "script:    " . $_SERVER['PHP_SELF'] . "\r\n" .
    "error:     " . $message ."\r\n\r\n";

    // open a log file and write error
    $fhandle = fopen( '/logs/errors'.date('Ymd').'.txt', 'a' );
    if($fhandle){
      fwrite( $fhandle, $serror );
      fclose(( $fhandle ));
     }
  
    // e-mail error to system operator
    if(!$debug_mode)
      mail($system_operator_mail, 'error: '.$message, $serror, 'From: ' . $system_from_mail );
}

// DB
$link = mysql_connect($db_hostname, $db_username, $db_pw);
if(mysql_errno()){
	raise_error(mysql_errno() . " : " . htmlspecialchars(mysql_error()));
	echo "{code:602,message:'" . mysql_error() . "'}";
}
$select = mysql_select_db("dittoapi", $link);

function db_query( $query ){
  	global $debug_mode;
  	// Perform Query
  	$result = mysql_query($query);

	// Check result
	// This shows the actual query sent to MySQL, and the error. Useful for debugging.
  	if (!$result) {
  		
  		if($debug_mode){
      		$message  = '<b>Invalid query:</b><br>' . mysql_error() . '<br><br>';
      		$message .= '<b>Whole query:</b><br>' . $query . '<br><br>';
      		die("602");
    	}
		echo "{code:602, message: '" . mysql_error() . "'}";
   		raise_error('db_query_error: ' . $message);
 	}
	return $result;
}

function escape_data($data){ 
 	global $dbc; 
 	if(ini_get('magic_quotes_gpc')){ 
  		$data=stripslashes($data); 
 	} 
	return mysql_real_escape_string(trim($data),$dbc); 
}
?>
