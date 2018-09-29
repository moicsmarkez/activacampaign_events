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
        <div class="config_api">
            <h3>Credenciales API Developer</h3>
            <div class="caja-op">
                <label style="margin-left: 10px;" for="kwe_ac_url_api" ><b>API URL</b></label><br>
                <input type="text" placeholder="eg: https://user.api-us1.com" name="kwe_ac_url_api" id="kwe_ac_url_api" value="<?php echo get_option('kwe_ac_url_api') != '' ? get_option('kwe_ac_url_api') : ''; ?>" <?php echo get_option('kwe_ac_url_api') != '' ? 'Disabled' : ''; ?> />
                <div class="button button-primary button-large <?php echo get_option('kwe_ac_url_api') != '' ? 'editar' : 'guardar' ?> " style="margin-top: 1px;height: 35px !important;line-height: 35px !important;width: 100px;text-align: center;">
                    <?php echo get_option('kwe_ac_url_api') != '' ? 'Editar' : 'Guardar' ?>
                </div>
                <p style="margin-left: 10px;margin-top: 0px;font-size: 12px;">Este credencial lo puedes ubicar siguiendo las opciones <em>Developer > API Access > URL</em>, desde le panel de ususrio de active campaign</p>
            </div>
            <div class="caja-op">
                <label style="margin-left: 10px;" for="kwe_ac_key_api" ><b>KEY</b></label><br>
                <input type="text" placeholder="eg: ycfy9df9yeh1kjuyuf8d2..." name="kwe_ac_key_api" id="kwe_ac_key_api"  value="<?php echo get_option('kwe_ac_key_api') != '' ? substr(get_option('kwe_ac_key_api'), 0, strlen(get_option('kwe_ac_key_api')) / 4) . '....' : ''; ?>" <?php echo get_option('kwe_ac_key_api') != '' ? 'Disabled' : ''; ?>  />
                <div class="button button-primary button-large <?php echo get_option('kwe_ac_key_api') != '' ? 'editar' : 'guardar' ?> " style="margin-top: 1px;height: 35px !important;line-height: 35px !important;width: 100px;text-align: center;">
                    <?php echo get_option('kwe_ac_key_api') != '' ? 'Editar' : 'Guardar' ?>
                </div>
                <p style="margin-left: 10px;margin-top: 0px;font-size: 12px;">Este credencial lo puedes ubicar siguiendo las opciones <em>Developer > API Access > KEY</em>, desde le panel de ususrio de active campaign</p>
            </div>
            <br>
            <h3>Credenciales API Tracking Event</h3>
            <div class="caja-op">
                <label style="margin-left: 10px;" for="kwe_ac_event_key_api" ><b>EVENT KEY</b></label><br>
                <input type="text" placeholder="eg: ehjh54j2h5jhj2h3jhj12..." name="kwe_ac_event_key_api" id="kwe_ac_event_key_api" value="<?php echo get_option('kwe_ac_event_key_api') != '' ? substr(get_option('kwe_ac_event_key_api'), 0, strlen(get_option('kwe_ac_event_key_api')) / 3) . '....' : ''; ?>" <?php echo get_option('kwe_ac_event_key_api') != '' ? 'Disabled' : ''; ?>  />
                <div class="button button-primary button-large <?php echo get_option('kwe_ac_event_key_api') != '' ? 'editar' : 'guardar' ?> " style="margin-top: 1px;height: 35px !important;line-height: 35px !important;width: 100px;text-align: center;">
                    <?php echo get_option('kwe_ac_event_key_api') != '' ? 'Editar' : 'Guardar' ?>
                </div>
                <p style="margin-left: 10px;margin-top: 0px;font-size: 12px;">Desde el panel de opciones, dirigete a la opcion <em>tracking > Event Tracking > Event key</em>, copia y pega la clave generada</p>
            </div>
            <div class="caja-op">
                <label style="margin-left: 10px;" for="kwe_ac_event_actid" ><b>EVENT ACTIVITY ID</b></label><br>
                <input type="text" placeholder="eg: 654798132" name="kwe_ac_event_actid" id="kwe_ac_event_actid" value="<?php echo get_option('kwe_ac_event_actid') != '' ? get_option('kwe_ac_event_actid') : ''; ?>" <?php echo get_option('kwe_ac_event_actid') != '' ? 'Disabled' : ''; ?> />
                <div class="button button-primary button-large <?php echo get_option('kwe_ac_event_actid') != '' ? 'editar' : 'guardar' ?> " style="margin-top: 1px;height: 35px !important;line-height: 35px !important;width: 100px;text-align: center;">
                    <?php echo get_option('kwe_ac_event_actid') != '' ? 'Editar' : 'Guardar' ?>
                </div>
                <p style="margin-left: 10px;margin-top: 0px;font-size: 12px;">Desde el panel de opciones, dirigete a la opcion <em>tracking > Event Tracking > (Vinculo) Event Tracking API</em>, copia la clave <em><b>actid</b> y pegas aqui</em></p>
            </div>
            <?php wp_nonce_field('8a35d1c099d6dd9f42e07afedb148294', 'kwe_ac_key_reg', true, true); ?>
        </div>
        <div class="probar_api">
            <!-- progress button -->
            <div id="progress-button" class="progress-button elastic">
                <!-- button with text -->
                <button onclick="return false"><span>Probar Conexión <br>(API dev.)</span></button>

                <!-- svg circle for progress indication -->
                <svg class="progress-circle" width="70" height="70">
                <path d="m35,2.5c17.955803,0 32.5,14.544199 32.5,32.5c0,17.955803 -14.544197,32.5 -32.5,32.5c-17.955803,0 -32.5,-14.544197 -32.5,-32.5c0,-17.955801 14.544197,-32.5 32.5,-32.5z"/>
                </svg>

                <!-- checkmark to show on success -->
                <svg class="checkmark" width="70" height="70">
                <path d="m31.5,46.5l15.3,-23.2"/>
                <path d="m31.5,46.5l-8.5,-7.1"/>
                </svg>

                <!-- cross to show on error -->
                <svg class="cross" width="70" height="70">
                <path d="m35,35l-9.3,-9.3"/>
                <path d="m35,35l9.3,9.3"/>
                <path d="m35,35l-9.3,9.3"/>
                <path d="m35,35l9.3,-9.3"/>
                </svg>

            </div><!-- /progress-button -->
            
        </div>
    </form>

    <div style="position: absolute;bottom: 20px;right: 20px;">
        <h4 class="plugin_kwe_ac_title_footer"><a href="https://keiwebco.com" >for KeiWebCo.</a></h4>
    </div>
</div>
