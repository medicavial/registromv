
<div class="container" style="width: 100%"> 
	<form id="form-procMedicoRed" name="form-procMedicoRed">
	<div class="panel panel-primary">
  		<div class="panel-heading">
    		<h3 class="panel-title" align="center"><b>Procedimientos M&eacute;dicos</b></h3>
  		</div><!-- End panel-heading -->
  		<div class="panel-body">
    		<div class="row">
				<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon">Procedimiento: </span>
						<input type="text" class="form-control" id="proc" name="proc" required="" placeholder="Escriba su procedimiento">
					</div>
				</div>
    		</div><!-- End row -->
    		<br />
    		<div class="row">
				<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon">Observaciones: </span>
						<textarea class="form-control" rows="3" id="obs" name="obs" style="resize:none;" ></textarea>
					</div>
				</div>
				
    		</div><!-- End row -->
    		<br />
    		<input type="hidden" name="fol" value="<?echo $fol?>">
    		<input type="hidden" name="Not" value="<?echo $Not?>">
    		<input type="hidden" id="usuario" name="usuario" value="<?echo $_SESSION["usuClave"]?>"> 
    		<button type="button" id="btn-addProcMedicos" class="btn btn-success" >Agregar</button>
    	<?
    		echo "<button type=\"button\" class=\"btn btn-primary\" style=\"float:right\" onclick=\"document.location.href='ejecutaprocMedRed.php?fol=".$fol."&Not=".$Not."'\">Siguiente</button>";
    	?>
  		</div><!-- End panel-body -->
	</div><!-- End panel panel-default -->
	</form>	
	
	<div id="resultadoPMR">
		<?
			require "list_procMedicosRed.php";
		?>
	</div>
</div><!-- End container -->
<br><br><br>



