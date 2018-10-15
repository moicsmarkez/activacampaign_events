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
<h1 class="plugin_kwe_ac_title" ><?php echo esc_html(get_admin_page_title()); ?></h1>
<div id="contenedor_kwe_ac">
    <br>
    <br> 
    <form id="form_kwe_ac_video"> 
        <div class="caja-op-video" >
            <div class="op-caja-op">
                <span>
                    <input class="etq" type="text" placeholder="eg: Nuevo video lanzamiento de producto" name="kwe_ac_nmb_video" id="kwe_ac_nmb_video" required="true" style="text-indent: 8%"/>
                    <label for="kwe_ac_nmb_video" ><b>Nombre del Video</b></label>
                    <span class="kwe-ac-tooltip">
                        ?
                        <span class="info">
                            <span class="pronounce">Para que Titulo?</span>
                            <span class="text">Te ayudara a reconocer que video estas siguiendo e identificar el interes de tus usuarios visitantes.</span>
                        </span>
                    </span>
                </span>
                <p style="margin-left: 10px;margin-top: 0px;font-size: 11px;">Nombre para identificar el video (puede ser o no utilizado en la etiqueta de AC)</p>
            </div>
            <div class="op-caja-op">
                <span>
                    <input class="etq" type="text" placeholder="eg: vdFg1h" name="kwe_ac_id_video" id="kwe_ac_id_video" required="true" style="text-indent: 2%"/>
                    <label for="kwe_ac_id_video" ><b>ID (Video)</b></label>
                    <span class="kwe-ac-tooltip">
                        ?
                        <span class="info">
                            <span class="pronounce">Encontrar Identificador, donde?</span>
                            <span class="text">Siempre que tu vídeo de Wistia sea público, el enlace para compartir el vídeo incluirá el identificador único al final de la URL. Por ejemplo, <b>vdFg1h</b> a continuación: http://home.wistia.com/m/vdFg1h</span>
                        </span> 
                    </span>
                </span>
                <p style="margin-left: 10px;margin-top: 0px;font-size: 11px;">Identificador del Video Wistia al cual hacer referencia de seguimiento</p>
            </div>
            <div class="op-caja-op">
                <span>
                    <input class="etq" type="text" placeholder="eg: [VIDEO] %video_titulo% - Ha visto un %video_porcentaje% - en un tiempo de %video_tiempo%"  name="kwe_ac_tag_video" id="kwe_ac_tag_video" required="true" style="text-indent: 13%"/>
                    <label for="kwe_ac_tag_video" ><b>Personalizar Etiqueta AC</b></label>
                    <span class="kwe-ac-tooltip">
                        ?
                        <span class="info">
                            <span class="pronounce">Personalizar, que son esos %video%?</span>
                            <span class="text">Son shortcodes, que te ayudaran a mostrar el valor de estos en la etiqueta, ejemplo de algunos shortcodes:<br><span><b>Video Id:</b> %video_id%</span><br><span><b>Video Porcentaje:</b> %video_porcentaje%</span><br><span><b>Video Titulo:</b> %video_titulo%</span><br><span><b>Video Tiempo(visto):</b> %video_tiempo%</span> </span>
                        </span>
                    </span>
                </span>
                <p style="margin-left: 10px;margin-top: 0px;font-size: 11px;">Formato como desea agregar la etiqueta en Ac para usuarios</p>
            </div>
            <div class="op-caja-op range-ac" style="width: 80%" >
                <br>
                <div>
                    <span class="kwe-ac-tooltip" style="margin: 5px 0px 5px 175px !important; letter-spacing: 0px; right: -3%" >
                        <span>?</span>
                        <span class="info">
                            <span class="pronounce">Porcentaje, basado en?</span>
                            <span class="text">Este porcentaje se basa en lo que ha visto el usuario en relacion a tiempo, <b>no quiere</b> decir que si salta del 2% al 20% se activara, <b>sino mas bien</b> especifica si el usuario vio el video 20% en relacion al tiempo total del video.</span>
                        </span>
                    </span><br> 
                    <div class="percent" style="padding: 10px 25px 5px;border: 2px solid #e6e6e6;margin: -15px 0px;border-radius: 15px;width: 95.7%;display: inline-block;">
                        <!--<input class="kwe-ac-tgl kwe-ac-tgl-skewed" name="smaller_than" id="smaller_than" value="on" type="checkbox" />
                        <label style="width: 70px;" class="tgl-btn" data-tg-off="Encima" data-tg-on="Inferior" for="smaller_than"></label>-->
                        <br>
                        <input type="range" name="kwe_ac_percent_video" id="kwe_ac_percent_video" min="1" max="100" step="1" value="30"/>
                        <div class="range-output">
                            <output class="output" name="output" for="range">
                                30%
                            </output> 
                        </div>
                        <p style="margin-top: 0px;font-size: 11px;">Porcentaje del video visto para activar la notificacion del evento.</p>
                    </div>
                    <div style="display: inline-block;width: 40%;height: 160px;vertical-align: top;margin-top: 6px;">
                        <a class="btn-saved-video" href="#" style="border: 1px solid rgba(0, 0, 0, 0);display: block;width: 120px;font-size: 1.2em;text-align: center;padding: 10px;background: rgb(0, 115, 170);box-shadow: rgb(95, 95, 95) 0px -3px 5px -3px;text-decoration: none;color: rgb(255, 255, 255);font-weight: 900;transition: background 0.6s ease 0s;transform: translate(5%, 25px) !important;" onmouseover="this.style.background = '#25b638'" onmouseout="this.style.background = '#0073aa'">
                            <i class="fa fa-floppy-o" style="font-size: 1.5em;vertical-align: baseline;"></i>
                            Guardar
                        </a> 
                    </div>
                    <label class="label-rage" for="kwe_ac_percent_video" ><b>Porcentaje activador del evento</b></label>
                </div>
            </div> 
        </div> 
        <div class="cd-panel cd-panel--from-right js-cd-panel-main">
            <header class="cd-panel__header">
                <h1>TODOS LOS VIDEOS REGISTRADOS</h1>
                <a href="#0" class="cd-panel__close js-cd-close">Close</a>
            </header>

            <div class="cd-panel__container">
                <div class="cd-panel__content">
                    <div class="divTable" style="width: 95% !important">
                        <div class="divTableBody">
                            <div class="divTableRow">
                                <div class="divTableHead">ID</div>
                                <div class="divTableHead">NOMBRE</div>
                                <div class="divTableHead">ACTIVADOR</div>
                                <div class="divTableHead">ETIQUETA</div>
                                <div class="divTableHead">ELIMINAR</div>
                            </div>
                            <?php
                            $opciont_reg_evento_video = get_option('videos_registrados_kwe_ac', array());
                            if (!$opciont_reg_evento_video) {
                                echo '<div class="divTableRow empty_reg_event_kwe_ac" ><div  style="padding: 15px;"><em style="color: #a5a5a5;">No hay registros de videos</em></div></div>';
                            }
                            ?>
                            <?php
                            if ($opciont_reg_evento_video) {
                                foreach ($opciont_reg_evento_video as $key => $value) {
                                    ?><div class="divTableRow">
                                        <div class="divTableCell"><?php echo $value['vid_id'];?></div>
                                        <div class="divTableCell"><?php echo $value['vid_T']; ?></div>
                                        <div class="divTableCell"><?php echo /*$value['vid_A'] == on ? '(Menos de) '.$value['vid_P'].'%' : '(Mas de) '.*/$value['vid_P'].'%'; ?></div>
                                        <div class="divTableCell"><?php echo $value['vid_E']; ?></div>
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
        <a style="right: -8.5%;" href="#0" class="btn-panel-table js-cd-panel-trigger" data-panel="main">
            <div class="content-a">
                <span>
                    <img style="vertical-align: middle;margin-bottom: 5px;width: 40px;" src="<?php echo plugin_dir_url(__FILE__) ?>../../shared/img/drag.png">
                </span>
                <span style="font-weight: 900;">VIDEOS</span>
            </div>
        </a>
    </form>
</div>
<?php wp_nonce_field('8a35d1c099d6dd9f42e07afedb148294', 'kwe_ac_key_reg', true, true); ?> 