
<form name="Pronostico" id="Pronostico" action="guardaPronosticoRed.php?fol=<?echo $fol;?>&Not=<?echo $Not;?>" method="POST">

        <div class="container" style="width:100%" >
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title" align="center"> Pron&oacute;stico</h3>
              </div>

                <div class="panel-body"> 
                  
                  <div class="row" align="center">                    
                      <div class="col-md-12">
                        <div class="container" style="width:100%"  >
                            <div class="panel panel-default" style="width:60%">
                              <div class="panel-heading">
                                <h3 class="panel-title" align="center"> Observaciones al Expediente</h3>
                                </div>

                              
                          
                            
                             <textarea rows="6" class="form-control" name="obsexp" id="obsexp" onpaste="return false" style="resize:none; border: none;" required=""onkeypress="return soloNumLetraspuntocoma(event)"></textarea>
                           
                          
                      </div>
                     </div> 


                    
                </div>

              </div><!--fin del row principal-->
                <br>
                <br>
                <div class="row">
                  <div class="col-md-10">
                  </div>
                  <div class="col-md-2">
                       <input type="submit" name="guardaProno" id="guardaProno" class="btn btn-success"  value="Guardar" />
                  </div>
               
           </div>
           


        </div>
        </div>
        </div>
</form>
