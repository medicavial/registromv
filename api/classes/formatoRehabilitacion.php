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
$query="Select Exp_nombre, Exp_paterno, Exp_materno, Exp_edad, Exp_sexo, Exp_poliza,Exp_reporte,Exp_siniestro,Exp_fecreg From Expediente Where Exp_cancelado=0 and Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
$row= mysql_fetch_array($rs);
$Edad=$row['Exp_edad'];
$Sexo=$row['Exp_sexo'];
$reporte=$row['Exp_reporte'];
$siniestro=$row['Exp_siniestro'];
$poliza=$row['Exp_poliza'];
$fecreg      =$row['Exp_fecreg'];
$NombreCompleto=$row['Exp_nombre']." ".$row['Exp_paterno']." ".$row['Exp_materno'];

list($fecha,$hora)= explode(" ", $fecreg);
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

if($Sexo=="M")$Sexo="Masculino";
if($Sexo=="F")$Sexo="Femenino";

///// Datos del Medico que Envia a Terapia /////
$query="Select Usu_registro, RPase_diagnostico From RehabilitacionPase Where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);
$medicoaterapia=$row['Usu_registro'];
$diagnosticopase=$row['RPase_diagnostico'];

$query="Select Med_nombre, Med_paterno, Med_materno From Medico Where Usu_login='".$medicoaterapia."'";
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);
$NombreMedico=$row['Med_nombre']." ".$row['Med_paterno']." ".$row['Med_materno'];

