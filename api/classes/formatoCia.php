<?php
require "pac_vars.inc";//con
require 'tcpdf.php';
require 'config/lang/eng.php';

$fol=$_GET['fol'];

////// datos del Expediente
//$query="Select Exp_nombre, Exp_paterno, Exp_materno, Exp_fechaNac, Exp_edad, Exp_meses, Exp_sexo, Rel_clave, Ocu_clave, Edo_clave, Exp_mail, Exp_telefono, Cia_clave, Exp_fecreg, Uni_clave From Expediente Where Exp_folio='".$fol."'";
$query="Select Exp_nombre, Exp_paterno, Exp_materno, Exp_fechaNac, Exp_edad, Exp_meses, Exp_sexo, Rel_clave, Ocu_clave, Edo_clave, Exp_mail, Exp_telefono, Cia_clave, Exp_fecreg, Uni_clave From Expediente Where Exp_cancelado=0 and Exp_folio='".$fol."'";
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
$Fecreg      =$row['Exp_fecreg'];
$UniClave    =$row['Uni_clave'];

$NombreCompleto= $Nombre." ".$Paterno." ".$Materno;
list($fecha,$hora)= explode(" ", $Fecreg);
list($ano,$mes,$dia)= explode("-",$fecha);

///// Datos de la Unidad

