<?php
require "validaUsuario.php";


$query="Select Max(HistAcc_clave)+1 As Cons From HistoriaAccRed where Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs=  mysql_query($query,$conn);
$row=  mysql_fetch_array($rs);
$cons= $row['Cons'];

if($cons==null || $cons=='')$cons=1;


    $query="Insert into HistoriaAccRed(HistAcc_clave,Exp_folio, Acc_estatus, Lug_clave, Acc_obs, Not_clave)
                                 Values('".$cons."','".$fol."','".$Accidente."','".$Lugar."','".$ObsAccidente."','".$Not."');";
    $rs= mysql_query(utf8_decode($query),$conn);



     $query="SELECT HistAcc_clave, Acc_estatus, Lug_nombre, Acc_obs FROM HistoriaAccRed
                           Inner Join LugarRed on HistoriaAccRed.Lug_clave=LugarRed.Lug_clave
                           Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
                       $rs=mysql_query($query,$conn);
                   if($row= mysql_fetch_array($rs))
                         {
                            echo"<table id=\"HistoriaAccRed\" align=\"center\" width=\"100%\" class=\"table table-striped table-hover\">
                                    <tr>
                                         <th width=\"20%\"><b>Accidente</b></th>
                                         <th width=\"15%\"><b>Lugar</b></th>
                                         <th width=\"40%\"><b>Observaciones</b></th>
                                         <th width=\"10%\"><b>Eliminar</b></th>
                                    </tr>";
                              do{
                                   echo "  <tr>";
                                   echo "                <td>".utf8_encode($row['Acc_estatus'])."</td>";
                                   echo "                <td>".utf8_encode($row['Lug_nombre'])."</td>";
                                   echo "                <td>".utf8_encode($row['Acc_obs'])."</td>";
                                   echo "                <td><input type=\"button\" class=\"btn btn-danger btn-xs\" onClick=\"eliminaAccAnt('".$row['HistAcc_clave']."','".$fol."','".$Not."')\" value='Eliminar'";
                                   echo " </tr>";
                                }  while($row = mysql_fetch_array($rs));

                             echo"  </table>";
                            }

      

?>
