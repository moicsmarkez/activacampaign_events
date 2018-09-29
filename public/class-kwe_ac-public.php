<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       facebook.com/moicsmarkez
 * @since      1.0.0
 *
 * @package    Kwe_ac
 * @subpackage Kwe_ac/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Kwe_ac
 * @subpackage Kwe_ac/public
 * @author     moicsmarkez <moicsmarkez@yahoo.com>
 */
class Kwe_ac_Public {

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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        $this->cargar_dependencias();
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/kwe_ac-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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
        wp_register_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/kwe_ac-public.js', array('jquery'), $this->version, true);
        $opciont_reg_evento = get_option('eventos_registrados_kwe_ac', array());
        foreach ($opciont_reg_evento as $opcion_key => $opcion_value) {
            if (!in_array(get_the_ID(), $opcion_value['pagina']) && !in_array('all', $opcion_value['pagina'])) {
                unset($opciont_reg_evento[$opcion_key]);
            }
        }
        $opciont_reg_evento = array_values($opciont_reg_evento);
        wp_localize_script($this->plugin_name, 'activecampaignevent', array('ajax_url' => admin_url('admin-ajax.php')));
        wp_localize_script($this->plugin_name, 'evnto_opciones_kwe_ac', $opciont_reg_evento);
        wp_enqueue_script($this->plugin_name);
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

    public function ac_event() {
        // load ac
        $ac = new ActiveCampaignAPI(ACTIVECAMPAIGN_URL, ACTIVECAMPAIGN_API_KEY);

        if (!(int) $ac->credentials_test()) {
            echo 'Access denied: Invalid credentials (URL and/or API key).';
            exit();
        }

        // track event
        $ac->track_actid = get_option('kwe_ac_event_actid');
        $ac->track_key = get_option('kwe_ac_event_key_api');

        if (isset($_COOKIE['_contact_hash'])) {
            $hash = $_COOKIE['_contact_hash'];
            $hash_response = $ac->api("contact/view?hash=$hash");  //this is where we get the email from the hash
            $ac->track_email = $hash_response->email;
        } elseif (isset($_COOKIE['email'])) {
            $ac->track_email = $_COOKIE['email'];
        }


        $response = $ac->api('tracking/log', array(
            'event' => $_POST['event'],
            'eventdata' => $_POST['eventdata'],
        ));


        echo json_encode($response);
        die();
    }

    private function get_cookie_hash(){
        return $_COOKIE['_contact_hash'];
    }
    
    private function is_cookie_hash(){
        return isset($_COOKIE['_contact_hash']);
    }
    
    private function shortcode_kwe_ac_result($param){
        if ($this->is_cookie_hash()) {
            $result='';
            $ac = new ActiveCampaignAPI(ACTIVECAMPAIGN_URL, ACTIVECAMPAIGN_API_KEY);

            if (!(int) $ac->credentials_test()) {
                return;
                die(-1);
            }

            $hash = $this->get_cookie_hash();
            $hash_response = $ac->api("contact/view?hash=$hash");  //this is where we get the email from the hash
            if ($hash_response) {
                switch($param){
                    case 'fullname':
                        $fName = $hash_response->first_name;
                        $lName = $hash_response->last_name;
                        $result = "<span class='ac_shortcode_fullname'>$fName $lName</span>";        
                        break;
                    case 'email': 
                        $emailc = $hash_response->email;
                        $result = "<span class='ac_shortcode_email'>$emailc</span>";        
                        break;
                    case 'firstname': 
                        $fName = $hash_response->first_name;
                        $result = "<span class='ac_shortcode_email'>$fName</span>";        
                        break;
                }
            }
        }
        return $result;
    } 
    
    public function kwe_ac_shortc_fullname() {
        define( 'DONOTCACHEPAGE', true );
        $result = $this->shortcode_kwe_ac_result('fullname');
        if(!$result){ return '';}
        return $result;
    }
    
    public function kwe_ac_shortc_email() {
        define( 'DONOTCACHEPAGE', true );
        $result = $this->shortcode_kwe_ac_result('email');
        if(!$result){ return '';}
        return $result;
    }
    
    public function kwe_ac_shortc_firstname() {
        define( 'DONOTCACHEPAGE', true );
        $result = $this->shortcode_kwe_ac_result('firstname');
        if(!$result){ return '';}
        return $result;
    }

}
