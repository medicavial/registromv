<?php 
require 'tcpdf.php';
require 'config/lang/eng.php';
require "pac_vars.inc";

$fol         = $_GET['fol'];
$cveRec      = $_GET['cveRec'];
$query="SELECT * FROM reciboParticulares WHERE Exp_folio='".$fol."' and Recibo_cont=".$cveRec;
$res=mysql_query($query,$conn);
$row=mysql_fetch_array($res);

$fecha 		   = $row['Recibo_fecExp'];
$facPago     = $_GET['facPago'];
$usr         = $row['Usu_login'];

$medico      = $row['Recibo_doc'];
$tipoRecibo  = $row['Recibo_tipo'];
$query="Select Exp_completo, Exp_fecreg From Expediente where Exp_folio='".$fol."'";
$res=mysql_query($query,$conn);
$row=mysql_fetch_array($res);
$nombreLes=$row['Exp_completo'];
$fecRegistro= $row['Exp_fecreg'];
/*$query="Select Max(Recibo_cont)+1 as clave From reciboParticulares";
$res=mysql_query($query,$conn);
$row=mysql_fetch_array($res);
$cveRecibo=$row['clave'];*/
if($medico!=''){
$query="Select Med_nombre,Med_paterno, Med_materno, Med_cedula from Medico where Med_clave=".$medico;
$res=mysql_query($query,$conn);
$row=mysql_fetch_array($res);
$medNombre= $row['Med_nombre']." ".$row['Med_paterno']." ".$row['Med_materno'];
$medCedula= $row['Med_cedula'];
}
if($cveRecibo==''||$cveRecibo==NULL){$cveRecibo=100;}


