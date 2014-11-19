<?php
require "../validaUsuario.php"; require "connMV.php";
require "enc.php";//encabezado de html


?>

<div class="container" style="width:100%" >
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title" align="center"> Lesiones</h3>
      </div>
        <div class="panel-body"> 
          
          <div class="row">
            <div class="col-md-4">
                      <div class="container" style="width:100%" >
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h3 class="panel-title" align="center"> Lesiones</h3>
                            </div>
                             <div class="panel-body"> 
                       

                      <div class ="row">
                        <div class="col-md-12"> <CENTER>
                          <div class="input-group">
                            
                                    <select name="lesionRed" id="lesionRed" size="13" class="selectpicker" data-style="btn-success"  >
                                                    <option value="-1"> *Selecciona</option>
                                                    <?php
                                                     {
                                            $query = "SELECT LES_clave, LES_nombre FROM LesionRed";
                                              $rs = mysql_query($query,$connMV);
                                              if($row = mysql_fetch_array($rs))
                                              {
                                                            do
                                                           {
                                                            echo "<option value=\"".$row["LES_clave"]."\">".$row["LES_nombre"]."</option>";
                                                }while ($row = mysql_fetch_array($rs));

                                                    }
                                                else
                                                  echo "Error al obtener el catalogo de Lesiones";
                                                     }
                                              ?>
                                                </div></select></CENTER>
                          
  


                           </div>
                           </div>
                          </div>
                           </div>
                           </div>
                          </div>                     
                                               

             <div class="col-md-4">
                      <div class="container" style="width:100%" >
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h3 class="panel-title" align="center"> Modelo</h3>
                            </div>
                            <br>

                            <div class="row">
                              <div class="col-md-12"><center>
                                <img alt=""  src="imgs/mapitacuerpo.png"  usemap="#cuerpo3map"/>
         <map name="cuerpo3map" id="cuerpo3map">
           <area shape="rect"     id="1"  coords="46,140,30,110"  alt="muslo derecho"    style.backgroundColor = "#FFFFFF"   onClick="guardaLesionRed(this.id)" />
           <area shape="rect"     id="2"  coords="65,140,45,110"  alt="muslo izquierdo"      onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="3"  coords="40,145,7"       alt="rodilla derecha"      onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="4"  coords="50,145,7"       alt="rodilla izquierda"    onClick="guardaLesionRed(this.id)" />
           <area shape="rect"     id="5"  coords="46,180,30,145"  alt="pierna derecha"       onClick="guardaLesionRed(this.id)" />
           <area shape="rect"     id="6"  coords="65,180,45,145"  alt="pierna izquierda"     onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="7"  coords="42,185,4"       alt="tobillo derecho"      onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="8"  coords="50,185,4"       alt="tobillo izquierdo"    onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="9"  coords="40,190,4"       alt="pie derecho"          onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="10" coords="50,190,4"       alt="pie izquierdo"        onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="11" coords="46,18,7"        alt="cara"                 onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="12" coords="46,8,7"         alt="cabeza"               onClick="guardaLesionRed(this.id)" />
           <area shape="rect"     id="13" coords="40,23,55,35"    alt="cuello"               onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="14" coords="25,40,4"        alt="hombro derecho"       onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="15" coords="65,40,4"        alt="hombro izquierdo"     onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="16" coords="35,50,7"        alt="pecho derecho"        onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="17" coords="60,50,7"        alt="pecho izquierdo"      onClick="guardaLesionRed(this.id)" />
           <area shape="rect"     id="18" coords="30,55,60,90"    alt="abdomen"              onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="62" coords="40,52,7"        alt="Torax"                onClick="guardaLesionRed(this.id)" />
           <area shape="rect"     id="19" coords="35,90,60,110"   alt="Cadera"               onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="20" coords="25,70,3"        alt="codo derecho"         onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="21" coords="70,70,3"        alt="codo izquierdo"       onClick="guardaLesionRed(this.id)" />
           <area shape="rect"     id="22" coords="20,40,30,70"    alt="brazo derecho"        onClick="guardaLesionRed(this.id)" />
           <area shape="rect"     id="23" coords="61,40,75,70"    alt="brazo izquierdo"      onClick="guardaLesionRed(this.id)" />
           <area shape="rect"     id="24" coords="10,71,30,95"   alt="ante-brazo derecho"    onClick="guardaLesionRed(this.id)" />
           <area shape="rect"     id="25" coords="63,71,80,95"   alt="ante-brazo izquierdo"  onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="26" coords="13,98,4"      alt="mu&ntilde;eca derecha"  onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="27" coords="80,98,4"      alt="mu&ntilde;eca izquierda"onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="28" coords="9,105,4"      alt="mano derecha"           onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="29" coords="83,105,4"     alt="mano izquierda"         onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="30" coords="8,115,4"      alt="dedos mano derecha"     onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="31" coords="83,115,4"     alt="dedos mano izquierda"   onClick="guardaLesionRed(this.id)" />

           <area shape="circle"   id="32" coords="150,8,7"         alt="cabeza (posterior)"                onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="33" coords="150,15,5"        alt="nuca"                              onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="34" coords="150,25,5"        alt="Columna Cervical"                  onClick="guardaLesionRed(this.id)" />
           <area shape="rect"     id="39" coords="153,140,170,105" alt="pierna derecha (posterior)"        onClick="guardaLesionRed(this.id)" />
           <area shape="rect"     id="40" coords="135,140,160,110" alt="pierna izquierda (posterior)"      onClick="guardaLesionRed(this.id)" />
           <area shape="rect"     id="41" coords="155,150,170,185" alt="ante-pierna derecha (posterior)"   onClick="guardaLesionRed(this.id)" />
           <area shape="rect"     id="42" coords="130,150,165,185" alt="ante-pierna izquierda (posterior)" onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="43" coords="158,151,7"       alt="rodilla derecha (posterior)"       onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="44" coords="145,151,7"       alt="rodilla izquierda (posterior)"     onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="45" coords="158,195,5"       alt="talon derecho"                     onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="46" coords="145,195,5"       alt="talon izquierdo"                   onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="51" coords="175,70,7"        alt="codo derecho()"                    onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="52" coords="130,70,7"        alt="codo izquierdo()"                  onClick="guardaLesionRed(this.id)" />
           <area shape="rect"     id="53" coords="175,71,190,98"   alt="ante-brazo derecho (posterior)"    onClick="guardaLesionRed(this.id)" />
           <area shape="rect"     id="54" coords="110,71,130,98"   alt="ante-brazo izquierdo (posterior)"  onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="55" coords="190,105,7"      alt="mano derecha (posterior)"           onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="56" coords="110,105,7"      alt="mano izquierda (posterior)"         onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="57" coords="190,115,4"      alt="dedos mano derecha (posterior)"     onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="58" coords="115,115,4"      alt="dedos mano izquierda (posterior)"   onClick="guardaLesionRed(this.id)" />
           
           <area shape="circle"   id="59" coords="150,50,8"       alt="Columna Dorzal"                     onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="60" coords="150,80,8"      alt="Columna Lumbar"                      onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="61" coords="150,95,8"      alt="Zona Sacra"                          onClick="guardaLesionRed(this.id)" />

           <area shape="rect"     id="35" coords="138,10,168,80"   alt="espalda"                           onClick="guardaLesionRed(this.id)" />
           <area shape="rect"     id="36" coords="140,81,165,95"   alt="espalda baja"                      onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="37" coords="160,101,8"       alt="gluteo derecho"                    onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="38" coords="145,101,8"       alt="gluteo izquierdo"                  onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="47" coords="175,40,7"        alt="hombro derecho (posterior)"        onClick="guardaLesionRed(this.id)" />
           <area shape="circle"   id="48" coords="130,40,7"        alt="hombro izquierdo (posterior)"      onClick="guardaLesionRed(this.id)" />
           <area shape="rect"     id="49" coords="160,40,180,70"   alt="brazo derecho (posterior)"         onClick="guardaLesionRed(this.id)" />
           <area shape="rect"     id="50" coords="120,40,150,70"   alt="brazo izquierdo (posterior)"       onClick="guardaLesionRed(this.id)" />
           
           
          </map>
                                </center>
                                <br>
                              </div>
                              
                            </div>
                        </div>
                      </div>
            </div>

             <div class="col-md-4">
                      <div class="container" style="width:100%" >
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h3 class="panel-title" align="center"> Resultados</h3>
                            </div>
                            <br>

                            <div class="row">
                              <div class="col-md-12"><center>
                                        <div id="TablaLesionRed"> <?php include 'ConsultaLesionRed.php';?></div>
                                       <!--<table class="table table-bordered table-hover">
                                              <thead>
                                                  <tr>
                                                      <th>#</th>
                                                      <th>Lesion</th>
                                                      <th>Zona</th>
                                                      <th>Eliminar</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  
                                              </tbody>
                                          </table> -->
                              </div>
                            </div>
                             </div>
                         </div>
                     </div>
          </DIV> <!-- CIERRE DE ROW -->
                    
<!-- CIERRE DE PANEL Y CONTAINER -->
        </div>
        </div>
        </div>

 


