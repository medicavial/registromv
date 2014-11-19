
<div class="container" style="width: 100%"> 
	<form id="form-suministrosRed" name="form-suministrosRed">
	<div class="panel panel-primary">
  		<div class="panel-heading">
    		<h3 class="panel-title" align="center"><b>Suministros</b></h3>
  		</div><!-- End panel-heading -->
  		<div class="panel-body">
  			<div class="row">
				<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon">Tipo: </span>
						<select class="form-control" style="width:40%;" name="tipoSumin" id="tipoSumin" required="required">
							<option value="" > - Seleccione - </option>
							<option value="1">M&eacute;dicamento</option>
							<option value="2">Ortesis</option>
						</select>
					</div>
				</div>				
    		</div><!-- End row -->
    		<br />
    		<div class="row">
				<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon">Descripci&oacute;n: </span>
						<input type="text" class="form-control" id="desc" name="desc" placeholder="Descripcion del suministro" required="required">
					</div>
				</div>
    		</div><!-- End row -->
    		<br />
    		<div class="row">
				<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon">Observaciones: </span>
						<textarea class="form-control" rows="3" id="obs" name="obs" style="resize:none;"></textarea>
					</div>
				</div>
				
    		</div><!-- End row -->
    		<br />
    		<input type="hidden" name="fol" value="<?echo $fol?>">
    		<input type="hidden" name="Not" value="<?echo $Not?>">
    		<input type="hidden" id="usuario" name="usuario" value="<?echo $_SESSION["usuClave"]?>"> 
    		<br>
    		<div class="row">
				<div class="col-md-11">
				</div>
			
    		<button type="button" id="btn-addSuministros" class="btn btn-success" >Agregar</button>
    	</div>
  		<br>
	</form>	
	
	<div id="resultadoSR">
		<?
			require "list_suministrosRed.php";
		?>
	</div><br><br>
		<?
    		echo "<button type=\"button\" class=\"btn btn-primary\" style=\"float:right\" onclick=\"document.location.href='ejecutaSuministrosRed.php?fol=".$fol."&Not=".$Not."'\">Siguiente</button>";
    	?>
</div><!-- End container -->

</div><!-- End panel-body -->
	</div><!-- End panel panel-default -->