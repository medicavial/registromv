//inicializamos la aplicacion
var app = angular.module('app', ['ui.bootstrap', 'ngCookies','ngRoute','ngAnimate' ,'mgo-angular-wizard','angularFileUpload','akoenig.deckgrid','ngDialog','ngIdle','datatables']);

//configuramos nuestra aplicacion
app.config(function($routeProvider,$idleProvider, $keepaliveProvider){

    //Configuramos la ruta que queremos el html que le toca y que controlador usara
    
    // menu y login general
     $routeProvider.when('/bloqueo',{
            templateUrl: 'views/bloqueo.html',
            controller : 'bloqueoCtrl'
    });

    $routeProvider.when('/home',{
            templateUrl: 'views/home.html',
            controller : 'homeCtrl'
    });

    $routeProvider.when('/login',{
            templateUrl: 'views/login.html',
            controller : 'loginCtrl'
    });

    $routeProvider.when('/material',{
            templateUrl: 'views/material.html',
            controller : 'materialCtrl'
    });

   

    // apertura de un expediente y seguimiento
    $routeProvider.when('/aperturaExp',{
            templateUrl: 'views/aperturaExp.html',
            controller : 'aperturaExpCtrl'
    });
    $routeProvider.when('/producto',{
            templateUrl: 'views/producto.html',
            controller : 'productoCtrl'
    });
    $routeProvider.when('/registra',{
            templateUrl: 'views/registra.html',
            controller : 'registraCtrl'           
    });
    $routeProvider.when('/portada',{
            templateUrl: 'views/portada.html',
            controller : 'portadaCtrl'           
    });
    $routeProvider.when('/busqueda',{
            templateUrl: 'views/busqueda.html',
            controller : 'busquedaCtrl'           
    });
    $routeProvider.when('/busqueda/unidad',{
            templateUrl: 'views/busquedaUni.html',
            controller : 'busquedaUniCtrl'           
    });
    $routeProvider.when('/documentos',{
            templateUrl: 'views/documentos.html',
            controller : 'documentosCtrl'           
    });
    $routeProvider.when('/historiaClinica',{
            templateUrl: 'views/historiaClinica.html',
            controller : 'historiaClinicaCtrl'           
    });
    
    $routeProvider.when('/signosVitales',{
            templateUrl: 'views/signosVitales.html',
            controller : 'signosVitalesCtrl'           
    });

    $routeProvider.when('/notaMedica',{
            templateUrl: 'views/notaMedica.html',
            controller : 'notaMedicaCtrl'           
    });
    $routeProvider.when('/subsecuencia',{
            templateUrl: 'views/subsecuencia.html',
            controller : 'subsecuenciaCtrl'           
    });

    // apartado de solicitudes 
    $routeProvider.when('/detalle/solicitud/:clave',{
            templateUrl: 'views/solicitudes/detalleSolicitud.html',
            controller : 'detalleSolicitudCtrl'
    });

    $routeProvider.when('/solicitudes',{
            templateUrl: 'views/solicitudes/solicitudes.html',
            controller : 'solicitudesCtrl'
    });

    $routeProvider.when('/solicitud',{
            templateUrl: 'views/solicitudes/solicitud.html',
            controller : 'solicitudCtrl'
    });

    $routeProvider.when('/solicitud/:folio',{
            templateUrl: 'views/solicitudes/solicitudexpediente.html',
            controller : 'solicitudExpedienteCtrl'
    });

    $routeProvider.when('/solicitudmasinfo/:clave',{
            templateUrl: 'views/solicitudes/solicitudmasinfo.html',
            controller : 'solicitudMasInfoCtrl'
    });


    $routeProvider.otherwise({redirectTo:'/login'});

    //$locationProvider.html5Mode(true);

    $idleProvider.idleDuration(900); // tiempo en activarse el modo en reposo 
    $idleProvider.warningDuration(10); // tiempo que dura la alerta de sesion cerrada
    $keepaliveProvider.interval(10); // 

});


