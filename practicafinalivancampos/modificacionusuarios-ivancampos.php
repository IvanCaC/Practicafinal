<?php

session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario"])) {
    header("Location:index-ivancampos.php");
    exit();
}
else{

$mysqli = new mysqli("127.0.0.1", "root", "", "practicafinal");

if ($mysqli->connect_error) {
    die("Error al realizar la conexión: " . $mysqli->connect_error);
}

// Insertar, Borrar o Actualizar artículo
if (isset($_POST["insertar"])) {
    if (isset($_POST["usuario"]) && isset($_POST["pass"]) ) {
        $usuario = $_POST["usuario"];
        $pass = $_POST["pass"];
        $sql = "INSERT INTO usuarios  VALUES ('$usuario', '$pass')";

        if ($mysqli->query($sql)) {
            echo "Inserción exitosa";
        } else {
            echo "Error en la inserción: " . $mysqli->error;
        }
    }
} elseif (isset($_POST["borrar"])) {
    if (isset($_POST["usuario"])) {
        $usuario = $_POST["usuario"];
        $sql = "DELETE FROM usuarios WHERE usuario = '$usuario'";

        if ($mysqli->query($sql)) {
            echo "Borrado exitoso";
        } else {
            echo "Error en el borrado: " . $mysqli->error;
        }
    }
} elseif (isset($_POST["actualizar"])) {
    if (isset($_POST["usuario"]) && isset($_POST["pass"]) ) {
        $usuario = $_POST["usuario"];
        $pass = $_POST["pass"];

        $sql = "UPDATE usuarios SET pass='$pass' WHERE usuario='$usuario'";

        if ($mysqli->query($sql)) {
            echo "Actualización exitosa";
        } else {
            echo "Error en la actualización: " . $mysqli->error;
        }
    }
  
}
elseif (isset($_POST["gestion_articulos"])){
    header("Location:articulos-ivancampos.php");
}
elseif (isset($_POST["cerrar_sesion"])){
    header("Location:cerrarsesionivancampos.php");
}
}

$sql = "SELECT usuario,pass FROM usuarios";
$res = $mysqli->query($sql);

if ($res) {
    echo "<h1>Lista de Usuarios disponibles</h1>";
    echo "<table border=1>
            <tr>
                <th>usuario</th>
                <th>pass</th>
            </tr>";

    while ($fila = $res->fetch_assoc()) {
        echo "<tr>
                <td>{$fila["usuario"]}</td>
                <td>{$fila["pass"]}</td>
              </tr>";
    }

    echo "</table>";
    $res->close(); // cierre de la instrucción
} else {
    echo "Error en la consulta: " . $mysqli->error;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Artículos</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div table >
    <div id="wrapper">
    <h2>Insertar, Borrar y Actualizar Artículos</h2>
    <form action="modificacionusuarios-ivancampos.php" method="POST">
        <label for="usuario">Usuario</label>
        <input type="text" name="usuario" id="usuario" required>
        <label for="pass">Pass</label>
        <input type="text" name="pass" id="pass" >
        <button type="submit" name="insertar">Insertar</button>
        <button type="submit" name="borrar">Borrar</button>
        <button type="submit" name="actualizar">Actualizar</button>
        
     
    </form>
    <form action="modificacionusuarios-ivancampos.php" method="POST">
        <button type="submit" name="gestion_articulos">volver a gestionar articulos</button>
        </form>
    </div>
    <form action="modificacionusuarios-ivancampos.php" method="POST">
    <button type="submit" name="cerrar_sesion">Cerrar session</button>
    </form>
    
    </div>
</body>
</html>
