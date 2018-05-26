<?php

add_action('admin_menu', function() {
	$page = add_menu_page(
		'ChatS - Support chat',
		'ChatS', 
		'manage_options',
		'chats',
		'chats_admin',
		CHATS_PLUGIN_DIR_URL.'images/chats-plugin-icon.png',
		100
	);

	add_action( 'admin_print_styles-' . $page, 'chats_admin_css' );
	add_action( 'admin_print_scripts-' . $page, 'chats_admin_js' );
});

// Регистрация скриптов и стилей админки
function chats_admin_css()
{
	wp_enqueue_style( 'chats-admin-font', 'https://fonts.googleapis.com/css?family=Roboto:400,500&amp;subset=cyrillic' );
	wp_enqueue_style( 'chats-admin-css', CHATS_PLUGIN_DIR_URL . 'css/app-admin.css' );
	// wp_enqueue_style( 'chatsusercss', CHATS_PLUGIN_DIR_URL . 'css/main.css' );
}

function chats_admin_js()
{
	wp_enqueue_script('chats-admin-axios', 'https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js', array(), null, 'in_footer');
	wp_enqueue_script('chats-admin-vue', 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js', array(), null, 'in_footer');
	wp_enqueue_script('chats-admin-app', CHATS_PLUGIN_DIR_URL . 'js/app-admin.js', array('chats-admin-vue'), null, 'in_footer');
	// wp_enqueue_script('chatsuserjs', CHATS_PLUGIN_DIR_URL . 'js/main.js', array('jquery'), null, 'in_footer');
}

function chats_admin()
{
	echo '
<div id="chats-admin" class="chats-admin">
	<div class="chats-list">
		<div class="chat-item" v-for="chatItem in chatList">
			<div class="chat-name">{{ chatItem.name }}</div>
		</div>
	</div>

	<div class="chats-messages">
		
	</div>

</div>
';
}
