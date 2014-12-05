<?php include('../configuracion.php'); 

// Chequear sesión
if($sesion_iniciada == '0')
{
	echo '
		<script type="text/javascript">
		function redireccionar()
		{
			location.href="../index.php"
		}
		setTimeout("redireccionar()", 2000);
		</script>';
	die();
}

if(isset($_POST['submit']))
{
	// Pasar a variables
	$nombre = $_POST['nombre'];
	$telefono = $_POST['telefono'];
	$email = $_POST['email'];
	$localidad = $_POST['localidad'];
	$provincia = $_POST['provincia'];

	if($nombre == '' || $localidad == '' || $provincia == '')
	{
		// Chequear si los campos obligatorios están vacios.
		echo '<div class="container-fluid"><p class="lead text-center bg-danger" style="margin-top: 10px;"><b>ERROR:</b> No puede dejar los espacios "Nombre", "Localidad" y/o "Provincia" vacios.</p></div>';
	}
	else
	{
		// Empezar a hacer la query MySQL para agregarlos a la Base de Datos.
		$agregar_cliente = "INSERT INTO clientes (nombre, telefono, email, provincia, localidad) VALUES ('".$nombre."','".$telefono."', '".$email."', '".$provincia."', '".$localidad."')";

		mysql_query($agregar_cliente);

		echo '<div class="container-fluid"><p class="lead text-center bg-success style="margin-top: 10px;"><b>INFO:</b> Nuevo cliente agregado correctamente. Redireccionando.</p></div>
		<script type="text/javascript">
		function redireccionar()
		{
			location.href="../index.php"
		}
		setTimeout("redireccionar()", 2000);
		</script>';
	}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Agregar Cliente | Inventario de Clientes</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link href="../css/font-awesome.min.css" rel="stylesheet">

	<script	href="js/jquery.js"></script>
	<script href="js/bootstrap.js"></script>
</head>
<body>
	<header>
		<div class="container">
			<h2>Inventario de Clientes <small>Agregar Cliente</small></h2>
		</div>
	</header>
	<div class="container">
	<form action="agregar_cliente.php" class="form-group" method="POST">
		<label for="nombre">Nombre y apellido o Razón social:</label><input type="text" class="form-control" name="nombre" placeholder="Nombre del Cliente"/><br />
		<label for="telefono">Teléfono:</label><input type="text" class="form-control" name="telefono" placeholder="Teléfono del Cliente (Formato: Característica-Número)"/><br />
		<label for="email">Correo:</label><input type="text" class="form-control" name="email" placeholder="Email del Cliente (Formato: nombre@servidor.com)"><br />
		<label for="localidad">Localidad:</label><input type="text" class="form-control" name="localidad" placeholder="Localidad del Cliente"><br />
		<label for="provincia">Provincia:</label><select name="provincia" id="provincia" class="form-control">
			<option value="">Seleccionar una provincia...</option>
			<option value="Buenos Aires">Buenos Aires</option>
			<option value="Catamarca">Catamarca</option>
			<option value="Chaco">Chaco</option>
			<option value="Chubut">Chubut</option>
			<option value="Córdoba">Córdoba</option>
			<option value="Corrientes">Corrientes</option>
			<option value="Entre Ríos">Entre Ríos</option>
			<option value="Formosa">Formosa</option>
			<option value="Jujuy">Jujuy</option>
			<option value="La Pampa">La Pampa</option>
			<option value="La Rioja">La Rioja</option>
			<option value="Mendoza">Mendoza</option>
			<option value="Neuquén">Neuquén</option>
			<option value="Río Negro">Río Negro</option>
			<option value="Salta">Salta</option>
			<option value="San Juan">San Juan</option>
			<option value="San Luis">San Luis</option>
			<option value="Santa Cruz">Santa Cruz</option>
			<option value="Santa Fe">Santa Fe</option>
			<option value="Santiago del Estero">Santiago del Estero</option>
			<option value="Tucumán">Tucumán</option>
		</select><br />
		<a href="../index.php" class="btn btn-lg btn-warning pull-right" style="margin: 0 10px;">Cancelar</a> <input type="submit" name="submit" class="btn btn-success btn-lg pull-right" value="Agregar Cliente">
	</form>
	</div>
</body>
</html>