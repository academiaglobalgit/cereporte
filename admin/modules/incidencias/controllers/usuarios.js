$( document ).ready(function() {
	var usuarios=[];
	var idx_current_usuario=0;

	function RefreshUsuarios(usuariosArray){
		var html_usuarios="";

		if(usuariosArray.length==0 || usuariosArray==null || usuariosArray===undefined){
			html_usuarios+='<tr  class="text-center" >';
            html_usuarios+='	<td colspan="11" >No Se encontraron Registros </td>'; 
            html_usuarios+='</tr>';
            usuarios=[];
		}else{
			usuarios=usuariosArray;
			for (var i = 0; i < usuariosArray.length; i++) {
				html_usuarios+='<tr>';
	            html_usuarios+='	<td   item-index="'+i+'"  >'+usuariosArray[i]['id']+'</td>'; 
	            html_usuarios+='	<td   item-index="'+i+'"  >'+usuariosArray[i]['nombre_completo']+'</td>'; 
	            html_usuarios+='	<td   item-index="'+i+'"  >'+usuariosArray[i]['username']+'</td>'; 

	            if(usuariosArray[i]['estatus']=="A"){
	           		html_usuarios+='	<td   item-index="'+i+'"  ><label class="label label-success">'+usuariosArray[i]['estatus']+'</label></td>'; 
	            }else{
	           		html_usuarios+='	<td   item-index="'+i+'"  ><label class="label label-default">'+usuariosArray[i]['estatus']+'</label></td>'; 
	            }
	            
	            html_usuarios+='	<td   item-index="'+i+'"  >'+usuariosArray[i]['nombre_permiso']+'</td>'; 
	           	html_usuarios+='	<td  class="active" item-index="'+i+'"  >'+usuariosArray[i]['nombre_area']+'</td>'; 
	            html_usuarios+='	<td   item-index="'+i+'"  >'+usuariosArray[i]['fecha_alta']+'</td>'; 
	            html_usuarios+='	<td >';
	            html_usuarios+='		<button item-index="'+i+'"  class="btn btn-default btn_u_editar" type="button" ><span class="glyphicon glyphicon-edit"></span></button>';  
	           // html_usuarios+='		<button item-index="'+i+'" class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal_u_eliminar" ><span class="glyphicon glyphicon-trash"></span></button>'; 

	            html_usuarios+='	</td>';
	            html_usuarios+='</tr>';
			}			
		}

		$("#tabla_usuarios").empty().append(html_usuarios); // refresca la tabla con nuevos registros

		$(".btn_u_editar").click(function(e) { //botton para el MODAL PARA EDITAR EL REGISTRO
			idx_current_usuario=$(this).attr('item-index');
			$("#form_u_editar_id_usuario").val(usuariosArray[idx_current_usuario]['id']);			
			$("#form_u_editar_usuario").val(usuariosArray[idx_current_usuario]['username']);			
			$("#form_u_editar_nombre").val(usuariosArray[idx_current_usuario]['nombre']);
			$("#form_u_editar_apellidop").val(usuariosArray[idx_current_usuario]['apellidop']);
			$("#form_u_editar_apellidom").val(usuariosArray[idx_current_usuario]['apellidom']);
			$("#form_u_editar_permiso").val(usuariosArray[idx_current_usuario]['id_permiso']);
			$("#form_u_editar_area").val(usuariosArray[idx_current_usuario]['id_area']);
			$("#form_u_editar_estatus").val(usuariosArray[idx_current_usuario]['estatus']);
	        $("#modal_u_editar").modal('show');
		});
	}

	$(".btn_menu_filtros").click(function(e) { //TOGGLE PARA EL MENU
        $(".filtro_avanzado").fadeToggle('fast');
	});

	$("#btn_form_u_crear").click(function(e) { //BTN FORM CREAR USUARIO
        SendAjax("form_u_crear","InsertUsuario",function(){
        	 $("#modal_u_crear").modal('hide');
        	 GetUsuarios();
        });
	});


	$("#btn_form_u_editar").click(function(e) { //BTN FORM EDITAR USUARIO
        SendAjax("form_u_editar","UpdateUsuario",function(){
        	 $("#modal_u_editar").modal('hide');
        	 GetUsuarios();
        });
	});



	$("#btn_form_u_search").click(function(e) { //BTN FILTRO BUSCAR USUARIO
         GetUsuarios();
	});

	function GetUsuarios(){ //function que llama al ajax para obtener los usuarios
		var data_ajax={
			nombre:$("#form_u_search_usuario").val()
		};
        GetAjax(data_ajax,"GetUsuarios",function(usuariosArray){

        	RefreshUsuarios(usuariosArray);
        	$("#form_u_search_usuario").val("");
        });
	}


	function GetAreasActivas(){ //function que llama al ajax para obtener areas para los combobox
		
        GetAjax([],"GetAreasActivas",function(resultArray){

        	RefreshComboBox("form_u_crear_area",resultArray,"id","descripcion");
        	RefreshComboBox("form_u_editar_area",resultArray,"id","descripcion");

        });
	}

	function GetPermisos(){ //function que llama al ajax para obtener areas para los combobox
		
        GetAjax([],"GetPermisos",function(resultArray){

        	RefreshComboBox("form_u_crear_permiso",resultArray,"id","descripcion");
        	RefreshComboBox("form_u_editar_permiso",resultArray,"id","descripcion");

        });
	}


	function InitializeUsuarios(){ // trae los usuarios en cuanto carga y rellena los combobox para los formularios
		GetUsuarios();
		GetPermisos();
		GetAreasActivas();
	}

	InitializeUsuarios(); //INICIALIZA TODO LO NECESARIO

});