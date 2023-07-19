$( document ).ready(function() {


	$("#btn_form_s_search").click(function(){
			GetScormsTracks();
	});

	$("#btn_form_s_eliminar").click(function(){
			SendAjax("form_s_search",'DeleteScormsTracks',function(result) {
				GetScormsTracks();
				$("#modal_s_eliminar").modal('hide');
			});
	});



	function GetScormsTracks(){ //function que llama al ajax para obtener scorms para los combobox
        var data_ajax=
        {
			scormid:$("#form_s_search_scormid").val(),
			userid:$("#form_s_search_userid").val()

		};
        GetAjax(data_ajax,"GetScormsTracks",function(scormsArray){
        	RefreshScormsTracks(scormsArray);
        });
	}

	function RefreshScormsTracks(scormsArray){
	
		var html_scorms="";
		if(scormsArray.length==0 || scormsArray==null || scormsArray===undefined){
			html_scorms+='<tr  class="text-center" >';
            html_scorms+='	<td colspan="11" >No se encontraron Registros </td>'; 
            html_scorms+='</tr>';
		}else{
			for (var i = 0; i < scormsArray.length; i++) {

				if(scormsArray[i]['element']=="cmi.core.score.raw" || scormsArray[i]['element']=="cmi.core.lesson_status" || scormsArray[i]['element']=="cmi.core.total_time"){
					//html_scorms+='<tr style="background-color:#86E2D5;" >';
					html_scorms+='<tr class="active" >';
					scormsArray[i]['element']="<strong>"+scormsArray[i]['element']+"</strong>";
				}else{
					html_scorms+='<tr>';
				}

	            html_scorms+='	<td style="font-size:12px !important; " item-index="'+i+'"  >'+scormsArray[i]['id']+'</td>'; 
	            html_scorms+='	<td style="font-size:12px !important; " item-index="'+i+'"  >'+scormsArray[i]['scormid']+'</td>'; 
	            html_scorms+='	<td style="font-size:12px !important; " item-index="'+i+'"  >'+scormsArray[i]['userid']+'</td>'; 
	            html_scorms+='	<td style="font-size:12px !important; " item-index="'+i+'"  >'+scormsArray[i]['element']+'</td>'; 
	            html_scorms+='	<td  item-index="'+i+'"  ><input style="font-size:12px !important; " id="id_st_value_'+scormsArray[i]['id']+'" name="st_value_'+scormsArray[i]['id']+'" type="text" value="'+scormsArray[i]['value']+'" ></td>'; 
	            html_scorms+='	<td style="font-size:12px !important; " item-index="'+i+'"  >'+scormsArray[i]['fecha_registro']+'</td>'; 
	            
	            html_scorms+='	<td style="font-size:12px !important; " item-index="'+i+'"  >'+scormsArray[i]['fecha_modificacion']+'</td>'; 
	            html_scorms+='</tr>';
			}			
		}

		$("#tabla_scormstracks").empty().append(html_scorms); // refresca la tabla con nuevos registros

		$(".btn_sf_change").click(function(){
			var idx_current_scorm=$(this).attr('item-index');
			var id_scorm= scormsArray[idx_current_scorm]['scormid'];
			var id_user= scormsArray[idx_current_scorm]['userid'];

			/* SendAjax("form_sf_change_"+idx_current_scorm,'ChangeScormFile',function(result) {
				GetScormFiles(id_scorm);
			});*/


		});

	}

	function InitializeScormsTracks(){ // trae los scormstracks en cuanto carga
		
	}


});