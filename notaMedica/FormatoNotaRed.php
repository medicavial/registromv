<?php
require "validaUsuario.php";//con
require 'tcpdf.php';
require 'config/lang/eng.php';




$query="Select Exp_nombre, Exp_paterno, Exp_materno, Exp_fechaNac,Usu_registro,Exp_fecreg, Exp_edad, Exp_meses, Exp_sexo, Rel_clave,  Exp_mail, Exp_telefono, Cia_clave From Expediente 
Where Exp_folio='".$fol."'";
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

$Mail        =$row['Exp_mail'];
$Telefono    =$row['Exp_telefono'];
$CiaClave    =$row['Cia_clave'];
$Usuario     =$row['Usu_registro'];
$fechaNotMedica =    $row['Exp_fecreg'];


$NombreCompleto= $Nombre." ".$Paterno." ".$Materno;

if($Sexo=="M")$Sexo="Masculino";
if($Sexo=="F")$Sexo="Femenino";

$query2="Select Rel_nombre, Edo_nombre from Expediente
INNER JOIN ocupacion_red on Expediente.Ocu_clave= ocupacion_red.Ocu_clave
INNER JOIN EdoCivil_red on Expediente.Edo_clave=EdoCivil_red.Edo_clave
Where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
$row= mysql_fetch_array($rs);

$Ocupacion   =$row['Ocu_nombre'];
$EdoCivil    =$row['Edo_nombre'];

if($Ocupacion==null||$Ocupacion==-1)$Ocupacion= "N/C";
if($EdoCivil==null||$EdoCivil==-1)$EdoCivil= "N/C ";




