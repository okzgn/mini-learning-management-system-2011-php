<?php
	include("libs/inside.php");
	include("libs/members.php");
	session_start();
	$inside = isset($_SESSION["UserINSIDE"]);
	if($inside){
		$User = explode("^^", base64_decode($_SESSION["UserINSIDE"]));
		$UserNames = $User[1];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head><title>Administraci&oacute;n UCE &gt; Estudiantes</title><meta http-equiv="content-type" content="text/html; charset=iso-8859-1" /><meta name="robots" content="index, follow" /><meta http-equiv="content-language" content="es" /><link rel="shortcut icon" type="image/ico" href="images/gicon.ico" /><link rel="stylesheet" type="text/css" href="__data/base.css" /><link rel="stylesheet" type="text/css" href="__data/theme_skyblue.css" /><link rel="stylesheet" type="text/css" href="__data/plugins/jquery.fancybox.css" /><script type="text/javascript" src="__data/doc.x.js"></script><script type="text/javascript" src="__data/plugins/swfobject.js"></script><script type="text/javascript" src="__data/jquery.js"></script><script type="text/javascript" src="__data/plugins/jquery.fancybox.js"></script><script type="text/javascript" src="__data/doc.ui.js"></script>
</head>

<body>

<div id="LIM">
<div class="s-doc-space">

	<div class="Header">
		<div class="space">
			<a title="Ir a la p&aacute;gina principal" href="index.php"><h1 class="s-pos-left s-hidden"><span>Administraci&oacute;n UCE</span></h1></a>
			<div class="adds s-pos-right">
				<?php echo ($inside ? '<div class="s-pos-right"><div class="links"><a href="index.php">P&aacute;gina principal</a>&nbsp;|&nbsp;<strong>Estudiantes</strong>&nbsp;|&nbsp;<a href="users.php">Cuenta</a>&nbsp;|&nbsp;<a href="logout.php">Cerrar sesi&oacute;n</a></div><br /><br /><br /><div class="links">Bienvenido/a, <strong>' . $UserNames . '</strong></div></div>' : '<div class="links s-pos-right"><a href="index.php">P&aacute;gina principal</a>&nbsp;|&nbsp;<strong>Estudiantes</strong>&nbsp;|&nbsp;<a href="users.php">Usuarios</a>&nbsp;|&nbsp;<a href="regis.php">Registro</a></div>'); ?>
				<?php echo ($inside ? '' : '<h4 class="s-pos-left">Estudiantes</h4>'); ?>
			</div>
		</div>

	</div>

	<div class="Content">
		<div class="space s-box-clean">
			<div class="students sphotos s-squ-silver s-pos-center s-box-clean s-siz-1">
				<?php if(!Get("profile")){ ?>

				<?php echo ($inside ? '<h3>Estudiantes</h3>' : ''); ?>
				<div class="students-space">
					<strong class="s-spaced-B s-txt-center">Grupo de estudiantes</strong>
					<?php

						$founded = MyFiles("base/files/");
						$numoff = count($founded);

						if($numoff > 0){
							foreach($founded as $fname){
								$file_ext = "." . substr($fname, strpos($fname, ".") + 1, strlen($fname));
								$file_atts = preg_split("/___/", $fname);
								$file_name = (strlen($file_atts[0]) > 22 ? substr($file_atts[0], 0, 20) . '...' : $file_atts[0]);
								if($file_name == "fotoperfil") echo '<a href="students.php?profile=' . substr($file_atts[1], 0, strpos($file_atts[1], ".")) . '"><img src="thumb.php?src=base/files/' . htmlentities($fname) . '&w=69&h=69" width="69" height="69" alt="Foto estudiante" /></a>';
							}
						}
						else {
							echo '<div class="nothing s-txt-center"><br />No hay estudiantes registrados</div>';
						}



					?>
				</div>
				<?php } else {
					if(MakeConnection() == "Ready"){
						$userid = Get("profile");
						$e_user = mysql_query("select * from students where (user='". $userid ."')");
						$useratt = mysql_fetch_object($e_user);

				?>

				<h3><?php echo $useratt->names; ?></h3>
				<div class="profile students-space"><div class="gatr">
					<?php
						$founded = MyFiles("base/files/", $userid);
						$numoff = count($founded);
						if($numoff > 0){
							foreach($founded as $fname){
								$file_ext = "." . substr($fname, strpos($fname, ".") + 1, strlen($fname));
								$file_atts = preg_split("/___/", $fname);
								$file_name = (strlen($file_atts[0]) > 22 ? substr($file_atts[0], 0, 20) . '...' : $file_atts[0]);
								if($file_name == "fotoperfil") echo '<img src="thumb.php?src=base/files/' . htmlentities($fname) . '&w=96&h=96" width="96" height="96" alt="Foto estudiante" />';
							}
						}
					?>
					<strong>Colegio: </strong><span><?php echo $useratt->college; ?></span><br />
					<strong>Edad: </strong><span><?php echo $useratt->age; ?></span><br />
					<strong>E-mail: </strong><span><?php echo $useratt->email; ?></span><br />
					<strong>Curso: </strong><span><?php echo $useratt->curs; ?></span><br /></div>
					<h2>Archivos</h2>
					<div id="user_files" class="studentfiles s-box-clean">
					<?php

						$founded = MyFiles("base/files/", $userid);
						$numoff = count($founded);

						if($numoff > 0){
							$docs = 0;
							$dcode = "";
							$phos = 0;
							$pcode = "";

							foreach($founded as $fname){
								$file_ext = strtolower("." . substr($fname, strpos($fname, ".") + 1, strlen($fname)));
								$file_atts = preg_split("/___/", $fname);
								$file_name = (strlen($file_atts[0]) > 14 ? substr($file_atts[0], 0, 14) . '...' : $file_atts[0]);
								if($file_ext == ".doc" || $file_ext == ".docx"){ $docs++; $dcode .= '<a title="Descargar archivo Word: ' . $file_atts[0] . '" class="fword" href="base/files/' . htmlentities($fname) . '"><span class="pt">' . (isset($file_atts[3]) ? substr($file_atts[3], 0, strpos($file_atts[3], ".")) : "") . '</span><span>' . $file_name . '</span></a>'; }
								if($file_ext == ".xls" || $file_ext == ".xlsx"){ $docs++; $dcode .= '<a title="Descargar archivo Excel: ' . $file_atts[0] . '" class="fexcl" href="base/files/' . htmlentities($fname) . '"><span class="pt">' . (isset($file_atts[3]) ? substr($file_atts[3], 0, strpos($file_atts[3], ".")) : "") . '</span><span>' . $file_name . '</span></a>'; }
								if($file_ext == ".ppt" || $file_ext == ".pptx"){ $docs++; $dcode .= '<a title="Descargar archivo PowerPoint: ' . $file_atts[0] . '" class="fpowp" href="base/files/' . htmlentities($fname) . '"><span class="pt">' . (isset($file_atts[3]) ? substr($file_atts[3], 0, strpos($file_atts[3], ".")) : "") . '</span><span>' . $file_name . '</span></a>'; }
							}

							echo ($docs == 0 ? '<h4>Documentos (' . $docs. ')</h4><span class="s-separator">&nbsp;</span>' : '<h4 class="s-spaced-A">Documentos (' . $docs. ')</h4><div>' . $dcode . '</div><span class="s-separator">&nbsp;</span>');

							foreach($founded as $fname){
								$file_ext = strtolower("." . substr($fname, strpos($fname, ".") + 1, strlen($fname)));
								$file_atts = preg_split("/___/", $fname);
								$file_name = (strlen($file_atts[0]) > 22 ? substr($file_atts[0], 0, 20) . '...' : $file_atts[0]);
								if($file_ext == ".gif" ||
									$file_ext == ".jpeg" ||
									$file_ext == ".jpg" ||
									$file_ext == ".png"){ $phos++; $pcode .= '<a title="Imagen:  ' . $file_atts[0] . '" class="fimag" href="base/files/' . htmlentities($fname) . '"><span>' . $file_name . '</span></a>'; }
							}

							echo ($phos == 0 ? '<h4 class="s-spaced-A">Fotos (' . $phos. ')</h4>' : '<h4 class="s-spaced-A">Fotos (' . $phos. ')</h4><div>' . $pcode . '</div>');
						}
						else {
							echo '<div class="nothing s-txt-center">No tienes documentos ni fotos publicadas</div>';
						}

					?>
					</div>
				</div>

				<?php }} ?>
			</div>
		</div>
	</div>

	<div class="Footer">
		<div class="space s-txt-center">2010-2011 &copy; Administraci&oacute;n UCE. Todos los derechos reservados. Creado por <a href="https://okzgn.com">OKZGN</a>
		</div>
	</div>

</div>
</div>

</body>
</html>
