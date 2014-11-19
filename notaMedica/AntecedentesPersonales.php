
<div class="container" style="width: 100%"> 
    
      <div class="panel panel-primary">
               <div class="panel-heading">
                       <h3 class="panel-title" align="center">Antecedentes Personales</h3>
               </div>
               <div class="panel-body">
                   
                     <div class='row'>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                      <span class='input-group-addon' style='width:170px;'>Cr&oacutenico-Degenerativos:</span>
                                            <select name="PadecimientosCronicos" id="PadecimientosCronicos" class="form-control" style='width:170px;'>
		                                    <option value="-1"> * Seleccione </option>
			                                    <?php
                                                                  {
				                                    $query = "SELECT Pad_clave, Pad_nombre FROM Padecimientos";
				                                    $rs = mysql_query($query,$conn);
				                                    if($row = mysql_fetch_array($rs))
				                                          {
              				                                      do
                                                                                 {
                                                                                    echo "<option value=\"".$row["Pad_clave"]."\">".$row["Pad_nombre"]."</option>";
					                                         }while ($row = mysql_fetch_array($rs));
				                                          }
						                           else
						         	               echo "Error al obtener el catalogo llega";
                                                                   }
					                     ?>
                                             </select>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                  <div class='input-group'>
                                        <span class='input-group-addon'>Observaciones:</span>
                                         <input type="text" name="ObsCronico" id="ObsCronico" class='form-control'>
                                  </div>
                            </div>    
                            <div class='col-md-2'>
                                  <div class='input-group'>                                       
                                      <input type="button" onClick="guardaPadCronRed('<?echo $fol;?>','<?echo $Not;?>');" name="GuardaPad" id="GuardaPad" Value="Agregar Padecimiento" class="btn btn-success" style='width:160px;'>    
                                  </div>
                            </div>                                                      
                     </div>
                      <br>
                      <div class="row">
                               <div class="col-md-12">
                                   <div id="Cronicos">
                                      <?
                                      $query="SELECT Hist_clave, Pad_nombre, Pad_obs 
           FROM HistoriaPadecimientoRed 
           Inner Join Padecimientos on HistoriaPadecimientoRed.Pad_clave=Padecimientos.Pad_clave 
           Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
    $rs=mysql_query($query,$conn);
    