//sirve para ejecutar cualquier cosa cuando inicia la aplicacion
app.run(function ($rootScope ,$cookies, $cookieStore, sesion, $location, $idle){

    
    $rootScope.admin = true;
    $rootScope.cerrar = false;
    console.log($cookies.permisos);
    console.log($rootScope.permisos);


    //verifica el tamaño de la pantalle y oculta o muestra el menu
    var mobileView = 992;

    $rootScope.getWidth = function() { return window.innerWidth; };

    $rootScope.$watch($rootScope.getWidth, function(newValue, oldValue)
    {
        if(newValue >= mobileView)
        {
            if(angular.isDefined($cookieStore.get('toggle')))
            {
                if($cookieStore.get('toggle') == false)
                    $rootScope.toggle = false;

                else
                    $rootScope.toggle = true;
            }
            else 
            {
                $rootScope.toggle = true;
            }
        }
        else
        {
            $rootScope.toggle = false;
        }

    });

    $rootScope.toggleSidebar = function() 
    {
        $rootScope.toggle = ! $rootScope.toggle;

        $cookieStore.put('toggle', $rootScope.toggle);
    };

    window.onresize = function() { $rootScope.$apply(); };


    //evento que verifica cuando alguien cambia de ruta
    $rootScope.$on('$routeChangeStart', function(){

        $rootScope.cerrar = false;
        $rootScope.username =  $cookies.username;
        $rootScope.cordinacion =  $cookies.cordinacion;
        if ($cookies.permisos  && $rootScope.permisos == undefined) {
            $rootScope.permisos = JSON.parse($cookies.permisos);
        };

        sesion.checkStatus();

    });


    //funcion en angular
    $rootScope.logout = function(){

        sesion.logout();
    } 

    //generamos al rootscope las variables que tenemos en las cookies para no perder la sesion 
    $rootScope.username =  $cookies.username;
    $rootScope.cordinacion =  $cookies.cordinacion;
    if ($cookies.permisos  && $rootScope.permisos == undefined) {
        $rootScope.permisos = JSON.parse($cookies.permisos);
    };

    


    //verificamos el estatus del usuario en la aplicacion
    $idle.watch();

    $rootScope.$on('$idleStart', function() {
        // the user appears to have gone idle  
        
        if($location.path() != "/login"){
            console.log('iniciando estado temporal'); 
        }                
    });

    $rootScope.$on('$idleWarn', function(e, countdown) {
        // follows after the $idleStart event, but includes a countdown until the user is considered timed out
        // the countdown arg is the number of seconds remaining until then.
        // you can change the title or display a warning dialog from here.
        // you can let them resume their session by calling $idle.watch()
        if($location.path() != "/login"){
            //console.log('Cuidado se va a bloquear');
        }
         
    });

    $rootScope.$on('$idleTimeout', function() {
       //Entra en el estado de reposo cerramos session guardamos la ultima ruta en la que se encontraba
       //ademas de verificar si no estaban en la pagina del login ni en la de bloqueo 
        if($location.path() != "/login" && $location.path() != "/solicitud" && $location.path() != '/notaMedica' && $location.path() != '/registra'){

            if ($location.path() != "/bloqueo") {

                $rootScope.ruta = $location.path(); //Guardamos 
                $location.path('/bloqueo');
            };
        
        }
        
    })

    $rootScope.$on('$idleEnd', function() {
        // the user has come back from AFK and is doing stuff. if you are warning them, you can use this to hide the dialog 
         
        if($location.path() != "/login"){
            //console.log('llegaste bienvenido');
        }
    });

    $rootScope.$on('$keepalive', function() {
        // do something to keep the user's session alive
        if($location.path() != "/login"){
            //console.log('Activo en el sitio'); 
        }
        
    });

});


