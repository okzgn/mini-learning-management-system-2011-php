<html><head><title>Procesando</title></head><body><?php
	include("libs/inside.php");
	session_start();
	$inside = isset($_SESSION["UserINSIDE"]);
	if(!$inside) header("location:" . $page_location);

	if(isset($_FILES["uphoto"])){
		echo '<center><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><img src="images/loadbar.gif" width="220" height="19" alt="Progressbar" /><br /><span style="font:bold 8pt arial;color:#000;">Subiendo archivo ... espere<br /><br /><span style="font: normal 7pt arial;color:#999">Este proceso puede llegar a tardar algunos minutos</span>';
		$file_name = $_FILES["uphoto"]["name"];
		$file_alltype = $_FILES["uphoto"]["type"];
		$file_size = $_FILES["uphoto"]["size"];
		$file_ext = strtolower("." . substr($file_alltype, strpos($file_alltype, "/") + 1, strlen($file_alltype)));

		$userid = Post("userid");
		$photoname = Post("uphoname");

		$file_newname = preg_replace("/\s+/", "_", $photoname . "___" . $userid . ($photoname == "fotoperfil" ?  "" :  "___" . date("j") . "-" .  date("n") . "-" .  date("Y")) . $file_ext);

		if(strlen($photoname) > 2 && strlen($photoname) < 48 && !preg_match("/[\W]/", $photoname)){
			if(!(($file_ext == ".gif" || $file_ext == ".jpeg" || $file_ext == ".png") && ($file_size < 204800))) header("location:" . $page_location . "users.php?uphores=err2");
			else {
			    $targetDir = __DIR__ . '/base/files/';
     			if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
     			}

                if(move_uploaded_file($_FILES["uphoto"]["tmp_name"], $targetDir . $file_newname)) header("location:" . $page_location . "users.php?uphores=correct");
				else header("location:" . $page_location . "users.php?uphores=err3");
			}
		}
		else header("location:" . $page_location . "users.php?uphores=err1");
	}
	else header("location:" . $page_location . "users.php?uphores=notfound");

?></body></html>
