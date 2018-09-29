(function ($) {
    'use strict';
    let easi_dur = 310;
    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */
    $(function () {

        $('.caja-op').on('click', '.button.button-cancel', function () {
            $(this).prev('div.button.guardar').removeClass('guardar').addClass('editar').text('Editar').prev('input').val($(this).data('v-before')).attr('Disabled', 'Disabled');
            $(this).remove();
        });

        $('.caja-op').on('click', '.button.editar', function () {
            $(this).after('<span class="button button-cancel button-small" data-v-before="' + $(this).prev().val() + '">Cancelar</span>').removeClass('editar').addClass('guardar').text('Guardar').prev('input').removeAttr('Disabled').val('');
        });

        $('.caja-op').on('click', '.button.guardar', function () {
            if (!$(this).prev('input').val() || $(this).prev('input').val().length === 0) {
                $.alert({
                    title: 'ERROR!',
                    content: 'No se puede registrar el campo vacido',
                    icon: 'fa fa-warning',
                    theme: 'material',
                    closeIcon: true,
                    animation: 'zoom',
                    type: 'red',
                    boxWidth: '30%',
                    useBootstrap: false,
                    buttons: {
                        Ok: function () {
                            this.close();
                        }
                    }
                });
                return;
            }

            let loading_overlay = '<div class="overlay"><div class="lds-ripple"><div></div><div></div></div></div>';
            let padre_box = $(this).closest("div.caja-op");
            let datos = $(padre_box).find(':input').serializeArray();
            datos[datos.length] = {name: 'kwe_ac_key_reg', value: $('input[name="kwe_ac_key_reg"]').val()};

            $.ajax({
                url: 'admin-ajax.php?action=saved_api_settings',
                method: 'post',
                data: datos,
                beforeSend: function () {
                    $(padre_box).prepend(loading_overlay);
                },
                success: function (response) {
                    $(padre_box).find('.button.button-cancel').remove();
                    $(padre_box).find('div.button.guardar').removeClass('guardar').addClass('editar').text('Editar').prev('input').attr('Disabled', 'Disabled');
                    $(padre_box).find('div.overlay').remove();
                },
            });
        });

        function validacion() {
            let index_error = false;
            let check_box = false;
            $.each($('#form_kwe_ac input, #form_kwe_ac select'), function (index) {
                let entrada = $(this);
                if (entrada.prop('tagName') == 'INPUT' && (entrada.prop('type') == 'text' || entrada.prop('type') == 'checkbox')) {
                    //console.log('Su id: ' + entrada.prop('id') + ' Su type: ' + entrada.prop('type'));
                    if (entrada.prop('id') == 'kwe_ac_nmb_event') {
                        if (!($.trim($(entrada).val()) != '' && $.trim($(entrada).val()).length != 0)) {
                            index_error = true;
                            if (!$('#error_' + entrada.prop('id')).length) {
                                $(entrada).after('<label id="error_' + entrada.prop('id') + '" style="display: block; color: #b10000;" for="' + entrada.prop('id') + '">Campo no puede estar vacio</label>');
                                $(entrada).addClass('con_error');
                            }
                        }
                    }
                    if (entrada.prop('type') == 'checkbox' && $('#kwe_ac_activador_event').val() == '_specific_link') {
                        if (entrada.prop('id') == '_ids' && $(entrada).is(':checked') && !($.trim($('#_specific_id_kwe_ac').val()) != '' && $.trim($('#_specific_id_kwe_ac').val()).length != 0)) {
                            index_error = true;
                            check_box = true;
                            if (!$('#error_specific_id_kwe_ac').length) {
                                $('#_specific_id_kwe_ac').after('<label id="error_specific_id_kwe_ac" style="display: block; color: #b10000;" for="_specific_id_kwe_ac">Campo no puede estar vacio</label>');
                                $('#_specific_id_kwe_ac').addClass('con_error');
                            }
                        } else if (entrada.prop('id') == '_clasess' && $(entrada).is(':checked') && !($.trim($('#_specific_class_kwe_ac').val()) != '' && $.trim($('#_specific_class_kwe_ac').val()).length != 0)) {
                            index_error = true;
                            check_box = true;
                            if (!$('#error_specific_class_kwe_ac').length) {
                                $('#_specific_class_kwe_ac').after('<label id="error_specific_class_kwe_ac" style="display: block; color: #b10000;" for="_specific_class_kwe_ac">Campo no puede estar vacio</label>');
                                $('#_specific_class_kwe_ac').addClass('con_error');
                            }
                        }
                    }

                    if (entrada.prop('id').startsWith('_specific') && ($.trim($(entrada).val()) != '' && $.trim($(entrada).val()).length != 0)) {
                        check_box = true;
                    }
                }
                if (entrada.prop('tagName') == 'SELECT') {
                    if (!($.trim($(entrada).val()) != '' && $.trim($(entrada).val()).length != 0)) {
                        index_error = true;
                        if (!$('#error_' + entrada.prop('id')).length) {
                            $(entrada).after('<label id="error_' + entrada.prop('id') + '" style="display: block; color: #b10000;" for="' + entrada.prop('id') + '">Seleccionar una opcion</label>');
                            $(entrada).addClass('con_error');
                        }
                    }
                }
            });
            if (!check_box && $('#kwe_ac_activador_event').val() == '_specific_link') {
                index_error = true;
                if (!$('#error_id_or_class_specific').length) {
                    $('#id_or_class_specific').after('<label id="error_id_or_class_specific" style="display: block; color: #b10000;" for="id_or_class_specific">Debes elegir una de dos!</label>');
                    $('#id_or_class_specific').addClass('con_error');
                }
            }
            return index_error;
        }

        $('#form_kwe_ac').on('keyup', '.con_error', function () {
            if ($(this).next('label').length) {
                $(this).next('label').remove();
            }
            $(this).removeClass('con_error');
        });

        $('#form_kwe_ac').on('change', '#id_or_class_specific input[type="checkbox"]', function () {
            if ($(this).is(':checked') && $('#error_id_or_class_specific').length) {
                $('#id_or_class_specific').removeClass('con_error');
                $('#error_id_or_class_specific').remove();
            }
            $('#id_or_class_specific label[id^="error"]').remove();
            $('#id_or_class_specific input[type="text"]').removeClass('con_error');

        });

        $('.caja-op-evnt').on('click', '.button.agregar_evnt', function () {
            let loading_overlay = '<div class="overlay"><div class="lds-ripple"><div></div><div></div></div></div>';
            let formualrio = $(this).closest("form");
            let padre_box = $(this).closest("div.caja-op-evnt");
            let datos = $(padre_box).find(':input').serializeArray();
            datos[datos.length] = {name: 'kwe_ac_key_reg', value: $('input[name="kwe_ac_key_reg"]').val()};
            datos[datos.length] = {name: '_option_evenst_display', value: 1};

            //COMPLETAR VALIDACIN DE DATOS
            if (validacion()) {
                return;
            }
            $.ajax({
                url: 'admin-ajax.php?action=saved_api_settings',
                method: 'post',
                data: datos,
                beforeSend: function () {
                    $(this).addClass('running');
                    $(padre_box).prepend(loading_overlay);
                },
                success: function (response) {
                    if (!response.success) {
                        $.alert({
                            title: 'ERROR',
                            content: 'Validacion incorrecta, Recarga la pagina Por favor!',
                            icon: 'fa fa-warning',
                            theme: 'material',
                            closeIcon: true,
                            animation: 'zoom',
                            type: 'red',
                            boxWidth: '30%',
                            useBootstrap: false,
                            buttons: {
                                Ok: function () {
                                    location.reload();
                                }
                            }
                        });
                        return;
                    }

                    if ($('.empty_reg_event_kwe_ac').length) {
                        $('.empty_reg_event_kwe_ac').remove();
                    }
                    $(padre_box).find(':input').val('');
                    $("#id_or_class_specific input:checkbox").removeAttr("checked");
                    _evnt_activador.reset();
                    sleector.reset();
                    $(response.data).appendTo('.tabla-kwe-ac-events > .divTable > .divTableBody').show(1000);
                    document.getElementById('form_kwe_ac').reset();
                    $(padre_box).find('div.overlay').remove();
                },
            });

        });

        if ($('#kwe_ac_activador_event').length) {
            var _evnt_activador = new Selectr('#kwe_ac_activador_event', {
                searchable: false,
                width: '300',
                placeholder: 'Selecciona un opción (*)'
            });

            _evnt_activador.on('selectr.select', function (option) {
                if (option.value != '' && $('label#error_kwe_ac_activador_event').length) {
                    $('label#error_kwe_ac_activador_event').remove();
                }

                if (option.value === '_specific_link') {
                    $('#id_or_class_specific').show(easi_dur);
                    return;
                }
                $('#id_or_class_specific').hide(easi_dur).find(':input:checkbox').removeAttr("checked");
                $('#_specific_id_kwe_ac').hide(easi_dur).val('');
                $('#_specific_class_kwe_ac').hide(easi_dur).val('');

            });
        }

        if ($('#kwe_ac_pagina_event').length) {
            var sleector = new Selectr('#kwe_ac_pagina_event', {
                width: '300',
                placeholder: 'Selecciona (*)',
                sortSelected: 'text'
            });

            sleector.on('selectr.select', function (option) {
                if (option.value != '' && $('label#error_kwe_ac_pagina_event').length) {
                    $('label#error_kwe_ac_pagina_event').remove();
                }
            });
        }

        $("#id_or_class_specific").on('change', 'input[type="checkbox"]', function () {
            $("#id_or_class_specific input:checkbox").not($(this)).removeAttr("checked");
            if (this.id === '_ids') {
                if (!$(this).is(':checked')) {
                    $('#_specific_id_kwe_ac').hide(easi_dur).val('');
                    $('#_specific_class_kwe_ac').hide(easi_dur).val('');
                    return;
                }
                $('#_specific_id_kwe_ac').show(easi_dur);
                $('#_specific_class_kwe_ac').hide(easi_dur).val('');
                return;
            } else if (this.id === '_clasess') {
                if (!$(this).is(':checked')) {
                    $('#_specific_id_kwe_ac').hide(easi_dur).val('');
                    $('#_specific_class_kwe_ac').hide(easi_dur).val('');
                    return;
                }
                $('#_specific_class_kwe_ac').show(easi_dur);
                $('#_specific_id_kwe_ac').hide(easi_dur).val('');
                return;
            }
        });

        $('#form_kwe_ac').on('click', '.eliminar_evnt_kwe_ac', function () {
            let evnt_fila_padre = $(this).closest('.divTableRow');
            let loading_overlay = '<div class="overlay"><div class="lds-ripple"><div></div><div></div></div></div>';
            let evnt_index_id = $(this).data('element-id');
            $.confirm({
                title: 'Eliminar!',
                content: 'Estas seguro de eliminar?',
                buttons: {
                    si: {
                        keys: ['S'],
                        action: function () {
                            return $.ajax({
                                url: 'admin-ajax.php?action=remove_envt_kwe_ac',
                                method: 'post',
                                data: {id_evnt: evnt_index_id},
                                beforeSend: function () {
                                    $('div.tabla-kwe-ac-events').prepend(loading_overlay);
                                },
                                success: function (response) {
                                    if (response.success) {
                                        //$(evnt_padre).remove();
                                        $.alert({
                                            title: 'Eliminado',
                                            content: 'Evento eliminado correctamente',
                                            theme: 'material',
                                            closeIcon: true,
                                            animation: 'zoom',
                                            type: 'red',
                                            boxWidth: '30%',
                                            useBootstrap: false,
                                        });
                                        $('div.tabla-kwe-ac-events > div.overlay').remove();
                                        $(evnt_fila_padre).remove();
                                        if ($('div.divTableBody .divTableRow').length < 2) {
                                            $('<div class="divTableRow empty_reg_event_kwe_ac"><div  style="padding: 15px;"><em style="color: #a5a5a5;">No hay registros de eventos</em></div></div>').appendTo('.tabla-kwe-ac-events > .divTable > .divTableBody').show(1000);
                                        }
                                    }
                                }
                            });
                        }
                    },
                    no: {
                        keys: ['N'],
                        action: function () {
                            this.close();
                        }
                    }
                },
                icon: 'fa fa-question',
                theme: 'material',
                closeIcon: true,
                animation: 'zoom',
                type: 'red',
                closeAnimation: 'scale',
                boxWidth: '30%',
                useBootstrap: false,
            }
            );
        });

        [].slice.call(document.querySelectorAll('.progress-button')).forEach(function (bttn, pos) {
            new UIProgressButton(bttn, {
                callback: function (instance) {
                    var progress = 0;
                    var interval = setInterval(function () {
                        progress = Math.min(progress + Math.random() * 0.025, 0.9);
                        instance.setProgress(progress);
                        console.log('Progreso: '+progress);
                        if (progress === 0.9 ) {
                            //instance.stop(0);
                            clearInterval(interval);
                        }
                    }, 150);
                    $.ajax({
                        url: 'admin-ajax.php?action=ac_check',
                        method: 'post',
                        data: {data: 'check'},
                        beforeSend: function () {
                        
                        },
                        success: function (response) {
                            if(response.success){
                                instance.setProgress(1);
                                instance.stop(1);
                                clearInterval(interval);
                            }else{
                                instance.setProgress(1);
                                instance.stop(-1);
                                clearInterval(interval);
                            }

                        },
                        error: function (response) {

                        }
                    });
                }
            });
        });

    });

})(jQuery);
