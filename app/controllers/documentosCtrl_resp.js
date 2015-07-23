app.controller('documentosCtrl', function($scope,$rootScope,$location,$cookies,busquedas,$http) {
	$rootScope.folio=$cookies.folio;
	$rootScope.usrLogin= $cookies.usrLogin;
  $rootScope.uniClave=$cookies.uniClave;
	$rootScope.permisos=JSON.parse($cookies.permisos);    
	$scope.subsecuenciaVal=true;
    $scope.paseReha=false;
    $scope.esParticular=false;
    $scope.esAba=false;
    $scope.ProSegNuevo=true
    $scope.cargador=true; 
    $scope.noSubsec=''; 
    $scope.soloReha=true; 
    $scope.veEditaNota=true;
    $scope.valida1=false;
    $scope.valida2=false;
    $scope.valida3=false;
    $scope.valida4=false;
    $scope.valida5=false;
    $scope.valida6=false;
    $scope.valida7=false;
    $scope.valida8=false;
    $scope.string = ''; 
    $scope.datos={
        folio: $rootScope.folio
    }
	busquedas.validaNota($rootScope.folio).success(function(data){ 		
        $scope.cargador=false;
		if(data.respuesta=='existe'){
			$scope.subsecuenciaVal=false;
		}                     
		else{
             busquedas.validaParticular($rootScope.folio).success(function(data){                                        
                $scope.proClave=data.Pro_clave;
                if(data.Pro_clave==8){
                    $scope.subsecuenciaVal=false;
                }else{
                    $scope.subsecuenciaVal=true;
                }
                if(data.Pro_clave==5 || data.Pro_clave==4){
                    $scope.soloReha=false;
                }else{
                    $scope.soloReha=true;
                }        
            });
			
		} 		          
    });
    busquedas.validaPaseM($rootScope.folio).success(function(data){             
        if(data.respuesta=='existe'){
            $scope.paseReha=true;
        }                     
        else{
            $scope.paseReha=false;
        }                 
    });

    busquedas.validaParticular($rootScope.folio).success(function(data){               
        if(data.Cia_clave==51){
            $scope.esParticular=true;
        }else if(data.Cia_clave==1){
            $scope.esAba=true;
        }          
    });

    busquedas.estatusNota($rootScope.folio).success(function(data){         
        if(data=="12"){
            $scope.veEditaNota=false;
            busquedas.listaDatosPacRec($rootScope.folio).success(function(data){                      
                    
                    $scope.datos.lesionado=data.Exp_completo;
                    $scope.datos.sexo=data.Exp_sexo;
                    $scope.datos.edad=data.Exp_edad;
                    $scope.datos.talla=data.Vit_talla;
                    $scope.datos.peso=data.Vit_peso;
                    $scope.datos.temperatura=data.Vit_temperatura;
                    $scope.datos.presion=data.Vit_ta;
                    $scope.string = String(dd) + String(mm) + String(yyyy) +'||'+'900001'+'||algo||' + $scope.datos.folio + '||654+5456';
                    $scope.datos.qr = String(dd) + String(mm) + String(yyyy) +'||'+'900001'+'||algo||' + $scope.datos.folio + '||654+5456';                    
                    $scope.datos.cadena = String(dd) + String(mm) + String(yyyy) +'||'+'900001'+'||algo||' + $scope.datos.folio + '||654+5456';                                        
                    $scope.datos.receta= $scope.datos.folio;                    
                    $scope.valida1=true;

                  });
                  $http.get('api/api.php?funcion=listaAlergiasRec&fol='+$rootScope.folio).success(function (data){          
                      $scope.datos.alergias = data;
                      $scope.valida2=true;
                  });
                  $http.get('api/api.php?funcion=datosDoc&usr='+$rootScope.usrLogin).success(function (data){
                                           
                      $scope.datos.doctor = data.Med_nombre+' '+data.Med_paterno+' '+data.Med_materno;
                      $scope.datos.cedula = data.Med_cedula;
                      $scope.datos.especialidad = data.Med_esp;
                      $scope.datos.telefonos = data.Med_telefono;
                      $scope.valida3=true;   
                  });

                  $http.get('api/api.php?funcion=datosUni&uni='+$rootScope.uniClave).success(function (data){
                      $scope.datos.direccionUni  = data.Uni_calleNum+', '+data.Uni_colMun;
                      $scope.datos.telUni = data.Uni_tel; 
                      $scope.valida7=true;                                         
                  });

                  $http.get('api/api.php?funcion=generaFolio&fol='+$rootScope.folio).success(function (data){                      
                      $scope.valida8=true; 
                  });
                  $http.get('api/api.php?funcion=datosMedicamentoRec&fol='+$rootScope.folio).success(function (data){                                        
                      
                      $scope.datos.medicamentos=data;                    
                      $scope.valida4=true;

                  });
                  $http.get('api/api.php?funcion=datosOrtRec&fol='+$rootScope.folio).success(function (data){                                        
                      
                      $scope.datos.ortesis=data;                    
                      $scope.valida5=true;

                  });
                  $http.get('api/api.php?funcion=datosIndicacionesRec&fol='+$rootScope.folio).success(function (data){                                                              
                      $scope.datos.indicaciones=data;  
                      $scope.cargador1=false;              
                      $scope.valida6=true;

                  });                                      
        }
    });
	$scope.irHistoriaClinica = function(folio){  
		$cookies.folio = folio;
        $location.path("/historiaClinica");
	}
	$scope.irSignosVitales = function(folio){  
		$cookies.folio = folio;
        $location.path("/signosVitales");
	}
    $scope.irSignosVitalesSub = function(folio){  
        $cookies.folio = folio;
        $location.path("/signosVitalesSub");
    }
	$scope.irNotaMedica = function(folio){  
		$cookies.folio = folio;
        $location.path("/notaMedica");
	}
	$scope.irSubsecuencia = function(folio){  		
		$cookies.folio = folio;
        $location.path("/subsecuencia");
	}
    $scope.irSubsecuenciaListado = function(folio){        
        $cookies.folio = folio;
        $location.path("/subsecuenciaListado");
    }
    $scope.irSolRehab = function(folio){          
        $cookies.folio = folio;
        $location.path("/rehabilitacion");
    }
     $scope.irSolRehabForm = function(folio){          
        $cookies.folio = folio;
        $location.path("/rehabilitacionForm");
    }
	$scope.irSolicitud = function(folio){  
		$cookies.folio = folio;
        $location.path("/solicitud/"+$rootScope.folio);
	}
    $scope.irReciboPar = function(folio){  
        $cookies.folio = folio;
        $location.path("/reciboParticular");
    }
    $scope.irSolFact = function(folio){  
        $cookies.folio = folio;
        $location.path("/solicitudFactura");
    }
    $scope.irDigitalizacion = function(folio){  
        $cookies.folio = folio;
        $location.path("/digitalizacion");
    }
     $scope.irCambioUnidad = function(folio){  
        $cookies.folio = folio;
        $location.path("/cambioUnidad");
    }
     $scope.irConsatancia = function(folio){  
        $cookies.folio = folio;
        $location.path("/constancia");
    }

	$scope.imprimirNota = function(folio){ 
        	$scope.cargador=true;        
            var fileName = "Reporte";
            var uri = 'api/classes/formatoNota.php?fol='+folio;
            var link = document.createElement("a");    
            link.href = uri;
            
            //set the visibility hidden so it will not effect on your web-layout
            link.style = "visibility:hidden";
            link.download = fileName + ".pdf";
            
            //this part will append the anchor tag and remove it after automatic click
            document.body.appendChild(link);
            link.click();
            $scope.cargador=false;
            document.body.removeChild(link);
        }
      $scope.imprimirRecetaNuevo = function(folio){                
            var fileName = 'Receta';
            var uri = 'api/classes/formatoRecetaNuevo.php?fol='+folio+'&usr='+$rootScope.usrLogin+'&uni='+$rootScope.uniClave;
            var link = document.createElement("a");    
            link.href = uri;
            
            //set the visibility hidden so it will not effect on your web-layout
            link.style = "visibility:hidden";
            link.download = fileName + ".pdf";
            
            //this part will append the anchor tag and remove it after automatic click
            document.body.appendChild(link);
            link.click();            
            document.body.removeChild(link);
        }
    $scope.imprimirReceta = function(folio){
        	/*$rootScope.cargador=true;          
            var fileName = "Reporte";
            var uri = 'api/classes/formatoReceta.php?fol='+folio+'&usr='+$rootScope.usrLogin;
            var link = document.createElement("a");    
            link.href = uri;
            
            //set the visibility hidden so it will not effect on your web-layout
            link.style = "visibility:hidden";
            link.download = fileName + ".pdf";
            
            //this part will append the anchor tag and remove it after automatic click
            document.body.appendChild(link);
            link.click();
            $rootScope.cargador=false;
            document.body.removeChild(link);*/
            busquedas.listaDatosPacRec($rootScope.folio).success(function(data){                      
                    
                    $scope.datos.lesionado=data.Exp_completo;
                    $scope.datos.sexo=data.Exp_sexo;
                    $scope.datos.edad=data.Exp_edad;
                    $scope.datos.talla=data.Vit_talla;
                    $scope.datos.peso=data.Vit_peso;
                    $scope.datos.temperatura=data.Vit_temperatura;
                    $scope.datos.presion=data.Vit_ta;
                    $scope.string = String(dd) + String(mm) + String(yyyy) +'||'+'900001'+'||algo||' + $scope.datos.folio + '||654+5456';
                    $scope.datos.qr = String(dd) + String(mm) + String(yyyy) +'||'+'900001'+'||algo||' + $scope.datos.folio + '||654+5456';                    
                    $scope.datos.cadena = String(dd) + String(mm) + String(yyyy) +'||'+'900001'+'||algo||' + $scope.datos.folio + '||654+5456';                                        
                    $scope.datos.receta= $scope.datos.folio;                    

                  });
                  $http.get('api/api.php?funcion=listaAlergiasRec&fol='+$rootScope.folio).success(function (data){          
                      $scope.datos.alergias = data;
                  });
                  $http.get('api/api.php?funcion=datosDoc&usr='+$rootScope.usrLogin).success(function (data){
                                           
                      $scope.datos.doctor = data.Med_nombre+' '+data.Med_paterno+' '+data.Med_materno;
                      $scope.datos.cedula = data.Med_cedula;
                      $scope.datos.especialidad = data.Med_esp;
                      $scope.datos.telefonos = data.Med_telefono;

                  });
                  $http.get('api/api.php?funcion=datosMedicamentoRec&fol='+$rootScope.folio).success(function (data){                                        
                      
                      $scope.datos.medicamentos=data;                    

                  });
                  $http.get('api/api.php?funcion=datosOrtRec&fol='+$rootScope.folio).success(function (data){                                        
                      
                      $scope.datos.ortesis=data;                    

                  });
                  $http.get('api/api.php?funcion=datosIndicacionesRec&fol='+$rootScope.folio).success(function (data){                                                              
                      $scope.datos.indicaciones=data;  
                      $scope.cargador1=false;              

                  });
                    $http.get('api/api.php?funcion=guardaEstatusNota&fol='+$rootScope.folio+'&estatus=12').success(function (data){                                
                    });                    

        }

        $scope.imprimirRehabilitacion = function(){
        var fileName = "Reporte";
        var uri = 'api/classes/formatoRehabilitacion.php?fol='+$rootScope.folio+'&usr='+$rootScope.usrLogin;
        var link = document.createElement("a");    
        link.href = uri;
        
        //set the visibility hidden so it will not effect on your web-layout
        link.style = "visibility:hidden";
        link.download = fileName + ".pdf";
        
        //this part will append the anchor tag and remove it after automatic click
        document.body.appendChild(link);
        link.click();                        
        document.body.removeChild(link);
      
      }
      $scope.imprimirRehabilitacion = function(){
        var fileName = "Reporte";
        var uri = 'api/classes/formatoRehabilitacion.php?fol='+$rootScope.folio+'&usr='+$rootScope.usrLogin;
        var link = document.createElement("a");    
        link.href = uri;
        
        //set the visibility hidden so it will not effect on your web-layout
        link.style = "visibility:hidden";
        link.download = fileName + ".pdf";
        
        //this part will append the anchor tag and remove it after automatic click
        document.body.appendChild(link);
        link.click();                        
        document.body.removeChild(link);
      
      }
      $scope.imprimirPaseReha = function(){
      var fileName = "Reporte";
                        var uri = 'api/classes/formatoPaseRehabilitacion.php?fol='+$rootScope.folio+'&usr='+$rootScope.usrLogin;
                        var link = document.createElement("a");    
                        link.href = uri;
                        
                        //set the visibility hidden so it will not effect on your web-layout
                        link.style = "visibility:hidden";
                        link.download = fileName + ".pdf";
                        
                        //this part will append the anchor tag and remove it after automatic click
                        document.body.appendChild(link);
                        link.click();                        
                        document.body.removeChild(link);

	}
    $scope.imprimirHistoriaClinica = function(){            
            var fileName = "Reporte";
            var uri = 'api/classes/FormatoH.php?fol='+$rootScope.folio;
            var link = document.createElement("a");    
            link.href = uri;
            
            //set the visibility hidden so it will not effect on your web-layout
            link.style = "visibility:hidden";
            link.download = fileName + ".pdf";
            
            //this part will append the anchor tag and remove it after automatic click
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }


     $scope.imprimirSignosVitales = function(){            
            var fileName = "Reporte";
            var uri = 'api/classes/formatoVitales.php?fol='+$rootScope.folio;
            var link = document.createElement("a");    
            link.href = uri;
            
            //set the visibility hidden so it will not effect on your web-layout
            link.style = "visibility:hidden";
            link.download = fileName + ".pdf";
            
            //this part will append the anchor tag and remove it after automatic click
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        $scope.imprimirSignosVitalesSub = function(){ 
             busquedas.validaSubsec($rootScope.folio).success(function(data){                                      
                if(data.Cons==null){
                  data.Cons=1;
                }
                $scope.noSubsec=data.Cons;    
              });           
            var fileName = "Reporte";
            var uri = 'api/classes/formatoVitalesSub.php?fol='+$rootScope.folio+'&sub='+$scope.noSubsec;
            var link = document.createElement("a");    
            link.href = uri;
            
            //set the visibility hidden so it will not effect on your web-layout
            link.style = "visibility:hidden";
            link.download = fileName + ".pdf";
            
            //this part will append the anchor tag and remove it after automatic click
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

         $scope.imprimirConstancia = function(){            
            var fileName = "Reporte";
            var uri = 'api/classes/formatoCia.php?fol='+$rootScope.folio;
            var link = document.createElement("a");    
            link.href = uri;
            
            //set the visibility hidden so it will not effect on your web-layout
            link.style = "visibility:hidden";
            link.download = fileName + ".pdf";
            
            //this part will append the anchor tag and remove it after automatic click
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }


         $scope.irDocumentos = function(){         
              $location.path("/documentos");          
        }
});