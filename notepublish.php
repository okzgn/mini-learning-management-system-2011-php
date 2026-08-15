<?php
	include("libs/inside.php");
	session_start();
	$inside = isset($_SESSION["UserINSIDE"]);
	if(!$inside) header("location:" . $page_location);

	if(Post("usrnames") && Post("mynote")){
		$Publisher = Post("usrnames");
		$Publisher = (strlen($Publisher) > 22 ? substr($Publisher, 0, 22) . '...' : $Publisher);
		$After = file_get_contents("base/teacher/notes.txt");
		$Content = '<blockquote><h5><span class="s-pos-left"><strong>Publicador: </strong>' . $Publisher . '</span><span class="s-pos-right"><strong>Fecha de publicaci&oacute;n: </strong>' .  date("j") . '/' .  date("n") . '/' .  date("Y") . ' - ' .  (date("H") - 5) . ':' .  date("i") . ' ' .  date("a") . '</span></h5><span>' .  Post("mynote") . '</span></blockquote>' . $After;
		if(file_put_contents("base/teacher/notes.txt", $Content)) header("location:" . $page_location. "users.php?notepres=correct");
		else header("location:" . $page_location. "users.php?notepres=error");
	}
	else header("location:" . $page_location. "users.php?notepres=err1");
?>