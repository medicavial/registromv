<?php
require 'validaUsuario.php';
require "enc.php";//encabezado de html


//$query="SELECT Exp_nombre, Exp_paterno, Exp_materno, Cia_nombrecorto, Exp_siniestro, Exp_reporte, Exp_poliza, Exp_telefono, Exp_mail, Exp_fechaNac, Exp_edad, Exp_meses, Exp_sexo, Ocu_clave, Edo_clave, Rel_clave FROM Expediente Inner Join Compania On Expediente.Cia_clave=Compania.Cia_clave WHERE Exp_folio='".$fol."'";
$query="SELECT Exp_nombre, Exp_paterno, Exp_materno, Exp_telefono, Exp_mail, Exp_fechaNac, Exp_edad, Exp_meses, Exp_sexo, Ocu_clave, Edo_clave, Rel_clave 
    FROM Expediente 
    Inner Join Compania On Expediente.Cia_clave=Compania.Cia_clave 
    WHERE Exp_cancelado=0 and Exp_folio='".$fol."'";
$rs= mysql_query($query,$conn);
$row=  mysql_fetch_array($rs);

$nombre               =$row['Exp_nombre'];
$paterno              =$row['Exp_paterno'];
$materno              =$row['Exp_materno'];
$Telefono             =$row['Exp_telefono'];
$Mail                 =$row['Exp_mail'];
$FechaN               =$row['Exp_fechaNac'];
$edad                 =$row['Exp_edad'];
$meses                =$row['Exp_meses'];
$sexo                 =$row['Exp_sexo'];
$ocupacion            =$row['Ocu_clave'];
$edoC                 =$row['Edo_clave'];
$relC                 =$row['Rel_clave'];


    $query = "SELECT Ocu_clave, Ocu_nombre FROM Ocupacion Where Ocu_clave=".$ocupacion;
    $rs = mysql_query($query,$conn);
    $row = mysql_fetch_array($rs);
    $OcuNombre =$row["Ocu_nombre"];

    
    $query = "SELECT Edo_clave, Edo_nombre FROM EdoCivil Where Edo_clave=".$edoC;
    $rs = mysql_query($query,$conn);
    $row = mysql_fetch_array($rs);
    $edoC =$row["Edo_nombre"];
    
   if($sexo=='F')$sexo='Femenino'; else $sexo='Masculino'; 

$query="Select Not_Estatus 
    From Nota_med_red
    Where Exp_folio='".$fol."' and Not_clave='".$Not."'
    ";
$rs=  mysql_query($query,$conn);
$row=  mysql_fetch_array($rs);
$notEstatus=$row['Not_Estatus'];
$progreso = $notEstatus*(7.692307692);

?>
<script>
    $(function() {

    $('.accordion').on('show', function (e) {
         $(e.target).prev('.accordion-heading').addClass('accordion-opened');
    });
   
    $('.accordion').on('hide', function (e) {
        $(this).find('.accordion-heading').not($(e.target)).removeClass('accordion-opened');
    });
       
});
    </script>

<div class="container" style="width: 100%"> 

