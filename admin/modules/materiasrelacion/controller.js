var app = angular.module('appAdministrador', ['angularUtils.directives.dirPagination']);
app.directive('ngEnter', function() 
{
    return function(scope, element, attrs) 
    {
        element.bind("keydown keypress", function(event) 
        {
            if(event.which === 13) 
            {
                scope.$apply(function()
                {
                    scope.$eval(attrs.ngEnter, {'event': event});
                });
                event.preventDefault();
            }
        });
    };
});
app.controller('ctlAdministrador', function($scope,$http,$filter,$window)
{

	$scope.pagination = [];
	$scope.itemrelacion_eliminar = 0;
	//$scope.showEliminarRelacionMateria = false;
	$scope.mostrarmateriascorporacion = false;
	$scope.btnMostrarAlumnos = false;
	$scope.btnMostrarProfesores = false;
	$scope.btnMostrarPlanEstudios = false;
	$scope.pagination.porpagina = 1000;
	$scope.pagination.current = 1;
	$scope.pagination.total = 0;

	$scope.materias_relacion = [];
	$scope.corporaciones = [];
	$scope.plan_estudios_autoridades = [];
	$scope.materias_autoridad = [];
	$scope.regiones = [];
	$scope.estudiantes_tipo = [];
	$scope.persona = [];
	$scope.escuelas = [];
	$scope.plan_estudios = [];
	$scope.alumno = [];
	$scope.alumnos = [];
	$scope.newAlumno = [];
	$scope.ciudades = [];
	$scope.cobaes_alumnos = [];
	$scope.profesores = [];
	$scope.dgb_alumnos = [];
	$scope.cobaes_actas = [];
	$scope.actaseleccionada = [];
	$scope.dgb_actas = []; 
	$scope.showNuevoAlumno = false;

	$scope.numero = "";
	$scope.escuelas = [];
	$scope.puestos = [];
	$scope.sucursales = [];
	$scope.plan_estudios = [];
	$scope.escuelas = [];
	$scope.estados_alumnos = [];
	//Limpiar variables
	$scope.limpiar = function()
	{
		$scope.mostrarmateriascorporacion = false;
		btnMostrarPlanEstudios = $scope.btnMostrarProfesores = $scope.btnMostrarAlumnos = false;
		$scope.alumno = [];
		$scope.materias_relacion = [];
		$scope.alumnos = [];
		$scope.newAlumno = [];
		$scope.profesores = [];
		$scope.cobaes_actas = [];
		$scope.dgb_actas = [];
		$scope.cobaes_alumnos = [];
		$scope.dgb_alumnos = [];
		$scope.materias_autoridad = [];
		$scope.plan_estudios_autoridades = [];
	}
	//Limpiar variables

	//Has login al inicio de la aplicación
	


	//----------------------------------------------------------------
	//Versión para sistema de reportes desarrollador por roberto vega
	
	
	
	
	$http.get("datos/getLogin.php")
	.success(function(data,status,headers,config)
	{
		if(angular.isObject(data))
		{//Si es objeto ENTONSES
			$scope.persona = data;
			if($scope.persona.permisos == 3) // Si es usuario de ayuda
				$window.location = "../adminayuda";
			else //SINO Consigue todos los alumnos
			{
				$scope.getCorporaciones();
				$scope.getCiudades();
				$scope.getEscuelas();
				$scope.getRegiones();
				$scope.getEstudiantestipo();
				$scope.getPlanEstudios();
				$scope.getPuestos();
				$scope.getEstadosAlumnos();
				$scope.getSucursales();
				



			}
		}
		console.log(data);
	})
	.error(function(err,status,headers,config)
	{
		console.log(err);
	});
	
	//Versión para sistema de reportes desarrollador por roberto vega
	//----------------------------------------------------------------



	//Has login al inicio de la aplicación


	//Boton mostrar alumnos
	$scope.btnMostrarAlumnos_click = function()
	{
		$scope.limpiar();
		$scope.btnMostrarAlumnos = true;
		$scope.getAlumnos(1);

	}
	//Boton mostrar alumnos

	$scope.getEstudiantestipo = function()
	{
		//$("body").css("cursor","progress");
		$http.get("datos/getTiposEstudiantes.php")
		.success(function(response,status,headers,config)
		{
			if(angular.isObject(response))
			{
				if(response.success)
				{
					$scope.estudiantes_tipo = response.data;
				}
				else
				{
					console.log("Error "+response.error);
				}
			}
			else
			{
				console.log("Error de formato json"+response);
			}
			//$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			//$("body").css("cursor","default");
		});
	}
	$scope.getPuestos = function()
	{
		//$("body").css("cursor","progress");
		$http.get("datos/getPuestos.php")
		.success(function(response,status,headers,config)
		{
			if(angular.isObject(response))
			{
				if(response.success)
				{
					$scope.puestos = response.data;
				}
				else
				{
					console.log("Error"+response.error);
				}
			}
			else
			{
				console.log("Error de formato json"+response);
			}
			//$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			//$("body").css("cursor","default");
		});
	}
	$scope.getSucursales = function()
	{
		//$("body").css("cursor","progress");
		$http.get("datos/getSucursales.php")
		.success(function(response,status,headers,config)
		{
			if(angular.isObject(response))
			{
				if(response.success)
				{
					$scope.sucursales = response.data;

				}
				else
				{
					console.log("Error"+response.error);
				}
			}
			else
			{
				console.log("Error de formato json"+response);
			}
			//$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			//$("body").css("cursor","default");
		});
	}




	$scope.getEstadosAlumnos = function()
	{

		//$("body").css("cursor","progress");
		$http.get("datos/getEstadosAlumnos.php")
		.success(function(response,status,headers,config)
		{
			if(angular.isObject(response))
			{
				if(response.success)
				{
					$scope.estados_alumnos = response.data;
				}
				else
				{
					console.log("Error "+response.error);
				}
			}
			else
			{
				console.log("Error de formato json"+response);
			}
			//$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			//$("body").css("cursor","default");
		});

	}






	$scope.getCorporaciones = function()
	{
		//$("body").css("cursor","progress");
		$http.get("datos/getCorporaciones.php")
		.success(function(response,status,headers,config)
		{
			if(angular.isObject(response))
			{
				if(response.success)
				{
					$scope.corporaciones = response.data;
				}
				else
				{
					console.log("Error"+response.error);
				}
			}
			else
			{
				console.log("Error de formato json"+response);
			}
			//$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			//$("body").css("cursor","default");
		});
	}

	$scope.getRegiones = function()
	{
		//$("body").css("cursor","progress");
		$http.get("datos/getRegiones.php")
		.success(function(response,status,headers,config)
		{
			if(angular.isObject(response))
			{
				if(response.success)
				{
					$scope.regiones = response.data;
				}
				else
				{
					console.log("Error"+response.error);
				}
			}
			else
			{
				console.log("Error de formato json"+response);
			}
			//$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			//$("body").css("cursor","default");
		});
	}

	//Funcion para consultar todas las corporaciones y sus alumnos
	$scope.getAlumnos = function(pagina)
	{
		//$scope.pagination.current = pagina;
		//$("body").css("cursor","progress");
		$http.post("datos/getAlumnos.php",
		{
			"pagina":pagina,
			"porpagina":$scope.pagination.porpagina
		})
		.success(function(response,status,headers,config)
		{
			if(angular.isObject(response))
			{
				if(response.success)
				{
					$scope.pagination.total = response.data.total;
					$scope.alumnos = response.data.alumnos;
				}
				else
				{
					console.log("Error"+response.error);
				}
			}
			else
			{
				console.log("Error de formato json"+response);
			}
			//$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			//$("body").css("cursor","default");
		});

	}
	//Funcion para consultar todas las corporaciones y sus alumnos

	//Nuevo alumno
	$scope.btnNuevoAlumno_click = function()
	{

		$scope.showNuevoAlumno = (!$scope.showNuevoAlumno);
	
		$scope.newAlumno = { "ciudad" : 2,"nombre_ciudad":"CLCN" , "corporacion" : 1 , "sexo" : 1 , "fecha_nacimiento" : "01/01/2016" , "show" : true ,"guardar":false, "telefonos":[],"plan_estudio":1,"tipo":2,"prueba":false  };
		$scope.newAlumno.nombre = "";
		$scope.newAlumno.apellido1 = "";
		
	}
	
	$scope.btnGuardarNuevoAlumno_click = function()
	{

		datos = angular.fromJson($scope.newAlumno);
		$http.post("datos/setNuevoAlumno.php",
		{
			datos
		}).success(function(response,status,headers,config)
		{

			if(angular.isObject(response))
			{
				if(response.success)
				{
					$scope.alumnos.push(response.data);
					$scope.newAlumno = [];
					$scope.showNuevoAlumno = false
				}
				else
				{
					alert("setNuevoAlumno Error: "+response.error);
				}

			}
			else
			{
				alert("setNuevoAlumno Error json: "+response.error);
			}

		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
		});
	}

	$scope.outCiudades = function()
	{
		if($scope.newAlumno.nombre_ciudad != "") 
		{
			$scope.newAlumno.ciudad = "";
			$scope.newAlumno.ciudad = $filter('filter')($scope.ciudades, { 'nomenclatura': $scope.newAlumno.nombre_ciudad})[0].id;
		}
	}
	$scope.outRegiones = function()
	{
		if($scope.newAlumno.nombre_region != "") 
		{
			$scope.newAlumno.region="";
			$scope.newAlumno.region = $filter('filter')($scope.regiones, { 'nomenclatura': $scope.newAlumno.nombre_region, 'corporacion':$scope.newAlumno.corporacion })[0].id;
		}
	}

	$scope.btnVerificarNuevoAlumno_click = function()
	{

		datos = angular.fromJson($scope.newAlumno);
		$http.post("datos/setNuevoAlumnoVerificar.php",
		{
			datos
		}).success(function(response,status,headers,config)
		{
			if(angular.isObject(response)) 
			{
				$scope.newAlumno.guardar = response.success;
				if(!response.success) alert(response.error);
			}
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
		});
	}
	//Nuevo alumno

	//Boton de editar un alumno
	$scope.btnEditarAlumno_click = function(alumno)
	{
		$scope.alumno = alumno;
		$scope.alumno.guardar = true;
		$scope.btntabInformacion('personal');
		$scope.updatealumno();
	}
	//Boton de editar un alumno

	//Boton para eliminar a un alumno
	$scope.btnEliminarAlumno_click = function(alumno)
	{
		datos = angular.fromJson(alumno);
		$http.post("datos/delAlumno.php",
		{
			datos
		}).success(function(data,status,headers,config)
		{

			if(data == 1)
			{
				$scope.alumnos.splice($scope.alumnos.indexOf(alumno),1);
			}
			else
			{
				alert(data);
			}
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
		});

	}
	//Boton para eliminar a un alumno

	//Guardar alumno
	$scope.btnGuardarAlumno_click = function(alumno)
	{
		datos = angular.fromJson(alumno);
		$http.post("datos/upAlumno.php",
		{
			datos
		}).success(function(response,status,headers,config)
		{
			if(angular.isObject(response))
			{
				if(response.success)
				{
					alumno.guardar = null;
					$scope.alumno = null;
				}
				else
				{
					alumno.guardar = false;
					alumno.error = response.error;
					alert(alumno.error);
				}
			}
			else
			{
				alert("error de formato json "+ response);
			}
		})
		.error(function(err,status,headers,config)
		{
			alumno.guardar = false;
			alumno.error = err;
			console.log(err);
		});

	}
	//Guardar alumno

	//Boton para activar/desactivar
	$scope.btnActivoAlumno_click = function(alumno)
	{
		datos = angular.fromJson(alumno);
		$http.post("datos/suspAlumno.php",
		{
			datos
		}).success(function(data,status,headers,config)
		{

			if(data == 1)
			{
				alumno.activo = alumno.activo == 1 ? 0:1;

			}
			else
			{

			}
		})
		.error(function(err,status,headers,config)
		{

			console.log(err);
		});
	}
	//Boton para activar/desactivar

	



	$scope.getCiudades = function()
	{
		//$("body").css("cursor","progress");
		$http.get("datos/getCiudades.php")
		.success(function(response,status,headers,config)
		{
			if(angular.isObject(response))
			{
				if(response.success)
				{
					$scope.ciudades = response.data;
				}
				else
				{
					console.log("Error"+response.error);
				}
			}
			else
			{
				console.log("Error de formato json"+response);
			}
			//$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			//$("body").css("cursor","default");
		});
	}

	$scope.getEscuelas = function()
	{
		//$("body").css("cursor","progress");
		$http.get("datos/getEscuelas.php")
		.success(function(response,status,headers,config)
		{
			if(angular.isObject(response))
			{
				if(response.success)
				{
					$scope.escuelas = response.data;
				}
				else
				{
					console.log("Error "+response.error);
				}
			}
			else
			{
				console.log("Error de formato json"+response);
			}
			//$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			//$("body").css("cursor","default");
		});
	}


	$scope.getPlanEstudios = function()
	{
		//$("body").css("cursor","progress");
		$http.get("datos/getPlanEstudios.php")
		.success(function(response,status,headers,config)
		{
			if(angular.isObject(response))
			{
				if(response.success)
				{
					$scope.plan_estudios = response.data;
				}
				else
				{
					console.log("Error " + response.error);
				}
			}
			else
			{
				console.log("Error de formato json"+response);
			}
			//$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			//$("body").css("cursor","default");
		});
	}




	//Salir de session
	$scope.btnunlogin_click = function()
	{
		$http.get("datos/delLogin.php").success(function(data,status,headers,config)
		{
			$scope.corporaciones = [];
			$scope.estudiantes_tipo = [];
			$scope.persona = [];
			$scope.escuelas = [];
			$scope.plan_estudios = [];
			$scope.ciudades = [];
			$scope.regiones = [];

			$scope.limpiar();

		})
		.error(function(err,status,headers,config)
		{
			alert("Error "+err);
			console.log(err);
		});
	}
	//Salir de session

	//Entrar al login
	$scope.btnEntrar_click = function()
	{
		if($scope.persona.usuario.length > 0 && $scope.persona.contrasena.length > 0)
		{
			datos = angular.fromJson({"usuario":$scope.persona.usuario,"contrasena":$scope.persona.contrasena});
			$http.post("datos/setLogin.php",
			{
				datos
			}).success(function(data,status,headers,config)
			{
				if(angular.isObject(data))
				{
					$scope.persona.permisos = data['permisos'];
					$scope.persona.id = data['id'];
					if($scope.persona.permisos == 3)
						$window.location = "../adminayuda";	
					else if($scope.persona.permisos == 2)
					{

						$scope.getCorporaciones();
						$scope.getCiudades();
						$scope.getRegiones();
						$scope.getEstudiantestipo();
						$scope.getEscuelas();
						$scope.getPlanEstudios();
						$scope.getPuestos();
						$scope.getSucursales();
						$scope.getEstadosAlumnos();

					}
				}
				else
				{
					alert(data);
				}

			})
			.error(function(err,status,headers,config)
			{
				alert("Error ");
				console.log(err);
			});
		}
	}
	//Entrar al login
	
	$scope.btnShowEliminarRelacionMateria_click = function($relacion_item)
	{
		if($relacion_item.id > 0)
		{
			$scope.itemrelacion_eliminar = $relacion_item;
			$scope.showEliminarRelacionMateria = (!$scope.showEliminarRelacionMateria );

		}
		else
		{
			$scope.materias_relacion.splice($scope.materias_relacion.indexOf($relacion_item),1);
			$scope.mostrarmateriascorporacion = false;
		}
		
	}

	$scope.btnHideEliminarRelacionMateria_click = function()
	{
		$scope.showEliminarRelacionMateria = (!$scope.showEliminarRelacionMateria );
	}

	$scope.btnDelItemRelacion_click = function()
	{
		if( $scope.materias_relacion[$scope.materias_relacion.indexOf($scope.itemrelacion_eliminar)].id > 0 )
		{
			$http.post("datos/delRelacionMateriaAutoridad.php",{"id":$scope.materias_relacion[$scope.materias_relacion.indexOf($scope.itemrelacion_eliminar)].id })
			.success(function(response,status,headers,config)
			{
				if(angular.isObject(response))
				{
					if(response.success)
					{
						$scope.materias_relacion.splice($scope.materias_relacion.indexOf($scope.itemrelacion_eliminar),1);
						$scope.mostrarmateriascorporacion = false;
					}
					else
					{

						console.log(response);
						
					}
				}
				else alert("error de formato "+ response);
			})
			.error(function(err,status,headers,config)
			{
				console.log(err);
			});


		}
		else
		{
			$scope.materias_relacion.splice($scope.materias_relacion.indexOf($relacion_item),1);
			$scope.mostrarmateriascorporacion = false;	
		}
		$scope.showEliminarRelacionMateria = (!$scope.showEliminarRelacionMateria );
	}
	$scope.cancelar_relacion_change = function()
	{
		$scope.mostrarmateriascorporacion = false;

		$scope.materias_relacion = $scope.materias_relacion.filter(function(item){ return item.id  > 0 ;});
		//console.log($filter('filter')($scope.materias_relacion, { id: '10' },true));


	}
	


	$scope.btnGuardarMateriaRelacion_click = function($materia,$id_plan_estudio)
	{


		$scope.mostrarmateriascorporacion = (!$scope.mostrarmateriascorporacion);
		if($scope.mostrarmateriascorporacion)
		{
			$scope.materias_relacion.push( { "materia_corporacion":$materia,"id_plan_estudio":$id_plan_estudio } );
		}
		else
		{

			$http.post("datos/addRelacionMateriaAutoridad.php", { "id_materia_corporacion" : $scope.materias_relacion[$scope.materias_relacion.length - 1].materia_corporacion.id , "id_materia_autoridad" : $materia.id }
			).success(function(data,status,headers,config)
			{
				if(angular.isObject(data))
				{
					if(data.success)
					{
							
						$scope.materias_relacion[$scope.materias_relacion.length - 1].materia_autoridad = $materia;
						$scope.materias_relacion[$scope.materias_relacion.length - 1].id = data.id;
					}
					else
					{
						
					}
				}
				else
				{
					
				}

			})
			.error(function(err,status,headers,config)
			{
				console.log(err);
			});




		}



	}

	$scope.btnMostrarPlanEstudios_click = function ()
	{
		$scope.limpiar();
		$scope.btnMostrarPlanEstudios = true;

		//$("body").css("cursor","progress");
		$http.get("datos/getPlanEstudios.php")
		.success(function(response,status,headers,config)
		{
			if(response.success)
			{
				if(angular.isObject(response.data))
				{
					$scope.plan_estudios = response.data;
					
				}
				else
				{
					alert("Error de formato json: "+response.data);
				}
			}
			else
			{
				alert("Error de base de datos: "+ response.error);
			}
			////$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			////$("body").css("cursor","default");
		});
		
		$http.get("datos/getMaterias.php")
		.success(function(response,status,headers,config)
		{
			if(response.success)
			{
				if(angular.isObject(response.data))
				{
					$scope.materias = response.data;
				}
				else
				{
					alert("Error de formato json " + response.data);
				}
			}
			else
			{
				alert("Error de base de datos: "+ response.error);
			}

			////$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			////$("body").css("cursor","default");
		});
		$http.get("datos/getMateriasAutoridad.php")
		.success(function(response,status,headers,config)
		{
			if(response.success)
			{
				if(angular.isObject(response.data))
				{
					$scope.materias_autoridad = response.data;
				}
				else
				{
					alert("Error de formato json " + response.data);
				}
			}
			else
			{
				alert("Error de base de datos: "+ response.error);
			}

			////$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			////$("body").css("cursor","default");
		});

		$http.get("datos/getPlanEstudiosAutoridades.php")
		.success(function(response,status,headers,config)
		{
			if(response.success)
			{
				if(angular.isObject(response.data))
				{
					$scope.plan_estudios_autoridades = response.data;
					
				}
				else
				{
					alert("Error de formato json " + response.data);
				}
			}
			else
			{
				alert("Error de base de datos: "+ response.error);
			}

			////$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			////$("body").css("cursor","default");
		});

		$http.get("datos/getRelacionMateriasAutoridad.php")
		.success(function(response,status,headers,config)
		{
			if(response.success)
			{
				if(angular.isObject(response.data))
				{
					$scope.materias_relacion = response.data;
				}
				else
				{
					alert("Error de formato json " + response.data);
				}
			}
			else
			{
				alert("Error de base de datos: "+ response.error);
			}

			////$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			////$("body").css("cursor","default");
		});


	}

	//Mostrar profesores
	$scope.btnMostrarProfesores_click = function ()
	{
		$scope.limpiar();
		$scope.btnMostrarProfesores = true;

		//$("body").css("cursor","progress");
		$http.get("datos/getProfesores.php")
		.success(function(response,status,headers,config)
		{
			if(response.success)
			{
				if(angular.isObject(response.data))
				{
					$scope.profesores = response.data;
				}
				else
				{
					alert("Error de formato json: "+response.data);
				}
			}
			else
			{
				alert("Error de base de datos: "+ response.error);
			}
			//$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			//$("body").css("cursor","default");
		});
	}
	//Mostrar profesores

	//Boton para mostrar las materias
	$scope.btnMostrarMaterias_click= function()
	{
		$scope.limpiar();
		//$("body").css("cursor","progress");
		$http.get("datos/getMaterias.php")
		.success(function(response,status,headers,config)
		{
			if(response.success)
			{
				if(angular.isObject(response.data))
				{
					$scope.materias = response.data;
				}
				else
				{
					alert("Error de formato json " + response.data);
				}
			}
			else
			{
				alert("Error de base de datos: "+ response.error);
			}

			//$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			//$("body").css("cursor","default");
		});

	}
	//Boton para mostrar las materias

	$scope.btnMostrarActas_click= function()
	{

	}
	$scope.btnactafolio_click = function(acta)
	{
		$scope.actaseleccionada = acta;
	}

	//DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB 
	$scope.btnDGBAlumnos_click = function()
	{
		//$("body").css("cursor","progress");
		$scope.limpiar();
		$http.get("datos/getDGBAlumnos.php")
		.success(function(response,status,headers,config)
		{
			if(response.success)
			{
				if(angular.isObject(response.data))
				{
					$scope.dgb_alumnos = response.data;
				}
				else alert("Error de formato json " + response.data);
			}
			else alert(response.error);
			//$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			//$("body").css("cursor","default");
		});
	}
	$scope.btnDGBActas_click = function()
	{
		$scope.limpiar();
		//$("body").css("cursor","progress");
		$http.get("datos/getDGBActas.php")
		.success(function(response,status,headers,config)
		{
			if(response.success)
			{
				if(angular.isObject(response.data))
				{
					alert(response.data);
				}
				else
				{
					alert("Error de formato json "+ response.data);
				}
			}
			else
			{
				alert("Error de base de datos: " + response.error);
			}
			//$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			//$("body").css("cursor","default");
		});
	}
	$scope.btnDGBProfesores_click = function ()
	{
		$scope.limpiar();
		//$("body").css("cursor","progress");
		$http.get("datos/getDGBProfesores.php")
		.success(function(response,status,headers,config)
		{
			if(response.success)
			{
				if(angular.isObject(response.data))
				{
					$scope.profesores = response.data;
				}
				else
				{
					alert("Error de formato json: " + response.data);
				}
			}
			else
			{
				alert("Error de base de datos: "+ response.error);
			}
			//$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			//$("body").css("cursor","default");
		});
	}
	//DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB DGB

	//COBAES COBAES COBAES COBAES COBAES COBAES COBAES COBAES COBAES COBAES COBAES COBAES COBAES COBAES COBAES
	//Mostrar actas
	$scope.btnCobaesAlumnos_click = function()
	{
		//$("body").css("cursor","progress");
		$scope.limpiar();
		$http.get("datos/getCobaesAlumnos.php")
		.success(function(response,status,headers,config)
		{
			if(response.success)
			{
				if(angular.isObject(response.data))
				{
					$scope.cobaes_alumnos = response.data;
				}
				else alert("Error de formato json " + response.data);
			}
			else
			{
				alert(response.error);
			}
			//$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			//$("body").css("cursor","default");
		});
	}

	$scope.btnCobaesActas_click = function()
	{
		//$("body").css("cursor","progress");
		$scope.limpiar();
		$http.get("datos/getCobaesActas.php")
		.success(function(response,status,headers,config)
		{
			if(response.success)
			{
				if(angular.isObject(response.data))
				{
					$scope.cobaes_actas = response.data;
				}
				else alert("Error de formato json " + response.data);
			}
			else
			{
				alert(response.error);
			}
			//$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			//$("body").css("cursor","default");
		});

	}
	//Mostrar actas
	//Mostrar profesores
	$scope.btnCobaesProfesores_click = function ()
	{
		$scope.limpiar();
		//$("body").css("cursor","progress");
		$http.get("datos/getCobaesProfesores.php")
		.success(function(response,status,headers,config)
		{
			if(response.success)
			{
				if(angular.isObject(response.data))
				{
					$scope.profesores = response.data;
				}
				else
				{
					alert("Error de formato json: "+response.data);
				}
			}
			else
			{
				alert("Error de base de datos: "+ response.error);
			}
			//$("body").css("cursor","default");
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
			//$("body").css("cursor","default");
		});
	}


	$scope.chkNumeroEmpleado = function()
	{
		$http.post("datos/chkNumeroEmpleado.php",angular.fromJson({"numero_empleado":$scope.newAlumno.numero_empleado}))
		.success(function(response,status,headers,config)
		{
			if(angular.isObject(response))
			{
				if(response.success)
				{
					alert("Existe un usuario con el mismo numero de trabajador");
				}
			}
			else alert("error de formato "+ response);
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
		});
	}
	$scope.chkUsuarioDisponible = function()
	{
		$http.post("datos/chkUsuarioDisponible.php",angular.fromJson({"usuario":$scope.newAlumno.usuario}))
		.success(function(response,status,headers,config)
		{
			if(angular.isObject(response))
			{
				if(response.success)
				{
					$scope.newAlumno.usuario = $scope.newAlumno.usuario + response.data;
				}
				else
				{

				}
			}
			else alert("error de formato "+ response);
		})
		.error(function(err,status,headers,config)
		{
			console.log(err);
		});
	}
	//Mostrar profesores
	//COBAES COBAES COBAES COBAES COBAES COBAES COBAES COBAES COBAES COBAES COBAES COBAES COBAES COBAES COBAES 
	$scope.cambio_sexo = function(alumno)
	{
		alumno.sexo = !alumno.sexo;
		alumno.guardar = true;
	}
	$scope.snort = function(key)
	{
		$scope.snortKey = key;
		$scope.reverse = !$scope.reverse;
	}
	$scope.onKeyPress = function ($event)
	{
      //$scope.onKeyPressResult = getKeyboardEventResult($event, "Key press");
      $scope.newAlumno.usuario = $scope.newAlumno.nombre + $scope.newAlumno.apellido1;
    };
    $scope.onKeyDown = function ($event)
    {
      //$scope.onKeyDownResult = getKeyboardEventResult($event, "Key down");
      $scope.newAlumno.usuario = $scope.newAlumno.nombre + $scope.newAlumno.apellido1;
    };



	$scope.btntabInformacion = function(tab)
	{
		$scope.tab_alumno = tab;
		if(tab == 'academica')
		{
			datos = angular.fromJson({"id_alumno":$scope.alumno.id});
			$http.post("datos/getCalificaciones.php",
			{
				datos
			}).success(function(response,status,headers,config)
			{
				if(response.success)
				{
					if(angular.isObject(response.data))
					{
						$scope.calificaciones = response.data;
					}
					else
					{
						alert("Error en el formato json: " +response.data);
					}
				}
				else
				{
					alert("Error de base de datos: "+ response.error);
				}
			})
			.error(function(err,status,headers,config)
			{
				alert(err);
				console.log(err);
			});
		}
		else if(tab == 'boleta')
		{
			//$("body").css("cursor","progress");
			var datos = {id_alumno:$scope.alumno.id};
			$http.post("datos/getBoleta.php",
				datos
			).success(function(response,status,headers,config)
			{
				if(response.success)
				{
					if(angular.isObject(response.data))
					{
						$scope.materiasBol = response.data;
						var periodo = 0;
						var per_idx = 0;
						for (var indice = 0; indice < $scope.materiasBol.length; indice++)
						{
							if(periodo!= $scope.materiasBol[indice].periodo)
							{
								periodo = $scope.materiasBol[indice].periodo;
								$scope.periodosBol[parseInt(periodo)-1] = periodo;
							}
						}
					}
					else
					{
						alert("Error de formato json: "+response.data);
					}
				}
				else
				{
					alert("Error de base de datos: "+response.error);
				}
				//$("body").css("cursor","default");
			})
			.error(function(err,status,headers,config)
			{
				alert(err);
				console.log(err);
				//$("body").css("cursor","default");
			});
		}//boleta
	}


	//----------------------------------------------------------------
	//Versión para sistema de reportes desarrollador por roberto vega
	$scope.btnMostrarPlanEstudios_click();
	//Versión para sistema de reportes desarrollador por roberto vega
	//----------------------------------------------------------------

});

