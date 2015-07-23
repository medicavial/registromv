<?php
require "../validaUsuario.php";//con
require '../tcpdf.php';
require '../config/lang/eng.php';

$btnBuscar = $_SESSION["perBuscar"];
if ($btnBuscar !='S' ) header("Location:../lanzador.php?sinpermiso=1");

$_SESSION['FOLIO']=$fol;

$query= "Select Exp_folio, Exp_nombre, Exp_paterno, Exp_materno, Exp_siniestro, Exp_poliza, Exp_reporte, Exp_fecreg, Usu_registro, Exp_fecreg, USU_registro, Uni_nombre, Uni_propia
			From Expediente inner join Unidad on Expediente.UNI_clave=Unidad.UNI_clave
			where Exp_folio='".$fol."';";

	$rs = mysql_query($query,$conn);
	$row=mysql_fetch_array($rs);

		$compania	= $row["Cia_nombrecorto"];
		$nombre		= $row["Exp_nombre"];
		$paterno	= $row["Exp_paterno"];
		$materno	= $row["Exp_materno"];
		$siniestro	= $row["Exp_siniestro"];
		$poliza		= $row["Exp_poliza"];
		$reporte	= $row["Exp_reporte"];
		$obs		= $row["Exp_obs"];
		$folio		= $row["Exp_folio"];
		$unidad		= $row["Uni_nombre"];
		$fechahora	= $row["Exp_fecreg"];
		$usuario	= $row["Usu_registro"];
                $propia         = $row["Uni_propia"];

                $dir='codigos/'.$fol.'.png';

		$cadena=$compania.$nombre.$paterno.$materno.$siniestro.$poliza.$reporte.$obs.$folio.$unidad.$fechahora.$usuario.'MV';
		$cadena=md5($cadena);

	$fechafac = date ("d-m-Y");
         $hora     = date("g:i a");


         ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
         ///////////////////////////////////                       PDF                      /////////////////////////////
         ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

         class MYPDF extends TCPDF {
	//Page header
	public function Header() {
            /*
		// Logo
                $image_file = K_PATH_IMAGES.'mv.jpg';
		$this->Image($image_file, 160, 10, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                $image_file = "../imgs/logos/aba.jpg";
		$this->Image($image_file, 10, 10, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
                $this->Ln(15);
		$this->SetFont('helvetica', 'B', 12);
		// Title
                $this->Cell(0, 10, 'Encuesta de calidad', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
                //$this->SetFont('helvetica', 'B', 10);
                //$this->Cell(0, 15, 'Folio Asignado:'.$_SESSION['FOLIO'], 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                //$this->SetFont('helvetica', 'B', 8);
                $this->SetFont('helvetica', 'B', 8);
                 $this->Cell(0, 10,"Fecha:".date('d'.'/'.'m'.'/'.'Y')." "."Hora:".date('g'.':'.'i'.' '.'A'), 0, 1, 'R', 0, '', 0, false, 'M', 'M');
             * 
             */
           	}
	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		//$this->SetY(-20);
		// Set font
		//$this->SetFont('helvetica', 'I', 8);
		// Page number
		//$this->Cell(0, 10, 'Pagina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	      }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
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

/////////////////////////////////////////////////////////////////
 $image_file = K_PATH_IMAGES.'mv.jpg';
		$pdf->Image($image_file, 160, 10, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                $image_file = "../imgs/logos/inbursa.jpg";
		$pdf->Image($image_file, 10, 10, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
                $pdf->Ln(15);
		$pdf->SetFont('helvetica', 'B', 12);
		// Title
                $pdf->Cell(0, 10, 'Encuesta de calidad', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->Cell(0, 15, 'Folio Asignado:'.$_SESSION['FOLIO'], 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                $pdf->SetFont('helvetica', 'B', 8);
                $pdf->SetFont('helvetica', 'B', 8);
                $pdf->Cell(0, 10,"Fecha:".date('d'.'/'.'m'.'/'.'Y')." "."Hora:".date('g'.':'.'i'.' '.'A'), 0, 1, 'R', 0, '', 0, false, 'M', 'M');
/////////////////////////////////////////////////////////////////

$image_file = "../codigos/".$fol.".png";
$pdf->Image($image_file, 90, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->Ln(25);

$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell($w, $h, "Paciente: ".$folio." - ".$nombre." ".$paterno." ".$materno." ", $border, $ln=1, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->SetFont('dejavusans', '', 8, '', true);
$pdf->Ln(5);
$pdf->Cell($w=45, $h, "Siniestro: ".$siniestro, $border, $ln=0, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->Cell($w=45, $h, "Póliza: ".$poliza, $border, $ln=0, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->Cell($w=45, $h, "Reporte: ".$reporte, $border, $ln=1, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->Ln(5);
$pdf->Cell($w, $h, "Estimado Paciente:", $border, $ln, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->Ln(5);
$pdf->Cell($w, $h, "Con el propósito de conocer su opinión acerca del servico médico ofrecido, le agradeceremos contestar el siguiente cuestionario.", $border, $ln=1, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->Ln(5);
$pdf->Cell($w=119, $h, "Acude a esta unidad médica:", $border, $ln=0, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->Cell($w=27, $h, "en ambulacia (   )", $border, $ln=0, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->Cell($w=20, $h, "por sus propios medios (   )", $border, $ln=1, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->Ln(5);
$pdf->Cell($w, $h, "Coloque una 'X' en la columna que mejor refleje el nivel de satisfacción que obtuvo en cada uno de los siguientes aspectos:", $border, $ln=1, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->Ln(5);

$html="
    <table cellspacing=\"2\" cellpadding=\"3\">
           <tr>
                <th   align=\"center\" width=\"50%\">
                </th>
                <th valing=\"middle\" align=\"center\" bgcolor=\"#cccccc\" width=\"10%\"><b>Excelente</b>
                </th>
                <th valing=\"middle\" align=\"center\" bgcolor=\"#cccccc\" width=\"10%\">
                <b>Bueno</b>
                </th>
                <th valing=\"middle\" align=\"center\" bgcolor=\"#cccccc\" width=\"10%\">
                <b>Regular</b>
                </th>
                <th valing=\"middle\"  align=\"center\" bgcolor=\"#cccccc\" width=\"10%\">
                <b>Malo</b>
                </th>
                <th valing=\"middle\" align=\"center\" bgcolor=\"#cccccc\" width=\"10%\">
                <b>No aplica</b>
                </th>
           </tr>
                      <tr>
           <td bgcolor=\"#E2EFED\">Independiente de esta atención médica.¿La asesoría proporcionada por el Ajustador fue?</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           </tr>

           <tr>
           <td>¿El trato del Personal de Recepción fue?</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           </tr>
           <tr>
           <td bgcolor=\"#E2EFED\">¿La rapidez con que le atendieron a su llegada fue?</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(   )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(   )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(   )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(   )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(   )</td>
           </tr>
           <tr>
           <td >¿En cuestión de comodidad, iluminación, limpieza las instalaciones son?</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           </tr>
           <tr>
           <td bgcolor=\"#E2EFED\">¿La presentación del médico que le atendió fue?</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           </tr>
           <tr>
           <td >¿El trato del médico que le atendió. Usted lo calificaría como?</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           </tr>
           <tr>
           <td bgcolor=\"#E2EFED\">¿La información proporcionada de su padecimiento y tratamiento por el médico tratante fue?</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           </tr>
           <tr>
           <td >¿Los servicios de Rayos X fueron?</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           </tr>
           <tr>
           <td bgcolor=\"#E2EFED\">¿Los servicios de Rehabilitación fueron?</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           </tr>
           <tr>
           <td >¿En general, el servicio ofrecido por MÉDICAVIAL fue?</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           </tr>
      </table>
     ";

$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";
$pdf->Ln(2);


$html="
      <table border=\"1\" cellspacing=\"2\" cellpadding=\"3\">
            <tr>
                    <th valing=\"middle\"  align=\"center\" bgcolor=\"#cccccc\" >
                    Agredecemos sus comentarios para mejorar nuestro servicio en atención a usted:
                    </th>
            </tr>
            <tr>
                  <td height=\"80px\">
                  </td>
            </tr>
      </table>
";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";

$html="
   <table border=\"1\" cellspacing=\"2\" cellpadding=\"3\">
            <tr>
                    <th valing=\"middle\" colspan=\"4\" align=\"center\" bgcolor=\"#cccccc\" >
                        Contacto
                    </th>
            </tr>
            <tr>
                   <td colspan=\"2\">
                 <b>Teléfono móvil: </b>
                   </td>
                   <td colspan=\"2\">
                   <b>Teléfono particular: </b>
                   </td>
           </tr>
           <tr>
                   <td colspan=\"2\">
                   <b>Teléfono oficina: </b>
                   </td>
                   <td colspan=\"2\">
                   <b>Correo Electrónico: </b>
                   </td>
            </tr>
            <tr>
                   <td colspan=\"4\" height=\"40px\">
                   <b>Dirección: </b>
                   </td>
            </tr>
            </table>
";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";


$pdf->Ln(20);
   $html="
          <table border=\"0\"  width=\"400\">
                 <tr>
                      <td width=\"30%\">

                      </td>
                      <td width=\"40%\">
                      <hr />
                     </td>
                     <td width=\"30%\">

                     </td>
                 </tr>
                 <tr>
                      <td width=\"30%\" align=\"center\">

                      </td>
                      <td width=\"40%\" align=\"center\">
                       Firma del Paciente
                      </td>
                      <td width=\"30%\" align=\"center\">

                      </td>
                 </tr>
          </table>
         ";

$pdf->writeHTMLCell($w=0, $h=0, $x='42', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


        $pdf->output("cuest1_".$_SESSION["FOLIO"].".pdf",'D');



?>