/// Numero de Rehabilitaciones
$query="Select Max(Rehab_cons) As Cons From Rehabilitacion Where Exp_folio='".$fol."'";
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
		$image_file = '../../imgs/logomv.jpg';
		$this->Image($image_file, 10, 10, 35, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		$this->SetFont('helvetica', 'B', 8);
                $this->Cell(0, 15, 'Folio Asignado:'.$fol, 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                $this->SetFont('helvetica', 'B', 10);
                $this->Cell(0, 15, 'TRATAMIENTO DE REHABILITACIÓN', 0, 0, 'C', 0, '', 0, false, 'M', 'M');
                $this->SetFont('helvetica', 'B', 8);
                $this->Cell(0, 15, 'Aseguradora:'.strtoupper($aseguradora), 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                $this->Cell(0, 15, 'REPORTE DE TERAPIA', 0, 0, 'C', 0, '', 0, false, 'M', 'M');                
                $this->Cell(0, 15, 'Unidad Médica:'.strtoupper($unidad), 0, 1, 'R', 0, '', 0, false, 'M', 'M');
           	}
	// Page footer
	public function Footer() {
                // Position at 15 mm from bottom
		$this->SetY(-20);
		$this->SetFont('helvetica', 'I', 8);
                $this->SetFillColor(255,255,50);
                $this->Cell($w, $h, 'ESTIMADO PACIENTE: Les rogamos firmar únicamente al recibir CADA UNA de las sesiones', $border, $ln=1, 'C',true);
                $this->Cell($w, $h, 'de rehabilitación. Cualquier anomalía favor de reportarla al (55) 19 95 07 07 o al 01-800-3-MEDICA.  GRACIAS!', $border, $ln=1, 'C',true);                   
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
<table>
    <tr>
        <td>
        <br>
        </td>
    </tr>
</table>
";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

//****************************
$html="";
$html = "
<table border=\"1\" cellspacing=\"2\" cellpadding=\"3\">
    <tr>
        <th align=\"center\" colspan=\"2\" bgcolor=\"#cccccc\">
            <b>Datos de la Solicitud de Rehabilitación</b>
        </th>
    </tr>
    <tr>
         <td width=\"70%\">
             <b>DIAGNÓSTICO CON EL QUE SE ENVIÓ A TERAPIA:</b>  ".strtoupper(utf8_encode($diagnosticopase))."
         </td>
         <td width=\"30%\">
           <b>NÚMERO DE SESIONES PREVIAS:</b> ".($numrehab-1)."
         </td>
    </tr>
    <tr>
         <td width=\"70%\">
             <b>MÉDICO QUE ENVÍA A TERAPIA:</b>  ".strtoupper(utf8_encode($NombreMedico))."
         </td>
         <td width=\"30%\" align=\"center\">
           <br><br><br><br><b>________________________________</b><br>
           FIRMA DEL MEDICO QUE ENVÍA A TERAPIA
         </td>
    </tr>
</table>
<table>
    <tr>
        <td>
        <br>
        </td>
    </tr>
</table>
";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$html="";
$html = "
<table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
    <tr>
        <th align=\"center\" bgcolor=\"#cccccc\">
            <b>Datos de la Rehabilitación</b>
        </th>
    </tr>
</table>
";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


for($j=1;$j<=$numrehab;$j++){
//while($numrehab>0){
//
//
/// Datos de la rehabilitación
$query="Select *,date_format(Rehab_fecha,'%Y-%m-%e')as fecha From Rehabilitacion Where Exp_folio='".$fol."' And Rehab_cons = ".$j;
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);

if($row==''){}
else{
$fecharehab=$row['fecha'];
$medicorehab=$row['Usu_Registro'];
$tiporehab=$row['Rehab_tipo'];
$dolorrehab=$row['Rehab_dolor'];
$mejoriarehab=$row['Rehab_mejoria'];
$observacionesrehab=$row['Rehab_obs'];
$duracionrehab=$row['Rehab_duracion'];
$citaantrehab=$row['Rehab_citaant'];
$unicverehab=$row['Uni_clave'];

$query="Select Uni_nombre as Nombre From Unidad Where Uni_clave=".$unicverehab;
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);
$unidadrehab=$row['Nombre'];

$query="Select Usu_nombre From Usuario Where Usu_login='".$medicorehab."'";
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);
$nombrerehab=$row['Usu_nombre'];

//****************************
$html="";
$html = "
<table border=\"1\" cellspacing=\"2\" cellpadding=\"3\">
    <tr>
         <td width=\"20%\">
             <b>FECHA:</b> ".$fecharehab."
         </td>
         <td width=\"40%\">
           <b>REHABILITADOR:</b> ".strtoupper(utf8_encode($nombrerehab))."
         </td>
         <td width=\"40%\">
           <b>TIPO DE TERAPIA:</b> ".strtoupper(utf8_encode($tiporehab))."
         </td>
    </tr>
    <tr>
         <td width=\"20%\">
             <b>NO. SESIÓN:</b> ".$j."
         </td>
         <td width=\"30%\">
           <b>ESCALA DE DOLOR:</b> ".$dolorrehab."
         </td>
         <td width=\"30%\">
           <b>ESCALA DE MEJORÍA:</b> ".$mejoriarehab."
         </td>
         <td width=\"20%\" >
            <b>DURACIÓN:</b>".strtoupper(utf8_encode($duracionrehab))."
         </td>
    </tr>
    <tr>
         
         <td width=\"70%\" colspan=\"2\">
            <b>OBSERVACIONES:</b> ".strtoupper(utf8_encode($observacionesrehab))."
         </td>
         <td width=\"30%\">
            <b>ACUDIO A CITA ANTERIOR:</b>".strtoupper(utf8_encode($citaantrehab))."
         </td>
    </tr>
    <tr>
        <td colspan=\"3\">
            <b>UNIDAD DE ATENCIÓN:</b>".strtoupper(utf8_encode($unidadrehab))."
        </td>
    </tr>
</table>
<table>
    <tr>
        <td>
        <br>
        </td>
    </tr>
</table>
";
if($j==5 || $j==10 || $j==15 || $j==20){

    $html.= "
<table border=\"1\" cellspacing=\"1\" cellpadding=\"2\">
    <tr>
         <td width=\"50%\" align=\"center\">
             <br><br><br><br><br><br>
             <br><b>_____________________________________________________</b>
             <br><b>Firma del Rehabilitador al Concluir la Terapia</b>
         </td>
         <td width=\"50%\" align=\"center\">
            <br><br><br><br><br><br>
            <br><b>_____________________________________________________</b>
            <br><b>Firma del Paciente al Concluir la Terapia</b>
         </td>
    </tr>
</table>
";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
if($j<$numrehab){
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
<table>
    <tr>
        <td>
        <br>
        </td>
    </tr>
</table>
";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

//****************************
$html="";
$html = "
<table border=\"1\" cellspacing=\"2\" cellpadding=\"3\">
    <tr>
        <th align=\"center\" colspan=\"2\" bgcolor=\"#cccccc\">
            <b>Datos de la Solicitud de Rehabilitación</b>
        </th>
    </tr>
    <tr>
         <td width=\"70%\">
             <b>DIAGNÓSTICO CON EL QUE SE ENVIÓ A TERAPIA:</b>  ".strtoupper(utf8_encode($diagnosticopase))."
         </td>
         <td width=\"30%\">
           <b>NÚMERO DE SESIONES PREVIAS:</b> ".($numrehab-1)."
         </td>
    </tr>
    <tr>
         <td width=\"70%\">
             <b>MÉDICO QUE ENVÍA A TERAPIA:</b>  ".strtoupper(utf8_encode($NombreMedico))."
         </td>
         <td width=\"30%\" align=\"center\">
           <br><br><br><br><b>________________________________</b><br>
           FIRMA DEL MEDICO QUE ENVÍA A TERAPIA
         </td>
    </tr>
</table>
<table>
    <tr>
        <td>
        <br>
        </td>
    </tr>
</table>
";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
}
}else{
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
}
//$numrehab--;
}
}

