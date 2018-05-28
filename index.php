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
define( 'CHATS_CONNECTIONS_TABLE_NAME', 'chats_connections' );



function chats_activate() {
	global $wpdb;

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	$chats_message_table = $wpdb->get_blog_prefix() . CHATS_MESSAGE_TABLE_NAME;
	$chats_connections_table = $wpdb->get_blog_prefix() . CHATS_CONNECTIONS_TABLE_NAME;

	$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

	$sql = "CREATE TABLE {$chats_message_table} (
		`id` BIGINT(20) NOT NULL AUTO_INCREMENT,
		`from` VARCHAR(100) NOT NULL,
		`chat_id` VARCHAR(100) NOT NULL,
		`date` INT(11) NOT NULL,
		`message` TEXT NOT NULL,
		PRIMARY KEY (`id`)
	) {$charset_collate};";

	$sql .= "CREATE TABLE {$chats_connections_table} (
		`id` BIGINT(20) NOT NULL AUTO_INCREMENT,
		`ip` VARCHAR(100) NOT NULL,
		`chat_id` VARCHAR(100) NOT NULL,
		`name` VARCHAR(100) NOT NULL,
		`email` VARCHAR(100) NOT NULL,
		`last_message` TEXT NOT NULL,
		`create_date` INT(11) NOT NULL,
		`update_date` INT(11) NOT NULL,
		PRIMARY KEY (`id`)
	) {$charset_collate};";

	dbDelta($sql);
}
register_activation_hook( __FILE__, 'chats_activate' );


function chats_deactivate() {
	global $wpdb;
	$chats_message_table = $wpdb->get_blog_prefix() . CHATS_MESSAGE_TABLE_NAME;
	$chats_connections_table = $wpdb->get_blog_prefix() . CHATS_CONNECTIONS_TABLE_NAME;
	$sql = "DROP TABLE IF EXISTS {$chats_message_table}, {$chats_connections_table};";
	$wpdb->query($sql);
}
register_deactivation_hook(  __FILE__, 'chats_deactivate' );




include('inc/user_side.php');
include('inc/admin_side.php');