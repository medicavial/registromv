<?php
require "validaUsuario.php";

$query="Delete from HistoriaOtrasRed where HistOt_clave =".$cla." and Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs = mysql_query($query,$conn);




 $query="SELECT HistOt_clave, Otr_nombre, HistOt_obs 
                                               FROM HistoriaOtrasRed 
                                               Inner Join Otras on HistoriaOtrasRed.Otr_clave=Otras.Otr_clave 
                                               Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
                                           $rs=mysql_query($query,$conn);

                                         if($row=mysql_fetch_array($rs)){

                                          echo"<table width=\"100%\" class=\"table table-striped table-hover\" >
                                                  <tr>
                                                         <th width=\"20%\"><b>Enfermedad</b></th>
                                                         <th width=\"80%\"><b>Observaciones</b></th>
                                                         <th width=\"10%\"><b>Eliminar</b></th>
                                                  </tr>";

                                           do{
                                               echo "  <tr>";
                                               echo "  <td>".utf8_encode($row['Otr_nombre'])."</td>";
                                               echo "  <td>".utf8_encode($row['HistOt_obs'])."</td>";
                                               echo "  <td><input type='button' onClick=\"eliminarOtrEnfRed(".$row['HistOt_clave'].",'".$fol."','".$Not."')\" value='Eliminar' class=\"btn btn-danger btn-xs\">";
                                               echo " </tr>";
                                             }while($row = mysql_fetch_array($rs));
                                             echo"</table>";
                                                   }




?>
