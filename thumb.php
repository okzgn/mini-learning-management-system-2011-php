<?php
	include("libs/inside.php");
	require_once 'libs/phpthumb/ThumbLib.inc.php';
	$exist = Get("src");
	$exist = file_exists($exist) ? $exist : "base/admin/notfound.jpg";
	$thumb = PhpThumbFactory::create($exist);  
	$thumb->adaptiveResize(Get("w"), Get("h"));  
	$thumb->show();  
?>  