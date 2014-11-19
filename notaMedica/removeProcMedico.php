<?
//print_r($_GET);
require "pac_vars.inc";

$sql="DELETE FROM ProcesosMedicosRed where PM_consecutivo=".$cons." and Exp_folio='".$fol."' and Not_clave=".$Not." ";
//echo $sql;
$rs=mysql_query($sql,$conn);

require "list_procMedicosRed.php";

?>