$query="SELECT * FROM Item_particulares Where Exp_folio='".$fol."' and it_folRecibo=".$cveRec.";";
                              $rs=mysql_query($query,$conn);
                          $descuento=0;
                          $total=0;
                          if($row = mysql_fetch_array($rs)){

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
 
                $image_file = "../../imgs/logomv.jpg";
		$pdf->Image($image_file, 10, 10, 60, '', 'JPG', '', 'T', false, 400, '', false, false, 0, false, false, false);
		$pdf->Cell(0, 16,"Fecha:".date('d'.'/'.'m'.'/'.'Y'.' '.'H'.':'.'i'.':'.'s'), 0, 1, 'R', 0, '', 0, false, 'M', 'M');
		// Set font
         $pdf->Ln(20);
/////////////////////////////////////////////////////////////////



$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell($w, $h, $folio, $border, $ln=1, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->SetFont('dejavusans', '', 8, '', true);
$pdf->Cell($w, $h, "Usuario: ".utf8_encode($usr), $border, $ln=1, $align, $fill, $link, $stretch, $ignore_min_height);

if($tipoRecibo==1||$tipoRecibo==2){
  $pdf->SetFont('dejavusans', '', 12, '', true);
  $pdf->Cell($w, 16, "+ Beneficios", $border, $ln=1, 'R', $fill, $link, $stretch, $ignore_min_height);  
}
$pdf->SetFont('dejavusans', '', 8, '', true);
$html="";
$pdf->Ln(2);
$html="
      <table class=\"table\" border=\"1px\" style=\"border:1px solid #757575; padding:10px 10px 10px 10px;vertical-align:middle;\">
                    <tr>
                        <td style=\"width:60%;\">
                            Recibo No. <b>".$cveRec."</b>
                        </td>
                        <td style=\"width:40%;vertical-align:middle;\" align=\"center\" >
                           Folio MV. <b>".$fol."</b>
                        </td>
                    </tr> 
                    <tr>
                        <td colspan=\"2\" style=\"width:100%;\">
                           Paciente: <b>".utf8_encode($nombreLes)."</b>
                        </td>
                        
                    </tr>                    
                    <tr>
                        <td colspan=\"2\" style=\"width:100%\">
                            <i>Fecha de atenci&oacute;n: </i>
                            <b>".$fecRegistro."</b>
                        </td>                                           
                    </tr>                   
                    <tr>
                        <td colspan=\"3\" style=\"width:100%\">
                            <i>Items</i><br><br>
                           ";



                            /*********************************** llenamos de tabla de items*********************/


                          
                            $html.= '<input type="hidden" id="datosGuardados" name="datosGuardados" value="1">';    
                            $html.="<table id=\"TablaAlergias\" border=\"1px\"  width=\"100%\" style=\" border:1px solid #757575;padding:5px 10px 5px 10px;vertical-align:middle;\" >
                            <tr>                                
                                 <th width=\"15%\"><b>Clave registro</b></th>
                                 <th width=\"20%\"><b>Clave MV</b></th>
                                 <th width=\"30%\"><b>Producto</b></th>                                         
                                 <th width=\"15%\"><b>Descuento</b></th>         
                                 <th width=\"20%\"><b>Precio</b></th>         
                                
                            </tr>";
                            $precioMatCu=0;
                            do{
                              
                              $subtotal=$subtotal+$row['it_precio'];
                              $porcentaje=($row['it_descuento']*$row['it_precio'])/100;
                              $descuento = $descuento+$porcentaje;
                              $total = $subtotal - $descuento;  
                              if($row['Tip_clave']!=5){                            
                                  $html.= "  <tr>";                           
                                  $html.= "                <td  align=\"center\">".utf8_encode($row['It_codReg'])."</td>";
                                  $html.= "                <td>".utf8_encode($row['it_codMV'])."</td>"; 
                                  $html.= "                <td>".utf8_encode($row['it_prod'])."</td>";                                                         
                                  $html.= "                <td  align=\"center\">".utf8_encode($row['it_descuento'])."%</td>"; 
                                  $html.="                 <td  align=\"center\">".$row['it_precio']."</td>";                            
                                  $html.= " </tr>";
                              }else{
                                  $precioMatCu=$precioMatCu+$row['it_precio'];                                  
                              }
                              
                             }while($row = mysql_fetch_array($rs)); 
                             if($precioMatCu!=0){
                                  $html.= "  <tr>";                           
                                  $html.= "                <td  align=\"center\">430</td>";
                                  $html.= "                <td>CURA000001</td>"; 
                                  $html.= "                <td>Material de Curaci&oacute;n</td>";                                                         
                                  $html.= "                <td  align=\"center\">--</td>"; 
                                  $html.="                 <td  align=\"center\">".$precioMatCu."</td>";                            
                                  $html.= " </tr>";
                              } 
                            $html.= "  <tr>";
                            $html.="                 <td colspan=\"4\" align=\"right\">Subtotal</td>";
                            $html.= "                <td><b>$ ".$subtotal."</b></td><td></td>";
                            $html.= " </tr>";
                            $html.= "  <tr>";
                            $html.="                 <td colspan=\"4\" align=\"right\">Descuento</td>";
                            $html.= "                <td>$ ".$descuento."</td><td></td>";
                            $html.= " </tr>";
                            $html.= "  <tr>";
                            $html.="                 <td colspan=\"4\" align=\"right\">Importe Total</td>";
                            $html.= "                <td><b>$ ".$total."</b></td><td></td>";
                            $html.= " </tr>";
                            /*$V=new EnLetras();
                            $enLetras=$V->ValorEnLetras($total,"pesos");
                            $html.= "  <tr>";
                            $html.="                 <td colspan=\"4\">Importe con letra: <b>".$enLetras."</b></td>";                            
                            $html.= " </tr>";*/
                             $html.="</table>";

                           

                            /**************************** fin de llenado de tabla de items *********************/





                     $html.=" 
                        </td>                                        
                    </tr>                   
                </table>
";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$html="";

$pdf->Ln(20);

$html="
      <table border=\"0\">
             <tr>
                  <td width=\"40%\">
                    M&eacute;dico que atendi&oacute;: <b>".$medNombre."</b><br>
                    C&eacute;dula: <b>".$medCedula."</b>
                  </td>
             </tr>                
      </table>
     ";

$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$html="";

$pdf->Ln(20);
   $html="
          <table border=\"0\">

                 <tr>
                      <td width=\"40%\">
                        <hr />
                      </td>
                      <td width=\"20%\">
                      
                     </td>
                     <td width=\"40%\">
                      <hr />
                     </td>
                 </tr>
                 <tr>
                      <td width=\"40%\" align=\"center\">
                       Nombre y firma de Recepci&oacute;n
                      </td>
                      <td width=\"20%\" align=\"center\">
                       
                      </td>
                      <td width=\"40%\" align=\"center\">
                        Nombre y firma del Paciente
                      </td>
                 </tr>
          </table>
         ";

$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


$pdf->output("recibo.pdf",'D');

$query="SELECT * FROM reciboParticulares WHERE Exp_folio='".$fol."' and Recibo_cont=".$cveRec;
$res=mysql_query($query,$conn);
$row=mysql_fetch_array($res);
//echo $sql;
$rs=mysql_query($sql,$conn);

 }else{
  echo 'Error, no has capturado ning&uacute;n Item';
 }

?>
