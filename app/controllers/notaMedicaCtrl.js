app.controller('notaMedicaCtrl', function($scope,$rootScope,$location,$cookies,WizardHandler,busquedas,$http) {
	$rootScope.folio=$cookies.folio;	
  $rootScope.usrLogin= $cookies.usrLogin;
  $rootScope.uniClave=$cookies.uniClave;
   $scope.mensaje=false;
   $scope.mensajeLesion=false;
   $scope.irVitales=false;
   $scope.verVitales=false;
  $scope.cargador=false;
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
          console.log(data); 
          if(data.noRowVit==1){
            WizardHandler.wizard().goTo(1); 
          }
          if(data.noRowVit>1){               
            $scope.verVitales=true;
             busquedas.listaVitales($rootScope.folio).success(function(data){

              $scope.vital.clave=data[0].Vit_clave;
            $scope.listVitales=data;                
            console.log(data);
          });  
          }
          if(data.noRowVit==0||data.noRowVit==null){
            $scope.irVitales=true;
          }                        
        });
        busquedas.listaPacLlega($rootScope.folio).success(function(data){                      
          $scope.listPacLLega=data; 
          console.log($scope.listPacLLega);                         
        });
        busquedas.listaTipVehi($rootScope.folio).success(function(data){                      
          $scope.listTipVehi=data; 
          console.log($scope.listTipVehi);                         
        });
        $scope.selectVital = function() {            
            $rootScope.vitSelect=$scope.vital.clave;
            console.log($rootScope.vitSelect);
            WizardHandler.wizard().next();  
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
            data: {'clave':'valor'}
            }).success( function (data){                        
              $scope.posicion=data;
              $scope.arregloOpc=verOpciones($scope.accidente.vehiculo);
              console.log($scope.arregloOpc);
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });    
        }
         $scope.guardaDatAcc = function(){
          console.log($scope.accidente);
          $http({
            url:'api/api.php?funcion=guardaDatAcc&fol='+$rootScope.folio+'&usr='+$rootScope.usrLogin,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: $scope.accidente
            }).success( function (data){                        
              if(data.respuesta=='correcto'){
                if(data.sexo=='F'){                	
                	 WizardHandler.wizard().next();	
                   busquedas.listaEmbarazo($rootScope.folio).success(function(data){                      
                      $scope.listEmbarazo=data; 
                      console.log($scope.listEmbarazo);                         
                    }); 
                }
                else{
                   busquedas.listaLesion().success(function(data){                      
                      $scope.listLesion=data; 
                      console.log($scope.listLesion);                         
                    }); 
                	 WizardHandler.wizard().goTo(3);
                }
              }
              else{
                console.log(data);
                alert('error en la inserción');
              }
              console.log(data);
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            }); 
        }
        $scope.guardaEmbarazo = function(){
          console.log($scope.embarazo);
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
                  console.log($scope.listEmbarazo);                         
                }); 
              }
              if(data.respuesta=='lleno'){
                $scope.mensaje=true;
              }
              else{
                console.log(data);
                alert('error en la inserción');
              }
              console.log(data);
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });           
        }
      
        $scope.lesionSig = function(){
          busquedas.listaLesion().success(function(data){                      
            $scope.listLesion=data; 
            console.log($scope.listLesion);                         
          }); 
           busquedas.listaLesiones($rootScope.folio).success(function(data){                      
            $scope.listLesiones=data; 
            console.log($scope.listLesiones);                         
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
                console.log($scope.listLesiones);
                $scope.cargador=false;                         
                });  
              }              
              else{
                console.log(data);
                alert('error en la inserción');
                $scope.cargador.false;   
              }
              console.log(data);
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
                $scope.cargador.false;   
            });           
          }
          console.log( $scope.lesion);
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
                console.log($scope.listLesiones);
                $scope.cargador.false;                         
                });  
              }              
              else{
                console.log(data);
                alert('error en la inserción');
                $scope.cargador.false;   
              }
              console.log(data);
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
                $scope.cargador.false;   
            });                     
          console.log( $scope.lesion);
        }
        $scope.siguienteEdoGral= function(){
          WizardHandler.wizard().next();             
        }
        $scope.guardaEdoGral= function(){
          console.log($scope.edoGral);
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
                console.log($scope.listRX);                         
                });
                busquedas.listaEstSol($rootScope.folio).success(function(data){                      
                  $scope.listEstSoli=data; 
                console.log($scope.listEstSoli);                         
                });                                  
                WizardHandler.wizard().next();                                        
              }              
              else{
                console.log(data);
                alert('error en la inserción');
              }
              console.log(data);
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });                        
        }
        $scope.guardaEstudios= function(){
          console.log($scope.estudios);
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
                console.log($scope.listEstSoli);                         
                });                                                                              
              }              
              else{
                console.log(data);
                alert('error en la inserción');
              }
              console.log(data);
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
                console.log($scope.listEstSoli);                         
                });  
              }              
              else{
                console.log(data);
                alert('error en la inserción');
              }
              console.log(data);
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });                     
          console.log( $scope.lesion);
        }
        $scope.proMedSig = function(){
            busquedas.listaProced().success(function(data){                      
              $scope.listaProced=data; 
            console.log($scope.listaProced);                         
            });  
            busquedas.listaProcedimientos($rootScope.folio).success(function(data){                      
              $scope.listaProcedimientos=data; 
            console.log($scope.listaProced);
            });       
            WizardHandler.wizard().next();  
        }
        $scope.guardaProcMedicos= function(){
          console.log($scope.procedimientos);
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
                  console.log($scope.listaProced);
                });                                                        
              }              
              else{
                console.log(data);
                alert('error en la inserción');
              }
              console.log(data);
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
                  console.log($scope.listaProced);
                }); 
              }              
              else{
                console.log(data);
                alert('error en la inserción');
              }
              console.log(data);
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });                     
          console.log( $scope.lesion);
        }
        $scope.diagnosticoSig = function(){
            busquedas.listaDiagnosticos().success(function(data){                      
              $scope.listaDiagnostico=data; 
            console.log($scope.listaDiagnostico);                         
            });                  
            WizardHandler.wizard().next();  
        }
        $scope.agregaDiagnostico = function(diag){
            console.log(diag);
            if($scope.diagnostico.diagnostico==''){
              $scope.diagnostico.diagnostico=diag;
            }else{
              $scope.diagnostico.diagnostico=$scope.diagnostico.diagnostico+' // '+diag;
            }
            $scope.diagnostico.diagnostico = $scope.diagnostico.diagnostico 
        }
         $scope.guardaDiagnostico = function(diag){
            console.log(diag);
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
                    console.log($scope.listaMedicamento);                         
                  });
                  busquedas.listaOrtesis().success(function(data){                      
                    $scope.listaOrt=data; 
                    console.log($scope.listaOrt);                         
                  });
                  busquedas.listaIndicaciones().success(function(data){                      
                    $scope.listaIndicacion=data; 
                    console.log($scope.listaIndicacion);                         
                  });  
                  busquedas.listaMedicamentosAgreg($rootScope.folio).success(function(data){                      
                    $scope.listaMedicamentosAgreg=data; 
                    console.log($scope.listaMedicamentosAgreg);
                  }); 
                  busquedas.listaOrtesisAgreg($rootScope.folio).success(function(data){                      
                    $scope.listaOrtesisAgreg=data; 
                    console.log($scope.listaOrtesisAgreg);
                  });  
                  busquedas.listaIndicAgreg($rootScope.folio).success(function(data){                      
                    $scope.listaIndicAgreg=data; 
                    console.log($scope.listaIndicAgreg);
                  });      
                  WizardHandler.wizard().next();                                                               
              }              
              else{
                console.log(data);
                alert('error en la inserción');
              }
              console.log(data);
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });      
        }
        $scope.verIndicacion = function(){
            console.log($scope.medica.medica);
            busquedas.verPosologia($scope.medica.medica).success(function(data){                      
                    $scope.medica.posologia=data.Sum_indicacion; 
                    console.log(data);                         
                  }); 
        }  
        $scope.verIndicacionCam = function(){
            console.log($scope.indicacion.indicacion);
            if($scope.indicacion.obs=='' || $scope.indicacion.obs==null){
              $scope.indicacion.obs=$scope.indicacion.indicacion;
            }else{
              $scope.indicacion.obs=$scope.indicacion.obs+', '+$scope.indicacion.indicacion;
            }
        }  
        $scope.guardaMedicamento= function(){
          console.log($scope.medicamentos);
          $http({
            url:'api/api.php?funcion=guardaMedicamento&fol='+$rootScope.folio,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: $scope.medica
            }).success( function (data){                        
              if(data.respuesta=='correcto'){ 
                $scope.indicacion={
                  indicacion:'',
                  obs:''
                }             
                busquedas.listaMedicamentosAgreg($rootScope.folio).success(function(data){                      
                  $scope.listaMedicamentosAgreg=data; 
                  console.log($scope.listaMedicamentosAgreg);
                });                                                        
              }              
              else{
                console.log(data);
                alert('error en la inserción');
              }
              console.log(data);
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });                      
        } 
        $scope.eliminarMedicamento = function(clavePro){                    
            $http({
            url:'api/api.php?funcion=eliminaMedicamento&proClave='+clavePro,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: {cve:'valor'}
            }).success( function (data){                        
              if(data.respuesta=='correcto'){               
                 busquedas.listaMedicamentosAgreg($rootScope.folio).success(function(data){                      
                  $scope.listaMedicamentosAgreg=data; 
                  console.log($scope.listaMedicamentosAgreg);
                }); 
              }              
              else{
                console.log(data);
                alert('error en la inserción');
              }
              console.log(data);
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });                     
          console.log( $scope.lesion);
        }        
        $scope.guardaOrtesis= function(){
          console.log($scope.ortesis);
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
                  console.log($scope.listaOrtesisAgreg);
                });                                                        
              }              
              else{
                console.log(data);
                alert('error en la inserción');
              }
              console.log(data);
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
                  console.log($scope.listaOrtesisAgreg);
                });    
              }              
              else{
                console.log(data);
                alert('error en la inserción');
              }
              console.log(data);
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });                     
          console.log( $scope.lesion);
        }           
        $scope.guardaIndicaciones= function(){
          console.log($scope.indicacion);
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
                  console.log($scope.listaIndicAgreg);
                });                                                        
              }              
              else{
                console.log(data);
                alert('error en la inserción');
              }
              console.log(data);
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
                  console.log($scope.listaIndicAgreg);
                });
              }              
              else{
                console.log(data);
                alert('error en la inserción');
              }
              console.log(data);
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });                     
          console.log( $scope.lesion);
        }           
        $scope.pronosSiguiente = function(){                            
            WizardHandler.wizard().next();  
        }        
        $scope.guardaPronostico= function(){
          console.log($scope.indicacion);
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
                console.log(data);
                alert('error en la inserción');
              }
              console.log(data);
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
               
});




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