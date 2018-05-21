var chatsUser = new Vue({
	el: '#chats-user',

	data: {
		chatUserToken: null,
		chatWindowOpen: true,
		message: '',
		messageList: [],
	},

	mounted: function() {
		this.getToken()
		this.getMessagesList()
		this.updateMessageList()
	},

	methods: {
		getToken() {
			if ( this.chatUserToken === null ) {
				if ( !localStorage.getItem('token') ) {
					axios.get(chats_ajax.url, {params: {action: 'generate_token'}})
						.then(function (response) {
							this.chatUserToken = response.data
							localStorage.setItem('token', response.data)
						}.bind(this))
						.catch(function (error) {
							console.log(error)
						})
				}
				else {
					this.chatUserToken = localStorage.getItem('token')
				}
			}
		},

		sendMessage() {
			this.getToken()

			var form_data = new FormData;
			form_data.append('token', this.chatUserToken)
			form_data.append('message', this.message)
			axios.post(chats_ajax.url + '?action=save_user_message', form_data)
				.then(function (response) {
					this.getMessagesList()
					this.message = ''
				}.bind(this))
				.catch(function (error) {
					console.log(error)
				})
		},

		getMessagesList() {
			axios.get(chats_ajax.url, {params: {action: 'get_messages_list', token: this.chatUserToken}})
				.then(function (response) {
					this.messageList = response.data
				}.bind(this))
				.catch(function (error) {
					console.log(error)
				})
		},

		updateMessageList() {
			setInterval(function() {
				axios.get(chats_ajax.url, {params: {action: 'get_messages_list', token: this.chatUserToken}})
					.then(function (response) {
						this.messageList = response.data
					}.bind(this))
					.catch(function (error) {
						console.log(error)
					})
			}.bind(this), 3000)
		},
	},
})