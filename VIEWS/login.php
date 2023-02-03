<?php
session_start();
if (isset($_POST['login'])) {
	$config = include '../data/config.php';

	try {
		//realizamos la peticion de conexion pdo y se almacena en una variable
		$dsn      = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
		$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
//Escogemos del formulario los datos que usaremos para el login
		$dni      = trim(strip_tags($_POST['dni']));
		$password = trim(strip_tags($_POST['password']));

		if (empty($_POST['dni']) || empty($_POST['password'])) {

			echo "<h3 style='color:red;text-align:center;'>Por favor, rellene los campos para el login.<h3>";
		} else {
//Se prepara la peticion de la consulta donde dni y password deben coincidir
			$consultaSQL = $conexion->prepare("SELECT * FROM usuario WHERE dni=:dni AND password=:password");
			$consultaSQL->bindParam("dni", $dni, PDO::PARAM_STR);
			$consultaSQL->bindParam("password", $password, PDO::PARAM_STR);
			$consultaSQL->execute();

			$login = $consultaSQL->fetch(PDO::FETCH_ASSOC);
			if (isset($login["dni"])) {

				if ($login["password"] == $password) {

					$_SESSION["dni"] = $login["dni"];
//Si coinciden redirecciona al index
					header("Location:../index.php");
				} else {
					echo "<h3 style='color:red;text-align:center;'>La contraseña no es correcto.<h3>";
				}
			} else {
				echo "<h3 style='color:red;text-align:center;'>El usuario no es correcto.<h3>";
			}
		}
	} catch (PDOException $error) {
		$resultado['error']   = true;
		$resultado['mensaje'] = $error->getMessage();
	}
}
?>

<?php
if (isset($resultado)) {
?>
	<div class="container mt-3">
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert- <?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
					<?= $resultado["mensaje"] ?>
				</div>
			</div>
		</div>
	</div>

<?php
}
?>
<?php include "../PUBLIC/PARTS/header.php"; ?>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Entrar</h3>
			</div>
			<div class="card-body">
				<form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" class="form-control" placeholder="usuario" name="dni">

					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" class="form-control" placeholder="contraseña" name="password">
					</div>
					<div class="row align-items-center remember">
					</div>
					<div class="form-group">
						<input type="submit" value="Login" class="btn float-right login_btn" name="login">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					¿No tiene cuenta?
				</div>
				<div class="d-flex justify-content-center">
					<a href="register.php">Dar de alta</a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include "../PUBLIC/PARTS/footer.php"; ?>
</body>

</html>