<?php
	include("libs/inside.php");
	session_start();
	session_destroy();
	header("location:" . $page_location);
?>