var app = angular.module('appReport', ["ngSanitize", "ngCsv", "angularUtils.directives.dirPagination", 'ngAnimate', 'ngFileUpload', 'luegg.directives']);
app.directive('ngEnter', function() {
    return function(scope, element, attrs) {
        element.bind("keydown keypress", function(event) {
            if (event.which === 13) {
                scope.$apply(function() {
                    scope.$eval(attrs.ngEnter, { 'event': event });
                });

                event.preventDefault();
            }
        });
    };
});

app.directive('animateOnChange', function($animate, $timeout) {
    return function(scope, elem, attr) {
        scope.$watch(attr.animateOnChange, function(nv, ov) {
            if (nv != ov) {
                var c = nv > ov ? 'change-up' : 'change';
                $animate.addClass(elem, c).then(function() {
                    $timeout(function() { $animate.removeClass(elem, c); });
                });
            }
        });
    };
});
app.factory('Excel', function($window) {
    var uri = 'data:application/vnd.ms-excel;base64,',
        template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
        base64 = function(s) { return $window.btoa(unescape(encodeURIComponent(s))); },
        format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) };
    return {
        tableToExcel: function(tableId, worksheetName) {
            var table = angular.element(tableId);
            ctx = { worksheet: worksheetName, table: table.html() },
                href = uri + base64(format(template, ctx));
            return href;
        }
    };
}).controller('ctrlReport', ['Excel', '$timeout', '$scope', '$http', '$location', 'Upload', '$interval', function(Excel, $timeout, $scope, $http, $location, Upload, $interval) {
    $scope.AniosMesesCortes = [];
    $scope.id_permiso = 0;
    $scope.permisos = 0;
    $scope.titulo = " Inicio ";
    $scope.currenturl = window.location.href;
    $scope.resultUrl = $scope.currenturl.substring(0, $scope.currenturl.lastIndexOf("/") + 1);
    $scope.cargandoForm = false;

    $scope.showSideBar = true;
    $scope.wrapperStyle = {};

    $scope.contentStyle = {};

    $scope.wrapperfull = {
        "padding-left": "0px"
    }
    $scope.contentFluid = {
            "padding-left": "0px",
            "padding-right": "0px"

        }
        /* color del BANNER para cada plan de estudios en css */
    $scope.colorBanner = [];
    $scope.colorBanner[1] = "background-color: #3498db; color:white;";
    $scope.colorBanner[49] = "background-color: #3498db; color:white;";
    $scope.colorBanner[2] = "background-color: #205DB0; color:white;";
    $scope.colorBanner[47] = "background-color: #205DB0; color:white;";
    $scope.colorBanner[3] = "background-color: #B6BF00; color:white;";
    $scope.colorBanner[4] = "background-color: #E11030; color:white;";
    $scope.colorBanner[61] = "background-color: #E11030; color:white;";
    $scope.colorBanner[9] = "background-color: #f07e30; color:white;";
    $scope.colorBanner[10] = "background-color: #f07e30; color:white;";
    $scope.colorBanner[12] = "background-color: #205DB0; color:white;";
    $scope.colorBanner[14] = "background-color: #E11030; color:white;";
    $scope.colorBanner[17] = "background-color: #3498db; color:white;";
    $scope.colorBanner[18] = "background-color: #205DB0; color:white;";
    $scope.colorBanner[51] = "background-color: #205DB0; color:white;";
    $scope.colorBanner[50] = "background-color: #0D1D41; color:white;";
    $scope.colorBanner[13] = "background-color: #3498db; color:white;";
    $scope.colorBanner[16] = "background-color: #E11030; color:white;";
    $scope.colorBanner[22] = "background-color: #205DB0; color:white;";
    $scope.colorBanner[62] = "background-color: #205DB0; color:white;";
    $scope.colorBanner[29] = "background-color: #f07e30; color:white;";
    $scope.colorBanner[30] = "background-color: #f07e30; color:white;";
    $scope.colorBanner[39] = "background-color: #205DB0; color:white;";
    $scope.colorBanner[40] = "background-color: #3498db; color:white;";
    $scope.colorBanner[19] = "background-color: #db1d36; color:white;";
    $scope.colorBanner[60] = "background-color: #DF241A; color:white;";
    $scope.colorBanner[59] = "background-color: #205DB0; color:white;";
    $scope.colorBanner[64] = "background-color: #205DB0; color:white;";
    $scope.colorBanner[71] = "background-color: #e50011; color:white;";
    $scope.colorBanner[72] = "background-color: #e50011; color:white;";
    $scope.colorBanner[73] = "background-color: #e50011; color:white;";
    $scope.colorBanner[74] = "background-color: #f1b609; color:white;";
    $scope.colorBanner[89] = "background-color: #205DB0; color:white;";

    /* tipo color del PANEL y botones para cada plan de estudios en boostrap */

    $scope.colorPannel = [];
    $scope.colorPannel[1] = "info";
    $scope.colorPannel[49] = "info";
    $scope.colorPannel[2] = "info";
    $scope.colorPannel[47] = "info";
    $scope.colorPannel[3] = "success";
    $scope.colorPannel[4] = "danger";
    $scope.colorPannel[61] = "danger";
    $scope.colorPannel[9] = "warning";
    $scope.colorPannel[10] = "warning";
    $scope.colorPannel[12] = "info";
    $scope.colorPannel[14] = "danger";
    $scope.colorPannel[17] = "info";
    $scope.colorPannel[18] = "info";
    $scope.colorPannel[51] = "info";
    $scope.colorPannel[50] = "info";
    $scope.colorPannel[13] = "info";
    $scope.colorPannel[16] = "danger";
    $scope.colorPannel[22] = "info";
    $scope.colorPannel[62] = "info";
    $scope.colorPannel[29] = "warning";
    $scope.colorPannel[30] = "warning";
    $scope.colorPannel[39] = "info";
    $scope.colorPannel[40] = "info";
    $scope.colorPannel[19] = "danger";
    $scope.colorPannel[60] = "danger";
    $scope.colorPannel[59] = "info";
    $scope.colorPannel[64] = "info";
    $scope.colorPannel[71] = "danger";
    $scope.colorPannel[72] = "danger";
    $scope.colorPannel[73] = "danger";
    $scope.colorPannel[74] = "warning";
    $scope.colorPannel[89] = "info";

    /*para mensajes*/
    $scope.corporaciones = [];
    $scope.corporaciones[0] = "Todas";
    $scope.corporaciones[1] = "AgCollege";
    $scope.corporaciones[2] = "Prepacoppel";
    $scope.corporaciones[2] = "Prepa Coppel 2020";
    $scope.corporaciones[3] = "Soriana";
    $scope.corporaciones[4] = "UCL";
    $scope.corporaciones[61] = "UCL";
    $scope.corporaciones[7] = "Toks";
    $scope.corporaciones[8] = "Mabe";
    $scope.corporaciones[6] = "UMI";
    $scope.corporaciones[10] = "Flexi";


    /*para mensajes */
    $scope.plan_estudios = [];
    $scope.plan_estudios[0] = "Todas";
    $scope.plan_estudios[1] = "AG College";
    $scope.plan_estudios[49] = "AG College 2020";
    $scope.plan_estudios[2] = "Prepacoppel";
    $scope.plan_estudios[47] = "Prepa Coppel 2020";
    $scope.plan_estudios[3] = "SorianaPrepa";
    $scope.plan_estudios[4] = "PrepaLey";
    $scope.plan_estudios[61] = "PrepaLey 2022";
    $scope.plan_estudios[9] = "PrepaToks";
    $scope.plan_estudios[10] = "LicenciaturaToks";
    $scope.plan_estudios[12] = "Maestria";
    $scope.plan_estudios[14] = "Ley Licenciatura";
    $scope.plan_estudios[17] = "AgSocial";
    $scope.plan_estudios[18] = "Ingenieria";
    $scope.plan_estudios[51] = "Admisiones";
    $scope.plan_estudios[13] = "Sumate";
    $scope.plan_estudios[16] = "UCL Escuelas";
    $scope.plan_estudios[22] = "LEG Coppel 2018";
    $scope.plan_estudios[62] = "LEG Coppel 2022";
    $scope.plan_estudios[29] = "Nueva Prepa Toks";
    $scope.plan_estudios[30] = "Nueva Licenciatura Toks";
    $scope.plan_estudios[39] = "Nueva Maestria";
    $scope.plan_estudios[40] = "AGcollege Licenciatura";
    $scope.plan_estudios[19] = "Flexi Academias";
    $scope.plan_estudios[60] = "Prepa Oxxo";
    $scope.plan_estudios[59] = "IDS UMI";
    $scope.plan_estudios[64] = "Admisiones UMI";
    $scope.plan_estudios[71] = "Prepa PIZZA HUT";
    $scope.plan_estudios[72] = "Prepa WINGS ARMY";
    $scope.plan_estudios[73] = "Prepa KIA SUSHI";
    $scope.plan_estudios[74] = "Prepa VALDEZ BALUARTE";
    $scope.plan_estudios[89] = "Maestria UMI 3";

    /*status mensajes*/
    $scope.status = [];
    $scope.status[0] = "Inactivo";
    $scope.status[1] = "Activo";

    $scope.tipos_mensajes = [];
    $scope.tipos_mensajes[0] = "Global(modal)";
    $scope.tipos_mensajes[1] = "Mensaje Normal";
    $scope.tipos_mensajes[2] = "Mensaje notificacion(proximamente)";
    /*$scope.tipos_mensajes[2]="baja del la empresa";
    $scope.tipos_mensajes[3]="baja del programa";
    $scope.tipos_mensajes[4]="Suspendidos por Documentos";
    $scope.tipos_mensajes[5]="Suspendidos por Inactividad";
    $scope.tipos_mensajes[6]="Suspendidos por tiempo";
    $scope.tipos_mensajes[7]="Baja sin confirmacion";
    $scope.tipos_mensajes[8]="Egresado";*/

    //VAR
    $scope.filters = [];
    $scope.columns = [];
    $scope.columnsSelect = [];
    $scope.columnsFilter = [];

    $scope.total_row = 0;
    $scope.bd = 2;
    $scope.report = [];
    $scope.sqlquery = "";

    //ACTAS
    $scope.alumnos_reportes = [];
    $scope.actas_reporte = [];
    $scope.corporacion = 2;
    $scope.ciclo_escolar = '';
    $scope.grado = '';
    $scope.tipo_evaluacion = '';
    $scope.tipo_movimiento = '';
    $scope.fecha_evaluacion = '';
    $scope.id_folio = '';
    $scope.subciclo_escolar = '';
    $scope.generacionesDGB=[];


    //MENSAJES DE PLATAFORMA
    $scope.mensajes = [];
    $scope.mensaje = {};
    $scope.mensaje.titulo = "";
    $scope.mensaje.tipo = 1;
    $scope.mensaje.status = 0;
    $scope.mensaje.sexo = 0;
    $scope.mensaje.id_corporacion = 2;
    $scope.mensaje.id_plan_estudio = 1;
    $scope.mensaje.mensaje = "";
    $scope.searchMensaje = "";
    $scope.isEditar = false;

    $scope.mensajeEditar = {};
    $scope.mensajeEditar.id = 0;
    $scope.mensajeEditar.titulo = 0;

    var toast = new notificacionesToast();

    $scope.ChangeView = function(url, is_fullscreen, titulo) {
        $scope.view = url;
        $scope.titulo = titulo;

        $scope.showSideBar = !is_fullscreen;
        if (is_fullscreen) {
            //$scope.wrapperclass="wrapper2";
            $scope.wrapperStyle = angular.copy($scope.wrapperfull);
            $scope.contentStyle = angular.copy($scope.contentFluid);


        } else {
            $scope.wrapperStyle = {};
            $scope.contentStyle = {};
        }
    }
    $scope.vistaMas = function() {
        var alto = $("#divContenido").height();
        $("#frame", window.parent.document).height((alto + 400));
    }

    $scope.vistaMenos = function() {
        var alto = $("#divContenido").height();
        //$("#frame",window.parent.document).height((alto-200));
    }

    $scope.SelectColumn = function(idx_column) {
        if (-1 == $scope.columnsSelect.indexOf(idx_column)) {
            $scope.columnsSelect.push(idx_column);
            $scope.columnsFilter.push(idx_column);
            $scope.filters.push("");

        }
    }
    $scope.UnSelectColumn = function(idx_column) {
        $scope.filters.splice(idx_column, 1);
        $scope.columnsFilter.splice(idx_column, 1);
        $scope.columnsSelect.splice(idx_column, 1);

    }

    $scope.GetColumns = function(bd) // GET the config columns from columnasprueba.php
        {
            $scope.sqlquery = "";
            $scope.columns.length = 0;
            $scope.columnsSelect.length = 0;
            $scope.columnsFilter.length = 0;
            $scope.filters.length = 0;

            $scope.report.length = 0;
            if (!$scope.cargando) {

                $scope.cargando = true;
                var url = $scope.resultUrl + "datos/GetColumns.php?bd=" + bd;
                $http.get(
                        url
                    ).success(function(data, status, headers, config) {
                        
                        $scope.cargando = false;

                        if (angular.isObject(data)) {
                            $scope.columns = angular.copy(data);


                        } else {
                            console.log("Error get config columns");
                        }


                    })
                    .error(function(err, status, headers, config) {
                        console.log("Error al optener las columnas " + err);
                        $scope.cargando = false;

                    });


            }

        };

    $scope.GetAniosMesesCortes = function() // get permisos
        {
            var url = $scope.resultUrl + "datos/GetAniosMesesCortes.php";
            $http.get(
                    url
                ).success(function(data, status, headers, config) {
                    if (angular.isObject(data)) {
                        $scope.AniosMesesCortes = angular.copy(data);
                    } else {
                        if (data == null) {
                            window.location.href = $scope.resultUrl + "datos/logout.php";
                        }
                    }
                })
                .error(function(err, status, headers, config) {
                    console.log("Error get permisos  " + err);
                });
        };


    $scope.GetPermisos = function() // get permisos
        {

            var url = $scope.resultUrl + "datos/GetPermisos.php";
            $http.get(
                    url
                ).success(function(data, status, headers, config) {

                    /*if(!isNaN(data)){
                    	$scope.permisos=data;
                    }else{
                    	console.log("Error get permisos"+data);
                    	if(data==null){
                    		window.location.href = $scope.resultUrl+"datos/logout.php";
                    	}
                    }*/


                    if (angular.isObject(data)) {
                        $scope.permisos = data['permisos']; //permiso tb personas
                        $scope.id_permiso = data['id_permiso']; // permiso tb usuario

                        var dataAyudas = [];
                        //var arrayPermisosAyuda = data['tiposroles_ayuda']

                        angular.forEach(data['tiposroles_ayuda'], function(item, index) {
                            dataAyudas.push(JSON.parse(item));
                        });

                        $scope.tiporoles = dataAyudas;
                    } else {
                        if (data == null) {
                            window.location.href = $scope.resultUrl + "datos/logout.php";
                        }
                    }




                })
                .error(function(err, status, headers, config) {
                    console.log("Error get permisos  " + err);

                });


        };



    $scope.GetAlerts = function() // get permisos
        {

            var url = $scope.resultUrl + "datos/GetAlertas.php";
            $http.get(
                    url
                ).success(function(data, status, headers, config) {

                    if (data != "no") {
                        angular.element.notify({
                            // options
                            icon: 'fa fa-paw',
                            message: data
                        }, {
                            // settings
                            type: 'success',
                            placement: {
                                from: 'top',
                                align: 'center'
                            }
                        });

                    } else {
                        console.log("Sin alerts: " + data);
                    }


                })
                .error(function(err, status, headers, config) {
                    console.log("Error get permisos  " + err);

                });


        };


    $scope.GenerateReport = function() {

        if (!$scope.cargando) {
            $scope.total_row = 0;
            $scope.cargando = true;
            $scope.report = [];

            var datos = {
                columns: $scope.columnsSelect,
                bd: $scope.bd,
                filters: $scope.filters
            };
            var url = $scope.resultUrl + "datos/GenerateReport.php";

            $http.post(
                    url,
                    datos
                ).success(function(data, status, headers, config) {

                    $scope.report = [];
                    if (angular.isObject(data)) {
                        if (angular.isObject(data[0])) {
                            $scope.report = angular.fromJson(data[0]);
                            $scope.sqlquery = data[1];
                        } else {
                            $scope.sqlquery = data[1];
                        }
                    } else {
                        $scope.sqlquery = data.toString();
                        console.log("Error Report 01 ");
                        console.log("recived: " + data);
                    }
                    $scope.cargando = false;
                })
                .error(function(err, status, headers, config) {
                    console.log("Error Report 02 " + err);
                    $scope.cargando = false;

                });


        }

    };


    $scope.GenerateReportExcel = function() {
        var gets = "?bd=" + $scope.bd + "&";
        for (var i = 0; i < $scope.columnsSelect.length; i++) {
            gets += "columns[]=" + $scope.columnsSelect[i] + "&";
        };
        for (var i = 0; i < $scope.filters.length; i++) {
            gets += "filters[]=" + $scope.filters[i] + "&";
        };
        gets = gets.slice(0, -1);

        var url = $scope.resultUrl + "datos/GenerateReportExcel.php" + gets;
        //$scope.personasfull = []; // listado de personas
        window.location.href = url;
    };


    $scope.HistorialActas = function(dgb) {

        if (!$scope.cargando) {
            $scope.total_row = 0;
            $scope.cargando = true;
            $scope.actas_reporte = [];

            var datos = {
                corporacion: dgb.corporacion,
                ciclo_escolar: dgb.ciclo_escolar,
                grado: dgb.grado,
                tipo_evaluacion: dgb.tipo_evaluacion,
                tipo_movimiento: dgb.tipo_movimiento,
                fecha_evaluacion: dgb.fecha_evaluacion,
                id_folio: dgb.id_folio,
                subciclo_escolar: dgb.subciclo_escolar
            };
            var url = $scope.resultUrl + "datos/dgb_historial.php";

            $http.post(
                    url,
                    datos
                ).success(function(data, status, headers, config) {

                    $scope.actas_reporte = [];
                    if (angular.isObject(data)) {
                        $scope.sqlquery = data[1].toString();
                        $scope.actas_reporte = angular.fromJson(data[0]);

                    } else {
                        $scope.sqlquery = data.toString();
                        console.log("Error Reporte actas_reporte 01 ");
                        console.log("recived: " + data);
                    }
                    $scope.cargando = false;
                })
                .error(function(err, status, headers, config) {
                    console.log("Error Reporte actas_reporte 02" + err);
                    $scope.cargando = false;

                });


        }

    };

    $scope.getGeneracionesDGB = function() {

        if (!$scope.cargando) {
            $scope.cargando = true;
            $scope.generacionesDGB = [];

            var datos = {};
            var url = $scope.resultUrl + "datos/dgb_get_generaciones.php";

            $http.post(
                    url,
                    datos
                ).success(function(data, status, headers, config) {
                    
                    $scope.generacionesDGB = [];
                    if (angular.isObject(data)) {
                         $scope.generacionesDGB = angular.fromJson(data);
                        
                    } else {
                        $scope.sqlquery = data.toString();
                        console.log("Error al traer generaciones ");
                        console.log("recived: " + data);
                    }
                    $scope.cargando = false;
                })
                .error(function(err, status, headers, config) {
                    console.log("Error al traer generaciones" + err);
                    $scope.cargando = false;

                });


        }

    };


    $scope.AlumnosDGB = function(dgb) {

        if (!$scope.cargando) {
            $scope.total_row = 0;
            $scope.cargando = true;
            $scope.alumnos_reportes = [];

            var datos = {
                corporacion: dgb.corporacion,
                ciclo_escolar: dgb.ciclo_escolar,
                grado: dgb.grado,
                tipo_movimiento: dgb.tipo_movimiento,
                fecha_inscripcion: dgb.fecha_inscripcion,
                matricula: dgb.matricula,
                id_moodle: dgb.idmoodle,
                subciclo_escolar: dgb.subciclo_escolar
            };
            var url = $scope.resultUrl + "datos/dgb_alumnos.php";

            $http.post(
                    url,
                    datos
                ).success(function(data, status, headers, config) {

                    $scope.alumnos_reportes = [];
                    if (angular.isObject(data)) {
                        $scope.sqlquery = data[1].toString();
                        $scope.alumnos_reportes = angular.fromJson(data[0]);

                    } else {
                        $scope.sqlquery = data.toString();
                        console.log("Error Reporte alumnos_reportes 01 ");
                        console.log("recived: " + data);
                    }
                    $scope.cargando = false;
                })
                .error(function(err, status, headers, config) {
                    console.log("Error Reporte alumnos_reportes 02" + err);
                    $scope.cargando = false;

                });


        }

    };


    $scope.SetMensaje = function(mensaje) {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        if (mensaje.titulo.toString().trim() == "") {
            alert("Porfavor ingresa el titulo.");
            return;
        }

        if ($('#editor1').val().toString().trim() == "") {
            alert("Porfavor ingresa el mensaje.");
            return;
        }

        if (!$scope.cargando) {

            var datos = {
                id_mensaje: mensaje.id,
                titulo: mensaje.titulo,
                tipo: mensaje.tipo,
                status: mensaje.status,
                sexo: mensaje.sexo,
                id_plan_estudio: mensaje.id_plan_estudio,
                mensaje: $('#editor1').val()
            };

            if ($scope.isEditar) { // editar mensaje
                var url = $scope.resultUrl + "datos/UpdateMensaje.php";

            } else { // crear mensaje
                var url = $scope.resultUrl + "datos/SetMensaje.php";

            }

            $http.post(
                    url,
                    datos
                ).success(function(data, status, headers, config) {


                    if (data == 1) {
                        alert("Mensaje guardado correctamente");
                        $scope.mensaje.id = 0;
                        $scope.mensaje.titulo = "";
                        $scope.mensaje.tipo = 1;
                        $scope.mensaje.status = 1;
                        $scope.mensaje.sexo = 0;
                        $scope.mensaje.id_plan_estudio = 0;
                        $scope.mensaje.mensaje = "";
                        for (instance in CKEDITOR.instances) {
                            CKEDITOR.instances[instance].updateElement();
                            CKEDITOR.instances[instance].setData("");
                        }
                        $scope.Mensajes();
                    } else {
                        alert("Por el momento no puedes guardar mensajes \n Intente mas tarde.");

                        console.log("Error form mensajes 01 ");
                        console.log("recived: " + data);
                    }
                    $scope.cargando = false;
                    $scope.isEditar = false;
                })
                .error(function(err, status, headers, config) {
                    alert("Por el momento no puedes guardar mensajes \n Intente mas tarde.");

                    console.log("Error form mensajes 02" + err);
                    $scope.cargando = false;

                });


        }

    };

    $scope.Mensajes = function() {
        if (!$scope.cargando) {

            $scope.mensajes = [];

            var datos = {};
            var url = $scope.resultUrl + "datos/GetMensajes.php";

            $http.post(
                    url,
                    datos
                ).success(function(data, status, headers, config) {

                    $scope.mensajes = [];

                    if (angular.isObject(data)) {
                        $scope.sqlquery = data[1].toString();
                        $scope.mensajes = angular.fromJson(data[0]);
                    } else {
                        $scope.sqlquery = data.toString();
                        console.log("Error Reporte mensajes 01 ");
                        console.log("recived: " + data);
                    }
                    $scope.cargando = false;
                })
                .error(function(err, status, headers, config) {
                    console.log("Error Reporte mensajes 02" + err);
                    $scope.cargando = false;

                });


        }

    };

    $scope.EditarMensaje = function(mensaje) {

        $scope.isEditar = true;
        $scope.mensaje.id = mensaje.id;
        $scope.mensaje.titulo = mensaje.titulo;
        $scope.mensaje.id_plan_estudio = mensaje.id_plan_estudio;
        $scope.mensaje.tipo = mensaje.tipo;
        $scope.mensaje.status = mensaje.status;
        $scope.mensaje.mensaje = mensaje.mensaje;
        $scope.mensaje.sexo = mensaje.sexo;

        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
            CKEDITOR.instances[instance].setData(mensaje.mensaje);
        }

    }
    $scope.ResetMensaje = function() {

        $scope.isEditar = false;
        $scope.mensaje.id = 0;
        $scope.mensaje.titulo = "";
        $scope.mensaje.tipo = 1;
        $scope.mensaje.status = 1;
        $scope.mensaje.sexo = 0;
        $scope.mensaje.id_plan_estudio = 0;
        $scope.mensaje.mensaje = "";
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
            CKEDITOR.instances[instance].setData("");
        }

    }

    $scope.CurrentMensaje = function(men) {

        $scope.mensajeEditar.id = men.id;
        $scope.mensajeEditar.titulo = men.titulo;

    }



    $scope.EliminarMensaje = function(id) {
        if (id.toString().trim() == "") {
            alert("Porfavor ingresa el ID.");
            return;
        }


        if (!$scope.cargando) {

            var datos = {
                id_mensaje: id
            };

            var url = $scope.resultUrl + "datos/EliminarMensaje.php";


            $http.post(
                    url,
                    datos
                ).success(function(data, status, headers, config) {


                    if (data == 1) {
                        alert("Mensaje Eliminado correctamente");
                        $scope.mensajeEditar.id = 0;
                        $scope.mensajeEditar.titulo = "";
                        $('#modal_mensajes').modal('toggle');
                        $scope.Mensajes();
                    } else {
                        alert("Por el momento no puedes eliminar mensajes \n Intente mas tarde.");

                        console.log("Error form mensajes 01 ");
                        console.log("recived: " + data);
                    }
                    $scope.cargando = false;
                })
                .error(function(err, status, headers, config) {
                    alert("Por el momento no puedes eliminar mensajes \n Intente mas tarde.");

                    console.log("Error form mensajes 02" + err);
                    $scope.cargando = false;

                });


        }

    };

    var scannerNotificaciones = function() {
        callbackNotificacionesMensajesAyuda();
        treadhMessages = setInterval(function() { callbackNotificacionesMensajesAyuda(); }, 300000);
    };

    var callbackNotificacionesMensajesAyuda = function() {
        var formData = new FormData();
        formData.append('a', 'threadNotificacionesAyuda');

        $.ajax({
            url: 'datos/ayuda_alumnos.php',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'post',
            success: function(response) {
                if (response.success) {
                    toast.changeConfig({
                        closeButton: true,
                        debug: false,
                        newestOnTop: false,
                        progressBar: false,
                        positionClass: "toast-bottom-right",
                        preventDuplicates: true,
                        onclick: null,
                        showDuration: "300",
                        hideDuration: "1000",
                        timeOut: "0",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut"
                    });

                    if (response.data.Mensajes.length > 0) {
                        let nuRegistros = response.data.Mensajes[0].nuMensajesNuevos;

                        if (nuRegistros > 0) {
                            toast.info('Nuevos Mensajes', 'Tienes ' + nuRegistros + ' nuevos mensajes de solicitudes de ayuda');
                        }
                    }

                    if (response.data.Pendientes.length > 0) {
                        let nuTotalVigentes = response.data.Pendientes[0].nuTotalVigentes;
                        let nuTotalVencidos = response.data.Pendientes[0].nuTotalVencidos;

                        if (nuTotalVigentes > 0) {
                            toast.info('Incidencias de ayuda pendientes', 'Tienes ' + nuTotalVigentes + ' incidencias vigentes');
                        }
                        if (nuTotalVencidos > 0) {
                            toast.info('Incidencias de ayuda vencidas', 'Tienes ' + nuTotalVencidos + ' incidencias vencidas');
                        }
                    }
                } else {
                    console.log(response);
                }
            },
            error: function(response) {
                console.log(response);
            }
        });
    };

    window.onbeforeunload = function(event) {
        clearTimeout(treadhMessages);
    };

    $scope.GetPermisos();
    $scope.GetAlerts();
    $scope.GetAniosMesesCortes();
    scannerNotificaciones();
}]);