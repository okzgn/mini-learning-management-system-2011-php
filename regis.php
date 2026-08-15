<?php
include("libs/inside.php");
include("libs/members.php");
session_start();
$inside = isset($_SESSION["UserINSIDE"]);
if($inside) header("location:" . $page_location);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head><title>Administraci&oacute;n UCE &gt; Registro</title><meta http-equiv="content-type" content="text/html; charset=iso-8859-1" /><meta name="robots" content="noindex, nofollow" /><meta http-equiv="content-language" content="es" /><link rel="shortcut icon" type="image/ico" href="images/gicon.ico" /><link rel="stylesheet" type="text/css" href="__data/base.css" /><link rel="stylesheet" type="text/css" href="__data/theme_skyblue.css" /><link rel="stylesheet" type="text/css" href="__data/plugins/jquery.fancybox.css" /><script type="text/javascript" src="__data/doc.x.js"></script><script type="text/javascript" src="__data/plugins/swfobject.js"></script><script type="text/javascript" src="__data/jquery.js"></script><script type="text/javascript" src="__data/plugins/jquery.fancybox.js"></script><script type="text/javascript" src="__data/doc.ui.js"></script>
</head>

<body>

<div id="LIM">
<div class="s-doc-space">

	<div class="Header">
		<div class="space">
			<a title="Ir a la p&aacute;gina principal" href="index.php"><h1 class="s-pos-left s-hidden"><span>Administraci&oacute;n UCE</span></h1></a>
			<div class="adds s-pos-right">
				<div class="links"><a href="index.php">P&aacute;gina principal</a>&nbsp;|&nbsp;<a href="students.php">Estudiantes</a>&nbsp;|&nbsp;<a href="users.php">Usuarios</a>&nbsp;|&nbsp;<strong>Registro</strong></div>
				<h4 class="s-pos-left">Registro estudiantes</h4>
			</div>
		</div>

	</div>

	<div class="Content">
		<div class="space s-box-clean">
			<?php
				if(MakeConnection() == "Ready"){
					$complete = (Post("user") && Post("password") && Post("again_password") && Post("names") && Post("age") && Post("email") && Post("curs") && Post("college"));
					if($complete){
						$user = Post("user");

						$e_user = mysql_query("select * from students where (user='". sha1($user) ."')");
						$exist_user = gettype(mysql_fetch_object($e_user)) != "boolean";

						$pwd = Post("password");
						$agnpwd = Post("again_password");
						$names = Post("names");
						$age = Post("age");
						$email = Post("email");
						$curs = Post("curs");
						$college = Post("college");
						$correct = (strlen($user) > 2 && strlen($pwd) > 5 && $pwd == $agnpwd && strlen($names) > 3 && strlen($age) == 2 && strlen($email) > 8 && strlen($curs) > 1 && strlen($college) > 7);
						if(!$exist_user && $correct){
							if(mysql_query("INSERT INTO students VALUES('". sha1($user) ."', '". sha1($pwd) ."', '". $names ."', '". $age ."', '" . $email . "', '" . $curs . "', '" . $college . "', 'normal')")) echo('<div class="s-siz-F s-pos-center s-squ-silver s-txt-center"><br />Has terminado de registrarte, ya puedes acceder al sistema<br /><br /><a class="s-button" href="users.php">Autentif&iacute;cate</a></div>');
							else header("location:" . $page_location);
						}
						else echo('<br /><strong class="s-spaced-A s-txt-center">' . ($exist_user ? 'Ya existe este usuario intenta con otro nombre de usuario' : 'Debes rellenar correctamente todos los campos del registro') . '<br /><br /><a class="s-button" href="regis.php">Reg&iacute;strate</a></strong>');
					}
					else {
			?>
			<div class="register s-pos-center s-siz-F s-squ-silver">
				<form action="regis.php" method="post">
					<fieldset>

						<h5 class="s-pos-right">Completa correctamente todos los campos del formulario</h5>
						<br />
						<strong class="s-spaced-B">Acceso a cuenta</strong>
						<div class="user">
							<h4><strong>*</strong> Nombre de usuario<br /></h4>
							<input type="text" class="s-frm-text" name="user" value="<?php echo (Post("user") ? Post("user") : ""); ?>" />
						</div>

						<div class="password">
							<h4><strong>*</strong> Contrase&ntilde;a<br /></h4>
							<input type="password" class="s-frm-text" name="password" />
						</div>

						<div class="agnpwd">
							<h4><strong>*</strong> Repetir contrase&ntilde;a<br /></h4>
							<input type="password" class="s-frm-text" name="again_password" />
						</div>

						<span class="s-separator">&nbsp;</span>
						<strong class="s-spaced-B">Informaci&oacute;n personal</strong>

						<div class="name">
							<h4><strong>*</strong> Nombres y apellidos<br /></h4>
							<input type="text" class="s-frm-text" name="names" value="<?php echo (Post("names") ? Post("names") : ""); ?>" />
						</div>

						<div class="age">
							<h4><strong>*</strong> Edad<br /></h4>
							<input type="text" class="s-frm-text" name="age" value="<?php echo (Post("age") ? Post("age") : ""); ?>" />
						</div>

						<div class="email">
							<h4><strong>*</strong> Direcci&oacute;n de e-mail<br /></h4>
							<input type="text" class="s-frm-text" name="email" value="<?php echo (Post("email") ? Post("email") : ""); ?>" />
						</div>

						<div class="curs">
							<h4><strong>*</strong> Curso<br /></h4>
							<input type="text" class="s-frm-text" name="curs" value="<?php echo (Post("curs") ? Post("curs") : ""); ?>" />
						</div>

						<div class="college">
							<h4><strong>*</strong> Colegio de procedencia<br /></h4>
							<input type="text" class="s-frm-text" name="college" value="<?php echo (Post("college") ? Post("college") : ""); ?>" />
						</div>

						<div class="s-txt-center">
							<input type="submit" class="s-frm-button" value="Registrar" /><br /><br />
						</div>

					</fieldset>
				</form>
			</div>
			<?php
					}
				}
				else {
			?>
			<br /><br /><h4 class="bigtext s-txt-center">El registro se ha desactivado temporalmente</h4><br /><br />
			<?php
				}
			?>
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
