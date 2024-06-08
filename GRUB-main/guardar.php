<?php
require 'conexion.php';

try {
    $id = $_POST['Id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $estado_civil = $_POST['estado_civil'];
    $hijos = isset($_POST['hijos']) ? $_POST['hijos'] : 0;
    $intereses = isset($_POST['intereses']) ? $_POST['intereses'] : null;

    $arrayIntereses = null;

    $num_array = count($intereses);
    $contador = 0;

    if ($num_array > 0) {
        foreach ($intereses as $key => $value) {
            if ($contador != $num_array - 1)
                $arrayIntereses .= $value . ' ';
            else
                $arrayIntereses .= $value;
            $contador++;
        }
    }

    $sql = "INSERT INTO estudiantes (id, nombre, email, telefono, estado_civil, hijos, intereses) VALUES ('$id', '$nombre', '$email', '$telefono', '$estado_civil', '$hijos', '$arrayIntereses')";
    $resultado = $mysqli->query($sql);

    // Resto del código para mostrar el resultado
} catch (mysqli_sql_exception $ex) {
    // Manejar la excepción y mostrar un mensaje personalizado
    $errorMessage = $ex->getMessage();
    if (strpos($errorMessage, 'Duplicate entry') !== false) {
        $mensajeError = 'Error: El ID ya existe en la base de datos.';
    } else {
        $mensajeError = 'Error al guardar.';
    }
}
?>

<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="row" style="text-align:center">
            <?php if (isset($mensajeError)) { ?>
                <h3><?php echo $mensajeError; ?></h3>
            <?php } elseif ($resultado) { ?>
                <h3>REGISTRO GUARDADO</h3>
            <?php } else { ?>
                <h3>ERROR AL GUARDAR</h3>
            <?php } ?>

            <a href="index.php" class="btn btn-primary">Regresar</a>

        </div>
    </div>
</div>
</body>
</html>
