<?

//print_r($_POST);
//require 'validaUsuario.php';
require "pac_vars.inc";

$query="Select Max(PM_consecutivo)+1 as clave From ProcesosMedicosRed Where Exp_folio='".$fol."' and Not_clave=".$Not." ";
$res=mysql_query($query,$conn);
@$row=mysql_fetch_array($res);
$clave=$row['clave'];
if($clave==''||$clave==NULL){$clave=1;}



$sql="INSERT INTO ProcesosMedicosRed (PM_consecutivo,Exp_folio,Not_clave,PM_procedimiento,PM_obs,Usu_login,PM_fecreg) 
	  Values (".$clave.",'".$fol."','".$Not."','".utf8_decode($proc)."','".utf8_decode($obs)."','".$usuario."',now())";
//echo $sql;
$rs=mysql_query($sql,$conn);

require "list_procMedicosRed.php";

?>