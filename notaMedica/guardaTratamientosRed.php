<?php
require "validaUsuario.php";//con

$query="Select Max(HistT_clave)+1 As cons From HistoriaTratRed Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs=  mysql_query($query,$conn);
$row=  mysql_fetch_array($rs);

$cons=$row['cons'];

if($cons==null || $cons=='')$cons=1;


$query="Insert into HistoriaTratRed(HistT_clave,Exp_folio, HistT_estatus, HistT_obs, Not_clave) 
                           Values('".$cons."','".$fol."','S','".$ObsTrat."','".$Not."');";
$rs=  mysql_query(utf8_decode($query),$conn);


                                               $query="SELECT HistT_clave, HistT_estatus, HistT_obs 
                                                       FROM HistoriaTratRed 
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
                                                      echo "<td>".utf8_encode($row['HistT_obs'])."</td>";
                                                      echo "<td><input type='button' onClick=\"eliminarTratamientosRed('".$row['HistT_clave']."','".$fol."','".$Not."')\" value='Eliminar' class=\"btn btn-danger btn-xs\">";
                                             echo "</tr>";
                                            }while($row = mysql_fetch_array($rs)); 
                                     echo" </table>";
                                     }


?>