//servicio que verifica sesiones de usuario
app.factory("sesion", function($cookies,$cookieStore,$location, $rootScope, $http)
{
    return{
        login : function(username, password)
        {   
            $http({
                url:'api/api.php?funcion=login',
                method:'POST', 
                contentType: 'application/json', 
                dataType: "json", 
                data:{user:username,psw:password}
            }).success( function (data){

                if (data.respuesta) {
                    $rootScope.mensaje = data.respuesta;
                }else{     
                    
                    $('html').removeClass('lockscreen');
                    $('#boton').button('reset');             
                    $rootScope.username = data[0].Usu_nombre;
                    $cookies.username = data[0].Usu_nombre;
                    $cookies.uniClave = data[0].Uni_clave;
                    $cookies.usrLogin = data[0].Usu_login;
                    $cookies.cordinacion = data[0].Cordinacion;

                    $http({
                        url:'api/api.php?funcion=permisos',
                        method:'POST', 
                        contentType: 'application/json', 
                        dataType: "json", 
                        data:{user:username}
                    }).success( function (data){
                        console.log(data);
                        $cookies.permisos=JSON.stringify(data); 
                        $rootScope.permisos=JSON.parse($cookies.permisos);                           
                    });

                    $location.path("/home");
                    //console.log(data);
                }
            });



        },
        logout : function()
        {
            //al hacer logout eliminamos la cookie con $cookieStore.remove y los rootscope
            $cookieStore.remove("username"),
            $rootScope.username =  '';
            $cookieStore.remove("permisos"),
            $rootScope.permisos =  '';

            //mandamos al login
            $location.path("/login");

        },
        checkStatus : function()
        {
            //verifica el estatus de la sesion al cambiar de ruta 
            //si manda alguna ruta direfente de login y no tiene sesion activa en cookies manda a login
            if($location.path() != "/login" && typeof($cookies.username) == "undefined")
            {   
                $location.path("/login");
            }
            //en el caso de que intente acceder al login y ya haya iniciado sesión lo mandamos a la home
            if($location.path() == "/login" && typeof($cookies.username) != "undefined")
            {
                $location.path("/home");
            }
        }
    }

});


