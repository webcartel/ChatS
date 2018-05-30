<?php

add_action('init', 'chats_user_init');
function chats_user_init() {
	add_action('wp_footer', 'chats_app_tag', 0);
}

function chats_app_tag() {
	echo '
<div id="chats-user">
	<div class="chats-user-window" v-if="chatWindowOpen">
		<div class="header">
			<span class="logo"></span>
			<span class="name">'.get_bloginfo('name').'</span>
			<span class="close" @click="chatWindowOpen = false"></span>
		</div>
		<ul class="messages-list">
			<li v-for="item in messageList" v-bind:class="{ support: item.from == item.chat_id }">
				<div class="message">
					<div class="text" v-html="item.message"></div>
					<div class="date">{{ timestampToDate(item.date) }}</div>
				</div>
			</li>
		</ul>
		<form action="/" class="form">
			<textarea v-model="message" placeholder="Ваше сообщение" @keyup.ctrl.enter="sendMessage()"></textarea>
			<button type="button" @click="sendMessage()">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
				    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
				    <path d="M0 0h24v24H0z" fill="none"/>
				</svg>
			</button>
		</form>
	</div>
	<div class="chats-user-open" v-if="!chatWindowOpen" @click="chatWindowOpen=true; scrollToBottom()">
		<span class="logo"></span>
	</div>
</div>
';
}

// Регистрация скриптов и стилей
function chats_user_css_js($value='')
{
	wp_enqueue_script('chats-user-axios', 'https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js', array(), null, 'in_footer');
	wp_enqueue_script('chats-user-vue', 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js', array(), null, 'in_footer');
	wp_enqueue_script('chats-user-app', CHATS_PLUGIN_DIR_URL . 'js/app-user.js', array('chats-user-vue'), null, 'in_footer');
	wp_enqueue_style( 'chats-user-css', CHATS_PLUGIN_DIR_URL . 'css/app-user.css' );
	wp_enqueue_style( 'chats-user-font', 'https://fonts.googleapis.com/css?family=Roboto:400,500&amp;subset=cyrillic' );
	// wp_enqueue_style( 'chatsusercss', CHATS_PLUGIN_DIR_URL . 'css/main.css' );
	// wp_enqueue_script('chatsuserjs', CHATS_PLUGIN_DIR_URL . 'js/main.js', array('jquery'), null, 'in_footer');

	wp_localize_script( 'chats-user-app', 'chats_ajax', array('url' => admin_url('admin-ajax.php')));
}
add_action( 'wp_enqueue_scripts', 'chats_user_css_js' );



function get_messages_list()
{
	if ( isset($_GET['token']) && !empty($_GET['token']) ) {
		$token = $_GET['token'];
		global $wpdb;
		$table_name = $wpdb->get_blog_prefix() . CHATS_MESSAGE_TABLE_NAME;
		$sql = "SELECT * FROM `". $table_name ."` WHERE `chat_id` LIKE '" . $token . "' ORDER BY `date` ASC";
		$responce = $wpdb->get_results($sql, ARRAY_A);
		echo json_encode($responce);
		exit();
	}
}
add_action( 'wp_ajax_get_messages_list', 'get_messages_list' );
add_action( 'wp_ajax_nopriv_get_messages_list', 'get_messages_list' );


// Сохранение сообщения
function save_user_message()
{
	global $wpdb;

	$chats_message_table = $wpdb->get_blog_prefix() . CHATS_MESSAGE_TABLE_NAME;
	$chats_connections_table = $wpdb->get_blog_prefix() . CHATS_CONNECTIONS_TABLE_NAME;

	if ( $_POST['message'] != '' ) {

		$chats_message_data = array(
			'from' => $_POST['token'],
			'chat_id' => $_POST['token'],
			'date' => time(),
			'message' => $_POST['message']
		);
		$chats_message_responce = $wpdb->insert( $chats_message_table, $chats_message_data);

		if ( $wpdb->get_row("SELECT * FROM $chats_connections_table WHERE `chat_id` = ".$_POST['token'] ) != null ) {
			$chats_connections_data = array(
				'ip' => $_SERVER['REMOTE_ADDR'],
				'name' => (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : '',
				'email' => (isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : '',
				'last_message' => $_POST['message'],
				'update_date' => time()
			);
			$chats_connections_responce = $wpdb->update( $chats_connections_table, $chats_connections_data, array('chat_id' => $_POST['token']) );
		}
		else {
			$chats_connections_data = array(
				'chat_id' => $_POST['token'],
				'ip' => $_SERVER['REMOTE_ADDR'],
				'name' => (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : '',
				'email' => (isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : '',
				'last_message' => $_POST['message'],
				'create_date' => time()
			);
			$chats_connections_responce = $wpdb->insert( $chats_connections_table, $chats_connections_data);
		}
	}

	echo var_dump($responce);

	exit();
}
add_action( 'wp_ajax_save_user_message', 'save_user_message' );
add_action( 'wp_ajax_nopriv_save_user_message', 'save_user_message' );

function generate_token()
{
	echo time().rand();
	exit();
}
add_action( 'wp_ajax_generate_token', 'generate_token' );
add_action( 'wp_ajax_nopriv_generate_token', 'generate_token' );