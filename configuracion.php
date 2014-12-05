<?php

// Conectando a la base de datos

$db_host= "localhost";
$db_name= "clientes";
$db_user= "root";
$db_password = "";
$conexion = mysql_connect($db_host, $db_user, $db_password) or die ('No se pudo realizar la conexión a la base de datos');

mysql_select_db($db_name, $conexion);

@session_start();

if(!empty($_SESSION['usuario']))
{
	$sql = mysql_query("SELECT * FROM usuarios WHERE usuario='".$_SESSION['usuario']."'");
	$row = mysql_fetch_array($sql);

	$usuarios = mysql_query("SELECT * FROM usuarios");
	if($user_ok = mysql_fetch_array($usuarios))
	{
		$sesion_iniciada = '1';
	}
}
	else
	{
		$sesion_iniciada = '0';
	}	


?>