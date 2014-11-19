<?
//print_r($_GET);
require "pac_vars.inc";

$sql="DELETE FROM SuministroRed where sumRed_consec=".$cons." and Exp_folio='".$fol."' and Not_clave=".$Not." ";
//echo $sql;
$rs=mysql_query($sql,$conn);

require "list_suministrosRed.php";

?>