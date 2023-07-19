//CONSTRUCTOR
function uploadFileActividadesIntegradoras(_idContainer, _idTemplate, _id_plan_estudio, _id_unidad, _id_course, _id_alumno_moodle, _nutab, _nuActividad) {
    //PARAMETROS
    this.idContainer = _idContainer;
    this.idTemplate = _idTemplate;
    this.id_plan_estudio = _id_plan_estudio;
    this.id_unidad = _id_unidad;
    this.id_course = _id_course;
    this.id_alumno_moodle = _id_alumno_moodle;
    this.nu_actividad = _nuActividad;
    this.nuTab = _nutab;
    this.methodChange = null;
    this.extensiones = null;

    //VARIABLES
    this.snDisabledUpload = false;
    this.snDisabledDownload = true;
    this.snDisabledDelete = true;
    this.snDisabledModalFiles = true;
    this.strLabelOriginal = "Seleccionar archivo(s)";
    this.strLabel = this.strLabelOriginal;
    this.urlServer = 'https://agcollege.edu.mx/uploadfilesplugin/actividades/';
    this.maxSizeFileMB = 150;
    this.nuFiles = 15;
    this.nuFilesEvent = 5;
    this.imgButtonUpload = "fa fa-arrow-up";
    this.imgButtonDownload = "fa fa-arrow-down";
    this.imgButtonDelete = "fa fa-times";
    this.imgButtonModal = "fa fa-eye";
    this.imgLoading = "fa fa-spinner fa-pulse";
    this.serverFiles = [];
    this.viewFileServer = null;
    this.toast = new notificacionesToast();

    //METODOS GETTER AND SETTER
    this.setFiles = fnc_setFiles;
    this.setExtensiones = fnc_setExtensiones;
    this.setMethodChange = fnc_setMethodChange;
    this.getFiles = fnc_getFiles;
    this.setDisableButton = fnc_setDisableButton;

    //FUNCIONES
    this.createTemplate = fnc_createTemplate;
    this.uploadEvent = fnc_uploadEvent;
    this.downloadEvent = fnc_downloadEvent;
    this.deleteEvent = fnc_deleteEvent;
    this.openModalFiles = fnc_openModalFiles;
    this.createModalFiles = fnc_createModalFiles;
    this.selectedFileModal = fnc_selectedFileModal;
    this.createModalFilesViewFile = fnc_createModalFilesViewFile;
    this.openModalFileFromServer = fnc_openModalFileFromServer;
    this.downloadSingleFileEvent = fnc_downloadSingleFileEvent;
    this.deleteSingleFileEvent = fnc_deleteSingleFileEvent;
    this.initArrayFiles = fnc_initArrayFiles;

    this.validateFiles = fnc_validateFiles;
    this.filesActives = fnc_filesActives;
    this.updateArrayFiles = fnc_updateArrayFiles;
    this.replaceLoadingButton = fnc_replaceLoadingButton;
    this.updateButtonsFileUpload = fnc_updateButtonsFileUpload;
    this.triggerCallback = fnc_triggerCallback;
    this.clearFocus = fnc_clearFocus;
    this.getIconExtension = fnc_getIconExtension;
    this.getEnableViewFile = fnc_getEnableViewFile;
}

/****************************************************************************************************/
/********************* GETTER AND SETTER ************************************************************/
/****************************************************************************************************/

//METODO QUE RECIBE
function fnc_setExtensiones(_value) {
    this.extensiones = _value;
}

//METODO QUE RECIBE ARCHIVOS AL CARGAR LA PANTALLA
function fnc_setFiles(_files) {
    this.serverFiles = _files;
    this.triggerCallback();
}

//METODO QUE ASIGNA UN CALLBACK PARA EJECUTARSE CADA VEZ QUE SE ACTUALIZA EL ARREGLO DE ARCHIVOS
function fnc_setMethodChange(callback) {
    this.methodChange = callback;
}

//METODO QUE DEVUELVE EL ARREGLOD EL ARCHIVOS
function fnc_getFiles() {
    return this.serverFiles;
}

