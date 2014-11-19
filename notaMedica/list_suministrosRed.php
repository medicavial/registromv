<?
require "pac_vars.inc";

//**************************************************************
//********************************** Tabla donde imprimimos los PM agregados

$query="SELECT * from SuministroRed 
        Inner JOin TipoSuministroRed on TipoSuministroRed.tipoSR_id=SuministroRed.sumRed_tipo
        where Exp_folio='".$fol."' and Not_clave='".$Not."' ";
//echo $query;
$rs=mysql_query($query,$conn);
if($row=mysql_fetch_array($rs)){
    
echo"<table width=\"40%\" class=\"table table-striped table-hover\">";
echo"<tr>";
        echo"<th class=\"resultados\">Clave</th>";
        echo"<th class=\"resultados\">Tipo</th>";
        echo"<th class=\"resultados\">Descripci&oacute;n</th>";
        echo"<th class=\"resultados\">Observaciones</th>";
        echo"<th class=\"resultados\">Usuario</th>";
        echo"<th class=\"resultados\">Fecha Registro</th>";
        echo"<th class=\"resultados\">Eliminar</th>";
echo"</tr>";
    do{
        echo "<tr>";
                echo"<td>".$row['sumRed_consec']."</td>";
                echo"<td>".$row['tipoSR_nombre']."</td>";
                echo"<td>".utf8_encode($row['sumRed_desc'])."</td>";
                echo"<td>".utf8_encode($row['sumRed_obs'])."</td>";
                echo"<td>".$row['Usu_login']."</td>";
                echo"<td>".$row['sumRed_fecreg']."</td>";
                echo"<td><button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"removeSuministroRed('".$row['sumRed_consec']."','".$row['Exp_folio']."','".$row['Not_clave']."'); \">Eliminar</button></td>";
        echo"</tr>";        
    }while($row=  mysql_fetch_array($rs));
    
echo"</table>";

}
?>