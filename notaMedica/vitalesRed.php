

<div class="container" style="width: 100%"> 
<form name="vitales" id="vitales" action="guardaVitalesRed.php?fol=<?echo $fol?>&Not=<?echo $Not;?>" method="POST">	
	<div class="panel panel-primary">
  		<div class="panel-heading">
    		<h3 class="panel-title" align="center"><b>Signos Vitales</b></h3>
  		</div><!-- End panel-heading -->
  		<div class="panel-body">
			<div class="row">
				<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon">Temperatura: </span>
						<input type="text" class="form-control" id="temp" name="temp" placeholder="Temperatura" required="" onKeypress="return soloNumerospunto(event)" onBlur="tempe()" >
						<span class="input-group-addon">&ordm;C</span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon">Talla: </span>
						<input type="text" class="form-control" id="talla" name="talla" placeholder="Talla" required="" onKeypress="return soloNumeros(event)"  onBlur="tall()">
						<span class="input-group-addon">Cm.</span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon">Peso: </span>
						<input type="number" class="form-control" id="peso" name="peso" placeholder="Peso" required="" onKeypress="return soloNumeros(event)" onBlur="peso()">
						<span class="input-group-addon">Kg.</span>
					</div>
				</div>
    		</div><!-- End row -->
    		<br />
    		<div class="row">
				<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon">Frecuencia Respiratoria: </span>
						<input type="text" class="form-control" id="frecResp" name="frecResp" placeholder="F/R" required="" onKeypress="return soloNumeros(event)" onBlur="valid(this.id)">
						<span class="input-group-addon">Rpm.</span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon">Tensi&oacute;n Arterial: </span>
						<input type="text" class="form-control" id="sistole" name="sistole" required=""onKeypress="return soloNumeros(event)" onBlur="valid(this.id)" >
						<span class="input-group-addon"> / </span>
						<input type="text" class="form-control" id="astole" name="astole" required="" onKeypress="return soloNumeros(event)" onBlur="valid(this.id);">
						<span class="input-group-addon">mmHg.</span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="input-group">
						<span class="input-group-addon">Frecuencia Cardiaca: </span>
						<input type="number" class="form-control" id="frecCard" name="frecCard" placeholder="F/C" required="" onKeypress="return soloNumeros(event)" onBlur="valid(this.id)">
						<span class="input-group-addon">Lpm.</span>
					</div>
				</div>
    		</div><!-- End row -->
    		<br />
    		<div class="row">
				<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon">Observaciones: </span>
                                                <textarea class="form-control" rows="3" name="obs" id="obs"></textarea>
					</div>
				</div>
				
    		</div><!-- End row -->
    		<br />
                <div class="row">
                    
                    <div class="col-md-5" >
                        <div class="input-group">
                            
                        </div></div>
                    
                    
                    <div class="col-md-5" >
                             <div class="input-group">

                                 <input type="submit" name="guardaVit" id="guardaVit" class="btn btn-success"  value="Guarda Signos Vitales" />
                               </div>
                                </div> 
                    
                </div>
                   
                
                <br>
              
             
  		</div><!-- End panel-body -->

</div><!-- End container -->

</form>	