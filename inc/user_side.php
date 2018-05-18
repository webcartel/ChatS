<?php

add_action('init', 'chats_user_init');
function chats_user_init() {
	add_action('wp_footer', 'chats_app_tag', 0);
}

function chats_app_tag() {
	echo '<div id="chats"></div>';
}