<?php
session_start();
require_once 'config.php';

// Procesar el formulario si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $expediente = htmlspecialchars($_POST['expediente'], ENT_QUOTES, 'UTF-8');
    $nif = htmlspecialchars($_POST['nif'], ENT_QUOTES, 'UTF-8');
    $nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
    $apellidos = htmlspecialchars($_POST['apellidos'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $movil = filter_var($_POST['movil'], FILTER_VALIDATE_INT);

    $foto = ''; // Inicializar con un valor predeterminado
    if ($_FILES['foto']['error'] == 0) {
        $foto = 'fotos/' . uniqid() . '_' . htmlspecialchars(basename($_FILES['foto']['name']), ENT_QUOTES, 'UTF-8');
        move_uploaded_file($_FILES['foto']['tmp_name'], $foto);
    }

    // Puedes hacer validaciones adicionales aquí antes de insertar en la base de datos

    try {
        $queryInsertarEstudiante = "
            INSERT INTO estudiantes (expediente, nif, nombre, apellidos, email, movil, foto)
            VALUES (:expediente, :nif, :nombre, :apellidos, :email, :movil, :foto)
        ";
        $stmt = $conexion->prepare($queryInsertarEstudiante);
        $stmt->bindParam(':expediente', $expediente);
        $stmt->bindParam(':nif', $nif);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':movil', $movil);
        $stmt->bindParam(':foto', $foto);
        $stmt->execute();

        $confirmacion = '<div class="alert alert-success w-25 text-center"> Estudiante creado correctamente</div>';
    } catch (PDOException $e) {
        echo "Error al crear la entrada: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Estudiante</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-secondary">

    <?php include 'includes/header.html';?>

        <div class="row bg-light">
            <div class="col-12">
                <form method="POST" action="" enctype="multipart/form-data" class="p-5 m-5 needs-validation" novalidate>

                    <label class="form-label" for="expediente"><strong>Expediente:</strong></label>
                    <input class="form-control w-50" type="text" name="expediente" required>
                    <div class="invalid-feedback">Solo caracteres alfanuméricos. Longitud máxima de 30</div><br/>

                    <label class="form-label" for="nif"><strong>NIF:</strong></label>
                    <input class="form-control w-50" type="text" name="nif" required>
                    <div class="invalid-feedback">Solo caracteres alfanuméricos. Longitud máxima de 30</div><br/>

                    <label class="form-label" for="nombre"><strong>Nombre:</strong></label><br>
                    <input class="form-control w-50" type="text" name="nombre" required>
                    <div class="invalid-feedback">Longitud máxima de 75</div><br/>

                    <label class="form-label" for="apellidos"><strong>Apellidos:</strong></label><br>
                    <input class="form-control w-50" type="text" name="apellidos" required>
                    <div class="invalid-feedback">Longitud máxima de 75</div><br/>

                    <label class="form-label" for="email"><strong>Email:</strong></label><br>
                    <input class="form-control w-50" type="text" name="email" required">
                    <div class="invalid-feedback">Longitud máxima de 75</div><br/>

                    <label class="form-label" for="movil"><strong>Movil:</strong></label><br>
                    <input class="form-control w-50" type="text" name="movil" required>
                    <div class="invalid-feedback">Longitud máxima de 75</div><br/>

                    <label class="form-label" for="foto"><strong>Foto:</strong></label>
                    <input class="form-control" type="file" name="foto" accept="image/*"><br>

                    <input class="btn btn-primary" type="submit" value="Crear Entrada">
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