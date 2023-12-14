<?php
// Conexión a la base de datos usando PDO
$host = "localhost";
$usuario = "root";
$clave = "";
$bd = "examen";

try {
    $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario, $clave);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $msjConexion = "<div class='alert alert-success text-center'>Conectado a la  base de datos</div>";
    
} catch (PDOException $ex) {
    $conexion->rollBack();
    $msjConexion = "<div class='alert alert-danger'>Error al conectar con la base de datos<br/>" . $ex->getMessage() . "</div>";
}
