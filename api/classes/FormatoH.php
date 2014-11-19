<?php
require "pac_vars.inc";//con
require 'tcpdf.php';
require 'config/lang/eng.php';

////////// Datos del Expediente/////

//$query="Select Exp_nombre, Exp_paterno, Exp_materno, Exp_fechaNac, Exp_edad, Exp_meses, Exp_sexo, Rel_clave, Ocu_clave, Edo_clave, Exp_mail, Exp_telefono From Expediente Where Exp_folio='".$fol."'";
$query="Select Exp_nombre, Exp_paterno, Exp_materno, Exp_fechaNac, Exp_edad, Exp_meses, Exp_sexo, Rel_clave, Ocu_clave, Edo_clave, Exp_mail, Exp_telefono From Expediente Where Exp_cancelado=0 and Exp_folio='".$fol."'";
$rs=mysql_query($query,$conn);
$row= mysql_fetch_array($rs);

//print_r($row);
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
		// Logo
    global $fol;
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
		$image_file = '../../imgs/logos/mv.jpg';
		$this->Image($image_file, 10, 10, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                /*$image_file = K_PATH_IMAGES.$fol.'.png';
		$this->Image($image_file, 90, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    */
		// Set font
		$this->SetFont('helvetica', 'B', 14);
		// Title
                $this->Cell(0, 15, 'Historia Clínica', 0, 1, 'R', 0, '', 0, false, 'M', 'M');
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
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
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


////////////////////////////////////////////////////////////////
///// código de barras creado en el pdf


//////////      fin de creacion de codigo de barras       ////////
/* $image_file = K_PATH_IMAGES.'mv.jpg';
    $pdf->Image($image_file, 10, 10, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);                              
    $pdf->SetFont('helvetica', 'B', 14);
    // Title
                $pdf->Cell(0, 15, 'Historia Clínica', 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->Cell(0, 15, 'Folio Asignado:'.$fol, 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                $pdf->SetFont('helvetica', 'B', 8);                
                $pdf->Cell(0, 15,"Fecha:".date('d'.'/'.'m'.'/'.'Y')." "."Hora:".date('g'.':'.'i'.' '.'A'), 0, 1, 'R', 0, '', 0, false, 'M', 'M');
                */
/////////////////////////////////////////////////////////////////

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
          <b>Fecha de nacimiento:</b>  ".utf8_encode($FechaNac)."
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
/////Antecedentes familiares
   $query="SELECT Enf_nombre, Fam_nombre, Est_nombre, FamE_obs FROM FamEnfermedad Inner Join Enfermedad on FamEnfermedad.Enf_clave=Enfermedad.Enf_clave Inner Join Familia on FamEnfermedad.Fam_clave=Familia.Fam_clave Inner Join EstatusFam on FamEnfermedad.Est_clave=EstatusFam.Est_clave Where Exp_folio='".$fol."'";
    $rs=mysql_query($query,$conn);
           $html="
         <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
               <th colspan=\"4\" align=\"center\" bgcolor=\"#cccccc\">
                    <b>Antecedentes Familiares</b>
               </th>
           </tr>
           <tr>
               <th width=\"20%\"><b>Enfermedad</b></th>
               <th width=\"15%\"><b>Familiar</b></th>
               <th width=\"15%\"><b>Estatus</b></th>
               <th width=\"50%\"><b>Observaciones</b></th>
           </tr>";
        if($row = mysql_fetch_array($rs))
            { 
                do{             
                    $html1="
                          <tr>
                              <td>".utf8_encode($row['Enf_nombre'])."</td>
                              <td>".utf8_encode($row['Fam_nombre'])."</td>
                              <td>".utf8_encode($row['Est_nombre'])."</td>
                              <td>".utf8_encode($row['FamE_obs'])."</td>
                          </tr>
                        ";
                    $html1o=$html1o.$html1;
                } while ($row = mysql_fetch_array($rs));
             }
             $query="SELECT  Count(Enf_clave) As Contador FROM Enfermedad";
            $rs=mysql_query($query,$conn);
            $row=mysql_fetch_row($rs);
            $Contador=$row[0];
            $Contador=$Contador-1;

          $query="SELECT Distinct Enf_clave FROM FamEnfermedad WHERE Exp_folio='".$fol."' order by Enf_clave";
           $rs=mysql_query($query,$conn);
                  if($row = mysql_fetch_array($rs))
                     {
                      
                      $EnfClavePac[$Contador];
                       do{

                          $EnfClavePac[$row['Enf_clave']-1]=$row['Enf_clave'];

                          } while ($row = mysql_fetch_array($rs));
                     }
        $query="SELECT Enf_clave, Enf_nombre FROM Enfermedad Order by Enf_clave";
        $rs=mysql_query($query,$conn);
        if($row = mysql_fetch_array($rs))
              {
                     $i=0;
                     
                   do{
                   $EnfClave[$i]=$row['Enf_clave'];
                    if( $EnfClave[$i] == $EnfClavePac[$i])
                          {
                               $htmlN1="";
                           }else{
                               $htmlN1="
                                     <tr>
                                          <td>".utf8_encode($row['Enf_nombre'])."</td>
                                          <td colspan=\"3\">"."<b>Negado</b>"."</td>
                                    </tr>
                               ";
                           }
                              $i=$i+1;
                           $htmlN=$htmlN.$htmlN1;
                      }while ($row = mysql_fetch_array($rs));
              }
                $html2="</table>";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html1o.$htmlN.$html2, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html1o=""; $html2=""; $htmlN="";
///// Antecedentes personales
   ///Cronico-Degenerativos
   $query="SELECT Hist_clave, Pad_nombre, Pad_obs FROM HistoriaPadecimiento Inner Join Padecimientos on HistoriaPadecimiento.Pad_clave=Padecimientos.Pad_clave Where Exp_folio='".$fol."'";
    $rs=mysql_query($query,$conn);
     $html="
           <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
               <th colspan=\"2\" align=\"center\" bgcolor=\"#cccccc\">
                    <b>Antecedentes Personales</b>
               </th>
           </tr>
            <tr>
               <th colspan=\"2\" align=\"center\" bgcolor=\"#E2EFED\">
                    Cr&oacute;nico-Degenerativos
               </th>
           </tr>
                  <tr>
                     <th width=\"20%\"><b>Enfermedad</b></th>
                     <th width=\"80%\"><b>Observaciones</b></th>
                  </tr>
              ";
    if($row = mysql_fetch_array($rs))
            {
         do{
                   $html1="
                          <tr>
                              <td>".utf8_encode($row['Pad_nombre'])."</td>
                              <td>".utf8_encode($row['Pad_obs'])."</td>
                          </tr>
                        ";
                    $html1o=$html1o.$html1;
                } while ($row = mysql_fetch_array($rs));
            }

            $query="SELECT  Count(Pad_clave) As Contador FROM Padecimientos";
            $rs=mysql_query($query,$conn);
            $row=mysql_fetch_row($rs);
            $Contador=$row[0];
            $Contador=$Contador-1;

            
           $query="SELECT Distinct Pad_clave FROM HistoriaPadecimiento WHERE Exp_folio='".$fol."' order by Pad_clave";
           $rs=mysql_query($query,$conn);
                  if($row = mysql_fetch_array($rs))
                     {

                      $PadClavePac[$Contador];
                       do{

                          $PadClavePac[$row['Pad_clave']-1]=$row['Pad_clave'];

                          } while ($row = mysql_fetch_array($rs));
                     }

        $query="SELECT Pad_clave, Pad_nombre FROM Padecimientos Order by Pad_clave";
        $rs=mysql_query($query,$conn);
        if($row = mysql_fetch_array($rs))
              {
                     $i=0;

                   do{
                   $PadClave[$i]=$row['Pad_clave'];
                    if( $PadClave[$i] == $PadClavePac[$i])
                          {
                               $htmlN1="";
                           }else{
                               $htmlN1="
                                     <tr>
                                          <td>".utf8_encode($row['Pad_nombre'])."</td>
                                          <td>"."<b>Negado</b>"."</td>
                                    </tr>
                               ";

                           }
                              $i=$i+1;
                           $htmlN=$htmlN.$htmlN1;

                      }while ($row = mysql_fetch_array($rs));
              }


   $html2="</table>";
  $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html1o.$htmlN.$html2, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$html=""; $html1=""; $html1o=""; $html2=""; $htmlN="";
//////Otras Enfermedades

    $query="SELECT Otr_nombre, HistOt_obs FROM HistoriaOtras Inner Join Otras on HistoriaOtras.Otr_clave=Otras.Otr_clave Where Exp_folio='".$fol."'";
    $rs=mysql_query($query,$conn);
         $html="  <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
               <th colspan=\"2\" align=\"center\" bgcolor=\"#E2EFED\">
                    Otras enfermedades
               </th>
           </tr>
                  <tr>
                     <th width=\"20%\"><b>Enfermedad</b></th>
                     <th width=\"80%\"><b>Observaciones</b></th>
                  </tr>
        ";
        if( $row=  mysql_fetch_array($rs))
   {

        do{
               $html1="
                          <tr>
                              <td>".utf8_encode($row['Otr_nombre'])."</td>
                              <td>".utf8_encode($row['HistOt_obs'])."</td>
                          </tr>
                        ";
                $html1o=$html1o.$html1;
         }while($row= mysql_fetch_array($rs));

    }


     $query="SELECT  Count(Otr_clave) As Contador FROM Otras";
            $rs=mysql_query($query,$conn);
            $row=mysql_fetch_row($rs);
            $Contador=$row[0];
            $Contador=$Contador-1;

 $query="SELECT Distinct Otr_clave FROM HistoriaOtras WHERE Exp_folio='".$fol."' order by Otr_clave";
           $rs=mysql_query($query,$conn);
                  if($row = mysql_fetch_array($rs))
                     {

                      $OtrClavePac[$Contador];
                       do{

                          $OtrClavePac[$row['Otr_clave']-1]=$row['Otr_clave'];

                          } while ($row = mysql_fetch_array($rs));
                     }

$query="SELECT Otr_clave, Otr_nombre FROM Otras Order by Otr_clave";
        $rs=mysql_query($query,$conn);
        if($row = mysql_fetch_array($rs))
              {
                     $i=0;
                   do{
                   $OtrClave[$i]=$row['Otr_clave'];
                    if( $OtrClave[$i] == $OtrClavePac[$i])
                          {
                               $htmlN1="";
                           }else{
                               $htmlN1="
                                     <tr>
                                          <td>".utf8_encode($row['Otr_nombre'])."</td>
                                          <td>"."<b>Negado</b>"."</td>
                                    </tr>
                               ";
                           }
                              $i=$i+1;
                           $htmlN=$htmlN.$htmlN1;
                      }while ($row = mysql_fetch_array($rs));
              } 
       $html2="</table>";
 $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html1o.$htmlN.$html2, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
 $html=""; $html1=""; $html1o=""; $html2=""; $htmlN="";

 /////Alergias
    $query="SELECT Ale_nombre, Ale_obs FROM HistoriaAlergias Inner Join Alergias on HistoriaAlergias.Ale_clave=Alergias.Ale_clave Where Exp_folio='".$fol."'";
        $rs=mysql_query($query,$conn);
         $html="  <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
               <th colspan=\"2\" align=\"center\" bgcolor=\"#E2EFED\">
                    Alergias
               </th>
           </tr>
                  <tr>
                     <th width=\"20%\"><b>Alergia</b></th>
                     <th width=\"80%\"><b>Observaciones</b></th>
                  </tr>
        ";
            if($row= mysql_fetch_array($rs))
            {
                do{
                     $html1="
                          <tr>
                              <td>".utf8_encode($row['Ale_nombre'])."</td>
                              <td>".utf8_encode($row['Ale_obs'])."</td>
                          </tr>
                        ";
                $html1o=$html1o.$html1;
                }while($row= mysql_fetch_array($rs));
            }

            $query="SELECT  Count(Ale_clave) As Contador FROM Alergias";
            $rs=mysql_query($query,$conn);
            $row=mysql_fetch_row($rs);
            $Contador=$row[0];
            $Contador=$Contador-1;

        $query="SELECT Distinct Ale_clave FROM HistoriaAlergias WHERE Exp_folio='".$fol."' order by Ale_clave";
        $rs=mysql_query($query,$conn);
                 if($row = mysql_fetch_array($rs))
                     {
                      $AleClavePac[$Contador];
                       do{
                          $AleClavePac[$row['Ale_clave']-1]=$row['Ale_clave'];
                          } while ($row = mysql_fetch_array($rs));
                     }

        $query="SELECT Ale_clave, Ale_nombre FROM Alergias Order by Ale_clave";
        $rs=mysql_query($query,$conn);
        if($row = mysql_fetch_array($rs))
              {
                     $i=0;
                   do{
                   $AleClave[$i]=$row['Ale_clave'];
                    if( $AleClave[$i] == $AleClavePac[$i])
                          {
                               $htmlN1="";
                           }else{
                               $htmlN1="
                                     <tr>
                                          <td>".utf8_encode($row['Ale_nombre'])."</td>
                                          <td>"."<b>Negado </b>"."</td>
                                    </tr>
                               ";
                           }
                              $i=$i+1;
                           $htmlN=$htmlN.$htmlN1;
                      }while ($row = mysql_fetch_array($rs));
              }

             $html2="</table>";
             $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html1o.$htmlN.$html2, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
             $html=""; $html1=""; $html1o=""; $html2="";

/// Padecimientos de Espalda
              $query="SELECT Esp_estatus, Esp_obs FROM HistoriaEspalda Where Exp_folio='".$fol."'";
              $rs=mysql_query($query,$conn);
     $html="  <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
               <th colspan=\"2\" align=\"center\" bgcolor=\"#E2EFED\">
                    Padecimientos de Espalda
               </th>
           </tr>
                  <tr>
                     <th width=\"20%\"><b>Padecimiento</b></th>
                     <th width=\"80%\"><b>Observaciones</b></th>
                  </tr>
        ";
          if($row=  mysql_fetch_array($rs))
          {

              do{
                  $html1="
                          <tr>
                              <td>".utf8_encode($row['Esp_estatus'])."</td>
                              <td>".utf8_encode($row['Esp_obs'])."</td>
                          </tr>
                        ";
                $html1o=$html1o.$html1;

              }while($row=mysql_fetch_array($rs));

          }else{
              $html1o="
                  <tr>
                        <td><b>No</b></td>
                        <td><b>Negado</b></td>
                  </tr>
           ";
          }
             $html2="</table>";
          $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html1o.$html2, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
          $html=""; $html1=""; $html1o=""; $html2="";

//Quiropractico
            $query="SELECT Quiro_estatus, Quiro_obs FROM HistoriaQuiro Where Exp_folio='".$fol."'";
            $rs=mysql_query($query,$conn);
     $html="  <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
               <th colspan=\"2\" align=\"center\" bgcolor=\"#E2EFED\">
                    Tratamiento con Quiropr&aacute;ctico
               </th>
           </tr>
                  <tr>
                     <th width=\"20%\"><b>Tratamiento</b></th>
                     <th width=\"80%\"><b>Observaciones</b></th>
                  </tr>
        ";
          if($row=  mysql_fetch_array($rs))
          {
              do{
                  $html1="
                          <tr>
                              <td>".utf8_encode($row['Quiro_estatus'])."</td>
                              <td>".utf8_encode($row['Quiro_obs'])."</td>
                          </tr>
                        ";
                $html1o=$html1o.$html1;
              }while($row=mysql_fetch_array($rs));
          }else{
              $html1o="
                  <tr>
                        <td><b>No</b></td>
                        <td><b>Negado</b></td>
                  </tr>
           ";
          }
             $html2="</table>";
          $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html1o.$html2, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
          $html=""; $html1=""; $html1o=""; $html2="";
 ///Plantillas
            $query="SELECT Plantillas_estatus, Plantillas_obs FROM HistoriaPlantillas Where Exp_folio='".$fol."'";
    $rs=mysql_query($query,$conn);
     $html="  <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
               <th colspan=\"2\" align=\"center\" bgcolor=\"#E2EFED\">
                    Plantillas
               </th>
           </tr>
                  <tr>
                     <th width=\"20%\"><b>Plantillas</b></th>
                     <th width=\"80%\"><b>Observaciones</b></th>
                  </tr>
        ";
          if($row=  mysql_fetch_array($rs))
          {
              do{
                  $html1="
                          <tr>
                              <td>".utf8_encode($row['Plantillas_estatus'])."</td>
                              <td>".utf8_encode($row['Plantillas_obs'])."</td>
                          </tr>
                        ";
                $html1o=$html1o.$html1;
              }while($row=mysql_fetch_array($rs));
          }else{
              $html1o="
                  <tr>
                        <td><b>No</b></td>
                        <td><b>Negado</b></td>
                  </tr>
           ";
          }
             $html2="</table>";
          $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html1o.$html2, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
          $html=""; $html1=""; $html1o=""; $html2="";


  ///Tratamientos
    $query="SELECT HistT_estatus, HistT_obs FROM HistoriaTrat Where Exp_folio='".$fol."'";
    $rs=mysql_query($query,$conn);
     $html="  <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
               <th colspan=\"2\" align=\"center\" bgcolor=\"#E2EFED\">
                    Otros Tratamientos
               </th>
           </tr>
                  <tr>
                     <th width=\"20%\"><b>Tratamiento</b></th>
                     <th width=\"80%\"><b>Observaciones</b></th>
                  </tr>
        ";
          if($row=  mysql_fetch_array($rs))
          {
              
              do{
                  $html1="
                          <tr>
                              <td>".utf8_encode($row['HistT_estatus'])."</td>
                              <td>".utf8_encode($row['HistT_obs'])."</td>
                          </tr>
                        ";
                $html1o=$html1o.$html1;

              }while($row=mysql_fetch_array($rs));
         
          }else{
              $html1o="
                  <tr>
                        <td><b>No</b></td>
                        <td><b>Negado</b></td>
                  </tr>
           ";
          }
             $html2="</table>";
          $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html1o.$html2, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
          $html=""; $html1=""; $html1o=""; $html2="";
              /////// Quirurgicas
     $query="SELECT HistO_estatus, HistO_obs FROM HistoriaOperacion Where Exp_folio='".$fol."'";
    $rs=mysql_query($query,$conn);
     $html="
                <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
               <th colspan=\"2\" align=\"center\" bgcolor=\"#E2EFED\">
                    Intervenciones Quir&uacute;rgicas
               </th>
           </tr>
                  <tr>
                     <th width=\"20%\"><b>Intervenci&oacute;n</b></th>
                     <th width=\"80%\"><b>Observaciones</b></th>
                  </tr>
        ";
 if($row=  mysql_fetch_array($rs))
          {
           
            
              do{
                  $html1="
                          <tr>
                              <td>".utf8_encode($row['HistO_estatus'])."</td>
                              <td>".utf8_encode($row['HistO_obs'])."</td>
                          </tr>
                        ";
                $html1o=$html1o.$html1;
              
              }while($row=mysql_fetch_array($rs));
             
          }else{
              $html1o="
                  <tr>
                        <td><b>No</b></td>
                        <td><b>Negado</b></td>
                  </tr>
           ";
          }
             $html2="</table>";
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html1o.$html2, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
          $html=""; $html1=""; $html1o=""; $html2="";

              //// Deportes
     $query="SELECT Dep_estatus, Dep_obs FROM HistoriaDeporte Where Exp_folio='".$fol."'";
    $rs=mysql_query($query,$conn);
     $html="
                <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
               <th colspan=\"2\" align=\"center\" bgcolor=\"#E2EFED\">
                    Deportes
               </th>
           </tr>
                  <tr>
                     <th width=\"20%\"><b>Deporte</b></th>
                     <th width=\"80%\"><b>Observaciones</b></th>
                  </tr>
        ";
     if($row=  mysql_fetch_array($rs))
          {
              do{
                     $html1="
                          <tr>
                              <td>".utf8_encode($row['Dep_estatus'])."</td>
                              <td>".utf8_encode($row['Dep_obs'])."</td>
                          </tr>
                        ";
                $html1o=$html1o.$html1;

              }while($row=mysql_fetch_array($rs));
            
          }else{
              $html1o="
                  <tr>
                        <td><b>No</b></td>
                        <td><b>Negado</b></td>
                  </tr>
           ";
          }
             $html2="</table>";
          $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html1o.$html2, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
          $html=""; $html1=""; $html1o=""; $html2="";

            ///Adicciones
    $query="SELECT Adic_estatus, Adic_obs FROM HistoriaAdiccion Where Exp_folio='".$fol."'";
    $rs=mysql_query($query,$conn);
           $html="
                <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
               <th colspan=\"2\" align=\"center\" bgcolor=\"#E2EFED\">
                    Adicciones
               </th>
           </tr>
                  <tr>
                     <th width=\"20%\"><b>Adicci&oacute;n</b></th>
                     <th width=\"80%\"><b>Observaciones</b></th>
                  </tr>
        ";
      if($row=  mysql_fetch_array($rs))
          {
      

              do{
                          $html1="
                          <tr>
                              <td>".utf8_encode($row['Adic_estatus'])."</td>
                              <td>".utf8_encode($row['Adic_obs'])."</td>
                          </tr>
                        ";
                $html1o=$html1o.$html1;

              }while($row=mysql_fetch_array($rs));
             
          }else{
              $html1o="
                  <tr>
                        <td><b>No</b></td>
                        <td><b>Negado</b></td>
                  </tr>
           ";
          }

             $html2="</table>";
               $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html1o.$html2, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
          $html=""; $html1=""; $html1o=""; $html2="";
          
              //Accidentes
     $query="SELECT Acc_estatus, Lug_nombre, Acc_obs  FROM HistoriaAcc Inner Join Lugar on HistoriaAcc.Lug_clave=Lugar.Lug_clave WHERE Exp_folio='".$fol."'";
    $rs=mysql_query($query,$conn);
              $html="
                <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
               <th colspan=\"3\" align=\"center\" bgcolor=\"#E2EFED\">
                    Accidentes
               </th>
           </tr>
           <tr>
                   <th width=\"15%\"><b>Accidente</b></th>
                   <th width=\"15%\"><b>Lugar</b></th>
                   <th width=\"70%\"><b>Observaciones</b></th>
           </tr>
        ";
         if($row=  mysql_fetch_array($rs))
          {
       
              do{
                     $html1="
                          <tr>
                              <td>".utf8_encode($row['Acc_estatus'])."</td>
                              <td>".utf8_encode($row['Lug_nombre'])."</td>
                              <td>".utf8_encode($row['Acc_obs'])."</td>
                          </tr>
                        ";
                $html1o=$html1o.$html1;
             
              }while($row=mysql_fetch_array($rs));
                
          }
          else{
              $html1o="
                  <tr>
                        <td><b>No</b></td>
                        <td align=\"center\"><b>-</b></td>
                        <td><b>Negado</b></td>
                  </tr>
           ";
          }
             $html2="</table>";
              $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html1o.$html2, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
          $html=""; $html1=""; $html1o=""; $html2="";

    // Zonas con Dolor
         /*
      $query="SELECT Zona_nombre, Zona_obs FROM HistoriaZona Inner Join ZonasDolor on HistoriaZona.Zona_clave=ZonasDolor.Zona_clave Where Exp_folio='".$fol."'";
    $rs=mysql_query($query,$conn);
                $html="
                <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
                    <tr>
                <th align=\"center\" colspan=\"2\ bgcolor=\"#cccccc\">
                   <b>Motivo de consulta</b>
                </th>
           </tr>";
          <tr>
               <th colspan=\"2\" align=\"center\" bgcolor=\"#E2EFED\">
                    Zonas con dolor
               </th>
           </tr>
                  <tr>
                     <th width=\"20%\"><b>Zona</b></th>
                     <th width=\"80%\"><b>Observaciones</b></th>
                  </tr>
        ";
          * 
          
    if($row=  mysql_fetch_array($rs))
    {
 

              do{
                          $html1="
                          <tr>
                              <td>".utf8_encode($row['Zona_nombre'])."</td>
                              <td>".utf8_encode($row['Zona_obs'])."</td>
                          </tr>
                        ";
                $html1o=$html1o.$html1;

              }while($row=mysql_fetch_array($rs));
            
          }
             $html2="</table>";
          $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html.$html1o.$html2, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
          $html=""; $html1=""; $html1o=""; $html2="";
          * 
          */

$html="
    <table border=\"1\" cellspacing=\"3\" cellpadding=\"4\">
           <tr>
                <th align=\"center\" colspan=\"1\" bgcolor=\"#cccccc\">
                  <b>Motivo de consulta</b>
                </th>
           </tr>
           <tr>
              <td align=\"justify\">
               ".utf8_encode($Motivo)."
           </td>

           </tr>
    </table>
";

$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
      $html=""; $html1=""; $html1o=""; $html2="";
$pdf->Ln(10);
   $html="
          <table border=\"0\"  width=\"400\">
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
                                                Nombre y Firma del Doctor
                      </td>
                      <td width=\"20%\">
                      </td>
                      <td width=\"40%\" align=\"center\">
                                                Nombre y Firma del Paciente
                      </td>
                 </tr>
          </table>
         ";

$pdf->writeHTMLCell($w=0, $h=0, $x='42', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->output("HC_".$fol.".pdf",'D');



?>