//****************************
$html="";
if($numrehab!=5&&$numrehab!=10&&$numrehab!=15&&$numrehab!=20&&$numrehab!=25){
$html = "
<table border=\"1\" cellspacing=\"1\" cellpadding=\"2\">
    <tr>
         <td width=\"50%\" align=\"center\">
             <br><br><br><br><br><br>
             <br><b>_____________________________________________________</b>
             <br><b>Firma del Rehabilitador al Concluir la Terapia</b>
         </td>
         <td width=\"50%\" align=\"center\">
            <br><br><br><br><br><br>
            <br><b>_____________________________________________________</b>
            <br><b>Firma del Paciente al Concluir la Terapia</b>
         </td>
    </tr>
</table>
";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
}

/*********************************      ademndums agregados *************************************************************/
$query1 = "select Exp_fecreg from Expediente where Exp_folio='".$fol."'";
$rs1=mysql_query($query1,$conn);
$row1=mysql_fetch_array($rs1);
$fechaAtencion = $row1['Exp_fecreg'];

$query="Select Addendum.*, Usuario.Usu_nombre  from Addendum
inner join Usuario on Addendum.Usu_reg = Usuario.Usu_login
where Exp_folio='".$fol."' and Add_tipoDoc=5";
$rs=mysql_query($query,$conn);
$fecha = date("Y-m-d H:i:s");

if($row=mysql_fetch_array($rs)){
$cont=1;
$pdf->AddPage();
        $html="
           <table  border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr><th bgcolor=\"#cccccc\">
                  <b>Addendum</b>
                </th>                
                <th align=\"right\" bgcolor=\"#cccccc\">
                  fecha atención: ".$fechaAtencion."<br>
                  fecha impresión: ".$fecha."
                </th>
           </tr>";

                  do{
                     $html.="<tr>
                                  <td colspan=\"2\">
                                    <table>
                                      <tr>
                                        <th colspan=\"3\"  bgcolor=\"#e6e6e6\">
                                            Addendum #".$cont." <br>
                                            <small>login: ".$row['Usu_reg']."</small>
                                        </th>
                                        <th colspan=\"2\" align=\"right\"  bgcolor=\"#e6e6e6\">
                                            fecha: ".$row['Add_fecha']."
                                        </th>
                                      </tr>
                                      <tr>
                                        <td colspan=\"5\">
                                         <b>".utf8_encode($row['Add_comentario'])."</b>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td colspan=\"5\" align=\"center\">
                                        <br><br>Firma<br><br><br>
                                        __________________________________________<br>

                                         ".utf8_encode($row['Usu_nombre'])."
                                        </td>
                                      </tr>
                                    </table>
                                  </td>                                              
                             </tr>"; 
                             $cont++;                    
                 }while($row = mysql_fetch_array($rs));
        $html.=" </table>";  
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
}



/*********************************        fin de addendums agregados **************************************************/

/*********************************          formato de cuestionario de rehabilitación             *********************/
if($numrehab==5||$numrehab==10||$numrehab==15||$numrehab==20||$numrehab==25){
include 'cuestionarioRehabilitacion.php';
}

/*********************************        fin  formato de cuestionario de rehabilitación             *********************/

//****************************
$year=$ano;
$mont=$mes;

$pdf->output("FR_".$fol.".pdf",'D');
     
?>


