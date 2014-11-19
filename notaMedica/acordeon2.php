<?php if ($notEstatus>=5 && $notEstatus<13) {?>
<div class="accordion-group">
  <div class="accordion-heading">
    <a class="accordion-toggle" href="#collapseVitales" data-toggle="collapse" data-parent="#accordion2">
      Signos Vitales
    </a>
  </div>
  <div class="accordion-body collapse" id="collapseVitales" style="height: 0px; border:1px solid #d9edf7">
    <div class="accordion-inner" style="background:white">
    <?php
    $query="Select Not_clave, Exp_folio,Not_temperatura, Not_talla, Not_peso, Not_ta, Not_fc, Not_fr, Not_obs_vitales 
    FROM Nota_med_red 
    WHERE Not_clave='".$Not."' and Exp_folio='".$fol."' ";
$rs= mysql_query($query,$conn);
if($row= mysql_fetch_array($rs)){
      do{
$html=" <table class=\"table table-striped table-hover\" cellspacing=\"3\" cellpadding=\"4\">
          <tr>
                <td bgcolor=\"#cccccc\" align=\"center\" colspan=\"6\"><b>Signos vitales</b></td>
          </tr>
    <tr>
               <td align=\"center\"><b>Temperatura<br>(°C)</b></td>
               <td align=\"center\"><b>Talla<br>(Cm)</b></td>
               <td align=\"center\"><b>Peso<br>(Kg)</b></td>
               <td align=\"center\"><b>Presion arterial<br>(mmHg)</b></td>
               <td align=\"center\"><b>Frecuencia cardiaca<br>(Lpm)</b></td>
               <td align=\"center\"><b>Frecuencia respiratoria<br>(Rpm)</b></td>
    </tr>
           <tr>
                      <td align=\"center\">".$row["Not_temperatura"]."</td>
                      <td align=\"center\">".$row["Not_talla"]."</td>
                      <td align=\"center\">".$row["Not_peso"]."</td>
                      <td align=\"center\">".$row["Not_ta"]."</td>
                      <td align=\"center\">".$row["Not_fc"]."</td>
                      <td align=\"center\">".$row["Not_fr"]."</td>
          </tr>
          <tr>
                     <td><b>Observaciones:</b></td>
                     <td colspan=\"5\" align=\"justify\">".utf8_encode($row["Not_obs_vitales"])."</td>
          </tr>

 </table>";

$html1= $html1.$html;
      }while($row = mysql_fetch_array($rs));

      echo $html;
}?>     
    </div>
  </div>
</div>                                                                
<?php
} 
if ($notEstatus>=6 && $notEstatus<13) {?>


<div class="accordion-group">
  <div class="accordion-heading">
    <a class="accordion-toggle" href="#collapseDaccidente" data-toggle="collapse" data-parent="#accordion2">
    Datos del Accidente
    </a>
  </div>
  <div class="accordion-body collapse" id="collapseDaccidente" style="height: 0px; border:1px solid #d9edf7">
    <div class="accordion-inner" style="background:white">
      <?php
        $query="Select  Llega_clave, Not_fechaAcc,  TipoVehiculo_clave, Posicion_clave, Not_vomito, Not_mareo, Not_nauseas, Not_perdioConocimiento, Not_cefalea,Not_obs  FROM Nota_med_red Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs=mysql_query($query,$conn);
$row= mysql_fetch_array($rs);


$LlegaClave     =    $row['Llega_clave'];
$FechaAcc       =    $row['Not_fechaAcc'];
$HoraAcc        =    $row['Not_horaAcc'];
$VehiculoClave  =    $row['TipoVehiculo_clave'];
$PosicionClave  =    $row['Posicion_clave'];
$Mecanismo      =    $row['Not_obs'];
$vomito         =    $row['Not_vomito'];
$mareo          =    $row['Not_mareo'];
$nauseas         =    $row['Not_nauseas'];
$conocimiento   =    $row['Not_perdioConocimiento'];
$cefalea        =    $row['Not_cefalea'];
$Usuario        =    $row['Usu_nombre'];
$fechaNotMedica =    $row['Not_fechareg'];

if($LlegaClave==null)$LlegaClave=-1;
if($VehiculoClave==null)$VehiculoClave=-1;
if($PosicionClave==null)$PosicionClave=-1;
if($vomito=="S"){$vomito="";}else{$vomito="Neg&oacute;: ";}
if($mareo=="S"){$mareo="";}else{$mareo="Neg&oacute;: ";}
if($nauseas=="S"){$nauseas="";}else{$nauseas="Neg&oacute;: ";}
if($conocimiento=="S"){$conocimiento="";}else{$conocimiento="Neg&oacute;: ";}
if($cefalea=="S"){$cefalea="";}else{$cefalea="Neg&oacute;: ";}

$query="Select Llega_nombre From Llega Where Llega_clave=".$LlegaClave;
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);
$LlegaNombre= $row['Llega_nombre'];

