(function ($) {
    'use strict';

    /**
     * All of the code for your public-facing JavaScript source
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
    function ac_event(event, eventdata) {
        return ajax({
            url: activecampaignevent.ajax_url,
            type: 'POST',
            data: {
                action: 'ac_event',
                event: event,
                eventdata: eventdata
            },
            success: function (response) {
                console.log('response', response);
            }
        });

        function ajax(options) {
            var request = new XMLHttpRequest();
            var url = options.url;
            var data = encodeData(options.data);

            if (options.type === 'GET') {
                url = url + (data.length ? '?' + data : '');
            }
            request.open(options.type, options.url, true);
            request.onreadystatechange = onreadystatechange;

            if (options.type === 'POST') {
                request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
                request.send(data);
            } else {
                request.send(null);
            }
            return;

            function onreadystatechange() {
                if (request.readyState === 4 && request.status === 200) {
                    options.success(request.responseText);
                }
            }
            function encodeData(data) {
                var query = [];
                for (var key in data) {
                    var field = encodeURIComponent(key) + '=' + encodeURIComponent(data[key]);
                    query.push(field);
                }
                return query.join('&');
            }
        }
    }


    $(function () {


        //MANJEADOR DE EVENTOS
        /* Para todos lo enlaces tipo elemento <a> */
        var todos_los_enlaces = $.grep(evnto_opciones_kwe_ac, function (element) {
            return element.activador === "_every_link";
        });
        if (todos_los_enlaces != null && todos_los_enlaces.length) {
            $('body').on('click', 'a', function () {
                let vinculo = $(this).attr('href');
                $.each(todos_los_enlaces, function (index, value) {
                    ac_event(value.nombre, 'Usuario clickeo en: ' + vinculo);
                })
            });
        }

        /* Para los enlaces por id o clase de cualquier elemento */
        var elem_especifico = $.grep(evnto_opciones_kwe_ac, function (element) {
            return element.activador === "_specific_link";
        });

        if (elem_especifico != null && elem_especifico.length) {
            $.each(elem_especifico, function (index, value) {
                if (value.id && document.getElementById(value.id).length) {
                    let elem_id = document.getElementById(value.id);
                    elem_id.addEventListener('click', function () {
                        ac_event(value.nombre, 'Ha pulsado sobre el boton (id): ' + value.id + ' desde ' + window.location.href);
                        return false;
                    }, false);
                } else if (value.clase && document.getElementsByClassName(value.clase).length) {
                    let elem_c = document.getElementsByClassName(value.clase);
                    $.each(elem_c, function (index, element) {
                        element.addEventListener('click', function () {
                            ac_event(value.nombre, 'Ha pulsado sobre el boton (class): ' + value.clase + ' desde ' + window.location.href);
                            return false;
                        }, false);
                    });
                }
            });
        }


        /* Para los desplazamiento de pantalla*/
        var screen_desplazamiento_mayor = $.grep(evnto_opciones_kwe_ac, function (element) {
            return element.activador === "_scroll_screen_more_fifty";
        });

        var screen_desplazamiento_menor = $.grep(evnto_opciones_kwe_ac, function (element) {
            return element.activador === "_scroll_screen_less_fifty";
        });

        if ((screen_desplazamiento_mayor != null && screen_desplazamiento_mayor.length) || (screen_desplazamiento_menor != null && screen_desplazamiento_menor.length)) {
            let halfwayHeight = document.body.scrollHeight / 2;
            let hasNotScrolledHalfway = true;
            let scroll_init = false;

            window.addEventListener("scroll", () => {
                scroll_init = true;
            });

            $.each(screen_desplazamiento_mayor, function (index, screen) {
                window.addEventListener("scroll", () => {
                    if (document.scrollingElement.scrollTop > halfwayHeight && hasNotScrolledHalfway) {
                        hasNotScrolledHalfway = false;
                        ac_event(screen.nombre, 'Cliente ha revisado mas de la mitad en la pagina, Url: ' + window.location.href);
                    }
                });
            });
            window.onbeforeunload = function (event) {
                $.each(screen_desplazamiento_menor, function (index, scree_m) {
                    if (hasNotScrolledHalfway && scroll_init) {
                        ac_event(scree_m.nombre, 'Cliente NO reviso mas de la mitad en la pagina, Url: ' + window.location.href);
                    }
                });
            };

        }


    });
})(jQuery);
