<?php
require "pac_vars.inc";
require 'tcpdf.php';
require 'config/lang/eng.php';

$fol=$_GET['fol'];
$usr=$_GET['usr'];
$query="Select Not_clave From NotaMedica Where Exp_folio='".$fol."' order by Not_clave";
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);

$nota= $row["Not_clave"];

$query="Select Exp_folio, Nota_clave From RecetaNota Where Exp_folio='".$fol."' ";
$rs=mysql_query($query,$conn);
$row=  mysql_fetch_array($rs);
$Fres=$row["Exp_folio"];
if($Fres=="" || $Fres==null){
$query="Insert Into RecetaNota (Exp_folio, Nota_clave, Rec_fecha, Usu_login)
                         Values('".$fol."',".$nota.",now(),'".$usr."')";
$rs=mysql_query($query,$conn);
}

////////// Datos del Expediente/////
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

/////////////// Datos del Medico///
$query="Select Med_nombre, Med_paterno, Med_materno, Med_sexo, Med_institucion, Med_cedula, Med_esp, Med_direccion, Med_telefono, Uni_clave From Medico where Usu_login='".$usr."'";
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);

$MedNombre   = $row["Med_nombre"];
$MedPaterno  = $row["Med_paterno"];
$MedMaterno  = $row["Med_materno"];
$Institucion = $row["Med_institucion"];
$Cedula      = $row["Med_cedula"];
$Esp         = $row["Med_esp"];
$Direccion   = $row["Med_direccion"];
$Telefono    = $row["Med_telefono"];
$Unidad      = $row["Uni_clave"];
$Titulo      = $row["Med_sexo"];
$CompletoMedico= $MedNombre." ".$MedPaterno." ".$MedMaterno;

if($Titulo=="M"){$Titulo="Dr.";}else{$Titulo="Dra.";}


$query="Select Uni_clave From Usuario Where Usu_login='".$usr."'";
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);
$Uni= $row["Uni_clave"];



$query="Select Uni_calleNum, Uni_colMun, Uni_tel From Unidad where Uni_clave=".$Uni;
$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);

$calleNum  = $row["Uni_calleNum"];
$colMun    = $row["Uni_colMun"];
$tel       = $row["Uni_tel"];

$Direc= $calleNum." ".$colMun;


          ////////////////////////////////////////////////////////////////////////////////////////////
          ////////////          PDF Con tcpdf                                               //////////
          ////////////                                                                     ///////////
          ////////////////////////////////////////////////////////////////////////////////////////////


/* @var $NombreCompleto MYPDF */

$NombreCompleto= $Nombre." ".$Paterno." ".$Materno;
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
            global $NombreCompleto;
            global $fol;
            // Logo
		//$image_file = K_PATH_IMAGES.'/images/mv.jpg';
		//$this->Image($image_file, 10, 10, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                //$image_file = K_PATH_IMAGES.$fol.'.png';
		//$this->Image($image_file, 90, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		//$this->SetFont('helvetica', 'B', 14);
		// Title
                //$this->Cell(0, 15, 'Nota Médica', 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                //$this->SetFont('helvetica', 'B', 10);
                 //$this->Cell(0, 15, 'Folio Asignado:'.$fol, 0, 1, 'R', 0, '', 0, false, 'M', 'M')
                 $this->SetFont('helvetica', 'B', 10);
                 $this->SetY(30);
                
                 $this->Cell(0, 15,"Fecha:".date('d'.'/'.'m'.'/'.'Y')." "."Hora:".date('g'.':'.'i'.' '.'A'), 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                 $this->SetY(33);
                 $this->Cell(127, 15,"Nombre: ".utf8_encode($NombreCompleto), 0,0, 'L', 0, '', 0, false, 'M', 'M');
                  $this->Cell(50, 15, 'Folio Asignado:'.$fol, 0, 1, 'R', 0, '', 0, false, 'M', 'M');
           	}
	// Page footer
	public function Footer() {
            global $tel;
           
		// Position at 15 mm from bottom
		$this->SetY(-180);
		// Set font
		$this->SetFont('helvetica', 'I', 9);
		// Page number
                $this->Cell($w, $h, $txt="Tel: ".$tel, $border, $ln=1, $align="L", $fill, $link, $stretch, $ignore_min_height);
                $this->Cell($w=85, $h, $txt="Atención las 24 hrs.", $border, $ln=1, $align="L", $fill, $link, $stretch, $ignore_min_height);
                $this->Cell($w, $h, $txt="Quejas y Sugerencias 01 800 3 MEDICA", $border, $ln=0, $align="L", $fill, $link, $stretch, $ignore_min_height);
                $this->Cell($w, $h, $txt="Firma del Médico", $border, $ln=1, $align="R", $fill, $link, $stretch, $ignore_min_height);
                $this->Line(150, 122, 200, 122);

		//$this->Cell(0, 10, 'Pagina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

	      }
}

$pdf = new MYPDF('P', PDF_UNIT, 'Mi[80][80]' , true, 'UTF-8', false);
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

