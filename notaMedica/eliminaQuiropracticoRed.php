<?php
require "validaUsuario.php";//con

$query="Delete from HistoriaQuiroRed where HistoriaQ_clave =".$cla." and Exp_folio='".$fol."' and Not_clave='".$Not."' ";
$rs = mysql_query($query,$conn);

               
                                    $query="SELECT HistoriaQ_clave, Quiro_estatus, Quiro_obs 
                                            FROM HistoriaQuiroRed 
                                            Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
                                    $rs=mysql_query($query,$conn);
 
                            if($row=  mysql_fetch_array($rs)){
                                  echo"<table  width=\"100%\" class=\"table table-striped table-hover\">
                                           <tr>
                                               <th width=\"90%\"><b>Observaciones</b></th>
                                               <th width=\"10%\"><b>Eliminar</b></th>
                                           </tr>";

                                    do{
                                        echo "<tr>";
                                        echo "                <td>".utf8_encode($row['Quiro_obs'])."</td>";
                                        echo "                <td><input type='button' onClick=\"eliminarQuiroRed('".$row['HistoriaQ_clave']."','".$fol."','".$Not."')\" value='Eliminar' class=\"btn btn-danger btn-xs\">";
                                        echo " </tr>";
                                     }while($row = mysql_fetch_array($rs));
                                   echo"</table>";
                                  }


?>
