$( document ).ready(function() {
	
	$(".btn_menu_filtros").click(function(e) { //TOGGLE PARA EL MENU
     
        $(".filtro_avanzado").fadeToggle('fast');
	});


		$("#btn_form_p_search").click(function(){
				GetProblematicas();

		});

		$("#btn_form_p_crear").click(function(){ // form crear
			SendAjax("form_p_crear",'InsertProblematica',function(result) {
				$("#modal_p_crear").modal('hide');
					GetProblematicas();
			});

		});


		$("#btn_form_p_editar").click(function(){ // form editar
			SendAjax("form_p_editar",'UpdateProblematica',function(result) {
				$("#modal_p_editar").modal('hide');
					GetProblematicas();
			});			
		});

	function RefreshProblematicas(problematicasArray){
		var html_problematicas="";

		if(problematicasArray.length==0 || problematicasArray==null || problematicasArray===undefined){
			html_problematicas+='<tr  class="text-center" >';
            html_problematicas+='	<td colspan="11" >No se encontraron Registros </td>'; 
            html_problematicas+='</tr>';
		}else{
			for (var i = 0; i < problematicasArray.length; i++) {
				html_problematicas+='<tr>';
	            html_problematicas+='	<td   item-index="'+i+'"  >'+problematicasArray[i]['id']+'</td>'; 
	            html_problematicas+='	<td   item-index="'+i+'"  >'+problematicasArray[i]['nombre']+'</td>'; 
	            if(problematicasArray[i]['estatus']==1){
	           		html_problematicas+='	<td   item-index="'+i+'"  ><label class="label label-success">A</label></td>'; 
	            }else{
	           		html_problematicas+='	<td   item-index="'+i+'"  ><label class="label label-default">B</label></td>'; 
	            }

	            html_problematicas+='	<td   item-index="'+i+'"  >'+problematicasArray[i]['categoria_nombre']+'</td>'; 
	            html_problematicas+='	<td   item-index="'+i+'"  >'+problematicasArray[i]['area_nombre']+'</td>'; 
	            html_problematicas+='	<td   item-index="'+i+'"  >'+problematicasArray[i]['plan_nombre']+'</td>'; 
	            html_problematicas+='	<td   item-index="'+i+'"  >'+problematicasArray[i]['fecha_alta']+'</td>'; 
	            html_problematicas+='	<td >';
	            html_problematicas+='		<button item-index="'+i+'"  class="btn btn-default btn_p_editar" type="button" ><span class="glyphicon glyphicon-edit"></span></button>';  
	           // html_problematicas+='		<button item-index="'+i+'" class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal_p_eliminar" ><span class="glyphicon glyphicon-trash"></span></button>'; 
	            html_problematicas+='	</td>';
	            html_problematicas+='</tr>';
			}			
		}

		$("#tabla_problematicas").empty().append(html_problematicas); // refresca la tabla con nuevos registros
		$(".btn_p_editar").click(function(){
			var idx_current_problematica=$(this).attr('item-index');
			$("#form_p_editar_id_problematica").val(problematicasArray[idx_current_problematica]['id']);
			$("#form_p_editar_nombre").val(problematicasArray[idx_current_problematica]['nombre']);
			$("#form_p_editar_estatus").val(problematicasArray[idx_current_problematica]['estatus']);
			$("#form_p_editar_id_categoria").val(problematicasArray[idx_current_problematica]['id_categoria']);
			$("#form_p_editar_id_area").val(problematicasArray[idx_current_problematica]['id_area']);
			$("#form_p_editar_id_plan_estudios").val(problematicasArray[idx_current_problematica]['id_plan_estudios']);

			$("#modal_p_editar").modal('show');

		});
	}
	function GetProblematicas(){ //function que llama al ajax para obtener problematicas para los combobox
        var data_ajax={
					problematica:$("#form_p_search_problematica").val()
				};
		        GetAjax(data_ajax,"GetProblematicas",function(problematicasArray){

		        	RefreshProblematicas(problematicasArray);
		        	$("#form_p_search_problematica").val("");
		        });
	}
		
	function GetCategorias(){ //function que llama al ajax para obtener categorias para los combobox
    
		        GetAjax([],"GetCategorias",function(categoriasArray){

		        	RefreshComboBox("form_p_editar_id_categoria",categoriasArray,'id','nombre');
		        	RefreshComboBox("form_p_crear_id_categoria",categoriasArray,'id','nombre');
		        });
	}

	function GetAreas(){ //function que llama al ajax para obtener area para los combobox
    
		        GetAjax([],"GetAreas",function(areasArray){
		        	RefreshComboBox("form_p_editar_id_area",areasArray,'id','descripcion');
		        	RefreshComboBox("form_p_crear_id_area",areasArray,'id','descripcion');
		        });
	}
	function GetPlanEstudios(){ //function que llama al ajax para obtener plan_estudio para los combobox
    
		        GetAjax([],"GetPlanEstudios",function(plan_estudiosArray){
		        	RefreshComboBox("form_p_editar_id_plan_estudios",plan_estudiosArray,'id','nombre');
		        	RefreshComboBox("form_p_crear_id_plan_estudios",plan_estudiosArray,'id','nombre');
		        });
	}				
	function InitializeProblematicas(){ // trae los problematicas en cuanto carga

		 GetProblematicas();
		 GetAreas();
		 GetCategorias();
		 GetPlanEstudios();
	}

	InitializeProblematicas();




});