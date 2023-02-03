<?php
session_start();
//Si existe la peticion de añadir foto...

if (isset($_POST['addPhoto'])) {

    $resultado = [
        'error' => false,
        'mensaje' => 'La fotografía ' . $_POST['nombre'] .  ' ha sido añadida con éxito.'
    ];

//Conexion a la bbdd
    $config = include '../data/config.php';

    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
//Se almacenan en un array los datos del formulario para añadir fotografias a la bbdd
        $fotografia = array(
            "nombre" => trim(strip_tags($_POST['nombre'])),
            "precio" => trim(strip_tags($_POST['precio'])),
            "tamanio" => trim(strip_tags($_POST['tamanio'])),
            "imagen" => trim(strip_tags($_POST['imagen'])),
            "creador" => trim(strip_tags($_POST['creador']))
        );


        if (empty($_POST['nombre']) || empty($_POST['precio']) || empty($_POST['tamanio']) || empty($_POST['imagen']) || empty($_POST['creador'])) {

            echo "<h3 style='color:red;text-align:center;'>Debe rellenar todos los campos para actualizar<h3>";
        } else {
//preparacion de consulta de datos a la bbdd y ejecucion
            $consultaSQL = "INSERT INTO fotografia (nombre,precio,tamanio,imagen,creador)";
            $consultaSQL .= "values (:" . implode(", :", array_keys($fotografia)) . ")";
            $sentencia = $conexion->prepare($consultaSQL);
            $sentencia->execute($fotografia);

//redireccion a catalogo para mostrar los datos de la consulta

            header('location:../VIEWS/catalogo.php');
        }
    } catch (PDOException $error) {
        $resultado['error'] = true;
        //$resultado['mensaje'] = $error->getMessage();
    }
}
?>
<?php include "../PUBLIC/PARTS/header.php"; ?>
<div class="container">
    <div class="d-flex justify-content-center h-100">
        <div class="card " style="height:29em">
            <div class="card-header">
                <h3>Añadir Foto</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Nombre" name="nombre">

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user-tie"></i></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Precio" name="precio">

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Tamaño" name="tamanio">

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-at"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Imagen" name="imagen">

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Creador" name="creador">

                    </div>
                    <p class="text-warning">Recuerda añadir las fotos a la carpeta images para que puedan verse </p>
                    <div class="row align-items-center remember">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-secondary bg-danger" name="addPhoto">Añadir</button>
                        <a type="button" class="btn btn-secondary bg-warning" href="../index.php">Inicio</a>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "../PUBLIC/PARTS/footer.php"; ?>
</body>

</html>