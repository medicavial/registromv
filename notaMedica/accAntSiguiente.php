<?php 
require 'validaUsuario.php';



$sql = "UPDATE Nota_med_red SET Not_Estatus = '4' WHERE Not_clave = '".$Not."' AND Exp_folio = '".$fol."';";
$rs = mysql_query($sql, $conn);

header("Location:NotaMedicaRedLlenado.php?fol=".$fol."&Not=".$Not."");
?>