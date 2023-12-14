<?php
session_start();
require_once 'config.php';

// Verificar si se ha proporcionado un ID válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idEstudiante = $_GET['id']; 

    // Obtener los datos de la estudiante con el ID proporcionado
    try {
        $queryObtenerEstudiante = "SELECT * FROM estudiantes WHERE ID = :id";
        $stmt = $conexion->prepare($queryObtenerEstudiante);
        $stmt->bindParam(':id', $idEstudiante);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $estudiante = $stmt->fetch(PDO::FETCH_ASSOC);

        } else {
            echo "Consulta no encontrada.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error al obtener la estudiante: " . $e->getMessage();
        exit;
    }
} else {
    echo "ID de estudiante no válido.";
    exit;
}

try {
    // Realizar la acción de borrado en la base de datos
    $queryBorrarEstudiante = "DELETE FROM estudiantes WHERE ID = :id";
    $stmt = $conexion->prepare($queryBorrarEstudiante);
    $stmt->bindParam(':id', $idEstudiante);
    $stmt->execute();
} catch (PDOException $e) {
    echo "Error al borrar el estudiante: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Estudiante</title>
    <!-- Agrega el enlace al archivo CSS de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-secondary">

    <?php include 'includes/header.html';?>

        <div class="row">
            <div class="col-12 p-5 m-5">
                <h2>Estudiante eliminado</h2>
            </div>
            <div class="col-12">
                <a class="ms-5 ps-5" href="index.php">Volver</a>
            </div>
        </div>
    </div>

</body>