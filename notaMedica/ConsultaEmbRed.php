<?php
    $query="SELECT Emb_semGestacion, Emb_dolAbdominal, Emb_descripcion, Emb_movFetales, Emb_fcf, Emb_ginecologia, Emb_obs "
            . "FROM EmbarazoRed  Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
    $rs=mysql_query($query,$conn);
if($row=  mysql_fetch_array($rs)){  
    ?>
    
<br><br>
<div class="container" style="width: 100%"> 
    
 <div class="panel panel-default">
        <div class="panel-heading">
         <h3 class="panel-title" align="center">Datos De Embarazo</h3>
        </div>    
            
           <div class="panel-body">


               <div class="row">
                   <div class="col-md-2">
                       <div class="input-group">
                           <span class="input-group-addon" >Ctrl. Gine.</span>
                       </div>
                   </div>
                   <div class="col-md-2">
                       <div class="input-group">
                           <span class="input-group-addon">Sem. Gestaci&oacute;</span>
                       </div>
                   </div>
                   <div class="col-md-2">
                       <div class="input-group">
                       <span class="input-group-addon">Dol.Adbominal</span>
                       </div>
                   </div>
                   <div class="col-md-2">
                       <div class="input-group">
                           <span class="input-group-addon">Descripci&oacute;n</span>
                       </div>
                   </div>
                   <div class="col-md-2">
                   <div class="input-group">
                       <span class="input-group-addon">F/C Fetal</span>
                   </div>
                   </div>
                   <div class="col-md-2">
                       <div class="input-group">
                       <span class="input-group-addon">Movi. Fetal</span>
                       </div>
                   </div>
                   
               
               
                   
                   
               </div>
               <div class="row">
                   
                   <div class="col-md-2"> 
                       <div class="input-group">
                           <input type="text" class="form-control" readonly="" value="<?echo utf8_encode($row['Emb_ginecologia']);?>">  
                       </div>
                   </div>
                   
                   <div class="col-md-2">
                       <div class="input-group">
                           <input type="text" class="form-control" readonly="" value="<?echo utf8_encode($row['Emb_semGestacion'])?>"
                       </div>
                   </div>
                   </div>
               
                    <div class="col-md-2">
                       <div class="input-group">
                           <input type="text" class="form-control" readonly="" value="<?echo utf8_encode($row['Emb_dolAbdominal']);?>"
                       </div>
                   </div>
                   </div>
     
                    <div class="col-md-2">
                       <div class="input-group">
                           <input type="text" class="form-control" readonly="" value="<?echo utf8_encode($row['Emb_descripcion']);?>"
                       </div>
                   </div>
                   </div>
    
                   <div class="col-md-2">
                       <div class="input-group">
                           <input type="text" class="form-control" readonly="" value="<?echo utf8_encode($row['Emb_fcf']);?>"
                       </div>
                   </div>
                   </div>

                   <div class="col-md-2">
                       <div class="input-group">
                           <input type="text" class="form-control" readonly="" value="<?echo utf8_encode($row['Emb_movFetales']);?>">
                       </div>
                   </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group">
                        <span class="input-group-addon">Observaciones</span>
                        <input type="textarea" class="form-control" readonly="" value="<?echo utf8_encode($row['Emb_obs'])?>">
                    </div>
                </div>
            </div>
               

           </div>
 </div>
</div>
<?
}
  ?>