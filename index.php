<?php

/*
Plugin Name: ChatS
Description: Support chat
Plugin URI: http://#
Author: Web Cartel
Author URI: http://web-cartel.ru
Version: 1.0
License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'CHATS_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'CHATS_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'CHATS_WP_UPLOADS_DIR_PATH', wp_upload_dir()['basedir'] );



function chats_activate() {
	// activate code
}
register_activation_hook( __FILE__, 'chats_activate' );




include('inc/user_side.php');
include('inc/admin_side.php');