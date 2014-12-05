<?php
include('configuracion.php');
session_start('configuracion.php');

$sql="DELETE FROM `usuarios` (status) WHERE id='$_SESSION[id]'";

session_destroy();

header('location: index.php');

?>