/////////////////////////////
          ////////////////////////////////////////////////////////////////////////////////////////////
          /////////////         PDF Con tcpdf                                               //////////
          ////////////                                                                     ///////////
          ////////////////////////////////////////////////////////////////////////////////////////////

          // Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
  //Page header
  public function Header() {
    // Logo
            /*global $fechaNotMedica;
    $image_file ='imgs/mv.jpg';
    $this->Image($image_file, 10, 10, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);





    //$image_file = K_PATH_IMAGES.$_SESSION["FOLIO"].'.png';
    //$this->Image($image_file, 90, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    // Set font
    $this->SetFont('helvetica', 'B', 14);
    // Title
                $this->Cell(0, 15, 'Nota Médica', 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                $this->SetFont('helvetica', 'B', 10);
                 $this->Cell(0, 15, 'Folio Asignado:'.$fol, 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                 $this->SetFont('helvetica', 'B', 8);
                 $this->Cell(0, 15,"Fecha:".$fechaNotMedica, 0, false, 'R', 0, '', 0, false, 'M', 'M');
            */}
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

                // PRINT VARIOUS 1D BARCODES

                // CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9.
                $pdf->write1DBarcode($fol, 'C39', '87', '', '', 12, 0.2, $style, 'C');
              //  $this->write1DBarcode($code, $type, $x, $y, $w, $h, $xres, $style, $align);
          $image_file ="imgs/mv.jpg";
    $pdf->Image($image_file, 160, 10, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
           //$image_file = "formatosMV/qualitas.jpg";
           //$pdf->Image($image_file, 10, 10, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    // Set font
                $pdf->Ln(15);
    $pdf->SetFont('helvetica', 'B', 12);
    // Title
                $pdf->Cell(0, 15, 'Nota Médica', 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                $pdf->SetFont('helvetica', 'B', 10);
                 $pdf->Cell(0, 15, 'Folio Asignado:'.$fol, 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                 $pdf->SetFont('helvetica', 'B', 8);
                 $pdf->Cell(0, 15,"Fecha:".$fechaNotMedica, 0, false, 'R', 0, '', 0, false, 'M', 'M');
$pdf->Ln(4);


/////////////////////////////////////////////////////////////////



$pdf->SetFont('dejavusans', '', 6, '', true);
$pdf->Cell($w, $h, $txt="Usuario: ".$Usuario, $border, $ln=4, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->SetFont('dejavusans', '', 8, '', true);
////////////////////// Datos del paciente///
$html .= "
    
<table border=\"1\"  cellspacing=\"3\" cellpadding=\"4\">
    <tr>
        <th align=\"center\" colspan=\"6\" bgcolor=\"#cccccc\">
            <b>DATOS DEL PACIENTE</b>
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


/////EMBARAZO//////////



 $query="SELECT Emb_semGestacion, Emb_dolAbdominal, Emb_descripcion, Emb_movFetales, Emb_fcf, Emb_ginecologia, Emb_obs FROM EmbarazoRed Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
    $rs=mysql_query($query,$conn);
    if($row=mysql_fetch_array($rs)){

$html="
       <table border=\"1\"  cellspacing=\"3\" cellpadding=\"4\">
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

//////FIN EMBARAZO///////////

////////////////////                    LESION                //////////////////////

$query="SELECT Les_nombre, Cue_nombre, LesN_clave FROM LesionNotaRed inner join LesionRed on LesionRed.Les_clave=LesionNotaRed.Les_clave inner join CuerpoRed on CuerpoRed.Cue_clave=LesionNotaRed.Cue_clave Where Exp_folio='".$fol."' and Not_clave=".$Not." ORDER BY LesN_clave ASC";
$rs=mysql_query($query,$conn);
if($row=  mysql_fetch_array($rs))
{
    $html= "<table width=\"100%\" border=\"1\"  align=\"center\"  width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
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
        $html.= "      <td align=\"left\">".utf8_encode($row['Les_nombre'])."</td>";
        $html.= "      <td align=\"left\">".utf8_encode($row['Cue_nombre'])."</td>";        
        $html.= " </tr>";
    }while($row = mysql_fetch_array($rs));
    $html.= "</table>";
    $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
    $html="";
}

////////////////////                  FIN LESION              ////////////////////// 

/////Antecedentes Heredo Familiares//////////


     $query="SELECT FamE_clave, Enf_nombre, Fam_nombre, Est_nombre, FamE_obs 
        FROM FamEnfermedadRed 
        Inner Join Enfermedad on FamEnfermedadRed.Enf_clave=Enfermedad.Enf_clave 
        Inner Join Familia on FamEnfermedadRed.Fam_clave=Familia.Fam_clave 
        Inner Join EstatusFam on FamEnfermedadRed.Est_clave=EstatusFam.Est_clave 
        Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
    $rs=mysql_query($query,$conn);

    if($row=mysql_fetch_array($rs)){

$html="<table id=\"TablaHeredo\" border=\"1\"  align=\"center\"  width=\"100%\" cellspacing=\"3\" cellpadding=\"4\">
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

$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";
  }

//////FIN Antecedentes Heredo Familiares///////////

/////////////     Antecedentes Personales   ///////////

$html="<table  width=\"100%\" border=\"1\" align=\"center\"  width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
          <tr>
                  <th align=\"center\" bgcolor=\"#cccccc\">
                            <b>Antecedentes Personales</b>
                  </th>
          </tr>
      </table>"; 
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";         

////////////    cronicos Degenerativos   ///////////
$query="SELECT Hist_clave, Pad_nombre, Pad_obs 
           FROM HistoriaPadecimientoRed 
           Inner Join Padecimientos on HistoriaPadecimientoRed.Pad_clave=Padecimientos.Pad_clave 
           Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
    $rs=mysql_query($query,$conn);
    
if($row=mysql_fetch_array($rs)){

 $html="<table  width=\"100%\" border=\"1\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
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
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";
}else{
	$html="<table  width=\"100%\" border=\"1\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
			<tr>
			<th>
			          <b>Cr&oacute;nicos Degenerativos</b> - Negado -
			</th>
			</tr></table>";	
	$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
	$html="";
}
////////////   fin cronicos Degenerativos   ///////////

////////////    Otras enfermedades   ///////////
 $query="SELECT HistOt_clave, Otr_nombre, HistOt_obs 
     FROM HistoriaOtrasRed 
     Inner Join Otras on HistoriaOtrasRed.Otr_clave=Otras.Otr_clave 
     Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
 $rs=mysql_query($query,$conn);

if($row=mysql_fetch_array($rs)){

$html="<table width=\"100%\" border=\"1\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
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
     $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
    $html="";
 }else{
	$html="<table  width=\"100%\" border=\"1\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
			<tr>
			<th>
			          <b>Otras Enfermedades</b> - Negado -
			</th>
			</tr></table>";
	$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
	$html="";
}

////////////   fin Otras enfermedades   ///////////

////////////    ALERGIAS                ///////////

$query="SELECT HistA_clave, Ale_nombre, Ale_obs 
       FROM HistoriaAlergiasRed 
       Inner Join Alergias on HistoriaAlergiasRed.Ale_clave=Alergias.Ale_clave 
       Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
       $rs=mysql_query($query,$conn);
 
       if($row=  mysql_fetch_array($rs)){
          $html="<table  border=\"1\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
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
               $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
              $html="";
      }else{
	$html="<table  width=\"100%\" border=\"1\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
			<tr>
			<th>
			          <b>Alergias</b> - Negado -
			</th>
			</tr></table>";
	$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
	$html="";
	}

////////////          FIN ALERGIAS     ////////////         

////////////        PADECIMIENTOS ESPALDA /////////

$query="SELECT HistE_clave, Esp_estatus, Esp_obs 
       FROM HistoriaEspaldaRed 
       Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs=mysql_query($query,$conn);
if($row=  mysql_fetch_array($rs)){ 
$html="<table width=\"100%\" border=\"1\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
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
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";
}else{
$html="<table  width=\"100%\" border=\"1\"  width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
		<tr>
		<th>
		          <b>Padecimientos Espalda</b> - Negado -
		</th>
		</tr></table>";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";
}

////////////     FIN PADECIMIENTOS ESPALDA  ///////

////////////      TRATAMIENTO QUIROPRACTICO ///////

$query="SELECT HistoriaQ_clave, Quiro_estatus, Quiro_obs 
        FROM HistoriaQuiroRed 
        Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
  $rs=mysql_query($query,$conn);

  if($row=  mysql_fetch_array($rs)){
  $html="<table  width=\"100%\" border=\"1\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\">
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
  $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
  $html="";
}else{
$html="<table  width=\"100%\" border=\"1\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
		<tr>
		<th>
		          <b>Tratamiento quiropr&aacute;ctico</b> - Negado -
		</th>
		</tr></table>";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";
}

///////////   FIN TRATAMIENTO QUIROPARACTICO //////

///////////       USO DE PLANTILLAS          //////

$query="SELECT HistP_clave, Plantillas_estatus, Plantillas_obs 
         FROM HistoriaPlantillasRed 
         Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs=mysql_query($query,$conn);
if($row=  mysql_fetch_array($rs)){ 
    $html="<table width=\"100%\" border=\"1\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\">
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
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";
}else{
$html="<table  width=\"100%\" border=\"1\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
		<tr>
		<th>
		          <b>Uso de Plantillas</b> - Negado -
		</th>
		</tr></table>";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";
}

///////////      FIN USO DE PLANTILLAS       //////

///////////         TRATAMIENTOS             //////

$query="SELECT HistT_clave, HistT_estatus, HistT_obs 
       FROM HistoriaTratRed 
       Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs=mysql_query($query,$conn);
if($row=  mysql_fetch_array($rs)){ 
    $html="<table width=\"100%\" border=\"1\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\">
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
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";
}else{
$html="<table  width=\"100%\" border=\"1\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
		<tr>
		<th>
		          <b>Tratamientos</b> - Negado -
		</th>
		</tr></table>";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";
}

///////////        FIN TRATAMIENTOS          //////

///////////      INTERVENCIONES              //////

$query="SELECT HistO_clave, HistO_estatus, HistO_obs 
       FROM HistoriaOperacionRed 
       Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs=mysql_query($query,$conn);
if($row=  mysql_fetch_array($rs)){ 
$html="<table  width=\"100%\" border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
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
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";
}
else{
$html="<table  width=\"100%\" border=\"1\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
		<tr>
		<th>
		          <b>Intervenciones</b> - Negado -
		</th>
		</tr></table>";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";
}                    

///////////          FIN DE INTERVENCIONES   //////

///////////             DEPORTES             //////

$query="SELECT HistD_clave, Dep_estatus, Dep_obs 
        FROM HistoriaDeporteRed 
        Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs=mysql_query($query,$conn);
if($row=  mysql_fetch_array($rs)){ 
    $html="<table  width=\"100%\" border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
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
    $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
    $html="";
}else{
$html="<table  width=\"100%\" border=\"1\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
		<tr>
		<th>
		          <b>Deportes</b> - Negado -
		</th>
		</tr></table>";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";
}      

///////////          FIN DEPORTES           ///////

///////////            ADICCIONES          //////

$query="SELECT HistA_clave, Adic_estatus, Adic_obs 
        FROM HistoriaAdiccionRed 
        Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs=mysql_query($query,$conn);
if($row=  mysql_fetch_array($rs)){ 
    $html="<table width=\"100%\" border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
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
    $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
    $html="";
}else{
$html="<table  width=\"100%\" border=\"1\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\" >
		<tr>
		<th>
		          <b>Adicciones</b> - Negado -
		</th>
		</tr></table>";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";
}           

//////////            FIN Accidentes        ///////

/////////////  Fin Antecedentes Personales   /////////// 


/////Accidentes Anteriores//////////
$query="SELECT HistAcc_clave, Acc_estatus, Lug_nombre, Acc_obs FROM HistoriaAccRed
                           Inner Join LugarRed on HistoriaAccRed.Lug_clave=LugarRed.Lug_clave
                           Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
                      
                       $rs=mysql_query($query,$conn);
                        if($row= mysql_fetch_array($rs))
                         {
                            $html="<table id=\"HistoriaAccRed\" border=\"1\" align=\"center\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\">
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
                                   $html.= "                <td>".utf8_encode($row['Acc_estatus'])."</td>";
                                   $html.= "                <td>".utf8_encode($row['Lug_nombre'])."</td>";
                                   $html.= "                <td>".utf8_encode($row['Acc_obs'])."</td>";                                   
                                   $html.= " </tr>";
                                }  while($row = mysql_fetch_array($rs));

                              $html.="  </table>";                            
                              $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
                              $html="";
                              }

//////FIN Accidentes Anteriores///////////


/////Signos vitales
$query="Select Not_clave, Exp_folio,Not_temperatura, Not_talla, Not_peso, Not_ta, Not_fc, Not_fr, Not_obs_vitales 
    FROM Nota_med_red 
    WHERE Not_clave='".$Not."' and Exp_folio='".$fol."' ";
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

      $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html1, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
      $html1="";
}
//////////////////////FIN VITALES


/////// Datos del accidente
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




////////////            ESTUDIOS REALIZADOS     ////////

$query="SELECT Est_clave, Est_estudio, Est_descripcion, Est_Resultado, Est_observacion
        FROM EstudiosRealizadosRed
        Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
$rs=mysql_query($query,$conn);
if($row= mysql_fetch_array($rs))
    {
    $html="<table id=\"EstudiosRealizadosRed\" border=\"1\" align=\"center\"  width=\"100%\" class=\"table table-striped table-hover\">
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
    $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
    $html="";
}

////////////            FIN ESTUDIOS REALIZADOS    /////

////////////            PROCEDIMIENTOS MEDICOS      ///////////

$query="SELECT * from ProcesosMedicosRed where Exp_folio='".$fol."' and Not_clave='".$Not."' ";
$rs=mysql_query($query,$conn);

if($row=mysql_fetch_array($rs)){
    
$html="<table align=\"center\" border=\"1\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\">";
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
                $html.="<td>".utf8_encode($row['PM_procedimiento'])."</td>";
                $html.="<td>".utf8_encode($row['PM_obs'])."</td>";                        
        $html.="</tr>";        
    }while($row=  mysql_fetch_array($rs));
    
$html.="</table>";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";
}

////////////          FIN PROCEDIMIENTOS MEDICOS   /////////////

////////////////            SUMINISTROS              ///////////

$query="SELECT * from SuministroRed 
        Inner JOin TipoSuministroRed on TipoSuministroRed.tipoSR_id=SuministroRed.sumRed_tipo
        where Exp_folio='".$fol."' and Not_clave='".$Not."' ";
$rs=mysql_query($query,$conn);
if($row=mysql_fetch_array($rs)){  
  $html="<table align=\"center\" border=\"1\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\">";
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
                  $html.="<td>".utf8_encode($row['tipoSR_nombre'])."</td>";
                  $html.="<td>".utf8_encode($row['sumRed_desc'])."</td>";
                  $html.="<td>".utf8_encode($row['sumRed_obs'])."</td>";                
          $html.="</tr>";        
      }while($row=  mysql_fetch_array($rs));  
  $html.="</table>";
  $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
  $html="";
}

