<?php
	include("libs/inside.php");
	include("libs/members.php");
	session_start();
	$inside = isset($_SESSION["UserINSIDE"]);
	if($inside){
		$User = explode("^^", base64_decode($_SESSION["UserINSIDE"]));
		$UserNames	= $User[1];
		$UserAge	= $User[2];
		$UserEmail	= $User[3];
		$UserCurs	= $User[4];
		$UserCollege	= $User[5];
		$UserType	= $User[6];
		$UserID		= $User[7];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head><title>Administraci&oacute;n UCE &gt; Usuarios</title><meta http-equiv="content-type" content="text/html; charset=iso-8859-1" /><meta name="robots" content="noindex, nofollow" /><meta http-equiv="content-language" content="es" /><link rel="shortcut icon" type="image/ico" href="images/gicon.ico" /><link rel="stylesheet" type="text/css" href="__data/base.css" /><link rel="stylesheet" type="text/css" href="__data/theme_skyblue.css" /><link rel="stylesheet" type="text/css" href="__data/plugins/jquery.fancybox.css" /><script type="text/javascript" src="__data/doc.x.js"></script><script type="text/javascript" src="__data/plugins/swfobject.js"></script><script type="text/javascript" src="__data/jquery.js"></script><script type="text/javascript" src="__data/plugins/jquery.fancybox.js"></script><script type="text/javascript" src="__data/doc.ui.js"></script>
</head>

<body>

<div id="LIM">
<div class="s-doc-space">

	<div class="Header">
		<div class="space">
			<a title="Ir a la p&aacute;gina principal" href="index.php"><h1 class="s-pos-left s-hidden"><span>Administraci&oacute;n UCE</span></h1></a>
			<div class="adds s-pos-right">
				<?php echo ($inside ? '<div class="s-pos-right"><div class="links"><a href="index.php">P&aacute;gina principal</a>&nbsp;|&nbsp;<a href="students.php">Estudiantes</a>&nbsp;|&nbsp;<strong>Cuenta de usuario</strong>&nbsp;|&nbsp;<a href="logout.php">Cerrar sesi&oacute;n</a></div><br /><br /><br /><div class="links">Bienvenido/a, <strong>' . $UserNames . '</strong></div></div>' : '<div class="links s-pos-right"><a href="index.php">P&aacute;gina principal</a>&nbsp;|&nbsp;<a href="students.php">Estudiantes</a>&nbsp;|&nbsp;<strong>Usuarios</strong>&nbsp;|&nbsp;<a href="regis.php">Registro</a></div>'); ?>
				<?php echo ($inside ? '' : '<h4 class="s-pos-left">Usuarios</h4>'); ?>
			</div>
		</div>

	</div>

	<div class="Content">
		<div class="space s-box-clean">
			<?php
				if($inside){ ?>
					<?php
						if($UserType == "admin"){
					?>

					<div class="s-box-clean s-txt-right">
						<h4 class="bigtext s-pos-left">Administrador</h4>
						<a class="s-pos-right s-button" href="users.php?do=drnof">Borrar todas las notas</a>
						<?php if(Get("do") == "drnof"){ file_put_contents("base/teacher/notes.txt", ""); echo '<h5 class="s-txt-center"><strong>Tarea realizada</strong></h5><br />'; } ?>
					</div><br />

					<?php }?>


				<?php if($UserType != "teacher"){ ?>

				<div class="userpanel s-pos-center s-squ-silver s-box-clean">

					<h3>Archivos publicados</h3>
					<div id="user_files" class="s-box-clean">
					<?php

						$founded = MyFiles("base/files/", $UserID);
						$numoff = count($founded);

						if($numoff > 0){
							foreach($founded as $fname){
								$file_ext = strtolower("." . substr($fname, strpos($fname, ".") + 1, strlen($fname)));
								$file_atts = preg_split("/___/", $fname);
								$file_name = (strlen($file_atts[0]) > 22 ? substr($file_atts[0], 0, 20) . '...' : $file_atts[0]);
								if($file_ext == ".doc" || $file_ext == ".docx") echo '<a title="Descargar archivo Word: ' . $file_atts[0] . '" class="fword" href="base/files/' . htmlentities($fname) . '"><span>' . $file_name . '</span></a>';
								if($file_ext == ".xls" || $file_ext == ".xlsx") echo '<a title="Descargar archivo Excel: ' . $file_atts[0] . '" class="fexcl" href="base/files/' . htmlentities($fname) . '"><span>' . $file_name . '</span></a>';
								if($file_ext == ".ppt" || $file_ext == ".pptx") echo '<a title="Descargar archivo PowerPoint: ' . $file_atts[0] . '" class="fpowp" href="base/files/' . htmlentities($fname) . '"><span>' . $file_name . '</span></a>';
								if($file_ext == ".gif" ||
									$file_ext == ".jpeg" ||
									$file_ext == ".jpg" ||
									$file_ext == ".png") echo '<a title="Imagen:  ' . $file_atts[0] . '" class="fimag" href="base/files/' . htmlentities($fname) . '"><span>' . $file_name . '</span></a>';
							}
						}
						else {
							echo '<div class="nothing s-txt-center">No tienes documentos ni fotos publicadas</div>';
						}

					?>
					</div>
					<em class="little s-pos-right">* Si necesitaras actualizar o reemplazar un archivo, debes volverlo a subir con el mismo nombre.</em>
				</div>

				<?php } ?>




				<?php if($UserType != "teacher"){  ?>

				<span class="s-separator">&nbsp;</span>

				<div class="userin s-box-clean">
					<div class="photoup s-pos-left s-siz-C s-squ-silver">
						<h3>Subir fotos</h3><br />
						<form action="upload_photo.php" method="post" enctype="multipart/form-data">
							<fieldset class="s-txt-center"><?php
					if(Get("uphores") == "correct") echo '<div class="aler s-pos-center s-squ-green">La foto se ha publicado correctamente</div>';
					if(Get("uphores") == "notfound") echo '<div class="aler s-pos-center s-squ-redy">Lo siento, no se ha enviado ninguna imagen</div>';
					if(Get("uphores") == "err1") echo '<div class="aler s-pos-center s-squ-redy">Debes ponerle nombre a la foto</div>';
					if(Get("uphores") == "err2") echo '<div class="aler s-pos-center s-squ-redy">La imagen es muy grande o el tipo de archivo no es compatible</div>';
					if(Get("uphores") == "err3") echo '<div class="aler s-pos-center s-squ-redy">Ha ocurrido un error al cargar la imagen</div>';
							?>
							<h4 class="s-spaced-A">Selecciona un  archivo de imagen<sup>&nbsp;(200Kb m&aacute;ximo)</sup>:</h4>
							<input type="hidden" name="userid" value="<?php echo $UserID; ?>" />
							<input class="s-frm-text" name="uphoto" type="file" />
							<span class="s-separator">&nbsp;</span>
							<strong>Nombre de la foto:</strong><br />
							<input class="s-frm-text" name="uphoname" type="text" value="" />
							<a class="helpy s-lil-button" href="javascript:void(0)"><span>?</span></a>
							<blockquote class="helpbox s-starbox s-squ-orange s-txt-left"><strong>Recuerda:</strong><br />Los nombres solo pueden contener caracteres alfanum&eacute;ricos, sin espacios ni s&iacute;mbolos.</blockquote><br />
							<input class="s-frm-button" type="submit" value="Publicar" /></fieldset>
						</form>
					</div>
					<div class="docup s-pos-right s-siz-D s-squ-silver">
						<h3>Subir documentos</h3><br />
						<form action="upload_doc.php" method="post" enctype="multipart/form-data">
							<fieldset class="s-txt-center"><?php
					if(Get("udocres") == "correct") echo '<div class="aler s-pos-center s-squ-green">El documento se ha publicado correctamente</div>';
					if(Get("udocres") == "notfound") echo '<div class="aler s-pos-center s-squ-redy">Lo siento, no se ha enviado ning&uacute;n documento</div>';
					if(Get("udocres") == "err1") echo '<div class="aler s-pos-center s-squ-redy">Debes ponerle nombre al documento</div>';
					if(Get("udocres") == "err2") echo '<div class="aler s-pos-center s-squ-redy">El documento es muy grande o el tipo de archivo no es compatible</div>';
					if(Get("udocres") == "err3") echo '<div class="aler s-pos-center s-squ-redy">Ha ocurrido un error al cargar el documento</div>';
							?>
							<h4 class="s-spaced-A">Selecciona un archivo de Office<sup>&nbsp;(400Kb m&aacute;ximo)</sup>:</h4>
							<input type="hidden" name="userid" value="<?php echo $UserID; ?>" />
							<input class="s-frm-text" name="udoc" type="file" />
							<span class="s-separator">&nbsp;</span>
							<strong>Nombre del documento:</strong><br />
							<input class="s-frm-text" name="udocname" type="text" value="" />
							<a class="helpy s-lil-button" href="javascript:void(0)"><span>?</span></a>
							<blockquote class="helpbox s-starbox s-squ-orange s-txt-left"><strong>Recuerda:</strong><br />Los nombres solo pueden contener caracteres alfanum&eacute;ricos, sin espacios ni s&iacute;mbolos.</blockquote><br />
							<input class="s-frm-button" type="submit" value="Publicar" /></fieldset>
						</form>
					</div>
				</div>
				<span class="s-separator">&nbsp;</span>

				<?php } ?>




				<?php if($UserType == "teacher"){  ?>

					<h3>Documentos existentes</h3>
					<div id="user_files" class="teacherfiles s-box-clean">
					<div class="indexes"><blockquote class="s-siz-E"><strong>Nombre archivo</strong></blockquote><blockquote class="s-siz-A"><strong>Estudiante</strong></blockquote><blockquote class="s-siz-4"><strong>Fecha</strong></blockquote><blockquote class="s-siz-4"><strong>Nota</strong></blockquote></div>
					<?php

						$founded = MyFiles("base/files/");
						$numoff = count($founded);
						MakeConnection();
						if($numoff > 0){
							$docs = 0;
							$dcode = "";

							foreach($founded as $fname){
								$file_ext = strtolower("." . substr($fname, strpos($fname, ".") + 1, strlen($fname)));
								$file_atts = preg_split("/___/", $fname);
								$file_name = $file_atts[0];
								if($file_ext == ".doc" || $file_ext == ".docx"){ $docs++; $dcode .= '<blockquote class="s-siz-E"><a title="Descargar archivo Word" class="tfile fword" href="base/files/' . htmlentities($fname) . '"><span>' . $file_name . '</span></a></blockquote><blockquote class="s-siz-A"><a class="nml" href="students.php?profile=' . $file_atts[1] . '">' . (strlen(RetrieveUser($file_atts[1], "names")) > 20 ? substr(RetrieveUser($file_atts[1], "names"), 0, 20) . '...' : RetrieveUser($file_atts[1], "names")) . '</a></blockquote><blockquote class="s-siz-4">' . (strpos($file_atts[2], ".") === false ? $file_atts[2] : substr($file_atts[2], 0, strpos($file_atts[2], "."))) . '</blockquote><blockquote class="npoint s-siz-4"><input type="hidden" value="' . $fname . '" /><input type="text" value="' . (isset($file_atts[3]) ? substr($file_atts[3], 0, strpos($file_atts[3], ".")) : "") . '" /></blockquote>'; }
								if($file_ext == ".xls" || $file_ext == ".xlsx"){ $docs++; $dcode .= '<blockquote class="s-siz-E"><a title="Descargar archivo Excel" class="tfile fexcl" href="base/files/' . htmlentities($fname) . '"><span>' . $file_name . '</span></a></blockquote><blockquote class="s-siz-A"><a class="nml" href="students.php?profile=' . $file_atts[1] . '">' . (strlen(RetrieveUser($file_atts[1], "names")) > 20 ? substr(RetrieveUser($file_atts[1], "names"), 0, 20) . '...' : RetrieveUser($file_atts[1], "names")) . '</a></blockquote><blockquote class="s-siz-4">' . (strpos($file_atts[2], ".") === false ? $file_atts[2] : substr($file_atts[2], 0, strpos($file_atts[2], "."))) . '</blockquote><blockquote class="npoint s-siz-4"><input type="hidden" value="' . $fname . '" /><input type="text" value="' . (isset($file_atts[3]) ? substr($file_atts[3], 0, strpos($file_atts[3], ".")) : "") . '" /></blockquote>'; }
								if($file_ext == ".ppt" || $file_ext == ".pptx"){ $docs++; $dcode .= '<blockquote class="s-siz-E"><a title="Descargar archivo Excel" class="tfile fexcl" href="base/files/' . htmlentities($fname) . '"><span>' . $file_name . '</span></a></blockquote><blockquote class="s-siz-A"><a class="nml" href="students.php?profile=' . $file_atts[1] . '">' . (strlen(RetrieveUser($file_atts[1], "names")) > 20 ? substr(RetrieveUser($file_atts[1], "names"), 0, 20) . '...' : RetrieveUser($file_atts[1], "names")) . '</a></blockquote><blockquote class="s-siz-4">' . (strpos($file_atts[2], ".") === false ? $file_atts[2] : substr($file_atts[2], 0, strpos($file_atts[2], "."))) . '</blockquote><blockquote class="npoint s-siz-4"><input type="hidden" value="' . $fname . '" /><input type="text" value="' . (isset($file_atts[3]) ? substr($file_atts[3], 0, strpos($file_atts[3], ".")) : "") . '" /></blockquote>'; }
							}

							echo ($docs == 0 ? '<div class="nothing s-txt-center"><br />No hay ning&uacute;n documento publicado por los estudiantes<br /><br /></div>' : '<div>' . $dcode . '</div>');

						}
						else {
							echo '<div class="nothing s-txt-center">No hay documentos ni fotos</div>';
						}

					?>
					</div>

				<?php }  ?>














				<div class="usernotes s-pos-center s-squ-silver s-siz-F">
					<h2>Publicar Notas</h2><br />
					<form action="notepublish.php" method="post">
						<fieldset>				<?php

					if(Get("notepres") == "correct") echo '<div class="aler s-pos-center s-squ-green s-siz-E">Tu nota se ha publicado</div>';
					if(Get("notepres") == "err1") echo '<div class="aler s-pos-center s-squ-redy s-siz-E">La nota debe tener contenido</div>';
					if(Get("notepres") == "error") echo '<div class="aler s-pos-center s-squ-redy s-siz-E">Ha ocurrido un error al publicar la nota</div>';


				?>
						<input type="hidden" name="usrnames" value="<?php echo $UserNames; ?>" />
						<strong>Contenido de la nota:</strong>
						<input class="s-frm-text" name="mynote" type="text" value="" />
						<input class="s-frm-button" type="submit" value="Enviar" />
						</fieldset>
					</form>
				</div>

				<?php
				}
				else {
					$usr = Post("usr");
					$pwd = Post("pwd");
					if(MakeConnection() == "Ready" && $usr && $pwd){
						$suser = mysql_query("select * from students where (user='" . sha1($usr) . "' And pass='" . sha1($pwd) . "')");
						$result = mysql_fetch_object($suser);
						if(gettype($result) != "boolean"){
							$Student = $result;
							$_SESSION["UserINSIDE"] = base64_encode(session_id() . "^^" . ($Student -> names) . "^^" . ($Student -> age) . "^^" . ($Student -> email) . "^^" . ($Student -> curs) . "^^" . ($Student -> college) . "^^" . ($Student -> details) . "^^" . ($Student -> user));
							header("location:" . $page_location);
						}
						else {
							echo '<div class="novalid s-pos-center s-squ-redy s-siz-D">La contrase&ntilde;a o usuario son incorrectos</div>';
						}
					}
			?>

			<div class="login s-pos-center s-siz-B s-squ-silver">
				<h2>Autentificaci&oacute;n</h2>
				<form action="users.php" method="post">
					<fieldset>
						<span class="s-spaced-A">Usuario</span>
						<input type="hidden" value="login" />
						<input class="s-frm-text" type="text" name="usr" /><br />

						<span class="s-spaced-A">Contrase&ntilde;a</span>
						<input class="s-frm-text" type="password" name="pwd" /><br />
						<a class="s-pos-right s-button" href="regis.php">Reg&iacute;strate</a>
						<input class="s-frm-button" type="submit" value="Entrar" />
					</fieldset>
				</form>
			</div>


			<?php } ?>
		</div>
	</div>

	<div class="Footer">
		<div class="space s-txt-center">2011 &copy; Administraci&oacute;n UCE. Todos los derechos reservados. Creado por <a href="https://okzgn.com">OKZGN</a>
		</div>
	</div>

</div>
</div>

</body>
</html>
