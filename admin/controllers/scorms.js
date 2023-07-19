$( document ).ready(function() {
	
		$(".btn_menu_filtros").click(function(e) { //TOGGLE PARA EL MENU
		    $(".filtro_avanzado").fadeToggle('fast');
		});

		$("#btn_form_s_search").click(function(){
				GetScorms();
		});

		$("#btn_form_s_crear").click(function(){ // form crear
			scormUpload.update({formData:{ 
					request: 'InsertScorm',
					data: getFormData($("#form_s_crear"))
				}});
			scormUpload.startUpload();
		});

		
		$("#btn_form_s_editar").click(function(){ // form editar
			SendAjax("form_s_editar",'UpdateScorm',function(result) {
				GetScorms();
				$("#modal_s_editar").modal('hide');
			});
		});

		
		$("#btn_form_s_upload").click(function(){ // form upload new scorm .zip
			scormUpload2.update({formData:{ 
					request: 'UploadScorm',
					data: getFormData($("#form_s_upload"))
				}});
			scormUpload2.startUpload();
		});

		$("#btn_form_s_eliminar").click(function(){ // form 
			SendAjax("form_s_eliminar",'DeleteScorm',function(result) {
				GetScorms();
				$("#modal_s_eliminar").modal('hide');
			});
		});

		$("#form_s_id_plan_estudio").change(function(){ // id_plan 
			GetTbMaterias($(this).val());
		});


var scormUpload2 = $("#fileuploader2").uploadFile({
		url:"php/ajaxHandler.php",
		multiple:false,
		dragDrop:false,
		maxFileCount:1,
		autoSubmit:false,
		fileName: "scorm_zip",
		dynamicFormData: function()
		{
				var data = { 
					request: 'UploadScorm',
					data: getFormData($("#form_s_upload"))
				};
				return data;
		},
		onSuccess:function(files,data,xhr,pd)
		{
		    //files: list of files
		    //data: response from server
		    //xhr : jquer xhr object
		    $("#btn_form_s_upload").removeAttr('disabled');
		    alert("Paquete Scorm cargado correctamente");
		   scormUpload2.reset();
		    GetScormFiles($("#form_s_upload_id_scorm").val());
			//$("#modal_s_upload").modal('hide');


		},
		onSubmit:function(files)
		{
			$("#btn_form_s_upload").attr('disabled','disabled');
		}
		,
		onError: function(files,status,errMsg,pd)
		{
		    //files: list of files
		    //status: error status
		    //errMsg: error message
		    $("#btn_form_s_upload").removeAttr('disabled');
		   	alert("No se pudo cargar este archivo scorm: "+errMsg);

		},
		onCancel: function(files,pd)
		{
			$("#btn_form_s_upload").removeAttr('disabled');
		    alert("Carga de scorm cancelada");
		}
}); 



var scormUpload= $("#fileuploader").uploadFile({
		url:"php/ajaxHandler.php",
		multiple:false,
		dragDrop:false,
		maxFileCount:1,
		autoSubmit:false,
		fileName: "scorm_zip",
		dynamicFormData: function()
		{
				var data = { 
					request: 'InsertScorm',
					data: getFormData($("#form_s_crear"))
				};
				return data;
		},
		onSuccess:function(files,data,xhr,pd)
		{
		    //files: list of files
		    //data: response from server
		    //xhr : jquer xhr object
		    $("#btn_form_s_crear").removeAttr('disabled');
		    alert("scorm guardado correctamente ");
		   scormUpload.reset();
		    GetScorms();
			$("#modal_s_crear").modal('hide');

		},
		onSubmit:function(files)
		{
			$("#btn_form_s_crear").attr('disabled','disabled');
		},
		onError: function(files,status,errMsg,pd)
		{
		    //files: list of files
		    //status: error status
		    //errMsg: error message
		    $("#btn_form_s_crear").removeAttr('disabled');
		   alert("No se pudo cargar este archivo scorm: "+errMsg);

		},
		onCancel: function(files,pd)
		{
			$("#btn_form_s_crear").removeAttr('disabled');
		    alert("Carga de scorm cancelada");
		}
}); 

function RefreshScorms(scormsArray){
	
		var html_scorms="";
		if(scormsArray.length==0 || scormsArray==null || scormsArray===undefined){
			html_scorms+='<tr  class="text-center" >';
            html_scorms+='	<td colspan="11" >No se encontraron Registros </td>'; 
            html_scorms+='</tr>';
		}else{
			for (var i = 0; i < scormsArray.length; i++) {
				html_scorms+='<tr>';
	            html_scorms+='	<td item-index="'+i+'" >'+scormsArray[i]['id']+'</td>'; 
	            html_scorms+='	<td item-index="'+i+'" >'+scormsArray[i]['nombre']+'</td>';
	            html_scorms+='	<td item-index="'+i+'" >'+scormsArray[i]['id_materia']+'</td>';
	           	html_scorms+='	<td item-index="'+i+'" >'+scormsArray[i]['scoid']+'</td>';
	           	html_scorms+='	<td item-index="'+i+'" ><a target="_blank" href="http://agcollege.edu.mx/cereporte/modules/scorm/uploads/scorms/'+scormsArray[i]['url']+'" >'+scormsArray[i]['url']+'</a></td>';
	           	html_scorms+='	<td item-index="'+i+'" ><a target="_blank" href="http://agcollege.edu.mx/cereporte/modules/scorm/scormplayer2/scormlib/rte.php?userid=1&SCOInstanceID='+scormsArray[i]['id']+'&SCO=none" >Reproducir</a></td>';

	            html_scorms+='	<td>';
	            html_scorms+='		<button item-index="'+i+'"  class="btn btn-default btn_s_editar" type="button" ><span class="glyphicon glyphicon-edit"></span></button>';  
	            html_scorms+='		<button item-index="'+i+'"  class="btn btn-default btn_s_upload" type="button" ><span class="glyphicon glyphicon-open-file"></span></button>';  
	            html_scorms+='		<button item-index="'+i+'"  class="btn btn-danger btn_s_eliminar" type="button" ><span class="glyphicon glyphicon-remove"></span></button>';  

	           // html_scorms+='		<button item-index="'+i+'" class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal_s_eliminar" ><span class="glyphicon glyphicon-trash"></span></button>'; 
	            html_scorms+='	</td>';
	            html_scorms+='</tr>';
			}			
		}

		$("#tabla_scorms").empty().append(html_scorms); // refresca la tabla con nuevos registros
		$(".btn_s_editar").click(function(){
			var idx_current_scorm=$(this).attr('item-index');
			$("#form_s_editar_id_scorm").val(scormsArray[idx_current_scorm]['id']);
			$("#form_s_editar_nombre").val(scormsArray[idx_current_scorm]['nombre']);
			$("#form_s_editar_scoid").val(scormsArray[idx_current_scorm]['scoid']);
			$("#form_s_editar_id_materia").val(scormsArray[idx_current_scorm]['id_materia']);
			$("#modal_s_editar").modal('show');
		});

		$(".btn_s_upload").click(function(){
			var idx_current_scorm=$(this).attr('item-index');
			$("#form_s_upload_id_scorm").val(scormsArray[idx_current_scorm]['id']);
			GetScormFiles(scormsArray[idx_current_scorm]['id']);
			$("#modal_s_upload").modal('show');

		});

		$(".btn_s_eliminar").click(function(){
			var idx_current_scorm=$(this).attr('item-index');
			$("#form_s_eliminar_id_scorm").val(scormsArray[idx_current_scorm]['id']);
			$("#modal_s_eliminar").modal('show');
		});


	}


function RefreshScormsFiles(scormsArray){
	
		var html_scorms="";
		if(scormsArray.length==0 || scormsArray==null || scormsArray===undefined){
			html_scorms+='<tr  class="text-center" >';
            html_scorms+='	<td colspan="11" >No se encontraron Registros </td>'; 
            html_scorms+='</tr>';
		}else{
			for (var i = 0; i < scormsArray.length; i++) {
				html_scorms+='<tr>';
	            html_scorms+='	<td   item-index="'+i+'"  >'+scormsArray[i]['id']+'</td>'; 
	            html_scorms+='	<td   item-index="'+i+'"  ><a target="_blank" href="http://agcollege.edu.mx/cereporte/modules/scorm/uploads/scorms/'+scormsArray[i]['url']+'/'+scormsArray[i]['url_scorm']+'" >'+scormsArray[i]['url_scorm']+'</a></td>';
	           	html_scorms+='	<td   item-index="'+i+'"  ><a target="_blank" href="http://agcollege.edu.mx/cereporte/modules/scorm/players/'+scormsArray[i]['url']+'/'+scormsArray[i]['url_player']+'/res" >Reproducir</a></td>';
	            html_scorms+='	<td >';
	           
	           if(scormsArray[i]['status']==0){
	            	html_scorms+='<form id="form_sf_change_'+i+'" name="form_sf_change_'+i+'" ><input id="id_scorm_'+i+'" name="id_scorm" type="hidden" value="'+scormsArray[i]['id_scorm']+'" > <input id="id_scorm_file_'+i+'" name="id_scorm_file" type="hidden" value="'+scormsArray[i]['id']+'" ></form>		<button item-index="'+i+'"  class="btn btn-default btn_sf_change" type="button" ><span class="glyphicon glyphicon-unchecked"></span></button>';  
	           }else{
	         		html_scorms+='		<button item-index="'+i+'"  class="btn btn-success" type="button" >Scorm Activo <span class="glyphicon glyphicon-check"></span></button>';  
	           }

	            html_scorms+='	</td>';
	            html_scorms+='</tr>';
			}			
		}

		$("#tabla_scormsfiles").empty().append(html_scorms); // refresca la tabla con nuevos registros

		$(".btn_sf_change").click(function(){
			var idx_current_scorm=$(this).attr('item-index');
			var id_scorm= scormsArray[idx_current_scorm]['id_scorm'];

			 SendAjax("form_sf_change_"+idx_current_scorm,'ChangeScormFile',function(result) {
				GetScormFiles(id_scorm);
			});


		});

	}


	function GetScorms(){ //function que llama al ajax para obtener scorms para los combobox
        var data_ajax={
					scorm:$("#form_s_search_scorm").val()
		};
        GetAjax(data_ajax,"GetScorms",function(scormsArray){
        	RefreshScorms(scormsArray);
        	$("#form_s_search_scorm").val("");
        });
	}
	
	function GetScormFiles(ids){
		var data_ajax={
			id_scorm:ids
		};
		GetAjax(data_ajax,"GetScormFiles",function(scormsArray){
        	RefreshScormsFiles(scormsArray);
        	GetScorms();
        });
	}


	function GetPlanEstudios(){
		var data_ajax={
		};
		GetAjax(data_ajax,"GetPlanEstudios",function(plansArray){
        	RefreshComboBox("form_s_id_plan_estudio",plansArray,'id','nombre');
        	GetTbMaterias(plansArray[0]['id']);
        });
	}


	function GetTbMaterias(id_plan){
		var data_ajax={
			id_plan_estudio: id_plan
		};
		GetAjax(data_ajax,"GetTbMaterias",function(matArray){
        	RefreshComboBox("form_s_id_materia",matArray,'id','nombre');
        });
	}

	function InitializeScorms(){ // trae los scorms en cuanto carga
		 GetPlanEstudios();
		 GetScorms();
	}

	InitializeScorms();
});