app.directive('modal', function ()
{
    return {
      template: '<div class="modal fade">' +
          '<div class="modal-dialog modal-lg">' +
            '<div class="modal-content">' +
              '<div class="modal-header">' +
                '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
                '<h4 class="modal-title" ng-bind="title"></h4>' +
              '</div>' +
              '<div class="modal-body" ng-transclude></div>' +
            '</div>' +
          '</div>' +
        '</div>',
      restrict: 'E',
      transclude: true,
      replace:true,
      scope:true,
      link: function postLink(scope, element, attrs)
      {
        scope.title = attrs.title;
        scope.$watch(attrs.visible, function(value)
        {
          $(element).modal(value ? 'show':'hide');
        });
        $(element).on('shown.bs.modal', function()
        {
        	/*
          scope.$apply(function()
          {
            scope.$parent[attrs.visible] = true;
          });
          */
        });
        $(element).on('hidden.bs.modal', function()
        {
        /*
          scope.$apply(function()
          {
          	alert('hide');
            scope.$parent[attrs.visible] = false;
          });
			*/
        });
      }
    };
});

app.directive('modalHeader', function(){
    return {
        template:'<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">{{title}}</h4></div>',
        replace:true,
        restrict: 'E',
        scope: {title:'@'}
    };
});

app.directive('modalBody', function(){
    return {
        template:'<div class="modal-body" ng-transclude></div>',
        replace:true,
        restrict: 'E',
        transclude: true
    };
});

app.directive('modalFooter', function(){
    return {
        template:'<div class="modal-footer" ng-transclude></div>',
        replace:true,
        restrict: 'E',
        transclude: true
    };
});

app.directive('modalmateriarelacion', function ()
{
    return {
      template: '<div class="modal fade">' +
          '<div class="modal-dialog modal-lg">' +
            '<div class="modal-content">' +
              '<div class="modal-header">' +
                '<button type="button" class="close" data-dismiss="modal" aria-hidden="true" ng-click="btnHideEliminarRelacionMateria_click()">&times;</button>' +
                '<h4 class="modal-title" ng-bind="title"></h4>' +
              '</div>' +
              '<div class="modal-body" ng-transclude></div>' +
            '</div>' +
          '</div>' +
        '</div>',
      restrict: 'E',
      transclude: true,
      replace:true,
      scope:true,
      link: function postLink(scope, element, attrs)
      {

        scope.title = attrs.title;
        $(element).modal({show: false,backdrop:'static'});

        scope.$watch(attrs.visible, function(value)
        {
          $(element).modal(value ? 'show':'hide');

        });
      }
    };
});