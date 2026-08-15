<?php

require_once __DIR__ . '/mysql.mock.php';

$page_location = "./";

function Get($param){
	if(!isset($_GET[$param])) $param = null;
	else $param = $_GET[$param];
	return $param;
}

function Post($param){
	if(!isset($_POST[$param])) $param = null;
	else $param = $_POST[$param];
	return $param;
}



function MyFiles($folder, $userid = "all"){
	$DocFolder = scandir($folder);
	$Res = array();
	foreach($DocFolder as $filename){
		if(strlen($filename) > 2){
			$file = substr($filename, 0, strpos($filename, "."));
			$analize = preg_split("/___/", $file);
			$docname = $analize[0];
			$owner = $analize[1];
			if($userid == $owner) array_push($Res, $filename);
			if($userid == "all") array_push($Res, $filename);
		}
	}
	return $Res;
}


function RetrieveUser($userid, $quest){
	$userinfo = mysql_query("select * from students where (user='". $userid ."')");
	$res = mysql_fetch_object($userinfo);

	$response = false;

	switch($quest){
		case "names" :	$response = $res->names; break;
	}

	return $response;
}


?>
