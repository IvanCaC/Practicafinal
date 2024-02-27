<?php
session_start();
/*
if (isset($_POST["usuario"]) && isset($_POST["password"])) {
    $usuario = substr($_POST["usuario"], 0, 30);
    $password = substr($_POST["password"], 0, 30);
    $password2 = substr($_POST["password2"], 0, 30);
if (strlen($password) >= 6) {
$mysqli = new mysqli("127.0.0.1", "root", "", "practicafinal");

if ($mysqli) {
    $sql = "INSERT INTO usuarios (usuario, pass) VALUES ('$usuario', '$password')";
    if ($mysqli->query($sql)) {
        echo "Creacion de cuenta exitosa";
    } else {
        echo "Error en la creacion de la cuenta: " . $mysqli->error;
    }
}
}
else {
    echo "contraseña minimo de 6 caracteres";
}

*/
include "errores-ivancampos.php";
if (isset($_POST["usuario"]) && isset($_POST["password"])){ // si tenemos datos del formulario en index hacemos la conexion a la base de datos
    $mysqli = new mysqli ("127.0.0.1", "root", "", "practicafinal"); // nos conectamos a la base de datos
    $usuario=$_POST["usuario"]; // asignamos nuevas variables a los datos que recibimos del formulario
    $pass=$_POST["password"];
    if ($mysqli) {  // si nos conectamos a la base de datos
        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND pass = '$pass'"; // hacemos una consulta para ver que tanto el usuario como la contraseña que le pasamos coinciden
        $result = $mysqli->query($sql); // esto solo GARANTIZA QUE SE HACE CONSULTA
        if ($result) {  // si se ha realizado la consulta
            $fila=$result->fetch_assoc();  // se guarda en una variable fila una linea de resultados
            if($fila){
                $_SESSION["usuario"]=$usuario; // agregamos como sesion el mismo nomnbre de usuario y este parametro lo usaremos para acceder a mi tabla de articulos
                header("Location:articulos-ivancampos.php"); // nos manda a la pagina de los articulos de la base de datos
            }
            else {
                echo "Error en el login: Usuario o contraseña incorrecta"; // mensaje de error
            }
        }
      
    }
}
else{
    header("Location:index-ivancampos.php"); // si no recibimos parametros volvemos al index
}

?>
