<?php
require "pac_vars.inc";//con
require 'tcpdf.php';
require 'config/lang/eng.php';

////////Correo por mas de 5 suministros Symio
$nosuministros="SELECT SUM(Nsum_cantidad) as numero, ObsNot_diagnosticoRx as dx, concat(Med_Nombre,' ',Med_paterno,' ',Med_materno) as medico, concat(Exp_nombre,' ',Exp_paterno,' ',Exp_materno) as lesionado, Not_fechareg as fecha, Uni_nombrecorto as unidad
FROM SymioNotaSuministro
INNER JOIN ObsNotaMed ON ObsNotaMed.Exp_folio=SymioNotaSuministro.Exp_folio
INNER JOIN NotaMedica ON NotaMedica.Exp_folio=SymioNotaSuministro.Exp_folio
INNER JOIN Medico ON Medico.Usu_login=NotaMedica.Usu_nombre
INNER JOIN Expediente ON Expediente.Exp_folio=SymioNotaSuministro.Exp_folio
INNER JOIN Unidad ON Unidad.Uni_clave=Expediente.Uni_clave
WHERE SymioNotaSuministro.Exp_folio = '".$fol."'";
$rssuministros=mysql_query($nosuministros,$conn);
$rowsuministros= mysql_fetch_array($rssuministros);
$numsuministros=$rowsuministros['numero'];
$dxsuministros=$rowsuministros['dx'];
$medicosuministros=$rowsuministros['medico'];
$lesionadosuministros=$rowsuministros['lesionado'];
$fechasuministros=$rowsuministros['fecha'];
$unidadsuministros=$rowsuministros['unidad'];

$desglose="SELECT Nsum_Cantidad, Nombre_producto, SymioProducto.Clave_producto
FROM SymioNotaSuministro
 INNER JOIN SymioProducto ON SymioProducto.Clave_producto=SymioNotaSuministro.Sum_clave
WHERE Exp_folio = '".$fol."'";
$rsdesglose=mysql_query($desglose,$conn);
$cadenadesglose="";
$nveces=0;
$contador=0;
while($rowdesglose= mysql_fetch_array($rsdesglose)){
        $desglosecantidad=$rowdesglose['Nsum_Cantidad'];
        $desgloseproducto=$rowdesglose['Nombre_producto'];
        $desgloseclave=$rowdesglose['Clave_producto'];

        $cadenadesglose .= $desglosecantidad."\t"."-"."\t".$desgloseproducto.'<br>';

        $qryproh="Select Par_datos From Parametros Where Par_descripcion='MedicamentosRestringidos'";
        $rsproh=mysql_query($qryproh,$conn);
        $rowproh=mysql_fetch_array($rsproh);
        $palabras=$rowproh['Par_datos'];
        $arreglo=explode(',', $palabras);
        for($j=0;$j<count($arreglo);$j++){
        //echo $arreglo[$j];
        $nveces=substr_count($desgloseclave,$arreglo[$j]);
            if($nveces>0){
                $contador=$contador+$nveces;
                $medicamentocontrolado.= $desglosecantidad."\t"."-"."\t".$desgloseproducto.'<br>';
            }
        }
}
/*if($contador>0){

    $myemail="jcaballero@medicavial.com.mx";
    $headers= "From: logistica_NoReply@medicavial.com.mx"."\r \n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $subj = "Medicamentos Controlados";
    $mensaje = "El folio ".'<b>'.$fol.'</b>'." tiene ".'<b>'.$contador.'</b>'." medicamentos controlados.".'<br><br>';
    $mensaje .= '<b>'."Unidad:".'</b>'.$unidadsuministros.'<br>';
    $mensaje .= '<b>'."Lesionado:".'</b>'.$lesionadosuministros.'<br>';
    $mensaje .= '<b>'."Dx:".'</b>'.$dxsuministros.'<br>';
    $mensaje .= '<b>'."Fecha de Atenci&oacute;n:".'</b>'.$fechasuministros.'<br>';
    $mensaje .= '<b>'."M&eacute;dico:".'</b>'.$medicosuministros.'<br><br>';
    $mensaje .= '<b>'."Desglose de Medicamentos Controlados".'</b>'.'<br>';
    $mensaje .= $medicamentocontrolado;
    $mailsend=mail("$myemail","$subj","$mensaje","$headers");
    unset($_GET['do']);

}


if($numsuministros>5){

    $myemail="jcaballero@medicavial.com.mx";
    $headers= "From: logistica_NoReply@medicavial.com.mx"."\r \n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $subj = "Suministros Excedidos";
    $mensaje = "El folio ".'<b>'.$fol.'</b>'." tiene ".'<b>'.$numsuministros.'</b>'." suministros.".'<br><br>';
    $mensaje .= '<b>'."Unidad:".'</b>'.$unidadsuministros.'<br>';
    $mensaje .= '<b>'."Lesionado:".'</b>'.$lesionadosuministros.'<br>';
    $mensaje .= '<b>'."Dx:".'</b>'.$dxsuministros.'<br>';
    $mensaje .= '<b>'."Fecha de Atenci&oacute;n:".'</b>'.$fechasuministros.'<br>';
    $mensaje .= '<b>'."M&eacute;dico:".'</b>'.$medicosuministros.'<br><br>';
    $mensaje .= '<b>'."Desglose de Suministros".'</b>'.'<br>';
    $mensaje .= $cadenadesglose;
    $mailsend=mail("$myemail","$subj","$mensaje","$headers");
    unset($_GET['do']);

}

*/


