<?php
require "validaUsuario.php";


   $query="Select Max(Hist_clave)+1 As Cons 
       From HistoriaPadecimientoRed 
       Where Exp_folio='".$fol."' and Not_clave='".$Not."'
       ";
   $rs=  mysql_query($query,$conn);
   $row=  mysql_fetch_array($rs);
   
   $cons=$row['Cons'];
   
   if($cons==null || $cons=="")$cons=1;


   $query="Insert into HistoriaPadecimientoRed(Hist_clave, Exp_folio, Pad_clave, Pad_obs,Not_clave) 
                              Values('".$cons."','".$fol."',".$IdCronico.",'".$ObsCronico."','".$Not."');";
   $rs=  mysql_query(utf8_decode($query),$conn);
   
   
   
       $query="SELECT Hist_clave, Pad_nombre, Pad_obs 
           FROM HistoriaPadecimientoRed 
           Inner Join Padecimientos on HistoriaPadecimientoRed.Pad_clave=Padecimientos.Pad_clave 
           Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
    $rs=mysql_query($query,$conn);
    
if($row=mysql_fetch_array($rs)){

 echo"<table  width=\"100%\" class=\"table table-striped table-hover\" >
  <tr>
       <th width=\"20%\"><b>Enfermedad</b></th>
       <th width=\"80%\"><b>Observaciones</b></th>
        <th width=\"10%\"><b>Eliminar</b></th>
  </tr>";

  do{
  echo "  <tr>";
  echo "                <td>".utf8_encode($row['Pad_nombre'])."</td>";
  echo "                <td>".utf8_encode($row['Pad_obs'])."</td>";
  echo "                <td><input type='button' onClick=\"eliminarPadCronRed('".$row['Hist_clave']."','".$fol."','".$Not."')\" value='Eliminar' class=\"btn btn-danger btn-xs\" >";
  echo " </tr>";
  }while($row = mysql_fetch_array($rs));
  
  echo"</table>";
}
   
?>
