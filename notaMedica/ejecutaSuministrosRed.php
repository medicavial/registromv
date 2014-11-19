<?php

require "validaUsuario.php";

$sql="UPDATE Nota_med_red set Not_Estatus=12 where Not_clave=".$Not." and Exp_folio='".$fol."' ";
//echo $sql;
$rs=mysql_query($sql,$conn);

header("Location: NotaMedicaRedLlenado.php?fol=".$fol."&Not=".$Not."");
?>