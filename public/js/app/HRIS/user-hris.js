var app = new Vue({
	el: '#userHRIS',
	data: {
		isEmpty: false,
		showPrevButton: false,
		showNextButton: false,
		showPageInput: false,
		showTable: true,
		showPagination: true,
		showSubmitBtn: false,
		disabledBtn: false,
		currentPage: 1,
		totalPage: 1,
		perPage: 10,
		pagination: [],
		userHRIS: [],
		tempUserHRIS: [],
		paramSearch: {},
		token: document.getElementById('token').value || '',
		clickDocument: {},
		currentSort: 'asc',
		nama: '',
		div_name: '',
		email: '',
		br_name: '',
		recruitment_position: '',
		user_active: ''
	},

	mounted: function () {
		this.getUserHRIS()
	},

	methods: {
		reset() {
			this.perPage = 10
			this.user_id = ''
			this.nama = ''
			this.username = ''
			this.email = ''
			this.br_name = ''
			this.div_name = ''
			this.user_active = ''
			this.recruitment_position = ''

			app.newApprover = {
				account: '',
				id_approver: '',
				approver_name: '',
				approver_email: ''
			}
		},

		getUserHRIS(param) {
			if (typeof param != 'undefined') {
				if (typeof param.nama != 'undefined') {
					this.paramSearch.nama = param.nama
				}
				if (typeof param.email != 'undefined') {
					this.paramSearch.email = param.email
				}
				if (typeof param.br_name != 'undefined') {
					this.paramSearch.br_name = param.br_name
				}
				if (typeof param.div_name != 'undefined') {
					this.paramSearch.div_name = param.div_name
				}
				if (typeof param.user_active != 'undefined') {
					this.paramSearch.user_active = param.user_active
				}

				if (typeof param.recruitment_position != 'undefined') {
					this.paramSearch.recruitment_position = param.recruitment_position
				}

				if (typeof param.page != 'undefined') {
					this.paramSearch.page = parseInt(param.page)
				}

				if (typeof param.per_page != 'undefined') {
					this.paramSearch.per_page = param.per_page
				}

				if (typeof param.sort_by != 'undefined') {
					this.paramSearch.sort_by = param.sort_by + ' ' + app.currentSort

					app.currentSort = (app.currentSort === 'asc') ? 'desc' : 'asc'
				}
			} else {
				this.paramSearch = {}

				this.paramSearch.page = 1
				this.paramSearch.per_page = 10
			}

			this.paramSearch.token = token
			this.paramSearch.user_id = id_hris

			axios.post(apiUrl + 'hris/hrisUser', this.paramSearch)
				.then((response) => {
					if (response.data.error) {
						// new PNotify({
						// 	title: 'Error',
						// 	text: response.data.message,
						// 	type: 'error',
						// 	styling: 'bootstrap3',
						// 	animate: {
						// 		animate: true,
						// 		in_class: 'rotateInDownLeft',
						// 		out_class: 'rotateOutUpRight'
						// 	},
						// 	delay: 5000,
						// 	swipeDismiss: true
						// })

						if (response.data.response_code == '401') {
							setTimeout(function () {
								location.href = `${webUrl}/logout`
							}, 3000)
						}
					} else {
						app.isEmpty = (response.data.data.length > 0) ? false : true
						app.showPrevButton = (response.data.paging.prev_page_url != null) ? true : false
						app.showNextButton = (response.data.paging.next_page_url != null) ? true : false
						app.currentPage = response.data.paging.current_page || 1
						app.showPageInput = response.data.paging.last_page == 1 ? false : true
						app.pagination = response.data.paging
						app.totalPage = response.data.paging.last_page
						app.perPage = response.data.paging.per_page
						app.userHRIS = response.data.data

					}

					$('.loading').fadeOut('slow')
				})
				.catch((response) => {
					// new PNotify({
					// 	title: 'Error',
					// 	text: 'Somethings wrong with the Application!<br/>Please contact your IT Team.',
					// 	type: 'error',
					// 	styling: 'bootstrap3',
					// 	animate: {
					// 		animate: true,
					// 		in_class: 'rotateInDownLeft',
					// 		out_class: 'rotateOutUpRight'
					// 	},
					// 	delay: 2000,
					// 	swipeDismiss: true
					// })

					$('.loading').fadeOut('slow')
				});

			axios.post(apiUrl + 'hris/hrisUser/getPosition', {
					'token': this.token
				})
				.then((response) => {
					// console.log(response.data);
					// return false;
					if (response.data.error) {
						app.errorMessage = response.data.message
					} else {
						app.approverList = response.data.data
					}
				})
				.catch((response) => {
					console.log(response)

					new PNotify({
						title: 'Error',
						text: 'Somethings wrong with the Application!<br/>Please contact your IT Team.',
						type: 'error',
						styling: 'bootstrap3',
						animate: {
							animate: true,
							in_class: 'rotateInDownLeft',
							out_class: 'rotateOutUpRight'
						},
						delay: 2000,
						swipeDismiss: true
					})
				})
		},



	}
})