$query="Select Uni_calleNum, Uni_colMun, Uni_tel From Unidad Where Uni_clave=".$UniClave;
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);
$calleNum   =$row['Uni_calleNum'];
$colMun     =$row['Uni_colMun'];
$tel        =$row['Uni_tel'];


          ////////////////////////////////////////////////////////////////////////////////////////////
          ////////////          PDF Con tcpdf                                               //////////
          ////////////                                                                     ///////////
          ////////////////////////////////////////////////////////////////////////////////////////////

          // Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		// Logo
		$image_file = '../../imgs/logos/mv.jpg';
		$this->Image($image_file, 10, 10, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                $image_file ="../../imgs/logos/aba.jpg";
		$this->Image($image_file, 155, 10, 39, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
                $this->Ln(4);
		$this->SetFont('helvetica', 'B', 14);
		// Title
                $this->Cell(0, 10, 'Constancia de Servicio Médico', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
                $this->Ln(8);
                //$this->SetFont('helvetica', 'B', 10);
                // $this->Cell(0, 15, 'Folio Asignado:'.$_SESSION['FOLIO'], 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                 $this->SetFont('helvetica', 'B', 10);
                 //$this->Cell(0, 15,"Fecha:".date('d'.'/'.'m'.'/'.'Y')." "."Hora:".date('g'.':'.'i'.' '.'A'), 0, false, 'R', 0, '', 0, false, 'M', 'M');
                 $this->Cell(0, 20,"Fecha:".date('d'.'-'.'m'.'-'.'Y'), 0, false, 'R', 0, '', 0, false, 'M', 'M');
           	}
	// Page footer
	public function Footer() {
            global $calleNum;
            global $colMun;
            global $tel;
		// Position at 15 mm from bottom
		$this->SetY(-25);
		// Set font
		$this->SetFont('helvetica', 'I', 10);
		// Page number
                  $this->Cell($w, $h, 'Dirección: '.utf8_encode($calleNum)." ".utf8_encode($colMun), $border, $ln=1, 'C');
                  $this->Cell($w, $h, 'Telefono: '.$tel, $border, $ln=1, 'C');
               $this->SetFont('helvetica', 'I', 8);
                 $this->Ln(4);
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
$pdf->SetFont('helvetica', '', 8, '', true);
// Add a page
// This method has several options, check the source code documentation for more information.
////// Comienza formato
$pdf->AddPage();
$pdf->Ln(8);
$pdf->SetFont('helvetica', 'B', 10, '', true);
$pdf->Cell(0, 10,"A QUIEN CORRESPONDA:", 0, 1, 'L', 0, '', 0, false, 'M', 'M');
$pdf->Ln(2);
$pdf->SetFont('helvetica', '', 8, '', true);
////// Primer parrafo
$html = "
<table align=\"Justyfi\">
    <tr>
        <td>
        Por medio de la presente, se hace constar que el Sr.(a) <u>".$NombreCompleto."</u> fue atendido(a) en esta Unidad el día <u>".$dia."-".$mes."-".$ano."</u>,
                 debido al accidente ocurrido el día <u>".$fecha."</u> el(la) paciente cuenta con los antecedentes de:
        </td>
    </tr>
</table>
";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";
$pdf->Ln(2);
////// Cronico degenerativos

   $query="SELECT Hist_clave, Pad_nombre, Pad_obs FROM HistoriaPadecimiento Inner Join Padecimientos on HistoriaPadecimiento.Pad_clave=Padecimientos.Pad_clave Where Exp_folio='".$fol."'";
    $rs=mysql_query($query,$conn);
    if($row = mysql_fetch_array($rs))
            {
   $html="<table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
            <tr>
                  <th colspan=\"2\" align=\"center\" bgcolor=\"#E2EFED\">
                           <b>Cronico-Degenerativos</b>
                   </th>
            </tr>
                  <tr>
                     <th width=\"20%\"><b>Enfermedad</b></th>
                     <th width=\"80%\"><b>Observaciones</b></th>
                  </tr>
                  ";
         do{
                   $html1="
                          <tr>
                              <td>".utf8_encode($row['Pad_nombre'])."</td>
                              <td>".utf8_encode($row['Pad_obs'])."</td>
                          </tr>
                        ";
                    $html1o=$html1o.$html1;
                } while ($row = mysql_fetch_array($rs));
                
                $html2="</table>";

$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html1o.$html2, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html1o=""; $html2=""; $htmlN="";
            }else{
                $html = "
<table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
    <tr>
        <th align=\"center\" bgcolor=\"#E2EFED\">
             <b>Cronico-Degenerativos</b>
        </th>
    </tr>
    <tr>
         <td>
               <b>Negados todos</b>
         </td>
    </tr>
</table>
";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
          }

   $query="SELECT Otr_nombre, HistOt_obs FROM HistoriaOtras Inner Join Otras on HistoriaOtras.Otr_clave=Otras.Otr_clave Where Exp_folio='".$fol."'";
    $rs=mysql_query($query,$conn);
    if($row=  mysql_fetch_array($rs))
        {
         $html="  <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
               <th colspan=\"2\" align=\"center\" bgcolor=\"#E2EFED\">
                    <b>Otras enfermedades</b>
               </th>
           </tr>
                  <tr>
                     <th width=\"20%\"><b>Enfermedad</b></th>
                     <th width=\"80%\"><b>Observaciones</b></th>
                  </tr>
          ";

           do{
              $html1="
                          <tr>
                              <td>".utf8_encode($row['Otr_nombre'])."</td>
                              <td>".utf8_encode($row['HistOt_obs'])."</td>
                          </tr>
                        ";
                $html1o=$html1o.$html1;

              }while($row=  mysql_fetch_array($rs));
          $html2="</table>";
          
          $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html1o.$html2, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
          $html=""; $html1=""; $html1o=""; $html2=""; $htmlN="";
        }else{
                $html = "
<table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
    <tr>
        <th align=\"center\" bgcolor=\"#E2EFED\">
             <b>Otras enfermedades</b>
        </th>
    </tr>
    <tr>
         <td>
               <b>Negadas todas</b>
         </td>
    </tr>
</table>
";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
          }

    $query="SELECT Ale_nombre, Ale_obs FROM HistoriaAlergias Inner Join Alergias on HistoriaAlergias.Ale_clave=Alergias.Ale_clave Where Exp_folio='".$fol."'";
    $rs=mysql_query($query,$conn);
    if($row=mysql_fetch_array($rs))
         {
            $html="  <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
               <th colspan=\"2\" align=\"center\" bgcolor=\"#E2EFED\">
                    <b>Alergias</b>
               </th>
           </tr>
                  <tr>
                     <th width=\"20%\"><b>Alergia</b></th>
                     <th width=\"80%\"><b>Observaciones</b></th>
                  </tr>
         ";
             do{
                 $html1="
                          <tr>
                              <td>".utf8_encode($row['Ale_nombre'])."</td>
                              <td>".utf8_encode($row['Ale_obs'])."</td>
                          </tr>
                        ";
                $html1o=$html1o.$html1;

               }while($row=  mysql_fetch_array($rs));

          $html2="</table>";
          $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html1o.$html2, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
          $html=""; $html1=""; $html1o=""; $html2=""; $htmlN="";
         }else{
                $html = "
<table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
    <tr>
        <th align=\"center\" bgcolor=\"#E2EFED\">
             <b>Alergias</b>
        </th>
    </tr>
    <tr>
         <td>
               <b>Negadas todas</b>
         </td>
    </tr>
</table>
";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
          }

$query="SELECT Esp_estatus, Esp_obs FROM HistoriaEspalda Where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
if($row= mysql_fetch_array($rs))
           {
            $html="  <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
               <th colspan=\"2\" align=\"center\" bgcolor=\"#E2EFED\">
                    <b>Padecimientos de Espalda</b>
               </th>
           </tr>
                  <tr>
                     <th width=\"20%\"><b>Padecimiento</b></th>
                     <th width=\"80%\"><b>Observaciones</b></th>
                  </tr>
           ";
                 do{
                      $html1="
                          <tr>
                              <td>".utf8_encode($row['Esp_estatus'])."</td>
                              <td>".utf8_encode($row['Esp_obs'])."</td>
                          </tr>
                        ";
                    $html1o=$html1o.$html1;

                   }while($row=mysql_fetch_array($rs));
            $html2="</table>";
          $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html1o.$html2, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
          $html=""; $html1=""; $html1o=""; $html2="";
           }else{
                $html = "
<table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
    <tr>
        <th align=\"center\" bgcolor=\"#E2EFED\">
             <b>Padecimientos de Espalda</b>
        </th>
    </tr>
    <tr>
         <td>
               <b>Negados todos</b>
         </td>
    </tr>
</table>
";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
          }
$query="SELECT HistO_estatus, HistO_obs FROM HistoriaOperacion Where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
if($row=  mysql_fetch_array($rs))
    {
    $html="
                <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
               <th colspan=\"2\" align=\"center\" bgcolor=\"#E2EFED\">
                    <b>Intervenciones Quirurgicas</b>
               </th>
           </tr>
                  <tr>
                     <th width=\"20%\"><b>Intervencion</b></th>
                     <th width=\"80%\"><b>Observaciones</b></th>
                  </tr>
        ";
       do{
           $html1="
                          <tr>
                              <td>".utf8_encode($row['HistO_estatus'])."</td>
                              <td>".utf8_encode($row['HistO_obs'])."</td>
                          </tr>
                        ";
                $html1o=$html1o.$html1;

         }while($row=  mysql_fetch_array($rs));
      $html2="</table>";
      $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html1o.$html2, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
      $html=""; $html1=""; $html1o=""; $html2="";
    }else{
                $html = "
<table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
    <tr>
        <th align=\"center\" bgcolor=\"#E2EFED\">
             <b>Intervenciones Quirurgicas</b>
        </th>
    </tr>
    <tr>
         <td>
               <b>Negadas todas</b>
         </td>
    </tr>
</table>
";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
          }

///// Segundo parrafo
$pdf->Ln(8);
$html = "
<table align=\"Justyfi\">
    <tr>
        <td>
        Y fue atendido(a) mediante exploración física y estudios de gabinete, de los cuales se da el siguiente <b>Diagnóstico:</b>
        </td>
    </tr>
</table>
";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";
$pdf->Ln(2);

$query="Select ObsNot_diagnosticoRx from ObsNotaMed where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
if($row=mysql_fetch_array($rs))
     {
             $html="
          <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
          <tr>
                 <td>".utf8_encode($row['ObsNot_diagnosticoRx'])."
                 </td>
          </tr>
         </table>";


// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html2=""; $html3="";
     }

///// tercer parrafo
$pdf->Ln(15);
$html = "
<table align=\"Justyfi\">
    <tr>
        <td>Cita abierta para valoración.<br/><br/>
        Atentamente:
        </td>
    </tr>
</table>
";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";

$pdf->Ln(15);

$html="
    <table>

    <tr>
        <td width=\"30%\">
        <b>Nombre y firma del Médico en turno: </b>
        </td>
         <td width=\"30%\">
        <hr>
        </td>
    </tr>
    <tr>
        <td>
        <b>Cedula profesional: </b>
        </td>
        <td width=\"30%\">
        <hr>
        </td>
    </tr>
   </table>
      ";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";






     $pdf->output("CM_".$fol.".pdf",'D');
?>
