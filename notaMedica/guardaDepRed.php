<?php
require "validaUsuario.php";



$query="Select Max(HistD_clave)+1 As Cons From HistoriaDeporteRed Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs=  mysql_query($query,$conn);
$row=  mysql_fetch_array($rs);

$cons=$row['Cons'];

if($cons=="" || $cons==null)$cons=1;

$query="Insert into HistoriaDeporteRed(HistD_clave,Exp_folio, Dep_estatus, Dep_obs,Not_clave) 
                   Values('".$cons."','".$fol."','S','".$ObsDeporte."','".$Not."')";
   $rs= mysql_query(utf8_decode($query),$conn);
   

   
   
   
  

                                               $query="SELECT HistD_clave, Dep_estatus, Dep_obs 
                                                       FROM HistoriaDeporteRed 
                                                       Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
                                               $rs=mysql_query($query,$conn);
 
                                      if($row=  mysql_fetch_array($rs)){ 
    
                                      echo"<table width=\"100%\" class=\"table table-striped table-hover\">
                                                 <tr>
                                                       <th width=\"90%\"><b>Observaciones</b></th>
                                                       <th width=\"10%\"><b>Eliminar</b></th>
                                                 </tr>";

                                          do{ 
                                             echo "<tr>";
                                                      echo "<td>".utf8_encode($row['Dep_obs'])."</td>";
                                                      echo "<td><input type='button' onClick=\"eliminarDepRed('".$row['HistD_clave']."','".$fol."','".$Not."')\" value='Eliminar' class=\"btn btn-danger btn-xs\">";
                                             echo "</tr>";
                                            }while($row = mysql_fetch_array($rs)); 
                                     echo" </table>";
                                     }
 
?>
