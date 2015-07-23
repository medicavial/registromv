 <div class="panel panel-default">
    <div class="panel-body">
       
            <div class="row">                
                <div class="col-xs-3">
                    <div class="input-group">
                        <label>Familia </label>
                        <input type="hidden" id="folRec" name="folRec" value="<? echo $cveRecibo?>">
                        <input type="hidden" id="fol" name="fol" value="<?echo $fol?>">                                    
                        <select class="form-control" name="familia" id="familia" onchange="selectItem()">
                            <option value=""> *Selecciona</option>
                            <?php 
                                $query="select Tip_clave, Tip_nombre from TipoItem where Tip_activo='S'";
                                $res=mysql_query($query,$conn);
                                if($row=mysql_fetch_array($res)){
                                    do{
                                        echo "<option value=\"".$row['Tip_clave']."\">".$row['Tip_nombre']."</option>";
                                    }while ($row=mysql_fetch_array($res));
                                }
                            ?>
                        </select>                                                              
                    </div>
                </div> 
                <div class="col-xs-3">
                    <div class="input-group" width="100%">
                        <label>Item </label>
                                                     
                        <div id="selectItem" width="100%">
                            <select class="form-control" style="width:100%" name="item" id="item" onchange="ponerPrecio()">
                                <option value=""> * Selecciona  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</option>                                
                            </select> 
                        </div>                                                             
                    </div>
                </div> 
                <div class="col-xs-2">
                    <div class="input-group">
                        <label>Descuento</label> 
                        <input type="hidden" id="folRec" name="folRec" value="<? echo $cveRecibo?>">
                        <input type="hidden" id="fol" name="fol" value="<?echo $fol?>">                                              
                        <input type="text" id="descuento" class="form-control solonum" maxlength="3" name="descuento" placeholder="%" value="0">                                                    

                    </div>
                    <div id="val100"></div>
                </div>
                <div class="col-xs-2">
                    <div class="input-group">
                        <label>Precio</label>                                        
                        <input type="text" id="precio" class="form-control" name="precio" placeholder="$" disabled>                                                    
                    </div>
                </div>               
                <div class="col-xs-2" align="right" style="padding-top:1.8em">
                    <div class="input-group">                                            
                        <input  type="button" id="agregarItemReciboNuevo" name="agregarItemReciboNuevo" class="btn btn-success" value="Agregar Item">                        
                    </div>
                </div>
            </div>      
            <br>
            <div class="row">
                <div class="col-xs-12">
                    <div id="mensaje" style="display:none;">
                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div id="listaItemsRec">
                        <?php require "list_item_recibo_nuevo.php";?>
                    </div>
                </div>
            </div>
    </div>
</div>