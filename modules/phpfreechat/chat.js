//$(document).ready(function(){
	

	var src_iframe ="";

	var chat_alumnos = ["@uva","@Pera","@sandia","@manzana"];

	$("#pfc_words").autocomplete({
      minLength: 1,
      source: chat_alumnos,
      focus: function( event, ui ) {
        //$( "#pfc_words" ).val( ui.item.label );
       
      },
      select: function( event, ui ) {
      
       	//$( "#pfc_words" ).val( ui.item.label );
       // $( "#pfc_words" ).val( ui.item.value );
       // $( "#pfc_words" ).html( ui.item.desc );
        //$( "#pfc_words" ).attr( "src", "images/" + ui.item.icon );
 		

 		$( "#pfc_words" ).val("");
        
      }
    }); 


	alert($("#pfc_words").attr('type'));
//}); 