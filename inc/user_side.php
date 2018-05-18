<?php

add_action('init', 'chats_user_init');
function chats_user_init() {
	add_action('wp_footer', 'chats_app_tag', 0);
}

function chats_app_tag() {
	echo '<div id="chats-user" class="chats-user"><ul><li v-for="item in messageList">{{ item.name }}</li></ul></div>';
}

function chats_user_css_js($value='')
{
	wp_enqueue_script('chats-user-vue', 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js', array(), null, 'in_footer');
	wp_enqueue_script('chats-user-app', CHATS_PLUGIN_DIR_URL . 'js/app-user.js', array('chats-user-vue'), null, 'in_footer');
	wp_enqueue_style( 'chats-user-css', CHATS_PLUGIN_DIR_URL . 'css/app-user.css' );
	// wp_enqueue_style( 'chatsusercss', CHATS_PLUGIN_DIR_URL . 'css/main.css' );
	// wp_enqueue_script('chatsuserjs', CHATS_PLUGIN_DIR_URL . 'js/main.js', array('jquery'), null, 'in_footer');
}
add_action( 'wp_enqueue_scripts', 'chats_user_css_js' );