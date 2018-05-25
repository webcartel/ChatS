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
	echo '
<div id="chats-admin" class="chats-admin">
	<div class="chats-list">
		{{ test }}
	</div>

	<div class="chats-messages">
		
	</div>

</div>
';
}



// Регистрация скриптов и стилей админки
function chats_admin_css($current_screen)
{
	if ( $current_screen->parent_file != chats ) { return; }
	wp_enqueue_style( 'chats-admin-font', 'https://fonts.googleapis.com/css?family=Roboto:400,500&amp;subset=cyrillic' );
	wp_enqueue_style( 'chats-admin-css', CHATS_PLUGIN_DIR_URL . 'css/app-admin.css' );
	// wp_enqueue_style( 'chatsusercss', CHATS_PLUGIN_DIR_URL . 'css/main.css' );
}
add_action( 'current_screen', 'chats_admin_css' );

function chats_admin_js()
{
	if ( get_current_screen()->parent_file != chats ) { return; }
	wp_enqueue_script('chats-admin-axios', 'https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js', array(), null, 'in_footer');
	wp_enqueue_script('chats-admin-vue', 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js', array(), null, 'in_footer');
	wp_enqueue_script('chats-admin-app', CHATS_PLUGIN_DIR_URL . 'js/app-admin.js', array('chats-admin-vue'), null, 'in_footer');
	// wp_enqueue_script('chatsuserjs', CHATS_PLUGIN_DIR_URL . 'js/main.js', array('jquery'), null, 'in_footer');
}
add_action( 'admin_footer', 'chats_admin_js' );