$( document ).ready(function() {
	
	$(".btn_menu_filtros").click(function(e) { //TOGGLE PARA EL MENU
     
        $(".filtro_avanzado").fadeToggle('fast');
	});

		$("#btn_form_search").click(function(){
				GetAreas();

		});

		$("#btn_form_a_crear").click(function(){ // form crear
			SendAjax("form_a_crear",'InsertArea',function(result) {
					GetAreas();
					$("#modal_a_crear").modal('hide');

			});

		});


		$("#btn_form_a_editar").click(function(){ // form editar
			SendAjax("form_a_editar",'UpdateArea',function(result) {
					$("#modal_a_editar").modal('hide');
					GetAreas();
			});			
		});

	function RefreshAreas(areasArray){
		var html_areas="";

		if(areasArray.length==0 || areasArray==null || areasArray===undefined){
			html_areas+='<tr  class="text-center" >';
            html_areas+='	<td colspan="11" >No se encontraron Registros </td>'; 
            html_areas+='</tr>';
		}else{
			for (var i = 0; i < areasArray.length; i++) {
				html_areas+='<tr>';
	            html_areas+='	<td   item-index="'+i+'"  >'+areasArray[i]['id']+'</td>'; 
	            html_areas+='	<td   item-index="'+i+'"  >'+areasArray[i]['descripcion']+'</td>'; 
	            if(areasArray[i]['estatus']=="A"){
	           		html_areas+='	<td   item-index="'+i+'"  ><label class="label label-success">'+areasArray[i]['estatus']+'</label></td>'; 
	            }else{
	           		html_areas+='	<td   item-index="'+i+'"  ><label class="label label-default">'+areasArray[i]['estatus']+'</label></td>'; 
	            }
	            html_areas+='	<td   item-index="'+i+'"  >'+areasArray[i]['orden']+'</td>'; 

	            html_areas+='	<td >';
	            html_areas+='		<button item-index="'+i+'"  class="btn btn-default btn_a_editar" type="button" ><span class="glyphicon glyphicon-edit"></span></button>';  
	           // html_areas+='		<button item-index="'+i+'" class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal_a_eliminar" ><span class="glyphicon glyphicon-trash"></span></button>'; 
	            html_areas+='	</td>';
	            html_areas+='</tr>';
			}			
		}

		$("#tabla_areas").empty().append(html_areas); // refresca la tabla con nuevos registros
		$(".btn_a_editar").click(function(){
			var idx_current_area=$(this).attr('item-index');
			$("#form_a_editar_id_area").val(areasArray[idx_current_area]['id']);
			$("#form_a_editar_descripcion").val(areasArray[idx_current_area]['descripcion']);
			$("#form_a_editar_estatus").val(areasArray[idx_current_area]['estatus']);
			$("#form_a_editar_orden").val(areasArray[idx_current_area]['orden']);
			$("#modal_a_editar").modal('show');

		});
	}
	function GetAreas(){ //function que llama al ajax para obtener areas para los combobox
        var data_ajax={
					area:$("#form_a_search_area").val()
				};
		        GetAjax(data_ajax,"GetAreas",function(areasArray){

		        	RefreshAreas(areasArray);
		        	$("#form_a_search_area").val("");
		        });
	}
		

	function InitializeAreas(){ // trae los areas en cuanto carga

		 GetAreas();
	}

	InitializeAreas();
});