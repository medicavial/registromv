<?
require 'validaUsuario.php';

$consulta = "SELECT Not_clave FROM Nota_med_red WHERE Exp_folio = '". $fol."'   ";
$rs  = mysql_query($consulta, $conn);
$row =  mysql_fetch_array($rs);


  $n=count($Seguridad);
  $m=count($Mecanismo);
    for($i=0; $i<$n; $i++)
    {
$query = "UPDATE `medica_registromv`.`Nota_med_red` SET `Llega_clave` = '".$llega."', `Not_fechaAcc` = '".$FechaAcc."', `TipoVehiculo_clave` = '".$vehiculo."', `Posicion_clave` = '".$posicion."', `Equi_clave` = '".$Seguridad[$i]."', `Mec_clave` = '".$Mecanismo[$i]."', `Not_vomito` = '".$Vomito."', `Not_mareo` = '".$Mareo."', `Not_nauseas` = '".$Nauseas."', `Not_perdioConocimiento` = '".$Conocimiento."', `Not_cefalea` = '".$Cefalea."', `Not_obs` = '".$mecanismo."' WHERE `Nota_med_red`.`Not_clave` = '".$Not."' AND `Nota_med_red`.`Exp_folio` = '".$fol."';";

        $rs=mysql_query($query,$conn);



            }
    $query="SELECT Exp_sexo FROM Expediente WHERE Exp_cancelado=0 and Exp_folio='".$fol."'";
$rs= mysql_query($query,$conn);
$row=  mysql_fetch_array($rs);

$Sexo  =$row['Exp_sexo'];

    if ($Sexo =='F') {

					$sql = "UPDATE Nota_med_red SET Not_Estatus = '6' WHERE Not_clave = '".$Not."' AND Exp_folio = '".$fol."';";
					$rs = mysql_query($sql, $conn);

					header("Location:NotaMedicaRedLlenado.php?fol=".$fol."&Not=".$Not."");
    }
    else
    {
    				$sql = "UPDATE Nota_med_red SET Not_Estatus = '7' WHERE Not_clave = '".$Not."' AND Exp_folio = '".$fol."';";
					$rs = mysql_query($sql, $conn);

					header("Location:NotaMedicaRedLlenado.php?fol=".$fol."&Not=".$Not."");
    }




?>