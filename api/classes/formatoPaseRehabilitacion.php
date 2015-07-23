<?php
require "pac_vars.inc";
require 'tcpdf.php';
require 'config/lang/eng.php';

$fol=$_GET['fol'];
$usr=$_GET['usr'];

///// Datos de la aseguradora /////
$query="Select Cia_nombrecorto From Compania INNER JOIN Expediente On Expediente.Cia_clave=Compania.Cia_clave Where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);
$aseguradora=$row['Cia_nombrecorto'];

///// Datos de la unidad /////
$query="Select Uni_nombrecorto From Unidad INNER JOIN Expediente On Expediente.Uni_clave=Unidad.Uni_clave Where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);
$unidad=$row['Uni_nombrecorto'];

////////// Datos del Expediente /////
$query="Select Exp_nombre, Exp_fecreg, Exp_paterno, Exp_materno, Exp_edad, Exp_sexo, Exp_poliza,Exp_reporte,Exp_siniestro From Expediente Where Exp_cancelado=0 and Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
$row= mysql_fetch_array($rs);
$Edad=$row['Exp_edad'];
$Sexo=$row['Exp_sexo'];
$reporte=$row['Exp_reporte'];
$siniestro=$row['Exp_siniestro'];
$poliza=$row['Exp_poliza'];
$fechaatencion=$row['Exp_fecreg'];
$NombreCompleto=$row['Exp_nombre']." ".$row['Exp_paterno']." ".$row['Exp_materno'];

if($Sexo=="M")$Sexo="Masculino";
if($Sexo=="F")$Sexo="Femenino";

list($fecha,$hora)= explode(" ", $fechaatencion);
list($ano,$mes,$dia)= explode("-", $fecha);

switch ($mes){
                 case '01':
                 $mes="January";//Enero
                 break;

                 case '02':
                 $mes="February";//Febrero
                 break;

                 case '03':
                 $mes="March";//Marzo
                 break;

                 case '04':
                 $mes="April";//Abril
                 break;

                 case '05':
                 $mes="May";//Mayo
                 break;

                 case '06':
                 $mes="June";//Junio
                 break;

                 case '07':
                 $mes="July";//Julio
                 break;

                 case '08':
                 $mes="August";//Agosto
                 break;

                 case '09':
                 $mes="September";//Septiembre
                 break;

                 case '10':
                 $mes="October";//Octubre
                 break;

                 case '11':
                 $mes="November";//Noviembre
                 break;

                 case '12':
                 $mes="December";//Diciembre
                 break;
}

///// Datos del Medico que Envia a Terapia /////
$query="Select * From RehabilitacionPase Where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);
$medicoaterapia=$row['Usu_registro'];
$diagnosticopase=$row['RPase_diagnostico'];
$fechapase=$row['RPase_fecha'];
$numeropase=$row['RPase_rehabilitacion'];
$obspase=$row['RPase_obs'];

$query="Select Med_nombre, Med_paterno, Med_materno From Medico Where Usu_login='".$medicoaterapia."'";
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);
$NombreMedico=$row['Med_nombre']." ".$row['Med_paterno']." ".$row['Med_materno'];

