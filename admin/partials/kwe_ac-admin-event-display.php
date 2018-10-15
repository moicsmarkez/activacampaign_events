<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       facebook.com/moicsmarkez
 * @since      1.0.0
 *
 * @package    Kwe_ac
 * @subpackage Kwe_ac/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h1 class="plugin_kwe_ac_title" ><?php echo esc_html(get_admin_page_title()); ?></h1>

<div id="contenedor_kwe_ac">
    <br>
    <br>
    <form id="form_kwe_ac">
        <div class="caja-op-evnt" >
            <div class="op-caja-op">
                <input style="text-indent: 4%;" class="etq" type="text" placeholder="eg: _clicked (*)" name="kwe_ac_nmb_event" id="kwe_ac_nmb_event" required="true"/>
                <label style="margin-left: 10px;" for="kwe_ac_nmb_event" ><b>Nombre</b></label>
                <p style="margin-left: 10px;margin-top: 0px;font-size: 11px;">Nombre del event, este de creara en ActiveCampaign</p>
            </div>
            <div class="op-caja-op">
                <select name="kwe_ac_activador_event" id="kwe_ac_activador_event"  required="true">
                    <option value="">Seleccione una opcion(*)</option>
                    <option value="_every_link">Todos los enlaces</option>
                    <option value="_specific_link">Enlace (o elemento) determinado</option>
                    <option value="_scroll_screen_less_fifty">Desplazamiento de pantalla menos del 50%</option>
                    <option value="_scroll_screen_more_fifty">Desplazamiento de pantalla mas del 50%</option>
                </select>
                <label style="margin-left: 10px;" for="kwe_ac_activador_event" ><b>Activador</b></label>
                <div style="display: none;" id="id_or_class_specific" >
                    <label><input type="checkbox" id="_ids" required="true"/> <b>ID</b> </label>
                    <label><input type="checkbox" id="_clasess" required="true" /> <b>Clase</b> </label>
                    <br>
                    <input style="display: none;"  id="_specific_id_kwe_ac" name="_specific_id_kwe_ac" type="text" placeholder="ID eg: btn-comprar (NO UTILIZAR #) (*)" required="true"/>
                    <input style="display: none;"  id="_specific_class_kwe_ac" name="_specific_class_kwe_ac" type="text" placeholder="Clase eg: btn-comprar (NO UTILIZAR .) (*)" required="true"/>
                </div>
                <p style="margin-left: 10px;margin-top: 0px;font-size: 11px;">Activador para notificar seguimiento del event</p>
            </div>
            <div class="op-caja-op">
                <select name="kwe_ac_pagina_event[]" multiple="" id="kwe_ac_pagina_event" required="true" >
                    <option value="all">Todas las paginas</option>
                    <?php
                    $pages = get_pages();
                    foreach ($pages as $pagg) {
                        $option = '<option value="' . $pagg->ID . '">';
                        $option .= $pagg->post_title;
                        $option .= '</option>';
                        echo $option;
                    }
                    ?>
                </select>
                <label style="margin-left: 10px;" for="kwe_ac_pagina_event" ><b>Pagina</b></label>
                <p style="margin-left: 10px;margin-top: 0px;font-size: 11px;">Especifica la pagina donde quisieras se escuche el evento</p>
            </div>
            <a class="button agregar_evnt" href="#" style="border: 1px solid rgba(0, 0, 0, 0); display: block; width: 120px; font-size: 1.2em; text-align: center; padding: 10px; background: rgb(0, 115, 170); box-shadow: rgb(95, 95, 95) 0px -3px 5px -3px; text-decoration: none; color: rgb(255, 255, 255); font-weight: 900; transition: background 0.6s ease 0s; height: auto !important; transform: translate(5%, 25px) !important;" onmouseover="this.style.background = '#25b638'" onmouseout="this.style.background = '#0073aa'">
                <i class="fa fa-floppy-o" style="font-size: 1.5em;vertical-align: baseline;"></i>
                Guardar
            </a>
        </div>
        <div class="cd-panel cd-panel--from-right js-cd-panel-main">
            <header class="cd-panel__header">
                <h1>TODOS LOS EVENTOS REGISTRADOS</h1>
                <a href="#0" class="cd-panel__close js-cd-close">Close</a>
            </header>

            <div class="cd-panel__container">
                <div class="cd-panel__content">
                    <div class="divTable">
                        <div class="divTableBody">
                            <div class="divTableRow">
                                <div class="divTableHead">NOMBRE</div>
                                <div class="divTableHead">ACTIVADOR <br>(elemento)</div>
                                <div class="divTableHead">ID</div>
                                <div class="divTableHead">CLASE</div>
                                <div class="divTableHead">PAGINAS</div>
                                <div class="divTableHead">ELIMINAR</div>
                            </div>
                            <?php
                            $opciont_reg_evento = get_option('eventos_registrados_kwe_ac', array());
                            if (!$opciont_reg_evento) {
                                echo '<div class="divTableRow empty_reg_event_kwe_ac" ><div  style="padding: 15px;"><em style="color: #a5a5a5;">No hay registros de eventos</em></div></div>';
                            }
                            ?>
                            <?php
                            if ($opciont_reg_evento) {
                                foreach ($opciont_reg_evento as $key => $value) {
                                    ?><div class="divTableRow">
                                        <div class="divTableCell"><?php echo $value['nombre'] ?></div>
                                        <div class="divTableCell"><?php
                                            switch ($value['activador']) {
                                                case '_every_link':
                                                    echo 'Todos lo enlaces';
                                                    break;
                                                case '_scroll_screen_more_fifty':
                                                    echo 'Despazamiento mayor';
                                                    break;
                                                case '_scroll_screen_less_fifty':
                                                    echo 'Desplazamiento menor';
                                                    break;
                                                case '_element_specific':
                                                    echo 'Elemento especifico';
                                                    break;
                                                case '_specific_link':
                                                    echo 'Vinculo especifico';
                                                    break;

                                                default:
                                                    break;
                                            }
                                            ?></div>
                                        <div class="divTableCell"><?php echo $value['id']; ?></div>
                                        <div class="divTableCell"><?php echo $value['clase']; ?></div>
                                        <div class="divTableCell"><?php
                                            foreach ($value['pagina'] as $pagina) {
                                                echo intval($pagina) ? '<a href="' . get_page_link($pagina) . '" target="_blank">' . get_the_title($pagina) . '</a><br>' : 'Todas las paginas<br>';
                                            }
                                            ?></div>
                                        <div class="divTableCell">
                                            <div class="button eliminar_evnt_kwe_ac" data-element-id="<?php echo $value['index_id']; ?>">
                                                <i class="fa fa-trash"></i>
                                                <div class="target-<?php echo $value['index_id']; ?> ">
                                                    <span><b>Seguro?</b></span>
                                                    <br>
                                                    <span class="confirm-yes"> SI </span><span class="confirm-no"> NO </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div> <!-- cd-panel__content -->
            </div> <!-- cd-panel__container -->
        </div>
        <a style="right: -11%;" href="#0" class="btn-panel-table js-cd-panel-trigger" data-panel="main">
            <div class="content-a">
                <span>
                    <img style="vertical-align: middle;margin-bottom: 5px;width: 40px;" src="<?php echo plugin_dir_url(__FILE__) ?>../../shared/img/drag.png">
                </span>
                <span style="font-weight: 900;">EVENTOS</span>
            </div>
        </a>
        <?php wp_nonce_field('8a35d1c099d6dd9f42e07afedb148294', 'kwe_ac_key_reg', true, true); ?>
    </form>
    <div style="position: absolute;bottom: 20px;right: 20px;">
        <h4 class="plugin_kwe_ac_title_footer"><a href="https://keiwebco.com" >for KeiWebCo.</a></h4>
    </div>
</div>
