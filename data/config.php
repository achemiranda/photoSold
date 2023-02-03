<?php
//conexion a la base de datos creada...
    return [
        'db' => [
            'host' => 'localhost',
            'user' => 'root',
            'pass' => '',
            'name' => 'photoSold',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        ]
    ];
?>