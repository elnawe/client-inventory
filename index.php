<?php include('configuracion.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Inventario de Clientes</title>

	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link href="css/font-awesome.min.css" rel="stylesheet">

	<script	href="js/jquery.js"></script>
	<script href="js/bootstrap.js"></script>
</head>
<body>
	<header>
		<div class="container">
			<h1>Inventario de Clientes <small>Creado por Nahuel J. Sacchetti</small></h1>
		</div>
	</header>

	<div class="container">
		<section class="col-md-9">
			<article class="text">
			<?php 
			// Si está la sesión iniciada: Mostrar listado de clientes anotados.
			if($sesion_iniciada == '1'): ?>
					<ul class="list-inline">
						<li><a href="forms/agregar_cliente.php" class="btn btn-success btn-sm">Agregar Cliente</a></li>
						<li><a href="forms/admin_cliente.php" class="btn btn-info btn-sm">Administrar Clientes</a></li>
					</ul>
				<div class="row">
					<div class="container-fluid">
					<?php // Buscador de Clientes
					if(isset($_POST['buscar']))
					{
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
												</tr>';

							while($buscados = mysql_fetch_assoc($queryBuscar))
							{
									echo '
								<tr>
								<td>'.$buscados['id'].'</td>
								<td>'.$buscados['nombre'].'</td>
								<td>'.$buscados['telefono'].'</td>
								<td>'.$buscados['email'].'</td>
								<td>'.$buscados['localidad'].'</td>
								<td>'.$buscados['provincia'].'</td>
								</tr>';
							}

								echo '
									</table>
								</div>
								<a href="index.php" class="btn btn-default pull-right">Cerrar búsqueda</a><br /><br />';
						}
						else
						{
							echo '<p class="lead"><span class="fa fa-search"></span> No se han encontrado resultados para su búsqueda.</p>';
						}
					} ?>
							<?php // foreach(cada cliente)
							$query = mysql_query("SELECT * FROM clientes");

							if(mysql_num_rows($query) > 0)
							{
								echo '
								<p class="lead">Listado de Clientes</p>
								<div class="table-responsive">
										<table class="table table-condensed table-hover">
										<tr class="info">
											<td>#</td>
											<td>Cliente</td>
											<td>Teléfono</td>
											<td>Mail</td>
											<td>Localidad</td>
											<td>Provincia</td>
										</tr>';
								while($clientes = mysql_fetch_assoc($query))
								{
									echo '
								<tr>
								<td>'.$clientes['id'].'</td>
								<td>'.$clientes['nombre'].'</td>
								<td>'.$clientes['telefono'].'</td>
								<td>'.$clientes['email'].'</td>
								<td>'.$clientes['localidad'].'</td>
								<td>'.$clientes['provincia'].'</td>
								</tr>';
								}

								echo '
									</table>
								</div>';
							}
							else
							{
								echo '<p class="lead">No hay clientes.</p>';
							}
						 	?>

					</div>
				</div>
			<?php elseif($sesion_iniciada == '0'): ?>
				<p class="lead">Debe iniciar sesión para poder utilizar la aplicacón.</p>
			<?php endif; ?>
			</article>
		</section>
		<aside class="col-md-3">
			<div class="container-fluid">
				<form action="index.php" class="form" method="POST">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon"><i class="fa fa-search"></i></div>
							<input type="text" class="form-control" name="nombre" maxlength="15">
						</div>
						<input type="submit" value="" class="hidden" name="buscar">
					</div>
				</form>
			</div>

			<div class="container-fluid">
				<?php

				if($sesion_iniciada == '1')
				{
					echo 'Bienvenido <b class="text-capitalize">'.$_SESSION['usuario'].'</b><br /><br />
					<a href="logout.php" class="btn btn-danger btn-md btn-block">Cerrar sesión</a>';
				}
				else if($sesion_iniciada == '0')
				{
					echo '
					<form action="login.php" class="iniciar_sesion" method="POST">
					<label>Usuario:</label><br />
					<input type="text" name="usuario" class="form-control" placeholder="Ingrese nombre de Usuario" maxlength="10" /><br />
					<label>Contraseña:</label><br />
					<input type="password" name="password" class="form-control" placeholder="Ingrese contraseña" maxlength="10"/><br />
					<input type="submit" name="submit" value="Iniciar sesión" class="btn bnt-lg btn-success btn-block" /><br />
					</form>';
				}
				?>
			</div>
		</aside>
	</div>
</body>
</html>