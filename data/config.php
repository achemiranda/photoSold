<?php
//conexion a la base de datos creada...
     return [
            'db' => [
                'host' => $_ENV['DB_HOST'],
                'user' => $_ENV['DB_USER'],
                'pass' => $_ENV['DB_PASS'],
                'name' => $_ENV['DB_DB'],
                'options' => [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            ]
        ];
?>