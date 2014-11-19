<?php 
require 'validaUsuario.php';

$sql="UPDATE Nota_med_red SET Pronostico='".$pronostico."',Not_obs_expediente='".$obsexp."', Not_fecha_registro= now(), Not_Estatus=13 WHERE Not_clave='".$Not."' and Exp_folio='".$fol."' ";
$rs=mysql_query($sql,$conn);


header("Location: NotaMedicaRedLlenado.php?fol=".$fol."&Not=".$Not."");



?>