<?php

session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario"])) { // si no inicia sesion volvemos al index
    header("Location:index-ivancampos.php");
    exit();
}
else{ // iniciamos sesion

$mysqli = new mysqli("127.0.0.1", "root", "", "practicafinal"); //nos concetanos a la base de datos

if ($mysqli->connect_error) { // si hay un error 
    die("Error al realizar la conexión: " . $mysqli->connect_error);
}

// Insertar, Borrar o Actualizar artículo
if (isset($_POST["insertar"])) { // con los datos del formulario de abajo los asignamos a variables
    if (isset($_POST["coda"]) && isset($_POST["nombre"]) && isset($_POST["pvp"]) && isset($_POST["iva"])) {
        $coda = $_POST["coda"];
        $nombre = $_POST["nombre"];
        $pvp = $_POST["pvp"];
        $iva = $_POST["iva"];

        $sql = "INSERT INTO articulos (coda, nombre, pvp, iva) VALUES ('$coda', '$nombre', $pvp, $iva)"; // consulta para insertar vakires a la base de datos
 
        if ($mysqli->query($sql)) { // si funciona la consulta insertamos correctamente
            echo "Inserción exitosa";
        } else {
            echo "Error en la inserción: " . $mysqli->error; // si no funciona error
        }
    }
} elseif (isset($_POST["borrar"])) { // con los datos del formulario de abajo los asignamos a variables
    if (isset($_POST["coda"])) {
        $coda = $_POST["coda"];
        $sql = "DELETE FROM articulos WHERE coda = '$coda'";// consulta para borrar vakires a la base de datos

        if ($mysqli->query($sql)) {
            echo "Borrado exitoso";// si funciona la consulta borramos correctamente
        } else {
            echo "Error en el borrado: " . $mysqli->error;// si no funciona error
        }
    }
} elseif (isset($_POST["actualizar"])) {
    if (isset($_POST["coda"]) && isset($_POST["nombre"]) && isset($_POST["pvp"]) && isset($_POST["iva"])) {
        $coda = $_POST["coda"];
        $nombre = $_POST["nombre"];
        $pvp = $_POST["pvp"];
        $iva = $_POST["iva"];

        $sql = "UPDATE articulos SET nombre='$nombre', pvp=$pvp, iva=$iva WHERE coda='$coda'";// Consulta para actualizar la base de datos

        if ($mysqli->query($sql)) {
            echo "Actualización exitosa";// si funciona la consulta actualizamos correctamente
        } else {
            echo "Error en la actualización: " . $mysqli->error;// si no funciona error
        }
    }
  
}
elseif (isset($_POST["cerrar_sesion"])){  // si seleccionamos cerrar sesion en nuestro formulario cerramos la sesion
    header("Location:cerrarsesionivancampos.php");
}
elseif (isset($_POST["gestiona_usuarios"])){
    header ("Location:modificacionusuarios-ivancampos.php");
}
// Consulta para obtener todos los artículos
$sql = "SELECT coda, nombre, pvp, iva FROM articulos"; // esta parte no va dentro de un if, ya que queremos que se realize siempre queremos seleccionar toda la informacion de la tabla articulos
$res = $mysqli->query($sql); // añadimos una variable al resultado de la consulta anterior

if ($res) { // SI la consulta es exitosa
    echo "<h1>Lista de Artículos(Videojuegos)</h1>"; // titulo
    echo "<table border=1>
            <tr>
                <th>Coda</th>
                <th>Nombre</th>
                <th>Pvp</th>
                <th>Iva</th>
            </tr>";
//Creamos una tabla con los titulos de cada parametro de la base de datos
    while ($fila = $res->fetch_assoc()) { // posicionamos la variable al principio del valor de la consulta y vamos avanzando hasta que se impriman todos
        echo "<tr>
                <td>{$fila["coda"]}</td>
                <td>{$fila["nombre"]}</td>
                <td>{$fila["pvp"]}</td>
                <td>{$fila["iva"]}</td>
              </tr>";
    }

    echo "</table>";
    $res->close(); // cierre de la instrucción
} else {
    echo "Error en la consulta: " . $mysqli->error; // fallo en la consulta
}
}
 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Artículos</title>
    <link rel="stylesheet" type="text/css" href="styles.css"><!-- Link a la hoja de estilos css-->
</head>
<body>
    <div table >
    <div id="wrapper"> <!-- link a un css-->
    <h2>Insertar, Borrar y Actualizar Artículos</h2>
    <form action="articulos-ivancampos.php" method="POST"> <!-- Formulario con el cual pondremos los datos para insertar, actualizar y borrar datos de la tabla de articulos-->
        <label for="coda">Coda</label>
        <input type="text" name="coda" id="coda" required>
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" required>
        <label for="pvp">PVP</label>
        <input type="number" name="pvp" id="pvp" required>
        <label for="iva">IVA</label>
        <input type="number" name="iva" id="iva" required>

        <button type="submit" name="insertar">Insertar</button>
        <button type="submit" name="borrar">Borrar</button>
        <button type="submit" name="actualizar">Actualizar</button>
       
    </form>
    <form action="articulos-ivancampos.php" method="POST">
    <button type="submit" name="gestiona_usuarios">Ir a la pagina para gestionar usuarios</button>
    </form>

    </div>
    <form action="articulos-ivancampos.php" method="POST"><!-- Formulario para cerrar la sesion y salir de la pagina-->
    <button type="submit" name="cerrar_sesion">Cerrar session</button>
    </form>

    
    </div>
</body>
</html>
