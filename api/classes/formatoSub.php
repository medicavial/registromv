<?php
require "pac_vars.inc";
require 'tcpdf.php';
require 'config/lang/eng.php';

$fol=$_GET['fol'];
$usr=$_GET['usr'];
////////// Datos del Expediente/////
//$fol=$fol;
$query="Select Exp_nombre, Exp_paterno, Exp_materno, Exp_fechaNac, Exp_edad, Exp_meses, Exp_sexo, Rel_clave, Ocu_clave, Edo_clave, Exp_mail, Exp_telefono, Cia_clave, Exp_fecreg From Expediente Where Exp_cancelado=0 and Exp_folio='".$fol."'";
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
$fecreg      =$row['Exp_fecreg'];

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

$query="Select Not_clave, Llega_clave, Not_fechaAcc, Not_horaAcc, TipoVehiculo_clave, Posicion_clave, Not_obs, Usu_nombre, Not_fechareg, Not_vomito, Not_mareo, Not_nauseas, Not_perdioConocimiento, Not_cefalea, Usu_nombre FROM NotaMedica Where Exp_folio='".$fol."'";
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
$nauseas        =    $row['Not_nauseas'];
$conocimiento   =    $row['Not_perdioConocimiento'];
$cefalea        =    $row['Not_cefalea'];
$Usuario        =    $row['Usu_nombre'];
$fechaNota      =    $row['Not_fechareg'];

if($LlegaClave==null)$LlegaClave=-1;
if($VehiculoClave==null)$VehiculoClave=-1;
if($PosicionClave==null)$PosicionClave=-1;
if($vomito=="S"){$vomito="";}else{$vomito="Negó: ";}
if($mareo=="S"){$mareo="";}else{$mareo="Negó: ";}
if($nauseas=="S"){$nauseas="";}else{$nauseas="Negó: ";}
if($conocimiento=="S"){$conocimiento="";}else{$conocimiento="Negó: ";}
if($cefalea=="S"){$cefalea="";}else{$cefalea="Negó: ";}

$query="Select ObsNot_diagnosticoRx from ObsNotaMed where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);

$diagnosticoI=$row['ObsNot_diagnosticoRx'];

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

///////// Datos de Subsecuencia

$query="Select Max(Sub_cons) From Subsecuencia Where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
$row=mysql_fetch_row($rs);
$Subcons=$row[0];

$query="Select Sub_SignosSintomas, Sub_evolucion, Sub_diagnostico, Sub_obs , Sub_fecha, Sub_hora, Usu_registro,Sub_waddell From Subsecuencia Where Exp_folio='".$fol."' and Sub_cons=".$Subcons;
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);

//echo $query;

$SigSint     =     $row['Sub_SignosSintomas'];
$evolucion   =     $row['Sub_evolucion'];
$diagSub     =     $row['Sub_diagnostico'];
$obsSub      =     $row['Sub_obs'];
$fecSub      =     $row['Sub_fecha'];
$horaSub     =     $row['Sub_hora'];
$Usuregistro =     $row['Usu_registro'];
$waddellSub  =     $row['Sub_waddell'];

///// Datos Medico
$query="Select Med_nombre, Med_paterno, Med_materno, Med_cedula, Med_sexo From Medico Where Usu_login='".$Usuario."'";
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);

