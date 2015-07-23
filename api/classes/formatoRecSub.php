<?php
require "pac_vars.inc";//con
require 'tcpdf.php';
require 'config/lang/eng.php';

$fol=$_GET['fol'];
$usr=$_GET['usr'];

/*****************  insercion de subsecuenica  ********************************/      
$query="Select Max(Sub_cons) As Cons From Subsecuencia Where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);

$Subcons= $row["Cons"];
$fecha=date('Y-m-d');
$hora=date('g:i:A');

$query="Insert Into RecetaSub(Exp_folio, Sub_cons, RecSub_fecha, RecSub_hora, Usu_login)
                       Values('".$fol."', ".$Subcons.", '".$fecha."', '".$hora."', '".$usr."')";
$rs=mysql_query($query,$conn);

/*********************     fin de insercion de subsecuencia *******************/

$query="Select Uni_clave From Usuario Where Usu_login='".$usr."'";
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);
$Uni= $row["Uni_clave"];

$query= "Select Exp_folio, Exp_nombre, Exp_paterno, Exp_materno,Exp_sexo,Exp_edad, Exp_siniestro, Exp_poliza, Exp_reporte, Exp_fecreg, Usu_registro, Exp_fecreg, USU_registro, Uni_nombre, Uni_propia
			From Expediente       
      inner join Unidad on Expediente.UNI_clave=Unidad.UNI_clave
			where Exp_folio='".$fol."';";

	$rs = mysql_query($query,$conn);
	$row=mysql_fetch_array($rs);

		$compania	= $row["Cia_nombrecorto"];
		$nombre		= $row["Exp_nombre"];
		$paterno	= $row["Exp_paterno"];
		$materno	= $row["Exp_materno"];
    $sexo     = $row["Exp_sexo"];
    $edad     = $row["Exp_edad"];
		$siniestro	= $row["Exp_siniestro"];
		$poliza		= $row["Exp_poliza"];
		$reporte	= $row["Exp_reporte"];
		$obs		= $row["Exp_obs"];
		$folio		= $row["Exp_folio"];
		$unidad		= $row["Uni_nombre"];
		$fechahora	= $row["Exp_fecreg"];
		$usuario	= $row["Usu_registro"];
    $propia         = $row["Uni_propia"];

    if($sexo=='M') $sexo='Masculino';
    elseif($sexo=='F') $sexo = 'Femenino';
    else $sexo ='--';

                $dir='../codigos/'.$fol.'.png';


    $query= "Select Vit_talla, Vit_peso, Vit_temperatura, Vit_ta
      From Vitales           
      where Exp_folio='".$fol."';";
    $rs = mysql_query($query,$conn);
    $row=mysql_fetch_array($rs);

    $talla=$row["Vit_talla"];
    $peso=$row["Vit_peso"];
    $temperatura=$row["Vit_temperatura"];
    $ta=$row["Vit_ta"];
    $lista='';
    $query="select Ale_nombre from HistoriaAlergias inner join Alergias on HistoriaAlergias.Ale_clave=Alergias.Ale_clave where HistoriaAlergias.Exp_folio='".$fol."'";
    $rs = mysql_query($query,$conn);
    if($row= mysql_fetch_assoc($rs)){
      do{
       if($lista==''){
            $lista=$row['Ale_nombre'];
        }else{
            $lista.=', '.$row['Ale_nombre'];
        }   
      }while($row= mysql_fetch_array($rs));
    }else{
      $lista='negó alergias';
    }

    

	$fechafac = date ("d-m-Y");
         $hora     = date("g:i a");

    $fechaConv=str_replace('-', '', $fechafac);