app.factory("busquedas", function($http, $rootScope, $cookies){
    return{
        buscarFolio: function(folio){
            return $http.get('api/api.php?funcion=getFolio&folio='+folio);
        },
        listadoFolios: function(usuUni){            
            return $http.get('api/api.php?funcion=listadoFolios&uni='+usuUni);
        },
        datosPaciente: function(folio){            
            return $http.get('api/api.php?funcion=getDatosPaciente&folio='+folio);
        },
        ocupacion: function(){
            return $http.get('api/api.php?funcion=getOcupacion');
        },
        edoCivil: function(){
            return $http.get('api/api.php?funcion=getEdoCivil');
        },
        enfermedad: function(){
            return $http.get('api/api.php?funcion=getEnfermedad');
        },
        familiar: function(){
            return $http.get('api/api.php?funcion=getFamiliar');
        },
        estatusFam: function(){
            return $http.get('api/api.php?funcion=getEstatus');
        },
        listaEnfHeredo: function(folio){
            return $http.get('api/api.php?funcion=getListEnfHeredo&fol='+folio);
        },
        padecimientos: function(){
            return $http.get('api/api.php?funcion=getPadecimientos');
        },
        otrasEnf: function(){
            return $http.get('api/api.php?funcion=getOtrasEnf');
        },
        alergias: function(){
            return $http.get('api/api.php?funcion=getAlergias');
        },
        listaPadecimientos: function(folio){
            return $http.get('api/api.php?funcion=getListPadecimientos&fol='+folio);
        },
        listaOtrasEnf: function(folio){
            return $http.get('api/api.php?funcion=getListOtrasEnf&fol='+folio);
        },
        listaAlergias: function(folio){
            return $http.get('api/api.php?funcion=getListAlergias&fol='+folio);
        },
        listaPadEsp: function(folio){
            return $http.get('api/api.php?funcion=getListPadEsp&fol='+folio);
        },
        listaTratQuiro: function(folio){
            return $http.get('api/api.php?funcion=getListTratQuiro&fol='+folio);
        },
        listaPlantillas: function(folio){
            return $http.get('api/api.php?funcion=getListPlantillas&fol='+folio);
        },
        listaTratamientos: function(folio){
            return $http.get('api/api.php?funcion=getListTratamientos&fol='+folio);
        },
        listaIntervenciones: function(folio){
            return $http.get('api/api.php?funcion=getListIntervenciones&fol='+folio);
        },
        listaDeportes: function(folio){
            return $http.get('api/api.php?funcion=getListDeportes&fol='+folio);
        },
        listaAdicciones: function(folio){
            return $http.get('api/api.php?funcion=getListAdicciones&fol='+folio);
        },
        catLugar: function(folio){
            return $http.get('api/api.php?funcion=getCatLugar&fol='+folio);
        },
        listaAccAnteriores: function(folio){
            return $http.get('api/api.php?funcion=getListAccAnt&fol='+folio);
        },
        listaPacLlega: function(folio){
            return $http.get('api/api.php?funcion=getListPacLlega&fol='+folio);
        },
        listaTipVehi: function(folio){
            return $http.get('api/api.php?funcion=getListTipVehi&fol='+folio);
        },
        listaVitales: function(folio){
            return $http.get('api/api.php?funcion=getListVitales&fol='+folio);
        },
        // Apartado de solicitudes
        detalleSolicitud:function(clave){
            return $http.get('api/api.php?funcion=detalleSolicitud&clave='+ clave);
        },
        detalleSolicitudMasInfo:function(clave){
            return $http.get('api/api.php?funcion=detalleSolicitudesInfo&clave='+ clave);
        },
        expedientes:function(){
            return $http.get('api/api.php?funcion=busquedaExpedientes');
        },
        folio:function(folio){
            return $http.get('api/api.php?funcion=busquedaFolio&folioapi='+ folio);
        },
        loginfast:function(usuario){
            return $http.get('api/api.php?funcion=loginfast&usuario='+ usuario);
        },
        lesionado:function(lesionado){
            return $http.get('api/api.php?funcion=busquedaLesionado&lesionado='+ lesionado);
        },
        missolicitudes:function(){
            return $http.get('api/api.php?funcion=solicitudes&userapi='+ $cookies.usrLogin);
        },
        solicitudes:function(){
            return $http.get('api/api.php?funcion=solicitudes');
        },
        solicitudesInfo:function(){
            return $http.get('api/api.php?funcion=solicitudesInfo');
        },
        solicitudesRespuestas:function(){
            return $http.get('api/api.php?funcion=solicitudesRespuestas');
        },
        tipoDocumento:function(){
            return $http.get('api/api.php?funcion=tipoDocumento');
        },
        listaEmbarazo:function(folio){
            return $http.get('api/api.php?funcion=getListEmbarazo&fol='+folio);
        },
        listaLesion:function(){
            return $http.get('api/api.php?funcion=getListLesion');
        },
        listaLesiones:function(folio){
            return $http.get('api/api.php?funcion=getListLesiones&fol='+folio);
        },
        listaRX:function(){
            return $http.get('api/api.php?funcion=getListRX');
        },
        listaEstSol:function(folio){
            return $http.get('api/api.php?funcion=getListEstSol&fol='+folio);
        },        
        listaEstSolSub:function(folio){
            return $http.get('api/api.php?funcion=getlistEstSolSub&fol='+folio);
        },
        listaProced:function(){
            return $http.get('api/api.php?funcion=getListProcedimientos');
        },
        listaProcedimientos:function(folio){
            return $http.get('api/api.php?funcion=getListProRea&fol='+folio);
        },
        listaDiagnosticos:function(){
            return $http.get('api/api.php?funcion=getListDiagnostic');
        },
        despDiagnosticos:function(diagnos){
            return $http.get('api/api.php?funcion=getListDiag&diag='+diagnos);
        },
        listaMedicamentos:function(){
            return $http.get('api/api.php?funcion=getListMedicamentos');
        },
        listaOrtesis:function(){
            return $http.get('api/api.php?funcion=getListOrtesis');
        },
        listaIndicaciones:function(){
            return $http.get('api/api.php?funcion=getListIndicaciones');
        },
        verPosologia:function(cveMed){
            return $http.get('api/api.php?funcion=vePosologia&cveMed='+cveMed);
        },
        verindicacion:function(cveMed){
            return $http.get('api/api.php?funcion=veIndicacion&cveMed='+cveMed);
        },
        listaMedicamentosAgreg:function(folio){
            return $http.get('api/api.php?funcion=getListMedicamentosAgreg&fol='+folio);
        },
        listaMedicamentosAgregSub:function(folio){
            return $http.get('api/api.php?funcion=getListMedicamentosAgregSub&fol='+folio);
        },
        listaOrtesisAgreg:function(folio){
            return $http.get('api/api.php?funcion=getListOrtesisAgreg&fol='+folio);
        },
        listaIndicAgreg:function(folio){
            return $http.get('api/api.php?funcion=getListIndicAgreg&fol='+folio);
        },
        listaUnidades:function(folio){
            return $http.get('api/api.php?funcion=unidades');
        },
        validaSigVitales:function(folio){
            return $http.get('api/api.php?funcion=validaSigVitales&fol='+folio);
        },
        validaSubsec:function(folio){
            return $http.get('api/api.php?funcion=validaSubsecuencia&fol='+folio);
        }


    }
});

