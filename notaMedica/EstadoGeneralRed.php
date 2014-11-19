
<form name="Observaciones" id="Observaciones" action="guardaObsRed.php?fol=<?echo $fol;?>&Not=<?echo $Not;?>" method="POST">

        <div class="container" style="width:100%" >
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title" align="center"> Observaciones</h3>
              </div>

                <div class="panel-body"> 
                  
                  <div class="row" align="center">

                    <div class="col-md-12">

                          <div class="container" style="center">
                            <div class="panel panel-default" style="width:60%">
                              <div class="panel-heading">
                                <h3 class="panel-title" align="center"> Estado General y Exploraci&oacute;n F&iacute;sica</h3>
                                </div>

                        
                          
                          <textarea class="form-control" rows="6" name="edoGeneral" id="edoGeneral" onpaste="return false" style="resize:none; border: none;" required="" onkeypress="return soloNumLetraspuntocoma(event)"><?echo $edoGeneral;?></textarea>
                          
                       
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
                       <input type="submit" name="guardaObs" id="guardaObs" class="btn btn-success"  value="Guarda Observaciones" />
                  </div>
               
           </div>


        </div>
        </div>
        </div>
</form>
