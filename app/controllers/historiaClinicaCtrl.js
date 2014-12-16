app.controller('historiaClinicaCtrl', function($scope,$rootScope,$location,$cookies,WizardHandler,busquedas,$http) {
	$rootScope.folio=$cookies.folio;
  $scope.formularios={};	
  $scope.cargador=false;
  $scope.cargador1=false;
  $scope.cargador2=false;
  $scope.cargador3=false;
  $scope.cargador4=false;
  $scope.cargador5=false;
  $scope.cargador6=false;
  $scope.cargador7=false;
  $scope.cargador8=false;
  $scope.cargador9=false;
    $scope.padEsp1='No';
    $scope.quiro='No';
    $scope.plant='No';
    $scope.trat='No';
    $scope.inter='No';
    $scope.dep='No';
    $scope.adic='No';    
    $scope.padObs='';
    $scope.siEmb='No';
    
    $scope.datos={
        nombre:'',
        pat:'',
        mat:'',
        fecnac:'',
        tel:'',
        numeroTel:'',
        mail:'',
        obs:''
    };
    $scope.datos1={
        enfermedad:'',
        familiar:'',
        estatus:'',
        observaciones:''        
    };
    $scope.padecimiento={
        nombre:'',
        obs:''
    };
    $scope.otras={
        enf:'',
        obs:''
    };
    $scope.alergia={
        alergia:'',
        obs:''
    };
    $scope.padEsp={      
        obs:''
    };
    $scope.quiropractico={      
        obs:''
    };
    $scope.plantillas={      
        obs:''
    };
    $scope.tratamiento={      
        obs:''
    };
    $scope.intervenciones={      
        obs:''
    };
     $scope.deporte={      
        obs:''
    };
    $scope.adiccion={      
        obs:''
    };
    $scope.acc={      
        opc:'Si',
        lugar:'',
        obs:''
    };
     $scope.vitales={      
        tem:"",
        talla:"",
        peso:"",
        frecResp:"",
        sistole:"",
        astole:"",
        frecCard:"",
        obs:''
    };
    $scope.accidente={
        llega:'',
        fecha:'',
        vehiculo:'',
        mecanismo:[],
        seguridad:[],
        vomido:'',
        mareo:'',
        nauseas:'',
        conocimiento:'',
        cefalea:'',
        mecLesion:''
    }; 
    $scope.arregloOpc={  
               Nod:'1',
               Nodtx:'1',
               Cintu:'',
               Cintutx:'',
               Bolsa:'',
               Bolsatx:'',
               Ropa:'',
               Ropatx:'',
               Casco:'',
               Cascotx:'',
               Rodi:'',
               Roditx:'',
               Code:'',
               Codetx:'',
               Costi:'',
               Costitx:'',
               Nodi:'1',
               Noditx:'',
               Volc:'',
               Volctx:'',
               Alca:'',
               Alcatx:'',
               Late:'',
               Latetx:'',
               Fron:'',
               Frontx:'',
               Derr:'',
               Derrtx:'',
               Simp:'',
               Simptx:'',
               Imap:'',
               Imaptx:'',
               Caid:'',
               Caidtx:'',
               Lesdep:'',
               Lesdeptx:'',
               Lestra:'',
               Lestratx:'',
               ManSub:'',
               ManSubtx:'',
               Otr:'',
               Otrtx:''
              }   
        $scope.embarazo={
            controlGine:'No'
        }
        $scope.defaultRelig={
            obsReligDefault:'No'
        }

        $scope.interacted = function(field) {
          //$dirty es una propiedad de formulario que detecta cuando se esta escribieno algo en el input
          return $scope.formularios.pac.$submitted && field.$invalid;          
        };

        $scope.interacted1 = function(field) {
          //$dirty es una propiedad de formulario que detecta cuando se esta escribieno algo en el input          
          return $scope.formularios.heredo.$submitted && field.$invalid;          
        };

        $scope.interacted2 = function(field) {
          //$dirty es una propiedad de formulario que detecta cuando se esta escribieno algo en el input          
          return $scope.formularios.cronicos.$submitted && field.$invalid;          
        };
         $scope.interacted3 = function(field) {
          //$dirty es una propiedad de formulario que detecta cuando se esta escribieno algo en el input          
          return $scope.formularios.enfermedades.$submitted && field.$invalid;          
        };
         $scope.interacted4 = function(field) {
          //$dirty es una propiedad de formulario que detecta cuando se esta escribieno algo en el input          
          return $scope.formularios.alergi.$submitted && field.$invalid;          
        };

        $scope.interacted5 = function(field) {
          //$dirty es una propiedad de formulario que detecta cuando se esta escribieno algo en el input          
          return $scope.formularios.ante.$submitted && field.$invalid;          
        };

        busquedas.ocupacion().success(function(data){
            $scope.ocupacion=data;               
        });
        busquedas.edoCivil().success(function(data){
            $scope.edoCivil=data;
            //console.log(data);
        })

        busquedas.datosPaciente($rootScope.folio).success(function(data){

            $rootScope.nombre= data.Exp_nombre + ' '+data.Exp_paterno+ ' ' + data.Exp_materno;                                  
            $scope.datos.fecnac= data.Exp_fechaNac;            
            $scope.datos.mail=data.Exp_mail;
            $scope.datos.obs=data.Rel_clave;
            $scope.datos.tel=data.Exp_telefono;
            $scope.datos.ocu = data.Ocu_clave;
            $scope.datos.edoC= data.Edo_clave;
            $scope.datos.sexo= data.Exp_sexo;

            edad=chkdate($scope.datos.fecnac,1);
            $scope.datos.anios=edad[0];
            $scope.datos.meses=edad[1]; 
            $scope.datos.folio= $rootScope.folio;      
            
        });     
         $scope.finished = function() {
            alert("Wizard finished :)");
        }

        $scope.logStep = function() {
            //console.log("Step continued");
        }

        $scope.goBack = function() {
            WizardHandler.wizard().goTo(0);
        }

        $scope.calculaFecha = function(){            
            
            edad=chkdate($scope.datos.fecnac,1);
            $scope.datos.anios=edad[0];
            $scope.datos.meses=edad[1]; 
        }
        $scope.obsRelig = function(){        
            if($scope.defaultRelig.obsReligDefault){
              $scope.datos.obs='Ninguna';
            }
            else{
              $scope.datos.obs=''; 
            }
        }
        $scope.enviaDatos = function(){            
            if($scope.formularios.pac.$valid){
              $scope.cargador=true;
            $http({
                    url:'api/api.php?funcion=guardaDatos',
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: $scope.datos
                    }).success( function (data){   
                      
                        busquedas.enfermedad().success(function(data){
                            $scope.enfermedad=data;                                                  
                        });
                        busquedas.familiar().success(function(data){
                            $scope.familiar=data;                            
                        });
                        busquedas.estatusFam().success(function(data){
                            $scope.estatus=data;                            
                        });
                        busquedas.listaEnfHeredo($rootScope.folio).success(function(data){
                            if(data.length>0){
                            $scope.listEnfeHe=data;
                            }
                            $scope.cargador=false;                                                
                        });
                        $cookies.estatus=1;
                        WizardHandler.wizard().next();

                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
                  }
        }
        $scope.guardaAntedente = function(){          
          //console.log($scope.datos1);
            if($scope.formularios.heredo.$valid){
            $scope.cargador=true;
            $http({
                    url:'api/api.php?funcion=guardaEnfH&fol='+$rootScope.folio,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: $scope.datos1
                    }).success( function (data){                        
                      if(!data.respuesta){                                                                                      
                        $scope.listEnfeHe=data;
                        $scope.cargador=false;                           
                        $scope.datos1={
                          enfermedad:'',
                          familiar:'',
                          estatus:'',
                          observaciones:''        
                        }
                        $scope.formularios.heredo.$submitted=false;                                                                                               
                      }
                      else{
                        alert('error en la inserción');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
              }
        }
        $scope.borrarEnfHeredo = function(contEnf){   
            $scope.cargador=true;                
            $http({
                    url:'api/api.php?funcion=borraEnfH&fol='+$rootScope.folio+'&cont='+contEnf,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: {'calve':'valor'}
                    }).success( function (data){   
                      //console.log(data);
                      if(!data.respuesta){
                        if(data.length>0){                                                                                    
                            $scope.listEnfeHe=data;                                                      
                         }else{
                            $scope.listEnfeHe=undefined;
                         }
                          $scope.cargador=false;
                      }
                      else{
                        alert('error en la inserción');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
        }
        $scope.antPersonales = function(){         
            busquedas.padecimientos().success(function(data){                      
              $scope.padecimientos=data;                                 
            }); 
            busquedas.otrasEnf().success(function(data){                                 
                $scope.otrasE=data;                                      
            });
            busquedas.alergias().success(function(data){                      
              $scope.alergias=data;                          
            });    
            busquedas.listaPadecimientos($rootScope.folio).success(function(data){                                                 
              if(data.length>0){   
                 $scope.listaPad=data;
              }                        
            });  
            busquedas.listaOtrasEnf($rootScope.folio).success(function(data){                      
              if(data.length>0){   
                $scope.listaOtras=data; 
              }
              //console.log($scope.listaOtras);                         
            });  
            busquedas.listaAlergias($rootScope.folio).success(function(data){                      
              if(data.length>0){   
                $scope.listaAlergias=data; 
              }
              //console.log($scope.listaAlergias);                         
            }); 
            busquedas.listaPadEsp($rootScope.folio).success(function(data){                      
              if(data.length>0){   
              $scope.listaPadEsp=data; 
              }
              //console.log($scope.listaPadEsp);                         
            }); 
            busquedas.listaTratQuiro($rootScope.folio).success(function(data){                      
              if(data.length>0){   
              $scope.listaTratQui=data; 
              }
              //console.log($scope.listaPadEsp);                         
            }); 
            busquedas.listaPlantillas($rootScope.folio).success(function(data){                      
              if(data.length>0){   
              $scope.listaPlantillas=data; 
              }
              //console.log($scope.listaPlantillas);                        
            }); 
            busquedas.listaTratamientos($rootScope.folio).success(function(data){                      
              if(data.length>0){   
              $scope.listaTratamientos=data; 
              }
              //console.log($scope.listaTratamientos);                        
            });
            busquedas.listaIntervenciones($rootScope.folio).success(function(data){                      
              if(data.length>0){   
              $scope.listaIntervenciones=data; 
              }
              //console.log($scope.listaIntervenciones);                        
            });
            busquedas.listaDeportes($rootScope.folio).success(function(data){                      
              if(data.length>0){   
              $scope.listaDeportes=data; 
              }
              //console.log($scope.listaDeportes);                      
            }); 
             busquedas.listaAdicciones($rootScope.folio).success(function(data){                      
              if(data.length>0){   
              $scope.listaAdicciones=data; 
              }
              //console.log($scope.listaAdicciones);                      
            }); 
             $cookies.estatus=2;
            WizardHandler.wizard().next();

        }
        $scope.agregaCronDeg= function(){
            //console.log($scope.padecimiento);
            if($scope.formularios.cronicos.$valid){
            $scope.cargador=true;           
            $http({
                    url:'api/api.php?funcion=guardaPad&fol='+$rootScope.folio,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: $scope.padecimiento
                    }).success( function (data){   
                    //console.log(data);
                      if(!data.respuesta){
                        $scope.cargador=false;                                     
                        $scope.listaPad=data;                                                                      
                        $scope.padecimiento={
                            nombre:'',
                            obs:''                            
                        };
                        $scope.formularios.cronicos.$submitted=false;
                      }
                      else{
                        alert('error en la inserción');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
                  }
        }
        $scope.borrarPadecimiento = function(idPad){ 
         $scope.cargador=true;                            
            $http({
                    url:'api/api.php?funcion=borraPadec&fol='+$rootScope.folio+'&cont='+idPad,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: {'calve':'valor'}
                    }).success( function (data){   
                      //console.log(data);
                      if(!data.respuesta){
                        if(data.length>0){                                        
                          $scope.listaPad=data;  
                          }else{
                            $scope.listaPad=undefined;
                          }
                        $scope.cargador=false;                                                            
                      }
                      else{
                        alert('error en la inserción');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
        }
        $scope.guardaOtras= function(){
           if($scope.formularios.enfermedades.$valid){
            //console.log($scope.otras);
            $scope.cargador1=true;
            $http({
                    url:'api/api.php?funcion=guardaOtras&fol='+$rootScope.folio,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: $scope.otras
                    }).success( function (data){   
                     // console.log(data);
                      if(!data.respuesta){                                       
                          $scope.listaOtras=data; 
                          $scope.cargador1=false;
                         // console.log($scope.listaOtras);                                               
                        $scope.otras={
                            enf:'',
                            obs:''                            
                        };
                        $scope.formularios.enfermedades.$submitted=false;
                      }
                      else{
                        alert('error en la inserción');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
            }
        }
        $scope.borrarOtras = function(idPad){
          $scope.cargador1=true;                             
            $http({
                    url:'api/api.php?funcion=borraOtrasEnf&fol='+$rootScope.folio+'&cont='+idPad,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: {'calve':'valor'}
                    }).success( function (data){   
                      //console.log(data);
                      if(!data.respuesta){  
                        if(data.length>0){                                                              
                          $scope.listaOtras=data;                                                                                                 
                        }else{
                          $scope.listaOtras=undefined;
                        }
                         $scope.cargador1=false;
                      }
                      else{
                        alert('error en la eliminación');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
        }
        $scope.guardaAlergia= function(){
          if($scope.formularios.alergi.$valid){
            $scope.cargador2=true;            
            $http({
                    url:'api/api.php?funcion=guardaAlergia&fol='+$rootScope.folio,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: $scope.alergia
                    }).success( function (data){   
                     // console.log(data);
                      if(!data.respuesta){                                
                          $scope.listaAlergias=data; 
                          $scope.cargador2=false; 
                          //console.log($scope.listaAlergias);                                               
                        $scope.alergia={
                            alergia:'',
                            obs:''
                        };
                        $scope.formularios.alergi.$submitted=false;
                      }
                      else{
                        alert('error en la inserción');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
          }
        }
        $scope.borrarAlergia = function(idPad){ 
            $scope.cargador2=true;                             
            $http({
                    url:'api/api.php?funcion=borraAlergia&fol='+$rootScope.folio+'&cont='+idPad,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: {'calve':'valor'}
                    }).success( function (data){   
                     // console.log(data);
                      if(!data.respuesta){
                       if(data.length>0){                                                
                          $scope.listaAlergias=data; 
                        }else{
                          $scope.listaAlergias=undefined;
                        }
                          $scope.cargador2=false; 
                         // console.log($scope.listaAlergias);                                                                                 
                      }
                      else{
                        alert('error en la eliminación');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
        }
        $scope.guardaPadEspalda= function(){           
          //console.log($scope.padEsp);
            $scope.cargador3=true; 
            $http({
                    url:'api/api.php?funcion=guardaPadEspalda&fol='+$rootScope.folio,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: $scope.padEsp
                    }).success( function (data){   
                      //console.log(data);
                      if(!data.respuesta){                                              
                            $scope.listaPadEsp=data; 
                            $scope.cargador3=false; 
                            //console.log($scope.listaPadEsp);                                                 
                        $scope.padEsp={
                          obs:''
                        }
                      }
                      else{
                        alert('error en la inserción');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
        }
        $scope.eliminaPadEspalda = function(idPad){
            $scope.cargador3=true;                              
            $http({
                    url:'api/api.php?funcion=borraPadEspalda&fol='+$rootScope.folio+'&cont='+idPad,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: {'calve':'valor'}
                    }).success( function (data){   
                      //console.log(data);
                      if(!data.respuesta){ 
                        if(data.length>0){                                                                           
                          $scope.listaPadEsp=data;                           
                        }else{
                          $scope.listaPadEsp=undefined;
                        }                             
                      }
                      else{
                        alert('error en la eliminación');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
        }
        $scope.guardaTratQui= function(){           
          //console.log($scope.quiropractico);
          $scope.cargador4=true; 
            $http({
                    url:'api/api.php?funcion=guardaTratQuiro&fol='+$rootScope.folio,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: $scope.quiropractico
                    }).success( function (data){   
                      //console.log(data);
                      if(!data.respuesta){                        
                          $scope.listaTratQui=data; 
                          $scope.cargador4=false;                          
                        $scope.quiropractico={
                          obs:''
                        }
                      }
                      else{
                        alert('error en la inserción');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
        }
        $scope.eliminaTratQui = function(idPad){ 
            $scope.cargador4=true;                             
            $http({
                    url:'api/api.php?funcion=borraTratQui&fol='+$rootScope.folio+'&cont='+idPad,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: {'calve':'valor'}
                    }).success( function (data){   
                      //console.log(data);
                      if(!data.respuesta){  
                        if(data.length>0){                                          
                          $scope.listaTratQui=data; 
                        }else{
                          $scope.listaTratQui=undefined;
                        }
                          $scope.cargador4=false;                                                                               
                      }
                      else{
                        alert('error en la eliminación');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
        }
        $scope.guardaPlantillas= function(){           
          //console.log($scope.plantillas);
          $scope.cargador5=true; 
            $http({
                    url:'api/api.php?funcion=guardaPlantillas&fol='+$rootScope.folio,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: $scope.plantillas
                    }).success( function (data){   
                      //console.log(data);
                      if(!data.respuesta){                                          
                          $scope.listaPlantillas=data; 
                          $scope.cargador5=false;                          
                        $scope.plantillas={
                          obs:''
                        }
                      }
                      else{
                        alert('error en la inserción');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
        }
         $scope.eliminaPlantillas = function(idPad){                             
            $scope.cargador5=true; 
            $http({
                    url:'api/api.php?funcion=borraPlatillas&fol='+$rootScope.folio+'&cont='+idPad,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: {'clave':'valor'}
                    }).success( function (data){   
                      //console.log(data);
                      if(!data.respuesta){
                        if(data.length>0){                                           
                          $scope.listaPlantillas=data; 
                        }else{
                          $scope.listaPlantillas=undefined;
                        }
                          $scope.cargador5=false;                                
                        }                      
                      else{
                        alert('error en la eliminación');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
        }
        $scope.guardaTratamiento= function(){           
          //console.log($scope.tratamiento);
          $scope.cargador6=true; 
            $http({
                    url:'api/api.php?funcion=guardaTratamiento&fol='+$rootScope.folio,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: $scope.tratamiento
                    }).success( function (data){   
                      //console.log(data);
                      if(!data.respuesta){                                          
                          $scope.listaTratamientos=data; 
                          $scope.cargador6=false; 
                        $scope.tratamiento={
                          obs:''
                        }
                      }
                      else{
                        alert('error en la inserción');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
        }
        $scope.eliminaTratamiento = function(idPad){                             
            $scope.cargador6=true; 
            $http({
                    url:'api/api.php?funcion=borraTratamiento&fol='+$rootScope.folio+'&cont='+idPad,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: {'clave':'valor'}
                    }).success( function (data){   
                      //console.log(data);
                      if(!data.respuesta){
                        if(data.length>0){                                          
                          $scope.listaTratamientos=data; 
                        }else{
                          $scope.listaTratamientos=undefined;
                        }
                          $scope.cargador6=false;                                                                            
                      }
                      else{
                        alert('error en la eliminación');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
        }
        $scope.guardaIntervenciones= function(){           
          //console.log($scope.tratamiento);
          $scope.cargador7=true; 
            $http({
                    url:'api/api.php?funcion=guardaIntervenciones&fol='+$rootScope.folio,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: $scope.intervenciones
                    }).success( function (data){   
                      //console.log(data);
                      if(!data.respuesta){                        
                          $scope.listaIntervenciones=data; 
                          $scope.cargador7=false;                                                   
                        $scope.intervenciones={
                          obs:''
                        }
                      }
                      else{
                        alert('error en la inserción');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
        }
        $scope.eliminaIntervencion = function(idPad){ 
            $scope.cargador7=true;                             
            $http({
                    url:'api/api.php?funcion=borraIntervencion&fol='+$rootScope.folio+'&cont='+idPad,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: {'clave':'valor'}
                    }).success( function (data){   
                      //console.log(data);
                      if(!data.respuesta){  
                        if(data.length>0){                      
                          $scope.listaIntervenciones=data; 
                        }else{
                          $scope.listaIntervenciones=undefined;
                          }                        
                          $scope.cargador7=false;                                                       
                      }
                      else{
                        alert('error en la eliminación');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
        }
        $scope.guardaDeporte= function(){           
          //console.log($scope.tratamiento);
          $scope.cargador8=true; 
            $http({
                    url:'api/api.php?funcion=guardaDeporte&fol='+$rootScope.folio,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: $scope.deporte
                    }).success( function (data){   
                      //console.log(data);
                      if(!data.respuesta){                        
                          $scope.listaDeportes=data; 
                          $scope.cargador8=false;  
                        $scope.deporte={
                          obs:''
                        }
                      }
                      else{
                        alert('error en la inserción');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
        }
        $scope.eliminaDeporte = function(idPad){  
            $scope.cargador8=true;                            
            $http({
                    url:'api/api.php?funcion=borraDeporte&fol='+$rootScope.folio+'&cont='+idPad,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: {'clave':'valor'}
                    }).success( function (data){   
                      //console.log(data);
                      if(!data.respuesta){   
                        if(data.length>0){                     
                          $scope.listaDeportes=data; 
                        }else{
                          $scope.listaDeportes=undefined;
                        }
                          $scope.cargador8=false;                                            
                      }
                      else{
                        alert('error en la eliminación');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
        }
        $scope.guardaAdiccion= function(){           
          //console.log($scope.adiccion);
            $scope.cargador9=true; 
            $http({
                    url:'api/api.php?funcion=guardaAdiccion&fol='+$rootScope.folio,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: $scope.adiccion
                    }).success( function (data){   
                      //console.log(data);
                      if(!data.respuesta){                        
                          $scope.listaAdicciones=data; 
                          $scope.cargador9=false;  
                        $scope.adiccion={
                          obs:''
                        }
                      }
                      else{
                        alert('error en la inserción');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
        }
        $scope.eliminaAdiccion = function(idPad){ 
            $scope.cargador9=true;                             
            $http({
                    url:'api/api.php?funcion=borraAdiccion&fol='+$rootScope.folio+'&cont='+idPad,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: {'clave':'valor'}
                    }).success( function (data){   
                      //console.log(data);
                      if(!data.respuesta){    
                        if(data.length>0){                     
                          $scope.listaAdicciones=data; 
                        }else{
                          $scope.listaAdicciones=undefined;
                        }
                          $scope.cargador9=false;                              
                      }
                      else{
                        alert('error en la eliminación');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
        }
        $scope.accidentesAnteriores = function(){          
          busquedas.catLugar().success(function(data){                      
            $scope.lugar=data;                          
          }); 
          busquedas.listaAccAnteriores($rootScope.folio).success(function(data){
            if(data.length>0){                      
              $scope.listAccAnt=data;
            }
            //console.log($scope.listAccAnt);                          
          }); 
          $cookies.estatus=3;
          WizardHandler.wizard().next();  
        }
        $scope.guardaAccAnt= function(){           
          //console.log($scope.acc);
          if($scope.formularios.ante.$valid){
          $scope.cargador=true;
            $http({
                    url:'api/api.php?funcion=guardaAccAnt&fol='+$rootScope.folio,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: $scope.acc
                    }).success( function (data){                      
                      if(!data.respuesta){                        
                          $scope.listAccAnt=data;                            
                        $scope.acc={
                          opc:'Si',
                          lugar:'',
                          obs:''                          
                        }
                        $scope.formularios.ante.$submitted=false;
                        $scope.cargador=false;
                      }
                      else{
                        alert('error en la inserción');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
            }
        }
        $scope.eliminaAccAnt = function(idPad){                             
            $scope.cargador=true;
            $http({
                    url:'api/api.php?funcion=borraAccAnt&fol='+$rootScope.folio+'&cont='+idPad,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: {'clave':'valor'}
                    }).success( function (data){   
                      //console.log(data);
                      if(!data.respuesta){        
                        if(data.length>0){
                          $scope.listAccAnt=data;
                        }else{
                          $scope.listAccAnt=undefined;
                        }                                     
                        $scope.cargador=false                                                                            
                      }
                      else{
                        alert('error en la eliminación');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
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
         $scope.irDocumentos = function(){         
              $location.path("/documentos");          
        }
});


function chkdate(objName, conedad)
{
//var strDatestyle = "US"; //United States date style
var strDatestyle = "EU";  //European date style
var strDate;
var strDateArray;
var strDay;
var strMonth;
var strYear;
var intday;
var intMonth;
var intYear;
var booFound = false;
var datefield = objName;
var strSeparatorArray = new Array("-"," ","/",".");
var intElementNr;
var err = 0;
var strMonthArray = new Array(12);

var d = new Date();
var dhoy =d.getDate();
var mhoy =d.getMonth()+1;
var ahoy =d.getFullYear();
var edad;

strMonthArray[0] = "Ene";
strMonthArray[1] = "Feb";
strMonthArray[2] = "Mar";
strMonthArray[3] = "Abr";
strMonthArray[4] = "May";
strMonthArray[5] = "Jun";
strMonthArray[6] = "Jul";
strMonthArray[7] = "Ago";
strMonthArray[8] = "Sep";
strMonthArray[9] = "Oct";
strMonthArray[10] = "Nov";
strMonthArray[11] = "Dic";
strDate = datefield;
if (strDate.length < 1) {
return true;
}
for (intElementNr = 0; intElementNr < strSeparatorArray.length; intElementNr++) {
if (strDate.indexOf(strSeparatorArray[intElementNr]) != -1) {
strDateArray = strDate.split(strSeparatorArray[intElementNr]);
if (strDateArray.length != 3) {
err = 1;
return false;
}
else {
strDay = strDateArray[0];
strMonth = strDateArray[1];
strYear = strDateArray[2];
}
booFound = true;
   }
}
if (booFound == false) {
if (strDate.length>5) {
strDay = strDate.substr(0, 2);
strMonth = strDate.substr(2, 2);
strYear = strDate.substr(4);
   }
}
if (strYear.length == 2) {
strYear = '20' + strYear;
}
// US style
if (strDatestyle == "US") {
strTemp = strDay;
strDay = strMonth;
strMonth = strTemp;
}
intday = parseInt(strDay, 10);
if (isNaN(intday)) {
err = 2;
return false;
}
intMonth = parseInt(strMonth, 10);
if (isNaN(intMonth)) {
for (i = 0;i<12;i++) {
if (strMonth.toUpperCase() == strMonthArray[i].toUpperCase()) {
intMonth = i+1;
strMonth = strMonthArray[i];
i = 12;
   }
}
if (isNaN(intMonth)) {
err = 3;
return false;
   }
}
intYear = parseInt(strYear, 10);
if (isNaN(intYear)) {
err = 4;
return false;
}
if (intMonth>12 || intMonth<1) {
err = 5;
return false;
}
if ((intMonth == 1 || intMonth == 3 || intMonth == 5 || intMonth == 7 || intMonth == 8 || intMonth == 10 || intMonth == 12) && (intday > 31 || intday < 1)) {
err = 6;
return false;
}
if ((intMonth == 4 || intMonth == 6 || intMonth == 9 || intMonth == 11) && (intday > 30 || intday < 1)) {
err = 7;
return false;
}
if (intMonth == 2) {
if (intday < 1) {
err = 8;
return false;
}
if (LeapYear(intYear) == true) {
if (intday > 29) {
err = 9;
return false;
}
}
else {
if (intday > 28) {
err = 10;
return false;
}
}
}
if (strDatestyle == "US") {
//datefield.value = strMonthArray[intMonth-1] + " " + intday+" " + strYear;
}
else
  {//Regreso de fecha *********************************************************************************
  //datefield.value = intday + " " + strMonthArray[intMonth-1] + " " + strYear;
  //si el mes es el mismo pero el dï¿½a inferior aun no ha cumplido aï¿½os, le quitaremos un aï¿½o al actual
  if ((intMonth==mhoy)&&(intday > dhoy))
  {
  ahoy=ahoy-1;

  }
  //si el mes es superior al actual tampoco habrï¿½ cumplido aï¿½os, por eso le quitamos un aï¿½o al actual
  if (intMonth > mhoy)
  {
  ahoy=ahoy-1;
  }
  if(intMonth==mhoy){
    meses=0
  }
  else if(intMonth>mhoy){
    meses =12-(intMonth - mhoy);
  }
  else if(intMonth<mhoy){
    meses = mhoy-intMonth;
  }
  edad=ahoy-strYear;
  if (conedad==1){  
  }
}
var edadCom=null;
edadCom=[edad,meses];
return edadCom;
}

function verOpciones(opcion){
  switch(opcion){
    case '0':
            validos={Nod:'1',
               Nodtx:'1',
               Cintu:'',
               Cintutx:'',
               Bolsa:'',
               Bolsatx:'',
               Ropa:'',
               Ropatx:'',
               Casco:'',
               Cascotx:'',
               Rodi:'',
               Roditx:'',
               Code:'',
               Codetx:'',
               Costi:'',
               Costitx:'',
               Nodi:'1',
               Noditx:'1',
               Volc:'',
               Volctx:'',
               Alca:'',
               Alcatx:'',
               Late:'',
               Latetx:'',
               Fron:'',
               Frontx:'',
               Derr:'',
               Derrtx:'',
               Simp:'',
               Simptx:'',
               Imap:'',
               Imaptx:'',
               Caid:'',
               Caidtx:'',
               Lesdep:'',
               Lesdeptx:'',
               Lestra:'',
               Lestratx:'',
               ManSub:'',
               ManSubtx:'',
               Otr:'',
               Otrtx:''
              }
    break; 
     case '1':
            validos={Nod:'',
               Nodtx:'',
               Cintu:'1',
               Cintutx:'1',
               Bolsa:'1',
               Bolsatx:'1',
               Ropa:'',
               Ropatx:'',
               Casco:'',
               Cascotx:'',
               Rodi:'',
               Roditx:'',
               Code:'',
               Codetx:'',
               Costi:'',
               Costitx:'',
               Nodi:'',
               Noditx:'',
               Volc:'1',
               Volctx:'1',
               Alca:'1',
               Alcatx:'1',
               Late:'1',
               Latetx:'1',
               Fron:'1',
               Frontx:'1',
               Derr:'',
               Derrtx:'',
               Simp:'',
               Simptx:'',
               Imap:'',
               Imaptx:'',
               Caid:'',
               Caidtx:'',
               Lesdep:'',
               Lesdeptx:'',
               Lestra:'',
               Lestratx:'',
               ManSub:'1',
               ManSubtx:'1',
               Otr:'1',
               Otrtx:'1'
              }
    break; 
     case '2':
            validos={Nod:'',
               Nodtx:'',
               Cintu:'',
               Cintutx:'',
               Bolsa:'',
               Bolsatx:'',
               Ropa:'1',
               Ropatx:'1',
               Casco:'1',
               Cascotx:'1',
               Rodi:'',
               Roditx:'',
               Code:'',
               Codetx:'',
               Costi:'',
               Costitx:'',
               Nodi:'',
               Noditx:'',
               Volc:'',
               Volctx:'',
               Alca:'1',
               Alcatx:'1',
               Late:'1',
               Latetx:'1',
               Fron:'1',
               Frontx:'1',
               Derr:'1',
               Derrtx:'1',
               Simp:'',
               Simptx:'',
               Imap:'',
               Imaptx:'',
               Caid:'',
               Caidtx:'',
               Lesdep:'',
               Lesdeptx:'',
               Lestra:'',
               Lestratx:'',
               ManSub:'',
               ManSubtx:'',
               Otr:'',
               Otrtx:''
              }
    break; 
     case '3':
            validos={Nod:'1',
               Nodtx:'1',
               Cintu:'',
               Cintutx:'',
               Bolsa:'',
               Bolsatx:'',
               Ropa:'',
               Ropatx:'',
               Casco:'',
               Cascotx:'',
               Rodi:'',
               Roditx:'',
               Code:'',
               Codetx:'',
               Costi:'',
               Costitx:'',
               Nodi:'',
               Noditx:'',
               Volc:'',
               Volctx:'',
               Alca:'',
               Alcatx:'',
               Late:'',
               Latetx:'',
               Fron:'',
               Frontx:'',
               Derr:'',
               Derrtx:'',
               Simp:'',
               Simptx:'',
               Imap:'',
               Imaptx:'',
               Caid:'1',
               Caidtx:'1',
               Lesdep:'1',
               Lesdeptx:'1',
               Lestra:'1',
               Lestratx:'1',
               ManSub:'',
               ManSubtx:'',
               Otr:'',
               Otrtx:''
              }
    break; 
     case '4':
            validos={Nod:'',
               Nodtx:'',
               Cintu:'',
               Cintutx:'',
               Bolsa:'',
               Bolsatx:'',
               Ropa:'',
               Ropatx:'',
               Casco:'1',
               Cascotx:'1',
               Rodi:'1',
               Roditx:'1',
               Code:'1',
               Codetx:'1',
               Costi:'1',
               Costitx:'1',
               Nodi:'',
               Noditx:'',
               Volc:'',
               Volctx:'',
               Alca:'1',
               Alcatx:'1',
               Late:'1',
               Latetx:'1',
               Fron:'1',
               Frontx:'1',
               Derr:'',
               Derrtx:'',
               Simp:'',
               Simptx:'',
               Imap:'',
               Imaptx:'',
               Caid:'',
               Caidtx:'',
               Lesdep:'',
               Lesdeptx:'',
               Lestra:'',
               Lestratx:'',
               ManSub:'',
               ManSubtx:'',
               Otr:'',
               Otrtx:''
              }
    break; 
     case '5':
            validos={Nod:'1',
               Nodtx:'1',
               Cintu:'',
               Cintutx:'',
               Bolsa:'',
               Bolsatx:'',
               Ropa:'',
               Ropatx:'',
               Casco:'',
               Cascotx:'',
               Rodi:'',
               Roditx:'',
               Code:'',
               Codetx:'',
               Costi:'',
               Costitx:'',
               Nodi:'',
               Noditx:'',
               Volc:'',
               Volctx:'',
               Alca:'',
               Alcatx:'',
               Late:'',
               Latetx:'',
               Fron:'',
               Frontx:'',
               Derr:'',
               Derrtx:'',
               Simp:'1',
               Simptx:'1',
               Imap:'1',
               Imaptx:'1',
               Caid:'',
               Caidtx:'',
               Lesdep:'',
               Lesdeptx:'',
               Lestra:'',
               Lestratx:'',
               ManSub:'',
               ManSubtx:'',
               Otr:'',
               Otrtx:''
              }
    break; 
     case '6':
            validos={Nod:'1',
               Nodtx:'1',
               Cintu:'',
               Cintutx:'',
               Bolsa:'',
               Bolsatx:'',
               Ropa:'',
               Ropatx:'',
               Casco:'',
               Cascotx:'',
               Rodi:'',
               Roditx:'',
               Code:'',
               Codetx:'',
               Costi:'',
               Costitx:'',
               Nodi:'',
               Noditx:'',
               Volc:'1',
               Volctx:'1',
               Alca:'1',
               Alcatx:'1',
               Late:'1',
               Latetx:'1',
               Fron:'1',
               Frontx:'1',
               Derr:'',
               Derrtx:'',
               Simp:'',
               Simptx:'',
               Imap:'',
               Imaptx:'',
               Caid:'',
               Caidtx:'',
               Lesdep:'',
               Lesdeptx:'',
               Lestra:'',
               Lestratx:'',
               ManSub:'1',
               ManSubtx:'1',
               Otr:'1',
               Otrtx:'1'
              }
    break; 
     case '7':
            validos={Nod:'1',
               Nodtx:'1',
               Cintu:'',
               Cintutx:'',
               Bolsa:'',
               Bolsatx:'',
               Ropa:'',
               Ropatx:'',
               Casco:'',
               Cascotx:'',
               Rodi:'',
               Roditx:'',
               Code:'',
               Codetx:'',
               Costi:'',
               Costitx:'',
               Nodi:'1',
               Noditx:'1',
               Volc:'',
               Volctx:'',
               Alca:'',
               Alcatx:'',
               Late:'',
               Latetx:'',
               Fron:'',
               Frontx:'',
               Derr:'',
               Derrtx:'',
               Simp:'',
               Simptx:'',
               Imap:'',
               Imaptx:'',
               Caid:'',
               Caidtx:'',
               Lesdep:'',
               Lesdeptx:'',
               Lestra:'',
               Lestratx:'',
               ManSub:'',
               ManSubtx:'',
               Otr:'',
               Otrtx:''
              }
    break; 
     default:
            validos={Nod:'1',
               Nodtx:'1',
               Cintu:'',
               Cintutx:'',
               Bolsa:'',
               Bolsatx:'',
               Ropa:'',
               Ropatx:'',
               Casco:'',
               Cascotx:'',
               Rodi:'',
               Roditx:'',
               Code:'',
               Codetx:'',
               Costi:'',
               Costitx:'',
               Nodi:'1',
               Noditx:'1',
               Volc:'',
               Volctx:'',
               Alca:'',
               Alcatx:'',
               Late:'',
               Latetx:'',
               Fron:'',
               Frontx:'',
               Derr:'',
               Derrtx:'',
               Simp:'',
               Simptx:'',
               Imap:'',
               Imaptx:'',
               Caid:'',
               Caidtx:'',
               Lesdep:'',
               Lesdeptx:'',
               Lestra:'',
               Lestratx:'',
               ManSub:'',
               ManSubtx:'',
               Otr:'',
               Otrtx:''
              }
    break; 
  }  
    return validos;  
}