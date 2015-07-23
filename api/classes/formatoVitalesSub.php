<?php
require "pac_vars.inc";
require 'tcpdf.php';
require 'config/lang/eng.php';

////////// Datos del Expediente/////

$fol= $_GET['fol'];
$sub= $_GET['sub'];
$query="Select Exp_nombre, Exp_paterno, Exp_materno, Exp_fechaNac, Exp_edad, Exp_meses, Exp_sexo, Rel_clave, Ocu_clave, Edo_clave, Exp_mail, Exp_telefono From Expediente Where Exp_cancelado=0 and Exp_folio='".$fol."'";
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

          ////////////////////////////////////////////////////////////////////////////////////////////
          ////////////          PDF Con tcpdf                                               //////////
          ////////////                                                                     ///////////
          ////////////////////////////////////////////////////////////////////////////////////////////

          // Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
     global $fol;
     global $sub;
		// Logo
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
	        $image_file = '../../imgs/logomv.jpg';
		$this->Image($image_file, 10, 10, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                /*$image_file = K_PATH_IMAGES.$fol.'.png';
		$this->Image($image_file, 90, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);*/
		// Set font
		$this->SetFont('helvetica', 'B', 14);
		// Title
                $this->Cell(0, 15, 'SV - Subsecuencia #'.$sub, 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                $this->SetFont('helvetica', 'B', 10);
                 $this->Cell(0, 15, 'Folio Asignado:'.$fol, 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                 $this->SetFont('helvetica', 'B', 8);
                 $this->Cell(0, 15,"Fecha:".date('d'.'/'.'m'.'/'.'Y')." "."Hora:".date('g'.':'.'i'.' '.'A'), 0, false, 'R', 0, '', 0, false, 'M', 'M');
           	}
	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-20);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Pagina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
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
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
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
           <b>E-Mail:</b>".$Mail."</td>
   </tr>
</table>
";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";

$pdf->Ln(5);

$query="Select VitSub_temperatura, VitSub_talla, VitSub_peso, VitSub_ta, VitSub_fc, VitSub_fr , VitSub_imc , VitSub_observaciones, VitSub_fecha, Usu_registro, IMC_categoria, IMC_comentario From VitalesSub  Inner Join IMC on IMC.IMC_clave=VitalesSub.IMC_clave  Where Exp_folio='".$fol."' and VitSub_subCons=".$sub;

$rs= mysql_query($query,$conn);

      while($row =  mysql_fetch_array($rs)){
$html=" <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
          <tr>
                <td bgcolor=\"#cccccc\" align=\"center\" colspan=\"6\"><b>Fecha:".$row["VitSub_fecha"]."</b></td>
          </tr>
    <tr>
               <td align=\"center\"><b>Temperatura</b></td>
               <td align=\"center\"><b>Talla</b></td>
               <td align=\"center\"><b>Peso</b></td>
               <td align=\"center\"><b>Presion arterial</b></td>
               <td align=\"center\"><b>Frecuencia cardiaca</b></td>
               <td align=\"center\"><b>Frecuencia respiratoria</b></td>
    </tr>
           <tr>
                      <td align=\"center\">".$row["VitSub_temperatura"]."</td>
                      <td align=\"center\">".$row["VitSub_talla"]."</td>
                      <td align=\"center\">".$row["VitSub_peso"]."</td>
                      <td align=\"center\">".$row["VitSub_ta"]."</td>
                      <td align=\"center\">".$row["VitSub_fc"]."</td>
                      <td align=\"center\">".$row["VitSub_fr"]."</td>
          </tr>

          <tr>
                      <td align=\"center\"><b>IMC</b></td>
                      <td align=\"center\"><b>Categoria</b></td>
                      <td align=\"center\" colspan=\"4\"><b>Comentario *(IMC)</b></td>
          </tr>

          <tr>
                      <td align=\"center\">".$row["VitSub_imc"]."</td>
                      <td align=\"center\">".utf8_encode($row["IMC_categoria"])."</td>
                      <td align=\"justify\" colspan=\"4\">".utf8_encode($row["IMC_comentario"])."</td>
          </tr>


          <tr>
                     <td><b>Observaciones:</b></td>
                     <td colspan=\"5\" align=\"justify\">".utf8_encode($row["VitSub_observaciones"])."</td>
          </tr>

 </table>";

$html1= $html1.$html;
      }


      $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html1, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html1="";

$pdf->output("SV_".$fol.".pdf",'D');

?>