////////


////////// Datos del Expediente/////

$query="Select Exp_nombre, Exp_paterno, Exp_materno, Exp_fechaNac, Exp_edad, Exp_meses, Exp_sexo, Rel_clave, Ocu_clave, Edo_clave, Exp_mail, Exp_telefono, Cia_clave From Expediente Where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
$row= mysql_fetch_array($rs);

$Nombre      =$row['Exp_nombre'];
$Paterno     =$row['Exp_paterno'];
$Materno     =$row['Exp_materno'];
$FechaNac    =$row['Exp_fechaNac'];
$Edad        =$row['Exp_edad'];
$Meses       =$row['Exp_meses'];
$Sexo        =$row['Exp_sexo'];
$Religion    =$row['Rel_clave'];
$Ocupacion   =$row['Ocu_clave'];
$EdoCivil    =$row['Edo_clave'];
$Mail        =$row['Exp_mail'];
$Telefono    =$row['Exp_telefono'];
$CiaClave    =$row['Cia_clave'];

$NombreCompleto= $Nombre." ".$Paterno." ".$Materno;

if($Sexo=="M")$Sexo="Masculino";
if($Sexo=="F")$Sexo="Femenino";
//if($Religion==null)$Religion=-1;
if($Ocupacion==null)$Ocupacion=-1;
if($EdoCivil==null)$EdoCivil=-1;


$query="Select Ocu_nombre From Ocupacion Where Ocu_clave=".$Ocupacion;
$rs=mysql_query($query,$conn);
$row= mysql_fetch_array($rs);
$Ocupacion     = $row['Ocu_nombre'];

$query="Select Edo_nombre From EdoCivil Where Edo_clave=".$EdoCivil;
$rs= mysql_query($query,$conn);
$row= mysql_fetch_array($rs);
$EdoCivil     =$row['Edo_nombre'];

$query="Select Con_motivo From Consulta Where Exp_folio='".$fol."'";
$rs= mysql_query($query,$conn);
$row= mysql_fetch_array($rs);

$Motivo               =$row['Con_motivo'];


//Datos del Accidente

