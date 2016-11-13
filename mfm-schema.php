<?php
/**
 * Plugin Name: MFM Schema.org Markup
 * Plugin URI: http://www.monkeyfishmarketing.com  
 * Description: This plugin will implement Schema.org markup onto the website
 * Version: 2.1
 * Author: Billy Bleasdale
 * License: GPL2
 */


if(!function_exists('mfm_menu')){
    add_action('admin_menu', 'mfm_menu');

    function mfm_menu() {
        add_menu_page('MonkeyFish', 'MonkeyFish', 'manage_options', 'mfm_menu', 'mfmMain',plugins_url( 'mfm-schema/images/mfm-logo.png'));
        add_submenu_page( 'mfm_menu','Welcome','Welcome', 'manage_options',   'mfm_menu',   '__return_null' );
    }
    
    function mfmMain(){
        echo "<h1>Welcome to Monkeyfish Marketing</h1>";
    }
    
}




add_action('admin_menu', 'mfm_schema');

function mfm_schema() {
    add_submenu_page('mfm_menu','MFM Schema', 'MFM Schema', 'manage_options', 'mfm_schema', 'mfmSchema');
    
}


require_once( plugin_dir_path( __FILE__ ) .'auto-updates.php' );
if ( is_admin() ) {
    new GitHubPluginUpdater( __FILE__, 'bab2k7', "mfm-schema" );
}


include( plugin_dir_path( __FILE__ ) . 'inc/schemaoutput.php');
include( plugin_dir_path( __FILE__ ) . 'inc/globalschema.php');

if ( is_admin() ){ // admin actions
  add_action( 'admin_init', 'register_mfmrmsettings' );
} else {
  // non-admin enqueues, actions, and filters
}

function register_mfmrmsettings() { // whitelist options
    /* Global Settings */
    register_setting( 'mfm-schema-global', 'org-enabled' );
    
    /* Organisation Data */
    register_setting( 'mfm-schema-global', 'org-brand' );
    register_setting( 'mfm-schema-global', 'org-website_url' );
    register_setting( 'mfm-schema-global', 'org-logo_url' );
    register_setting( 'mfm-schema-global', 'org-telephone' );
    register_setting( 'mfm-schema-global', 'org-fax' );
    register_setting( 'mfm-schema-global', 'org-email' );
    register_setting( 'mfm-schema-global', 'org-street' );
    register_setting( 'mfm-schema-global', 'org-town' );
    register_setting( 'mfm-schema-global', 'org-county' );
    register_setting( 'mfm-schema-global', 'org-postcode' );
    register_setting( 'mfm-schema-global', 'org-country' );
    
    /* Place Data */
    register_setting( 'mfm-schema-global', 'place-enabled' );
    register_setting( 'mfm-schema-global', 'place-photo' );
    register_setting( 'mfm-schema-global', 'place-latitude' );
    register_setting( 'mfm-schema-global', 'place-longitude' );
    
    /* Local Data */
    register_setting( 'mfm-schema-global', 'local-enabled' );
    register_setting( 'mfm-schema-global', 'local-close-times-mon' );
    register_setting( 'mfm-schema-global', 'local-close-times-tue' );
    register_setting( 'mfm-schema-global', 'local-close-times-wed' );
    register_setting( 'mfm-schema-global', 'local-close-times-thu' );
    register_setting( 'mfm-schema-global', 'local-close-times-fri' );
    register_setting( 'mfm-schema-global', 'local-close-times-sat' );
    register_setting( 'mfm-schema-global', 'local-close-times-sun' );
    
    register_setting( 'mfm-schema-global', 'local-open-times-mon' );
    register_setting( 'mfm-schema-global', 'local-open-times-tue' );
    register_setting( 'mfm-schema-global', 'local-open-times-wed' );
    register_setting( 'mfm-schema-global', 'local-open-times-thu' );
    register_setting( 'mfm-schema-global', 'local-open-times-fri' );
    register_setting( 'mfm-schema-global', 'local-open-times-sat' );
    register_setting( 'mfm-schema-global', 'local-open-times-sun' );
    
    /* Breadcrumbs Data */
    register_setting( 'mfm-schema-global', 'breadcrumbs-enabled' );
    
    /* Article Data */
    register_setting( 'mfm-schema-global', 'article-enabled' );
    register_setting( 'mfm-schema-global', 'art-cats' );
    
}


add_action('admin_head', 'mfm_schema_admin_inc');
function mfm_schema_admin_inc() {
    echo '
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>                       
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

';
    echo '<link rel="stylesheet" href="'.plugin_dir_url(dirname(__FILE__)).'mfm-schema/css/styles.css" type="text/css" media="all" />';
}

add_action( 'wp_footer', 'outputSchema' );



 
// function to create the DB / Options / Defaults					
function mfm_schema_install() {
   	global $wpdb;
  	global $table_name;
        $table_name = $wpdb->prefix . 'mfm_schema_plugins';
	// create the ECPT metabox database table
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) 
	{
		$sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
		`id` mediumint(9) NOT NULL AUTO_INCREMENT,
		`plugin_name` mediumtext NOT NULL,
		`plugin_tidy_name` tinytext NOT NULL,
		UNIQUE KEY id (id)
		);";
 
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
 
}
// run the install scripts upon plugin activation
register_activation_hook(__FILE__,'mfm_schema_install');

// Remove auto generated feed links
function my_remove_feeds() {
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 );
}
add_action( 'after_setup_theme', 'my_remove_feeds' );