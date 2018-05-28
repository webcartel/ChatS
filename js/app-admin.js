var chatsAdmin = new Vue({
	el: '#chats-admin',

	data: {
		chatList: [
			{
				name: '33addd88d780ffb3d86d7b9c7a02ebd40',
				lastMessage: 'Так как возвращается 0, если никакие поля не были обновлены',
				date: 1527373207,
				online: false,
			},
			{
				name: 'Test name 2',
				lastMessage: 'Формат данных который будет ассоциирован с указанными значениями в параметре $data.',
				date: 1527373284,
				online: true,
			},
			{
				name: 'Test name 2',
				lastMessage: 'Обновляет или создает строку в таблице. Если строка с указанным ключом PRIMARY KEY уже есть все остальные указанные поля будут обновлены у строки',
				date: 1527373343,
				online: false,
			},
		],
	},

	mounted: function() {

	},

	methods: {
		scrollToBottom() {
			setTimeout(function() {
				var container = this.$el.querySelector('.messages-list')
				container.scrollTop = container.scrollHeight
			}.bind(this), 500)
		},

		shortString(str) {
			return (str.length >= 55) ? str.substr(0, 55) + '...' : str
		},

		timestampToDate(sec) {
		    var t = new Date(1970, 0, 1)
		    t.setSeconds(sec)
		    let year = t.getFullYear()
		    let month = (t.getMonth()+1) < 10 ? '0'+(t.getMonth()+1) : (t.getMonth()+1)
		    let day = t.getDate() < 10 ? '0'+t.getDate() : t.getDate()
		    let hours = t.getHours()
		    let minutes = t.getMinutes()
		    let seconds = t.getSeconds()
		    let date = hours +':'+ minutes// +' '+ day +'.'+ month +'.'+ year
		    return date
		},
	},
})