$query="Select Not_clave, Llega_clave, Not_fechaAcc, Not_horaAcc, TipoVehiculo_clave, Posicion_clave, Not_obs, Usu_nombre, Not_fechareg, Not_vomito, Not_mareo, Not_nauseas, Not_perdioConocimiento, Not_cefalea, Usu_nombre, Not_fechareg FROM NotaMedica Where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
$row= mysql_fetch_array($rs);

$NotaClave      =    $row['Not_clave'];
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
if($vomito=="S"){$vomito="";}else{$vomito="Negó: ";}
if($mareo=="S"){$mareo="";}else{$mareo="Negó: ";}
if($nauseas=="S"){$nauseas="";}else{$nauseas="Negó: ";}
if($conocimiento=="S"){$conocimiento="";}else{$conocimiento="Negó: ";}
if($cefalea=="S"){$cefalea="";}else{$cefalea="Negó: ";}

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



          ////////////////////////////////////////////////////////////////////////////////////////////
          ////////////          PDF Con tcpdf                                               //////////
          ////////////                                                                     ///////////
          ////////////////////////////////////////////////////////////////////////////////////////////

          // Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		// Logo
            global $fechaNotMedica;
            global $fol;
    $style = array(
                'position' => '',
                'align' => 'C',
                'stretch' => false,
                'fitwidth' => true,
                'cellfitalign' => '',
                'border' => TRUE,
                'hpadding' => 'auto',
                'vpadding' => 'auto',
                'fgcolor' => array(0,0,0),
                'bgcolor' => false, //array(255,255,255),
                'text' => true,
                'font' => 'helvetica',
                'fontsize' => 8,
                'stretchtext' => 4
               );          
    $this->write1DBarcode($fol, 'C39', '87', '10', '', 10, 0.2, $style, 'C');
		$image_file = '../../imgs/logos/mv.jpg';
		$this->Image($image_file, 10, 10, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                /*$image_file = K_PATH_IMAGES.$fol.'.png';
		$this->Image($image_file, 90, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    */
		// Set font
		$this->SetFont('helvetica', 'B', 14);
		// Title
                $this->Cell(0, 15, 'Nota Médica', 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                $this->SetFont('helvetica', 'B', 10);
                 $this->Cell(0, 15, 'Folio Asignado:'.$fol, 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                 $this->SetFont('helvetica', 'B', 8);
                 $this->Cell(0, 15,"Fecha:".$fechaNotMedica, 0, false, 'R', 0, '', 0, false, 'M', 'M');
           	}
	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-20);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number

                  //  $this->Cell($w, $h, "_____________________________", $border, $ln=1, 'C');
                    //$this->Cell($w, $h, "Nombre y Firma del Paciente", $border, $ln, 'C');
                    //$this->Ln(2);
                    $this->Cell($w, $h, 'Pagina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), $border, $ln=1, 'C');
                   
                }
	      
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM+10);
//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//set some language-dependent strings
$pdf->setLanguageArray($l);
// set default font subsetting mode
$pdf->setFontSubsetting(true);
// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 8, '', true);
// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();
$pdf->SetFont('dejavusans', '', 6, '', true);
$pdf->Cell($w, $h, $txt="Usuario: ".$Usuario, $border, $ln=1, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->SetFont('dejavusans', '', 8, '', true);
////////////////////// Datos del paciente///
$html = "
    
<table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
    <tr>
        <th align=\"center\" colspan=\"6\" bgcolor=\"#cccccc\">
            <b>Datos del paciente</b>
        </th>
    </tr>
    <tr>
         <td colspan=\"3\">
             <b>Nombre:</b>  ".utf8_encode($NombreCompleto)."
         </td>
         <td>
           <b>Edad:</b>  ".$Edad." años
         </td>
         <td colspan=\"2\">
             <b>Sexo:</b>  ".$Sexo."
         </td>
    </tr>
    <tr>
      <td colspan=\"2\">
             <b>Tipo de trabajo:</b>  ".utf8_encode($Ocupacion)."
      </td>
      <td colspan=\"2\">
          <b>Estado civil:</b>  ".utf8_encode($EdoCivil)."
      </td>
      <td colspan=\"2\">
           <b>Obs. Religión:</b>  ".utf8_encode($Religion)."
      </td>
   </tr>
   <tr>
      <td colspan=\"2\">
          <b>Fecha de nacimiento:</b>  ".$FechaNac."
      </td>
      <td colspan=\"2\">
          <b>Tel. Domicilio:</b>  ".$Telefono."
      </td>
      <td colspan=\"\">
           <b>E-Mail:</b>  ".utf8_encode($Mail)."
      </td>
   </tr>
</table>
";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";

    $query="SELECT Emb_semGestacion, Emb_dolAbdominal, Emb_descripcion, Emb_movFetales, Emb_fcf, Emb_ginecologia, Emb_obs FROM Embarazo Where Exp_folio='".$fol."'";
    $rs=mysql_query($query,$conn);
    if($row=mysql_fetch_array($rs)){

$html="
       <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
    <tr>
        <th align=\"center\" colspan=\"4\" bgcolor=\"#cccccc\">
            <b>Antecedentes Ginecoobstétricos </b>
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
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";
    }
/////Signos vitales
    if($vit){
        $query="Select Vit_temperatura, Vit_talla, Vit_peso, Vit_ta, Vit_fc, Vit_fr , Vit_imc , Vit_observaciones, Vit_fecha, Usu_registro, IMC_categoria, IMC_comentario From Vitales  Inner Join IMC on IMC.IMC_clave=Vitales.IMC_clave  Where Exp_folio='".$fol."' and Vit_clave=".$vit;
    }else{
        $query="Select Vit_temperatura, Vit_talla, Vit_peso, Vit_ta, Vit_fc, Vit_fr , Vit_imc , Vit_observaciones, Vit_fecha, Usu_registro, IMC_categoria, IMC_comentario From Vitales  Inner Join IMC on IMC.IMC_clave=Vitales.IMC_clave  Where Exp_folio='".$fol."'";
    }    
$rs= mysql_query($query,$conn);
if($row= mysql_fetch_array($rs)){
      do{
$html=" <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
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
                      <td align=\"center\">".$row["Vit_temperatura"]."</td>
                      <td align=\"center\">".$row["Vit_talla"]."</td>
                      <td align=\"center\">".$row["Vit_peso"]."</td>
                      <td align=\"center\">".$row["Vit_ta"]."</td>
                      <td align=\"center\">".$row["Vit_fc"]."</td>
                      <td align=\"center\">".$row["Vit_fr"]."</td>
          </tr>
          <tr>
                     <td><b>Observaciones:</b></td>
                     <td colspan=\"5\" align=\"justify\">".utf8_encode($row["Vit_observaciones"])."</td>
          </tr>

 </table>";

$html1= $html1.$html;
      }while($row = mysql_fetch_array($rs));

      $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html1, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
      $html1="";
}

/////// Datod del accidente
 $query="SELECT Exp_folio, Not_clave, Equi_nombre FROM  SegNotaMed  inner join EquipoSeg on EquipoSeg.Equi_clave=SegNotaMed.Equi_clave Where Exp_folio='".$fol."'";
               $rs=mysql_query($query,$conn);

                if($row= mysql_fetch_array($rs))
                {
                    do
                        {
                            $EquipoSeg="-".$row["Equi_nombre"]."<br/>";


                         $SegArreglo=$SegArreglo.$EquipoSeg;

                        }while($row= mysql_fetch_array($rs));
                }

 $query="SELECT Exp_folio, Not_clave, Mec_nombre FROM  MecNotaMed  inner join MecLesion on MecLesion.MEC_clave=MecNotaMed.Mec_clave Where Exp_folio='".$fol."'";
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
    <table  border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
                <th align=\"center\" colspan=\"4\" bgcolor=\"#cccccc\">
                      <b>Datos del accidente</b>
                </th>
           </tr>

            <tr>
                <td colspan=\"2\">
                   <b>El paciente llega: </b>".utf8_encode($LlegaNombre)."
                </td>
                <td colspan=\"2\">
                   <b>Fecha y hora:   </b>".utf8_encode($FechaAcc)." ".utf8_encode($HoraAcc)."
                </td>

           </tr>
           <tr>
               <td colspan=\"2\">
                  <b>Tipo de vehículo: </b>".utf8_encode($VehiculoNombre)."
               </td>
               <td colspan=\"2\">
                  <b>Posición:  </b>".utf8_encode($PosicionNombre)."
               </td>
           </tr>
           <tr>
               <td valign='middle'>
                 <b>Equipo de seguridad: </b>
               </td>
               <td>".utf8_encode($SegArreglo)."</td>
               <td valign=\"middle\">
               <b>Descripción del acc.: </b>
               </td>
               <td>".utf8_encode($LesArreglo)."</td>
           </tr>
           <tr>
                 <td>
                      <b>Mecanismo de la lesión: </b>
                 </td>
                 <td colspan=\"3\">".utf8_encode($Mecanismo)."
                 </td>
           </tr>
           <tr>
                <td colspan=\"4\" bgcolor=\"#cccccc\" align=\"center\">
                   <b>Presentó: </b>
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
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";

    $query="SELECT Les_nombre, Cue_nombre, LesN_clave FROM LesionNota inner join Lesion on Lesion.Les_clave=LesionNota.Les_clave inner join Cuerpo on Cuerpo.Cue_clave=LesionNota.Cue_clave Where Exp_folio='".$fol."' ORDER BY LesN_clave ASC";
    $rs=mysql_query($query,$conn);

    $html="
            <tr>
                    <th width=\"50%\"><b>Lesión</b></th>
                    <th width=\"50%\"><b>Zona</b></th>
            </tr>
          ";
    if($row=  mysql_fetch_array($rs))
    {
        do{
              $html1="
                        <tr>
                             <td>".utf8_encode($row['Les_nombre'])."</td>
                             <td>".utf8_encode($row['Cue_nombre'])."</td>
                         </tr>";
              $html2=$html2.$html1;

        }while($row = mysql_fetch_array($rs));
    }

 
$htmlLesion= $html.$html2;
$html=""; $html2=""; $html3="";

$query="Select ObsNot_edoG from ObsNotaMed where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);

$edoGeneral=$row['ObsNot_edoG'];

$html="
     <table  border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
                <th align=\"center\" colspan=\"2\" bgcolor=\"#cccccc\">
                      <b>El paciente presento</b>
                </th>
           </tr>".$htmlLesion."
     </table>
    ";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";

$html="
    <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
    <tr>
                  <td align=\"center\" bgcolor=\"#cccccc\">
                     <b>Estado general: </b>
                </td>
           </tr>
           <tr>
                <td align=\"justify\">".utf8_encode($edoGeneral)."
                </td>
           </tr>

    </table>
    ";

$query="Select ObsNot_expF from ObsNotaMed where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);

$expFisica=$row['ObsNot_expF'];


$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";
$html="
<table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
  <tr>
                <td align=\"center\" bgcolor=\"#cccccc\">
                    <b>Exploración física: </b>
                </td>
           </tr>
           <tr>
                <td align=\"justify\">".utf8_encode($expFisica)."
                </td>
           </tr>
</table>

    ";

$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";


$query="Select ObsNot_diagnosticoRx from ObsNotaMed where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);

$diagnosticoRx=$row['ObsNot_diagnosticoRx'];

  $query="SELECT Rxs_clave, Rx_nombre, Rxs_Obs, Rxs_desc FROM RxSolicitados inner Join Rx on Rx.Rx_clave=RxSolicitados.Rx_clave Where Exp_folio='".$fol."'";
  $rs=mysql_query($query,$conn);
$html="
     <table  border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
                <th align=\"center\" colspan=\"3\" bgcolor=\"#cccccc\">
                      <b>Estudios solicitados</b>
                </th>
           </tr>
           <tr>
               <th width=\"20%\"><b>Rx</b></th>
               <th width=\"30%\"><b>Observaciones</b></th>
               <th width=\"50%\"><b>Interpretación Ortopédica</b></th>
           </tr>
      ";
  if($row=  mysql_fetch_array($rs))
        {
           do
             {
               $html1= "<tr>
                            <td>".utf8_encode($row['Rx_nombre'])."</td>
                            <td>".utf8_encode($row['Rxs_Obs'])."</td>
                            <td>".utf8_encode($row['Rxs_desc'])."</td>
                     </tr>";
               $html2=$html2.$html1;
           }while($row=  mysql_fetch_array($rs));

        }
        $html3="
          <tr>
                 <td>
                  <b>Diagnóstico:</b>
                 </td>
                 <td colspan=\"2\">".utf8_encode($diagnosticoRx)."
                 </td>
          </tr>
         </table>";


// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html2.$html3, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html2=""; $html3="";




    $query="SELECT Nproc_clave, Pro_nombre, Nproc_obs  FROM NotaProcedimientos inner Join Procedimientos on Procedimientos.Pro_clave=NotaProcedimientos.Pro_clave Where Exp_folio='".$fol."'";
    $rs=mysql_query($query,$conn);
   if($row = mysql_fetch_array($rs))
     {
       $html="
    <table  border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
                <th align=\"center\" colspan=\"2\" bgcolor=\"#cccccc\">
                      <b>Procedimientos</b>
                </th>
           </tr>
           <tr>
                 <td width=\"30%\"><b>Procedimiento</b></td>
                 <td width=\"70%\"><b>Observaciones</b></td>
           </tr>";
           do{
                $html1="<tr>
                             <td>".utf8_encode($row['Pro_nombre'])."</td>
                             <td>".utf8_encode($row['Nproc_obs'])."</td>
                        </tr>";
                $html2=$html2.$html1;

             }while($row=mysql_fetch_array ($rs));
             $html3="</table>";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html2.$html3, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html2=""; $html3="";
     }



    $query="SELECT Cur_clave, Cur_curaciones  FROM Curaciones Where Exp_folio='".$fol."'";
    $rs=mysql_query($query,$conn);

if($row = mysql_fetch_array($rs))
    {
    $html="
    <table  border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
                <th align=\"center\" bgcolor=\"#cccccc\">
                      <b>Curaciones</b>
                </th>
           </tr>";
              do{
             $html1="<tr>
                          <td>".utf8_encode($row['Cur_curaciones'])."</td>
                     </tr>";
             $html2=$html2.$html1;

              }while($row = mysql_fetch_array($rs));
              $html3="</table>";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html2.$html3, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html2=""; $html3="";
    }

/////Symio
if($_SESSION["usuClave"]=='lendex'){
$html="
       <table  border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
                <th align=\"center\" colspan=\"3\" bgcolor=\"#cccccc\">
                      <b>Suministros Symio</b>
                </th>
           </tr>
           <tr>
                <td width=\"10%\"><b>Cantidad</b></td>
                <td width=\"30%\"><b>Suministro</b></td>
                <td width=\"60%\"><b>Indicaciones</b></td>
          </tr>";

$query="SELECT Nsum_clave, Nombre_producto, Nsum_obs, Nsum_Cantidad  FROM SymioNotaSuministro inner Join SymioProducto on SymioProducto.Clave_producto =SymioNotaSuministro.Sum_clave Where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);

       if($row = mysql_fetch_array($rs))
           {
             do{
                 $html1="<tr>
                              <td>".utf8_encode($row['Nsum_Cantidad'])."</td>
                              <td>".utf8_encode($row['Nombre_producto'])."</td>
                              <td>".utf8_encode($row['Nsum_obs'])."</td>
                         </tr>";
                 $html2=$html2.$html1;
                }while($row = mysql_fetch_array($rs));
           }
$html3="</table>";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html2.$html3, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html2=""; $html3="";
}
////Fin Symio

/*
$html="
        <table  border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
                <th align=\"center\" colspan=\"2\" bgcolor=\"#cccccc\">
                      <b>Otros estudios</b>
                </th>
           </tr>
           <tr>
                <th width=\"20%\"><b>Estudio</b></th>
                <th width=\"80%\"><b>Justificacion y Observaciones</b></th>
           </tr>";

    $query="SELECT EstuS_clave, Estu_nombre, EstuS_Obs FROM EstSolicitados inner Join Estudios on Estudios.Estu_clave=EstSolicitados.Estu_clave Where Exp_folio='".$fol."'";
    $rs=mysql_query($query,$conn);

    if($row=  mysql_fetch_array($rs))
         {
            do
               {
                $html1="<tr>
                         <td>".utf8_encode($row['Estu_nombre'])."</td>
                         <td>".utf8_encode($row['EstuS_Obs'])."</td>
                 </tr>";
                $html2=$html2.$html1;
                }while($row = mysql_fetch_array($rs));
        }
$html3="</table>";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html2.$html3, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html2=""; $html3="";
*/
$html="
       <table  border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
                <th align=\"center\" colspan=\"3\" bgcolor=\"#cccccc\">
                      <b>Suministros</b>
                </th>
           </tr>
           <tr>
                <td width=\"10%\"><b>Cantidad</b></td>
                <td width=\"30%\"><b>Suministro</b></td>
                <td width=\"60%\"><b>Indicaciones</b></td>
          </tr>";

$query="SELECT Nsum_clave, Sum_nombre, Nsum_obs, Nsum_Cantidad  FROM NotaSuministro inner Join Suministro on Suministro.Sum_clave =NotaSuministro.Sum_clave Where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);

       if($row = mysql_fetch_array($rs))
           {
             do{
                 $html1="<tr>
                              <td>".utf8_encode($row['Nsum_Cantidad'])."</td>
                              <td>".utf8_encode($row['Sum_nombre'])."</td>
                              <td>".utf8_encode($row['Nsum_obs'])."</td>
                         </tr>";
                 $html2=$html2.$html1;
                }while($row = mysql_fetch_array($rs));
           }
$html3="</table>";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html2.$html3, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html2=""; $html3="";


$html="
     <table  border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
                <th align=\"center\" colspan=\"4\" bgcolor=\"#cccccc\">
                      <b>Ortesis</b>
                </th>
           </tr>
           <tr>
                  <td width=\"10%\"><b>Cantidad</b></td>
                  <td width=\"15%\"><b>Ortesis</b></td>
                  <td width=\"15%\"><b>Presentación</b></td>
                  <td width=\"60%\"><b>Indicaciones</b></td>
            </tr>";
    $query="SELECT Notor_clave, Ort_nombre, Ortpre_nombre, Notor_cantidad, Notor_indicaciones FROM NotaOrtesis inner Join Ortesis on Ortesis.Ort_clave=NotaOrtesis.Ort_clave inner Join  Ortpresentacion on Ortpresentacion.Ortpre_clave=NotaOrtesis.Ortpre_clave Where Exp_folio='".$fol."'";
    $rs=mysql_query($query,$conn);

if($row = mysql_fetch_array($rs))
    {
          do{
                $html1="<tr>
                            <td>".utf8_encode($row['Notor_cantidad'])."</td>
                            <td>".utf8_encode($row['Ort_nombre'])."</td>
                            <td>".utf8_encode($row['Ortpre_nombre'])."</td>
                             <td>".utf8_encode($row['Notor_indicaciones'])."</td>
                        </tr>";
                $html2=$html2.$html1;

            }while($row = mysql_fetch_array($rs));
    }

$html3="</table>";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html2.$html3, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html2=""; $html3="";

$html="
       <table  border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
               <tr>
                    <th align=\"center\" bgcolor=\"#cccccc\">
                         <b>Indicaciones generales</b>
                    </th>
               </tr>";

$query="SELECT Nind_clave, Nind_obs FROM NotaInd Where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
       if($row = mysql_fetch_array($rs))
           {
               do{
                     $html1="<tr>
                                  <td>".utf8_encode($row['Nind_obs'])."</td>
                             </tr>";
                     $html2=$html2.$html1;
                 }while($row = mysql_fetch_array($rs));
           }
 
           $html3="</table>";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html2.$html3, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html2=""; $html3="";

$pdf->AddPage();

$query="Select ObsNot_obs, ObsNot_pron, ObsNot_waddell from ObsNotaMed where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);


$obsGenerales=$row['ObsNot_obs'];
$pronGeneral=$row['ObsNot_pron'];
$ObsNotWaddell =$row['ObsNot_waddell'];

$html="

   <table  border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
               <tr>
                    <th align=\"center\" bgcolor=\"#cccccc\">
                         <b>CRITERIOS DE WADDELL</b>
                    </th>
               </tr>
               <tr>
                    <td>".utf8_encode($ObsNotWaddell)."</td>
               </tr>
               </table>
";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html2.$html3, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html2=""; $html3="";

$html="
    
   <table  border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
               <tr>
                    <th align=\"center\" bgcolor=\"#cccccc\">
                         <b>OBSERVACIONES</b>
                    </th>
               </tr>
               <tr>
                    <td>".utf8_encode($obsGenerales)."</td>
               </tr>
               </table>
";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html2.$html3, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html2=""; $html3="";


$html="

   <table  border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
               <tr>
                    <th align=\"center\" bgcolor=\"#cccccc\">
                         <b>PRONÓSTICO</b>
                    </th>
               </tr>
               <tr>
                    <td>".utf8_encode($pronGeneral)."</td>
               </tr>
    </table>
";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html2.$html3, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html2=""; $html3="";

$query="Select Med_nombre, Med_paterno, Med_materno, Med_cedula, Med_sexo From Medico Where Usu_login='".$Usuario."'";
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);

