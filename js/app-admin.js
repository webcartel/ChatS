var chatsAdmin = new Vue({
	el: '#chats-admin',

	data: {
		test: 'kjsdfhkjsdhfkjsdhkj',
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