$pdf->SetY(10);
$pdf->SetFont('helvetica', 'B',12);
$pdf->Cell($w, $h, $txt=$Titulo." ".utf8_encode($CompletoMedico), $border, $ln=1, $align="C", $fill, $link, $stretch, $ignore_min_height);
$pdf->Line(25, 14, 180, 14, $style);
$pdf->Ln(1);
$pdf->SetFont('dejavusans', '', 7, '', true);
$pdf->Cell($w, $h, $txt="Institución: ". utf8_encode($Institucion), $border, $ln=1, $align="C", $fill, $link, $stretch, $ignore_min_height);
$pdf->Cell($w, $h, $txt="Cedula: ".utf8_encode($Cedula)."  "."Esp: ".$Esp, $border, $ln=1, $align="C", $fill, $link, $stretch, $ignore_min_height);
$pdf->Cell($w, $h, $txt= "Dirección: ".utf8_encode($Direc), $border, $ln=1, $align="C", $fill, $link, $stretch, $ignore_min_height);
//$pdf->Cell($w, $h, $txt="Telefono: ". utf8_encode($Telefono), $border, $ln, $align, $fill, $link, $stretch, $ignore_min_height);

$pdf->Ln(10);

$html="
       <table cellspacing=\"1\" >

           <tr>
                <td width=\"10%\" bgcolor=\"#E2EFED\"><b>Cantidad</b></td>
                <td width=\"20%\" bgcolor=\"#E2EFED\"><b>Medicamento</b></td>
                <td width=\"70%\" bgcolor=\"#E2EFED\"><b>Indicaciones</b></td>
          </tr>";

$query="SELECT Nsum_clave, Sum_nombre, Nsum_obs, Nsum_Cantidad  FROM NotaSuministro inner Join Suministro on Suministro.Sum_clave =NotaSuministro.Sum_clave Where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);

       if($row = mysql_fetch_array($rs))
           {
             do{
                 $html1="<tr>
                              <td align=\"center\">".utf8_encode($row['Nsum_Cantidad'])."</td>
                              <td>".utf8_encode($row['Sum_nombre'])."</td>
                              <td>".utf8_encode($row['Nsum_obs'])."</td>
                         </tr>";
                 $html2=$html2.$html1;
                }while($row = mysql_fetch_array($rs));
           }
$html3="</table>";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html2.$html3, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html2=""; $html3="";
$pdf->Ln(2);
$html="
       <table cellspacing=\"1\" >

           <tr>
               <th width=\"10%\" bgcolor=\"#E2EFED\"><b>Cantidad</b></th>
               <th width=\"15%\" bgcolor=\"#E2EFED\"><b>Ortesis</b></th>
               <th width=\"15%\" bgcolor=\"#E2EFED\"><b>Presentacion</b></th>
               <th width=\"60%\" bgcolor=\"#E2EFED\"><b>Indicaciones</b></th>
          </tr>";

 $query="SELECT Notor_clave, Ort_nombre, Ortpre_nombre, Notor_cantidad, Notor_indicaciones FROM NotaOrtesis inner Join Ortesis on Ortesis.Ort_clave=NotaOrtesis.Ort_clave inner Join  Ortpresentacion on Ortpresentacion.Ortpre_clave=NotaOrtesis.Ortpre_clave Where Exp_folio='".$fol."'";
    $rs=mysql_query($query,$conn);

       if($row = mysql_fetch_array($rs))
           {
             do{
                 $html1="<tr>
                             <td align=\"center\">".utf8_encode($row['Notor_cantidad'])."</td>
                             <td>".utf8_encode($row['Ort_nombre'])."</td>
                             <td>".utf8_encode($row['Ortpre_nombre'])."</td>
                             <td>".utf8_encode($row['Notor_indicaciones'])."</td>
                         </tr>";
                 $html2=$html2.$html1;
                }while($row = mysql_fetch_array($rs));
           }
$html3="</table>";

$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html2.$html3, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html2=""; $html3="";


$pdf->Ln(2);

$html="
       <table  cellspacing=\"1\" >
               <tr>
                    <th align=\"center\" bgcolor=\"#E2EFED\">
                         <b>Indicaciones generales</b>
                    </th>
               </tr>";

$query="SELECT Nind_clave, Nind_obs FROM NotaInd Where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
       if($row = mysql_fetch_array($rs))
           {
               do{
                     $html1="<tr>
                                  <td>".utf8_encode(strtoupper($row['Nind_obs']))."</td>
                             </tr>";
                     $html2=$html2.$html1;
                 }while($row = mysql_fetch_array($rs));
           }

           $html3="</table>";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html2.$html3, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html2=""; $html3="";
//////
/*
$pdf->Ln(2);

$html="
       <table  cellspacing=\"1\" >
               <tr>
                    <th align=\"center\" bgcolor=\"#E2EFED\">
                         <b>Diagn&oacute;stico</b>
                    </th>
               </tr>";


$query="SELECT ObsNot_diagnosticoRx FROM ObsNotaMed Where Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
       if($row = mysql_fetch_array($rs))
           {

                     $html1="<tr>
                                  <td>".utf8_encode($row['ObsNot_diagnosticoRx'])."</td>
                             </tr>";
                     $html2=$html2.$html1;
                
           }

           $html3="</table>";

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html2.$html3, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html2=""; $html3="";
*/
/////
       $pdf->output("RC_".$fol.".pdf",'D');



?>

