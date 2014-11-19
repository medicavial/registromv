<?php
require "validaUsuario.php";



$query="Select Max(HistA_clave)+1 As Cons From HistoriaAdiccionRed Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs=  mysql_query($query,$conn);
$row=  mysql_fetch_array($rs);


        

$cons=$row['Cons'];

if($cons=="" || $cons==null)$cons=1;

$query="Insert into HistoriaAdiccionRed(HistA_clave,Exp_folio, Adic_estatus, Adic_obs,Not_clave) 
                   Values('".$cons."','".$fol."','S','".$ObsAdiccion."','".$Not."')";
   $rs= mysql_query(utf8_decode($query),$conn);
  

                                               $query="SELECT HistA_clave, Adic_estatus, Adic_obs 
                                                       FROM HistoriaAdiccionRed 
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
                                                      echo "<td>".utf8_encode($row['Adic_obs'])."</td>";
                                                      echo "<td><input type='button' onClick=\"eliminarAdiRed('".$row['HistA_clave']."','".$fol."','".$Not."')\" value='Eliminar' class=\"btn btn-danger btn-xs\">";
                                             echo "</tr>";
                                            }while($row = mysql_fetch_array($rs)); 
                                     echo" </table>";
                                     }
 
?>