$MedicoNombre=$row["Med_nombre"]." ".$row["Med_paterno"].$row["Med_materno"];
$Cedula=$row["Med_cedula"];
$Titulo=$row["Med_sexo"];

if($Titulo=='M'){$Titulo="Dr.";}else{$Titulo="Dra.";}

$html="
           <table  border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
              <tr>
                  <th align=\"center\" bgcolor=\"#cccccc\">
                  <b>Firmas</b>
                  </th>
             </tr>
           </table>

     ";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$html="
    <table  border=\"1\">
            
             <tr>
                      <td width=\"35%\" height=\"70px\">
                              <br/>
                              <br/>
                              <br/>
                              <br/>
                              <br/>
                          
                      </td>
                      <td width=\"30%\" style=\"border:none\">

                     </td>
                     <td width=\"35%\"  height=\"70px\">
                             <br/>
                             <br/>
                             <br/>
                             <br/>
                             <br/>                  
                     </td>
                 </tr>
                 <tr>
                      <td width=\"35%\" align=\"center\" >".$Titulo." ".utf8_encode($MedicoNombre)."<br/>Cédula: ".utf8_encode($Cedula)."</td>
                      <td width=\"30%\" style=\"border:none\">

                      </td>
                      <td width=\"35%\" align=\"center\" >
                              Firma del paciente
                      </td>
                 </tr>
            <tr>
                    <td colspan=\"2\" style=\"border:none\"> </td>
                
                    <td align=\"justyfi\">
                    Firma del paciente al recibir resultado radiográfico, medicamentos, órtesis,  diagnóstico. 
                    </td>
            </tr>
    </table>
      ";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->output("NM_".$fol.".pdf",'D');


?>


