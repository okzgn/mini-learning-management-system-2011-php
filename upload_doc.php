<html><head><title>Procesando</title></head><body>

<center><img src="images/loadbar.gif" width="220" height="19" alt="Progressbar" />
<?php
	include("libs/inside.php");
	session_start();
	$inside = isset($_SESSION["UserINSIDE"]);
	if(!$inside) header("location:" . $page_location);

	if(isset($_FILES["udoc"])){
		echo '<center><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><img src="images/loadbar.gif" width="220" height="19" alt="Progressbar" /><br /><span style="font:bold 8pt arial;color:#000;">Subiendo archivo ... espere<br /><br /><span style="font: normal 7pt arial;color:#999">Este proceso puede llegar a tardar algunos minutos</span>';
		$file_name = $_FILES["udoc"]["name"];
		$file_alltype = $_FILES["udoc"]["type"];
		$file_size = $_FILES["udoc"]["size"];
		$file_ext = strtolower("." . substr($file_name, strpos($file_name, ".") + 1, strlen($file_name)));

		$userid = Post("userid");
		$docname = Post("udocname");

		$file_newname = preg_replace("/\s+/", "_", $docname . "___" . $userid . "___" . date("j") . "-" .  date("n") . "-" .  date("Y") . $file_ext);

		if(strlen($docname) > 2 && strlen($docname) < 48 && !preg_match("/[\W]/", $docname)){
			if(!(($file_ext == ".doc" || $file_ext == ".xls" || $file_ext == ".ppt" || $file_ext == ".docx" || $file_ext == ".xlsx" || $file_ext == ".pptx") && ($file_size < 409600))) header("location:" . $page_location . "users.php?udocres=err2&$" . $file_ext . "=" . $file_size);
			else {
			    $targetDir = __DIR__ . '/base/files/';
     			if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
     			}

                if(move_uploaded_file($_FILES["udoc"]["tmp_name"], $targetDir . $file_newname)) header("location:" . $page_location . "users.php?udocres=correct");
				else header("location:" . $page_location . "users.php?udocres=err3");
			}
		}
		else header("location:" . $page_location . "users.php?udocres=err1");
	}
	else header("location:" . $page_location . "users.php?udocres=notfound");

?></body></html>
