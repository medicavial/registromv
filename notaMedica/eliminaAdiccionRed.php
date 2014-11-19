<?php
require "validaUsuario.php";

$query="Delete from HistoriaAdiccionRed where HistA_clave =".$cla." and Exp_folio='".$fol."' and Not_clave='".$Not."' ";
$rs = mysql_query($query,$conn);




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
