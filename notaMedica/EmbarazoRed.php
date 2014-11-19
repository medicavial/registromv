

<form id="embRed" name="embRed" method="POST">
<div class="container" style="width: 100%"> 
    
 <div class="panel panel-primary">
        <div class="panel-heading">
         <h3 class="panel-title" align="center">Antecedentes Gineco-Obstetricos</h3>
        </div>    
            
           <div class="panel-body">


                            <div class="row">


                                 <div class="col-md-1" >
                                    <div class="input-group">
                                        <span class="input-group-addon ">La Paciente esta Embarazada?   </span>
                                        <span class="input-group-addon " style="height:35px;"> <input type="radio" name="Emb" id="Emb" value="Si" onClick="muestra('Embarazo')"/>Si &nbsp;&nbsp;<input type="radio" name="Emb" id="Emb" value="No" onClick="oculta('Embarazo')" Checked/>No </span>
                                     </div>
                                </div>
                                </div>
                                
                <div id="Embarazo" style="display:none;">
                                
                    <br>
                                <div class="row">
                                    <div class="col-md-1" >
                                        <div class="input-group">
                                         <span class="input-group-addon">Actualmente  est&aacute; sometida a control ginecol&oacute;gico?  </span>
                                            <span class="input-group-addon " style="height:35px;"> <input type="radio" name="Gine" id="Gine" value="Si">Si &nbsp;&nbsp; <input type="radio" name="Gine" id="Gine" value="No" Checked>No</span>
                                     </div>
                                    </div>
                                <div class="col-md-5" >
                                </div>
                                <div class="col-md-1 ">
                                        <div class="input-group">
                                        <span class="input-group-addon">Semanas de gestaci&oacute;n</span>
                                        <span class="input-group-addon" style="height:35px;"><select name="semGes" id="semGes"  >
                      <?
                      for($x=0;$x<=45;$x++){
                       echo" <option value=\"".$x."\">".$x."</option>";
                         }
                      ?>
                    </select></span>
                                        </div>
                                </div> 
                                <div class="col-md-5" >
                                </div>
                                    </div>
                    <br>
                    <div class="row">
                                 <div class="col-md-1">
                                          <div class="input-group">
                                           <span class="input-group-addon" style="height:35px;">Dolor Abdominal</span>
                                          <span class="input-group-addon " style="height:35px;"><input type="radio" name="dolAbdominal" id="dolAbdominal" value="Si" />Si &nbsp; &nbsp; <input type="radio" name="dolAbdominal" id="dolAbdominal" value="No"  Checked/>No</span>
                                          </div>
                                </div>
                                <div class="col-md-5">
                                </div>
                                 
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">Descripci&oacute;n: </span>
                                
                                <textarea  id="descEmb" name="descEmb" class="form-control" style="width:250px; height: 35px; resize:none;" ></textarea>
                            </div>
                        </div>
                        </div>
                    <br>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"> Frecuencia card&iacute;aca fetal </span>
                                <input type="text" name="edoEmb" id="edoEmb" class="form-control" style="width:150px">
                            </div>
                        </div>
                    
                        <div class="col-md-1">
                            <div class="input-group">
                                <span class="input-group-addon">Movimientos Fetales</span>
                                <span class="input-group-addon " style="height:35px;"><input type="radio" name="movFet" id="movFet" Value="Si"/>Presentes &nbsp; &nbsp;<input type="radio" name="movFet" id="movFet" Value="No" Checked/>Ausentes</span>
                                
                            </div>
                        </div>
                        <div class="col-md-5">
                        </div>
                        </div>
                   
                        
                        
                 
                    <br>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">Justificaci&oacute;n y obs.  </span>
                                <textarea rows="1" cols="60" name="obsEmb" id="obsEmb" class="form-control" onpaste="return false" style="resize:none; " onkeypress="return soloNumLetraspuntocoma(event)"></textarea>
                   
                            </div>
                     
                        </div>
                        </div> 
                         <br>
                      
                        <DIV class= "row">  

                        <div class="col-md-5 ">
                        </div>   
                        <div class="col-md-6">
                            <div class="input group">
                                <input type="button"  name="guardaEmbRed" id="guardaEmbRed" class="btn btn-success" onclick="GEmbarazoRed('<?echo $fol;?>','<?echo $Not;?>')" value="Guardar Embarazo" />
                                
                            </div>
                        </div>
                    </DIV>  
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            
                         <div id="MuestraEmbRed">
                        <?include'ConsultaEmbRed.php';?>
                          
                        </div>
                            
                        </div> 
                    </div>
                    
         

</div>

                    <DIV class= "row">  

                        <div class="col-md-10 ">
                        </div>   
                        <div class="col-md-2">
                            <div class="input group">
                                <input type="button"  name="siguiente" id="siguiente" class="btn btn-primary" onclick="document.location.href='embSiguiente.php?fol=<?echo $fol;?>&Not=<?echo $Not;?>'" value="Siguiente" />
                                
                            </div>
                        </div>
                    </DIV>  
                    

</div>
</div>
</div>
</form>
    







