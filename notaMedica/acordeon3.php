<?php if ($notEstatus>=10 && $notEstatus<13) {?>
<div class="accordion-group">
  <div class="accordion-heading">
    <a class="accordion-toggle" href="#collapseProcMed" data-toggle="collapse" data-parent="#accordion2">
      Estudios Realizados
    </a>
  </div>
  <div class="accordion-body collapse" id="collapseProcMed" style="height: 0px; border:1px solid #d9edf7">
    <div class="accordion-inner" style="background:white">
      
      
      <?php
          $query="SELECT Est_clave, Est_estudio, Est_descripcion, Est_Resultado, Est_observacion
        FROM EstudiosRealizadosRed
        Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
      $rs=mysql_query($query,$conn);
      if($row= mysql_fetch_array($rs))
          {
          $html="<table id=\"EstudiosRealizadosRed\"  align=\"center\"  width=\"100%\" class=\"table table-striped table-hover\">
          <tr>
              <th align=\"center\" colspan=\"4\"  bgcolor=\"#cccccc\">
                    <b>Estudios Realizados</b>
              </th>
          </tr>
          <tr>
              <th width=\"30%\"><b>Estudio</b></th>
              <th width=\"15%\"><b>Descripcion</b></th>
              <th width=\"15%\"><b>Resultado</b></th>
              <th width=\"40%\"><b>Observaciones</b></th>    
          </tr>";
          do{
              $html.= "  <tr>";
              $html.= "                <td>".utf8_encode($row['Est_estudio'])."</td>";
              $html.= "                <td>".utf8_encode($row['Est_descripcion'])."</td>";
              $html.= "                <td>".utf8_encode($row['Est_Resultado'])."</td>";
              $html.= "                <td>".utf8_encode($row['Est_observacion'])."</td>";       
              $html.= " </tr>";
          }  while($row = mysql_fetch_array($rs));

          $html.="  </table>";
          echo $html;
      }else{
        echo "<div>- NING&Uacute;N ESTUDIO -</div>";
      }
      ?>
    </div>
  </div>
</div>                                                                
<?php
} 
if ($notEstatus>=11 && $notEstatus<13) {?>


<div class="accordion-group">
  <div class="accordion-heading">
    <a class="accordion-toggle" href="#collapseSuministros" data-toggle="collapse" data-parent="#accordion2">
    Procedimientos M&eacute;dicos
    </a>
  </div>
  <div class="accordion-body collapse" id="collapseSuministros" style="height: 0px; border:1px solid #d9edf7">
    <div class="accordion-inner" style="background:white">
      
      <?php 

        $query="SELECT * from ProcesosMedicosRed where Exp_folio='".$fol."' and Not_clave='".$Not."' ";
        $rs=mysql_query($query,$conn);

        if($row=mysql_fetch_array($rs)){
            
        $html="<table align=\"center\" class=\"table table-striped table-hover\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\">";
        $html.="<tr>
                <th align=\"center\" colspan=\"2\"  bgcolor=\"#cccccc\">
                      <b>Procedimientos M&eacute;dicos</b>
                </th>
            </tr>";
        $html.="<tr>";     
                $html.="<th class=\"resultados\">Procedimiento</th>";
                $html.="<th class=\"resultados\">Observaciones</th>";        
        $html.="</tr>";
            do{
                $html.= "<tr>";                
                        $html.="<td>".$row['PM_procedimiento']."</td>";
                        $html.="<td>".$row['PM_obs']."</td>";                        
                $html.="</tr>";        
            }while($row=  mysql_fetch_array($rs));
            
        $html.="</table>";
        echo $html;
        }else{
          echo "- SIN PROCEDIMIENTOS M&Eacute;DICOS";
        }

       ?>

    </div>
  </div>
</div>                                       


<?php
} 
if ($notEstatus>=12 && $notEstatus<13) {?>

<div class="accordion-group">
  <div class="accordion-heading">
    <a class="accordion-toggle" href="#collapsePronostico" data-toggle="collapse" data-parent="#accordion2">
      Suministros
    </a>
  </div>
  <div class="accordion-body collapse" id="collapsePronostico" style="height: 0px; border:1px solid #d9edf7">
    <div class="accordion-inner" style="background:white">      
        <?php 

          $query="SELECT * from SuministroRed 
        Inner JOin TipoSuministroRed on TipoSuministroRed.tipoSR_id=SuministroRed.sumRed_tipo
        where Exp_folio='".$fol."' and Not_clave='".$Not."' ";
        $rs=mysql_query($query,$conn);
        if($row=mysql_fetch_array($rs)){  
          $html="<table align=\"center\" class=\"table table-striped table-hover\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\">";
          $html.="<tr>
                  <th align=\"center\" colspan=\"3\"  bgcolor=\"#cccccc\">
                        <b>Suministros</b>
                  </th>
              </tr>";
          $html.="<tr>";        
                  $html.="<th class=\"resultados\"><b>Tipo</b></th>";
                  $html.="<th class=\"resultados\"><b>Descripci&oacute;n</b></th>";
                  $html.="<th class=\"resultados\"><b>Observaciones</b></th>";       
          $html.="</tr>";
              do{
                  $html.= "<tr>";               
                          $html.="<td>".$row['tipoSR_nombre']."</td>";
                          $html.="<td>".$row['sumRed_desc']."</td>";
                          $html.="<td>".$row['sumRed_obs']."</td>";                
                  $html.="</tr>";        
              }while($row=  mysql_fetch_array($rs));  
          $html.="</table>";
          echo $html;
        }

         ?>
    </div>
  </div>
</div>                                       


<?php
} 
?>