$MedicoNombre=$row["Med_nombre"]." ".$row["Med_paterno"].$row["Med_materno"];


          ////////////////////////////////////////////////////////////////////////////////////////////
          ////////////          PDF Con tcpdf                                               //////////
          ////////////                                                                     ///////////
          ////////////////////////////////////////////////////////////////////////////////////////////

          // Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		// Logo
                global $fecSub, $horaSub, $Subcons,$fol;
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
		$this->Image($image_file, 90, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    */
		// Set font
		$this->SetFont('helvetica', 'B', 14);
		// Title
                $this->Cell(0, 15, 'Subsecuencia #'.$Subcons, 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                $this->SetFont('helvetica', 'B', 10);
                 $this->Cell(0, 15, 'Folio Asignado:'.$fol, 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                 $this->SetFont('helvetica', 'B', 8);
                 $this->Cell(0, 15,"Fecha:".$fecSub." "."Hora:".$horaSub, 0, false, 'R', 0, '', 0, false, 'M', 'M');
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
          <b>Tel. Domicilio:</b>  ".utf8_encode($Telefono)."
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

$html="
    <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
    <tr>
        <th align=\"center\" colspan=\"3\" bgcolor=\"#cccccc\">
            <b>Datos del siniestro</b>
        </th>
    </tr>
    <tr>
         <td>
              <b>Fecha de siniestro: </b>".$FechaAcc."
         </td>
         <td>
             <b>Fecha de primera atención: </b>".$fechaNota."
         </td>
         <td>
         <b>Médico de primera atención: </b>".$MedicoNombre."
         </td>
    </tr>
    <tr>
        <td>
         <b>Diagnóstico inicial:</b>
        </td>
        <td colspan=\"2\">".$diagnosticoI."
        </td>
    </tr>

    </table>
      ";

$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

/////Signos vitales
$query="Select VitSub_temperatura, VitSub_talla, VitSub_peso, VitSub_ta, VitSub_fc, VitSub_fr , VitSub_imc , VitSub_observaciones, VitSub_fecha, Usu_registro, IMC_categoria, IMC_comentario From VitalesSub  Inner Join IMC on IMC.IMC_clave=VitalesSub.IMC_clave  Where Exp_folio='".$fol."' and VitSub_subCons=".$Subcons;
$rs= mysql_query($query,$conn);
//echo $query;
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
                      <td align=\"center\">".$row["VitSub_temperatura"]."</td>
                      <td align=\"center\">".$row["VitSub_talla"]."</td>
                      <td align=\"center\">".$row["VitSub_peso"]."</td>
                      <td align=\"center\">".$row["VitSub_ta"]."</td>
                      <td align=\"center\">".$row["VitSub_fc"]."</td>
                      <td align=\"center\">".$row["VitSub_fr"]."</td>
          </tr>
          <tr>
                     <td><b>Observaciones:</b></td>
                     <td colspan=\"5\" align=\"justify\">".utf8_encode($row["VitSub_observaciones"])."</td>
          </tr>

 </table>";

$html1= $html1.$html;
      }while($row = mysql_fetch_array($rs));

      $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html1, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
      $html1="";
}

$html="
<table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
    <tr>
        <th align=\"center\" bgcolor=\"#cccccc\">
            <b>Datos subsecuencia</b>
        </th>
    </tr>
    <tr>
        <td align=\"cebter\" bgcolor=\"#E2EFED\">
           <b>Signos y síntomas</b>
        </td>
    </tr>
    <tr>
        <td align=\"justify\">".utf8_encode($SigSint)."
        </td>
    </tr>
    <tr>
        <td align=\"cebter\" bgcolor=\"#E2EFED\">
           <b>Evolución</b>
        </td>
    </tr>
    <tr>
        <td align=\"justify\">".utf8_decode($evolucion)."
        </td>
    </tr>

</table>
";
      $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
      $html="";


    $query="SELECT Rxsub_clave, Rx_nombre, Rxsub_Obs, Rxsub_desc FROM RxSubSolicitados inner Join Rx on Rx.Rx_clave=RxSubSolicitados.Rx_clave Where Exp_folio='".$fol."' and Sub_cons=".$Subcons;
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
                            <td>".utf8_encode($row['Rxsub_Obs'])."</td>
                            <td>".utf8_encode($row['Rxsub_desc'])."</td>
                     </tr>";
               $html2=$html2.$html1;
           }while($row=  mysql_fetch_array($rs));
        }else{
          $html1= "<tr>
                    <td colspan=\"3\">no requiere</td>                            
                   </tr>";
               $html2=$html2.$html1;
        }
        $html3="
         </table>";
        // Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html2.$html3, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html2=""; $html3="";
      

$html="
    <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
    <tr>
        <td align=\"cebter\" bgcolor=\"#E2EFED\">
           <b>Diagnostico</b>
        </td>
    </tr>
      <tr>
                 <td align=\"justify\">".utf8_encode($diagSub)."
                 </td>
          </tr>
      </table>    
      ";
      $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
      $html="";

    $query="SELECT Sum_clave as clave, Subsum_cantidad as cantidad, Sym_denominacion as sustancia, Sym_medicamento as medicamento, Sym_forma_far as presentacion, Subsum_obs as posologia  FROM SubSuministros 
