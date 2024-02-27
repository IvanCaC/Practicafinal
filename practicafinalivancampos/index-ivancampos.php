<?php
session_start(); //iniciamos ña sesion
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css"><!-- Link a la hoja de estilos css-->
    <title>Pagina principal ivan campos</title>
</head>
<body>
<div id="wrapper">
<h1>Pagina de inicio de sesion</h1>
 
<h2>Login de usuario</h2>
<form action="comprobador-ivancampos.php" method="POST"> <!-- Formulario con el que iniciaremos sesion-->
			<input type="text" name="usuario" placeholder="usuario"><br>
			<input type="password" name="password" placeholder="contraseña"><br>
			<button type="submit">Logear</button>

</form>
<br>
<h2>Creacion de usuario</h2>
<form action="crearusuarios-ivancampos.php" method="POST"> <!-- Formulario con el que crearemos nuevos usuarios -->
            <input type="text" name="usuario" maxlength="30"
				placeholder="usuario" required><br>
			<input type="password" name="password" maxlength="50"
				placeholder="contraseña"><br>
			<input type="password" name="password2" maxlength="50"
				placeholder="Repita contraseña" required><br>

            <button>Crear Usuario</button>
</form>
<h2>Abandonar sesion</h2><!-- Formulario con el que cerraremos sesion-->
<form action="index-ivancampos.php" method="POST">
    <button type="submit">Cerrar sesión</button>
</form>

<?php
        include "errores-ivancampos.php"; // incluimos una pagina con errores
        if(isset($_GET["error"])){
            $error=$_GET["error"];
            //if(isset($mensajeError[$error]))
                echo "<p><strong>Error:</strong> {$mensajeError[$error]}</p>";
        }
        ?>
<p></p>



</body>
</html>