app.factory("movimientos", function($http, $rootScope){
    return{
        actualizaSolicitud:function(clave,estatus){
            return $http.get('api/api.php?funcion=ActualizaSolicitud&clave='+clave+'&estatus='+estatus);
        },
        guardaSolicitudInfo:function(datos){
            return $http.post('api/api.php?funcion=guardaSolicitudInfo',datos);
        },
        ingresaSolicitud:function(datos){
            return $http.post('api/api.php?funcion=guardaSolicitud',datos);
        }
    }
});


// se genero un controlador para los documentos no es necesario generar archivo adicional
app.controller('materialCtrl', function($scope){

    $scope.inicio = function(){
        $scope.documentos = [
            {ruta:'imgs/pdf.png',nombre:'Nota Médica',ubicacion:'archivos/Nota_Medica.pdf'},
            {ruta:'imgs/pdf.png',nombre:'Historia Clínica',ubicacion:'archivos/Historia_Clinica.pdf'},
            {ruta:'imgs/pdf.png',nombre:'Subsecuencia',ubicacion:'archivos/Suministros.pdf'},
            {ruta:'imgs/pdf.png',nombre:'Rehabilitación',ubicacion:'archivos/Rehabilitacion.pdf'},
            {ruta:'imgs/pdf.png',nombre:'Finiquito (GNP)',ubicacion:'archivos/Finiquito.pdf'},
            {ruta:'imgs/pdf.png',nombre:'Carta Finiquito(GNP)',ubicacion:'archivos/Carta_Finiquito.pdf'},
            {ruta:'imgs/pdf.png',nombre:'Aviso de privacidad',ubicacion:'archivos/Aviso_De_Privacidad.pdf'},
            {ruta:'imgs/pdf.png',nombre:'Id de paciente',ubicacion:'archivos/identificacion.pdf'},
            {ruta:'imgs/pdf.png',nombre:'Informe Médico THONA',ubicacion:'archivos/Informe_Medico_Thona.pdf'},
            {ruta:'imgs/pdf.png',nombre:'Informe Médico Quálitas',ubicacion:'archivos/Informe_Medico_Paciente_ABRIL_2014.pdf'}
        ];

        $scope.procesos = [
            {ruta:'imgs/office.png',nombre:'Proceso constancia médica ABA',ubicacion:'archivos/Manual_de_entrega_de_constancia_medica_ABA.doc'},
            {ruta:'imgs/pdf.png',nombre:'Proceso atención médica THONA',ubicacion:'archivos/Procedimiento_Thona.pdf'}
        ];

        $scope.escaners = [
            {ruta:'imgs/pdf.png',nombre:'Guía Visual de Configuración de Escáner HP Scanjet 5590',ubicacion:'archivos/Scaner.pdf'}
        ];

        $scope.consentimientos = [
            {ruta:'imgs/pdf.png',nombre:'Carta de Consentimiento',ubicacion:'archivos/carta-consentimiento.pdf'}
        ];

        $scope.manuales = [
            {ruta:'imgs/pdf.png',nombre:'Instructivo de Descarga de Medicamentos',ubicacion:'archivos/DescargaMed.pdf'}
        ];

        $scope.ejercicios = [
            {ruta:'imgs/pdf.png',nombre:'Cadera y Rodilla',ubicacion:'ejercicios/Cadera_Rodilla.pdf'},
            {ruta:'imgs/pdf.png',nombre:'Higiene de Columna',ubicacion:'ejercicios/Higiene_Columna.pdf'},
            {ruta:'imgs/pdf.png',nombre:'Columna Cervical',ubicacion:'ejercicios/Columna_Cervical.pdf'},
            {ruta:'imgs/pdf.png',nombre:'Hombro',ubicacion:'ejercicios/Hombro.pdf'},
            {ruta:'imgs/pdf.png',nombre:'Codo, Mano , y Muñeca',ubicacion:'ejercicios/Codo_Mano_Muneca.pdf'},
            {ruta:'imgs/pdf.png',nombre:'Tobillo y Pie',ubicacion:'ejercicios/Tobillo_Pie.pdf'},
            {ruta:'imgs/pdf.png',nombre:'Columna Dorsolumbar',ubicacion:'ejercicios/Columna_Dorsolumbar.pdf'}
        ];
    }
});


