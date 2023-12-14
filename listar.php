<?php
session_start();
require_once 'config.php';
require 'TCPDF/tcpdf.php';

// Verificar si se ha proporcionado un ID válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idEstudiante = $_GET['id'];

    $query = "
        SELECT 
            id,
            expediente,
            nif,
            nombre,
            apellidos,
            email,
            movil,
            foto
        FROM estudiantes
        WHERE id = :id
    ";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':id', $idEstudiante);
    $stmt->execute();

    // Verificar si se encontró la estudiante
    if ($stmt->rowCount() === 1) {
        // Obtener los datos de la estudiante
        $estudiante = $stmt->fetch(PDO::FETCH_ASSOC);

        // Aquí puedes mostrar los datos de la estudiante
        $id = $estudiante['id'];
        $expediente = $estudiante['expediente'];
        $nif = $estudiante['nif'];
        $nombre = $estudiante['nombre'];
        $apellidos = $estudiante['apellidos'];
        $email = $estudiante['email'];
        $movil = $estudiante['movil'];
        // Mostrar la imagen si está definida
        if (!empty($estudiante['foto'])) {
            $foto =  $estudiante['foto'];
        } else {
            $foto =  "No hay foto disponible.";
        }
    } else {
        echo "No se encontró el estudiante.";
    }
} else {
    echo "ID de estudiante no proporcionado.";
}

function generarPDF($id, $expediente, $nif, $nombre, $apellidos, $email, $movil, $foto)
{
    // Crear una instancia de TCPDF
    $pdf = new TCPDF();

    // Establecer metadatos del documento
    $pdf->SetCreator($id);
    $pdf->SetAuthor($nombre);
    $pdf->SetTitle($expediente);

    // Agregar una página al PDF
    $pdf->AddPage();

    // Agregar texto al PDF
    $pdf->SetFont('times', '', 12);
    $pdf->Cell(0, 10, $nif, 0, 1);
    $pdf->Cell(0, 10, $nombre, 0, 1);
    $pdf->Cell(0, 10, $apellidos, 0, 1);
    $pdf->Cell(0, 10, $email, 0, 1);
    $pdf->Cell(0, 10, $movil, 0, 1);

    // Agregar una imagen al PDF
    $imagePath = $foto; // Reemplaza con la ruta de tu imagen
    $pdf->Image($imagePath, 10, 60, 80, 60, 'JPEG'); // Parámetros: URL/ruta, x, y, ancho, alto, formato

    // Guardar el PDF en el servidor o mostrarlo en el navegador
    $pdf->Output('estudiante.pdf', 'I');
}

// Verificar si se ha enviado la solicitud
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Llamar a la función para generar el PDF cuando se reciba la solicitud
    generarPDF($id, $expediente, $nif, $nombre, $apellidos, $email, $movil, $foto);
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
    <link rel="stylesheet" href="style.css">
</head>
</head>

<body class="bg-secondary">
    <?php include 'includes/header.html'; ?>
    <div class="row bg-light">
        <div class="col-12">
            <div class="container mt-3">
                <h2 class="d-flex justify-content-start">Estudiante #<?php echo $id; ?></h2>
                <h1 class="d-flex justify-content-center"><?php echo $expediente; ?></h1>
                <img class="w-50 d-flex mx-auto" src="<?php echo $foto; ?>" alt="Entrada" />
                <div class="descipcion justify-content-center mx-auto mt-3 w-75">
                    <p class="text-justify"><?php echo $nif; ?></p>
                    <p class="text-justify"><?php echo $nombre; ?></p>
                    <p class="text-justify"><?php echo $apellidos; ?></p>
                    <p class="text-justify"><?php echo $email; ?></p>
                    <p class="text-justify"><?php echo $movil; ?></p>
                </div>
            </div>
            <form action="" method="post">
                <button class="btn btn-primary ms-5 mt-5" type="submit">Generar PDF</button>
            </form>
        </div>
        <a class="ms-5 ps-5 mt-4" href="index.php">Volver</a>
    </div>
    </div>

</body>