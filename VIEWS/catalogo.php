<?php
session_start();

//Conexion a la bbdd
$config = include '../data/config.php';

try {
    //almacenamos en una variable la peticion de conexion pdo
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    //almacenamos en una variable la sesion para el dni del usuario
    $usuarioEstaLogueado = $_SESSION["dni"] ?? false;
    $usuarioEsAdmin = false;

    //prparacion de la consulta de los datos a volcar de la tabla fotografia
    $consultaSQL = $conexion->prepare("SELECT * FROM fotografia");
    $consultaSQL->execute();
    $catalogo = $consultaSQL->fetchAll(PDO::FETCH_ASSOC);

    if ($usuarioEstaLogueado) {
        $dni = $_SESSION['dni'];

        //peticion de datos del usuario en base al dato dni
        $usuario = $conexion->prepare("SELECT * FROM usuario WHERE dni=:dni");
        $usuario->bindParam("dni", $dni, PDO::PARAM_STR);
        $usuario->execute();
        $consultarAdmin = $usuario->fetch(PDO::FETCH_ASSOC);

        //Conforme al dni usamos variable para determinar si es administrador o no
        $usuarioEsAdmin = (bool) $consultarAdmin['admin'];
        $_SESSION['admin'] = $usuarioEsAdmin;
    }
} catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
}

include "../PUBLIC/PARTS/header.php";

?>

<div class="container-fluid">
    <div class="row justify-content-center align-items-center minh-100 mt-5">
        <div class="col-lg-12 p-5 mt-5">
            <?php if ($usuarioEstaLogueado) { ?>
            <h3 class='m-1 p-1 text-warning text-center'>-- <?php echo ($usuarioEsAdmin ? 'ADMIN' : 'MIEMBRO')?> --</h3>
            <?php } ?>
            <h1 class="text-warning">PhotoSOLD.</h1>
            <table class="table table-striped table-hover table-dark " style="border:solid 2px yellow;">
                <thead>
                    <tr class="text-center">
                        <th scope="col">Nombre</th>
                        <th scope="col">Precio (€)</th>
                        <th scope="col">Tamaño</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Creador</th>
                        <th scope="col">Creada</th>
                        <th scope="col">Actualizada</th>
                        <?php if ($usuarioEstaLogueado) { ?>
                        <th></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //Bucle para mostrar todos los campos de la tabla fotografia en una tabla
                    if ($catalogo && $consultaSQL->rowCount() > 0) {
                        foreach ($catalogo as $datoFila) {
                            if ($datoFila['imagen'] != 0) {
                    ?>
                    <tr class="catalogo text-center">
                        <td class="p-2"><?php echo $datoFila["nombre"]; ?></td>
                        <td class="p-2"><?php echo $datoFila["precio"]; ?></td>
                        <td class="p-2"><?php echo $datoFila["tamanio"]; ?></td>
                        <td class="p-2"><img style="width: 5em;" src="<?php echo $datoFila["imagen"]; ?>"></td>
                        <td class="p-2"><?php echo $datoFila["creador"]; ?></td>
                        <td class="p-2"><?php echo $datoFila["created_at"]; ?></td>
                        <td class="p-2"><?php echo $datoFila["updated_at"]; ?></td>
                        <?php if ($usuarioEstaLogueado) { ?>
                        <td>
                            <?php if ($usuarioEsAdmin) { ?>
                            <a href="<?php echo '../ACCIONES/borraPhoto.php?id_fotografia=' . $datoFila["id_fotografia"] ?>" class="btn btn-secondary btn-light fw-bold border-white bg-warning"><i class="fa fa-trash"></i>Borrar</a>
                            <?php } else { ?>
                            <a href="<?php echo '../ACCIONES/buyPhoto.php?id_fotografia=' . $datoFila["id_fotografia"] ?>" class="btn btn-secondary btn-light fw-bold border-white bg-warning"><i class="fa fa-coins"></i>Comprar</a>
                            <?php } ?>
                        </td>
                        <?php } ?>
                    </tr>
                    <?php
                            }
                        }
                    }                       
                    ?>
                </tbody>
            </table>
            <a href="../index.php" class="btn btn-lg btn-light fw-bold border-white bg-warning"><i class="fas fa-home"></i>Ir a inicio</a>
            <?php if ($usuarioEstaLogueado && $usuarioEsAdmin) { ?>
            <a href="../ACCIONES/addPhoto.php" class="btn btn-lg btn-light fw-bold border-white bg-warning"><i class="fas fa-plus"></i> Añadir foto</a>
            <?php } ?>
            <?php if ($usuarioEstaLogueado) { ?>
            <a href="../ACCIONES/finSession.php" class="btn btn-lg btn-light fw-bold border-white bg-danger"><i class="fas fa-door-closed"></i>Cerrar sesion</a>
            <?php } ?><
        </div>
    </div>
</div>
<?php include "../PUBLIC/PARTS/footer.php";  ?>