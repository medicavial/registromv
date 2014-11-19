
<style>
    fieldset.scheduler-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}

legend.scheduler-border {
    border:none;
    width:auto;
    font-size: 1.2em !important;
    font-weight: bold !important;
    text-align: left !important;
}
    
</style>

<?
 
        
?>
<script>
  $(function() {
    $( "#FechaAcc" ).datepicker();
  });
  </script>
<form name="DatosdelAccidente" Id="DatosdelAccidente" method="POST" action="guardaDatosAccRed.php?fol=<?echo $fol?>&Not=<?echo $Not;?>">
    
<div class="container" style="width: 100%"> 
    <div class="panel panel-primary">
        <div class="panel-heading">
         <h3 class="panel-title" align="center">Datos del Accidente</h3>
        </div>    
            
           <div class="panel-body">


   <div class="row">

                   <div class="col-md-4" >
                                    <div class="input-group">
                                         <span class="input-group-addon">El paciente Llega: </span>
                                            <select name="llega" id="llega" class= "form-control" >
			<option value="-1"> * Seleccione </option>
				<?php

{
					$query = "SELECT Llega_clave, Llega_nombre FROM Llega_red";
					$rs = mysql_query($query,$conn);
					if($row = mysql_fetch_array($rs))
					{
              					do
                                                {
                                                    echo "<option value=\"".$row["Llega_clave"]."\">".$row["Llega_nombre"]."</option>";
						}while ($row = mysql_fetch_array($rs));

				        }
						else
							echo "Error al obtener el catalogo llega";
}
					?>
					</select>
                                     </div>
                   </div>
                                
                                <div class="col-md-4">
                                    
                                    <div class="input-group">
                                        <span class="input-group-addon">Fecha del Accidente</span>
                                        <input type="text" name="FechaAcc" id="FechaAcc" class= "form-control" >
                                    </div>
                                </div>

                        <div class="col-md-4">
                       
                       <div class="input-group">
                           <span class="input-group-addon"> Tipo de vehiculo &nbsp; </span>
                           
                           <select name="vehiculo" id="vehiculo" class= "form-control"  onChange="cargaContenidoRed(this.id); cargaSelectRed();">
			<option value="0"> * Seleccione </option>
				<?php
                                        {
					$query = "SELECT id, opcion FROM TipoVehiculo_red";
					$rs = mysql_query($query,$conn);
					if($row = mysql_fetch_array($rs))
					{
              					do
                                                {
                                                    echo "<option value=\"".$row["id"]."\">".$row["opcion"]."</option>";
						}while ($row = mysql_fetch_array($rs));

				        }
						else
							echo "Error al obtener el catalogo de aseguradoras";
                                        }
					?>
                            </select>
                          
                           
                       </div>
                   </div>
