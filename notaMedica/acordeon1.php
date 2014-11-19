<?php if ($notEstatus>=2 && $notEstatus<13) {?>
<div class="accordion-group">
  <div class="accordion-heading">
    <a class="accordion-toggle" href="#collapseAntHeredo" data-toggle="collapse" data-parent="#accordion2">
    Antecedentes Heredo-Familiares
    </a>
  </div>
  <div class="accordion-body collapse" id="collapseAntHeredo" style="height: 0px; border:1px solid #d9edf7">
    <div class="accordion-inner" style="background:white">

      <?php
        $query="SELECT FamE_clave, Enf_nombre, Fam_nombre, Est_nombre, FamE_obs 
                FROM FamEnfermedadRed 
                Inner Join Enfermedad on FamEnfermedadRed.Enf_clave=Enfermedad.Enf_clave 
                Inner Join Familia on FamEnfermedadRed.Fam_clave=Familia.Fam_clave 
                Inner Join EstatusFam on FamEnfermedadRed.Est_clave=EstatusFam.Est_clave 
                Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
        $rs=mysql_query($query,$conn);
        if($row=mysql_fetch_array($rs)){
        $html="<table   align=\"center\" class=\"table table-striped table-hover\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\">
        <tr>
                <th align=\"center\" colspan=\"4\" bgcolor=\"#cccccc\">
                    <b>Antecedentes Heredo Familiares</b>
                </th>
            </tr>
          <tr>
               <td width=\"20%\"><b>Enfermedad</b></td>
               <td width=\"15%\"><b>Familiar</b></td>
               <td width=\"15%\"><b>Estatus</b></td>
               <td width=\"40%\"><b>Observaciones</b></td>       
          </tr>";

        do{
          $html.= "  <tr>";
          $html.="                <td>".utf8_encode($row['Enf_nombre'])."</td>";
          $html.="                <td>".utf8_encode($row['Fam_nombre'])."</td>";
          $html.="                <td>".utf8_encode($row['Est_nombre'])."</td>";
          $html.="                <td>".utf8_encode($row['FamE_obs'])."</td>";          
          $html.=" </tr>";
          }  while($row = mysql_fetch_array($rs));

          $html.="  </table>"; 
          echo $html; 
          }
          else{
            echo "<div>- NEGADO -</div>";
          }
  ?>
    </div>
  </div>
</div>                                                                
<?php
} 
if ($notEstatus>=3 && $notEstatus<13) {?>


<div class="accordion-group">
  <div class="accordion-heading">
    <a class="accordion-toggle" href="#collapseAntPersonales" data-toggle="collapse" data-parent="#accordion2">
    Antecedentes Personales
    </a>
  </div>
  <div class="accordion-body collapse" id="collapseAntPersonales" style="height: 0px; border:1px solid #d9edf7">
    <div class="accordion-inner" style="background:white">
<?php
    ////////////    cronicos Degenerativos   ///////////
$query="SELECT Hist_clave, Pad_nombre, Pad_obs 
           FROM HistoriaPadecimientoRed 
           Inner Join Padecimientos on HistoriaPadecimientoRed.Pad_clave=Padecimientos.Pad_clave 
           Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
    $rs=mysql_query($query,$conn);
    
if($row=mysql_fetch_array($rs)){

 $html="<table width=\"100%\" cellspacing=\"3\" class=\"table table-striped table-hover\" cellpadding=\"4\" >
<tr>
<th colspan=\"2\">
          <b>Cr&oacute;nicos Degenerativos</b>
</th>
</tr>";
  do{
  $html.= "  <tr>";
  $html.= "                <td>".utf8_encode($row['Pad_nombre'])."</td>";
  $html.= "                <td>".utf8_encode($row['Pad_obs'])."</td>";
  $html.= " </tr>";
  }while($row = mysql_fetch_array($rs));
  
  $html.= "</table>";
echo $html;
}else{
  $html="<table  class=\"table table-striped table-hover\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
      <tr>
      <th>
                <b>Cr&oacute;nicos Degenerativos</b> - Negado -
      </th>
      </tr></table>"; 
  echo $html;
}
////////////   fin cronicos Degenerativos   ///////////

////////////    Otras enfermedades   ///////////
 $query="SELECT HistOt_clave, Otr_nombre, HistOt_obs 
     FROM HistoriaOtrasRed 
     Inner Join Otras on HistoriaOtrasRed.Otr_clave=Otras.Otr_clave 
     Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
 $rs=mysql_query($query,$conn);

if($row=mysql_fetch_array($rs)){

$html="<table class=\"table table-striped table-hover\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
<tr>
<th colspan=\"2\">
          <b>Otras Enfermedades</b>
</th>
</tr> ";     

 do{
     $html.= "  <tr>";
     $html.= "  <td>".utf8_encode($row['Otr_nombre'])."</td>";
     $html.= "  <td>".utf8_encode($row['HistOt_obs'])."</td>";    
     $html.= " </tr>";
     }while($row = mysql_fetch_array($rs));
     $html.="</table>";
     echo $html;
 }else{
  $html="<table  class=\"table table-striped table-hover\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
      <tr>
      <th>
                <b>Otras Enfermedades</b> - Negado -
      </th>
      </tr></table>";
  echo $html;
}

////////////   fin Otras enfermedades   ///////////

////////////    ALERGIAS                ///////////

$query="SELECT HistA_clave, Ale_nombre, Ale_obs 
       FROM HistoriaAlergiasRed 
       Inner Join Alergias on HistoriaAlergiasRed.Ale_clave=Alergias.Ale_clave 
       Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
       $rs=mysql_query($query,$conn);
 
       if($row=  mysql_fetch_array($rs)){
          $html="<table  class=\"table table-striped table-hover\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
                    <tr>
                      <th colspan=\"2\">
                        <b>Alergias</b>
                      </th>
                    </tr>";
                     
          do{
              $html.= "<tr>";
              $html.= "<td>".utf8_encode($row['Ale_nombre'])."</td>";
              $html.= "<td>".utf8_encode($row['Ale_obs'])."</td>";             
              $html.= " </tr>";
          }while($row = mysql_fetch_array($rs));
              $html.="</table>";
              echo $html;
      }else{
  $html="<table  class=\"table table-striped table-hover\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
      <tr>
      <th>
                <b>Alergias</b> - Negado -
      </th>
      </tr></table>";
  echo $html;
  }

////////////          FIN ALERGIAS     ////////////         

////////////        PADECIMIENTOS ESPALDA /////////

$query="SELECT HistE_clave, Esp_estatus, Esp_obs 
       FROM HistoriaEspaldaRed 
       Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs=mysql_query($query,$conn);
if($row=  mysql_fetch_array($rs)){ 
$html="<table class=\"table table-striped table-hover\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
<tr>
      <th>
            <b>Padecimientos Espalda</b>
      </th>
</tr>";
    do{ 
       $html.= "<tr>";
                $html.= "<td>".utf8_encode($row['Esp_obs'])."</td>";              
       $html.= "</tr>";
      }while($row = mysql_fetch_array($rs)); 
$html.=" </table>";
echo $html;
}else{
$html="<table  class=\"table table-striped table-hover\"  width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
    <tr>
    <th>
              <b>Padecimientos Espalda</b> - Negado -
    </th>
    </tr></table>";
echo $html;
}

////////////     FIN PADECIMIENTOS ESPALDA  ///////

////////////      TRATAMIENTO QUIROPRACTICO ///////

$query="SELECT HistoriaQ_clave, Quiro_estatus, Quiro_obs 
        FROM HistoriaQuiroRed 
        Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
  $rs=mysql_query($query,$conn);

  if($row=  mysql_fetch_array($rs)){
  $html="<table  class=\"table table-striped table-hover\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\">
  <tr>
          <th>
            <b>Tratamiento quiropr&aacute;ctico</b>
          </th>
  </tr>";
  do{
      $html.= "<tr>";
      $html.= "                <td>".utf8_encode($row['Quiro_obs'])."</td>";      
      $html.= " </tr>";
   }while($row = mysql_fetch_array($rs));
  $html.="</table>";
  echo $html;
}else{
$html="<table  class=\"table table-striped table-hover\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
    <tr>
    <th>
              <b>Tratamiento quiropr&aacute;ctico</b> - Negado -
    </th>
    </tr></table>";
echo $html;
}

///////////   FIN TRATAMIENTO QUIROPARACTICO //////

///////////       USO DE PLANTILLAS          //////

$query="SELECT HistP_clave, Plantillas_estatus, Plantillas_obs 
         FROM HistoriaPlantillasRed 
         Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs=mysql_query($query,$conn);
if($row=  mysql_fetch_array($rs)){ 
    $html="<table class=\"table table-striped table-hover\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\">
                <tr>
                 <th>
                  <b>Uso de Plantillas</b>
                  </th>
                </tr>";
    do{ 
       $html.= "<tr>";
                $html.= "<td>".utf8_encode($row['Plantillas_obs'])."</td>";                
       $html.= "</tr>";
      }while($row = mysql_fetch_array($rs)); 
$html.=" </table>";
echo $html;
}else{
$html="<table  class=\"table table-striped table-hover\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
    <tr>
    <th>
              <b>Uso de Plantillas</b> - Negado -
    </th>
    </tr></table>";
echo $html;
}

///////////      FIN USO DE PLANTILLAS       //////

///////////         TRATAMIENTOS             //////

$query="SELECT HistT_clave, HistT_estatus, HistT_obs 
       FROM HistoriaTratRed 
       Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs=mysql_query($query,$conn);
if($row=  mysql_fetch_array($rs)){ 
    $html="<table class=\"table table-striped table-hover\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\">
        <tr>
          <th>
                  <b>Tratamientos</b>
                  </th>
        </tr>";
    do{ 
       $html.= "<tr>";
                $html.= "<td>".utf8_encode($row['HistT_obs'])."</td>";                
       $html.= "</tr>";
      }while($row = mysql_fetch_array($rs)); 
$html.=" </table>";
echo $html;
}else{
$html="<table  class=\"table table-striped table-hover\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
    <tr>
    <th>
              <b>Tratamientos</b> - Negado -
    </th>
    </tr></table>";
echo $html;
}

///////////        FIN TRATAMIENTOS          //////

///////////      INTERVENCIONES              //////

$query="SELECT HistO_clave, HistO_estatus, HistO_obs 
       FROM HistoriaOperacionRed 
       Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs=mysql_query($query,$conn);
if($row=  mysql_fetch_array($rs)){ 
$html="<table  width=\"100%\" class=\"table table-striped table-hover\" cellspacing=\"3\" cellpadding=\"4\">
     <tr>
          <th>
                  <b>Intervenciones</b>
                  </th>
      </tr>";

    do{ 
       $html.= "<tr>";
                $html.= "<td>".utf8_encode($row['HistO_obs'])."</td>";               
       $html.= "</tr>";
      }while($row = mysql_fetch_array($rs)); 
$html.=" </table>";
echo $html;
}
else{
$html="<table  class=\"table table-striped table-hover\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
    <tr>
    <th>
              <b>Intervenciones</b> - Negado -
    </th>
    </tr></table>";
echo $html;
}                    

///////////          FIN DE INTERVENCIONES   //////

///////////             DEPORTES             //////

$query="SELECT HistD_clave, Dep_estatus, Dep_obs 
        FROM HistoriaDeporteRed 
        Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs=mysql_query($query,$conn);
if($row=  mysql_fetch_array($rs)){ 
    $html="<table  width=\"100%\" class=\"table table-striped table-hover\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
            <th>
                <b>Deportes</b>
            </th>
            </tr>";
    do{ 
      $html.= "<tr>";
      $html.= "<td>".utf8_encode($row['Dep_obs'])."</td>";      
      $html.= "</tr>";
    }while($row = mysql_fetch_array($rs)); 
    $html.=" </table>";
    echo $html;
}else{
$html="<table  class=\"table table-striped table-hover\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
    <tr>
    <th>
              <b>Deportes</b> - Negado -
    </th>
    </tr></table>";
echo $html;
}      

///////////          FIN DEPORTES           ///////

///////////            ADICCIONES          //////

$query="SELECT HistA_clave, Adic_estatus, Adic_obs 
        FROM HistoriaAdiccionRed 
        Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs=mysql_query($query,$conn);
if($row=  mysql_fetch_array($rs)){ 
    $html="<table width=\"100%\" class=\"table table-striped table-hover\" cellspacing=\"3\" cellpadding=\"4\">
          <tr>
            <th>
                <b>Adicciones</b>
            </th>
          </tr>";
    do{ 
        $html.= "<tr>";
          $html.= "<td>".utf8_encode($row['Adic_obs'])."</td>";        
        $html.= "</tr>";
    }while($row = mysql_fetch_array($rs)); 
    $html.=" </table>";
    echo $html;
}else{
$html="<table  class=\"table table-striped table-hover\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
    <tr>
    <th>
              <b>Adicciones</b> - Negado -
    </th>
    </tr></table>";
echo $html;
}           

?>
    </div>
  </div>
</div>                                       


<?php
} 
if ($notEstatus>=4 && $notEstatus<13) {?>

<div class="accordion-group">
  <div class="accordion-heading">
    <a class="accordion-toggle" href="#collapseAccAnt" data-toggle="collapse" data-parent="#accordion2">
      Accidentes Anteriores
    </a>
  </div>
  <div class="accordion-body collapse" id="collapseAccAnt" style="height: 0px; border:1px solid #d9edf7">
    <div class="accordion-inner" style="background:white">
         
      <?php
        $query="SELECT HistAcc_clave, Acc_estatus, Lug_nombre, Acc_obs FROM HistoriaAccRed
                           Inner Join LugarRed on HistoriaAccRed.Lug_clave=LugarRed.Lug_clave
                           Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
                      
                       $rs=mysql_query($query,$conn);
                        if($row= mysql_fetch_array($rs))
                         {
                            $html="<table id=\"HistoriaAccRed\" class=\"table table-striped table-hover\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\">
                                    <tr>
                                      <th align=\"center\" colspan=\"3\" bgcolor=\"#cccccc\">
                                          <b>Accidentes Anteriores</b>
                                      </th>
                                    </tr>
                                    <tr>
                                         <td width=\"30%\"><b>Accidente</b></td>
                                         <td width=\"25%\"><b>Lugar</b></td>
                                         <td width=\"45%\"><b>Observaciones</b></td>
                                         
                                    </tr>";
                              do{
                                   $html.= "  <tr>";
                                   $html.= "                <td>".$row['Acc_estatus']."</td>";
                                   $html.= "                <td>".$row['Lug_nombre']."</td>";
                                   $html.= "                <td>".$row['Acc_obs']."</td>";                                   
                                   $html.= " </tr>";
                                }  while($row = mysql_fetch_array($rs));

                              $html.="  </table>";                            
                              echo $html;
                          }else{
                            echo "<div>- NEGADO -</div>";
                          }

      ?>                          

    </div>
  </div>
</div>                                       


<?php
} 
?>