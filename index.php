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

define( 'CHATS_MESSAGE_TABLE_NAME', 'chats_messages' );



function chats_activate() {
	global $wpdb;

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	$table_name = $wpdb->get_blog_prefix() . CHATS_MESSAGE_TABLE_NAME;
	$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

	$sql = "CREATE TABLE {$table_name} (
		`id` BIGINT(20) NOT NULL AUTO_INCREMENT,
		`from` VARCHAR(100) NOT NULL,
		`to` VARCHAR(100) NOT NULL,
		`chat_id` VARCHAR(100) NOT NULL,
		`date` INT(11) NOT NULL,
		`message` TEXT NOT NULL,
		PRIMARY KEY (`id`)
	) {$charset_collate};";

	dbDelta($sql);
}
register_activation_hook( __FILE__, 'chats_activate' );


function chats_deactivate() {
	global $wpdb;

	$table_name = $wpdb->get_blog_prefix() . CHATS_MESSAGE_TABLE_NAME;

	$sql = "DROP TABLE IF EXISTS {$table_name};";

	$wpdb->query($sql);
}
register_deactivation_hook(  __FILE__, 'chats_deactivate' );




include('inc/user_side.php');
include('inc/admin_side.php');