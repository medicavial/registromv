


<div class="container" style="width: 100%"> 
    
<div class="panel panel-primary">
       <div class="panel-heading">
                  <h3 class="panel-title" align="center">Antecedentes Heredo Familiares</h3>
       </div>
       <div class="panel-body">
       
         
           <div class="row">
               
               <div class="col-md-4" >
                     <div class="input-group">
                            <span class="input-group-addon">Enfermedad:</span>
                            <select name="Enfermedad" id="Enfermedad" class= "form-control" >
		                  <option value="-1"> * Seleccione </option>
			           <?php
                                           {
				          $query = "SELECT Enf_clave, Enf_nombre FROM Enfermedad";
				           $rs = mysql_query($query,$conn);
				             if($row = mysql_fetch_array($rs))
				                  {
              				               do
                                                           {
                                                                echo "<option value=\"".$row["Enf_clave"]."\">".$row["Enf_nombre"]."</option>";
					                   }while ($row = mysql_fetch_array($rs));
				                           }
						             else
						         	echo "Error al obtener el catalogo llega";
                                                      }
			           ?>
                             </select>
                     </div> 
               </div >
               
               <div class="col-md-4" >
                     <div class="input-group">
                            <span class="input-group-addon">Familiar:</span>
                            <select name="Familiar" id="Familiar" class= "form-control">
		              <option value="-1"> * Seleccione </option>
			           <?php
                                           {
				          $query = "SELECT Fam_clave, Fam_nombre FROM Familia";
				           $rs = mysql_query($query,$conn);
				             if($row = mysql_fetch_array($rs))
				                  {
              				               do
                                                           {
                                                                echo "<option value=\"".$row["Fam_clave"]."\">".$row["Fam_nombre"]."</option>";
					                   }while ($row = mysql_fetch_array($rs));
				                           }
						             else
						         	echo "Error al obtener el catalogo llega";
                                                      }
					    ?>
                               </select>
                     </div> 
               </div >
               
               <div class="col-md-4" >
                     <div class="input-group">
                            <span class="input-group-addon">Estatus:</span>
                             <select name="Estatus" id="Estatus" class= "form-control">
		                <option value="-1"> * Seleccione </option>
			           <?php
                                           {
				          $query = "SELECT Est_clave, Est_nombre FROM EstatusFam";
				           $rs = mysql_query($query,$conn);
				             if($row = mysql_fetch_array($rs))
				                  {
              				               do
                                                           {
                                                                echo "<option value=\"".$row["Est_clave"]."\">".$row["Est_nombre"]."</option>";
					                   }while ($row = mysql_fetch_array($rs));
				                           }
						             else
						         	echo "Error al obtener el catalogo llega";
                                                      }
					    ?>
                              </select>
                     </div> 
               </div >
               
           </div>
           <br/>
           <div class="row">
                           
               <div class="col-md-8" >
                     <div class="input-group">
                            <span class="input-group-addon">Observaciones:</span>
                             <input type="text" name="ObsHeredo" id="ObsHeredo" class="form-control">
                            
                     </div> 
               </div >
               
               <div class="col-md-4">
                 <input type="button" class="btn btn-success" onclick="guardaHeredoRed('<?echo $fol;?>','<?echo$Not;?>')" value="Agregar Antecedente" />
               </div>
               
           </div>
           <br/>
           <br/>
           <div class="row">
               <div class="col-md-12">
                   
                   <div id="resAgregaAntecedenteRed">
                     <?
                       $query="SELECT FamE_clave, Enf_nombre, Fam_nombre, Est_nombre, FamE_obs 
                               FROM FamEnfermedadRed 
                               Inner Join Enfermedad on FamEnfermedadRed.Enf_clave=Enfermedad.Enf_clave 
                               Inner Join Familia on FamEnfermedadRed.Fam_clave=Familia.Fam_clave 
                               Inner Join EstatusFam on FamEnfermedadRed.Est_clave=EstatusFam.Est_clave 
                               Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
                       $rs=mysql_query($query,$conn);
                       
 
                   if($row= mysql_fetch_array($rs))
                         {
                            echo"<table id=\"TablaHeredo\" align=\"center\"  width=\"100%\" class=\"table table-striped table-hover\">
                                    <tr>
                                         <th width=\"20%\"><b>Enfermedad</b></th>
                                         <th width=\"15%\"><b>Familiar</b></th>
                                         <th width=\"15%\"><b>Estatus</b></th>
                                         <th width=\"40%\"><b>Observaciones</b></th>
                                         <th width=\"10%\"><b>Eliminar</b></th>
                                    </tr>";
                              do{
                                   echo "  <tr>";
                                   echo "                <td>".utf8_encode($row['Enf_nombre'])."</td>";
                                   echo "                <td>".utf8_encode($row['Fam_nombre'])."</td>";
                                   echo "                <td>".utf8_encode($row['Est_nombre'])."</td>";
                                   echo "                <td>".utf8_encode($row['FamE_obs'])."</td>";
                                   echo "                <td><input type=\"button\" class=\"btn btn-danger btn-xs\" onClick=\"eliminarHeredoRed('".$row['FamE_clave']."','".$fol."','".$Not."')\" value='Eliminar'";
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
                      <input type="Button" class="btn btn-primary btn-lg"  value="Siguiente" onClick="document.location.href='siguiente1Nr.php?fol=<?echo $fol;?>&Not=<?echo $Not;?>'" />
                  </div>
               
           </div>
           
           
                  
       </div>       
            
 </div>
         
</div>    




