<?php
session_start();
$error=0;
include "errores-ivancampos.php";

if (isset($_POST["usuario"]) && isset($_POST["password"]) && isset($_POST["password2"])) {
    $usuario = substr($_POST["usuario"], 0, 30);
    $password = substr($_POST["password"], 0, 30);
    $password2 = substr($_POST["password2"], 0, 30);

    if (preg_match("/(*UTF8)^[\p{L}\p{N}]{1,30}$/", $usuario)) {
        if ($password == $password2) {
            if (strlen($password) >= 6) {
                $mysqli = new mysqli("127.0.0.1", "root", "", "practicafinal");

                if ($mysqli) {
                    
                    $sql = "INSERT INTO usuarios (usuario, pass) VALUES ('$usuario', '$password')";
                    if ($mysqli->query($sql) == false) {
                        if ($mysqli->errno == 1062) {
                            $error = ERROR_USUARIO_EXISTE;
                        } else {
                            echo "Error al intentar insertar en la base de datos: " . $mysqli->error;
                            $error = ERROR_GRABAR;
                        }
                    } else {
                        $_SESSION["usuario"] = $usuario;
                    }

                    $mysqli->close();
                } else {
                    $error = ERROR_CONEXION;
                }
            } else {
                $error = ERROR_PASSWORD_CORTA;
            }
        } else {
            $error = ERROR_DOS_PASSWORD;
        }
    } else {
        $error = ERROR_USUARIO_INVALIDO;
    }
} else {
    header("Location: index-ivancampos.php");
}

if ($error != 0) {
    header("Location: index-ivancampos.php?error=" . $error);
} else {
   echo "Usuario creado correctamente bienvenido $usuario";
   echo "<a href='cerrarsesionivancampos.php'>borrar a la pagina principal</a>";
}
?>