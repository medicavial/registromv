<?php
require 'validaUsuario.php';

$query="Update Nota_med_red Set Not_Estatus=2 Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs=  mysql_query($query,$conn);


$header="Location: NotaMedicaRedLlenado.php?fol=".$fol."&Not=".$Not;

header($header);




?>
