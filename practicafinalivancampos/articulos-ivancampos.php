<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location:index-ivancampos.php");
    exit();
} else {
    $mysqli = new mysqli("127.0.0.1", "root", "", "practicafinal");

    if ($mysqli->connect_error) {
        die("Error al realizar la conexión: " . $mysqli->connect_error);
    }

    // Insertar, Borrar o Actualizar artículo
    if (isset($_POST["insertar"])) {
        if (isset($_POST["coda"]) && isset($_POST["nombre"]) && isset($_POST["pvp"]) && isset($_POST["iva"])) {
            $coda = $_POST["coda"];
            $nombre = $_POST["nombre"];
            $pvp = $_POST["pvp"];
            $iva = $_POST["iva"];

            $sql = "INSERT INTO articulos (coda, nombre, pvp, iva) VALUES ('$coda', '$nombre', $pvp, $iva)";
            if ($mysqli->query($sql)) {
                echo "Inserción exitosa";
            } else {
                echo "Error en la inserción: " . $mysqli->error;
            }
        }
    } elseif (isset($_POST["borrar"])) {
        if (isset($_POST["coda"])) {
            $coda = $_POST["coda"];
            $sql = "DELETE FROM articulos WHERE coda = '$coda'";
            if ($mysqli->query($sql)) {
                echo "Borrado exitoso";
            } else {
                echo "Error en el borrado: " . $mysqli->error;
            }
        }
    } elseif (isset($_POST["actualizar"])) {
        if (isset($_POST["coda"]) && isset($_POST["nombre"]) && isset($_POST["pvp"]) && isset($_POST["iva"])) {
            $coda = $_POST["coda"];
            $nombre = $_POST["nombre"];
            $pvp = $_POST["pvp"];
            $iva = $_POST["iva"];

            $sql = "UPDATE articulos SET nombre='$nombre', pvp=$pvp, iva=$iva WHERE coda='$coda'";
            if ($mysqli->query($sql)) {
                echo "Actualización exitosa";
            } else {
                echo "Error en la actualización: " . $mysqli->error;
            }
        }
    } elseif (isset($_POST["registrar_venta"])) {
        if (isset($_POST["coda"]) && isset($_POST["cantidad"])) {
            $coda = $_POST["coda"];
            $cantidad = $_POST["cantidad"];
            $usuario = $_SESSION["usuario"];
            $fecha = date('Y-m-d');

            $sql_articulo = "SELECT pvp, iva FROM articulos WHERE coda = '$coda'";
            $res_articulo = $mysqli->query($sql_articulo);
            if ($res_articulo) {
                $articulo = $res_articulo->fetch_assoc();
                $pvp = $articulo['pvp'];
                $iva = $articulo['iva'];
                $total_gasto = $cantidad * $pvp * (1 + $iva / 100);

                $sql_venta = "INSERT INTO ventas (usuario, coda, fecha, cantidad, total_gasto) VALUES ('$usuario', '$coda', '$fecha', $cantidad, $total_gasto)";
                if ($mysqli->query($sql_venta)) {
                    echo "Venta registrada exitosamente";
                } else {
                    echo "Error al registrar la venta: " . $mysqli->error;
                }
            } else {
                echo "Error al obtener el artículo: " . $mysqli->error;
            }
        }
    } elseif (isset($_POST["cerrar_sesion"])) {
        header("Location:cerrarsesionivancampos.php");
    } elseif (isset($_POST["gestiona_usuarios"])) {
        header("Location:modificacionusuarios-ivancampos.php");
    }

    // Consulta para obtener todos los artículos
    $sql = "SELECT coda, nombre, pvp, iva FROM articulos";
    $res = $mysqli->query($sql);

    if ($res) {
        echo "<h1>Lista de Artículos(Videojuegos)</h1>";
        echo "<table border=1>
                <tr>
                    <th>Coda</th>
                    <th>Nombre</th>
                    <th>Pvp</th>
                    <th>Iva</th>
                </tr>";
        while ($fila = $res->fetch_assoc()) {
            echo "<tr>
                    <td>{$fila["coda"]}</td>
                    <td>{$fila["nombre"]}</td>
                    <td>{$fila["pvp"]}</td>
                    <td>{$fila["iva"]}</td>
                  </tr>";
        }
        echo "</table>";
        $res->close();
    } else {
        echo "Error en la consulta: " . $mysqli->error;
    }
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
    <div id="wrapper">
        <h2>Insertar, Borrar y Actualizar Artículos</h2>
        <form action="articulos-ivancampos.php" method="POST">
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
        <h2>Registrar Venta</h2>
        <form action="articulos-ivancampos.php" method="POST">
            <label for="coda">Coda</label>
            <input type="text" name="coda" id="coda" required>
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" required>
            <button type="submit" name="registrar_venta">Registrar Venta</button>
        </form>
        <form action="articulos-ivancampos.php" method="POST">
            <button type="submit" name="gestiona_usuarios">Ir a la página para gestionar usuarios</button>
        </form>
        <form action="articulos-ivancampos.php" method="POST">
            <button type="submit" name="cerrar_sesion">Cerrar sesión</button>
        </form>
    </div>
</body>
</html>
