var paginadoJquery = function() {};

paginadoJquery.prototype = {
    _maxPagesVisibles: 6,
    _totalPages: 0,
    _startVisiblePages: 1,
    _endVisiblePages: 0,
    _currentPage: 1,
    _itemsPage: 25,
    _startRow: 0,
    _endRow: 0,
    _showbeforePages: false,
    _showAfterPages: false,
    _showLegendRows: true,
    _filtered: null,
    _filterData: [],
    _pages: [],
    _originalData: [],
    _domDiv: "",
    _domTable: "",
    _functionUpdateTable:null,

    _functionMsjeErrorServer: null,
    _functionBeforeServer: null,
    _functionAfterServer: null,
    _urlFileserver: null,
    _formData: null,
    _nuTotalRegistros: 0,

    /*********************************************************************************************************/
    /************************************* GETTER & SETTER ***************************************************/
    /*********************************************************************************************************/

    set_maxPagesVisibles: function(value) {
        this._maxPagesVisibles = value;
    },

    setItemsPage: function(value) {
        this._itemsPage = value;
    },

    getFilterData: function(){
    	return this._filterData;
    },

    setFunctionUpdateTable: function(callback){
        this._functionUpdateTable = callback;
    },

    setFunctionBeforeServer: function(callback){        
        this._functionBeforeServer = callback;
    },

    setFunctionAfterServer: function(callback){
        this._functionAfterServer = callback;
    },

    setFunctionMsjeErrorServer: function(callback){
        this._functionMsjeErrorServer = callback;
    },

    setUrlFileserver: function(strFile){
        this._urlFileserver = strFile;
    },

    setFormData: function(data){
        this._formData = data;
    },

    /*********************************************************************************************************/
    /*************************** PAGINADO LOCAL **************************************************************/
    /*********************************************************************************************************/

    //METODO QUE INICIALIZA EL PLUGIN
    initializeLocal: function(value, divParent)
    {
        if (!isNull('array', value))
        {
        	this._domDiv = divParent;
            this._originalData = value;
            this.initPaginate();
        }
    },

    //METODO QUE INICIALIZA PAGINADO
    initPaginate: function()
    {
        //CALCULAMOS EL NUMERO DE PAGINAS TOTALES
        this._totalPages = roundNumber(1, this._originalData.length / this._itemsPage);
        this._startVisiblePages = 1;
        this._endVisiblePages = this._totalPages < this._maxPagesVisibles ? this._totalPages : this._maxPagesVisibles;

        //FILTRAMOS EL GRID
        this.filteredData("");
    },

    //METODO QUE FILTRA EL GRID (DESDE UN FORMULARIO)
    filteredData: function(strValue) 
    {
        var result = $.grep(this._originalData, function(item) 
        {
            var bandera = false;
            for (var key in item) 
            {
                bandera = !isNull('string', item[key]) && item[key].toString().toLowerCase().includes(strValue.toLowerCase());
                if (bandera) { return bandera; }
            }
            return bandera;
        });

        this.showLegendRows = isNull('string', strValue) ? true : false;
        this.updatePaginate(result);
    },

    //METODO QUE ACTUALIZA EL PAGINADO CUANDO ESCRIBIMOS SOBRE FILTRO
    updatePaginate: function(dataUpdated) 
    {
        this._totalPages = roundNumber(1, dataUpdated.length / this._itemsPage);
        this._filterFullData = dataUpdated;

        this._currentPage = 1;
        this._startVisiblePages = 1;
        this._endVisiblePages = this._totalPages < this._maxPagesVisibles ? this._totalPages : this._maxPagesVisibles;

        this.goToPage(this._currentPage);
    },

    //METODO QUE FILTRA EL GRID DEPENDIENDO DE UNA PAGINA EN ESPECIFICO
    goToPage: function(nuPage) 
    {
        let startRow = (this._itemsPage * nuPage) - this._itemsPage;
        let endRow = startRow + this._itemsPage - 1;

        var arrayFilter = this._filterFullData.filter(function(item, index){
            return index >= startRow && index <= endRow;
        });

        this._filterData = arrayFilter;

        this._startRow = startRow + 1;
        this._endRow = nuPage == this._totalPages ? this._filterFullData.length : endRow + 1;
        this._currentPage = nuPage;

        this.updateNumbersPaginates();
        this.showHideArrowButtons();
        this.updateUI();
        this._functionUpdateTable(this._filterData);
    },

    //METODO QUE MUESTRA EL PRIMER BLOQUE DE PAGINAS DEL PAGINADO
    goToFirstPages: function()
    {
        this._startVisiblePages = 1;
        this._endVisiblePages = this._maxPagesVisibles;
        this.goToPage(this._startVisiblePages);
    },

    goToPreviousPages: function()
    {
        var tope = this._startVisiblePages;
        this._startVisiblePages = tope - this._maxPagesVisibles;
        this._endVisiblePages = tope - 1;
        this.goToPage(this._startVisiblePages);
    },

    //METODO QUE MUESTRA EL SIGUIENTE BLOQUE DE PAGINAS DEL PAGINADO
    goToNextPages: function()
    {
        var tope = this._endVisiblePages + this._maxPagesVisibles;
        this._startVisiblePages = this._endVisiblePages + 1;
        this._endVisiblePages = tope < this._totalPages ? tope : this._totalPages;
        this.goToPage(this._startVisiblePages);
        //this.updateNumbersPaginates();
    },

    //METODO QUE MUESTRA EL ULTIMO BLOQUE DE PAGINAS DEL PAGINADO
    goToLastPages: function()
    {
        var residuo = roundNumber(1, this._totalPages/this._maxPagesVisibles);
        this._startVisiblePages = (this._maxPagesVisibles * residuo) - this._maxPagesVisibles + 1;
        this._endVisiblePages = this._totalPages;
        this.goToPage(this._startVisiblePages);
    },

    //METODO QUE ACTUALIZA EL ARRAY QUE MUESTRA LAS PAGINAS DISPONIBLES A LA VISTA
    updateNumbersPaginates: function()
    {
        this.pages = [];
        for (var i = this._startVisiblePages; i <= this._endVisiblePages; i++) {
            this.pages.push(i);
        }
    },

    //METODO QUE MUESTRA U OCULTA LOS BOTONES DE LAS FLECHAS
    showHideArrowButtons() 
    {
        this._showbeforePages = this._currentPage > this._maxPagesVisibles;
        this._showAfterPages = this._endVisiblePages < this._totalPages;
    },

    //METODO QUE ACTUALIZA LA INTERFAZ GRAFICA
    updateUI: function()
    {
    	var ul = $('<ul style="padding-top: 0px !important; margin-top: 0px !important;" class="pagination">');
    	var _self = this;

    	if(this._showbeforePages)
    	{
    		var liPrevious = $('<li/>');

    		var aPrevious = $('<a href="#"/>');
    		var iconPrevious = $('<i class="fa fa-angle-left" aria-hidden="true"></i>');
            aPrevious.on('click', function()
            {
                _self.goToPreviousPages();
            });

    		var aFirst = $('<a href="#"/>');
    		var iconFirst = $('<i class="fa fa-angle-double-left" aria-hidden="true"></i>');
            aFirst.on('click', function()
            {
                _self.goToFirstPages();
            });

    		aPrevious.append(iconPrevious);
    		aFirst.append(iconFirst);
    		liPrevious.append(aFirst);
    		liPrevious.append(aPrevious);
    		ul.append(liPrevious);
    	}

    	for(var i=0; i<this.pages.length; i++)
    	{
    		var li = $('<li nuPage="' + this.pages[i] + '"/>');

    		li.on('click', function()
    		{
    			var nuPage = $(this).attr('nuPage');
    			_self.goToPage(nuPage);
    		});

    		var a = $('<a href="#"/>');
    		a.text(this.pages[i]);            

    		li.append(a);
    		ul.append(li);
    	}
    	
    	if(this._showAfterPages)
    	{
    		var liNext = $('<li/>');

    		var aNext = $('<a href="#"/>');            
    		var iconNext = $('<i class="fa fa-angle-right" aria-hidden="true"></i>');
            aNext.on('click', function()
            {
                _self.goToNextPages();
            });

    		var aLast = $('<a href="#"/>');
    		var iconLast = $('<i class="fa fa-angle-double-right" aria-hidden="true"></i>');
            aLast.on('click', function()
            {
                _self.goToLastPages();
            });

    		aNext.append(iconNext);
    		aLast.append(iconLast);
    		liNext.append(aNext);
    		liNext.append(aLast);
    		ul.append(liNext);
    	}

    	//ANEXAMOS A LA PANTALLA
    	var nav = $('<nav aria-label="Page navigation"/>');
    	nav.append(ul);
    	$("#" + this._domDiv).empty();
    	$("#" + this._domDiv).append(nav);
    },

    /*********************************************************************************************************/
    /*************************** PAGINADO SERVER **************************************************************/
    /*********************************************************************************************************/

    //METODO QUE INICIALIZA EL PLUGIN
    initializeServer: function(divParent)
    {        
        this._domDiv = divParent;        
        //this._startVisiblePages = 1;
        this.consultarServidor(this._currentPage, true);
    },

    //METODO QUE REALIZA EL REQUEST AL SERVER
    consultarServidor: function(nuPage, snArrowsClick)
    {
        this._formData.append('nuPage', nuPage);
        this._formData.append('nuRowsPage', this._itemsPage);

        var _self = this;

        $.ajax({
            url: _self._urlFileserver,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: _self._formData,
            type: 'post',
            beforeSend: function()
            {
                if(_self._functionBeforeServer != null)
                {
                    _self._functionBeforeServer();
                } 
            },
            complete: function()
            {
                if(_self._functionAfterServer != null){
                    _self._functionAfterServer();
                }
            },
            success: function(response)
            {
                if(response.success)
                {
                    if(snArrowsClick)
                    {
                        _self.calculateTotalPagesServer(response.data.nuTotalRows);
                        _self.goToPageServer(nuPage);
                    }

                    if(response.data.registros.length < _self._itemsPage && _self._totalPages != nuPage){
                        _self.ocultarPaginado();
                    }

                    _self._functionUpdateTable(response.data.registros);                    
                }
                else
                {
                    if(_self._functionMsjeErrorServer != null){
                        _self._functionMsjeErrorServer(response.errorTitle, response.errorMensaje);
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                if(_self._functionMsjeErrorServer != null){
                    _self._functionMsjeErrorServer('Error al obtener el listado', 'Ocurrio un error en el servidor');
                }
                console.log(errorThrown);
            }
        });
    },

    //METODO QUE OCULTA EL PAGINADO
    ocultarPaginado: function()
    {
        $("#" + this._domDiv).empty();
    },

    //METODO QUE CALCULA EL TOTAL DE PAGINAS
    calculateTotalPagesServer: function(nuTotalRegistros)
    {
        this._nuTotalRegistros = nuTotalRegistros;
        this._totalPages = roundNumber(1, nuTotalRegistros / this._itemsPage);
    },

    //CREAR PAGINADO EN BASE AL REQUEST
    goToPageServer: function(nuPage) 
    {
        this._currentPage = nuPage;
        this._startVisiblePages = this._startVisiblePages < this._maxPagesVisibles ? 1 : this._startVisiblePages;        

        if((this._startVisiblePages + this._maxPagesVisibles) > this._totalPages){
            this._endVisiblePages = this._totalPages;
        }
        else if(this._totalPages <= this._maxPagesVisibles){
            this._endVisiblePages = this._totalPages;
        }
        else{
            this._endVisiblePages = this._startVisiblePages + this._maxPagesVisibles - 1;
        }

        this.updateNumbersPaginatesServer();
        this.showHideArrowButtonsServer();
        this.updateUIServer();
    },

    //METODO QUE ACTUALIZA EL ARRAY QUE MUESTRA LAS PAGINAS DISPONIBLES A LA VISTA
    updateNumbersPaginatesServer: function()
    {
        this.pages = [];
        for (var i = this._startVisiblePages; i <= this._endVisiblePages; i++) {
            this.pages.push(i);
        }
    },

    //METODO QUE MUESTRA U OCULTA LOS BOTONES DE LAS FLECHAS
    showHideArrowButtonsServer() 
    {
        this._showbeforePages = this._currentPage > this._maxPagesVisibles;
        this._showAfterPages = this._endVisiblePages < this._totalPages;
    },

    //METODO QUE ACTUALIZA LA INTERFAZ GRAFICA
    updateUIServer: function()
    {
        var ul = $('<ul style="padding-top: 0px !important; margin-top: 0px !important;" class="pagination">');
        var _self = this;

        if(this._showbeforePages)
        {
            var liPrevious = $('<li/>');

            var aPrevious = $('<a href="#"/>');
            var iconPrevious = $('<i class="fa fa-angle-left" aria-hidden="true"></i>');
            aPrevious.on('click', function()
            {
                _self.goToPreviousPagesServer();
            });

            var aFirst = $('<a href="#"/>');
            var iconFirst = $('<i class="fa fa-angle-double-left" aria-hidden="true"></i>');
            aFirst.on('click', function()
            {
                _self.goToFirstPagesServer();
            });

            aPrevious.append(iconPrevious);
            aFirst.append(iconFirst);
            liPrevious.append(aFirst);
            liPrevious.append(aPrevious);
            ul.append(liPrevious);
        }

        for(var i=0; i<this.pages.length; i++)
        {
            var li = $('<li id="nuPage_' + this.pages[i] + '" name="nuPage_' + this.pages[i] + '" nuPage="' + this.pages[i] + '" style="cursor: pointer;"/>');

            li.on('click', function()
            {
                var nuPage = $(this).attr('nuPage');

                _self._currentPage = nuPage;

                _self.setActiveCurrentPage(nuPage);
                _self.consultarServidor(nuPage, false);                                
            });

            if(this.pages[i] == this._currentPage){
                li.addClass('active');
            }

            var a = $('<a href="#"/>');
            a.text(this.pages[i]);            

            li.append(a);
            ul.append(li);
        }
        
        if(this._showAfterPages)
        {
            var liNext = $('<li/>');

            var aNext = $('<a href="#"/>');            
            var iconNext = $('<i class="fa fa-angle-right" aria-hidden="true"></i>');
            aNext.on('click', function()
            {
                _self.goToNextPagesServer();
            });

            var aLast = $('<a href="#"/>');
            var iconLast = $('<i class="fa fa-angle-double-right" aria-hidden="true"></i>');
            aLast.on('click', function()
            {
                _self.goToLastPagesServer();
            });

            aNext.append(iconNext);
            aLast.append(iconLast);
            liNext.append(aNext);
            liNext.append(aLast);
            ul.append(liNext);
        }

        //ANEXAMOS A LA PANTALLA
        var nav = $('<nav aria-label="Page navigation"/>');
        nav.append(ul);
        this.ocultarPaginado();
        $("#" + this._domDiv).append(nav);
    },

    //METODO QUE PONE EL ITEM DE LA PAGINA COMO SELECCIONADO
    setActiveCurrentPage: function(nuPage)
    {
        $("li[id*='nuPage_']").removeClass('active');
        $("#nuPage_" + nuPage).addClass('active');
    },

    //METODO QUE MUESTRA EL PRIMER BLOQUE DE PAGINAS DEL PAGINADO
    goToFirstPagesServer: function()
    {
        this._startVisiblePages = 1;
        this.consultarServidor(this._startVisiblePages, true);
    },

    //METODO QUE MUESTRA EL BLOQUE DE PAGINAS PREVIAS
    goToPreviousPagesServer: function()
    {
        this._startVisiblePages = this._startVisiblePages - this._maxPagesVisibles;
        this.consultarServidor(this._startVisiblePages, true);
    },

    //METODO QUE MUESTRA EL SIGUIENTE BLOQUE DE PAGINAS DEL PAGINADO
    goToNextPagesServer: function()
    {        
        this._startVisiblePages = this._endVisiblePages + 1;
        this.consultarServidor(this._startVisiblePages, true);
    },

    //METODO QUE MUESTRA EL ULTIMO BLOQUE DE PAGINAS DEL PAGINADO
    goToLastPagesServer: function()
    {
        var residuo = roundNumber(1, this._totalPages/this._maxPagesVisibles);
        this._startVisiblePages = (this._maxPagesVisibles * residuo) - this._maxPagesVisibles + 1;
        this.consultarServidor(this._startVisiblePages, true);
    }
};