<?php


$query= "Select Exp_folio, Exp_nombre, Exp_paterno, Exp_materno, Exp_siniestro, Exp_poliza, Exp_reporte, Exp_fecreg, Usu_registro, Exp_fecreg, USU_registro, Uni_nombrecorto, Uni_propia
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
		$unidad		= $row["Uni_nombrecorto"];
		$fechahora	= $row["Exp_fecreg"];
		$usuario	= $row["Usu_registro"];
                $propia         = $row["Uni_propia"];

                $dir='codigos/'.$fol.'.png';

		$cadena=$compania.$nombre.$paterno.$materno.$siniestro.$poliza.$reporte.$obs.$folio.$unidad.$fechahora.$usuario.'MV';
		$cadena=md5($cadena);

	$fechafac = date ("d-m-Y");
         $hora     = date("g:i a");
$query="select Usu_nombre from Usuario where Usu_login='".$usr."'";
$rs = mysql_query($query,$conn);
$row=mysql_fetch_array($rs);
$rehabilitador=$row['Usu_nombre'];
        
$pdf->AddPage();

/////////////////////////////////////////////////////////////////
///// código de barras creado en el pdf

                $image_file = '../../imgs/logomv.jpg';
		$pdf->Image($image_file, 10, 10, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
                $pdf->Ln(25);
		$pdf->SetFont('helvetica', 'B', 12);
		// Title
                $pdf->Cell(0, 10, 'Cuestionario de atención en el área de rehabilitación', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
                              
                $pdf->SetFont('helvetica', 'B', 8);
                $pdf->Cell(0, 10,"Fecha:".date('d'.'/'.'m'.'/'.'Y')." "."Hora:".date('g'.':'.'i'.' '.'A'), 0, 1, 'R', 0, '', 0, false, 'M', 'M');
/////////////////////////////////////////////////////////////////

/*$image_file = "../codigos/".$fol.".png";
$pdf->Image($image_file, 90, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->Ln(25);
*/
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell($w, $h, "Paciente: ".$folio." - ".$nombre." ".$paterno." ".$materno." ", $border, $ln=1, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->SetFont('dejavusans', '', 8, '', true);
$pdf->Ln(5);
$pdf->Cell($w=45, $h, "Siniestro: ".$siniestro, $border, $ln=0, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->Cell($w=45, $h, "Póliza: ".$poliza, $border, $ln=0, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->Cell($w=45, $h, "Reporte: ".$reporte, $border, $ln=1, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->Ln(5);
$pdf->Cell($w, $h, "Estimado Paciente:", $border, $ln, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->Ln(5);
$pdf->Cell($w, $h, "Con el propósito de conocer su opinión acerca del servico ofrecido en sus sesiones de Rehabilitación, le agradeceremos", $border, $ln=1, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->Ln(1);
$pdf->Cell($w, $h, "contestar el siguiente cuestionario.", $border, $ln=1, $align, $fill, $link, $stretch, $ignore_min_height);
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
           <td bgcolor=\"#E2EFED\">El trato del personal Médico fue:</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           </tr>

           <tr>
           <td>La puntualidad con que le atendieron a su llegada fue:</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           </tr>
           <tr>
           <td bgcolor=\"#E2EFED\">En cuestión de comodidad, limpieza y equipo utilizado en su tratamiento, su opinión es:</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(   )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(   )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(   )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(   )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(   )</td>
           </tr>
           <tr>
           <td >La presentación del rehabilitador que le atendió fue:</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           </tr>
           <tr>
           <td bgcolor=\"#E2EFED\">El trato del rehabilitador que le atendió fue:</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           </tr>
           <tr>
           <td >la información proporcionada sobre su tratamiento fue:</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           <td align=\"center\" >(    )</td>
           </tr>
           <tr>
           <td bgcolor=\"#E2EFED\">En general el servicio de rehabilitación ofrecido por MÉDICA VIAL fue:</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           <td align=\"center\" bgcolor=\"#E2EFED\">(    )</td>
           </tr>   
           <tr>
           <td></td>
           
           </tr>   
           <tr>
           <td colspan=\"6\">Rehabilitador(a): <b>".utf8_encode($rehabilitador)." </b></td>
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

?>