$query="Select opcion From TipoVehiculo Where id=".$VehiculoClave;
$rs=mysql_query($query,$conn);
$row=  mysql_fetch_array($rs);
$VehiculoNombre=$row['opcion'];

$query="Select opcion From PosicionAcc Where id=".$PosicionClave;
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);
$PosicionNombre=$row['opcion'];


//////////////DATOS DEL ACCIDENTE//////////

                $query="SELECT  Equi_nombre FROM  Nota_med_red  inner join EquipoSegRed on Nota_med_red.Equi_clave=EquipoSegRed.Equi_clave Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
               $rs=mysql_query($query,$conn);

                if($row= mysql_fetch_array($rs))
                {
                    do
                        {
                            $EquipoSeg="-".$row["Equi_nombre"]."<br/>";


                         $SegArreglo=$SegArreglo.$EquipoSeg;

                        }while($row= mysql_fetch_array($rs));
                }

 $query="SELECT Mec_nombre FROM Nota_med_red INNER JOIN MecLesionRed on Nota_med_red.Mec_clave=MecLesionRed.Mec_clave Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
               $rs=mysql_query($query,$conn);

                if($row= mysql_fetch_array($rs))
                {
                    do
                        {
                            $MecLes="-".$row["Mec_nombre"]."<br/>";


                         $LesArreglo=$LesArreglo.$MecLes;

                        }while($row= mysql_fetch_array($rs));
                }
              

$html="
    <table  class=\"table table-striped table-hover\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
                <th align=\"center\" colspan=\"4\" bgcolor=\"#cccccc\">
                      <b>Datos del accidente</b>
                </th>
           </tr>

            <tr>
                <td colspan=\"2\">
                   <b>El paciente llega: </b>".$LlegaNombre."
                </td>
                <td colspan=\"2\">
                   <b>Fecha y hora:   </b>".$FechaAcc." ".$HoraAcc."
                </td>

           </tr>
           <tr>
               <td colspan=\"2\">
                  <b>Tipo de veh&iacute;culo: </b>".$VehiculoNombre."
               </td>
               <td colspan=\"2\">
                  <b>Posici&oacute;n:  </b>".$PosicionNombre."
               </td>
           </tr>
           <tr>
               <td valign='middle'>
                 <b>Equipo de seguridad: </b>
               </td>
               <td>".$SegArreglo."</td>
               <td valign=\"middle\">
               <b>Descripci&oacute;n del acc.: </b>
               </td>
               <td>".$LesArreglo."</td>
           </tr>
           <tr>
                 <td>
                      <b>Mecanismo de la lesi&oacute;n: </b>
                 </td>
                 <td colspan=\"3\">".$Mecanismo."
                 </td>
           </tr>
           <tr>
                <td colspan=\"4\" bgcolor=\"#cccccc\" align=\"center\">
                   <b>Present&oacute;: </b>
                </td>
          </tr>
          <tr>
                <td>".$vomito."Vomito</td>
                <td>".$mareo."Mareo</td>
                <td>".$nauseas."Nauseas</td>
                <td>".$cefalea."Cefalea</td>
           </tr>
           <tr>
            <td colspan=\"2\">".$conocimiento." Perdida del conocimiento</td>
            
           </tr>
    </table>
      ";
// Print text using writeHTMLCell()
echo $html;
?>     
    </div>
  </div>
</div>                                       


