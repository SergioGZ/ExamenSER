<?php
session_start();
require_once 'config.php';

try {
    // Consulta SQL con INNER JOIN para obtener datos de entradas, categorías y usuarios
    $query = "
        SELECT entradas.ID, entradas.autor, entradas.titulo, entradas.descripcion, categorias.nombre AS categoria, entradas.fecha, entradas.imagen
        FROM entradas
        INNER JOIN categorias ON entradas.categoria_id = categorias.id
    ";
    $stmtEntradas = $conexion->query($query);
    $stmtEntradas->execute();
} catch (PDOException $e) {
    echo "Error al realizar la consulta de la tabla entradas: " . $e->getMessage();
}

try {
    // Consulta SQL para tabla categorias
    $query = "SELECT * FROM categorias";
    $stmtCategorias = $conexion->query($query);
    $stmtCategorias->execute();
} catch (PDOException $e) {
    echo "Error al realizar la consulta de la tabla usuarios: " . $e->getMessage();
}

try {
    // Consulta SQL para tabla categorias
    $query = "SELECT * FROM categorias";
    $stmtCategorias = $conexion->query($query);
    $stmtCategorias->execute();
} catch (PDOException $e) {
    echo "Error al realizar la consulta de la tabla usuarios: " . $e->getMessage();
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
            <a class="btn btn-primary float-start text-center me-3" href="crearentrada.php">Añadir entrada</a>
            <a class="btn btn-primary float-start text-center" href="crearcategoria.php">Añadir categoría</a>
        </div>
    </div>

    <div class="row bg-light">
        <div class="col-12">
            <?php
            // Mostrar la tabla entradas
            echo
            "<h1>Entradas</h1>
            <table id='tabla' class='table table-responsive table-striped datatable col-12'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Autor</th>
                        <th>Fecha</th>
                        <th>Imagen</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>

                <tbody>";
            while ($entrada = $stmtEntradas->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$entrada['ID']}</td>
                        <td>{$entrada['titulo']}</td>
                        <td style='max-width: 200px;'>{$entrada['descripcion']}</td>
                        <td>{$entrada['categoria']}</td>
                        <td>{$entrada['autor']}</td>
                        <td>{$entrada['fecha']}</td>
                        <td><img src='{$entrada['imagen']}' alt='Sin imagen' style='max-width: 50px; max-height: 50px;'></td>
                        <td>
                            <a href='listar.php?id={$entrada['ID']}' class='btn btn-primary'><i class='bi bi-eye-fill'></i></a>
                            <a href='modificar.php?id={$entrada['ID']}' class='btn btn-primary'><i class='bi bi-pencil-square'></i></a>
                            <a href='borrar.php?id={$entrada['ID']}' class='btn btn-danger'><i class='bi bi-trash'></i></a>
                        </td>
                    </tr>";
            }
            
            echo "</tbody>
                </table>";

                
            ?>
        </div>
    </div>

    <div class="row bg-light mt-5">
        <div class="col-12">
            <?php
            // Mostrar la tabla categorias
            echo
            "<h1>Categorías</h1>
            <table id='tabla3' class='table table-responsive table-striped datatable col-12'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th style='max-width:100px;'>Operaciones</th>
                    </tr>
                </thead>

                <tbody>";
            while ($categoria = $stmtCategorias->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$categoria['id']}</td>
                        <td>{$categoria['nombre']}</td>
                        <td>
                        <a href='borrarCategoria.php?id={$categoria['id']}' class='btn btn-danger'><i class='bi bi-trash'></i></a>";
                        echo "</td>
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