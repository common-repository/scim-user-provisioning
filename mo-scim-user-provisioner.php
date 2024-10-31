<?php
/**
* Plugin Name:SCIM user provisioning
* Plugin URI: http://miniorange.com
* Description: This plugin allows user provisioning from Azure AD, Okta and OneLogin to WordPress with SCIM standard.
* Version: 1.1.1
* Author: miniOrange
*License: MIT/Expat
*License URI: https://docs.miniorange.com/mit-license
*/


require_once('mo-scim-user-provisioner-save.php');
require_once('mo-scim-user-provisioner-menu-settings.php');
require_once('mo-scim-user-provisioner-attribute-mapping.php');
require_once('feedback.php');
class scim_user_provisioner_add_on {

function __construct(){

    update_site_option('msup_scim_up_host_name','https://login.xecurify.com');
    if(is_multisite())
        add_action( 'network_admin_menu', array($this, 'msup_miniorange_menu'),11);
    else
        add_action( 'admin_menu', array( $this, 'msup_miniorange_menu' ),11 );
    add_action( 'admin_init', 'miniorange_save_setting_user_provisioning',1 );
    add_action( 'init', 'msup_scim_user_provisioning_validate' );
    register_deactivation_hook(__FILE__, array( $this, 'msup_scim_up_deactivate'));
    remove_action( 'admin_notices', array( $this, 'msup_scim_up_success_message') );
    remove_action( 'admin_notices', array( $this, 'msup_scim_up_error_message') );
    add_action( 'admin_enqueue_scripts', array( $this, 'msup_plugin_settings_script' ) );
    add_action( 'admin_enqueue_scripts', array( $this, 'msup_plugin_settings_style' ) );
    add_action( 'admin_footer', array( $this, 'msup_feedback_request' ) );
}

function msup_miniorange_menu() {
	add_menu_page('SCIM user provisioning','SCIM user provisioning', 'administrator', 'user_provisioning','user_provisioning',plugin_dir_url(__FILE__) . 'images/miniorange.png');
}
function msup_feedback_request() {
    msup_scim_display_scim_feedback_form();
}

function msup_scim_up_deactivate() {
    do_action( 'msup_scim_up_flush_cache');    
    delete_site_option('msup_scim_up_host_name');
    delete_site_option('msup_scim_up_message');
    delete_site_option('msup_scim_up_error_message');
    delete_site_option('msup_scim_idp_name');
    delete_site_option('msup_scim_up_bearer_token');
    
}
function msup_plugin_settings_style($page) {
    if($page != 'toplevel_page_user_provisioning')
    return;
        wp_enqueue_style( 'msup_scim_up_admin_settings_style', plugins_url( 'includes/css/style_settings.min.css', __FILE__ ) );
        wp_enqueue_style( 'msup_scim_up_admin_settings_styles', plugins_url( 'includes/css/style_settings.css', __FILE__ ) );
        wp_enqueue_style( 'msup_scim_up_admin_settings_phone_style', plugins_url( 'includes/css/phone.min.css', __FILE__ ) );
    }
	
function msup_plugin_settings_script($page) {
    if($page != 'toplevel_page_user_provisioning')
    return;
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'msup_scim_up_admin_settings_script', plugins_url( 'includes/js/settings.min.js', __FILE__ ) );
		wp_enqueue_script( 'msup_scim_up_admin_settings_phone_script', plugins_url('includes/js/phone.min.js', __FILE__ ) );
		
	}

function msup_scim_up_show_success_message() 
{
        remove_action( 'admin_notices', array( $this, 'msup_scim_up_success_message') );
        add_action( 'admin_notices', array( $this, 'msup_scim_up_error_message') );
    }
function msup_scim_up_show_error_message() {
        remove_action( 'admin_notices', array( $this, 'msup_scim_up_error_message') );
        add_action( 'admin_notices', array( $this, 'msup_scim_up_success_message') );
    }
function msup_scim_up_success_message() {
        $class = "error";
        $message = get_site_option('msup_scim_up_message');
        echo "<div class='" . $class . "'> <p>" . $message . "</p></div>";
    }

function msup_scim_up_error_message() {
        $class = "updated";
        $message = get_site_option('msup_scim_up_message');
        echo "<div class='" . $class . "'><p>" . $message . "</p></div>";
    }
function msup_deactivate()
{
    deactivate_plugins( __FILE__ );
    wp_redirect('plugins.php');

}

public function msup_user_provisioning_get_current_page_url() {
		$http_host = $_SERVER['HTTP_HOST'];
		if(substr($http_host, -1) == '/') {
			$http_host = substr($http_host, 0, -1);
		}
		$request_uri = $_SERVER['REQUEST_URI'];
		if(substr($request_uri, 0, 1) == '/') {
			$request_uri = substr($request_uri, 1);
		}
		$is_https = (isset($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'], 'on') == 0);
		$relay_state = 'http' . ($is_https ? 's' : '') . '://' . $http_host . '/' . $request_uri;
		return $relay_state;
	}
}

new scim_user_provisioner_add_on;
