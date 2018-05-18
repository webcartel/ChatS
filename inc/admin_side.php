<?php

add_action('admin_menu', function() {
	add_menu_page(
		'ChatS - Support chat',
		'ChatS', 
		'manage_options',
		'chats',
		'chats_admin',
		CHATS_PLUGIN_DIR_URL.'images/chats-plugin-icon.png',
		100
	);
});

function chats_admin()
{
	
}