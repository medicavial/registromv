app.controller('notaMedicaCtrl', function($scope,$rootScope,$location,$cookies,WizardHandler,busquedas,$http) {
	debugger;
  $rootScope.folio=$cookies.folio;	
  $rootScope.usrLogin= $cookies.usrLogin;
  $rootScope.uniClave=$cookies.uniClave;
  $rootScope.cargador=false;
   $scope.mensaje=false;
   $scope.mensajeLesion=false;
   $scope.irVitales=false;
   $scope.verVitales=false;
   $scope.siEmb='No';  
  $scope.regresar=false;
  $scope.paso='';
  $scope.sexo='';
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
    }
    $rootScope.arregloOpc={  
               Nod:'SI',
               Nodtx:'SI',
               Cintu:'NO',
               Cintutx:'NO',
               Bolsa:'NO',
               Bolsatx:'NO',
               Ropa:'NO',
               Ropatx:'NO',
               Casco:'NO',
               Cascotx:'NO',
               Rodi:'NO',
               Roditx:'NO',
               Code:'NO',
               Codetx:'NO',
               Costi:'NO',
               Costitx:'NO',
               Nodi:'NO',
               Noditx:'NO',
               Volc:'NO',
               Volctx:'NO',
               Alca:'NO',
               Alcatx:'NO',
               Late:'NO',
               Latetx:'NO',
               Fron:'NO',
               Frontx:'NO',
               Derr:'NO',
               Derrtx:'NO',
               Simp:'NO',
               Simptx:'NO',
               Imap:'NO',
               Imaptx:'NO',
               Caid:'NO',
               Caidtx:'NO',
               Lesdep:'NO',
               Lesdeptx:'NO',
               Lestra:'NO',
               Lestratx:'NO',
               ManSub:'NO',
               ManSubtx:'NO',
               Otr:'NO',
               Otrtx:'NO'
              }   
        $scope.embarazo={
            controlGine:'No',
            semanas:0,
            dolor:'No',
            desc:'',
            fcFet:'',
            movFet:'No',
            justif:''

        }
        $scope.lesion={
          lesion:''
        }
        $scope.edoGral={
          estado:''
        }
        $scope.estudios={
          rx:'',
          obs:'',
          interp:''
        }
        $scope.procedimientos={
          procedimiento:'',
          obs:''
        }
        $scope.diagnostico={
          diagnostico:'',
          obs:''
        }
        $scope.medica={
          medica:'',
          posologia:'',
          cantidad:1
        }
        $scope.ortesis={
          ortesis:'',
          presentacion:'',
          cantidad:1,
          indicaciones:''
        }
        $scope.indicacion={
          indicacion:'',
          obs:''
        }
        $scope.pronostico={
          pronostico:'',
          criterio:''
        }
        $scope.vital={
          clave:'',
          
        }
        busquedas.validaSigVitales($rootScope.folio).success(function(data){                                          
          if(data.noRowVit==1){
            $scope.regresar=true;
            WizardHandler.wizard().goTo(1); 
          }
          if(data.noRowVit>1){               
            $scope.verVitales=true;
             busquedas.listaVitales($rootScope.folio).success(function(data){
              $scope.vital.clave=data[0].Vit_clave;
            $scope.listVitales=data;                          
            $rootScope.cargador=false;
          });  
          }
          if(data.noRowVit==0||data.noRowVit==null){
            $scope.irVitales=true;
          }                        
        });
        busquedas.listaPacLlega($rootScope.folio).success(function(data){                      
          $scope.listPacLLega=data;                   
        });
        busquedas.listaTipVehi($rootScope.folio).success(function(data){                      
          $scope.listTipVehi=data;                             
        });
        $scope.selectVital = function() {            
            $rootScope.vitSelect=$scope.vital.clave;          
            $scope.regresar=true;
            WizardHandler.wizard().next();  
        }              
        $scope.regresaWizard = function() {           
            WizardHandler.wizard().previous();
            if($scope.paso=='Lesion'){
              if($scope.sexo=='M'){
                WizardHandler.wizard().goTo('Datos Acc.');
              }
            }
        }

         $scope.finished = function() {
            alert("Wizard finished :)");
        }

        $scope.logStep = function() {
            //console.log("Step continued");
        }

        $scope.goBack = function() {
            WizardHandler.wizard().goTo(0);
        }
        
        $scope.selectPosicion = function(){          
          
            $http({
            url:'api/api.php?funcion=selectPosicion&opcion='+$scope.accidente.vehiculo,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: {1:'valor'}
            }).success( function (data){
              console.log(data);                        
              $scope.posicion=data;
              $rootScope.arregloOpc=verOpciones($scope.accidente.vehiculo);
              console.log($rootScope.arregloOpc);           
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });    
        }
         $scope.guardaDatAcc = function(){         
          $http({
            url:'api/api.php?funcion=guardaDatAcc&fol='+$rootScope.folio+'&usr='+$rootScope.usrLogin,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: $scope.accidente
            }).success( function (data){                        
              if(data.respuesta=='correcto'){
                $scope.sexo=data.sexo;
                if(data.sexo=='F'){                	
                	 WizardHandler.wizard().next();	
                   busquedas.listaEmbarazo($rootScope.folio).success(function(data){                      
                      $scope.listEmbarazo=data;                                           
                    }); 
                }
                else{
                   busquedas.listaLesion().success(function(data){                      
                      $scope.listLesion=data;                       
                    }); 
                	 WizardHandler.wizard().goTo(3);
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
        $scope.guardaEmbarazo = function(){          
          $http({
            url:'api/api.php?funcion=guardaEmbarazo&fol='+$rootScope.folio+'&usr='+$rootScope.usrLogin,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: $scope.embarazo
            }).success( function (data){                        
              if(data.respuesta=='correcto'){
                busquedas.listaEmbarazo($rootScope.folio).success(function(data){                      
                  $scope.listEmbarazo=data;                                 
                }); 
              }
              if(data.respuesta=='lleno'){
                $scope.mensaje=true;
              }
              else{               
                alert('error en la inserción');
              }             
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });           
        }
      
        $scope.lesionSig = function(){
          busquedas.listaLesion().success(function(data){                      
            $scope.listLesion=data;                                 
          }); 
           busquedas.listaLesiones($rootScope.folio).success(function(data){                      
            $scope.listLesiones=data;                                   
          }); 

          WizardHandler.wizard().next(); 
        }

        $scope.validaLista = function(){
          if($scope.lesion.lesion==''){
            $scope.mensajeLesion=true;
          }else{
            $scope.mensajeLesion=false;
          }
          
        }
         $scope.guardaLesion = function(cuerpo){          
          $scope.lesion.cuerpo=cuerpo;
          $scope.cargador=true;
          if($scope.lesion.lesion==''|| $scope.lesion.lesion==null){
            $scope.mensajeLesion=true;
             $scope.cargador=false; 
          }else{
            $http({
            url:'api/api.php?funcion=guardaLesion&fol='+$rootScope.folio,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: $scope.lesion
            }).success( function (data){                        
              if(data.respuesta=='correcto'){
                $scope.lesion.lesion='';
                busquedas.listaLesiones($rootScope.folio).success(function(data){                      
                $scope.listLesiones=data;               
                $scope.cargador=false;                         
                });  
              }              
              else{               
                alert('error en la inserción');
                $scope.cargador.false;   
              }            
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
                $scope.cargador.false;   
            });           
          }         
        }

         $scope.eliminarLes = function(claveLesion){ 
            $scope.cargador.true;                   
            $http({
            url:'api/api.php?funcion=eliminaLesion&fol='+$rootScope.folio+'&cveLes='+claveLesion,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: {cve:'valor'}
            }).success( function (data){                        
              if(data.respuesta=='correcto'){
                $scope.lesion.lesion='';
                busquedas.listaLesiones($rootScope.folio).success(function(data){                      
                $scope.listLesiones=data;                 
                $scope.cargador.false;                         
                });  
              }              
              else{                
                alert('error en la inserción');
                $scope.cargador.false;   
              }              
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
                $scope.cargador.false;   
            });                               
        }
        $scope.siguienteEdoGral= function(){
          WizardHandler.wizard().next();             
        }
        $scope.guardaEdoGral= function(){          
          $http({
            url:'api/api.php?funcion=guardaEdoGral&fol='+$rootScope.folio,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: $scope.edoGral
            }).success( function (data){                        
              if(data.respuesta=='correcto'){ 
                busquedas.listaRX().success(function(data){                      
                  $scope.listRX=data;                                         
                });
                busquedas.listaEstSol($rootScope.folio).success(function(data){                      
                  $scope.listEstSoli=data;                 
                });                                  
                WizardHandler.wizard().next();                                        
              }              
              else{                
                alert('error en la inserción');
              }              
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });                        
        }
        $scope.guardaEstudios= function(){          
          $http({
            url:'api/api.php?funcion=guardaEstudios&fol='+$rootScope.folio+'&usr='+$rootScope.usrLogin+'&uniClave='+$rootScope.uniClave,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: $scope.estudios
            }).success( function (data){                        
              if(data.respuesta=='correcto'){ 
                $scope.estudios={
                  rx:'',
                  obs:'',
                  interp:''
                }
                busquedas.listaEstSol($rootScope.folio).success(function(data){                      
                  $scope.listEstSoli=data;                 
                });                                                                              
              }              
              else{                
                alert('error en la inserción');
              }              
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });                        
        }
         $scope.eliminarEstRealizado = function(claveEst){                    
            $http({
            url:'api/api.php?funcion=eliminaEstRealizado&fol='+$rootScope.folio+'&cveEst='+claveEst,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: {cve:'valor'}
            }).success( function (data){                        
              if(data.respuesta=='correcto'){               
                 busquedas.listaEstSol($rootScope.folio).success(function(data){                      
                  $scope.listEstSoli=data;                 
                });  
              }              
              else{                
                alert('error en la inserción');
              }              
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });                               
        }
        $scope.proMedSig = function(){
            busquedas.listaProced().success(function(data){                      
              $scope.listaProced=data;             
            });  
            busquedas.listaProcedimientos($rootScope.folio).success(function(data){                      
              $scope.listaProcedimientos=data;             
            });       
            WizardHandler.wizard().next();  
        }
        $scope.guardaProcMedicos= function(){          
          $http({
            url:'api/api.php?funcion=guardaProcedimientos&fol='+$rootScope.folio,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: $scope.procedimientos
            }).success( function (data){                        
              if(data.respuesta=='correcto'){ 
                $scope.procedimientos={
                  procedimiento:'',
                  obs:''
                }
                busquedas.listaProcedimientos($rootScope.folio).success(function(data){                      
                  $scope.listaProcedimientos=data;                   
                });                                                        
              }              
              else{                
                alert('error en la inserción');
              }              
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });                      
        }
        $scope.eliminarProcedimiento = function(clavePro){                    
            $http({
            url:'api/api.php?funcion=eliminaProcedimiento&proClave='+clavePro,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: {cve:'valor'}
            }).success( function (data){                        
              if(data.respuesta=='correcto'){               
                busquedas.listaProcedimientos($rootScope.folio).success(function(data){                      
                  $scope.listaProcedimientos=data;                   
                }); 
              }              
              else{                
                alert('error en la inserción');
              }              
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });                               
        }
        $scope.diagnosticoSig = function(){
            busquedas.listaDiagnosticos().success(function(data){                      
              $scope.listaDiagnostico=data;             
            });                  
            WizardHandler.wizard().next();  
        }
        $scope.despliegaDiagnosticos = function(diagnostic){
            busquedas.despDiagnosticos(diagnostic).success(function(data){                      
              $scope.listaDiagnostics=data;             
            });                              
        }
        $scope.agregaDiagnostico = function(diag){            
            if($scope.diagnostico.diagnostico==''){
              $scope.diagnostico.diagnostico=diag;
            }else{
              $scope.diagnostico.diagnostico=$scope.diagnostico.diagnostico+' // '+diag;
            }
            $scope.diagnostico.diagnostico = $scope.diagnostico.diagnostico 
        }
         $scope.guardaDiagnostico = function(diag){            
            $http({
            url:'api/api.php?funcion=guardaDiagnostico&fol='+$rootScope.folio,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: $scope.diagnostico
            }).success( function (data){                        
              if(data.respuesta=='correcto'){                
                  busquedas.listaMedicamentos().success(function(data){                      
                    $scope.listaMedicamento=data;                     
                  });
                  busquedas.listaOrtesis().success(function(data){                      
                    $scope.listaOrt=data;                     
                  });
                  busquedas.listaIndicaciones().success(function(data){                      
                    $scope.listaIndicacion=data;                     
                  });  
                  busquedas.listaMedicamentosAgreg($rootScope.folio).success(function(data){                      
                    $scope.listaMedicamentosAgreg=data;                     
                  }); 
                  busquedas.listaOrtesisAgreg($rootScope.folio).success(function(data){                      
                    $scope.listaOrtesisAgreg=data;                     
                  });  
                  busquedas.listaIndicAgreg($rootScope.folio).success(function(data){                      
                    $scope.listaIndicAgreg=data;                     
                  });      
                  WizardHandler.wizard().next();                                                               
              }              
              else{                
                alert('error en la inserción');
              }              
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });      
        }
        $scope.verIndicacion = function(){            
            busquedas.verPosologia($scope.medica.medica).success(function(data){                      
                    $scope.medica.posologia=data.Sum_indicacion;                                         
                  }); 
        }  
        $scope.verIndicacionCam = function(){            
            if($scope.indicacion.obs=='' || $scope.indicacion.obs==null){
              $scope.indicacion.obs=$scope.indicacion.indicacion;
            }else{
              $scope.indicacion.obs=$scope.indicacion.obs+', '+$scope.indicacion.indicacion;
            }
        }  
        $scope.guardaMedicamento= function(){          
          $http({
            url:'api/api.php?funcion=guardaMedicamentoSub&fol='+$rootScope.folio,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: $scope.medica
            }).success( function (data){                        
              if(data.respuesta=='correcto'){ 
                 $scope.medica={
                    medica:'',
                    posologia:'',
                    cantidad:1
                  }            
                busquedas.listaMedicamentosAgregSub($rootScope.folio).success(function(data){                      
                  $scope.listaMedicamentosAgregSub=data;                   
                });                                                        
              }              
              else{                
                alert('error en la inserción');
              }              
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });                      
        } 
        $scope.eliminarMedicamento = function(clavePro){                    
            $http({
            url:'api/api.php?funcion=eliminaMedicamentoSub&proClave='+clavePro,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: {cve:'valor'}
            }).success( function (data){                        
              if(data.respuesta=='correcto'){               
                 busquedas.listaMedicamentosAgreg($rootScope.folio).success(function(data){                      
                  $scope.listaMedicamentosAgreg=data;                   
                }); 
              }              
              else{                
                alert('error en la inserción');
              }              
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });                               
        }        
        $scope.guardaOrtesis= function(){          
          $http({
            url:'api/api.php?funcion=guardaOrtesis&fol='+$rootScope.folio,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: $scope.ortesis
            }).success( function (data){                        
              if(data.respuesta=='correcto'){ 
                $scope.ortesis={
                  ortesis:'',
                  presentacion:'',
                  cantidad:1,
                  indicaciones:''
                }             
                busquedas.listaOrtesisAgreg($rootScope.folio).success(function(data){                      
                  $scope.listaOrtesisAgreg=data;                   
                });                                                        
              }              
              else{                
                alert('error en la inserción');
              }              
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });                      
        }   
        $scope.eliminarOrtesis = function(clavePro){                    
            $http({
            url:'api/api.php?funcion=eliminarOrtesis&proClave='+clavePro,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: {cve:'valor'}
            }).success( function (data){                        
              if(data.respuesta=='correcto'){               
               busquedas.listaOrtesisAgreg($rootScope.folio).success(function(data){                      
                  $scope.listaOrtesisAgreg=data;                   
                });    
              }              
              else{                
                alert('error en la inserción');
              }              
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });                               
        }           
        $scope.guardaIndicaciones= function(){          
          $http({
            url:'api/api.php?funcion=guardaIndicacion&fol='+$rootScope.folio,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: $scope.indicacion
            }).success( function (data){                        
              if(data.respuesta=='correcto'){ 
                $scope.indicacion={
                  indicacion:'',
                  obs:''
                }           
                busquedas.listaIndicAgreg($rootScope.folio).success(function(data){                      
                  $scope.listaIndicAgreg=data;                   
                });                                                        
              }              
              else{                
                alert('error en la inserción');
              }              
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });                      
        } 
        $scope.eliminarIndicacion = function(clavePro){                    
            $http({
            url:'api/api.php?funcion=eliminarIndicacion&proClave='+clavePro,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: {cve:'valor'}
            }).success( function (data){                        
              if(data.respuesta=='correcto'){               
                busquedas.listaIndicAgreg($rootScope.folio).success(function(data){                      
                  $scope.listaIndicAgreg=data;                   
                });
              }              
              else{                
                alert('error en la inserción');
              }              
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });                               
        }           
        $scope.pronosSiguiente = function(){                            
            WizardHandler.wizard().next();  
        }        
        $scope.guardaPronostico= function(){          
          $http({
            url:'api/api.php?funcion=guardaPronostico&fol='+$rootScope.folio,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: $scope.pronostico
            }).success( function (data){                        
              if(data.respuesta=='correcto'){ 
                     WizardHandler.wizard().next();                                                   
              }              
              else{                
                alert('error en la inserción');
              }              
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });                      
        } 
        $scope.imprimirNota = function(){          
            var fileName = "Reporte";
            var uri = 'api/classes/formatoNota.php?fol='+$rootScope.folio+'&vit='+$rootScope.vitSelect;
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
        $scope.imprimirReceta = function(){          
            var fileName = "Reporte";
            var uri = 'api/classes/formatoReceta.php?fol='+$rootScope.folio+'&usr='+$rootScope.usrLogin;
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
               
});




function verOpciones(opcion){
  switch(opcion){
    case '0':
            validos={Nod:'SI',
               Nodtx:'SI',
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
               Nodi:'SI',
               Noditx:'SI',
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
               Cintu:'SI',
               Cintutx:'SI',
               Bolsa:'SI',
               Bolsatx:'SI',
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
               Volc:'SI',
               Volctx:'SI',
               Alca:'SI',
               Alcatx:'SI',
               Late:'SI',
               Latetx:'SI',
               Fron:'SI',
               Frontx:'SI',
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
               ManSub:'SI',
               ManSubtx:'SI',
               Otr:'SI',
               Otrtx:'SI'
              }
    break; 
     case '2':
            validos={Nod:'',
               Nodtx:'',
               Cintu:'',
               Cintutx:'',
               Bolsa:'',
               Bolsatx:'',
               Ropa:'SI',
               Ropatx:'SI',
               Casco:'SI',
               Cascotx:'SI',
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
               Alca:'SI',
               Alcatx:'SI',
               Late:'SI',
               Latetx:'SI',
               Fron:'SI',
               Frontx:'SI',
               Derr:'SI',
               Derrtx:'SI',
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
            validos={Nod:'SI',
               Nodtx:'SI',
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
               Caid:'SI',
               Caidtx:'SI',
               Lesdep:'SI',
               Lesdeptx:'SI',
               Lestra:'SI',
               Lestratx:'SI',
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
               Casco:'SI',
               Cascotx:'SI',
               Rodi:'SI',
               Roditx:'SI',
               Code:'SI',
               Codetx:'SI',
               Costi:'SI',
               Costitx:'SI',
               Nodi:'',
               Noditx:'',
               Volc:'',
               Volctx:'',
               Alca:'SI',
               Alcatx:'SI',
               Late:'SI',
               Latetx:'SI',
               Fron:'SI',
               Frontx:'SI',
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
            validos={Nod:'SI',
               Nodtx:'SI',
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
               Simp:'SI',
               Simptx:'SI',
               Imap:'SI',
               Imaptx:'SI',
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
            validos={Nod:'SI',
               Nodtx:'SI',
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
               Volc:'SI',
               Volctx:'SI',
               Alca:'SI',
               Alcatx:'SI',
               Late:'SI',
               Latetx:'SI',
               Fron:'SI',
               Frontx:'SI',
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
               ManSub:'SI',
               ManSubtx:'SI',
               Otr:'SI',
               Otrtx:'SI'
              }
    break; 
     case '7':
            validos={Nod:'SI',
               Nodtx:'SI',
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
               Nodi:'SI',
               Noditx:'SI',
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
            validos={Nod:'SI',
               Nodtx:'SI',
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
               Nodi:'SI',
               Noditx:'SI',
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