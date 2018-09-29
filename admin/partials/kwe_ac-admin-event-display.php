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
        <h3>Registrar seguimiento de un evento</h3>
        <div class="caja-op-evnt" >
            <div class="op-caja-op">
                <label style="margin-left: 10px;" for="kwe_ac_nmb_event" ><b>NOMBRE</b></label><br>
                <input type="text" placeholder="eg: _clicked (*)" name="kwe_ac_nmb_event" id="kwe_ac_nmb_event" required="true"/>
                <p style="margin-left: 10px;margin-top: 0px;font-size: 11px;">Nombre del event, este de creara en ActiveCampaign</p>
            </div>
            <div class="op-caja-op">
                <label style="margin-left: 10px;" for="kwe_ac_activador_event" ><b>ACTIVADOR</b></label><br>
                <select name="kwe_ac_activador_event" id="kwe_ac_activador_event"  required="true">
                    <option value="">Seleccione una opcion(*)</option>
                    <option value="_every_link">Todos los enlaces</option>
                    <option value="_specific_link">Enlace (o elemento) determinado</option>
                    <option value="_scroll_screen_less_fifty">Desplazamiento de pantalla menos del 50%</option>
                    <option value="_scroll_screen_more_fifty">Desplazamiento de pantalla mas del 50%</option>
                </select>
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
                <label style="margin-left: 10px;" for="kwe_ac_pagina_event" ><b>PAGINA</b></label><br>
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
                <p style="margin-left: 10px;margin-top: 0px;font-size: 11px;">Especifica la pagina donde quisieras se escuche el evento</p>
            </div>
            <div class="button button-primary button-large agregar_evnt" style="margin-top: 1px;height: 35px !important;line-height: 35px !important;width: 100px;text-align: center;">
                Agregar
            </div>
        </div>
        <div class="tabla-kwe-ac-events">
            <div style="padding: 15px 0px;text-align: center" colspan="6"><h3 style="margin: 0;">EVENTOS REGISTRADOS</h3></div>
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
                        echo '<div class="divTableRow empty_reg_event_kwe_ac"><div  style="padding: 15px;"><em style="color: #a5a5a5;">No hay registros de eventos</em></div></div>';
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
                                <div class="divTableCell"><div class="button eliminar_evnt_kwe_ac" data-element-id="<?php echo $value['index_id']; ?>"><i class="fa fa-trash"></i></div></div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php wp_nonce_field('8a35d1c099d6dd9f42e07afedb148294', 'kwe_ac_key_reg', true, true); ?>
    </form>
    <div style="position: absolute;bottom: 20px;right: 20px;">
        <h4 class="plugin_kwe_ac_title_footer"><a href="https://keiwebco.com" >for KeiWebCo.</a></h4>
    </div>
</div>
