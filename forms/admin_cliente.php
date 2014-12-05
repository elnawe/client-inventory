<?php 
include('../configuracion.php');

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


// BORRAR CLIENTE
if(isset($_POST['borrar']))
{
	$clienteBorrar = $_POST['id'];

	mysql_query("DELETE FROM clientes WHERE id='".$clienteBorrar."'");

	echo '<div class="container-fluid"><p class="lead text-center bg-success style="margin-top: 10px;"><b>INFO:</b> Cliente borrado correctamente.</p></div>';
}

// MODIFICAR CLIENTE
if(isset($_POST['submit']))
{
	$idCliente = $_POST['id'];
	$nuevoNombre = $_POST['nombre'];
	$nuevoTelefono = $_POST['telefono'];
	$nuevoEmail = $_POST['email'];
	$nuevoProvincia = $_POST['provincia'];
	$nuevoLocalidad = $_POST['localidad'];

	mysql_query("UPDATE clientes SET nombre='".$nuevoNombre."', telefono='".$nuevoTelefono."', email='".$nuevoEmail."', provincia='".$nuevoProvincia."', localidad='".$nuevoLocalidad."' WHERE id='".$idCliente."'");

	echo '<div class="container-fluid"><p class="lead text-center bg-success style="margin-top: 10px;"><b>INFO:</b> Cliente: "'.$nuevoNombre.'" editado correctamente.</p></div>';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Administrar Clientes | Inventario de Clientes</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link href="../css/font-awesome.min.css" rel="stylesheet">

	<script	href="js/jquery.js"></script>
	<script href="js/bootstrap.js"></script>
</head>
<body>
	<header>
		<div class="container">
			<h2>Inventario de Clientes <small>Administrar Clientes</small></h2>
		</div>
	</header>
	<div class="container">
		<form action="admin_cliente.php" name="modificar" method="POST" role="form">
			<div class="form-group">
				<label for="buscarCliente"><span class="fa fa-search"></span> Buscar cliente para modificar</label>
				<input type="text" class="form-control" name="nombre" placeholder="Ingrese el nombre, apellido, razón social, localidad o provincia del cliente para buscar..." />
			</div>
			<div class="pull-right">
				<input type="submit" class="btn btn-lg btn-success" value="Buscar" name="buscar"> <a href="../index.php" class="btn btn-warning btn-lg" style="margin: 0 10px;">Cancelar</a>
			</div>
				
		</form>
	</div>
<?php
	if(isset($_POST['buscar']))
{
	echo '<div class="container-fluid">
		<section class="col-md-12" style="margin: 10px 0 0 0;">';

	$buscarNombre = $_POST['nombre'];
	$queryBuscar = mysql_query("SELECT * FROM clientes WHERE nombre LIKE '%".$buscarNombre."%' OR localidad LIKE '%".$buscarNombre."%' OR provincia LIKE '%".$buscarNombre."%'");
	$result = mysql_num_rows($queryBuscar);
	if($result > 0)
	{
		echo '
		
		<p class="lead">Clientes encontrados con <em>"'.$buscarNombre.'"</em></p>
					<div class="table-responsive">
							<table class="table table-condensed table-hover">
							<tr class="info">
								<td>#</td>
								<td>Cliente</td>
								<td>Teléfono</td>
								<td>Mail</td>
								<td>Localidad</td>
								<td>Provincia</td>
								<td class="text-center"><i class="fa fa-pencil-square-o"> Modificar</i></td>
								<td class="text-center"><i class="fa fa-trash"> Borrar</i></td>
							</tr>';
		while($buscados = mysql_fetch_assoc($queryBuscar))
		{
				echo '
			<form role="form" action="admin_cliente.php" method="POST">
			<tr>
			<td>'.$buscados['id'].'</td>
			<input type="hidden" name="id" value="'.$buscados['id'].'" />
			<td>'.$buscados['nombre'].'</td>
			<td>'.$buscados['telefono'].'</td>
			<td>'.$buscados['email'].'</td>
			<td>'.$buscados['localidad'].'</td>
			<td>'.$buscados['provincia'].'</td>
			<td class="text-center"><a href="admin_cliente.php?id='.$buscados['id'].'"><input type="submit" value="Editar" name="editar" class="btn btn-xs btn-info"></a></td>
			<td class="text-center"><a href="admin_cliente.php?id='.$buscados['id'].'"><input type="submit" value="Borrar" name="borrar" class="btn btn-xs btn-danger"></a></td>
			</tr>
			</form>';
		}
			echo '
				</table>
		</div>

			<a href="../index.php" class="btn btn-default pull-right">Cerrar búsqueda</a><br /><br />';
	}
	else
	{
		echo '<p class="lead"><span class="fa fa-search"></span> No se han encontrado resultados para su búsqueda.</p>';
	}

	echo '</section>
			</div>';
}

if(isset($_POST['editar']))
{
	$clienteModificar = $_POST['id'];
	$get_query = mysql_query("SELECT * FROM clientes WHERE id='".$clienteModificar."'");

	$datos = mysql_fetch_array($get_query);

	if($datos > 0)
	{
		echo '
		<div class="container">
		<p class="lead"><b>Editar cliente:</b> '.$datos['nombre'].'</p>
	<form action="admin_cliente.php" class="form-group" method="POST">
		<input type="hidden" name="id" value="'.$datos['id'].'" />
		<label for="nombre">Nombre y apellido o Razón social:</label><input type="text" class="form-control" name="nombre" value="'.$datos['nombre'].'" placeholder="Nombre del Cliente"/><br />
		<label for="telefono">Teléfono:</label><input type="text" class="form-control" name="telefono" value="'.$datos['telefono'].'" placeholder="Teléfono del Cliente (Formato: Característica-Número)"/><br />
		<label for="email">Correo:</label><input type="text" class="form-control" name="email" value="'.$datos['email'].'" placeholder="Email del Cliente (Formato: nombre@servidor.com)"><br />
		<label for="localidad">Localidad:</label><input type="text" class="form-control" name="localidad" value="'.$datos['localidad'].'" placeholder="Localidad del Cliente"><br />
		<label for="provincia">Provincia:</label><input name="provincia" class="form-control" type="text" value="'.$datos['provincia'].'"><br />
		<div class="pull-right"><input type="submit" name="submit" class="btn btn-success btn-lg" value="Editar Cliente"><a href="../index.php" class="btn btn-lg btn-warning" style="margin: 0 10px;">Cancelar</a></div>
		</form>
	</div>';
	}
}
?>
</body>
</html>