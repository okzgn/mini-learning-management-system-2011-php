<?php
	include("libs/inside.php");
	session_start();
	$inside = isset($_SESSION["UserINSIDE"]);
	if(!$inside) header("location:" . $page_location);

	$after = explode(".", Post("file"));
	$real = explode("___", $after[0]);
	$real = $real[0] . "___" . $real[1] . "___"  . $real[2];
	$stat = rename("base/files/" . Post("file"), "base/files/". $real . "___" . Post("point") . "." . $after[1]);

	echo $stat;

?>