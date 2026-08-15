<?php
include("libs/inside.php");
session_start();
$inside = isset($_SESSION["UserINSIDE"]);
if($inside){
	$User = explode("^^", base64_decode($_SESSION["UserINSIDE"]));
	$UserNames = $User[1];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head><title>Administraci&oacute;n UCE</title><meta http-equiv="content-type" content="text/html; charset=iso-8859-1" /><meta name="title" content="Administraci&oacute;n UCE" /><meta name="description" content="Sistema de informaci&oacute;n y calificaci&oacute;n para estudiantes" /><meta name="keywords" content="Administraci&oacute;n, UCE" /><meta name="robots" content="index, follow" /><meta name="revisit-after" content="15 days" /><meta http-equiv="content-language" content="es" /><link rel="shortcut icon" type="image/ico" href="images/gicon.ico" /><link rel="stylesheet" type="text/css" href="__data/base.css" /><link rel="stylesheet" type="text/css" href="__data/theme_skyblue.css" /><link rel="stylesheet" type="text/css" href="__data/plugins/jquery.fancybox.css" /><script type="text/javascript" src="__data/doc.x.js"></script><script type="text/javascript" src="__data/plugins/swfobject.js"></script><script type="text/javascript" src="__data/jquery.js"></script><script type="text/javascript" src="__data/plugins/jquery.fancybox.js"></script><script type="text/javascript" src="__data/doc.ui.js"></script>
</head>

<body>

<div id="LIM">
<div class="s-doc-space">

	<div class="Header">
		<div class="space">
			<a title="Ir a la p&aacute;gina principal" href="index.php"><h1 class="s-pos-left s-hidden"><span>Administraci&oacute;n UCE</span></h1></a>
			<div class="adds s-pos-right">
				<?php echo ($inside ? '<div class="links"><strong>P&aacute;gina principal</strong>&nbsp;|&nbsp;<a href="students.php">Estudiantes</a>&nbsp;|&nbsp;<a href="users.php">Cuenta</a>&nbsp;|&nbsp;<a href="logout.php">Cerrar sesi&oacute;n</a></div><br /><br /><br /><div class="links s-pos-right">Bienvenido/a, <strong>' . $UserNames . '</strong></div>' : '<div class="links"><strong>P&aacute;gina principal</strong>&nbsp;|&nbsp;<a href="students.php">Estudiantes</a>&nbsp;|&nbsp;<a href="users.php">Usuarios</a>&nbsp;|&nbsp;<a href="regis.php">Registro</a></div>'); ?>
			</div>
		</div>

	</div>

	<div class="Content">
		<div class="space s-box-clean">

			<div class="STUDENTSIDE s-pos-right">
				<div class="works s-squ-silver">
					<h3><a href="students.php">Estudiantes</a></h3>
					<div class="sphotos works-space s-box-clean">
					<?php

						$founded = MyFiles("base/files/");
						$numoff = count($founded);

						if($numoff > 0){
							foreach($founded as $fname){
								$file_ext = "." . substr($fname, strpos($fname, ".") + 1, strlen($fname));
								$file_atts = preg_split("/___/", $fname);
								$file_name = (strlen($file_atts[0]) > 22 ? substr($file_atts[0], 0, 20) . '...' : $file_atts[0]);
								if($file_name == "fotoperfil") echo '<a href="students.php?profile=' . substr($file_atts[1], 0, strpos($file_atts[1], ".")) . '"><img src="thumb.php?src=base/files/' . htmlentities($fname) . '&w=48&h=48" width="48" height="48" alt="Foto estudiante" /></a>';
							}
						}
						else {
							echo '<div class="nothing s-txt-center"><br />No hay estudiantes registrados</div>';
						}

					?>
					</div>
				</div>

				<?php if(!$inside){ ?>
				<div class="login s-squ-silver s-pos-center s-siz-1">
					<h2><a href="users.php">Autentificaci&oacute;n</a></h2>
					<form action="users.php" method="post">
						<fieldset>
							<span>Usuario</span>
							<input type="hidden" value="login" />
							<input class="s-frm-text" type="text" name="usr" /><br />

							<span>Contrase&ntilde;a</span>
							<input class="s-frm-text" type="password" name="pwd" /><br />
							<a class="s-pos-right s-button" href="regis.php">Reg&iacute;strate</a>
							<input class="s-frm-button" type="submit" value="Entrar" />

						</fieldset>
					</form>
				</div><?php } ?>
			</div>

			<div class="TEACHERSIDE s-pos-left s-box-clean">
				<div class="biganunce">
					<img src="thumb.php?src=base/teacher/biganunce.jpg&w=460&h=220" width="460" height="220" alt="Welcome" />
					<strong class="batext">Bienvenidos al sistema de informaci&oacute;n y calificaci&oacute;n por grupo de estudiantes.</strong>
				</div>
				<span class="s-separator">&nbsp;</span>
				<div class="anunces">
					<h4 class="s-spaced-A">Notas</h4>
					<div class="rememsbox s-squ-silver"><?php $notes = file_get_contents("base/teacher/notes.txt"); echo (strlen($notes) < 1 ? '<br /><br /><div class="nothing s-txt-center">Ning&uacute;n usuario ha publicado notas al momento, s&eacute; el primero</div>' : $notes); ?></div>
				</div>
			</div>

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
