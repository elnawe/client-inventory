<?php
include("configuracion.php");


$usuario = mysql_real_escape_string($_POST['usuario']);
$password = md5($_POST['password']);

if($usuario == '' or $password == '')
{
	header('location: index.php');
}
else
{
	$usuarios = mysql_query("SELECT * FROM usuarios WHERE usuario='".$usuario."' AND password='".$password."'");

	$user_ok = mysql_fetch_array($usuarios);

	if($user_ok > 0)
	{
		$_SESSION['usuario'] = $user_ok['usuario'];
		$_SESSION['password'] = $user_ok['password'];
		$_SESSION['id'] = $user_ok['id'];

		header('location: '.$_SERVER['HTTP_REFERER']);
	}
	else
	{
		echo '
		<script>javascript:alert("Usuario y/o contraseña incorrectos.");</script>
		<script>javascript:history.back(1)</script>'; 
	}
}
?>