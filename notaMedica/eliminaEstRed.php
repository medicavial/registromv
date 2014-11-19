<?php
require "validaUsuario.php";//con


$query="Delete from EstudiosRealizadosRed where Est_clave =".$cla." and Exp_folio='".$fol."' and Not_clave='".$Not."';";
$rs = mysql_query($query,$conn);


                         $query="SELECT Est_clave, Est_estudio, Est_descripcion, Est_Resultado, Est_observacion
                         FROM EstudiosRealizadosRed
                         Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
                                        $rs=mysql_query($query,$conn);
                                             
                            if($row= mysql_fetch_array($rs))
                                   {

                                echo"<table id=\"TablaHeredo\" align=\"center\"  width=\"100%\" class=\"table table-striped table-hover\">
                             <tr>
                             <th width=\"20%\"><b>Estudio</b></th>
                                          <th width=\"15%\"><b>Descripcion</b></th>
                                          <th width=\"15%\"><b>Resultado</b></th>
                                          <th width=\"40%\"><b>Observaciones</b></th>
                                          <th width=\"10%\"><b>Eliminar</b></th>
                                </tr>";

                            do{
                                              echo "  <tr>";
                                             echo "                <td>".utf8_encode($row['Est_estudio'])."</td>";
                                             echo "                <td>".utf8_encode($row['Est_descripcion'])."</td>";
                                             echo "                <td>".utf8_encode($row['Est_Resultado'])."</td>";
                                             echo "                <td>".utf8_encode($row['Est_observacion'])."</td>";
                                             echo "                <td><input type=\"button\" class=\"btn btn-danger btn-xs\" onClick=\"eliminarEstRealizadoRed('".$row['Est_clave']."','".$fol."','".$Not."')\" value='Eliminar'";
                                             echo " </tr>";
                                 }  while($row = mysql_fetch_array($rs));

                                         echo"  </table>";
                                 }


