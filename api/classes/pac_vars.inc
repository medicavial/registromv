<?php
$host	="medicavial.net";
$user	="medica_webusr";
$pwd	="tosnav50";
$db	="medica_registromv";
$conn=mysql_connect($host,$user,$pwd) or die('Error al conectar: ' . mysql_error());
mysql_select_db($db,$conn);


date_default_timezone_set('America/Mexico_City');
?>