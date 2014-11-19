<?php
require "validaUsuario.php";

$query="Delete from HistoriaOperacionRed where HistO_clave =".$cla." and Exp_folio='".$fol."' and Not_clave='".$Not."' ";
$rs = mysql_query($query,$conn);



                                               $query="SELECT HistO_clave, HistO_estatus, HistO_obs 
                                                       FROM HistoriaOperacionRed 
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
                                                      echo "<td>".utf8_encode($row['HistO_obs'])."</td>";
                                                      echo "<td><input type='button' onClick=\"eliminarIntQxRed('".$row['HistO_clave']."','".$fol."','".$Not."')\" value='Eliminar' class=\"btn btn-danger btn-xs\">";
                                             echo "</tr>";
                                            }while($row = mysql_fetch_array($rs)); 
                                     echo" </table>";
                                     }

?>
