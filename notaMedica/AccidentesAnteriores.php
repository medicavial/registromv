
<form id="accRed" name="accRed">
    
<div class="container" style="width: 100%"> 
    <div class="panel panel-primary">
        <div class="panel-heading">
         <h3 class="panel-title" align="center">Accidentes Anteriores</h3>
        </div>    
            
           <div class="panel-body">


                            <div class="row">

                             
                         


                   <div class="col-md-2" >
                                    <div class="input-group">
                                         <span class="input-group-addon" style="height:35px">Accidente: </span>
                                         <span class="input-group-addon">
                                            <input type='radio' name='Accidente' id="Accidente" value='Si' Checked />Si <input type='radio' name='Accidente' id="Accidente" value='No'  />No
                                          </span>
                                     </div>
                   </div>


                    <div class="col-md-2" >
                        <div class="input-group">
                                    <span class="input-group-addon">Lugar: </span>
                                     <!--<select name="Lugar" id="Lugar" class="requerido" style="width: 150px;">-->

                                    <select name="Lugar" id="Lugar"  class= "form-control" style="width: 150px;">
                                     <option value="-1"> * Seleccione </option>
			           <?php
                                           {
				          $query = "SELECT Lug_clave, Lug_nombre FROM LugarRed";
				           $rs = mysql_query($query,$conn);
				             if($row = mysql_fetch_array($rs))
				                  {
              				               do
                                                           {
                                                                echo "<option value=\"".$row["Lug_clave"]."\">".$row["Lug_nombre"]."</option>";
					                   }while ($row = mysql_fetch_array($rs));
				                           }
						             else
						         	echo "Error al obtener el catalogo llega";
                                                      }
					    ?>
                                            </select>
                            </div>
                   </div>
                   
                   <div class="col-md-1" >
                                    <div class="input-group">
                                    </div>
                                </div>

                                 

                     <div class="col-md-5" >
                             <div class="input-group">
                                        <span class="input-group-addon">Observaciones: </span>

                                         <input type="text" name="ObsAccidente" id="ObsAccidente" class= "form-control" >
                                       
                                        
                                          </div>
                                          </div>
                                
                     <div class="col-md-1" >
                             <div class="input-group">

                                 <input type="button" name="guardaAcc" id="guardaAcc" class="btn btn-success"  onclick="guardaAccRed('<?echo $fol;?>','<?echo$Not;?>')" value="Agregar Accidente" />
                               </div>
                                </div> 
                              </div>
               <br/>
           <br/>


           <!-- *******************-->

              <div class="row">
               <div class="col-md-12">

                   <div id="resAgregaAccidentesAnterioresRed">
                     <?
                       $query="SELECT HistAcc_clave, Acc_estatus, Lug_nombre, Acc_obs FROM HistoriaAccRed
                           Inner Join LugarRed on HistoriaAccRed.Lug_clave=LugarRed.Lug_clave
                           Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
                      
                       $rs=mysql_query($query,$conn);
                   if($row= mysql_fetch_array($rs))
                         {
                            echo"<table id=\"HistoriaAccRed\" align=\"center\" width=\"100%\" class=\"table table-striped table-hover\">
                                    <tr>
                                         <th width=\"20%\"><b>Accidente</b></th>
                                         <th width=\"15%\"><b>Lugar</b></th>
                                         <th width=\"40%\"><b>Observaciones</b></th>
                                         <th width=\"10%\"><b>Eliminar</b></th>
                                    </tr>";
                              do{
                                   echo "  <tr>";
                                   echo "                <td>".utf8_encode($row['Acc_estatus'])."</td>";
                                   echo "                <td>".utf8_encode($row['Lug_nombre'])."</td>";
                                   echo "                <td>".utf8_encode($row['Acc_obs'])."</td>";
                                   echo "                <td><input type=\"button\" class=\"btn btn-danger btn-xs\" onClick=\"eliminaAccAnt('".$row['HistAcc_clave']."','".$fol."','".$Not."')\" value='Eliminar'";
                                   echo " </tr>";
                                }  while($row = mysql_fetch_array($rs));

                             echo"  </table>";
                            }
                     ?>
                    </div>

               </div>

           </div>
           <br/>
           <br/>
           <div class="row">
                  <div class="col-md-10">
                  </div>
                  <div class="col-md-2">
                      <input type="Button" class="btn btn-primary btn-lg"  value="Siguiente" onClick="document.location.href='accAntSiguiente.php?fol=<?echo $fol;?>&Not=<?echo $Not;?>'" />
                  </div>

           </div>

                               
           



</div>
</div>
</div>
 </form>
<!--   **************************-->



          
