<?php 

require_once "Modelo.php";
// clase para el envío de correos
require_once 'nomad_mimemail.inc.php';
/**
*  clase para el control de incidencias 
*/
class Incidencias extends Modelo
{	
    public $mimemail;
	function __construct()
	{
		 parent::__construct();
         
	}
/************************************************************************************************************************************/
/************************       método para agregar incidencias dependiendo del usuario y la unuidad                   **************/
/************************************************************************************************************************************/
    public function setIncidencia($usuario, $unidad, $datos)
    {
        $tipo= $datos->tipo;
        $severidad= $datos->severidad;
        $observaciones= $datos->observaciones;

        $fecha = date('d-m-Y');
        $hora  = date('h:i a');
        try{
            $query="Insert into Incidente(Usu_login, Uni_clave, Tipin_clave, Inc_obs, Inc_fecha, Inc_hora, Inc_severidad)
                               Values('".$usuario."',".$unidad.",".$tipo.",'".$observaciones."','".$fecha."','".$hora."',".$severidad.")";
            $result = $this->_db->query($query);
            return 'exito';
        }catch(Exception $e){
            return 'error';
        }
    }

/************************************************************************************************************************************/
/************************       método de envío de correo de incidencia dependiendo la severidad y el tipo             **************/
/************************************************************************************************************************************/

