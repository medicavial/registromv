<?php
require "validaUsuario.php";


$fecnac      = trim($fecnac);
$txtedad     = trim($txtedad);
$txtmeses    = trim($txtmeses);
$telefono    = trim($telefono);
$mail        = trim($mail);


 $query="Update Expediente Set Exp_fechaNac='".$fecnac."', Exp_edad='".$txtedad."', Exp_meses='".$txtmeses."', Exp_sexo='".$sexo."', Rel_clave='".$Religion."', Ocu_clave=".$Ocupacion.", Edo_clave=".$EdoCivil.", Exp_mail='".$mail."', Exp_telefono='".$telefono."'
    where Exp_folio='".$fol."'";
$rs=  mysql_query($query,$conn);


$consulta = "SELECT max(Not_clave)+1 as cons FROM Nota_med_red WHERE Exp_folio = '". $fol."'   ";
$rs  = mysql_query($consulta, $conn);
$row =  mysql_fetch_array($rs);
$Not = $row['cons'];

if($Not ==null|| $Not=="") $Not=1;

$query = "INSERT INTO Nota_med_red (not_clave,Exp_folio,Ocu_clave, not_Obs_religion,Edo_clave, Not_Estatus) 
    VALUES('".$Not."','".$fol."','".$Ocupacion."','".$Religion."','".$EdoCivil."', 1)";
$rs= mysql_query($query,$conn);


$header="Location: NotaMedicaRedLlenado.php?fol=".$fol."&Not=".$Not;

header($header);

?>