<?
require "pac_vars.inc";

//**************************************************************
//********************************** Tabla donde imprimimos los PM agregados

$query="SELECT * from ProcesosMedicosRed where Exp_folio='".$fol."' and Not_clave='".$Not."' ";
//echo $query;
$rs=mysql_query($query,$conn);

if($row=mysql_fetch_array($rs)){
    
echo"<table width=\"40%\" class=\"table table-striped table-hover\">";
echo"<tr>";
        echo"<th class=\"resultados\">Clave</th>";
        echo"<th class=\"resultados\">Procedimiento</th>";
        echo"<th class=\"resultados\">Observaciones</th>";
        echo"<th class=\"resultados\">Usuario</th>";
        echo"<th class=\"resultados\">Fecha Registro</th>";
        echo"<th class=\"resultados\">Eliminar</th>";
echo"</tr>";
    do{
        echo "<tr>";
                echo"<td>".$row['PM_consecutivo']."</td>";
                echo"<td>".$row['PM_procedimiento']."</td>";
                echo"<td>".$row['PM_obs']."</td>";
                echo"<td>".$row['Usu_login']."</td>";
                echo"<td>".$row['PM_fecreg']."</td>";
                echo"<td><button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"removeProcMedico('".$row['PM_consecutivo']."','".$row['Exp_folio']."','".$row['Not_clave']."'); \">Eliminar</button></td>";
        echo"</tr>";        
    }while($row=  mysql_fetch_array($rs));
    
echo"</table>";

}

?>