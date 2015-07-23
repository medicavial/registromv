app.controller('rehabilitacionFormCtrl', function($scope,$rootScope,$location,$cookies,WizardHandler,busquedas,$http) {
	$rootScope.folio=$cookies.folio;	
  $rootScope.usrLogin= $cookies.usrLogin;
  $rootScope.uniClave=$cookies.uniClave;
  $scope.cargador=true;
  $scope.cargador1=false;
  $scope.cargador2=false;
  $scope.formularios={};
  $scope.validaEx=false;
  $scope.validaPase=false;
  $scope.formu=true;
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
  $scope.acc={
       fecSin:'',
       fecAtn:'',
       med:'',
       diag:''
  };
  $scope.exp={

  }
  $scope.formReah={
      noSes:'',
      obs:'',
      diag:''
  }
  $scope.datosPase={
      medic:'',
      fech:'',
      noSes:'',
      obs:'',
      diag:''
  }
  $scope.rehabilitacionForm={
      tipo:'',
      escala:'',
      mejoria:'',
      criterios:'',
      observa:'',
      duracion:'',
      acudio:''
  }
  $scope.nota=false;
  $scope.noR='';
  
  $scope.interacted = function(field) {          
    return $scope.formularios.rehabForm.$submitted && field.$invalid;          
  };
  $scope.interacted1 = function(field) {          
    return $scope.formularios.estudiosSub.$submitted && field.$invalid;          
  };

  busquedas.datosPacienteRe($rootScope.folio).success(function(data){
    $scope.cargador=false;      
      $rootScope.nombre= data.Exp_nombre + ' '+data.Exp_paterno+ ' ' + data.Exp_materno;
      $scope.datos.cia=data.Cia_nombrecorto;
      $scope.datos.sin=data.Exp_siniestro;
      $scope.datos.pol=data.Exp_poliza;
      $scope.datos.rep=data.Exp_reporte;
      $scope.datos.fecnac= data.Exp_fechaNac;            
      $scope.datos.mail=data.Exp_mail;
      $scope.datos.obs=data.Rel_clave;
      $scope.datos.tel=data.Exp_telefono;
      $scope.datos.ocu = data.Ocu_clave;
      $scope.datos.edoC= data.Edo_clave;
      $scope.datos.sexo= data.Exp_sexo;

      
      $scope.datos.folio= $rootScope.folio;      
      
  }); 
  busquedas.rehabNum($rootScope.folio).success(function(data){    
        if(!data.respuesta){
            $scope.formu=false;
           $scope.noR=data.rehab;
        }                                           
    });

  busquedas.validaPaseMed($rootScope.folio).success(function(data){      
        if(!data.respuesta){
           $scope.formReah={
                noSes:parseInt(data.RPase_rehabilitacion),
                obs:data.RPase_obs,
                diag:data.RPase_diagnostico
          }
        }                                           
    });

  $scope.verDatosAcc = function(){          
          //console.log($scope.datos1);
            
            
            if($scope.acc.fecSin==''){
              $scope.cargador=true;
              $http({
                      url:'api/api.php?funcion=datosAcc&folio='+$rootScope.folio,
                      method:'POST', 
                      contentType: 'application/json', 
                      dataType: "json", 
                      data: $scope.datos1
                      }).success( function (data){ 
                        console.log(data);                       
                        $scope.acc.fecSin=data.Not_fechaAcc;
                        $scope.acc.fecAtn=data.Not_fechareg;
                        $scope.acc.doc=data.Med_nombre;
                        $scope.acc.diag=data.ObsNot_diagnosticoRx;
                        $scope.cargador=false;
                      }).error( function (xhr,status,data){
                          $scope.mensaje ='no entra';            
                          alert('Error');
                      });
              }
        }  

  $scope.verExpdiente = function(){                                            
            //if($scope.acc.fecSin==''){
              if(!$scope.validaEx){
              $scope.cargador=true;
              $http({
                    url:'api/api.php?funcion=datosExp&folio='+$rootScope.folio,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: $scope.datos1
                    }).success( function (data){ 
                      console.log(data);                       
                      if(data.nota=='SI'){
                        $scope.nota=true;
                      }
                      $scope.subsec=data.Subs;
                      $scope.cargador=false;
                      $scope.validaEx=true;
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
                  }
              //}
        }
   $scope.VerDatosPase = function(){                                            
             if(!$scope.validaPase){
              $scope.cargador=true;
              $http({
                    url:'api/api.php?funcion=verDatosPase&fol='+$rootScope.folio,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: $scope.datos1
                    }).success( function (data){ 
                                           
                      if(!data.respuesta){
                        $scope.datosPase={
                            medic:data.Med_nombre+' '+data.Med_materno+' '+data.Med_materno,
                            fech:data.RPase_fecha,
                            noSes:data.RPase_rehabilitacion,
                            obs:data.RPase_obs,
                            diag:data.RPase_diagnostico
                        }                      
                      }else{
                        alert('Error en la consulta');
                      }
                      $scope.subsec=data.Subs;
                      $scope.cargador=false;
                      $scope.validaEx=true;
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
                  }
    }
   

  $scope.guardaRehabilitacion = function(){                                                      
           if($scope.formularios.rehabForm.$valid){    
              $scope.cargador1=true; 
              
              $http({
                    url:'api/api.php?funcion=guardaRehabilitacion&fol='+$rootScope.folio+'&usr='+$rootScope.usrLogin+'&uni='+$rootScope.uniClave,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: $scope.rehabilitacionForm
                    }).success( function (data){ 
                      $scope.formu=true;                                            
                      if(data.respuesta=='SI'){
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
                        $scope.cargador1=false;
                        $location.path("/documentos"); 
                      }else{
                        alert('Error en la insersión');
                      }
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
              }
        }  
  

  
  
  $scope.irDocumentos = function(){         
        $location.path("/documentos");          
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
  $scope.imprimirSub = function(){          
    $scope.cargador=true;          
      var fileName = "Reporte";
      var uri = 'api/classes/formatoSub.php?fol='+$rootScope.folio+'&usr='+$rootScope.usrLogin;
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


});