//METODO QUE HABILITA O DESHABILITA LOS BOTONES OPERATIVOS
function fnc_setDisableButton(op, snDisabled) {
    switch (op) {
        case 1:
            this.snDisabledUpload = snDisabled;
            break;
        case 2:
            this.snDisabledDownload = snDisabled;
            break;
        case 3:
            this.snDisabledDelete = snDisabled;
            break;
        case 4:
            this.snDisabledModalFiles = snDisabled;
            break;
    }

    this.updateButtonsFileUpload();
}

/****************************************************************************************************/
/********************* METODOS INTERNOS *************************************************************/
/****************************************************************************************************/

//METODO QUE CREA EL TEMPLATE UPLOAD
function fnc_createTemplate() {
    var _self = this;

    //INPUT TEXT DISABLED	
    var inputText = $('<input type="text" id="inputFileUploadTemplate_' + this.idTemplate + '" name="inputFileUploadTemplate_' + this.idTemplate + '" class="form-control" disabled/>')

    //INPUT HIDDEN
    var inputFileHidden = $('<input type="file" id="inputFileUploadTemplateHidden_' + this.idTemplate + '" name="inputFileUploadTemplateHidden_' + this.idTemplate + '" multiple="" style="display:none;"/>');
    inputFileHidden.on('change', function(e) {
        _self.uploadEvent(e.target.files);
    });

    //BOTONES SUBIR, DESCARGAR, ELIMINAR Y VISUALIZAR	
    var buttonUpload = $('<button type="button" id="inputFileUploadButtonUpload_' + this.idTemplate + '" name="inputFileUploadButtonUpload_' + this.idTemplate + '" class="btn btn-default" title="Subir archivos"><span class="' + this.imgButtonUpload + '"></span></button>');
    var buttonDownload = $('<button type="button" id="inputFileUploadButtonDownload_' + this.idTemplate + '" name="inputFileUploadButtonDownload_' + this.idTemplate + '" class="btn btn-default" title="Descargar archivos"><span class="' + this.imgButtonDownload + '"></span></button>');
    var buttonDelete = $('<button type="button" id="inputFileUploadButtonDelete_' + this.idTemplate + '" name="inputFileUploadButtonDelete_' + this.idTemplate + '" class="btn btn-default" title="Eliminar"><span class="' + this.imgButtonDelete + '"></span></button>');
    var buttonModal = $('<button type="button" id="inputFileUploadButtonModal_' + this.idTemplate + '" name="inputFileUploadButtonModal_' + this.idTemplate + '" class="btn btn-default" title="Ver archivos"><span class="' + this.imgButtonModal + '"></span></button>');

    buttonUpload.attr('disabled', this.snDisabledUpload);
    buttonDownload.attr('disabled', this.snDisabledDownload);
    buttonDelete.attr('disabled', this.snDisabledDelete);
    buttonModal.attr('disabled', this.snDisabledModalFiles);

    buttonUpload.on('click', function() {
        inputFileHidden.trigger('click');
    });

    buttonDownload.on('click', function() {
        _self.downloadEvent();
    });

    buttonDelete.on('click', function() {
        _self.deleteEvent();
    });

    buttonModal.on('click', function() {
        _self.openModalFiles();
    });

    //BUTTONS CONTAINER
    var divButtonsContainer = $('<div class="input-group-btn"/>');
    divButtonsContainer.append(buttonUpload);
    divButtonsContainer.append(buttonDownload);
    divButtonsContainer.append(buttonDelete);
    divButtonsContainer.append(buttonModal);

    //INPUT GROUP
    var divInputGroup = $('<div class="input-group"/>');
    divInputGroup.append(inputText);
    divInputGroup.append(divButtonsContainer);
    divInputGroup.append(inputFileHidden);

    //CONTAINER
    var divContainer = $("#" + this.idContainer);
    divContainer.empty();
    divContainer.append(divInputGroup);

    //MODALES
    setTimeout
    this.createModalFiles();
    this.createModalFilesViewFile();
    this.initArrayFiles();
}

