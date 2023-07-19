$( document ).ready(function() {
	
		$(".btn_menu_filtros").click(function(e) { //TOGGLE PARA EL MENU
		    $(".filtro_avanzado").fadeToggle('fast');
		});

		$("#btn_form_c_search").click(function(){
				GetCategorias();
		});

		$("#btn_form_c_crear").click(function(){ // form crear
			SendAjax("form_c_crear",'InsertCategoria',function(result) {
					GetCategorias();
				$("#modal_c_crear").modal('hide');
			});
		});

		$("#btn_form_c_editar").click(function(){ // form editar
			SendAjax("form_c_editar",'UpdateCategoria',function(result) {
					GetCategorias();
					$("#modal_c_editar").modal('hide');
			});			
		});

function Refreshcategorias(categoriasArray){
		var html_categorias="";
		if(categoriasArray.length==0 || categoriasArray==null || categoriasArray===undefined){
			html_categorias+='<tr  class="text-center" >';
            html_categorias+='	<td colspan="11" >No se encontraron Registros </td>'; 
            html_categorias+='</tr>';
		}else{
			for (var i = 0; i < categoriasArray.length; i++) {
				html_categorias+='<tr>';
	            html_categorias+='	<td   item-index="'+i+'"  >'+categoriasArray[i]['id']+'</td>'; 
	            html_categorias+='	<td   item-index="'+i+'"  >'+categoriasArray[i]['nombre']+'</td>'; 
	            if(categoriasArray[i]['tipo_incidencia']==1){
	            	html_categorias+='	<td   item-index="'+i+'"  class="active" >Externa</td>'; 

	            }else{
	            	html_categorias+='	<td   item-index="'+i+'"     >Interna</td>'; 

	            }


	            html_categorias+='	<td >';
	            html_categorias+='		<button item-index="'+i+'"  class="btn btn-default btn_c_editar" type="button" ><span class="glyphicon glyphicon-edit"></span></button>';  
	           // html_categorias+='		<button item-index="'+i+'" class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal_c_eliminar" ><span class="glyphicon glyphicon-trash"></span></button>'; 
	            html_categorias+='	</td>';
	            html_categorias+='</tr>';
			}			
		}

		$("#tabla_categorias").empty().append(html_categorias); // refresca la tabla con nuevos registros
		$(".btn_c_editar").click(function(){
			var idx_current_categoria=$(this).attr('item-index');
			$("#form_c_editar_id_categoria").val(categoriasArray[idx_current_categoria]['id']);
			$("#form_c_editar_nombre").val(categoriasArray[idx_current_categoria]['nombre']);
			$("#form_c_editar_tipo").val(categoriasArray[idx_current_categoria]['tipo_incidencia']);
			$("#modal_c_editar").modal('show');
		});
	}

	function GetCategorias(){ //function que llama al ajax para obtener categorias para los combobox
        var data_ajax={
					categoria:$("#form_c_search_categoria").val()
				};
		        GetAjax(data_ajax,"GetCategorias",function(categoriasArray){
		        	Refreshcategorias(categoriasArray);
		        	$("#form_c_search_categoria").val("");
		        });
	}
		

	function Initializecategorias(){ // trae los categorias en cuanto carga
		 GetCategorias();
	}

	Initializecategorias();
});