<?php
} 
if ($notEstatus>=7 && $notEstatus<13) {
  if($sexo=="Femenino"){?>
<div class="accordion-group">
  <div class="accordion-heading">
    <a class="accordion-toggle" href="#collapseEmbarazo" data-toggle="collapse" data-parent="#accordion2">
      Embarazo
    </a>
  </div>
  <div class="accordion-body collapse" id="collapseEmbarazo" style="height: 0px; border:1px solid #d9edf7">
    <div class="accordion-inner" style="background:white">
<?php
  $query="SELECT Emb_semGestacion, Emb_dolAbdominal, Emb_descripcion, Emb_movFetales, Emb_fcf, Emb_ginecologia, Emb_obs FROM EmbarazoRed Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
    $rs=mysql_query($query,$conn);
    if($row=mysql_fetch_array($rs)){

$html="
       <table width=\"100%\" class=\"table table-striped table-hover\"  cellspacing=\"3\" cellpadding=\"4\">
    <tr>
        <th align=\"center\" colspan=\"4\" bgcolor=\"#cccccc\">
            <b>Antecedentes Ginecoobst&eacute;tricos </b>
        </th>
    </tr>
    <tr>
        <td><b>Control ginecologico:</b></td><td>".utf8_encode($row['Emb_ginecologia'])."</td>
        <td><b>Semanas de Gestaci&oacute;n:</b></td><td>".utf8_encode($row['Emb_semGestacion'])."</td>
    </tr>
    <tr>
        <td><b>Dolor abdominal:</b></td> <td>".utf8_encode($row['Emb_dolAbdominal'])."</td>
        <td><b>Descripcion:</b></td><td>".utf8_encode($row['Emb_descripcion'])."</td>
    </tr>
    <tr>
         <td><b>Frecuenc&iacute;a cardiaca fetal:</b></td><td>".utf8_encode($row['Emb_fcf'])."</td>
         <td><b>Movimientos fetales:</b></td><td>".utf8_encode($row['Emb_movFetales'])."</td>
        
    </tr>
    <tr>
         <td><b>Observacion:</b></td><td colspan=\"3\">".utf8_encode($row['Emb_obs'])."</td>
    </tr>
    </table>
   ";
    echo $html;
    }
    else{
      echo '<div>- NEGADO -</div>';
    }
  }
  ?>
</div>
</div>
</div>
  <?php
} 
if ($notEstatus>=8 && $notEstatus<13) {?>

<div class="accordion-group">
  <div class="accordion-heading">
    <a class="accordion-toggle" href="#collapsePresento" data-toggle="collapse" data-parent="#accordion2">
      El paciente present&oacute;:
    </a>
  </div>
  <div class="accordion-body collapse" id="collapsePresento" style="height: 0px; border:1px solid #d9edf7">
    <div class="accordion-inner" style="background:white">
     <?php
      $query="SELECT Les_nombre, Cue_nombre, LesN_clave FROM LesionNotaRed inner join LesionRed on LesionRed.Les_clave=LesionNotaRed.Les_clave inner join CuerpoRed on CuerpoRed.Cue_clave=LesionNotaRed.Cue_clave Where Exp_folio='".$_SESSION["FOLIO"]."' and Not_clave=".$Not." ORDER BY LesN_clave ASC";
      $rs=mysql_query($query,$conn);
      if($row=  mysql_fetch_array($rs))
      {
          $html= "<table class=\"table table-striped table-hover\" align=\"center\"  width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
                      <tr>
                          <th align=\"center\"  colspan=\"2\" bgcolor=\"#cccccc\">
                            <b>El paciente presenta:</b>
                          </th>
                      </tr>
                      <tr>
                          <th align=\"left\" width=\"50%\"><b>Lesi&oacute;n</b></th>
                          <th align=\"left\" width=\"50%\"><b>Zona</b></th>                
                      </tr>";
          do{
              $html.= "  <tr>";
              $html.= "      <td align=\"left\">".$row['Les_nombre']."</td>";
              $html.= "      <td align=\"left\">".$row['Cue_nombre']."</td>";        
              $html.= " </tr>";
          }while($row = mysql_fetch_array($rs));
          $html.= "</table>";
          echo $html;
      }else{
        echo "<div> - NEGADO -</div>";
      }
     ?>     
    </div>
  </div>
</div>                                       


<?php
} 
if ($notEstatus>=9 && $notEstatus<13) {?>

<div class="accordion-group">
  <div class="accordion-heading">
    <a class="accordion-toggle" href="#collapseEdoGral" data-toggle="collapse" data-parent="#accordion2">
      Estado General:
    </a>
  </div>
  <div class="accordion-body collapse" id="collapseEdoGral" style="height: 0px; border:1px solid #d9edf7">
    <div class="accordion-inner" style="background:white">
      <?php 
        $query="SELECT Not_edo_general from Nota_med_red         
        where Exp_folio='".$fol."' and Not_clave='".$Not."' ";
        $rs=mysql_query($query,$conn);
        $row=  mysql_fetch_array($rs);

         $html="<table align=\"center\" class=\"table table-striped table-hover\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\">";
          $html.="<tr>
                  <th align=\"center\"  bgcolor=\"#cccccc\">
                        <b>Estado General</b>
                  </th>          
                  </tr>
                  <tr>
                    <td>".$row['Not_edo_general']."</td>
                  </tr>
                </table>";
        echo $html;
      ?>    
    </div>
  </div>
</div>                                       


<?php
} 
?>


