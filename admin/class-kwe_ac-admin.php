<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       facebook.com/moicsmarkez
 * @since      1.0.0
 *
 * @package    Kwe_ac
 * @subpackage Kwe_ac/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Kwe_ac
 * @subpackage Kwe_ac/admin
 * @author     moicsmarkez <moicsmarkez@yahoo.com>
 */
class Kwe_ac_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Kwe_ac_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Kwe_ac_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class. 
         */
        if ((isset($_GET['page']) && $_GET['page'] == 'active_campaign_tracking_events') || (isset($_GET['page']) && $_GET['page'] == 'active_campaign_tracking_events_settings')) {
            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/kwe_ac-admin.css', array(), $this->version, 'all');
            wp_enqueue_style('jquery_confim', plugin_dir_url(__FILE__) . 'css/jquery-confirm.min.css', array(), $this->version, 'all');
            wp_enqueue_style('selector-kwe-ac', plugin_dir_url(__FILE__) . 'css/selectr.min.css', array(), $this->version, 'all');
            wp_enqueue_style('fontawesome-kwe-ac', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), $this->version, 'all');
        }

        return;
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Kwe_ac_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Kwe_ac_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        if ((isset($_GET['page']) && $_GET['page'] == 'active_campaign_tracking_events') || (isset($_GET['page']) && $_GET['page'] == 'active_campaign_tracking_events_settings')) {
            wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/kwe_ac-admin.js', array('jquery'), $this->version, false);
            wp_enqueue_script('jquery_confirm_' . $this->plugin_name, plugin_dir_url(__FILE__) . 'js/jquery-confirm.min.js', array('jquery'), $this->version, false);
            wp_enqueue_script('slector-kwe-ac' . $this->plugin_name, plugin_dir_url(__FILE__) . 'js/selectr.min.js', array('jquery'), $this->version, false);
            wp_enqueue_script('modenizr-custom' . $this->plugin_name, plugin_dir_url(__FILE__) . 'js/modernizr.custom.js', array(), $this->version, null, false);
            wp_enqueue_script('classie' . $this->plugin_name, plugin_dir_url(__FILE__) . 'js/classie.js', array(), $this->version, null, true);
            wp_enqueue_script('UIButtomEffect' . $this->plugin_name, plugin_dir_url(__FILE__) . 'js/uiProgressButton.js', array(), $this->version, null, true);
        }
    }

    public function menu_admin() {
        add_menu_page('Active Campaign Tracking Events', 'AC Tracking Events', 'manage_options', 'active_campaign_tracking_events_settings', array($this, 'pagina_opciones_eventos'), 'dashicons-groups', 10);
        add_submenu_page('active_campaign_tracking_events_settings', 'Active Campaign Tracking Events', 'Configuración', 'manage_options', 'active_campaign_tracking_events', array($this, 'pagina_opciones'));
        //add_submenu_page('active_campaign_tracking_events', 'Active Campaign Tracking Events', 'Configuración Api', 'manage_options', 'active_campaign_tracking_events', array($this, 'pagina_opciones'));
    }

    public function pagina_opciones() {
        include_once( plugin_dir_path(__FILE__) . 'partials/kwe_ac-admin-display.php' );
    }

    public function pagina_opciones_eventos() {
        include_once( plugin_dir_path(__FILE__) . 'partials/kwe_ac-admin-event-display.php' );
    }

    public function guardar_opciones_api() {
        if (!isset($_POST['kwe_ac_key_reg']) || !wp_verify_nonce($_POST['kwe_ac_key_reg'], '8a35d1c099d6dd9f42e07afedb148294')) {
            wp_send_json_error('Procedimiento invalido, por favor refresca la pagina! -1');
            die(-1);
        }


        if (isset($_POST['kwe_ac_url_api']) && ($_POST['kwe_ac_url_api'] != '' || !empty($_POST['kwe_ac_url_api']))) {
            update_option('kwe_ac_url_api', $_POST['kwe_ac_url_api'], false);
            wp_send_json_success('sucess');
            wp_die();
        }
        if (isset($_POST['kwe_ac_key_api']) && ($_POST['kwe_ac_key_api'] != '' || !empty($_POST['kwe_ac_key_api']))) {
            update_option('kwe_ac_key_api', $_POST['kwe_ac_key_api'], false);
            wp_send_json_success('sucess');
            wp_die();
        }
        if (isset($_POST['kwe_ac_event_key_api']) && ($_POST['kwe_ac_event_key_api'] != '' || !empty($_POST['kwe_ac_event_key_api']))) {
            update_option('kwe_ac_event_key_api', $_POST['kwe_ac_event_key_api'], false);
            wp_send_json_success('sucess');
            wp_die();
        }
        if (isset($_POST['kwe_ac_event_actid']) && ($_POST['kwe_ac_event_actid'] != '' || !empty($_POST['kwe_ac_event_actid']))) {
            update_option('kwe_ac_event_actid', $_POST['kwe_ac_event_actid'], false);
            wp_send_json_success('sucess');
            wp_die();
        }
        if (isset($_POST['_option_evenst_display']) && ( $_POST['_option_evenst_display'] != '' || !empty($_POST['_option_evenst_display']) )) {
            $reg_evento = array();

            if (!isset($_POST['kwe_ac_nmb_event']) && !($_POST['kwe_ac_nmb_event'] != '' || !empty($_POST['kwe_ac_nmb_event']))) {
                wp_send_json_error('Procedimiento invalido, por favor refresca la pagina! -3');
                die(-1);
            }
            if (!isset($_POST['kwe_ac_activador_event']) && !($_POST['kwe_ac_activador_event'] != '' || !empty($_POST['kwe_ac_activador_event']))) {
                wp_send_json_error('Procedimiento invalido, por favor refresca la pagina! -3');
                die(-1);
            }
            if (!isset($_POST['_specific_id_kwe_ac']) && !($_POST['_specific_id_kwe_ac'] != '' || !empty($_POST['_specific_id_kwe_ac']))) {
                wp_send_json_error('Procedimiento invalido, por favor refresca la pagina! -3');
                die(-1);
            }
            if (!isset($_POST['_specific_class_kwe_ac']) && !($_POST['_specific_class_kwe_ac'] != '' || !empty($_POST['_specific_class_kwe_ac']))) {
                wp_send_json_error('Procedimiento invalido, por favor refresca la pagina! -3');
                die(-1);
            }
            if (!isset($_POST['kwe_ac_pagina_event']) && !($_POST['kwe_ac_pagina_event'] != '' || !empty($_POST['kwe_ac_pagina_event']))) {
                wp_send_json_error('Procedimiento invalido, por favor refresca la pagina! -3');
                die(-1);
            }

            $opciont_reg_evento = get_option('eventos_registrados_kwe_ac', array());
            $flaG_tmp = false;
            if ($opciont_reg_evento && count($opciont_reg_evento)) {
                $reg_evento = [
                    'index_id' => 'kwe_ac_' . rand(0, 1000) . '_' . mb_strtolower(str_replace(' ', '_', $_POST['kwe_ac_nmb_event']), 'UTF-8'),
                    'nombre' => $_POST['kwe_ac_nmb_event'],
                    'activador' => $_POST['kwe_ac_activador_event'],
                    'id' => $_POST['_specific_id_kwe_ac'],
                    'clase' => $_POST['_specific_class_kwe_ac'],
                    'pagina' => in_array('all', $_POST['kwe_ac_pagina_event']) ? array('all') : $_POST['kwe_ac_pagina_event'],
                ];
                array_push($opciont_reg_evento, $reg_evento);
                update_option('eventos_registrados_kwe_ac', $opciont_reg_evento, false);
                $flaG_tmp = true;
            } else {
                $reg_evento[] = [
                    'index_id' => 'kwe_ac_' . rand(0, 1000) . '_' . mb_strtolower(str_replace(' ', '_', $_POST['kwe_ac_nmb_event']), 'UTF-8'),
                    'nombre' => $_POST['kwe_ac_nmb_event'],
                    'activador' => $_POST['kwe_ac_activador_event'],
                    'id' => $_POST['_specific_id_kwe_ac'],
                    'clase' => $_POST['_specific_class_kwe_ac'],
                    'pagina' => in_array('all', $_POST['kwe_ac_pagina_event']) ? array('all') : $_POST['kwe_ac_pagina_event'],
                ];
                update_option('eventos_registrados_kwe_ac', $reg_evento, false);
                $flaG_tmp = true;
                $reg_evento = $reg_evento[0];
            }

            if ($flaG_tmp) {
                ob_start();
                ?>
                <div class="divTableRow" style="display: none;">
                    <div class="divTableCell"><?php echo $reg_evento['nombre'] ?></div>
                    <div class="divTableCell"><?php
                        switch ($reg_evento['activador']) {
                            case '_every_link':
                                echo 'Todos lo enlaces';
                                break;
                            case '_scroll_screen_more_fifty':
                                echo 'Desplazamiento mayor';
                                break;
                            case '_scroll_screen_less_fifty':
                                echo 'Despazamiento menor';
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
                    <div class="divTableCell"><?php echo $reg_evento['id']; ?></div>
                    <div class="divTableCell"><?php echo $reg_evento['clase']; ?></div>
                    <div class="divTableCell"><?php
                        foreach ($reg_evento['pagina'] as $pagina) {
                            echo intval($pagina) ? '<a href="' . get_page_link($pagina) . '" target="_blank">' . get_the_title($pagina) . '</a><br>' : 'Todas las paginas<br>';
                        }
                        ?></div>
                    <div class="divTableCell"><div class="button eliminar_evnt_kwe_ac" data-element-id="<?php echo $reg_evento['index_id']; ?>"><i class="fa fa-trash"></i></div></div>
                </div>
                <?php
                wp_send_json_success(ob_get_clean());
                wp_die();
            }
        }

        wp_send_json_error('Procedimiento invalido, por favor refresca la pagina! -2');
        die(-1);
    }

    public function eliminar_evento() {

        $opciont_reg_evento = get_option('eventos_registrados_kwe_ac', array());

        if (isset($_POST['id_evnt']) && $_POST['id_evnt'] != '') {
            foreach ($opciont_reg_evento as $opcion_key => $opcion_valor) {
                if ($opcion_valor['index_id'] === $_POST['id_evnt']) {
                    unset($opciont_reg_evento[$opcion_key]);
                    update_option('eventos_registrados_kwe_ac', $opciont_reg_evento, false);
                    wp_send_json_success(ob_get_clean());
                    wp_die();
                }
            }
        }

        wp_send_json_error('Procedimiento invalido, por favor refresca la pagina! -2');
        die(-1);
    }

    public function capturar_hash() {
        if (isset($_GET['contact_hash']) && $_GET['contact_hash'] != '') {
            $this->cargar_dependencias();
            // load ac
            $ac = new ActiveCampaignAPI(ACTIVECAMPAIGN_URL, ACTIVECAMPAIGN_API_KEY);

            if (!(int) $ac->credentials_test()) {
                return;
                die(-1);
            }

            $hash_response = $ac->api("contact/view?hash=" . $_GET['contact_hash']);  //this is where we get the email from the hash
            if ($hash_response) {
                //CREAR COOKIES
                setcookie("_contact_hash", $_GET['contact_hash'], 60 * 60 * 24 * 30 + time(), "/", $_SERVER['HTTP_HOST']);
            }
        }
        
    }

    private function cargar_dependencias() {
        if (!defined("ACTIVECAMPAIGN_URL")) {
            define("ACTIVECAMPAIGN_URL", get_option('kwe_ac_url_api'));
        }
        if (!defined("ACTIVECAMPAIGN_API_KEY")) {
            define("ACTIVECAMPAIGN_API_KEY", get_option('kwe_ac_key_api'));
        }

        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/ac/ActiveCampaign.class.php';
    }

    public function ac_check() {
        $this->cargar_dependencias();
        // load ac
        $ac = new ActiveCampaignAPI(ACTIVECAMPAIGN_URL, ACTIVECAMPAIGN_API_KEY);

        if (!(int) $ac->credentials_test()) {
            wp_send_json_error();
            die(-1);
        }
        wp_send_json_success();
        die(-1);
    }
    
    public function kwe_ac_shortcode_button(){
        global $typenow;
        if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
            if( in_array( $typenow, array( 'post', 'page' ) ) ) {
                if ( get_user_option( 'rich_editing' ) == 'true') {
                    add_filter( 'mce_external_plugins', array($this,'popups_add_tinymce_plugin') );
                    add_filter( 'mce_buttons', array($this,'popups_register_button') );
                }
            }
        }
    }
    
    public function popups_add_tinymce_plugin($plugin_array){
        $plugin_array['popups_kwe_ac_button'] = plugin_dir_url(__FILE__) . 'js/popup_kwe_ac_sc.js';
    	return $plugin_array;
    }
    
    public function popups_register_button($buttons){
       array_push($buttons, 'popups_kwe_ac_button');
       return $buttons;
    }

}
