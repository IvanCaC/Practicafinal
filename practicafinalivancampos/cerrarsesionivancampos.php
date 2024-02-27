<?php // Con este codigo cerraremos la sesion para poder salir de la pagina de articulos
session_start(); //seguimos con la sesion
unset($_SESSION); // vaciamos la variable con la que accedemos 
session_destroy(); // destruimos la sesion
header ("Location:index-ivancampos.php"); //volvemos al index
?>