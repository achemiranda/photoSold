<?php
//Instalacion de la base de datos
    $config = include 'config.php';
    try {
//almacenamos en una variable la peticion de conexion pdo
        $conexion = new PDO('mysql:host=' . $config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['options']);
        $sql = file_get_contents("BBDD.sql");
        $conexion->exec($sql);
        echo "La base de datos y la tabla han sido creadas con éxito";
    } catch (PDOException $error) {
        echo $error->getMessage();
    }
?>