$cadena=$fechaConv."||"."900001".'||'.$usr.'||'.$fol.'||'.'654+5456';

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
$pdf->SetMargins(10, 20, 10);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//set auto page breaks
$pdf->SetAutoPageBreak(FALSE, 0);
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
                $image_file = "../../imgs/logos/mv.jpg";
		$pdf->Image($image_file, 5, 5, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
                 

                $pdf->Ln(3);
		            $pdf->SetFont('helvetica', 'B', 20);
                $pdf->Cell(0, 10, 'Receta Médica', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
                $pdf->Ln(3);
                $pdf->SetFont('helvetica', 'B', 9);
                $pdf->Cell(0, 10, "Fecha:".date('d'.'/'.'m'.'/'.'Y')." "."Hora:".date('g'.':'.'i'.' '.'A'), 0, 1, 'C', 0, '', 0, false, 'M', 'M');                
                $pdf->SetFont('helvetica', 'B', 9);
                $pdf->Cell(0, 15, "RECETA ID:".$fol, 0, 1, 'C', 0, '', 0, false, 'M', 'M');                

         $pdf->write2DBarcode($cadena, 'QRCODE,L', 170, 3, 50, 50, '', 'N');         

/////////////////////////////////////////////////////////////////


$pdf->Ln(5);

$pdf->SetFont('helvetica', '', 10);
$pdf->Cell($w=100, $h, "Paciente: ".$nombre." ".$paterno." ".$materno." ", $border, $ln=0, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->Cell($w=45, $h, "Genero: ".$sexo, $border, $ln=0, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->Cell($w=55, $h, "Edad: ".$edad." años", $border, $ln=1, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->SetFont('dejavusans', '', 8, '', true);
$pdf->Ln(3);

$pdf->SetFont('helvetica', '', 10);
$pdf->Cell($w=45, $h, "Talla: ".$talla." cm.", $ln=0, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->Cell($w=55, $h, "Peso: ".$peso." kg ", $border, $ln=0, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->Cell($w=45, $h, "Temperatura: ".$temperatura." °C. ", $border, $ln=0, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->Cell($w=55, $h, "Presión arterial: ".$ta, $border, $ln=1, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->Ln(6);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell($w=65, $h, "Folio MV:", $ln=0, $align, $fill, $link, $stretch, $ignore_min_height);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell($w=50, $h, "Alergias: ".$lista, $ln=0, '', false, '',1, 'T');
$image_file = $dir;
$pdf->Image($image_file, 28, 52, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->Ln(14);
$pdf->SetFont('helvetica', '', 8);

$inicio=80;
$tamImg=120;
$linea=125;
$html="
    <table cellpadding=\"2\">
           <tr cellspacing=\"2\" >             
                <th bordercolor=\"#FFFFFF\" colspan=\"5\" bgcolor=\"#f2f0f0\" width=\"100%\" style=\"font-size:40px\"><b>Datos de la Receta</b>
                </th>
               
           </tr>
            <tr>
           <td align=\"center\" style=\"width:10%\" bgcolor=\"#dce4f9\">Clave</td>
           <td align=\"center\" style=\"width:10%\" bgcolor=\"#dce4f9\">Autorizacion</td>
           <td align=\"center\" style=\"width:10%\" bgcolor=\"#dce4f9\">Cantidad</td>
           <td  style=\"width:55%\" bgcolor=\"#dce4f9\">Medicamento (sustancia activa y presentación)</td>
           <td align=\"center\" style=\"width:15%\" bgcolor=\"#dce4f9\">Forma farmacéutica</td>           
           </tr>";
           $query="SELECT Sum_clave as clave, Subsum_cantidad as cantidad, Sym_denominacion as sustancia, Sym_medicamento as medicamento, Sym_presentacion as susActiva, Sym_forma_far as presentacion, Subsum_obs as posologia  FROM SubSuministros 
            inner Join SymioCuadroBasico on SymioCuadroBasico.Clave_producto =SubSuministros.Sum_clave
             Where Exp_folio='".$fol."' and Sub_cons=".$Subcons;
            $rs = mysql_query($query,$conn);

           if($row= mysql_fetch_assoc($rs)){
              do{
               $html.= "<tr>              
               <td align=\"center\" >".utf8_encode($row['clave'])."</td>
               <td >No requiere</td>
               <td align=\"center\" >".utf8_encode($row['cantidad'])."</td>
               <td >".utf8_encode($row['medicamento'])." (".utf8_encode($row['sustancia'])." - ".utf8_encode($row['susActiva']).")</td>
               <td align=\"center\" >".utf8_encode($row['presentacion'])."</td>
               </tr>
                <tr>              
               <td ></td>
               <td colspan=\"4\"><b>Indicaciones: </b>".utf8_encode($row['posologia'])."</td>               
               </tr>
              <hr>";
              $inicio=$inicio+11;
              $tamImg=$tamImg-13;
              $linea= $linea -12; 
              }while($row= mysql_fetch_array($rs));
          }else{
              $query="select * from NotaSuministroAlternativa where Exp_folio='".$fol."'";
              $rs=mysql_query($query,$conn);
              if($row = mysql_fetch_array($rs))
                     {
                       do{
                           $html.="<tr>
                                        <td  >Medicamento</td>
                                        <td >No requiere</td>
                                        <td align=\"center\">".utf8_encode($row['NsumAl_Cantidad'])."</td>
                                        <td>".utf8_encode($row['NsumAl_medicamento'])."</td>
                                        <td></td>                                        
                                   </tr>
                                   <tr>              
                                   <td ></td>
                                   <td colspan=\"4\"><b>Indicaciones: </b>".utf8_encode($row['NsumAl_posologia'])."</td>               
                                   </tr>
                                  <hr>";
                                  $inicio=$inicio+11;
                                  $tamImg=$tamImg-13;
                                  $linea= $linea -12; 
                           
                          }while($row = mysql_fetch_array($rs));
                     }
              else{
                $html.="<tr>                  
                            <td colspan=\"5\">No requiere medicamentos</td>
                       </tr>
                       <hr>"; 
                       $inicio=$inicio+11;
                        $tamImg=$tamImg-13;
                        $linea= $linea -12;               
              }
          }        

         $query="SELECT Ort_clave, Sym_medicamento,Ortpre_nombre, Subort_cantidad, Subort_indicaciones FROM SubOrtesis 
                inner Join SymioCuadroBasico on SymioCuadroBasico.Clave_producto=SubOrtesis.Ort_clave 
                inner Join  Ortpresentacion on Ortpresentacion.Ortpre_clave=SubOrtesis.OrtPre_clave
                Where Exp_folio='".$fol."' and Sub_cons=".$Subcons;
            $rs1 = mysql_query($query,$conn);

           if($row1= mysql_fetch_assoc($rs1)){
              do{
               $html.= "
                <tr>              
                   <td align=\"center\" >".utf8_encode($row1['Ort_clave'])."</td>
                   <td >No requiere</td>
                   <td align=\"center\" >".utf8_encode($row1['Subort_cantidad'])."</td>
                   <td >".utf8_encode($row1['Sym_medicamento'])."</td>
                   <td align=\"center\" >".utf8_encode($row1['Ortpre_nombre'])."</td>
                </tr>
                <tr>              
                   <td ></td>
                   <td colspan=\"4\"><b>Indicaciones: </b>".utf8_encode($row1['Subort_indicaciones'])."</td>               
                </tr>
                <hr>";
                $inicio=$inicio+11;
              $tamImg=$tamImg-13;
              $linea= $linea -12; 
              }while($row1= mysql_fetch_array($rs1));
          }else{
            $query="select * from NotaOrtesisAlternativa where Exp_folio='".$fol."'";
            $rs=mysql_query($query,$conn);
            if($row = mysql_fetch_array($rs))
                   {
                     do{
                         $html.="<tr><td>Ortesis</td>
                                      <td>No requiere</td>
                                      <td align=\"center\">".utf8_encode($row['NortAl_Cantidad'])."</td>
                                      <td>".utf8_encode($row['NortAl_ortesis'])."</td>
                                      <td>Según Item</td>
                                </tr>
                                <tr>              
                                   <td ></td>
                                   <td colspan=\"4\"><b>Indicaciones: </b>".utf8_encode($row['NortAl_posologia'])."</td>               
                                </tr><hr>"; 
                                $inicio=$inicio+11;
                                $tamImg=$tamImg-13;
                                $linea= $linea -12;                         
                        }while($row = mysql_fetch_array($rs));
                   }
            else{
              $html.="<tr>                  
                          <td colspan=\"5\">No requiere ortesis</td>
                     </tr><hr>";  
                     $inicio=$inicio+11;
                        $tamImg=$tamImg-13;
                        $linea= $linea -12;             
            }
          }       
  $html.="
      </table>
     ";

$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";
$pdf->Ln(2);

if($tamImg>0){
  $image_file = "../../imgs/nulo.jpg";
$pdf->Image($image_file, 10, $inicio, 190,$tamImg, 'JPG', '', 'T', false, 500, '', false, false, 0, false, false, false);  
}

$pdf->Ln($linea);
$indicaciones='';
$query="SELECT Sind_clave, Sind_obs FROM SubInd Where Exp_folio='".$fol."' and Sub_cons=".$Subcons;
$rs = mysql_query($query,$conn);
    if($row= mysql_fetch_assoc($rs)){
      do{
       if($indicaciones==''){
            $indicaciones=$row['Sind_obs'];
        }else{
            $indicaciones.=', '.$row['Sind_obs'];
        }   
      }while($row= mysql_fetch_array($rs));
    }

$html="
      <table cellspacing=\"1\" style=\"border: 1px solid black; margin:2px 2px 2px 2px; font-size:30px\">
            <tr  bgcolor=\"#cccccc\" >
                    <th>
                    <b>Indicaciones</b>
                    </th>
            </tr>
            <tr>
                  <td height=\"70px\">
                  ".utf8_encode($indicaciones)."
                  </td>
            </tr>
      </table>
";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";

$query="select Med_nombre,Med_paterno, Med_materno,Med_cedula,Med_esp, Med_telefono, Med_institucion  from Medico where Usu_login='".$usr."'";
$rs = mysql_query($query,$conn);
$row=mysql_fetch_array($rs);

$query="Select Uni_calleNum, Uni_colMun, Uni_tel From Unidad where Uni_clave=".$Uni;
$rs1 = mysql_query($query,$conn);
$row1=mysql_fetch_array($rs1);
$html="
   <table cellspacing=\"1\" cellpadding=\"2\" style=\"padding-top:5px\">
            <tr>
                    <td valing=\"middle\" colspan=\"3\">
                        Institución: ".utf8_encode($row['Med_institucion'])."
                    </td>

            </tr>
            <tr>
                    <td valing=\"middle\">
                        Médico: ".utf8_encode($row['Med_nombre'])." ".utf8_encode($row['Med_paterno'])." ".utf8_encode($row['Med_materno'])."
                    </td>
                    <td valing=\"middle\">
                        Cédula: ".utf8_encode($row['Med_cedula'])."
                    </td>
                    <td align=\"center\">
                   ___________________________________
                   </td>
            </tr>
            <tr>
                   <td>
                      Reg. Especialidad: ".utf8_encode($row['Med_esp'])."
                   </td>
                   <td>
                      
                   </td>                   
                   <td align=\"center\">
                      Firma
                   </td>      
           </tr>
           <tr>
                    <td>
                    </td>
           </tr>
           <tr>
                   <td colspan=\"2\">
                   <b>Dirección: ".utf8_encode($row1['Uni_calleNum']).", ".utf8_encode($row1['Uni_colMun'])."</b>
                   </td>
            </tr>
            <tr>
                   <td colspan=\"2\">
                   <b>Teléfono: ".utf8_encode($row1['Uni_tel'])."</b>
                   </td>
            </tr>
           
            <tr>
                   <td colspan=\"2\">
                   <b>Quejas y Sugerencias 01 800 3 MEDICA</b>
                   </td>
            </tr>
             <tr>
                    <td>
                    </td>
           </tr>
            <tr>
                    <td colspan=\"2\">
                    <b>".utf8_encode($cadena)."</b>
                    </td>
           </tr>
            <tr>
                    <td>
                    </td>
           </tr>
             <tr>
                   <td align=\"center\" colspan=\"3\" style=\" margin:2px 2px 2px 2px; font-size:40px\">
                   <b>Cita abierta las 24hrs en caso de continuar con molestas, favor de agendar.</b>
                   </td>
            </tr>            
            </table>
";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html="";

        $pdf->output("RSub_".$Subcons."_".$fol.".pdf",'D');



?>
