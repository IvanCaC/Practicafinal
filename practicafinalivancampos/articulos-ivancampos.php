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
    $sql_articulos = "SELECT coda, nombre, pvp, iva FROM articulos";
    $res_articulos = $mysqli->query($sql_articulos);

    if (!$res_articulos) {
        echo "Error en la consulta de artículos: " . $mysqli->error;
    }

    // Consulta para obtener todas las ventas
    $sql_ventas = "SELECT id, fecha, coda, cantidad, total_gasto FROM ventas";
    $res_ventas = $mysqli->query($sql_ventas);

    if (!$res_ventas) {
        echo "Error en la consulta de ventas: " . $mysqli->error;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Artículos y Ventas</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div id="wrapper">
        <h1>Lista de Artículos</h1>
        <table border="1">
            <tr>
                <th>Coda</th>
                <th>Nombre</th>
                <th>Pvp</th>
                <th>Iva</th>
            </tr>
            <?php
            if ($res_articulos && $res_articulos->num_rows > 0) {
                while ($fila = $res_articulos->fetch_assoc()) {
                    echo "<tr>
                            <td>{$fila["coda"]}</td>
                            <td>{$fila["nombre"]}</td>
                            <td>{$fila["pvp"]}</td>
                            <td>{$fila["iva"]}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No hay artículos registrados.</td></tr>";
            }
            ?>
        </table>

        <h1>Lista de Ventas</h1>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Coda Artículo</th>
                <th>Cantidad</th>
                <th>Total Gasto</th>
            </tr>
            <?php
            if ($res_ventas && $res_ventas->num_rows > 0) {
                while ($fila = $res_ventas->fetch_assoc()) {
                    echo "<tr>
                            <td>{$fila["id"]}</td>
                            <td>{$fila["fecha"]}</td>
                            <td>{$fila["coda"]}</td>
                            <td>{$fila["cantidad"]}</td>
                            <td>{$fila["total_gasto"]}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay ventas registradas.</td></tr>";
            }
            ?>
        </table>

        <br><br>

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
            <label for="coda">Coda del Artículo</label>
            <input type="text" name="coda" id="coda" required>
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" required>
            <button type="submit" name="registrar_venta">Registrar Venta</button>
        </form>

        <form action="modificacionusuarios-ivancampos.php" method="POST">
            <button type="submit" name="gestiona_usuarios">Gestionar Usuarios</button>
        </form>

        <form action="cerrarsesionivancampos.php" method="POST">
            <button type="submit" name="cerrar_sesion">Cerrar Sesión</button>
        </form>
    </div>
</body>
</html>

<?php
// Liberar el resultado y cerrar la conexión
if ($res_articulos) {
    $res_articulos->close();
}
if ($res_ventas) {
    $res_ventas->close();
}
$mysqli->close();
?>
