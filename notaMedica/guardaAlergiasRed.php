<?php
require "validaUsuario.php";

$query="Select Max(HistA_clave)+1 As Cons From HistoriaAlergiasRed Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs=  mysql_query($query,$conn);
$row=  mysql_fetch_array($rs);
$cons=$row['Cons'];

if($cons==null || $cons=="")$cons=1;

$query="Insert into HistoriaAlergiasRed(HistA_clave,Exp_folio, Ale_clave, Ale_obs, Not_clave) 
                                 Values('".$cons."','".$fol."',".$IdAlergias.",'".$ObsAlergias."','".$Not."');";
$rs=  mysql_query(utf8_decode($query),$conn);




$query="SELECT HistA_clave, Ale_nombre, Ale_obs 
                                                     FROM HistoriaAlergiasRed 
                                                     Inner Join Alergias on HistoriaAlergiasRed.Ale_clave=Alergias.Ale_clave 
                                                     Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
                                                     $rs=mysql_query($query,$conn);
 
                                             if($row=  mysql_fetch_array($rs)){
                                   echo"<table width=\"100%\" class=\"table table-striped table-hover\">
                                                 <tr>
                                                      <th width=\"20%\"><b>Alergia</b></th>
                                                      <th width=\"80%\"><b>Observaciones</b></th>
                                                      <th width=\"10%\"><b>Eliminar</b></th>
                                                 </tr>";
                                       do{
                                             echo "<tr>";
                                                 echo "<td>".utf8_encode($row['Ale_nombre'])."</td>";
                                                 echo "<td>".utf8_encode($row['Ale_obs'])."</td>";
                                                 echo "<td><input type='button' onClick=\"eliminarAlergiaRed('".$row['HistA_clave']."','".$fol."','".$Not."')\" value='Eliminar' class=\"btn btn-danger btn-xs\">";
                                             echo " </tr>";
                                         }while($row = mysql_fetch_array($rs));
                                    echo"</table>";
                                 }


?>
