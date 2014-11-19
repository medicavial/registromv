<?php
require "validaUsuario.php";//con

$query="Select Max(HistE_clave)+1 As cons From HistoriaEspaldaRed Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs=  mysql_query($query,$conn);
$row=  mysql_fetch_array($rs);

$cons=$row['cons'];

if($cons==null || $cons=='')$cons=1;


$query="Insert into HistoriaEspaldaRed(HistE_clave,Exp_folio, Esp_estatus, Esp_obs, Not_clave) 
                           Values('".$cons."','".$fol."','S','".$ObsEspalda."','".$Not."');";
$rs=  mysql_query(utf8_decode($query),$conn);


                                               $query="SELECT HistE_clave, Esp_estatus, Esp_obs 
                                                       FROM HistoriaEspaldaRed 
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
                                                      echo "<td>".utf8_encode($row['Esp_obs'])."</td>";
                                                      echo "<td><input type='button' onClick=\"eliminarEspRed('".$row['HistE_clave']."','".$fol."','".$Not."')\" value='Eliminar' class=\"btn btn-danger btn-xs\">";
                                             echo "</tr>";
                                            }while($row = mysql_fetch_array($rs)); 
                                     echo" </table>";
                                     }

?>
