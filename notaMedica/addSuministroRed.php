<?

//print_r($_POST);
//require 'validaUsuario.php';
require "pac_vars.inc";

$query="Select Max(sumRed_consec)+1 as clave From SuministroRed Where Exp_folio='".$fol."' and Not_clave=".$Not." ";
$res=mysql_query($query,$conn);
$row=mysql_fetch_array($res);
$clave=$row['clave'];
if($clave==''||$clave==NULL){$clave=1;}



$sql="INSERT INTO SuministroRed (sumRed_consec,sumRed_tipo,Exp_folio,Not_clave,sumRed_desc,sumRed_obs,Usu_login,sumRed_fecreg) 
	  Values (".$clave.",".$tipoSumin.",'".$fol."',".$Not.",'".$desc."','".$obs."','".$usuario."',now())";
//echo $sql;
$rs=mysql_query(utf8_decode($sql),$conn);

require "list_suministrosRed.php";

?>