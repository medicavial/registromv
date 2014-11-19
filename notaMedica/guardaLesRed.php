<?php
require "validaUsuario.php";

if($_POST['guardaLesRed'])
{
$query="Insert into LesionNotaRed(Exp_folio, Les_clave, Cue_clave,Not_clave)
                       Values('".$_SESSION["FOLIO"]."','".$lesionRed."','".$cuerpo."',".$Not.")";

$rs= mysql_query(utf8_decode($query),$conn);
include 'ConsultaLesionRed.php';
}

?>
