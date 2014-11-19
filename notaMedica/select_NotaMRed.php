<?php
require 'validaUsuario.php';
// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects=array(
"vehiculo"=>"TipoVehiculo",
"posicion"=>"PosicionAcc"
);

function validaSelect($selectDestino)
{
	// Se valida que el select enviado via GET exista
	global $listadoSelects;
	if(isset($listadoSelects[$selectDestino])) return true;
	else return false;
}

function validaOpcion($opcionSeleccionada)
{
	// Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
	if(is_numeric($opcionSeleccionada)) return true;
	else return false;
}

$selectDestino=$_GET["select"]; $opcionSeleccionada=$_GET["opcion"];

if(validaSelect($selectDestino) && validaOpcion($opcionSeleccionada))
{
	$tabla=$listadoSelects[$selectDestino];
	
	$query="SELECT id, opcion FROM $tabla WHERE relacion='$opcionSeleccionada'";
        $rs=mysql_query($query,$conn);
      

	if($row=  mysql_fetch_array($rs)){
	// Comienzo a imprimir el select
	echo "<span class=\"input-group-addon\">Posici&oacute;n &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><select name='".$selectDestino."' id='".$selectDestino."' style='width:270px;'onChange='cargaContenido(this.id)' class= \"form-control\">";
	echo "<option value='0'>*Seleccione</option>";
	do
	{
		// Convierto los caracteres conflictivos a sus entidades HTML correspondientes para su correcta visualizacion
		$row[1]=htmlentities($row[1]);
		// Imprimo las opciones del select
		echo "<option value='".$row[0]."'>".$row[1]."</option>";
	}while($row=mysql_fetch_row($rs));
	echo "</select>";
        } else{
            ?>
        <div class="input-group">
         <span class="input-group-addon">Posici&oacute;n &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
            <select name="posicion" id="posicion" class="form-control"  style="width:270px" >
            <option value="0">  *Seleccione </option>
        </select>
        </div>
        <?

        }

}

?>
