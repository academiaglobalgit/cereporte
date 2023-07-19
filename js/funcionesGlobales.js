//METODO QUE ABRE UNA URL EN UNA NUEVA PESTAÑA, A TRAVES DE POST Y PASANDOLE PARAMETROS
function openNewWindowPost(winURL, params, viewInTab = 'target')
{
	var winName = 'windowPost_' + new Date().getTime();
	var form = document.createElement("form");
	form.setAttribute("method", "post");
	form.setAttribute("action", winURL);
	form.setAttribute(viewInTab, winName);

	for (let i in params) 
	{
		if (params.hasOwnProperty(i)) 
		{
			var input = document.createElement('input');
			input.type = 'hidden';
			input.name = i;
			input.value = params[i];
			form.appendChild(input);
		}
	}

	document.body.appendChild(form);                       
	window.open(winURL, winName);
	//form.target = winName;
	form.submit();                 
	document.body.removeChild(form);
}

//METODO QUE VALIDA SI UN TIPO DE VARIABLE ES NULO
function isNull(tipo, value)
{
    switch(tipo.toUpperCase())
    {
        case "STRING": return typeof value == undefined || value == 'undefined' || value == null || value.toString().replace(/(?:(?:^|\n)\s+|\s+(?:$|\n))/g, '').replace(/\s+/g, ' ') == '';
        case "BOOLEAN": return typeof value == undefined || value == 'undefined' || value == null;
        case "ARRAY": return typeof value == undefined || value == 'undefined' || value == null || value.length == 0;
        case "DOM": return typeof value == undefined || value == 'undefined' || value == null;
        case "OBJECT": return typeof value == undefined || value == 'undefined' || value == null || value == {};
        default: return true;
    }	        
}


//METODO QUE REDONDEA UN NUMERO SEGUN EL TIPO DE REDONDEO
function roundNumber(nuope, value)
{
	var newValue = 0;

	switch(nuope)
	{
		//REDONDEAR HACIA ARRIBA
		case 1: newValue = Math.ceil(value); break;
		default: break;
	}

	return newValue;
}