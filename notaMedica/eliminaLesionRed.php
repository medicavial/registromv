<?php
require "validaUsuario.php";//con

$query="Delete from LesionNotaRed where LesN_clave =".$cla.";";
$rs = mysql_query($query,$conn);
include 'ConsultaLesionRed.php';
?>