<div class="panel panel-default">
  <div class="panel-heading">
    <div class="row">
      <div class="col-md-6">
        <h3>Nota M&eacute;dica <small>red</small></h3>
      </div>
      <div class="col-md-6" align="right">
        <h3>Folio No. <b><? echo $fol?> </b></h3>
      </div>
    </div>
  </div> 
  <div class="panel-body">

  <!-- acordeon de pasos anteriores -->
  <div class="container" style="width: 100%">




    <div class="accordion-group-enc">
                    <div class="accordion-heading">
                      <a class="accordion-toggle" href="#collapsePasosAnteriores" style="color:white;text-decoration:none;" data-toggle="collapse" data-parent="#accordion2">
                        <div class="row">
                          <div class="col-md-6">Pasos Anteriores</div>
                          <div class="col-md-6" align="right" style="font-size:18px;">+   </div>
                        </div>
                        
                      </a>
                    </div>
                    <div class="accordion-body collapse" id="collapsePasosAnteriores" style="height: 0px; border:1px solid #3f81ba">
                      <div class="accordion-inner" style="background:white">

                          <div class="row" style="">
          <div class="col-md-12">  
            <div id="content">
              <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                  <li class="active"><a href="#paciente" data-toggle="tab">Paciente</a></li>
                  <?php  
                  if ($notEstatus>=2 && $notEstatus<13) {?>
                    <li><a href="#antecedentes" data-toggle="tab">Antecedentes</a></li>
                  <?php } 
                  if ($notEstatus>=5 && $notEstatus<13) {?>
                    <li><a href="#accidente" data-toggle="tab">Datos del Accidente</a></li>
                  <?php } 
                  if ($notEstatus>=10 && $notEstatus<13) {?>
                    <li><a href="#suministros" data-toggle="tab">Procedimientos y Suministros</a></li>
                  <?php } ?>            
              </ul>
              <div id="my-tab-content" class="tab-content">
                <div class="tab-pane active" id="paciente">
                  <div class="accordion-group">
                    <div class="accordion-heading">
                      <a class="accordion-toggle" href="#collapseDatosPaciente" data-toggle="collapse" data-parent="#accordion2">
                        Datos del paciente
                      </a>
                    </div>
                    <div class="accordion-body collapse" id="collapseDatosPaciente" style="height: 0px; border:1px solid #d9edf7">
                      <div class="accordion-inner" style="background:white">
                        <div class="row"> 
                          <div class="col-md-3">   
                            <div class="input-group">
                              <span class="input-group-addon">Folio: </span>
                              <input type="text" class="form-control" value="<?echo$fol;?>" disabled>
                            </div>
                            <br/>
                          </div>    
                          <div class="col-md-6">   
                            <div class="input-group">
                              <span class="input-group-addon">Nombre: </span>
                              <input type="text" class="form-control" value="<?echo$nombre." ".$paterno." ".$materno;?>" disabled>
                            </div>
                          </div>    
                        </div>

                        <div class="row">
                          <div class="col-md-3">   
                            <div class="input-group">
                              <span class="input-group-addon">FechaNac: </span>                  
                              <input for="element_4_1" type=text class= "form-control" name="fecnac" id="fecnac" onBlur="checkdate(this,1)" disabled value="<?echo $FechaN;?>" >
                            </div>
                          </div>

                          <div class="col-md-3">   
                            <div class="input-group">
                              <span class="input-group-addon">A&ntilde;os: </span>                  
                              <input for="element_4_1" type=text class= "form-control" name="txtedad" id="txtedad" onkeypress="return soloNumeros(event)" maxlength="3"value="<?echo $edad;?>" disabled>
                            </div>
                          </div>

                          <div class="col-md-3">   
                            <div class="input-group">
                              <span class="input-group-addon">Meses: </span>                  
                              <input for="element_4_1" type=text class= "form-control" id="txtmeses" class= "form-control" name="txtmeses"  onkeypress="return soloNumeros(event)"  value="<?echo $meses;?>" disabled>
                            </div>
                          </div>    

                          <div class="col-md-3">   
                            <div class="input-group">
                              <span class="input-group-addon">Sexo: </span>                  
                              <input type=text class= "form-control" name='sexo' id='sexo' value='<?echo$sexo;?>' disabled>
                            </div>
                          </div>    

                        </div>
                        <br/>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="input-group">
                              <span class="input-group-addon">Tipo de trabajo:</span>
                              <input type="text" class="form-control" value="<?echo $OcuNombre;?>" disabled>                           
                            </div>    
                          </div>
                          <div class="col-md-3">
                            <div class="input-group">
                              <span class="input-group-addon">Estado civil:</span>
                              <input type="text" class="form-control" value="<?echo $edoC;?>" disabled> 
                            </div>    
                          </div>
                          <div class="col-md-3">
                            <div class="input-group">
                              <span class="input-group-addon">Tel&eacute;fono:</span>                  
                              <input type="text" name="telefono"  class= "form-control" id="telefono"  maxlength="15" value="<?php echo $Telefono?>" onkeypress="return soloNumeros(event)" disabled>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="input-group">
                              <span class="input-group-addon">E-mail:</span>
                              <input type="text" name="mail" id="mail" class= "form-control"  maxlength="35"  value="<?php echo $Mail?>" onchange="validaMail()" disabled>
                            </div>
                          </div>
                        </div>
                        <br/>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="input-group">
                              <span class="input-group-addon">Obs.MedicoReligiosas:</span>
                              <input type="text" name="Religion" class= "form-control" id="Religion" value="<?echo $relC;?>"disabled>
                            </div>
                          </div>
                        </div>
                        <br/>
                        <br/>
                        <div class="row">
                          <div class="col-md-10">
                          </div>
                          <div class="col-md-2">
                          </div>
                        </div>     
                      </div>
                    </div>
                  </div>                                                                
                </div>
                
                <div class="tab-pane" id="antecedentes">
                  <?php 
                   if ($notEstatus>=2 && $notEstatus<13) {
                  include 'acordeon1.php';}?>        
                </div>
                  <div class="tab-pane" id="accidente">
                  <?php if ($notEstatus>=5 && $notEstatus<13) {
                  include 'acordeon2.php';}?>
                </div>
                <div class="tab-pane" id="suministros">
                  <?if ($notEstatus>=10 && $notEstatus<13) {
                  include 'acordeon3.php';}?>
                </div>
              </div>
            </div>
          </div> 
       </div>          
      <script type="text/javascript">
          jQuery(document).ready(function ($) {
              $('#tabs').tab();
          });
      </script>
      


                      </div>
                    </div>
    </div>





  <br>
    
        <div class="row">               
          <div class="col-md-12" >                
           
                <div class="progress progress-striped">
                  <div class="progress-bar progress-bar-info" role="progressbar"
                       aria-valuenow="<?echo $progreso?>" aria-valuemin="0" aria-valuemax="100"
                       style="width:<?echo $progreso?>%">
                    <label><?echo (int)$progreso?>%</label>
                  </div>
               
            </div>
          </div>
        </div> 
      </div>


<?




switch ($notEstatus)
{
      case 1:
          include 'AntecedentesHeredo.php';
      break;
  
      case 2:
          include 'AntecedentesPersonales.php';
      break;

      case 3:
          include 'AccidentesAnteriores.php';
      break;
      case 4:
          include 'vitalesRed.php';
      break;
      case 5:
          include 'DatosdelAccidente.php';
      break;
      case 6:
          include 'EmbarazoRed.php';
      break;
      case 7:
          include 'LesionRed.php';
      break;
       case 8:
          include 'EstadoGeneralRed.php';
      break;
       case 9:
          include 'EstudiosRealizadosRed.php';
      break;
      case 10:
          include 'procMedicosRed.php';
      break;
      case 11:
          include 'suministrosRed.php';
      break;
      case 12:
          include 'PronosticoRed.php';
      break;
  case 13:
          include 'imprimeNota.php';
      break;





}


                                                                                        
?>

 

</div>
</div>      
    
</div> 