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
    

    // Iniciar la transacción
    $conexion->beginTransaction();

    $sql = "CREATE TABLE IF NOT EXISTS categorias (
            id INT PRIMARY KEY AUTO_INCREMENT,
            nombre VARCHAR(255) NOT NULL
        )";
    $conexion->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS entradas (
            ID INT PRIMARY KEY AUTO_INCREMENT,
            autor VARCHAR(255) NOT NULL,
            categoria_id INT,
            titulo VARCHAR(255) NOT NULL,
            imagen VARCHAR(255),
            descripcion TEXT,
            fecha DATE,
            FOREIGN KEY (categoria_id) REFERENCES categorias(id)
        )";
    $conexion->exec($sql);
    // Commit de la transacción
    if ($conexion->inTransaction()) {
        $conexion->commit();
        echo "Transacción completada exitosamente.";
    }
} catch (PDOException $ex) {
    $conexion->rollBack();
    $msjConexion = "<div class='alert alert-danger'>Error al conectar con la base de datos<br/>" . $ex->getMessage() . "</div>";
}