</div>
               <br> <br>
              
      
               <div class="row">
                   
                   <div class="col-md-4">
                       
                       <div class="input-group">
                           <span class="input-group-addon">Posici&oacute;n &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
                     
                                <select name="posicion" id="posicion" class= "form-control"  >
                                      <option value="0"> * Seleccione *</option>
                                </select>
                       </div>
                   </div>
               </div>
               <br> <br>
        <div class="row">
        <div class="col-md-6">
            <div class="container" style="width: 100%"> 
       
        <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title" align="center">Equipo de Seguridad</h3></div> 
        <div class="panel-body" style="width:100%;">
           
            <div class="row">
                <div class="col-md-1">
                    <div class="input-group" id="Nod"  style="display:block" >
                    <span class="input-group-addon" class="form-control"><input name="" type="checkbox" value="0" style="width:20px;height:20px;" disabled="disabled">
                    </span></div>
                </div>
                
                <div class="col-md-11">
                    <div class="input-group" id="Nodtx"  style="display:block"> 
                    <input type="text" value="*No disponible" readonly="" class="form-control" style="width:200px;"><br></div>
                    </div>
            </div>
            
            
            <div class="row">
                <div class="col-md-1">
                    <div class="input-group" id="Cintu" style="display:none">
                        <span class="input-group-addon" class="form-control">
                        <input type="checkbox" name="Seguridad[]" value="1" style="width:20px;height:20px;">  
                        </span>
                    </div>
                </div>
                <div class="col-md-11">
                    <div class="input-group" id="Cintutx" style="display:none">
                        <input type="text" value="Cinturon Puesto" readonly="" class="form-control" style="width:200px;">
                    </div>
                </div>
                
            </div>
            
            
            <div class="row">
                <div class="col-md-1">
                    <div class="input-group" id="Bolsa" style="display:none">
                        <span class="input-group-addon" class="form-control">
                        <input type="checkbox" name="Seguridad[]" value="2" style="width:20px;height:20px;">  
                        </span>
                    </div>
                </div>
                <div class="col-md-11">
                    <div class="input-group" id="Bolsatx" style="display:none">
                        <input type="text" value="Abrio bolsa de aire" readonly="" class="form-control" style="width:200px;">
                    </div>
                </div>
                
            </div>
            
           
            <div class="row">
                <div class="col-md-1">
                    <div class="input-group" id="Ropa" style="display:none">
                        <span class="input-group-addon" class="form-control">
                        <input type="checkbox" name="Seguridad[]" value="3" style="width:20px;height:20px;">  
                        </span>
                    </div>
                </div>
                <div class="col-md-11">
                    <div class="input-group" id="Ropatx" style="display:none">
                        <input type="text" value="Ropa Protectora" readonly="" class="form-control" style="width:200px;">
                    </div>
                </div>
                
            </div>
            
            <div class="row">
                <div class="col-md-1">
                    <div class="input-group" id="Casco" style="display:none">
                        <span class="input-group-addon" class="form-control">
                        <input type="checkbox" name="Seguridad[]" value="4" style="width:20px;height:20px;">  
                        </span>
                    </div>
                </div>
                <div class="col-md-11">
                    <div class="input-group" id="Cascotx" style="display:none">
                        <input type="text" value="Casco puesto" readonly="" class="form-control" style="width:200px;">
                    </div>
                </div>
                
            </div>
            
            
            <div class="row">
                <div class="col-md-1">
                    <div class="input-group" id="Rodi" style="display:none">
                        <span class="input-group-addon" class="form-control">
                        <input type="checkbox" name="Seguridad[]" value="5" style="width:20px;height:20px;">  
                        </span>
                    </div>
                </div>
                <div class="col-md-11">
                    <div class="input-group" id="Roditx" style="display:none">
                        <input type="text" value="Rodilleras" readonly="" class="form-control" style="width:200px;">
                    </div>
                </div>
                
            </div>
            
            <div class="row">
                <div class="col-md-1">
                    <div class="input-group" id="Code" style="display:none">
                        <span class="input-group-addon" class="form-control">
                        <input type="checkbox" name="Seguridad[]" value="6" style="width:20px;height:20px;">  
                        </span>
                    </div>
                </div>
                <div class="col-md-11">
                    <div class="input-group" id="Codetx" style="display:none">
                        <input type="text" value="Coderas" readonly="" class="form-control" style="width:200px;">
                    </div>
                </div>
                
            </div>
            
            
            <div class="row">
                <div class="col-md-1">
                    <div class="input-group" id="Costi" style="display:none">
                        <span class="input-group-addon" class="form-control">
                        <input type="checkbox" name="Seguridad[]" value="7" style="width:20px;height:20px;">  
                        </span>
                    </div>
                </div>
                <div class="col-md-11">
                    <div class="input-group" id="Costitx" style="display:none">
                        <input type="text" value="Costilleras" readonly="" class="form-control" style="width:200px;">
                    </div>
                </div>
                
            </div>
            
            





            
                               
                     
                           
     </div>                                    
     </div>
    
    </div>
                 
    </div>  
    
    

      <div class="col-md-6">
        <div class="container" style="width: 100%">                
        
        <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title" align="center">Descripcion</h3></div> 
        <div class="panel-body" style="width:100%;">
            <div class="row">
                <div class="col-md-1">
                    <div class="input-group" id="Nodi"  style="display:block" >
                    <span class="input-group-addon" class="form-control"><input name="" type="checkbox" value="0" style="width:20px;height:20px;" disabled="disabled">
                    </span></div>
                </div>
                
                <div class="col-md-11">
                    <div class="input-group" id="Noditx"  style="display:block"> 
                    <input type="text" value="*No disponible" readonly="" class="form-control" style="width:200px;"></div>
                    </div>
            </div>
            
            <div class="row">
                <div class="col-md-1">
                    <div class="input-group" id="Volc" style="display:none">
                        <span class="input-group-addon" class="form-control">
                        <input type="checkbox" name="Mecanismo[]" value="1" style="width:20px;height:20px;">  
                        </span>
                    </div>
                </div>
                <div class="col-md-11">
                    <div class="input-group" id="Volctx" style="display:none">
                        <input type="text" value="Volcadura" readonly="" class="form-control" style="width:200px;">
                    </div>
                </div>
                
            </div>
            
            
            <div class="row">
                <div class="col-md-1">
                    <div class="input-group" id="Alca" style="display:none">
                        <span class="input-group-addon" class="form-control">
                        <input type="checkbox" name="Mecanismo[]" value="2" style="width:20px;height:20px;">  
                        </span>
                    </div>
                </div>
                <div class="col-md-11">
                    <div class="input-group" id="Alcatx" style="display:none">
                        <input type="text" value="Alcance" readonly="" class="form-control" style="width:200px;">
                    </div>
                </div>
                
            </div>
            
            <div class="row">
                <div class="col-md-1">
                    <div class="input-group" id="Late" style="display:none">
                        <span class="input-group-addon" class="form-control">
                        <input type="checkbox" name="Mecanismo[]" value="3" style="width:20px;height:20px;">  
                        </span>
                    </div>
                </div>
                <div class="col-md-11">
                    <div class="input-group" id="Latetx" style="display:none">
                        <input type="text" value="Lateral" readonly="" class="form-control" style="width:200px;">
                    </div>
                </div>
                
            </div>
            
            <div class="row">
                <div class="col-md-1">
                    <div class="input-group" id="Fron" style="display:none">
                        <span class="input-group-addon" class="form-control">
                        <input type="checkbox" name="Mecanismo[]" value="4" style="width:20px;height:20px;">  
                        </span>
                    </div>
                </div>
                <div class="col-md-11">
                    <div class="input-group" id="Frontx" style="display:none">
                        <input type="text" value="Frontal" readonly="" class="form-control" style="width:200px;">
                    </div>
                </div>
                
            </div>
            
            <div class="row">
                <div class="col-md-1">
                    <div class="input-group" id="Derr" style="display:none">
                        <span class="input-group-addon" class="form-control">
                        <input type="checkbox" name="Mecanismo[]" value="5" style="width:20px;height:20px;">  
                        </span>
                    </div>
                </div>
                <div class="col-md-11">
                    <div class="input-group" id="Derrtx" style="display:none">
                        <input type="text" value="Derrapon" readonly="" class="form-control" style="width:200px;">
                    </div>
                </div>
                
            </div>
            
            
            <div class="row">
                <div class="col-md-1">
                    <div class="input-group" id="Simp" style="display:none">
                        <span class="input-group-addon" class="form-control">
                        <input type="checkbox" name="Mecanismo[]" value="6" style="width:20px;height:20px;">  
                        </span>
                    </div>
                </div>
                <div class="col-md-11">
                    <div class="input-group" id="Simptx" style="display:none">
                        <input type="text" value="Solo Impacto" readonly="" class="form-control" style="width:200px;">
                    </div>
                </div>
                
            </div>
            
            <div class="row">
                <div class="col-md-1">
                    <div class="input-group" id="Imap" style="display:none">
                        <span class="input-group-addon" class="form-control">
                        <input type="checkbox" name="Mecanismo[]" value="7" style="width:20px;height:20px;">  
                        </span>
                    </div>
                </div>
                <div class="col-md-11">
                    <div class="input-group" id="Imaptx" style="display:none">
                        <input type="text" value="Impacto y Aplastamiento" readonly="" class="form-control" style="width:200px;">
                    </div>
                </div>
                
            </div>
            
            
            <div class="row">
                <div class="col-md-1">
                    <div class="input-group" id="Caid" style="display:none">
                        <span class="input-group-addon" class="form-control">
                        <input type="checkbox" name="Mecanismo[]" value="8" style="width:20px;height:20px;">  
                        </span>
                    </div>
                </div>
                <div class="col-md-11">
                    <div class="input-group" id="Caidtx" style="display:none">
                        <input type="text" value="Ca&iacute;da" readonly="" class="form-control" style="width:200px;">
                    </div>
                </div>
                
            </div>
            
            <div class="row">
                <div class="col-md-1">
                    <div class="input-group" id="Lesdep" style="display:none">
                        <span class="input-group-addon" class="form-control">
                        <input type="checkbox" name="Mecanismo[]" value="9" style="width:20px;height:20px;">  
                        </span>
                    </div>
                </div>
                <div class="col-md-11">
                    <div class="input-group" id="Lesdeptx" style="display:none">
                        <input type="text" value="Lesi&oacute;n deportiva" readonly="" class="form-control" style="width:200px;">
                    </div>
                </div>
                
            </div>
            
            
            <div class="row">
                <div class="col-md-1">
                    <div class="input-group" id="Lestra" style="display:none">
                        <span class="input-group-addon" class="form-control">
                        <input type="checkbox" name="Mecanismo[]" value="10" style="width:20px;height:20px;">  
                        </span>
                    </div>
                </div>
                <div class="col-md-11">
                    <div class="input-group" id="Lestratx" style="display:none">
                        <input type="text" value="Lesi&oacute;n traslado" readonly="" class="form-control" style="width:200px;">
                    </div>
                </div>
                
            </div>
                    
            
            <div class="row">
                <div class="col-md-1">
                    <div class="input-group" id="ManSub" style="display:none">
                        <span class="input-group-addon" class="form-control">
                        <input type="checkbox" name="Mecanismo[]" value="11" style="width:20px;height:20px;">  
                        </span>
                    </div>
                </div>
                <div class="col-md-11">
                    <div class="input-group" id="ManSubtx" style="display:none">
                        <input type="text" value="Maniobra s&uacute;bita" readonly="" class="form-control" style="width:200px;">
                    </div>
                </div>
                
            </div>
            
             <div class="row">
                <div class="col-md-1">
                    <div class="input-group" id="Otr" style="display:none">
                        <span class="input-group-addon" class="form-control">
                        <input type="checkbox" name="Mecanismo[]" value="11" style="width:20px;height:20px;">  
                        </span>
                    </div>
                </div>
                <div class="col-md-11">
                    <div class="input-group" id="Otrtx" style="display:none">
                        <input type="text" value="Otro" readonly="" class="form-control" style="width:200px;">
                    </div>
                </div>
                
            </div>
                             
                                  
                                  
                                  

               
           </div>
              </div>
                       </div>
                                        
                                       
                                        
                                    
                               
                   
               
               </div> </div>
               <br><br> 

        <div class="row">
        <div class="col-md-6">
        <div class="container" style="width: 100%"> 
        <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title" align="center">El paciente Presento</h3></div> 
        <center>
            <div class="panel-body" style="width:100%;">
            
                 
                <div class="row">         
                    <div class="col-md-6">
                        
                    <div class="input-group">
                        <span class="input-group-addon"><input type="checkbox" name="Vomito" id="Vomito" value="S"></span>
                        <input type="text" value="V&oacute;mito" readonly="" class= "form-control">
                    </div> 
                </div>
                  
                <div class="col-md-6">
                    
                    <div class="input-group">
                        <span class="input-group-addon"><input type="checkbox" name="Mareo" id="Mareo" value="S"></span>
                        <input type="text" value="Mareo" readonly="" class= "form-control">
                    </div> 
                    </div>
                </div> 
            <br>
                   
                   <div class="row">
                <div class="col-md-6">
                    
                    <div class="input-group">
                        <span class="input-group-addon"><input type="checkbox" name="Nauseas" id="Nauseas" value="S"></span>
                        <input type="text" value="Nauseas" readonly="" class= "form-control">
                    </div> 
                    
                </div>
                
                 
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon"><input type="checkbox" name="Conocimiento" id="Conocimiento" value="S"></span>
                        <input type="text" value="Conocimiento" readonly="" class= "form-control">
                    </div> 
                </div>
                   </div>
            <br>
                   <div class="row">
                   <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon"><input type="checkbox" name="Cefalea" id="Cefalea" value="S"></span>
                        <input type="text" value="Cefalea" readonly=""class= " form-control">
                    </div> 
                </div> 
                   </div>
                   
      
                
                   </div> </center> 





</div>
</div>

</div>

            
            
            
            <div class="col-md-6">
        <div class="container" style="width: 100%"> 
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title" align="center">Mecanismo de la lesi&oacute;n</h3></div> 
        <div class="panel-body" style="width:100%;">
            
 <textarea rows="7" cols="90" id="mecanismo" name="mecanismo"  onpaste="return false" style="resize:none; border:none " onkeypress="return soloNumLetraspuntocoma(event)"><?echo $mecanismo;?></textarea>




</div>
</div>

</div>
</div>
            
            
            
</div>








                
              
                 
               <br><br>
               
               
           <br><br>
               
                 <div class="row">
           <div class="col-md-5">
           </div>
          <div class="col-md-2">
          <input type="Submit" class="btn btn-success btn-lg"  value="Guarda Datos de Acc"   />
          
           </div>
      </div>
      <br><br>



             
               
              
               
               
               
          
 </div>
               
                
                   
  </div>
               
               
    </div>

</form>