//METODO QUE CREA EL MODAL DE VISUALIZAR LISTADO DE ARCHIVOS
function fnc_createModalFiles() {
    $("#inputFileUploadModalFiles_" + this.idTemplate).remove();

    var divContentModalParent = $('<div class="modal fade" id="inputFileUploadModalFiles_' + this.idTemplate + '" name="inputFileUploadModalFiles_' + this.idTemplate + '" tabindex="-1" role="dialog" style="display:none;"/>');
    var divContentModalDialog = $('<div class="modal-dialog modal-lg"/>');
    var divContentModalContent = $('<div class="modal-content"/>');

    var divHeader = $('<div class="modal-header"/>');
    divHeader.append('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
    divHeader.append('<h4 id="inputFileUploadModalFilesClose_' + this.idTemplate + '" name="inputFileUploadModalFilesClose_' + this.idTemplate + '"  class="modal-title">Archivos</h4>');

    var divBody = $('<div class="modal-body"/>');

    //RESPONSIVO
    if ($(window).width() < 768) {
        var tableFiles = $('<table class="table table-bordered" style="width: 100% !important;"/>');
        tableFiles.append('<thead><tr>' +
            '<th>Tipo de archivo</th>' +
            '<th>Nombre Archivo</th>' +
            '<th>Acciones</th></tr></thead>');

        var tableBody = $('<tbody id="inputFileUploadModalFilesTableBody_' + this.idTemplate + '" name="inputFileUploadModalFilesTableBody_' + this.idTemplate + '"/>');
        tableFiles.append(tableBody);
        divBody.append($('<div class="table-responsive"/>').append(tableFiles));
    } else {
        var tableFiles = $('<table class="table table-bordered" style="width: 100% !important;"/>');
        tableFiles.append('<thead><tr>' +
            '<th style="width: 140px !important;">Tipo de archivo</th>' +
            '<th style="width: 577px !important;">Nombre Archivo</th>' +
            '<th style="width: 150px !important;">Acciones</th></tr></thead>');

        var tableBody = $('<tbody id="inputFileUploadModalFilesTableBody_' + this.idTemplate + '" name="inputFileUploadModalFilesTableBody_' + this.idTemplate + '"/>');
        tableFiles.append(tableBody);
        divBody.append(tableFiles);
    }

    divContentModalContent.append(divHeader);
    divContentModalContent.append(divBody);
    divContentModalDialog.append(divContentModalContent);
    divContentModalParent.append(divContentModalDialog);

    $('body').append(divContentModalParent);
}

//METODO QUE CREA EL MODAL PARA VISUALIZAR UN ARCHIVO DESDE EL SERVIDOR
function fnc_createModalFilesViewFile() {
    $("#inputFileUploadModalFilesViewFile_" + this.idTemplate).remove();

    var fileDataHeight = $(window).height() - 150;
    var divContentModalParent = $('<div class="modal fade" id="inputFileUploadModalFilesViewFile_' + this.idTemplate + '" name="inputFileUploadModalFilesViewFile_' + this.idTemplate + '" tabindex="-1" role="dialog" style="display:none";/>');
    var divContentModalDialog = $('<div class="modal-dialog"/>');
    var divContentModalContent = $('<div class="modal-content"/>');

    var divHeader = $('<div class="modal-header"/>');
    divHeader.append('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
    divHeader.append('<h4 id="inputFileUploadModalFilesViewTitle_' + this.idTemplate + '" name="inputFileUploadModalFilesViewTitle_' + this.idTemplate + '" class="modal-title"/>');

    var classImg = 'margin: auto !important; top: 0% !important; display: inline !important; position: relative !important; max-width: 90% !important; max-height: ' + fileDataHeight + ' !important;';
    var divBody = $('<div align="center" class="modal-body"/>');

    divBody.append('<img id="imgFile_' + this.idTemplate + '" name="imgFile_' + this.idTemplate + '" style="' + classImg + '"/>');
    divBody.append('<embed id="pdfFile_' + this.idTemplate + '" name="pdfFile_' + this.idTemplate + '" frameborder="0" width="100%" height="' + fileDataHeight + '"/>');

    divContentModalContent.append(divHeader);
    divContentModalContent.append(divBody);
    divContentModalDialog.append(divContentModalContent);
    divContentModalParent.append(divContentModalDialog);
    $('body').append(divContentModalParent);
}

//METODO QUE INICIALIZA EL ARRAY SERVER FILES
function fnc_initArrayFiles() {
    this.strLabel = this.serverFiles.length == 0 ? this.strLabelOriginal : this.serverFiles.length == 1 ? this.serverFiles[0].name : this.serverFiles.length + ' archivos';
    $('#inputFileUploadTemplate_' + this.idTemplate).val(this.strLabel);
}

//METODO QUE SUBE LOS ARCHIVOS
function fnc_uploadEvent(_files) {
    if (!isNull('array', _files) && this.validateFiles(_files)) {
        var form_data = new FormData();

        for (var i = 0; i < _files.length; i++) {
            var fileTag = 'file_' + i;
            form_data.append(fileTag, _files[i], _files[i].name);
        }

        form_data.append('id_plan_estudio', this.id_plan_estudio);
        form_data.append('id_unidad', this.id_unidad);
        form_data.append('id_course', this.id_course);
        form_data.append('id_alumno_moodle', this.id_alumno_moodle);
        form_data.append('nu_actividad', this.nu_actividad);

        var _self = this;
        $.ajax({
            url: _self.urlServer + 'uploadFile.php',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            beforeSend: function() {
                _self.replaceLoadingButton(1, _self.imgLoading);
            },
            complete: function() {
                _self.replaceLoadingButton(1, _self.imgButtonUpload);
            },
            success: function(response) {
                if (response.success) {
                    _self.updateArrayFiles(response.data);
                } else {
                    _self.toast.error(response.title, response.msje, response);
                }
            },
            error: function(response) {
                _self.toast.error('Error al subir el archivo',
                    `Ocurrio un error en el servidor
        ${response.responseText}
        `);
                console.log(response)
            }
        });
    } else {
        $("#inputFileUploadTemplateHidden_" + this.idTemplate).val("");
    }

    this.clearFocus();
}

//METODO QUE DESCARGA LOS ARCHIVOS
function fnc_downloadEvent() {
    if (!isNull('array', this.serverFiles)) {
        var arrayData = [];
        for (var i = 0; i < this.serverFiles.length; i++) {
            if (!this.serverFiles[i].snDelete) {
                arrayData.push(this.serverFiles[i]);
            }
        }

        var _data = {
            id_plan_estudio: this.id_plan_estudio,
            files: JSON.stringify(arrayData)
        };

        openNewWindowPost(this.urlServer + 'downloadFile.php', _data);
    }

    this.clearFocus();
}

//METODO QUE ELIMINA LOGICAMENTE LOS ARCHIVOS
function fnc_deleteEvent() {
    if (!isNull('array', this.serverFiles)) {
        for (var i = 0; i < this.serverFiles.length; i++) {
            this.serverFiles[i].snDelete = true;
        }

        this.strLabel = this.strLabelOriginal;
        this.snDisabledDownload = true;
        this.snDisabledDelete = true;
        this.snDisabledModalFiles = true;
        this.updateButtonsFileUpload();

        $("#inputFileUploadTemplateHidden_" + this.idTemplate).val("");
        this.triggerCallback();
    }

    // this.clearFocus();
    fnc_clearFocus();
}

//METODO QUE ABRE EL MODAL PARA VISUALIZAR LOS ARCHIVOS
function fnc_openModalFiles() {
    var body = $("#inputFileUploadModalFilesTableBody_" + this.idTemplate);
    body.empty();

    var contador = 1;
    var arrayData = [];
    var _self = this;

    for (var i = 0; i < this.serverFiles.length; i++) {
        if (!this.serverFiles[i].snDelete) {
            let itemFile = this.serverFiles[i];
            var acciones = $('<btn-group/>');

            var viewFile = $('<button type="button" id="inputFileUploadModalViewFile_' + this.idTemplate + '_' + contador + '" name="inputFileUploadModalViewFile_' + this.idTemplate + '_' + contador + '" class="btn btn-default" tile="Visualizar archivo"/>');
            viewFile.append('<span class="' + this.imgButtonModal + '"></span>');

            var downloadFile = $('<button type="button" id="inputFileUploadModalDownloadFile_' + this.idTemplate + '_' + contador + '" name="inputFileUploadModalDownloadFile_' + this.idTemplate + '_' + contador + '" class="btn btn-default" tile="Descargar archivo"/>');
            downloadFile.append('<i class="' + this.imgButtonDownload + '"></i>');

            var deleteFile = $('<button type="button" id="inputFileUploadModalDeleteFile_' + this.idTemplate + '_' + contador + '" name="inputFileUploadModalDeleteFile_' + this.idTemplate + '_' + contador + '" class="btn btn-default" tile="Eliminar archivo"/>');
            deleteFile.append('<i class="' + this.imgButtonDelete + '"></i>');

            viewFile.attr('disabled', this.getEnableViewFile(this.serverFiles[i].extension));
            downloadFile.attr('disabled', this.snDisabledDownload);
            deleteFile.attr('disabled', this.snDisabledDelete);

            //EVENTO VISUALIZAR ARCHIVO
            viewFile.on('click', function(e) {
                var _idButton = $(this).attr('id');
                _self.selectedFileModal(_idButton, itemFile);
            });

            //EVENTO DESCARGAR ARCHIVO
            downloadFile.on('click', function(e) {
                _self.downloadSingleFileEvent(itemFile);
            });

            //EVENTO ELIMINAR ARCHIVO
            deleteFile.on('click', function(e) {
                var rowTr = $(this).closest('tr');
                _self.deleteSingleFileEvent(rowTr, itemFile);
            });

            acciones.append(viewFile);
            acciones.append(downloadFile);
            acciones.append(deleteFile);

            var tr = $('<tr id="inputFileUploadModalFilesRow_' + contador + '" name="inputFileUploadModalFilesRow_' + contador + '"/>');

            if ($(window).width() < 768) {
                tr.append('<td align="center"><i class="' + this.getIconExtension(this.serverFiles[i].extension) + '"></i></td>');
                tr.append('<td align="left">' + this.serverFiles[i].name + '</td>');
                var tdAcciones = $('<td align="center"/>');
            } else {
                tr.append('<td align="center" style="max-width: 140px !important;"><i class="' + this.getIconExtension(this.serverFiles[i].extension) + '"></i></td>');
                tr.append('<td align="left" style="max-width: 577px !important; word-wrap: break-word !important;">' + this.serverFiles[i].name + '</td>');
                var tdAcciones = $('<td align="center" style="max-width: 150px !important;"/>');
            }

            tdAcciones.append(acciones);
            tr.append(tdAcciones);
            body.append(tr);

            contador = contador + 1;
        }
    }

    $('#inputFileUploadModalFiles_' + this.idTemplate).modal({ keyboard: false, backdrop: 'static' }).modal('show');
}

//METODO QUE ABRE EL MODAL PARA VISUALIZAR EL ARCHIVO DESDE EL SERVIDOR
function fnc_selectedFileModal(idButton, itemFile) {
    var form_data = new FormData();
    form_data.append('id_plan_estudio', this.id_plan_estudio);
    form_data.append('urlFile', itemFile.path);

    var _self = this;

    $.ajax({
        url: _self.urlServer + 'viewFile.php',
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        beforeSend: function() {
            _self.replaceLoadingButton(4, _self.imgLoading, idButton);
        },
        complete: function() {
            _self.replaceLoadingButton(4, _self.imgButtonModal, idButton);
        },
        success: function(response) {
            if (response.success) {
                _self.viewFileServer = {
                    fileName: itemFile.name,
                    fileView: response.data[0].filedata,
                    fileType: response.data[0].fileType
                };

                _self.openModalFileFromServer();
            } else {
                _self.toast.error(response.title, response.msje, response);
            }
        },
        error: function(response) {
            _self.toast.error('Error al subir el archivo', 'Ocurrio un error en el servidor');
        }
    });
}

//METODO QUE ABRE EL MODAL PARA VISUALIZAR UN ARCHIVO
function fnc_openModalFileFromServer() {
    if (this.viewFileServer != null) {
        $("#inputFileUploadModalFilesViewTitle_" + this.idTemplate).text(this.viewFileServer.fileName);

        if (this.viewFileServer.fileType == 'img') {
            $("#imgFile_" + this.idTemplate).attr('src', this.viewFileServer.fileView);
            $("#imgFile_" + this.idTemplate).css('display', 'block');
            $("#pdfFile_" + this.idTemplate).css('display', 'none');
        } else if (this.viewFileServer.fileType == 'pdf') {
            $("#pdfFile_" + this.idTemplate).attr('src', this.viewFileServer.fileView);
            $("#pdfFile_" + this.idTemplate).css('display', 'block');
            $("#imgFile_" + this.idTemplate).css('display', 'none');
        }

        var _self = this;
        $("#inputFileUploadModalFilesViewFile_" + this.idTemplate).on('hidden.bs.modal', function(e) {
            if ($('.modal.in').length > 0) {
                $('body').addClass('modal-open');
            }

            _self.viewFileServer = null;
        });

        $("#inputFileUploadModalFilesViewFile_" + this.idTemplate).modal({ keyboard: false, backdrop: 'static' }).modal('show');
    }
}

//METODO QUE DESCARGA UN ARCHIVO EN ESPECIFICO
function fnc_downloadSingleFileEvent(itemFile) {
    if (!isNull('object', itemFile)) {
        var arrayData = [];
        arrayData.push(itemFile);

        var _data = {
            id_plan_estudio: this.id_plan_estudio,
            files: JSON.stringify(arrayData)
        };

        openNewWindowPost(this.urlServer + 'downloadFile.php', _data);
    }

    this.clearFocus();
}

//METODO QUE ELIMINA UN ARCHIVO EN ESPECIFICO LOGICAMENTE
function fnc_deleteSingleFileEvent(tr, itemFile) {
    //OBTENEMOS EL INDEX DEL ELEMENTO ARCHIVO A ELIMINAR LOGICAMENTE
    var idx = -1;
    for (var i = 0; i < this.serverFiles.length; i++) {
        if (itemFile.name == this.serverFiles[i].name) {
            idx = i;
            break;
        }
    }

    //SI ENCONTRO EL ARCHIVO
    if (idx > -1) {
        tr.remove();
        this.serverFiles[idx].snDelete = true;

        //CONTAMOS LOS ARCHIVOS QUE HAN SIDO ELIMINADOS		
        var arrayFilesActivos = [];
        for (var i = 0; i < this.serverFiles.length; i++) {
            if (!this.serverFiles[i].snDelete) {
                arrayFilesActivos.push(this.serverFiles[i]);
            }
        }

        //SI YA NO HAY ARCHIVOS ACTIVOS
        if (arrayFilesActivos.length == 0) {
            this.strLabel = this.strLabelOriginal;
            this.snDisabledDownload = true;
            this.snDisabledDelete = true;
            this.snDisabledModalFiles = true;

            $("#inputFileUploadTemplateHidden_" + this.idTemplate).val("");
        } else if (arrayFilesActivos.length == 1) {
            this.strLabel = arrayFilesActivos[0].name;
        } else {
            this.strLabel = arrayFilesActivos.length + " archivos";
        }

        this.updateButtonsFileUpload();
        this.triggerCallback();
    }
}

//METODO QUE VALIDA LOS ARCHIVOS
function fnc_validateFiles(_files) {
    var bandera = true;
    var _currentFiles = this.filesActives();

    //SI EL TOTAL DE ARCHIVOS ES MENOR QUE EL TOTAL DE ARCHIVOS QUE TENDREMOS, LANZAMOS ERROR
    if ((_files.length + _currentFiles.length) > this.nuFiles) {
        bandera = false;
        this.toast.error('Archivos no válidos', 'El número máximo de archivos totales son ' + this.nuFiles, null);
        return;
    }
    //SI EL NUMERO DE ARCHIVOS DE SUBIDO ES MAYOR AL LIMITE DE ARCHIVOS POR EVENTO, LANZAMOS ERROR
    else if (_files.length > this.nuFilesEvent) {
        bandera = false;
        this.toast.error('Archivos no válidos', 'El número máximo de archivos por subida son ' + this.nuFilesEvent, null);
        return;
    } else {
        //RECORREMOS ARCHIVOS POR SUBIR
        for (var i = 0; i < _files.length; i++) {
            var _size = _files[i].size / 1048576;
            _size = parseFloat(_size.toFixed(6));

            //SI EL ARCHIVO ES MAYOR AL LIMITE POR ARCHIVO, LANZAMOS ERROR
            if (_size > this.maxSizeFileMB) {
                bandera = false;
                this.toast.error('Archivo no válido', 'El archivo ' + _files[i].name + ' no debe de pesar más de ' + this.maxSizeFileMB + ' MB', null);
                return;
            }

            //SI EXISTEN RESTRICCIONES EN LAS EXTENSIONES
            if (!isNull('string', this.extensiones)) {
                var arrayExtensiones = this.extensiones.split(',');

                for (var j = 0; j < arrayExtensiones.length; j++) {
                    if (_files[i].name.toLowerCase().indexOf(arrayExtensiones[j].trim())) {
                        bandera = false;
                        this.toast.error('Archivo no válido', 'El archivo ' + _files[i].name + ' no cuenta con una extensión ' + this.extensiones);
                        return;
                    }
                }
            }

            //VALIDAMOS SI EXISTE EL ARCHIVO
            for (var j = 0; j < _currentFiles.length; j++) {
                if (_currentFiles[j].name.toLowerCase() == _files[i].name.toLowerCase()) {
                    bandera = false;
                    this.toast.error('Archivo repetido', 'El archivo ' + _files[i].name + ' ya fue agregado anteriormente');
                    return;
                }
            }
        }
    }

    return bandera;
}

//METODO QUE REGRESA LOS ARCHIVOS ACTIVOS (NO ELIMINADOS)
function fnc_filesActives() {
    var _arrayFiles = [];

    for (var i = 0; i < this.serverFiles.length; i++) {
        if (!this.serverFiles[i].snDelete) {
            _arrayFiles.push(this.serverFiles[i]);
        }
    }

    return _arrayFiles;
}

//METODO QUE ACTUALIA EL ARRAY FILES
function fnc_updateArrayFiles(data) {
    //INSERTAMOS LOS ARCHIVOS SUBIDOS
    for (var i = 0; i < data.length; i++) {
        var indexRepetido = -1;
        for (var j = 0; j < this.serverFiles.length; j++) {
            if (data[i].name == this.serverFiles[j].name) {
                indexRepetido = j;
                break;
            }
        }

        if (indexRepetido > -1) {
            this.serverFiles[indexRepetido].snDelete = false;
        } else {
            this.serverFiles.push(data[i]);
        }
    }

    //CONTAMOS LOS ARCHIVOS QUE NO HAN SIDO BORRADOS
    var _contadorFilesActivos = 0;
    for (var i = 0; i < this.serverFiles.length; i++) {
        if (!this.serverFiles[i].snDelete) {
            _contadorFilesActivos = _contadorFilesActivos + 1;
        }
    }

    //ACTUALIZAMOS EL LABEL
    if (_contadorFilesActivos > 1) {
        this.strLabel = _contadorFilesActivos + ' archivos';
    } else {
        this.strLabel = data[0].name;
    }

    //ACTUALIZAMOS BOTONES PLUGIN
    this.snDisabledModalFiles = false;
    this.snDisabledDownload = false;
    this.snDisabledDelete = false;
    this.updateButtonsFileUpload();
    $("#inputFileUploadTemplateHidden_" + this.idTemplate).val("");

    //EJECUTAMOS CALLBACK
    this.triggerCallback();
}

//METODO QUE REEMPLAZA LA CLASE DE LOS BOTONES DEL TEMPLATE
function fnc_replaceLoadingButton(op, newClass, idSelector = null) {
    var domSelector;
    if (idSelector == null) {
        idSelector = this.idTemplate;
    }

    switch (op) {
        case 1:
            domSelector = $("#inputFileUploadButtonUpload_" + idSelector).find('span');
            break;
        case 2:
            domSelector = $("#inputFileUploadButtonDownload_" + idSelector).find('span');
            break;
        case 3:
            domSelector = $("#inputFileUploadButtonDelete_" + idSelector).find('span');
            break;
        case 4:
            domSelector = $("#" + idSelector).find('span');
            break;
        default:
            domSelector = $("#" + idSelector).find('span');
            break;
    }

    domSelector.removeClass();
    domSelector.addClass(newClass);
}

//METODO QUE ACTUALIZA LOS BOTONES DEL TEMPLATE
function fnc_updateButtonsFileUpload() {
    $("#inputFileUploadTemplate_" + this.idTemplate).val(this.strLabel);
    $("#inputFileUploadButtonUpload_" + this.idTemplate).attr('disabled', this.snDisabledUpload);
    $("#inputFileUploadButtonDownload_" + this.idTemplate).attr('disabled', this.snDisabledDownload);
    $("#inputFileUploadButtonDelete_" + this.idTemplate).attr('disabled', this.snDisabledDelete);
    $("#inputFileUploadButtonModal_" + this.idTemplate).attr('disabled', this.snDisabledModalFiles);
}

//METODO QUE HABILITA EL VISOR DEL ARCHIVO DEPENDIENDO DE LA EXTENSION DE ESTE
function fnc_getEnableViewFile(extension) {
    switch (extension.toLowerCase()) {
        case 'jpeg':
            return false;
        case 'jpg':
            return false;
        case 'png':
            return false;
        case 'zip':
            return true;
        case 'rar':
            return true;
        case 'txt':
            return true;
        case 'xlsx':
            return true;
        case 'xls':
            return true;
        case 'docx':
            return true;
        case 'doc':
            return true;
        case 'pptx':
            return true;
        case 'ppt':
            return true;
        case 'pdf':
            return false;
        default:
            return true;
    }
}

//METODO QUE OBTIENE EL ICONO DEL ARCHIVO
function fnc_getIconExtension(extension) {
    switch (extension.toLowerCase()) {
        case 'jpeg':
            return 'fa fa-file-image-o fa-2x text-info';
        case 'jpg':
            return 'fa fa-file-image-o fa-2x text-info';
        case 'png':
            return 'fa fa-file-image-o fa-2x text-info';
        case 'zip':
            return 'fa fa-file-archive-o fa-2x text-danger';
        case 'rar':
            return 'fa fa-file-archive-o fa-2x text-danger';
        case 'txt':
            return 'fa fa-file-text-o fa-2x text-muted';
        case 'xlsx':
            return 'fa fa-file-excel-o fa-2x text-success';
        case 'xls':
            return 'fa fa-file-excel-o fa-2x text-success';
        case 'docx':
            return 'fa fa-file-word-o fa-2x text-primary';
        case 'doc':
            return 'fa fa-file-word-o fa-2x text-primary';
        case 'pptx':
            return 'fa fa-file-powerpoint-o fa-2x text-warning';
        case 'ppt':
            return 'fa fa-file-powerpoint-o fa-2x text-warning';
        case 'pdf':
            return 'fa fa-file-pdf-o fa-2x text-danger';
        default:
            return 'fa fa-file fa-2x text-muted';
    }
}

//METODO QUE EJECUTA EL CALLBACK PARA DEVOLVER ARREGLO A PANTALLA PRINCIPAL
function fnc_triggerCallback() {
    if (!isNull('callback', this.methodChange)) {
        this.methodChange(this.serverFiles, this.nuTab);
    }
}

//METODO QUE ASIGNA EL FOCO AL DOCUMENTO HTML
function fnc_clearFocus() {
    if (document.activeElement != document.body) {
        document.activeElement.blur();
    }
}