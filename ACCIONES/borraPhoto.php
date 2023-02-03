<?php
session_start();

    $resultado = [
        'error' => false,
        'mensaje' => 'La fotografía ' . $_POST['nombre'] .  ' ha sido borrada con éxito.'
    ];
//Conexion a la bbdd
    $config = include '../data/config.php';

    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);


//Se hace una consulta de los datos a traves del id_fotografia a la tabla fotografia
            $id_fotografia = $_GET["id_fotografia"];

            $imagenBorrar = $conexion->prepare("SELECT * FROM fotografia WHERE id_fotografia=:id_fotografia");
            $imagenBorrar->bindParam("id_fotografia", $id_fotografia, PDO::PARAM_STR);
            $imagenBorrar->execute();
            $campoBorrado = $imagenBorrar->fetch();
//Se borra la fotografia indicada de la tabla a traves de su id_fotografia
            $imagenBorrada = $conexion->prepare('DELETE FROM fotografia WHERE id_fotografia=:id_fotografia');
            $imagenBorrada->bindParam("id_fotografia", $id_fotografia, PDO::PARAM_STR);
            $imagenBorrada->execute();      

//una vez borrada redireccionamos al catalogo para comprobar
            header('location:../VIEWS/catalogo.php');
        
    } catch (PDOException $error) {
        $resultado['error'] = true;
        //$resultado['mensaje'] = $error->getMessage();
    }
