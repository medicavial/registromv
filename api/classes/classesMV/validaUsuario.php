<?php
	session_start( );
	require "../recursos/func/pac_vars.inc";//con
	
	if (!isset($_SESSION["usuClave"]))
  {
    // si no existe la acreditacion guarda un mensaje
    $_SESSION["message"] = "Lo sentimos parece que usted no esta autorizado
                            para acceder a este URL {$_SERVER["REQUEST_URI"]}";
    header("Location: logout.php"); // Se envia a la pagina de entrada.
    exit;
  }
?>