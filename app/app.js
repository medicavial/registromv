//inicializamos la aplicacion
var app = angular.module('app', ['ui.bootstrap', 'ngCookies','ngRoute','ngAnimate' ,'mgo-angular-wizard','angularFileUpload','akoenig.deckgrid','ngDialog']);

//configuramos nuestra aplicacion
app.config(function($routeProvider){

    //Configuramos la ruta que queremos el html que le toca y que controlador usara
    
    // menu y login general
    $routeProvider.when('/home',{
            templateUrl: 'views/home.html',
            controller : 'homeCtrl'
    });

    $routeProvider.when('/login',{
            templateUrl: 'views/login.html',
            controller : 'loginCtrl'
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

});


//sirve para ejecutar cualquier cosa cuando inicia la aplicacion
app.run(function ($rootScope ,$cookies, $cookieStore, sesion, $location){

    
    $rootScope.admin = true;
    $rootScope.cerrar = false;


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

        sesion.checkStatus();

    });


    //funcion en angular
    $rootScope.logout = function(){

        sesion.logout();
    } 

    //generamos al rootscope las variables que tenemos en las cookies para no perder la sesion 
    $rootScope.username =  $cookies.username;
    $rootScope.cordinacion =  $cookies.cordinacion;

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
                    $rootScope.username = data[0].Usu_nombre;
                    $cookies.username = data[0].Usu_nombre;
                    $cookies.uniClave = data[0].Uni_clave;
                    $cookies.usrLogin = data[0].Usu_login;
                    $cookies.cordinacion = data[0].Cordinacion;
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
            return $http.get('api/api.php?funcion=busquedaFolio&folio='+ folio);
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
        listaEstSol:function(){
            return $http.get('api/api.php?funcion=getListEstSol');
        },
        listaProced:function(){
            return $http.get('api/api.php?funcion=getListProcedimientos');
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

