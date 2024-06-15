<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario"])) {
    header("Location: index-ivancampos.php");
    exit();
}

// Conexión a la base de datos
$mysqli = new mysqli("127.0.0.1", "root", "", "practicafinal");

if ($mysqli->connect_error) {
    die("Error al realizar la conexión: " . $mysqli->connect_error);
}

// Consulta para obtener las ventas
$sql = "SELECT id, fecha, producto, cantidad, precio_unitario, total FROM ventas";
$res = $mysqli->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Ventas</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div id="wrapper">
        <h1>Lista de Ventas</h1>

        <?php if ($res && $res->num_rows > 0): ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = $res->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $fila["id"]; ?></td>
                            <td><?php echo $fila["fecha"]; ?></td>
                            <td><?php echo $fila["producto"]; ?></td>
                            <td><?php echo $fila["cantidad"]; ?></td>
                            <td><?php echo $fila["precio_unitario"]; ?></td>
                            <td><?php echo $fila["total"]; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay ventas registradas.</p>
        <?php endif; ?>

        <br>
        <form action="cerrarsesionivancampos.php" method="POST">
            <button type="submit" name="cerrar_sesion">Cerrar Sesión</button>
        </form>
    </div>
</body>
</html>

<?php
// Liberar el resultado y cerrar la conexión
if ($res) {
    $res->close();
}
$mysqli->close();
?>
