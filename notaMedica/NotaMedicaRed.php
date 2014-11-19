<?php
require 'validaUsuario.php';
require "enc.php";//encabezado de html


//$query="SELECT Exp_nombre, Exp_paterno, Exp_materno, Cia_nombrecorto, Exp_siniestro, Exp_reporte, Exp_poliza, Exp_telefono, Exp_mail, Exp_fechaNac, Exp_edad, Exp_meses, Exp_sexo, Ocu_clave, Edo_clave, Rel_clave FROM Expediente Inner Join Compania On Expediente.Cia_clave=Compania.Cia_clave WHERE Exp_folio='".$fol."'";
$query="SELECT Exp_nombre, Exp_paterno, Exp_materno, Exp_telefono, Exp_mail, Exp_fechaNac, Exp_edad, Exp_meses, Exp_sexo, Ocu_clave, Edo_clave, Rel_clave FROM Expediente Inner Join Compania On Expediente.Cia_clave=Compania.Cia_clave WHERE Exp_cancelado=0 and Exp_folio='".$fol."'";
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
$Sexo                 =$row['Exp_sexo'];
$ocupacion            =$row['Ocu_clave'];
$edoC                 =$row['Edo_clave'];
$relC                 =$row['Rel_clave'];
?>
<script>
  $(function() {
    $( "#fecnac" ).datepicker();
     $("#fecnac").datepicker("option", { dateFormat: "dd/mm/yy" });
  });
  </script>

<form name="Nota Medica" Id="Nota Medica" method="POST" action="guardaHistoriaRed.php?fol=<?echo$fol;?>" onLoad="scroll()">

<div class="container" style="width: 100%"> 
<div class="page-header">
    <h1>Nota M&eacute;dica <small>Red</small></h1>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title" align="center">Datos del paciente</h3>
  </div>
  <div class="panel-body">
  
     
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
                  <span class="input-group-addon">Fecha de Nacimiento: </span>                  
                <input for="element_4_1" type=text class= "form-control" name="fecnac" id="fecnac" required="" onBlur="checkdate(this,1)"  value="<?echo $FechaN;?>" >
              </div>
            </div>
              
           <div class="col-md-3">   
              <div class="input-group">
                  <span class="input-group-addon">A&ntilde;os: </span>                  
                <input for="element_4_1" type=text class= "form-control" name="txtedad" id="txtedad" required="" onkeypress="return soloNumeros(event)" maxlength="3"value="<?echo $edad;?>" >
              </div>
            </div>
              
           <div class="col-md-3">   
              <div class="input-group">
                  <span class="input-group-addon">Meses: </span>                  
                <input for="element_4_1" type=text class= "form-control" id="txtmeses" class= "form-control" name="txtmeses"  onkeypress="return soloNumeros(event)"  value="<?echo $meses;?>" >
              </div>
           </div>    

             <div class="col-md-3">   
              <div class="input-group">
                  <span class="input-group-addon">Sexo: </span> 
                  <span class="input-group-addon">                 
                <input type='radio' name='sexo' id='sexo'   value='M'/>  M <input type='radio' name='sexo' id='sexo'  Checked value='F'/>  F
              </span>
              </div>
           </div>    
              
   </div>
      <br/>
      <div class="row">
              <div class="col-md-3">
                     <div class="input-group">
                           <span class="input-group-addon">Tipo de trabajo:</span>
                           
                                        <select required="required" name="Ocupacion" id="Ocupacion"   class= "form-control"   style="width: 150px;">
                                        
                                            <option value="-1"> *Seleccione </option>
				           <?php
                                               {
					          $query = "SELECT Ocu_clave, Ocu_nombre FROM Ocupacion";
					           $rs = mysql_query($query,$conn);
					             if($row = mysql_fetch_array($rs))
					                  {
              					               do
                                                                   {
                                                                     if($row["Ocu_clave"]==$ocupacion){
                                                                      echo "<option value=\"".$row["Ocu_clave"]."\" selected>".$row["Ocu_nombre"]."</option>";
                                                                    }
                                                                    else{
                                                                      echo "<option value=\"".$row["Ocu_clave"]."\">".$row["Ocu_nombre"]."</option>"; 
                                                                    }
						                   }while ($row = mysql_fetch_array($rs));

				                           }
						             else
						         	echo "Error al obtener el catalogo llega";
                                                      }
					    ?>
					</select>                             
                     </div>    
              </div>
              <div class="col-md-3">
                     <div class="input-group">
                           <span class="input-group-addon">Estado civil:</span>
                           
                                        <select required="required" name="EdoCivil" id="EdoCivil"  class= "form-control"  style="width: 150px;">
			                <option value="-1"> * Seleccione </option>
				           <?php
                                               {
					          $query = "SELECT Edo_clave, Edo_nombre FROM EdoCivil";
					           $rs = mysql_query($query,$conn);
					             if($row = mysql_fetch_array($rs))
					                  {
              					               do
                                                                   {
                                                                     if($row["Edo_clave"]==$edoC){
                                                                        echo "<option value=\"".$row["Edo_clave"]."\" selected>".$row["Edo_nombre"]."</option>";
                                                                    }
                                                                    else{
                                                                        echo "<option value=\"".$row["Edo_clave"]."\">".$row["Edo_nombre"]."</option>";
                                                                    }
						                   }while ($row = mysql_fetch_array($rs));

				                           }
						             else
						         	echo "Error al obtener el catalogo llega";
                                                      }
					    ?>
					</select>
                     </div>    
              </div>
                    <div class="col-md-3">
              <div class="input-group">
                  <span class="input-group-addon">Tel&eacute;fono:</span>                  
                  <input type="text" name="telefono"  class= "form-control" id="telefono" required="" maxlength="15" value="<?php echo $Telefono?>" onkeypress="return soloNumeros(event)">
              </div>
          </div>
          <div class="col-md-3">
              <div class="input-group">
                  <span class="input-group-addon">E-mail:</span>
                  <input type="email" name="mail" id="mail" class= "form-control" required="" maxlength="35"  value="<?php echo $Mail?>" onchange="validaMail()">
                  
              </div>
          </div>
      </div>
      <br/>
      <div class="row">
          

          <div class="col-md-6">
              <div class="input-group">
                  <span class="input-group-addon">Obs.MedicoReligiosas:</span>
                  <input type="text" name="Religion" required="" class= "form-control" id="Religion" value="<?echo $relC;?>">
              </div>
          </div>
          
      </div>
      <br/>
      <br/>
      <div class="row">
           <div class="col-md-10">
           </div>
          <div class="col-md-2">
          <input type="Submit" class="btn btn-primary btn-lg"  value="Siguiente" />
          
           </div>
      </div>     
  </div>
</div>  
    
    
</div> 
    
    </form>




  