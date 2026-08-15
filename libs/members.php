<?php

include_once("inside.php");



function MakeConnection(){
	$Conn = mysql_connect("localhost", "root", "");
	$SelectDB = mysql_query("use uce;");
	$Status = "Not";
	if(!$SelectDB){
		$CreateDB = mysql_query("create uce;");
		$SelectDB = mysql_query("use uce;");
		if(!!$CreateDB && !!$SelectDB) $Status = "Ready";
	}
	else $Status = "Ready";

	return $Status;
}

?>
