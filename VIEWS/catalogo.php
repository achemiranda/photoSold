<?php
session_start();

//Conexion a la bbdd
$config = include '../data/config.php';

try {
    //almacenamos en una variable la peticion de conexion pdo
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    //almacenamos en una variable la sesion para el dni del usuario
    $dni = $_SESSION["dni"];

    //prparacion de la consulta de los datos a volcar de la tabla fotografia
    $consultaSQL = $conexion->prepare("SELECT * FROM fotografia");
    $consultaSQL->execute();
    $catalogo = $consultaSQL->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_SESSION['dni'])) {
        $dni = $_SESSION['dni'];

        //peticion de datos del usuario en base al dato dni
        $usuario = $conexion->prepare("SELECT * FROM usuario WHERE dni=:dni");
        $usuario->bindParam("dni", $dni, PDO::PARAM_STR);
        $usuario->execute();
        $consultarAdmin = $usuario->fetch(PDO::FETCH_ASSOC);

        //Conforme al dni usamos variable para determinar si es administrador o no
        $admin = $consultarAdmin['admin'];
        $_SESSION['admin'] = $admin;
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

            <?php
            if (isset($_SESSION['dni'])) {
                //Si el valor de admin = 1 entra a la pagina en modo admin.
                if ($admin == 1) {
                    echo "<h3 class='m-1 p-1 text-warning text-center'>-- Modo Admin --</h3>";
                }
            }

            ?>
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
                        <th></th>
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
                                    <td><a href="<?php echo '../ACCIONES/borraPhoto.php?id_fotografia=' . $datoFila["id_fotografia"] ?>" class="btn btn-secondary btn-light fw-bold border-white bg-warning"><i class="fa fa-trash"></i>Borrar</a></td>
                                </tr>
                        <?php

                            }
                        }

                        ?>
                </tbody>
            </table>
            <a href="index.php" class="btn btn-lg btn-light fw-bold border-white bg-warning"><i class="fas fa-home"></i>Ir a inicio</a>
            <a href="../ACCIONES/addPhoto.php" class="btn btn-lg btn-light fw-bold border-white bg-warning"><i class="fas fa-plus"></i> Añadir foto</a>
            <a href="../ACCIONES/finSession.php" class="btn btn-lg btn-light fw-bold border-white bg-danger"><i class="fas fa-door-closed"></i>Cerrar sesion</a>
        </div>
    </div>
</div>


<?php
                        //Si el valor de admin = 0 entra a la pagina en modo Usuario.
                     if ($admin == 0) {

                        echo "<h1 class='m-1 p-1 text-success text-center'>-- Usuario Registrado --</h1>";
?>

    <div class="container-fluid">
        <div class="row justify-content-center align-items-center minh-100">
            <div class="col-lg-12 p-5">
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
                            <th></th>
                            );
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($catalogo && $consultaSQL->rowCount() > 0) {
                            foreach ($catalogo as $datoFila) {
                                if ($datoFila['imagen'] != 0) {
                        ?>
                                    <tr class="text-center">
                                        <td class="p-2"><?php echo $datoFila["nombre"]; ?></td>
                                        <td class="p-2"><?php echo $datoFila["precio"]; ?></td>
                                        <td class="p-2"><?php echo $datoFila["tamanio"]; ?></td>
                                        <td class="p-2"><img style="width: 5em;" src="<?php echo $datoFila["imagen"]; ?>"></td>
                                        <td class="p-2"><?php echo $datoFila["creador"]; ?></td>
                                        <td class="p-2"><?php echo $datoFila["created_at"]; ?></td>
                                        <td class="p-2"><?php echo $datoFila["updated_at"]; ?></td>
                                        <td><a href="<?php echo '../ACCIONES/borraPhoto.php?nombre=' . $datoFila['nombre'] ?>" class="btn btn-secondary btn-light fw-bold border-white bg-warning"><i class="fas fa-coins"></i>Comprar</a></td>
                                    </tr>
                        <?php
                                }
                            }
                        }

                        ?>
                    </tbody>
                </table>
                <a href="../index.php" class="btn btn-lg btn-light fw-bold border-white bg-warning"><i class="fas fa-home"></i>Ir a inicio</a>
                <a href="../ACCIONES/addPhoto.php" class="btn btn-lg btn-light fw-bold border-white bg-warning"><i class="fas fa-skull"></i>Dar de baja</a>
                <a href="../ACCIONES/finSession.php" class="btn btn-lg btn-light fw-bold border-white bg-danger"><i class="fas fa-door-closed"></i>Cerrar sesion</a>
            </div>
        </div>
    </div>
<?php
                        //Si el valor de admin no es ni 0 ó 1 entra a la página como no registrado.
                    } elseif (!isset($_SESSION['admin'])) {
                        echo "<h1 class='m-1 p-1 text-primary text-center'>-- Visitante no Registrado --</h1>";
?>
    <div class="container-fluid mt-5">
        <div class="row justify-content-center align-items-center minh-100 mt-5">
            <div class="col-lg-12 p-5  mt-5">
                <h1 class="text-warning">PhotoSOLD.</h1>
                <table class="table table-striped table-hover table-dark " style="border:solid 2px blue;">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">Nombre</th>
                            <th scope="col">Precio (€)</th>
                            <th scope="col">Tamaño</th>
                            <th scope="col">Imagen</th>
                            <th scope="col">Creador</th>
                            <th scope="col">Creada</th>
                            <th scope="col">Actualizada</th>
                            <th></th>
                            );
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($catalogo && $consultaSQL->rowCount() > 0) {
                            foreach ($catalogo as $datoFila) {
                                if ($datoFila['imagen'] != 0) {
                        ?>
                                    <tr class="text-center">
                                        <td class="p-2"><?php echo $datoFila["nombre"]; ?></td>
                                        <td class="p-2"><?php echo $datoFila["precio"]; ?></td>
                                        <td class="p-2"><?php echo $datoFila["tamanio"]; ?></td>
                                        <td class="p-2"><img style="width: 5em;" src="<?php echo $datoFila["imagen"]; ?>"></td>
                                        <td class="p-2"><?php echo $datoFila["creador"]; ?></td>
                                        <td class="p-2"><?php echo $datoFila["created_at"]; ?></td>
                                        <td class="p-2"><?php echo $datoFila["updated_at"]; ?></td>
                                    </tr>
                        <?php
                                }
                            }
                        }

                        ?>
                    </tbody>
                </table>
                <a href="../index.php" class="btn btn-lg btn-light fw-bold border-white bg-primary"><i class="fas fa-home"></i>Ir a inicio</a>
                <a href="../ACCIONES/finSession.php" class="btn btn-lg btn-light fw-bold border-white bg-danger"><i class="fas fa-door-closed"></i>Cerrar sesion</a>
            </div>
        </div>
    </div>
<?php

            }
        }

?>
<?php include "../PUBLIC/PARTS/footer.php"; ?>