    public function sendIncidencia($usuario, $unidad, $datos)
    {
        $mimemail = new nomad_mimemail();
        $tipo= $datos->tipo;
        $severidad= $datos->severidad;
        $observaciones= $datos->observaciones;
        $fecha = date('d-m-Y');
        $hora  = date('h:i a');
        $correos=array();

        switch ($tipo) {
            case '1':
                $nombreTipo='Equipo Rx';
                $correos=array("egutierrez@medicavial.com.mx", "sistemasrep2@medicavial.com.mx");
                break;
            case '2':
                $nombreTipo='Personal';
                break;
            case '3':
                $nombreTipo='Equipo de Cómputo';
                break;
            case '4':
                $nombreTipo='Sistema';
                break;
            case '5':
                $nombreTipo='Medicamentos';
                break;
            case '6':
                $nombreTipo='Ortesis';
                break;              
            case '7':
                $nombreTipo='Médico';
                break;              
            case '8':
                $nombreTipo='Cabina';
                break;            
            case '9':
                $nombreTipo='Rehabilitación';
                break;              
            case '10':
                $nombreTipo='Normatividad';
                break; 
            case '11':
                $nombreTipo='Mantenimiento';
                break; 
            case '12':
                $nombreTipo='Otro';
                break;                    
        }    

        switch ($severidad) {
            case '1':
                $severidadNom='baja';
                break;
            case '2':
                $severidadNom='regular';
                break;
            case '3':
                $severidadNom='alta';
                break;        
        }
        try{
        $query="select Usu_nombre, Uni_nombrecorto from Usuario
                inner join Unidad on Unidad.Uni_clave=Usuario.Uni_clave 
                where Usuario.Usu_login='".$usuario."'";
        $result = $this->_db->query($query);
        $rs = $result->fetch();
         }catch(Exception $e){
            return $e->getMessage();
        }
        $contenido='<HTML>
                                <HEAD>
                                </HEAD>
                                <BODY>
                                <br>                
                                <img src="logomv.gif"> 
                                <br>
                                <br>
                                <table class="table1" border="1" style="width: 100%; border: 1px solid #000;">
                                    <tr>
                                        <th colspan="6" align="center" style=" width: 25%; background: #eee;
                                           text-align: left;
                                           vertical-align: top;
                                           border: 1px solid #000;
                                           border-collapse: collapse;
                                           padding: 0.3em;
                                           caption-side: bottom;">
                                            INCIDENCIA
                                        </th>
                                    </tr>
                                    <br>
                                    <tr>
                                        <td style=" width: 40%;
                                           text-align: left;
                                           vertical-align: top;
                                           border: 1px solid #000;
                                           border-collapse: collapse;
                                           padding: 0.3em;
                                           caption-side: bottom;">
                                            Unidad: <b>'.utf8_encode($rs['Uni_nombrecorto']).'</b>
                                        </td>
                                        <td style=" width: 60%;
                                           text-align: left;
                                           vertical-align: top;
                                           border: 1px solid #000;
                                           border-collapse: collapse;
                                           padding: 0.3em;
                                           caption-side: bottom;">
                                            Usuario: <b>'.utf8_encode($rs['Usu_nombre']).'</b>
                                        </td>                                        
                                    </tr>
                                    <tr>
                                        <td>
                                            Tipo de incidencia: <b>'.$nombreTipo.'</b>
                                        </td>
                                        <td >
                                            Severidad de incidencia: <b>'.$severidadNom.'</b>
                                        </td>                                       
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            Observaciones: <b>'.utf8_encode($observaciones).'</b>
                                        </td>                                        
                                    </tr>                                    
                                </table>
                                </BODY>
                                </HTML>         
                ';
        $mimemail->set_from("seguimiento_NoReply@medicavial.com.mx");        
         if($tipo==1){
            $mimemail->set_to("jsanchez@medicavial.com.mx");
            $mimemail->add_cc("scisneros@medicavial.com.mx");
            $mimemail->add_cc("agutierrez@medicavial.com.mx");
            $mimemail->add_bcc("egutierrez@medicavial.com.mx");
         }elseif($tipo==2){
            $mimemail->set_to("jsanchez@medicavial.com.mx");
            $mimemail->add_cc("scisneros@medicavial.com.mx");
            $mimemail->add_cc("agutierrez@medicavial.com.mx");
            $mimemail->add_cc("msanchez@medicavial.com.mx");
            $mimemail->add_bcc("egutierrez@medicavial.com.mx");
         }elseif ($tipo==3) {
            $mimemail->set_to("jsanchez@medicavial.com.mx");
            $mimemail->add_cc("scisneros@medicavial.com.mx");
            $mimemail->add_cc("agutierrez@medicavial.com.mx");
            $mimemail->add_cc("clinicasoporte@medicavial.com.mx");
            $mimemail->add_cc("soportemv@medicavial.com.mx");
            $mimemail->add_bcc("egutierrez@medicavial.com.mx");
         }elseif ($tipo==4) {
            $mimemail->set_to("jsanchez@medicavial.com.mx");
            $mimemail->add_cc("scisneros@medicavial.com.mx");
            $mimemail->add_cc("agutierrez@medicavial.com.mx");
            $mimemail->add_bcc("egutierrez@medicavial.com.mx");
         }elseif ($tipo==5) {
            $mimemail->set_to("jsanchez@medicavial.com.mx");
            $mimemail->add_cc("scisneros@medicavial.com.mx");
            $mimemail->add_cc("agutierrez@medicavial.com.mx");
            $mimemail->add_cc("alozano@medicavial.com.mx");
            $mimemail->add_bcc("egutierrez@medicavial.com.mx");
         }elseif ($tipo==6) {
            $mimemail->set_to("jsanchez@medicavial.com.mx");
            $mimemail->add_cc("scisneros@medicavial.com.mx");
            $mimemail->add_cc("agutierrez@medicavial.com.mx");
            $mimemail->add_cc("alozano@medicavial.com.mx");
            $mimemail->add_bcc("egutierrez@medicavial.com.mx");
         }elseif ($tipo==7) {
            $mimemail->set_to("jsanchez@medicavial.com.mx");
            $mimemail->add_cc("scisneros@medicavial.com.mx");
            $mimemail->add_cc("agutierrez@medicavial.com.mx");
            $mimemail->add_cc("jlinares@medicavial.com.mx");
            $mimemail->add_bcc("egutierrez@medicavial.com.mx");
         }elseif ($tipo==8) {
            $mimemail->set_to("jsanchez@medicavial.com.mx");
            $mimemail->add_cc("scisneros@medicavial.com.mx");
            $mimemail->add_cc("agutierrez@medicavial.com.mx");
            $mimemail->add_cc("dbermudez@medicavial.com.mx");
            $mimemail->add_cc("jlinares@medicavial.com.mx");
            $mimemail->add_bcc("egutierrez@medicavial.com.mx");
         }elseif ($tipo==9) {
            $mimemail->set_to("jsanchez@medicavial.com.mx");
            $mimemail->add_cc("scisneros@medicavial.com.mx");
            $mimemail->add_cc("agutierrez@medicavial.com.mx");
            $mimemail->add_cc("coordreh@medicavial.com.mx");
            $mimemail->add_bcc("egutierrez@medicavial.com.mx");
         }elseif ($tipo==10) {
            $mimemail->set_to("jsanchez@medicavial.com.mx");
            $mimemail->add_cc("scisneros@medicavial.com.mx");
            $mimemail->add_cc("agutierrez@medicavial.com.mx");            
            $mimemail->add_cc("elanderos@medicavial.com.mx");            
            $mimemail->add_bcc("egutierrez@medicavial.com.mx");
         }elseif ($tipo==11) {
            $mimemail->set_to("jsanchez@medicavial.com.mx");
            $mimemail->add_cc("scisneros@medicavial.com.mx");
            $mimemail->add_cc("agutierrez@medicavial.com.mx");
            $mimemail->add_cc("mantenimiento@medicavial.com.mx");            
            $mimemail->add_bcc("egutierrez@medicavial.com.mx");
         }elseif ($tipo==12) {
            $mimemail->set_to("jsanchez@medicavial.com.mx");
            $mimemail->add_cc("scisneros@medicavial.com.mx");
            $mimemail->add_cc("agutierrez@medicavial.com.mx");            
            $mimemail->add_bcc("egutierrez@medicavial.com.mx");
         }           
        //$mimemail->set_cc('agutierrez@medicavial.com.mx');   
        //$mimemail->add_cc('egutierrez@medicavial.com.mx');        
        $mimemail->set_subject("- Incidencia - ".$rs['Uni_nombrecorto']." - ".$rs['Usu_nombre']);
        $mimemail->set_html($contenido);
        $mimemail->add_attachment("../imgs/logomv.jpg", "logomv.gif");
        
        if ($mimemail->send()){
            return 'exito';
           
        }else {
            return 'error';
        }        
    }
}
 ?>