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
		<div class="chat-item" @click="getChatMessages(chatItem.chat_id)" v-bind:class="{ active: chatItem.chat_id == currentChatId }" v-for="chatItem in connectionsList">
			<div class="chat-name" v-bind:class="{ online: chatItem.chat_id }">{{ chatItem.chat_id }}</div>
			<div class="chat-lastmessage" v-html="shortString(chatItem.last_message)"></div>
			<div class="chat-date" v-html="timestampToDate(chatItem.create_date)"></div>
		</div>
	</div>

	<div class="chats-messages">

		<div class="message-block" v-if="messagesList.length > 0" v-for="messageItem in messagesList">
			<div class="message" v-html="messageItem.message"></div>
		</div>

	</div>

</div>
';
}


function get_connections_list()
{
	global $wpdb;
	$chats_connections_table = $wpdb->get_blog_prefix() . CHATS_CONNECTIONS_TABLE_NAME;
	$sql = "SELECT * FROM `". $chats_connections_table ."` WHERE 1 ORDER BY `update_date` DESC";
	$responce = $wpdb->get_results($sql, ARRAY_A);
	echo json_encode($responce);
	exit();
}
add_action( 'wp_ajax_get_connections_list', 'get_connections_list' );


function admin_get_messages_list()
{
	if ( isset($_GET['chat_id']) && !empty($_GET['chat_id']) ) {
		$chat_id = $_GET['chat_id'];
		global $wpdb;
		$chats_message_table = $wpdb->get_blog_prefix() . CHATS_MESSAGE_TABLE_NAME;
		$sql = "SELECT * FROM `". $chats_message_table ."` WHERE `chat_id`='" . $chat_id . "' ORDER BY `date` ASC";
		$responce = $wpdb->get_results($sql, ARRAY_A);
		echo json_encode($responce);
		exit();
	}
}
add_action( 'wp_ajax_admin_get_messages_list', 'admin_get_messages_list' );