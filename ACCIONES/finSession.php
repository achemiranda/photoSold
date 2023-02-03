<?php
//Cerramos la sesion y borramos los datos que puedan haber almacenados
    session_start();
    unset($_SESSION['dni']);
    unset($_SESSION['admin']);
    session_destroy();
    //redireccion al index
    header("Location: ../index.php");
?>