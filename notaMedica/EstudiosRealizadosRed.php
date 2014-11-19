
<div class="container" style="width: 100%"> 
    
 <div class="panel panel-primary">
        <div class="panel-heading">
         <h3 class="panel-title" align="center">Estudios Realizados</h3>
        </div>    
            
           <div class="panel-body">


                            <div class="row">


                                 <div class="col-md-6" >
                                    <div class="input-group">
                                        <span class="input-group-addon ">Estudio:&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    </span>
                                            <input type='Text' name='Estudio' id="Estudio" class= "form-control"/>
                                     </div>
                                </div>
                                 <div class="col-md-6" >
                                    <div class="input-group">
                                        <span class="input-group-addon">Descripci&oacute;n:&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp; &nbsp;  </span>
                                            <input type='Text' name='Descripcion' id="Descripcion" class= "form-control"/>
                                     </div>
                                </div>

               </div>

               <br>

                <div class="row">


                                 <div class="col-md-12" >
                                    <div class="input-group">
                                         <span class="input-group-addon" >Resultado:  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   </span>
                                            <input type='Text' name='Resultado' id="Resultado" class= "form-control" />
                                     </div>
                                </div>
                    </div>
               <br>
               <div class="row">
                   

                                     <div class="col-md-12" >
                                    <div class="input-group">
                                         <span class="input-group-addon" >Observaciones: </span>

                                                <input type="text" name="Observaciones" class= "form-control" id="Observaciones" >
                                     </div>
                                </div>
                </div>
                 


               <br>


               <div class="row">
                  <div class="col-md-4">
                  </div>
                   <div class="col-md-4"> <center>
                     <input type="button" class="btn btn-success" onclick="guardaEstRealizadosRed('<?echo $fol;?>','<?echo$Not;?>')" value="Agregar Estudio" />
                 </center>
                   </div>
                   

           </div>
           <br>
           <br>
            <!-- *******************************-->


            <div class="row">
               <div class="col-md-12">

                   <div id="resAgregaEstudioRed">
                     <?
                         $query="SELECT Est_clave, Est_estudio, Est_descripcion, Est_Resultado, Est_observacion
                         FROM EstudiosRealizadosRed
                         Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
                                        $rs=mysql_query($query,$conn);
                                            
                            if($row= mysql_fetch_array($rs))
                                   {

                                echo"<table id=\"EstudiosRealizadosRed\" align=\"center\"  width=\"100%\" class=\"table table-striped table-hover\">
                             <tr>
                             <th width=\"20%\"><b>Estudio</b></th>
                                          <th width=\"15%\"><b>Descripcion</b></th>
                                          <th width=\"15%\"><b>Resultado</b></th>
                                          <th width=\"40%\"><b>Observaciones</b></th>
                                          <th width=\"10%\"><b>Eliminar</b></th>
                                </tr>";

                            do{
                                              echo "  <tr>";
                                             echo "                <td>".utf8_encode($row['Est_estudio'])."</td>";
                                             echo "                <td>".utf8_encode($row['Est_descripcion'])."</td>";
                                             echo "                <td>".utf8_encode($row['Est_Resultado'])."</td>";
                                             echo "                <td>".utf8_encode($row['Est_observacion'])."</td>";
                                             echo "                <td><input type=\"button\" class=\"btn btn-danger btn-xs\" onClick=\"eliminarEstRealizadoRed('".$row['Est_clave']."','".$fol."','".$Not."')\" value='Eliminar'";
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
                      <input type="Button" class="btn btn-primary btn-lg"  value="Siguiente" onClick="document.location.href='estSiguiente.php?fol=<?echo $fol;?>&Not=<?echo $Not;?>'" />
                  </div>

           </div>
               
</div>          
</div>
</div>