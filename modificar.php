<?php
session_start();
require_once 'config.php';

// Verificar si se ha proporcionado un ID válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idEstudiante = $_GET['id']; 

    // Obtener los datos de el estudiante con el ID proporcionado
    try {
        $queryObtenerEstudiante = "SELECT * FROM estudiantes WHERE ID = :id";
        $stmt = $conexion->prepare($queryObtenerEstudiante);
        $stmt->bindParam(':id', $idEstudiante);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $estudiante = $stmt->fetch(PDO::FETCH_ASSOC);
            $expediente = $estudiante['expediente'];
            $nif = $estudiante['nif'];
            $nombre = $estudiante['nombre'];
            $apellidos = $estudiante['apellidos'];
            $email = $estudiante['email'];
            $movil = $estudiante['movil'];

        } else {
            echo "Entrada no encontrada.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error al obtener la entrada: " . $e->getMessage();
        exit;
    }
} else {
    echo "ID de entrada no válido.";
    exit;
}


// Verificar si el formulario ha sido enviado mediante el método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $expediente = $_POST['expediente'];
    $nif = $_POST['nif'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $movil = $_POST['movil'];

    $foto = ''; // Inicializar con un valor predeterminado
    if ($_FILES['foto']['error'] == 0) {
        $foto = 'fotos/' . uniqid() . '_' . htmlspecialchars(basename($_FILES['foto']['name']), ENT_QUOTES, 'UTF-8');
        move_uploaded_file($_FILES['foto']['tmp_name'], $foto);
    }

    try {
        // Actualizar los campos de la entrada en la base de datos
        $queryActualizarEstudiante = "UPDATE estudiantes SET expediente = :expediente, nif = :nif, nombre = :nombre, apellidos = :apellidos, email = :email, movil = :movil, foto = :foto WHERE ID = :id";
        $stmt = $conexion->prepare($queryActualizarEstudiante);
        $stmt->bindParam(':id', $idEstudiante);
        $stmt->bindParam(':expediente', $expediente);
        $stmt->bindParam(':nif', $nif);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':movil', $movil);
        $stmt->bindParam(':foto', $foto);
        $stmt->execute();

        $confirmacion = '<div class="alert alert-success w-75 text-center">Estudiante modificado correctamente</div>';
    } catch (PDOException $e) {
        echo "Error al actualizar la entrada: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Entrada</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>

<body class="bg-secondary">

    <?php include 'includes/header.html'; ?>

    <div class="row bg-light">
        <div class="col-12">
            <form method="POST" action="" enctype="multipart/form-data" class="p-5 m-5 needs-validation" novalidate>
                <label class="form-label" for="expediente"><strong>Expediente:</strong></label>
                <input class="form-control w-50" type="text" name="expediente" value="<?php echo $expediente; ?>" required><br>

                <label class="form-label" for="nif"><strong>NIF:</strong></label>
                <input class="form-control w-50" type="text" name="nif" value="<?php echo $nif; ?>" required><br>

                <label class="form-label" for="nombre"><strong>Nombre:</strong></label><br>
                <input class="form-control w-50" type="text" name="nombre" value="<?php echo $nombre; ?>" required><br>

                <label class="form-label" for="apellidos"><strong>Apellidos:</strong></label><br>
                <input class="form-control w-50" type="text" name="apellidos" value="<?php echo $apellidos; ?>" required><br>
                
                <label class="form-label" for="email"><strong>Email:</strong></label><br>
                <input class="form-control w-50" type="text" name="email" value="<?php echo $email; ?>" required><br>

                <label class="form-label" for="movil"><strong>Movil:</strong></label><br>
                <input class="form-control w-50" type="text" name="movil" value="<?php echo $movil; ?>" required><br>

                <label class="form-label" for="foto"><strong>Foto:</strong></label>
                <input class="form-control" type="file" name="foto" accept="image/*">
                <p class="form-text">Necesario subir foto de nuevo</p><br>

                <input class="btn btn-primary" type="submit" value="Modificar Estudiante">
                <?php
                if (!empty($confirmacion)) {
                    echo "<p>$confirmacion</p>";
                }
                ?>
            </form>
            <a class="ms-5 ps-5" href="index.php">Volver</a>
        </div>
    </div>
    </div>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>

</body>

</html>