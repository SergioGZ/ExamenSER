<?php
session_start();
require_once 'config.php';

// Verificar si se ha proporcionado un ID válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idEstudiante = $_GET['id']; 

    // Obtener los datos de la Estudiante con el ID proporcionado
    try {
        $queryObtenerEstudiante = "SELECT * FROM estudiantes WHERE ID = :id";
        $stmt = $conexion->prepare($queryObtenerEstudiante);
        $stmt->bindParam(':id', $idEstudiante);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $entrada = $stmt->fetch(PDO::FETCH_ASSOC);

        } else {
            echo "Estudiante no encontrado.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error al obtener el estudiante: " . $e->getMessage();
        exit;
    }
} else {
    echo "ID de estudiante no válido.";
    exit;
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Borrar Entrada</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-secondary">

    <?php include 'includes/header.html';?>

        <div class="row">
            <div class="col-12 p-5 m-3">
                <?php
                    // Mostrar confirmación de borrado
                    echo "<h2>Confirmar Borrado</h2>";
                    echo "<p>¿Estás seguro de que deseas borrar la entrada con ID {$idEstudiante}?</p>";
                    echo "<a href='eliminar.php?id={$idEstudiante}' class='btn btn-danger'>Sí, Borrar</a> ";
                    echo "<a href='index.php' class='btn btn-secondary'>Cancelar</a>";
                ?>
            </div>
            <div class="col-12">
                <a class="ms-3 ps-5" href="index.php">Volver</a>
            </div>
        </div>
    </div>

</body>

</html>