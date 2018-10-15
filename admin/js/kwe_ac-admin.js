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
            if (!$(this).prev('input').val().trim() || $(this).prev('input').val().length === 0) {
                iziToast.error({
                    title: 'ERROR', message: 'No se puede registrar el campo vacido', position: 'topRight', layout: '2'
                });
                return;
            }

            let loading_overlay = '<div class="overlay"><div class="lds-ripple"><div></div><div></div></div></div>';
            let padre_box = $(this).closest("div.caja-op");
            let datos = $(padre_box).find(':input').serializeArray();
            datos[datos.length] = {name: 'kwe_ac_key_reg', value: $('input[name="kwe_ac_key_reg"]').val()};


            $.ajax({
                url: 'admin-ajax.php?action=saved_api_settings_and_events',
                method: 'post',
                data: datos,
                beforeSend: function () {
                    $(padre_box).prepend(loading_overlay);
                },
                success: function (response) {
                    $(padre_box).find('.button.button-cancel').remove();
                    $(padre_box).find('div.button.guardar').removeClass('guardar').addClass('editar').text('Editar').prev('input').attr('Disabled', 'Disabled');
                    $(padre_box).find('div.overlay').remove();
                    iziToast.success({
                        title: 'LISTO', layout: '2', message: 'Se ha realizado el registro exitosamente', position: 'topRight'
                    });
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
                                $(entrada).next('label').after('<p id="error_' + entrada.prop('id') + '" style="display: block;color: #b10000;margin: 0px;" for="' + entrada.prop('id') + '">Campo no puede estar vacio</p>');
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

        $('form[id^="form_kwe_ac"]').on('keyup', '.con_error', function () {
            if ($(this).nextAll('p[id^="error_kwe_ac"]').length) {
                $(this).nextAll('p[id^="error_kwe_ac"]').first().remove();
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
            var loading_overlay = '<div class="overlay"><div class="lds-ripple"><div></div><div></div></div></div>';
            var padre_box = $(this).closest("div.caja-op-evnt");
            var datos = $(padre_box).find(':input').serializeArray();
            datos[datos.length] = {name: 'kwe_ac_key_reg', value: $('input[name="kwe_ac_key_reg"]').val()};
            datos[datos.length] = {name: '_option_evenst_display', value: 1};

            //COMPLETAR VALIDACIN DE DATOS
            if (validacion()) {
                return;
            }

            $.ajax({
                url: 'admin-ajax.php?action=saved_api_settings_and_events',
                method: 'post',
                data: datos,
                beforeSend: function () {
                    $(this).addClass('running');
                    $(padre_box).prepend(loading_overlay);
                },
                success: function (response) {
                    if (!response.success) {
                        iziToast.error({
                            title: 'ERROR', message: 'Validacion incorrecta, Recarga la pagina Por favor!', position: 'topRight', layout: '2'
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
                    $(response.data).appendTo('.cd-panel__content > .divTable > .divTableBody').show(1000);
                    document.getElementById('form_kwe_ac').reset();
                    $(padre_box).find('div.overlay').remove();
                    iziToast.success({
                        title: 'LISTO', layout: '2', message: 'Se ha realizado el registro exitosamente', position: 'topRight'
                    });
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

        $('#form_kwe_ac').on('click', '.eliminar_evnt_kwe_ac', function (evnt) {
            evnt.preventDefault();
            var current = document.getElementsByClassName("active");
            if (current.length > 0) {
                current[0].className = current[0].className.replace(" active", "");
            }
            this.className += " active";
        });

        $('body').on('click', '#form_kwe_ac .eliminar_evnt_kwe_ac > div[class^="target-kwe_ac"] > .confirm-no', function (evnt) {
            evnt.preventDefault();
            console.log($(this).closest('.eliminar_evnt_kwe_ac'));
            $(this).closest('.eliminar_evnt_kwe_ac').removeClass('active');
        });

        $('body').on('click', '#form_kwe_ac .eliminar_evnt_kwe_ac > div[class^="target-kwe_ac"] > .confirm-yes', function (evnt) {
            evnt.preventDefault();
            $(this).closest('.eliminar_evnt_kwe_ac').removeClass('active');
            var evnt_fila_padre = $(this).closest('.divTableRow');
            var loading_overlay = '<div class="overlay"><div class="lds-ripple"><div></div><div></div></div></div>';
            var evnt_index_id = $(this).closest('.eliminar_evnt_kwe_ac').data('element-id');

            $.ajax({
                url: 'admin-ajax.php?action=remove_envt_kwe_ac',
                method: 'post',
                data: {id_evnt: evnt_index_id},
                beforeSend: function () {
                    $('div.cd-panel__content > .divTable').prepend(loading_overlay);
                },
                success: function (response) {
                    if (!response.success) {
                        iziToast.error({
                            title: 'ERROR', message: 'Hubo un problema, Recarga la pagina Por favor!', position: 'topRight', layout: '2'
                        });
                        return;
                    }

                    if (response.success) {
                        $('div.cd-panel__content > .divTable > div.overlay').remove();
                        $(evnt_fila_padre).remove();
                        if ($('div.divTableBody .divTableRow').length < 2) {
                            $('<div class="divTableRow empty_reg_event_kwe_ac"><div  style="padding: 15px;"><em style="color: #a5a5a5;">No hay registros de eventos</em></div></div>').appendTo('.cd-panel__content > .divTable > .divTableBody').show(1000);
                        }
                        iziToast.success({
                            title: 'LISTO', layout: '2', message: 'Evento eliminado con exito!', position: 'topRight'
                        });
                    }
                }
            });
        });

        /************* MANIPULACION VIDEOS **************/

        $('.caja-op-video').on('click', 'a.btn-saved-video', function (evnt) {
            evnt.preventDefault();
            var loading_overlay = '<div class="overlay"><div class="lds-ripple"><div></div><div></div></div></div>';
            //var formualrio = $(this).closest("form");
            var padre_box = $(this).closest("div.caja-op-video");
            var datos = $(padre_box).find(':input').serializeArray();
            datos[datos.length] = {name: 'kwe_ac_key_reg', value: $('input[name="kwe_ac_key_reg"]').val()};
            datos[datos.length] = {name: '_option_evenst_video_display', value: 1};

            //VALIDACION
            var index_error = false;
            $.each($('#form_kwe_ac_video input'), function (index) {
                var entrada = $(this);
                if (entrada.prop('tagName') == 'INPUT' && entrada.prop('type') == 'text') {
                    if (!($.trim($(entrada).val()) != '' && $.trim($(entrada).val()).length != 0)) {
                        index_error = true;
                        if (!$('#error_' + entrada.prop('id')).length) {
                            $(entrada).next('label').after('<p id="error_' + entrada.prop('id') + '" style="display: block;color: #b10000;margin: 0px;" for="' + entrada.prop('id') + '">Campo no puede estar vacio</p>');
                            $(entrada).addClass('con_error');
                        }
                    }
                }
            });

            if (index_error)
                return;
            
            $.ajax({
                url: 'admin-ajax.php?action=saved_api_settings_and_events',
                method: 'post',
                data: datos,
                beforeSend: function () {
                    $(this).addClass('running');
                    $(padre_box).prepend(loading_overlay);
                },
                success: function (response) {
                    if (!response.success) {
                        iziToast.error({
                            title: 'ERROR', message: 'Validacion incorrecta, Recarga la pagina Por favor!', position: 'topRight', layout: '2'
                        });
                        return;
                    }

                    if ($('.empty_reg_event_kwe_ac').length) {
                        $('.empty_reg_event_kwe_ac').remove();
                    }
                    $(padre_box).find(':input[type="text"]').val('');
                    $(padre_box).find(':input[type="checkbox"]').val('on');
                    $(padre_box).find('.rangeslider-fill-lower').css('width','229.354px');
                    $(padre_box).find('.rangeslider-thumb').css('left','217.354px'); 
                    $(response.data).appendTo('.cd-panel__content > .divTable > .divTableBody').show(1000);
                    document.getElementById('form_kwe_ac_video').reset();
                    $(padre_box).find('div.overlay').remove();
                    iziToast.success({
                        title: 'LISTO', layout: '2', message: 'Se ha realizado el registro exitosamente', position: 'topRight'
                    });
                },
            });

        });

        $('#form_kwe_ac_video').on('click', '.eliminar_evnt_kwe_ac', function (evnt) {
            evnt.preventDefault();
            var current = document.getElementsByClassName("active");
            if (current.length > 0) {
                current[0].className = current[0].className.replace(" active", "");
            }
            this.className += " active";
        });

        jQuery('body').on('click', '#form_kwe_ac_video .eliminar_evnt_kwe_ac > div[class^="target-kwe_ac"] > .confirm-no', function (evnt) {
            evnt.preventDefault();
            $(this).closest('.eliminar_evnt_kwe_ac').removeClass('active');
        });

        $('body').on('click', '#form_kwe_ac_video .eliminar_evnt_kwe_ac > div[class^="target-kwe_ac"] > .confirm-yes', function (evnt) {
            evnt.preventDefault();
            $(this).closest('.eliminar_evnt_kwe_ac').removeClass('active');
            var evnt_fila_padre = $(this).closest('.divTableRow');
            var loading_overlay = '<div class="overlay"><div class="lds-ripple"><div></div><div></div></div></div>';
            var evnt_index_id = $(this).closest('.eliminar_evnt_kwe_ac').data('element-id');

            $.ajax({
                url: 'admin-ajax.php?action=remove_video_kwe_ac',
                method: 'post',
                data: {id_video: evnt_index_id},
                beforeSend: function () {
                    $('div.cd-panel__content > .divTable').prepend(loading_overlay);
                },
                success: function (response) {
                    if (!response.success) {
                        iziToast.error({
                            title: 'ERROR', message: 'Hubo un problema, Recarga la pagina Por favor!', position: 'topRight', layout: '2'
                        });
                        return;
                    }

                    if (response.success) {
                        $('div.cd-panel__content > .divTable > div.overlay').remove();
                        $(evnt_fila_padre).remove();
                        if ($('div.divTableBody .divTableRow').length < 2) {
                            $('<div class="divTableRow empty_reg_event_kwe_ac" ><div  style="padding: 15px;"><em style="color: #a5a5a5;">No hay registros de videos</em></div></div>').appendTo('.cd-panel__content > .divTable > .divTableBody').show(1000);
                        }
                        iziToast.success({
                            title: 'LISTO', layout: '2', message: 'Video eliminado con exito!', position: 'topRight'
                        });
                    }
                }
            });
        });

        [].slice.call(document.querySelectorAll('.progress-button')).forEach(function (bttn, pos) {
            new UIProgressButton(bttn, {
                callback: function (instance) {
                    var progress = 0;
                    var interval = setInterval(function () {
                        progress = Math.min(progress + Math.random() * 0.025, 0.9);
                        instance.setProgress(progress);
                        console.log('Progreso: ' + progress);
                        if (progress === 0.9) {
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
                            if (response.success) {
                                instance.setProgress(1);
                                instance.stop(1);
                                clearInterval(interval);
                            } else {
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

        $('#form_kwe_ac_video .range-ac input[type="range"]').on('input', function (event) {
            $(this).closest('.range-ac').find('output').val($(this).val() + "%");
            event.preventDefault();
        });


        /******** range js **********/

        var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) {
            return typeof obj;
        } : function (obj) {
            return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
        };
        var _createClass = function () {
            function defineProperties(target, props) {
                for (var i = 0; i < props.length; i++) {
                    var descriptor = props[i];
                    descriptor.enumerable = descriptor.enumerable || false;
                    descriptor.configurable = true;
                    if ("value" in descriptor)
                        descriptor.writable = true;
                    Object.defineProperty(target, descriptor.key, descriptor);
                }
            }
            return function (Constructor, protoProps, staticProps) {
                if (protoProps)
                    defineProperties(Constructor.prototype, protoProps);
                if (staticProps)
                    defineProperties(Constructor, staticProps);
                return Constructor;
            };
        }();
        function _classCallCheck(instance, Constructor) {
            if (!(instance instanceof Constructor)) {
                throw new TypeError("Cannot call a class as a function");
            }
        }
        var END = 'change';
        var START = 'ontouchstart' in document ? 'touchstart' : 'mousedown';
        var INPUT = 'input';
        var MAX_ROTATION = 35;
        var SOFTEN_FACTOR = 3;
        var
                RangeInput = function () {

                    function RangeInput(el) {
                        _classCallCheck(this, RangeInput);
                        this.el = el;

                        this._handleEnd = this._handleEnd.bind(this);
                        this._handleStart = this._handleStart.bind(this);
                        this._handleInput = this._handleInput.bind(this);

                        //Call the plugin
                        $(this.el.querySelector('input[type=range]')).rangeslider({
                            polyfill: false, //Never use the native polyfill
                            rangeClass: 'rangeslider',
                            disabledClass: 'rangeslider-disabled',
                            horizontalClass: 'rangeslider-horizontal',
                            verticalClass: 'rangeslider-vertical',
                            fillClass: 'rangeslider-fill-lower',
                            handleClass: 'rangeslider-thumb',
                            onInit: function onInit() {
                                //No args are passed, so we can't change context of this
                                var pluginInstance = this;

                                //Move the range-output inside the handle so we can do all the stuff in css
                                $(pluginInstance.$element).
                                        parents('.range-ac').
                                        find('.range-output').
                                        appendTo(pluginInstance.$handle);
                            }});


                        this.sliderThumbEl = el.querySelector('.rangeslider-thumb');
                        this.outputEl = el.querySelector('.range-output');
                        this.inputEl = el.querySelector('input[type=range]');
                        this._lastOffsetLeft = 0;
                        this._lastTimeStamp = 0;

                        this.el.querySelector('.rangeslider').addEventListener(START, this._handleStart);
                    }
                    _createClass(RangeInput, [{key: '_handleStart', value: function _handleStart(
                                    e) {
                                var _this = this;
                                this._lastTimeStamp = new Date().getTime();
                                this._lastOffsetLeft = this.sliderThumbEl.offsetLeft;

                                //Wrap in raf because offsetLeft is updated by the plugin after this fires
                                requestAnimationFrame(function (_) {
                                    //Bind through jquery because plugin doesn't fire native event
                                    $(_this.inputEl).on(INPUT, _this._handleInput);
                                    $(_this.inputEl).on(END, _this._handleEnd);
                                });
                            }}, {key: '_handleEnd', value: function _handleEnd(
                                    e) {
                                var _this2 = this;
                                //Unbind through jquery because plugin doesn't fire native event
                                $(this.inputEl).off(INPUT, this._handleInput);
                                $(this.inputEl).off(END, this._handleEnd);

                                requestAnimationFrame(function (_) {
                                    return _this2.outputEl.style.transform = 'rotate(0deg)';
                                });
                            }}, {key: '_handleInput', value: function _handleInput(
                                    e) {
                                var _this3 = this;
                                var now = new Date().getTime();
                                var timeElapsed = now - this._lastTimeStamp || 1;
                                var distance = this.sliderThumbEl.offsetLeft - this._lastOffsetLeft;
                                var direction = distance < 0 ? -1 : 1;
                                var velocity = Math.abs(distance) / timeElapsed; //pixels / millisecond
                                var targetRotation = Math.min(Math.abs(distance * velocity) * SOFTEN_FACTOR, MAX_ROTATION);

                                requestAnimationFrame(function (_) {
                                    return _this3.outputEl.style.transform = 'rotate(' + targetRotation * -direction + 'deg)';
                                });

                                this._lastTimeStamp = now;
                                this._lastOffsetLeft = this.sliderThumbEl.offsetLeft;
                            }}]);
                    return RangeInput;
                }();

        /*! rangeslider.js - v2.1.1 | (c) 2016 @andreruffert | MIT license | https://github.com/andreruffert/rangeslider.js */
        !function (a) {
            "use strict";
            "function" == typeof define && define.amd ? define(["jquery"], a) : "object" == (typeof exports === 'undefined' ? 'undefined' : _typeof(exports)) ? module.exports = a(require("jquery")) : a(jQuery);
        }(function (a) {
            "use strict";
            function b() {
                var a = document.createElement("input");
                return a.setAttribute("type", "range"), "text" !== a.type;
            }
            function c(a, b) {
                var c = Array.prototype.slice.call(arguments, 2);
                return setTimeout(function () {
                    return a.apply(null, c);
                }, b);
            }
            function d(a, b) {
                return b = b || 100, function () {
                    if (!a.debouncing) {
                        var c = Array.prototype.slice.apply(arguments);
                        a.lastReturnVal = a.apply(window, c), a.debouncing = !0;
                    }
                    return clearTimeout(a.debounceTimeout), a.debounceTimeout = setTimeout(function () {
                        a.debouncing = !1;
                    }, b), a.lastReturnVal;
                };
            }
            function e(a) {
                return a && (0 === a.offsetWidth || 0 === a.offsetHeight || a.open === !1);
            }
            function f(a) {
                for (var b = [], c = a.parentNode; e(c); ) {
                    b.push(c), c = c.parentNode;
                }
                return b;
            }
            function g(a, b) {
                function c(a) {
                    "undefined" != typeof a.open && (a.open = a.open ? !1 : !0);
                }
                var d = f(a), e = d.length, g = [], h = a[b];
                if (e) {
                    for (var i = 0; e > i; i++) {
                        g[i] = d[i].style.cssText, d[i].style.setProperty ? d[i].style.setProperty("display", "block", "important") : d[i].style.cssText += ";display: block !important", d[i].style.height = "0", d[i].style.overflow = "hidden", d[i].style.visibility = "hidden", c(d[i]);
                    }
                    h = a[b];
                    for (var j = 0; e > j; j++) {
                        d[j].style.cssText = g[j], c(d[j]);
                    }
                }
                return h;
            }
            function h(a, b) {
                var c = parseFloat(a);
                return Number.isNaN(c) ? b : c;
            }
            function i(a) {
                return a.charAt(0).toUpperCase() + a.substr(1);
            }
            function j(b, e) {
                if (this.$window = a(window), this.$document = a(document), this.$element = a(b), this.options = a.extend({}, n, e), this.polyfill = this.options.polyfill, this.orientation = this.$element[0].getAttribute("data-orientation") || this.options.orientation, this.onInit = this.options.onInit, this.onSlide = this.options.onSlide, this.onSlideEnd = this.options.onSlideEnd, this.DIMENSION = o.orientation[this.orientation].dimension, this.DIRECTION = o.orientation[this.orientation].direction, this.DIRECTION_STYLE = o.orientation[this.orientation].directionStyle, this.COORDINATE = o.orientation[this.orientation].coordinate, this.polyfill && m)
                    return !1;
                this.identifier = "js-" + k + "-" + l++, this.startEvent = this.options.startEvent.join("." + this.identifier + " ") + "." + this.identifier, this.moveEvent = this.options.moveEvent.join("." + this.identifier + " ") + "." + this.identifier, this.endEvent = this.options.endEvent.join("." + this.identifier + " ") + "." + this.identifier, this.toFixed = (this.step + "").replace(".", "").length - 1, this.$fill = a('<div class="' + this.options.fillClass + '" />'), this.$handle = a('<div class="' + this.options.handleClass + '" />'), this.$range = a('<div class="' + this.options.rangeClass + " " + this.options[this.orientation + "Class"] + '" id="' + this.identifier + '" />').insertAfter(this.$element).prepend(this.$fill, this.$handle), this.$element.css({position: "absolute", width: "1px", height: "1px", overflow: "hidden", opacity: "0"}), this.handleDown = a.proxy(this.handleDown, this), this.handleMove = a.proxy(this.handleMove, this), this.handleEnd = a.proxy(this.handleEnd, this), this.init();
                var f = this;
                this.$window.on("resize." + this.identifier, d(function () {
                    c(function () {
                        f.update(!1, !1);
                    }, 300);
                }, 20)), this.$document.on(this.startEvent, "#" + this.identifier + ":not(." + this.options.disabledClass + ")", this.handleDown), this.$element.on("change." + this.identifier, function (a, b) {
                    if (!b || b.origin !== f.identifier) {
                        var c = a.target.value, d = f.getPositionFromValue(c);
                        f.setPosition(d);
                    }
                });
            }
            Number.isNaN = Number.isNaN || function (a) {
                return "number" == typeof a && a !== a;
            };
            var k = "rangeslider", l = 0, m = b(), n = {polyfill: !0, orientation: "horizontal", rangeClass: "rangeslider", disabledClass: "rangeslider--disabled", horizontalClass: "rangeslider--horizontal", verticalClass: "rangeslider--vertical", fillClass: "rangeslider__fill", handleClass: "rangeslider__handle", startEvent: ["mousedown", "touchstart", "pointerdown"], moveEvent: ["mousemove", "touchmove", "pointermove"], endEvent: ["mouseup", "touchend", "pointerup"]}, o = {orientation: {horizontal: {dimension: "width", direction: "left", directionStyle: "left", coordinate: "x"}, vertical: {dimension: "height", direction: "top", directionStyle: "bottom", coordinate: "y"}}};
            return j.prototype.init = function () {
                this.update(!0, !1), this.onInit && "function" == typeof this.onInit && this.onInit();
            }, j.prototype.update = function (a, b) {
                a = a || !1, a && (this.min = h(this.$element[0].getAttribute("min"), 0), this.max = h(this.$element[0].getAttribute("max"), 100), this.value = h(this.$element[0].value, Math.round(this.min + (this.max - this.min) / 2)), this.step = h(this.$element[0].getAttribute("step"), 1)), this.handleDimension = g(this.$handle[0], "offset" + i(this.DIMENSION)), this.rangeDimension = g(this.$range[0], "offset" + i(this.DIMENSION)), this.maxHandlePos = this.rangeDimension - this.handleDimension, this.grabPos = this.handleDimension / 2, this.position = this.getPositionFromValue(this.value), this.$element[0].disabled ? this.$range.addClass(this.options.disabledClass) : this.$range.removeClass(this.options.disabledClass), this.setPosition(this.position, b);
            }, j.prototype.handleDown = function (a) {
                if (this.$document.on(this.moveEvent, this.handleMove), this.$document.on(this.endEvent, this.handleEnd), !((" " + a.target.className + " ").replace(/[\n\t]/g, " ").indexOf(this.options.handleClass) > -1)) {
                    var b = this.getRelativePosition(a), c = this.$range[0].getBoundingClientRect()[this.DIRECTION], d = this.getPositionFromNode(this.$handle[0]) - c, e = "vertical" === this.orientation ? this.maxHandlePos - (b - this.grabPos) : b - this.grabPos;
                    this.setPosition(e), b >= d && b < d + this.handleDimension && (this.grabPos = b - d);
                }
            }, j.prototype.handleMove = function (a) {
                a.preventDefault();
                var b = this.getRelativePosition(a), c = "vertical" === this.orientation ? this.maxHandlePos - (b - this.grabPos) : b - this.grabPos;
                this.setPosition(c);
            }, j.prototype.handleEnd = function (a) {
                a.preventDefault(), this.$document.off(this.moveEvent, this.handleMove), this.$document.off(this.endEvent, this.handleEnd), this.$element.trigger("change", {origin: this.identifier}), this.onSlideEnd && "function" == typeof this.onSlideEnd && this.onSlideEnd(this.position, this.value);
            }, j.prototype.cap = function (a, b, c) {
                return b > a ? b : a > c ? c : a;
            }, j.prototype.setPosition = function (a, b) {
                var c, d;
                void 0 === b && (b = !0), c = this.getValueFromPosition(this.cap(a, 0, this.maxHandlePos)), d = this.getPositionFromValue(c), this.$fill[0].style[this.DIMENSION] = d + this.grabPos + "px", this.$handle[0].style[this.DIRECTION_STYLE] = d + "px", this.setValue(c), this.position = d, this.value = c, b && this.onSlide && "function" == typeof this.onSlide && this.onSlide(d, c);
            }, j.prototype.getPositionFromNode = function (a) {
                for (var b = 0; null !== a; ) {
                    b += a.offsetLeft, a = a.offsetParent;
                }
                return b;
            }, j.prototype.getRelativePosition = function (a) {
                var b = i(this.COORDINATE), c = this.$range[0].getBoundingClientRect()[this.DIRECTION], d = 0;
                return "undefined" != typeof a["page" + b] ? d = a["client" + b] : "undefined" != typeof a.originalEvent["client" + b] ? d = a.originalEvent["client" + b] : a.originalEvent.touches && a.originalEvent.touches[0] && "undefined" != typeof a.originalEvent.touches[0]["client" + b] ? d = a.originalEvent.touches[0]["client" + b] : a.currentPoint && "undefined" != typeof a.currentPoint[this.COORDINATE] && (d = a.currentPoint[this.COORDINATE]), d - c;
            }, j.prototype.getPositionFromValue = function (a) {
                var b, c;
                return b = (a - this.min) / (this.max - this.min), c = Number.isNaN(b) ? 0 : b * this.maxHandlePos;
            }, j.prototype.getValueFromPosition = function (a) {
                var b, c;
                return b = a / (this.maxHandlePos || 1), c = this.step * Math.round(b * (this.max - this.min) / this.step) + this.min, Number(c.toFixed(this.toFixed));
            }, j.prototype.setValue = function (a) {
                (a !== this.value || "" === this.$element[0].value) && this.$element.val(a).trigger("input", {origin: this.identifier});
            }, j.prototype.destroy = function () {
                this.$document.off("." + this.identifier), this.$window.off("." + this.identifier), this.$element.off("." + this.identifier).removeAttr("style").removeData("plugin_" + k), this.$range && this.$range.length && this.$range[0].parentNode.removeChild(this.$range[0]);
            }, a.fn[k] = function (b) {
                var c = Array.prototype.slice.call(arguments, 1);
                return this.each(function () {
                    var d = a(this), e = d.data("plugin_" + k);
                    e || d.data("plugin_" + k, e = new j(this, b)), "string" == typeof b && e[b].apply(e, c);
                });
            }, "rangeslider.js is available in jQuery context e.g $(selector).rangeslider(options);";
        });

        [].forEach.call(document.querySelectorAll('.range-ac'), function (el) {
            new RangeInput(el);
        });

        /************* PANEL SLIDE ******************/
        var panelTriggers = document.getElementsByClassName('js-cd-panel-trigger');
        if (panelTriggers.length > 0) {
            for (var i = 0; i < panelTriggers.length; i++) {
                (function (i) {
                    var panelClass = 'js-cd-panel-' + panelTriggers[i].getAttribute('data-panel'),
                            panel = document.getElementsByClassName(panelClass)[0];
                    // open panel when clicking on trigger btn
                    panelTriggers[i].addEventListener('click', function (event) {
                        event.preventDefault();
                        addClass(panel, 'cd-panel--is-visible');
                    });
                    //close panel when clicking on 'x' or outside the panel
                    panel.addEventListener('click', function (event) {
                        if (hasClass(event.target, 'js-cd-close') /*|| hasClass(event.target, panelClass)*/) {
                            event.preventDefault();
                            removeClass(panel, 'cd-panel--is-visible');
                        }
                    });
                })(i);
            }
        }

        //class manipulations - needed if classList is not supported
        //https://jaketrent.com/post/addremove-classes-raw-javascript/
        function hasClass(el, className) {
            if (el.classList)
                return el.classList.contains(className);
            else
                return !!el.className.match(new RegExp('(\\s|^)' + className + '(\\s|$)'));
        }
        function addClass(el, className) {
            if (el.classList)
                el.classList.add(className);
            else if (!hasClass(el, className))
                el.className += " " + className;
        }
        function removeClass(el, className) {
            if (el.classList)
                el.classList.remove(className);
            else if (hasClass(el, className)) {
                var reg = new RegExp('(\\s|^)' + className + '(\\s|$)');
                el.className = el.className.replace(reg, ' ');
            }
        }


    });

})(jQuery);