///////////////           FIN SUMINISTROS             //////////

///////////////////            estado general, exploracion fisica y observaciones   /////////////

$query="SELECT Not_edo_general, Not_obs_expediente from Nota_med_red         
        where Exp_folio='".$fol."' and Not_clave='".$Not."' ";
$rs=mysql_query($query,$conn);
$row=  mysql_fetch_array($rs);

 $html="<table align=\"center\" border=\"1\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\">";
  $html.="<tr>
          <th align=\"center\"  bgcolor=\"#cccccc\">
                <b>Estado General y Exploraci&oacute;n F&iacute;sica</b>
          </th>          
          </tr>
          <tr>
            <td>".utf8_encode($row['Not_edo_general'])."</td>
          </tr>
        </table>";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";

$html="<table align=\"center\" border=\"1\" width=\"100%\" cellspacing=\"3\" cellpadding=\"4\">";
  $html.="<tr>
          <th align=\"center\" bgcolor=\"#cccccc\">
                <b>Observaciones</b>
          </th>          
          </tr>
          <tr>
            <td>".utf8_encode($row['Not_obs_expediente'])."</td>
          </tr>
        </table>";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";

//////////////////        fin estado General y exploracion fisica  y observaciones    ///////////////////

///////////////////////////					FIRMAS 						/////////////////////////////////


$html="<br><br><br><br><br><br><br><br><br><br><br><br><br>
    <table cellspacing=\"3\" cellpadding=\"4\">
                         
                 <tr>
                      <td width=\"50%\" align=\"left\" >Dr(a).   ____________________________________________________</td>
                      
                      <td width=\"50%\" align=\"center\" >
                              _______________________________________________________
                      </td>
                 </tr>
                 <tr>
                      <td width=\"50%\" align=\"left\" >Cédula:____________________</td>
                      
                      <td width=\"50%\" align=\"center\" >
                              Firma del paciente
                      </td>
                 </tr>

            <tr>
                    <td style=\"border:none\"> </td>
                
                    <td align=\"left\">
                    Firma del paciente al recibir resultado radiográfico, medicamentos, órtesis,  diagnóstico. 
                    </td>
            </tr>
    </table>
      ";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


//////////////////////////				  FIN FIRMAS 					/////////////////////////////////



$pdf->output("NMR_".$fol.".pdf",'D');