/// Numero de Subsecuencias
$query="Select Max(Sub_cons) As Cons From Subsecuencia Where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);
$numrehab=$row['Cons'];

          ////////////////////////////////////////////////////////////////////////////////////////////
          ////////////          PDF Con tcpdf                                               //////////
          ////////////                                                                     ///////////
          ////////////////////////////////////////////////////////////////////////////////////////////

          // Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
            global $aseguradora,$unidad,$fol;
		$image_file ='../../imgs/logomv.jpg';
		$this->Image($image_file, 10, 10, 35, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		$this->SetFont('helvetica', 'B', 8);
                $this->Cell(0, 15, 'Folio Asignado:'.$fol, 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                $this->SetFont('helvetica', 'B', 10);
                $this->Cell(0, 15, 'PASE A REHABILITACION', 0, 0, 'C', 0, '', 0, false, 'M', 'M');
                $this->SetFont('helvetica', 'B', 8);
                $this->Cell(0, 15, 'Aseguradora:'.strtoupper($aseguradora), 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                //$this->Cell(0, 15, 'REPORTE DE TERAPIA', 0, 0, 'C', 0, '', 0, false, 'M', 'M');
                $this->Cell(0, 15, 'Unidad Médica:'.strtoupper($unidad), 0, 1, 'R', 0, '', 0, false, 'M', 'M');
           	}
	// Page footer
	public function Footer() {
                // Position at 15 mm from bottom
		$this->SetY(-20);
		$this->SetFont('helvetica', 'I', 8);
                $this->SetFillColor(255,255,50);
                //$this->Cell($w, $h, 'ESTIMADO PACIENTE: Les rogamos firmar únicamente al recibir CADA UNA de las sesiones', $border, $ln=1, 'C',true);
                //$this->Cell($w, $h, 'de rehabilitación. Cualquier anomalía favor de reportarla al (55) 19 95 07 07 o al 01-800-3-MEDICA.  GRACIAS!', $border, $ln=1, 'C',true);
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
$pdf->SetFont('dejavusans', '', 6, '', true);
// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();
$pdf->Cell(0, 15, '', 0, 1, 'R', 0, '', 0, false, 'M', 'M');
////////////////////// Datos del paciente///
$html = "
<table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
    <tr>
        <th align=\"center\" colspan=\"4\" bgcolor=\"#cccccc\">
            <b>Datos del Paciente</b>
        </th>
    </tr>
    <tr>
         <td colspan=\"2\" width=\"70%\">
             <b>LESIONADO:</b>  ".strtoupper(utf8_encode($NombreCompleto))."
         </td>
         <td width=\"15%\">
           <b>EDAD:</b>  ".$Edad."
         </td>
         <td width=\"15%\">
             <b>SEXO:</b>  ".strtoupper($Sexo)."
         </td>
    </tr>
    <tr>
      <td>
             <b>SINIESTRO:</b>  ".strtoupper(utf8_encode($siniestro))."
      </td>
      <td>
          <b>REPORTE:</b>  ".strtoupper(utf8_encode($reporte))."
      </td>
      <td colspan=\"2\">
           <b>PÓLIZA:</b>  ".strtoupper(utf8_encode($poliza))."
      </td>
   </tr>   
</table>
";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

//****************************
$html="";
$html = "
<table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
    <tr>
        <th align=\"center\" colspan=\"2\" bgcolor=\"#cccccc\">
            <b>Datos del Pase a Rehabilitación</b>
        </th>
    </tr>
    <tr>
         <td width=\"70%\">
             <b>DIAGNÓSTICO CON EL QUE SE ENVIÓ A TERAPIA:</b>  ".strtoupper(utf8_encode($diagnosticopase))."
         </td>
         <td width=\"30%\" colspan=\"2\">
           <b>NÚMERO DE SUBSECUENCIAS PREVIAS:</b> ".($numrehab)."
         </td>
    </tr>
    <tr>
         <td width=\"70%\">
             <b>OBSERVACIONES:</b>  ".strtoupper(utf8_encode($obspase))."
         </td>
         <td>
           <b>FECHA:</b> ".($fechapase)."
         </td>
         <td>
           <b>NO. REHABILITACIONES APROX.:</b> ".($numeropase)."
         </td>
    </tr>
    <tr>
         <td width=\"70%\">
             <b>MÉDICO QUE ENVÍA A TERAPIA:</b>  ".strtoupper(utf8_encode($NombreMedico))."
         </td>
         <td width=\"30%\" align=\"center\" colspan=\"2\">
           <br><br><br><br><b>________________________________</b><br>
           FIRMA DEL MEDICO QUE ENVÍA A TERAPIA
         </td>
    </tr>
</table>
";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


//****************************

$pdf->output("PR_".$fol.".pdf",'D');                   

     /*if($CiaClave==1){
      header("Location:formatoCia.php?fol=".$fol);
     }*/
     
?>