inner Join SymioCuadroBasico on SymioCuadroBasico.Clave_producto =SubSuministros.Sum_clave
 Where Exp_folio='".$fol."' and Sub_cons=".$Subcons;
    $rs=mysql_query($query,$conn);

    if($row = mysql_fetch_array($rs))
           {
      $html="
       <table  border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
                <th align=\"center\" colspan=\"3\" bgcolor=\"#cccccc\">
                      <b>Suministros</b>
                </th>
           </tr>
           <tr>
                <td width=\"10%\"><b>Cantidad</b></td>
                <td width=\"20%\"><b>Suministro</b></td>
                <td width=\"70%\"><b>Indicaciones</b></td>
          </tr>";


             do{
                 $html1="<tr>
                              <td>".utf8_encode($row['cantidad'])."</td>
                              <td>".utf8_encode($row['medicamento'])."</td>
                              <td>".utf8_encode($row['posologia'])."</td>
                         </tr>";
                 $html2=$html2.$html1;
                }while($row = mysql_fetch_array($rs));

      $html3="</table>";
      // Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html2.$html3, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html2=""; $html3="";
           }

    $query="SELECT Subort_clave, Sym_medicamento,Ortpre_nombre, Subort_cantidad, Subort_indicaciones FROM SubOrtesis 
inner Join SymioCuadroBasico on SymioCuadroBasico.Clave_producto=SubOrtesis.Ort_clave 
inner Join  Ortpresentacion on Ortpresentacion.Ortpre_clave=SubOrtesis.OrtPre_clave
Where Exp_folio='".$fol."' and Sub_cons=".$Subcons;
    $rs=mysql_query($query,$conn);

if($row = mysql_fetch_array($rs))
    {

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

          do{
                $html1="<tr>
                            <td>".utf8_encode($row['Subort_cantidad'])."</td>
                            <td>".utf8_encode($row['Sym_medicamento'])."</td>
                            <td>".utf8_encode($row['Ortpre_nombre'])."</td>
                             <td>".utf8_encode($row['Subort_indicaciones'])."</td>
                        </tr>";
                $html2=$html2.$html1;

            }while($row = mysql_fetch_array($rs));
    
$html3="</table>";
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html2.$html3, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html2=""; $html3="";
}



    $query="SELECT Sind_clave, Sind_obs FROM SubInd Where Exp_folio='".$fol."' And Sub_cons=".$Subcons;
    $rs=mysql_query($query,$conn);
       if($row = mysql_fetch_array($rs))
           {
$html="
       <table  border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
               <tr>
                    <th align=\"center\" bgcolor=\"#cccccc\">
                         <b>Indicaciones generales</b>
                    </th>
               </tr>";

               do{
                     $html1="<tr>
                                  <td>".utf8_encode($row['Sind_obs'])."</td>
                             </tr>";
                     $html2=$html2.$html1;
                 }while($row = mysql_fetch_array($rs));
           $html3="</table>";
           // Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html2.$html3, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html2=""; $html3="";
           }



$html="
    <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
    <tr>
        <td align=\"cebter\" bgcolor=\"#E2EFED\">
           <b>Criterios de Waddell</b>
        </td>
    </tr>
      <tr>
                 <td align=\"justify\">".utf8_encode($waddellSub)."
                 </td>
          </tr>
    <tr>
        <td align=\"cebter\" bgcolor=\"#E2EFED\">
           <b>Observaciones</b>
        </td>
    </tr>
      <tr>
                 <td align=\"justify\">".utf8_encode($obsSub)."
                 </td>
          </tr>
      </table>
      ";
      $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
      $html="";


      $query="Select Med_nombre, Med_paterno, Med_materno, Med_cedula, Med_sexo From Medico Where Usu_login='".$usr."'";
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

    $pdf->output("SB_".$Subcons."_".$fol.".pdf",'D');
?>

