<?php
session_start();

$mysqli = new mysqli("127.0.0.1", "root", "", "practicafinal");

if ($mysqli->connect_error) {
    die("Error al realizar la conexión: " . $mysqli->connect_error);
}

// Consulta para obtener todas las ventas
$sql = "SELECT id, fecha, producto, cantidad, precio_unitario, total FROM ventas";
$res = $mysqli->query($sql);

if ($res) {
    echo "<h1>Lista de Ventas</h1>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>";

    while ($fila = $res->fetch_assoc()) {
        echo "<tr>
                <td>{$fila["id"]}</td>
                <td>{$fila["fecha"]}</td>
                <td>{$fila["producto"]}</td>
                <td>{$fila["cantidad"]}</td>
                <td>{$fila["precio_unitario"]}</td>
                <td>{$fila["total"]}</td>
              </tr>";
    }

    echo "</table>";
    $res->close(); // cierre de la instrucción
} else {
    echo "Error en la consulta: " . $mysqli->error;
}

$mysqli->close();
?>
