<?php
session_start();
$_SESSION["nombre"] = $_POST["nombre"];
$_SESSION["ventas"] = 0;
echo "La variable de sesión se ha establecido correctamente.";
?>