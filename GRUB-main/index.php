<?php
require 'conexion.php';

$method = $_SERVER['REQUEST_METHOD'];

// Manejar las solicitudes GET para la API
if ($method == 'GET' && isset($_GET['api'])) {
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if (!empty($id)) {
        $sql = "SELECT * FROM estudiantes WHERE id = $id";
        $resultado = $mysqli->query($sql);

        if ($resultado && $resultado->num_rows > 0) {
            $data = $resultado->fetch_assoc();
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(['error' => 'Estudiante no encontrado']);
        }
        exit(); // Evitar que se ejecute el resto del código si es una solicitud de la API
    }
}

// El resto del código manejará las solicitudes del formulario web
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
        <h2 style="text-align:center">Registro de Datos Estudiantes</h2>
    </div>

    <div class="row">
        <a href="nuevo.php" class="btn btn-primary">Nuevo Registro</a>

        <form action="" method="GET">
            <b>ID: </b><input type="text" id="id" name="id" />
            <input type="submit" id="buscar" name="buscar" value="Buscar" class="btn btn-info" />
        </form>
    </div>

    <br>

    <div class="row table-responsive">
        <?php
        // Si llegamos aquí, no es una solicitud de la API, es una solicitud del formulario web
        if (isset($_GET['buscar'])) {
            $id = isset($_GET['id']) ? $_GET['id'] : null;

            if (!empty($id)) {
                $sql = "SELECT * FROM estudiantes WHERE id = $id";
                $resultado = $mysqli->query($sql);

                if ($resultado && $resultado->num_rows > 0) {
                    // Mostrar el resultado si existe
                    $data = $resultado->fetch_assoc();
                    ?>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Telefono</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td><?php echo $data['id']; ?></td>
                            <td><?php echo $data['nombre']; ?></td>
                            <td><?php echo $data['email']; ?></td>
                            <td><?php echo $data['telefono']; ?></td>
                            <td><a href="modificar.php?id=<?php echo $data['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td><a href="#" data-href="eliminar.php?id=<?php echo $data['id']; ?>" data-toggle="modal" data-target="#confirm-delete"><span class="glyphicon glyphicon-trash"></span></a></td>
                        </tr>
                        </tbody>
                    </table>
                    <?php
                } else {
                    // Mostrar mensaje si no existe
                    ?>
                    <div class="alert alert-warning" role="alert">
                        Estudiante no encontrado.
                    </div>
                    <?php
                }
            }
        } else {
            // Consulta SQL para mostrar la tabla completa
            $sql = "SELECT * FROM estudiantes";
            $resultado = $mysqli->query($sql);

            if ($resultado && $resultado->num_rows > 0) {
                // Resto del código para mostrar la tabla
                ?>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Telefono</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['telefono']; ?></td>
                            <td><a href="modificar.php?id=<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td><a href="#" data-href="eliminar.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete"><span class="glyphicon glyphicon-trash"></span></a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?php
            } else {
                // Código para mostrar un mensaje si no hay resultados
                ?>
                <div class="alert alert-warning" role="alert">
                    No hay registros en la base de datos.
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Eliminar Registro</h4>
            </div>

            <div class="modal-body">
                ¿Desea eliminar este registro?
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<script>
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

        $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
    });
</script>

</body>
</html>