if($row=mysql_fetch_array($rs)){

 echo"<table  width=\"100%\" class=\"table table-striped table-hover\" >
  <tr>
       <th width=\"20%\"><b>Enfermedad</b></th>
       <th width=\"80%\"><b>Observaciones</b></th>
        <th width=\"10%\"><b>Eliminar</b></th>
  </tr>";

  do{
  echo "  <tr>";
  echo "                <td>".$row['Pad_nombre']."</td>";
  echo "                <td>".$row['Pad_obs']."</td>";
  echo "                <td><input type='button' onClick=\"eliminarPadCronRed('".$row['Hist_clave']."','".$fol."','".$Not."')\" value='Eliminar' class=\"btn btn-danger btn-xs\" >";
  echo " </tr>";
  }while($row = mysql_fetch_array($rs));
  
  echo"</table>";
}
                                      ?>
                                   </div>
                                </div>                             
                      </div>
                      
                      
                     <div class='row'>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                      <span class='input-group-addon' style='width:170px;'>Otras enfermedades:</span>
                    <select name="Otras" id="Otras" class="form-control" style='width:170px;'>
		           <option value="-1"> * Seleccione </option>
			           <?php
                                           {
				          $query = "SELECT Otr_clave, Otr_nombre FROM Otras";
				           $rs = mysql_query($query,$conn);
				             if($row = mysql_fetch_array($rs))
				                  {
              				               do
                                                           {
                                                                echo "<option value=\"".$row["Otr_clave"]."\">".$row["Otr_nombre"]."</option>";
					                   }while ($row = mysql_fetch_array($rs));
				                           }
						             else
						         	echo "Error al obtener el catalogo llega";
                                                      }
					    ?>
                    </select>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                  <div class='input-group'>
                                        <span class='input-group-addon'>Observaciones:</span>
                                          <input type="text" name="ObsOtras" id="ObsOtras" class='form-control'>
                                  </div>
                            </div>    
                            <div class='col-md-2'>
                                  <div class='input-group'>  
                                      <input type="button" onClick="guardaOtrEnfRed('<?echo $fol;?>','<?echo $Not;?>') "name="GuardaOtras" id="GuardaOtras" Value="Agregar Otras" class="btn btn-success" style='width:160px;'>                                       
                                  </div>
                            </div>                                                      
                     </div>
                      <br/>
                      
                      <div class="row">
                             <div class="col-md-12">
                                        <div id="OtrasEnf">
                                            <?
                                           $query="SELECT HistOt_clave, Otr_nombre, HistOt_obs 
                                               FROM HistoriaOtrasRed 
                                               Inner Join Otras on HistoriaOtrasRed.Otr_clave=Otras.Otr_clave 
                                               Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
                                           $rs=mysql_query($query,$conn);

                                         if($row=mysql_fetch_array($rs)){

                                          echo"<table width=\"100%\" class=\"table table-striped table-hover\" >
                                                  <tr>
                                                         <th width=\"20%\"><b>Enfermedad</b></th>
                                                         <th width=\"80%\"><b>Observaciones</b></th>
                                                         <th width=\"10%\"><b>Eliminar</b></th>
                                                  </tr>";

                                           do{
                                               echo "  <tr>";
                                               echo "  <td>".utf8_encode($row['Otr_nombre'])."</td>";
                                               echo "  <td>".utf8_encode($row['HistOt_obs'])."</td>";
                                               echo "  <td><input type='button' onClick=\"eliminarOtrEnfRed(".$row['HistOt_clave'].",'".$fol."','".$Not."')\" value='Eliminar' class=\"btn btn-danger btn-xs\" >";
                                               echo " </tr>";
                                             }while($row = mysql_fetch_array($rs));
                                             echo"</table>";
                                                   }
                                            ?>
                                        </div>
                             </div>
                      </div>   
                      
                      
                     <div class='row'>
                            <div class='col-md-4'>
                                <div class='input-group'>
                                      <span class='input-group-addon' style='width:170px;'>Alergias:</span>
                    <select name="Alergias" id="Alergias"  class='form-control' style='width:170px;' >
		           <option value="-1"> * Seleccione </option>
			           <?php
                                           {
				          $query = "SELECT Ale_clave, Ale_nombre FROM Alergias";
				           $rs = mysql_query($query,$conn);
				             if($row = mysql_fetch_array($rs))
				                  {
              				               do
                                                           {
                                                                echo "<option value=\"".$row["Ale_clave"]."\">".$row["Ale_nombre"]."</option>";
					                   }while ($row = mysql_fetch_array($rs));
				                           }
						             else
						         	echo "Error al obtener el catalogo llega";
                                                      }
					    ?>
                    </select>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                  <div class='input-group'>
                                        <span class='input-group-addon'>Observaciones:</span>
                                         <input type="text" name="ObsAlergias"  id="ObsAlergias" class='form-control'>
                                  </div>
                            </div>    
                            <div class='col-md-2'>
                                  <div class='input-group'>      
                                      <input type="button" onClick="guardaAlergiasRed('<?echo $fol;?>','<?echo$Not;?>')" name="GuardaAlergias" id="GuardaAlergias" Value="Agregar Alergia" class="btn btn-success" style='width:160px;'>                                      
                                  </div>
                            </div>                                                      
                     </div>
                      <br/>
                      <div class="row">
                          <div class="col-md-12">
                                      <div id="resAlergias">
                                        <?php
                                             $query="SELECT HistA_clave, Ale_nombre, Ale_obs 
                                                     FROM HistoriaAlergiasRed 
                                                     Inner Join Alergias on HistoriaAlergiasRed.Ale_clave=Alergias.Ale_clave 
                                                     Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
                                                     $rs=mysql_query($query,$conn);
 
                                             if($row=  mysql_fetch_array($rs)){
                                   echo"<table width=\"100%\" class=\"table table-striped table-hover\" >
                                                 <tr>
                                                      <th width=\"20%\"><b>Alergia</b></th>
                                                      <th width=\"80%\"><b>Observaciones</b></th>
                                                      <th width=\"10%\"><b>Eliminar</b></th>
                                                 </tr>";
                                       do{
                                             echo "<tr>";
                                                 echo "<td>".utf8_encode($row['Ale_nombre'])."</td>";
                                                 echo "<td>".utf8_encode($row['Ale_obs'])."</td>";
                                                 echo "<td><input type='button' onClick=\"eliminarAlergiaRed('".$row['HistA_clave']."','".$fol."','".$Not."')\" value='Eliminar' class=\"btn btn-danger btn-xs\" >";
                                             echo " </tr>";
                                         }while($row = mysql_fetch_array($rs));
                                    echo"</table>";
                                 }
  ?>  
                                      </div>
                          </div>                          
                      </div>
                      
                      <div class='row'>
                          <div class='col-md-4'>
                                  <div class='input-group'>
                                      <span class='input-group-addon' style='width:170px;'> <b>Padecimientos espalda:</b></span>
                                     <span class='input-group-addon' style='width:150px;' >
                                          <input type="radio" name="Espalda" id="Espalda" value="Si" onclick="enableE('Oesp','ObsEspalda','GuardaEsp')" />  Si <input type="radio" name="Espalda" id="Espalda" value="No" Checked onclick="disableE('Oesp','ObsEspalda','GuardaEsp')"/> No
                                     </span>
                                  </div>    
                          </div>
                          
                          <div class='col-md-6' >
                              <div class='input-group'>
                                <span class='input-group-addon'id="Oesp" style="visibility:hidden;" style='width:200px;' >Observaciones:</span>   
                              <input type="text" name="ObsEspalda" id="ObsEspalda" class='form-control' style="visibility:hidden;">
                              </div>
                          </div>  
                          <div class='col-md-2'>
                              <div class='input-group'>
                                     <input type="button" onClick="guardaEspRed('<?echo $fol;?>','<?echo $Not;?>')" name="GuardaEsp" id="GuardaEsp" Value="Guarda Padecimiento" class="btn btn-success"  style="width: 160px; visibility:hidden;"/>
                               </div>                                 
                          </div>                                                    
                      </div>
                   <br/>
                   <div class="row">
                          <div class="col-md-12">
                                     <div id="resPadEspalda">   
                                         <?php
                                               $query="SELECT HistE_clave, Esp_estatus, Esp_obs 
                                                       FROM HistoriaEspaldaRed 
                                                       Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
                                               $rs=mysql_query($query,$conn);
 
                                      if($row=  mysql_fetch_array($rs)){ 
    
                                      echo"<table width=\"100%\" class=\"table table-striped table-hover\" >
                                                 <tr>
                                                       <th width=\"90%\"><b>Observaciones</b></th>
                                                       <th width=\"10%\"><b>Eliminar</b></th>
                                                 </tr>";

                                          do{ 
                                             echo "<tr>";
                                                      echo "<td>".utf8_encode($row['Esp_obs'])."</td>";
                                                      echo "<td><input type='button' onClick=\"eliminarEspRed('".$row['HistE_clave']."','".$fol."','".$Not."')\" value='Eliminar' class=\"btn btn-danger btn-xs\">";
                                             echo "</tr>";
                                            }while($row = mysql_fetch_array($rs)); 
                                     echo" </table>";
                                     }
                                     ?>
                                     </div>   
                          </div>
                   </div>
                      
                      <div class='row'>
                          <div class='col-md-4'>
                                  <div class='input-group'>
                                      <span class='input-group-addon' style='width:170px;'><b>Ha recibido tratamiento<br/> Quiropractico:<sub>(Huesero)</sub></b></span>
                                     <span class='input-group-addon' style='width:150px;' >
                                          <input type="radio" name="Quiro" id="Quiro" value="Si" onclick="enableE('Oquiro','ObsQuiro','GuardaQuiro')"/> Si <input type="radio" name="Quiro" id="Quiro" value="No" Checked onclick="disableE('Oquiro','ObsQuiro','GuardaQuiro')"/> No
                                     </span>
                                  </div>    
                          </div>
                          
                          <div class='col-md-6' >
                              <div class='input-group'>
                                <span class='input-group-addon'id="Oquiro" style="visibility:hidden;" style='width:200px;' >Observaciones:</span>   
                              <input type="text" name="ObsQuiro" id="ObsQuiro" Class='form-control'  style='visibility:hidden;'>
                              </div>
                          </div>  
                          <div class='col-md-2'>
                              <div class='input-group'>
                                  <input type="button" onClick="guardaQuiroRed('<?echo $fol;?>','<?echo $Not;?>')" name="GuardaQuiro" id="GuardaQuiro" Value="Agregar Tratamiento"class="btn btn-success" style="width: 160px; visibility:hidden;"/>                                     
                               </div>                                 
                          </div>                                                    
                      </div>
                      <br/>
                      <div class="row">
                          <div class="col-md-12">
                                <div id="resQuiropractico">
                               <?php
                                    $query="SELECT HistoriaQ_clave, Quiro_estatus, Quiro_obs 
                                            FROM HistoriaQuiroRed 
                                            Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
                                    $rs=mysql_query($query,$conn);
 
                            if($row=  mysql_fetch_array($rs)){
                                  echo"<table  width=\"100%\" class=\"table table-striped table-hover\">
                                           <tr>
                                               <th width=\"90%\"><b>Observaciones</b></th>
                                               <th width=\"10%\"><b>Eliminar</b></th>
                                           </tr>";

                                    do{
                                        echo "<tr>";
                                        echo "                <td>".utf8_encode($row['Quiro_obs'])."</td>";
                                        echo "                <td><input type='button' onClick=\"eliminarQuiroRed('".$row['HistoriaQ_clave']."','".$fol."','".$Not."')\" value='Eliminar' class=\"btn btn-danger btn-xs\">";
                                        echo " </tr>";
                                     }while($row = mysql_fetch_array($rs));
                                   echo"</table>";
                                  }
  ?>                
                                    
                                </div>
                          </div>
                      </div>
                      <div class='row'>
                          <div class='col-md-4'>
                                  <div class='input-group'>
                                      <span class='input-group-addon' style='width:185px;'><b>Ha usado plantillas:</b></span>
                                     <span class='input-group-addon' style='width:150px;' >
                                          <input type="radio" name="Plan" id="Plan" value="Si" onclick="enableE('Oplan','ObsPlan','GuardaPlan')"/> Si <input type="radio" name="Plan" id="Plan" value="No" Checked onclick="disableE('Oplan','ObsPlan','GuardaPlan')"/> No
                                     </span>
                                  </div>    
                          </div>
                          
                          <div class='col-md-6' >
                              <div class='input-group'>
                                <span class='input-group-addon' id="Oplan" style="visibility:hidden;" style='width:200px;' >Observaciones:</span>   
                                <input type="text" name="ObsPlan" id="ObsPlan" Class='form-control' style="visibility:hidden;">                             
                              </div>
                          </div>  
                          <div class='col-md-2'>
                              <div class='input-group'>
                                  <input type="button" onClick="guardaPlantillasRed('<?echo$fol;?>','<?echo $Not;?>')" name="GuardaPlan" id="GuardaPlan" Value="Agregar Plantillas" class="btn btn-success" style="width: 160px; visibility:hidden;"/>
                                                                      
                               </div>                                 
                          </div>                                                    
                      </div>
                      <br/>
                      <div class="row">
                            <div class="col-md-12">                                       
                                   <div id="resPlantillas">
                                       <?
                                       
                                               $query="SELECT HistP_clave, Plantillas_estatus, Plantillas_obs 
                                                       FROM HistoriaPlantillasRed 
                                                       Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
                                               $rs=mysql_query($query,$conn);
 
                                      if($row=  mysql_fetch_array($rs)){ 
    
                                      echo"<table width=\"100%\" class=\"table table-striped table-hover\">
                                                 <tr>
                                                       <th width=\"90%\"><b>Observaciones</b></th>
                                                       <th width=\"10%\"><b>Eliminar</b></th>
                                                 </tr>";

                                          do{ 
                                             echo "<tr>";
                                                      echo "<td>".utf8_encode($row['Plantillas_obs'])."</td>";
                                                      echo "<td><input type='button' onClick=\"eliminarPlantillasRed('".$row['HistP_clave']."','".$fol."','".$Not."')\" value='Eliminar' class=\"btn btn-danger btn-xs\">";
                                             echo "</tr>";
                                            }while($row = mysql_fetch_array($rs)); 
                                     echo" </table>";
                                     }
                                       ?>
                                   </div>
                            </div>
                      </div>

                      <div class='row'>
                          <div class='col-md-4'>
                                  <div class='input-group'>
                                      <span class='input-group-addon' style='width:185px;'><b>Tratamientos:</b></span>
                                     <span class='input-group-addon' style='width:150px;' >
                                          <input type='radio' name='Tratamiento' id="Tratamiento" value='Si' onclick="enableE('Otrat','ObsTratamiento','GuardaTrat')"/> Si <input type='radio' name='Tratamiento' id="Tratamiento" value='No' Checked onclick="disableE('Otrat','ObsTratamiento','GuardaTrat')"/> No
                                     </span>
                                  </div>    
                          </div>
                          
                          <div class='col-md-6' >
                              <div class='input-group'>
                                <span class='input-group-addon' id="Otrat" style="visibility:hidden;" style='width:200px;' >Observaciones:</span>   
                                <input type="text" name="ObsTratamiento" id="ObsTratamiento" Class='form-control' style="visibility:hidden;">                                                            
                              </div>
                          </div>  
                          <div class='col-md-2'>
                              <div class='input-group'>
                                  <input type="button" onClick="guardaTratamientosRed('<?echo $fol;?>','<?echo$Not;?>')" name="GuardaTrat" id="GuardaTrat" Value="Agregar Tratamiento" class="btn btn-success"style="width: 160px; visibility:hidden;"/>                                      
                               </div>                                 
                          </div>                                                    
                      </div>
                   
                          <br/>                      
                     <div class="row">
                            <div class="col-md-12">
                                  <div id="resTratamiento">
                                      <?
                                      
                                               $query="SELECT HistT_clave, HistT_estatus, HistT_obs 
                                                       FROM HistoriaTratRed 
                                                       Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
                                               $rs=mysql_query($query,$conn);
 
                                      if($row=  mysql_fetch_array($rs)){ 
    
                                      echo"<table width=\"100%\" class=\"table table-striped table-hover\">
                                                 <tr>
                                                       <th width=\"90%\"><b>Observaciones</b></th>
                                                       <th width=\"10%\"><b>Eliminar</b></th>
                                                 </tr>";

                                          do{ 
                                             echo "<tr>";
                                                      echo "<td>".utf8_encode($row['HistT_obs'])."</td>";
                                                      echo "<td><input type='button' onClick=\"eliminarTratamientosRed('".$row['HistT_clave']."','".$fol."','".$Not."')\" value='Eliminar' class=\"btn btn-danger btn-xs\">";
                                             echo "</tr>";
                                            }while($row = mysql_fetch_array($rs)); 
                                     echo" </table>";
                                     }
                                      ?>
                                  </div>    
                            </div>
                        </div>    
                      
                      <div class='row'>
                          <div class='col-md-4'>
                                  <div class='input-group'>
                                      <span class='input-group-addon' style='width:185px;'><b>Intervenciones <br/> Quirurgicas:</b></span>
                                     <span class='input-group-addon' style='width:150px;' >
                                          <input type='radio' name='Operaciones' Id="Operaciones" value='Si' onclick="enableE('Oqui','ObsOperaciones','GuardaOpe')"/> Si <input type='radio' name='Operaciones' Id="Operaciones" value='No' Checked onclick="disableE('Oqui','ObsOperaciones','GuardaOpe')"/> No
                                     </span>
                                  </div>    
                          </div>
                          
                          <div class='col-md-6' >
                              <div class='input-group'>
                                <span class='input-group-addon' id="Oqui" style="visibility:hidden;" style='width:200px;' >Observaciones:</span>  
                                <input type="text" name="ObsOperaciones" id="ObsOperaciones" Class='form-control' style="visibility:hidden">                                                                                          
                              </div>
                          </div>  
                          <div class='col-md-2'>
                              <div class='input-group'>
                                  <input type="button" onClick="guardaIntQxRed('<?echo $fol;?>','<?echo$Not;?>')" name="GuardaOpe" id="GuardaOpe" Value="Agregar Operacion" class="btn btn-success" style="width: 160px; visibility:hidden">                                  
                               </div>                                 
                          </div>                                                    
                      </div>                          
                      <br/>
                      
                      <div class="row">
                          <div class="col-md-12">
                                <div id="resIntQx">
                                    <?
                                               $query="SELECT HistO_clave, HistO_estatus, HistO_obs 
                                                       FROM HistoriaOperacionRed 
                                                       Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
                                               $rs=mysql_query($query,$conn);
 
                                      if($row=  mysql_fetch_array($rs)){ 
    
                                      echo"<table width=\"100%\" class=\"table table-striped table-hover\">
                                                 <tr>
                                                       <th width=\"90%\"><b>Observaciones</b></th>
                                                       <th width=\"10%\"><b>Eliminar</b></th>
                                                 </tr>";

                                          do{ 
                                             echo "<tr>";
                                                      echo "<td>".utf8_encode($row['HistO_obs'])."</td>";
                                                      echo "<td><input type='button' onClick=\"eliminarIntQxRed('".$row['HistO_clave']."','".$fol."','".$Not."')\" value='Eliminar' class=\"btn btn-danger btn-xs\">";
                                             echo "</tr>";
                                            }while($row = mysql_fetch_array($rs)); 
                                     echo" </table>";
                                     }                                    
                                    ?>
                                </div>                                 
                          </div>
                                    
                      </div>
                      
                      <div class='row'>
                          <div class='col-md-4'>
                                  <div class='input-group'>
                                      <span class='input-group-addon' style='width:185px;'><b>Deportes:</b></span>
                                     <span class='input-group-addon' style='width:150px;' >
                                          <input type='radio' name='Deporte' ID="Deporte" value='Si' onclick="enableE('Odep','ObsDeporte','GuardaDep')"/> Si <input type='radio' name='Deporte' Id="Deporte" value='No' Checked onclick="disableE('Odep','ObsDeporte','GuardaDep')"/> No
                                     </span>
                                  </div>    
                          </div>
                          
                          <div class='col-md-6' >
                              <div class='input-group'>
                                <span class='input-group-addon' id="Odep" style="visibility:hidden;" style='width:200px;' >Observaciones:</span>  
                                <input type="text" name="ObsDeporte" id="ObsDeporte" Class='form-control'style="visibility:hidden;"/>                                                                                       
                              </div>
                          </div>  
                          <div class='col-md-2'>
                              <div class='input-group'>
                                  <input type="button" onClick="guardaDepRed('<?echo $fol;?>','<?echo $Not;?>')" name="GuardaDep" id="GuardaDep" Value="Agregar Deporte" class="btn btn-success"style="width: 160px; visibility:hidden;" >                                                               
                               </div>                                 
                          </div>                                                    
                      </div> 
                                     <br/>
                      <div class="row">
                          <div class="col-md-12">
                                  <div id="resDeportes">
                                      <?
                                               $query="SELECT HistD_clave, Dep_estatus, Dep_obs 
                                                       FROM HistoriaDeporteRed 
                                                       Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
                                               $rs=mysql_query($query,$conn);
 
                                      if($row=  mysql_fetch_array($rs)){ 
    
                                      echo"<table width=\"100%\" class=\"table table-striped table-hover\">
                                                 <tr>
                                                       <th width=\"90%\"><b>Observaciones</b></th>
                                                       <th width=\"10%\"><b>Eliminar</b></th>
                                                 </tr>";

                                          do{ 
                                             echo "<tr>";
                                                      echo "<td>".utf8_encode($row['Dep_obs'])."</td>";
                                                      echo "<td><input type='button' onClick=\"eliminarDepRed('".$row['HistD_clave']."','".$fol."','".$Not."')\" value='Eliminar' class=\"btn btn-danger btn-xs\">";
                                             echo "</tr>";
                                            }while($row = mysql_fetch_array($rs)); 
                                     echo" </table>";
                                     }                                      
                                      ?>
                                  </div>
                          </div>
                      </div>
                                     
                                     
                      <div class='row'>
                          <div class='col-md-4'>
                                  <div class='input-group'>
                                      <span class='input-group-addon' style='width:185px;'><b>Adicciones:</b></span>
                                     <span class='input-group-addon' style='width:150px;' >
                                          <input type='radio' name='Adiccion' ID="Adiccion" value='Si' onclick="enableE('Oacc','ObsAdiccion','GuardaAdi')"/> Si <input type='radio' name='Adiccion' Id="Adiccion" value='No' Checked onclick="disableE('Oacc','ObsAdiccion','GuardaAdi')" /> No
                                     </span>
                                  </div>    
                          </div>
                          
                          <div class='col-md-6' >
                              <div class='input-group'>
                                <span class='input-group-addon' id="Oacc" style="visibility:hidden;" style='width:200px;' >Observaciones:</span>  
                                <input type="text" name="ObsAdiccion" id="ObsAdiccion" Class='form-control' style="visibility:hidden;">                                                                                                                  
                              </div>
                          </div>  
                          <div class='col-md-2'>
                              <div class='input-group'>
                                  <input type="button" onClick="guardaAdiRed('<?echo $fol;?>','<?echo $Not;?>')" name="GuardaAdi" id="GuardaAdi" Value="Agregar Adiccion" class="btn btn-success" style="width: 160px; visibility:hidden;" >                                                                                              
                               </div>                                 
                          </div>                                                    
                      </div>
                <br/>
                <div class="row">
                      <div class="col-md-12">
                            <div id="resAdiccionesRed">
                                <?
                                               $query="SELECT HistA_clave, Adic_estatus, Adic_obs 
                                                       FROM HistoriaAdiccionRed 
                                                       Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
                                               $rs=mysql_query($query,$conn);

                                      if($row=  mysql_fetch_array($rs)){ 
    
                                      echo"<table width=\"100%\" class=\"table table-striped table-hover\">
                                                 <tr>
                                                       <th width=\"90%\"><b>Observaciones</b></th>
                                                       <th width=\"10%\"><b>Eliminar</b></th>
                                                 </tr>";

                                          do{ 
                                             echo "<tr>";
                                                      echo "<td>".utf8_encode($row['Adic_obs'])."</td>";
                                                      echo "<td><input type='button' onClick=\"eliminarAdiRed('".$row['HistA_clave']."','".$fol."','".$Not."')\" value='Eliminar' class=\"btn btn-danger btn-xs\">";
                                             echo "</tr>";
                                            }while($row = mysql_fetch_array($rs)); 
                                     echo" </table>";
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
                       <input type="Button" class="btn btn-primary btn-lg"  value="Siguiente"  onClick="document.location.href='antPerSiguiente.php?fol=<?echo $fol;?>&Not=<?echo $Not;?>'" />
                    </div>
                </div>
                      
               </div>

                
   </div>
              
       </div>
  

   




