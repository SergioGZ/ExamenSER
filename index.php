<?php
session_start();
require_once 'config.php';

try {

    $query = "
        SELECT id, expediente, nif, nombre, apellidos, email, movil, foto
        FROM estudiantes
    ";
    $stmtEstudiantes = $conexion->query($query);
    $stmtEstudiantes->execute();
} catch (PDOException $e) {
    echo "Error al realizar la consulta de la tabla entradas: " . $e->getMessage();
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
    <link rel="stylesheet" href="http://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">

    <?php include 'includes/header.html'; ?>

    <div class="row">
        <div class="col-12 w-50 my-5">
            <a class="btn btn-primary float-start text-center me-3" href="crearestudiante.php">Añadir estudiante</a>
        </div>
    </div>

    <div class="row bg-light">
        <div class="col-12">
            <?php
            echo
            "<h1>Estudiantes</h1>
            <table id='tabla' class='table table-responsive table-striped datatable col-12'>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Foto</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>

                <tbody>";
            while ($estudiante = $stmtEstudiantes->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$estudiante['email']}</td>
                        <td>{$estudiante['nombre']}</td>
                        <td>{$estudiante['apellidos']}</td>
                        <td><img src='{$estudiante['foto']}' alt='Sin imagen' style='max-width: 50px; max-height: 50px;'></td>
                        <td>
                            <a href='listar.php?id={$estudiante['id']}' class='btn btn-primary'><i class='bi bi-eye-fill'></i></a>
                            <a href='modificar.php?id={$estudiante['id']}' class='btn btn-primary'><i class='bi bi-pencil-square'></i></a>
                            <a href='borrar.php?id={$estudiante['id']}' class='btn btn-danger'><i class='bi bi-trash'></i></a>
                        </td>
                    </tr>";
            }
            
            echo "</tbody>
                </table>";

                
            ?>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="http://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        var table = new DataTable('#tabla', {
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
        });
    </script>
</body>

</html>