//bloqueo de sesion
app.controller('bloqueoCtrl',function($scope, $cookies, $cookieStore, $rootScope, sesion){

    $scope.inicio = function(){

        $scope.usuario = $cookies.usrLogin;
        $scope.nombre = $cookies.username;

        $cookieStore.remove("username"),
        $rootScope.username = '';
        $rootScope.mensaje = '';

        $('html').addClass('lockscreen');

    }

    $scope.login = function(){

        
        $rootScope.mensaje = '';
        //console.log($scope.usuario);
        sesion.login($scope.usuario, $scope.password);

    }

});


//funcion que ayuda a ponerl la hora actual 

var tiempo = new Date();
                
var dd = tiempo.getDate(); 
var mm = tiempo.getMonth()+1;//enero es 0! 
if (mm < 10) { mm = '0' + mm; }
if (dd < 10) { dd = '0' + dd; }

var yyyy = tiempo.getFullYear();
//armamos fecha para los datepicker
var FechaAct = yyyy + '-' + mm + '-' + dd;

var hora = tiempo.getHours();
var minuto = tiempo.getMinutes();

var FechaActHora = hora + ':' + minuto;


///notas 



//definicion de factoria en angular
// app.factory('nombredefactoria',function($http,$rootScope){
//     return{
//         query:function(parametros){
//             //cualquier cosa
//         },
//         alta:function(){
//             //cualquier cosa
//         }
//     }
// })


///funciones en algular
// $rootScope.nombrefuncion = function(parametros){}
// $scope.nombrefuncion = function(){}

// //llamada desde html
// <button ng-click="nombrefuncion()">
// //llamada desde js
// $scope.nombrefuncion();

