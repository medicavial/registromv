<?php 
require 'validaUsuario.php';



$sql="UPDATE Nota_med_red SET Not_temperatura='".$temp."',Not_talla='".$talla."',Not_peso='".$peso."',Not_fr='".$frecResp."',Not_fc='".$frecCard."',Not_ta='".$sistole."/".$astole."',Not_obs_vitales='".$obs."',Not_Estatus = '5' where Not_clave='".$Not."' and Exp_folio='".$fol."' ";
$rs=mysql_query($sql,$conn);

header("Location:NotaMedicaRedLlenado.php?fol=".$fol."&Not=".$Not."");
?>