<?php
session_start();
//Si existe la peticion del boton registrar
if (isset($_POST['registrar'])) {

    $resultado = [
        'error' => false,
        'mensaje' => 'El usuario ' . $_POST['nombre'] . $_POST['apellido'] .  ' ha sido creado con éxito'
    ];
    //Conexion a la bbdd
    $config = include '../data/config.php';

    try {
        //preparacion de la conexion y almacenada en una variable
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
//Almacenamos los datos del formulario
        $usuario = array(
            "dni" => trim(strip_tags($_POST['dni'])),
            "nombre" => trim(strip_tags($_POST['nombre'])),
            "apellidos" => trim(strip_tags($_POST['apellidos'])),
            "email" => trim(strip_tags($_POST['email'])),
            "password" => trim(strip_tags($_POST['password']))
        );


        if (empty($_POST['dni']) || empty($_POST['nombre']) || empty($_POST['apellidos']) || empty($_POST['email']) || empty($_POST['password'])) {

            echo "<h3 style='color:red;text-align:center;'>Debe rellenar todos los campos para registrarse<h3>";
        } else {
//preparacion de la consulta para introducir en la tabla usuario los datos del formulario
            $consultaSQL = "INSERT INTO usuario (dni,nombre,apellidos,email,password)";
            $consultaSQL .= "values (:" . implode(", :", array_keys($usuario)) . ")";
            $sentencia = $conexion->prepare($consultaSQL);
            $sentencia->execute($usuario);
//redireccion a login para acceder una vez registrado
            header('location:login.php');
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
        <div class="card" style="height:26em">
            <div class="card-header">
                <h3>Registrarse</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="DNI" name="dni">

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user-tie"></i></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Nombre" name="nombre">

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Apellidos" name="apellidos">

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-at"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Email" name="email">

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></i></span>
                        </div>
                        <input type="password" class="form-control" placeholder="contraseña" name="password">

                    </div>
                    <div class="row align-items-center remember">
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-secondary bg-danger" name="registrar">Registrar</button>
                        <a type="button" class="btn btn-secondary bg-warning" href="login.php">A Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "../PUBLIC/PARTS/footer.php"; ?>
</body>

</html>