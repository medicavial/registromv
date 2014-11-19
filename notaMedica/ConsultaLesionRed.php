<?php
    $query="SELECT Les_nombre, Cue_nombre, LesN_clave FROM LesionNotaRed inner join LesionRed on LesionRed.Les_clave=LesionNotaRed.Les_clave inner join CuerpoRed on CuerpoRed.Cue_clave=LesionNotaRed.Cue_clave Where Exp_folio='".$_SESSION["FOLIO"]."' and Not_clave=".$Not." ORDER BY LesN_clave ASC";

    $rs=mysql_query($query,$conn);
if($row=  mysql_fetch_array($rs))
   {
    


 echo "<table id=\"TablaPadCron\" name=\"TablaPadCron\" align=\"center\"  width=\"100%\" class=\"table table-striped table-hover\" >
        <tr>
       <th width=\"45%\"><b>Lesi&oacute;n</b></th>
       <th width=\"45%\"><b>Zona</b></th>
        <th width=\"10%\"><b>Eliminar</b></th>
  </tr>";

 
  do{
  echo "  <tr>";
  echo "                <td>".utf8_encode($row['Les_nombre'])."</td>";
  echo "                <td>".utf8_encode($row['Cue_nombre'])."</td>";
  echo "                <td><input type='button' class='btn btn-danger btn-xs' onClick='eliminarLesRed(".$row['LesN_clave'].",".$Not.")' value='Eliminar'";
  echo " </tr>";
  }while($row = mysql_fetch_array($rs));

  echo"</table>";
}
  ?>
  
