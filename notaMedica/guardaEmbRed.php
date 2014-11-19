<?php
require "validaUsuario.php";


if($_POST['guardaEmbRed'])
{
    $query="Select Exp_folio From EmbarazoRed  Where Exp_folio='".$fol."' and Not_clave='".$Not."'";
    $rs=mysql_query($query,$conn);
    $row=mysql_fetch_array($rs);
    $contEmb=$row['Exp_folio'];
    if($contEmb=="" || $contEmb==null){


        $sql = "INSERT INTO EmbarazoRed (`Not_clave`,`Exp_folio`, `Emb_semGestacion`, `Emb_dolAbdominal`, `Emb_descripcion`, `Emb_fcf`, `Emb_movFetales`, `Emb_ginecologia`, `Emb_obs`)"
                . " VALUES ('".$Not."','".$fol."','".$semGes."', '".$dolAbdominal."', '".$descEmb."', '".$edoEmb."','".$movFet."', '".$Gine."', '".$obsEmb."');";
        
   $rs=mysql_query(utf8_decode($sql),$conn);
   
   
 


include 'ConsultaEmbRed.php';

    }else{
       echo"
              <table align=\"center\" width=\"100%\">
                      <tr>
                           <td align=\"center\">
                           <br>
                               <b>Ya ha Ingresado un Embarazo Previamente</b>
                           </td>
                      </tr>
              </table>
              <br/>
           ";
       include 'ConsultaEmbRed.php';
    }
}

?>
