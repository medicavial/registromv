<?php
require "validaUsuario.php";//con


$query="Delete from FamEnfermedadRed where FamE_clave =".$cla." and Exp_folio='".$fol."' and Not_clave='".$Not."';";
$rs = mysql_query($query,$conn);





 $query="SELECT FamE_clave, Enf_nombre, Fam_nombre, Est_nombre, FamE_obs 
        FROM FamEnfermedadRed 
        Inner Join Enfermedad on FamEnfermedadRed.Enf_clave=Enfermedad.Enf_clave 
        Inner Join Familia on FamEnfermedadRed.Fam_clave=Familia.Fam_clave 
        Inner Join EstatusFam on FamEnfermedadRed.Est_clave=EstatusFam.Est_clave 
        Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
    $rs=mysql_query($query,$conn);
 
if($row= mysql_fetch_array($rs))
    {

echo"<table id=\"TablaHeredo\" align=\"center\" width=\"100%\" class=\"table table-striped table-hover\">
  <tr>
       <th width=\"20%\"><b>Enfermedad</b></th>
       <th width=\"15%\"><b>Familiar</b></th>
       <th width=\"15%\"><b>Estatus</b></th>
       <th width=\"40%\"><b>Observaciones</b></th>
       <th width=\"10%\"><b>Eliminar</b></th>
  </tr>";

do{
  echo "  <tr>";
  echo "                <td>".utf8_encode($row['Enf_nombre'])."</td>";
  echo "                <td>".utf8_encode($row['Fam_nombre'])."</td>";
  echo "                <td>".utf8_encode($row['Est_nombre'])."</td>";
  echo "                <td>".utf8_encode($row['FamE_obs'])."</td>";
  echo "                <td><input type=\"button\" class=\"btn btn-danger btn-xs\" onClick=\"eliminarHeredoRed('".$row['FamE_clave']."','".$fol."','".$Not."')\" value='Eliminar'";
  echo " </tr>";
  }  while($row = mysql_fetch_array($rs));

  echo"  </table>";
    }


?>


