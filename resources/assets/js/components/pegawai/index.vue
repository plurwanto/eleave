<template>
	<div class="table-responsive">
		<table class="table table-striped jambo_table bulk_action">
			<thead>
				<tr>
					<td colspan="8">
						<div class="row">
							<div class="col-xs-4 col-md-3">
								<a href="#" class="btn btn-info" @click="getAllMembers()">Reset Filter</a>
							</div>
							<div class="col-xs-1 col-md-1 pull-right">
								<select name="per_page" id="per_page" class="form-control" v-model="perPage" @change="getAllMembers({per_page:perPage})">
									<option value="10">10</option>
									<option value="15">15</option>
									<option value="20">20</option>
									<option value="25">25</option>
									<option value="30">30</option>
								</select>
							</div>
						</div>
					</td>
				</tr>
				<tr class="headings">
					<th class="column-title">No. </th>
					<th class="column-title">
						<a href="#" @click="getAllMembers({sort_by:'mem_nip'})">
							Payroll ID
						</a>
					</th>
					<th class="column-title">
						<a href="#" @click="getAllMembers({sort_by:'mem_name'})">
							Name
						</a> 
					</th>
					<th class="column-title">
						<a href="#" @click="getAllMembers({sort_by:'cus_name'})">
							Client
						</a> 
					</th>
					<th class="column-title">
						<a href="#" @click="getAllMembers({sort_by:'cont_position'})">
							Position
						</a> 
					</th>
					<th class="column-title">
						<a href="#" @click="getAllMembers({sort_by:'cont_city_name'})">
							City
						</a> 
					</th>
					<th class="column-title">
						<a href="#" @click="getAllMembers({sort_by:'tr_name'})">
							Tax System
						</a> 
					</th>
					<th class="column-title no-link last"><span class="nobr">Action</span></th>
				</tr>
				<tr class="headings">
					<th class="column-title"></th>
					<th class="column-title">
						<input type="text" name="pegawai[mem_nip]" id="mem_nip" class="form-control column-search" placeholder="Payroll ID" v-model.trim="mem_nip" @keyup.enter="getAllMembers({mem_nip:mem_nip})">
					</th>
					<th class="column-title">
						<input type="text" name="pegawai[mem_name]" id="mem_name" class="form-control column-search" placeholder="Employee Name" v-model.trim="mem_name" @keyup.enter="getAllMembers({mem_name:mem_name})">
					</th>
					<th class="column-title">
						<select name="pegawai[cus_name]" id="cus_name" class="form-control dropdown-search" v-model="selected_client" @change="getAllMembers({cus_name:selected_client})">
							<option value="">-- Select Client --</option>
							<option v-for="clients in client" :value="clients.client_name">{{clients.client_name}}</option>
						</select>
					</th>
					<th class="column-title">
						<select name="pegawai[cont_position]" id="cont_position" class="form-control dropdown-search" v-model="selected_position" @change="getAllMembers({cont_position:selected_position})">
							<option value="">-- Select Position --</option>
							<option v-for="pegawai_alls in pegawai_all" :value="pegawai_alls.position">{{pegawai_alls.position}}</option>
						</select>
					</th>
					<th class="column-title">
						<select name="pegawai[cont_city_name]" id="cont_city_name" class="form-control dropdown-search" v-model="selected_city" @change="getAllMembers({cont_city_name:selected_city})">
							<option value="">-- Select City --</option>
							<option v-for="cities in city" :value="cities.city_name">{{cities.city_name}}</option>
						</select>
					</th>
					<th class="column-title">
						<select name="pegawai[tr_name]" id="tr_name" class="form-control dropdown-search" v-model="selected_tax_remark" @change="getAllMembers({tr_name:selected_tax_remark})">
							<option value="">-- Select Tax System --</option>
							<option v-for="tax_remarks in tax_remark" :value="tax_remarks.tax_name">{{tax_remarks.tax_name}}</option>
						</select>
					</th>
					<th class="column-title no-link last"></th>
					<input type="submit" id="submit-search" class="hidden">
				</tr>
			</thead>
			<tbody>
				<tr v-for="(employeeData, i) in employee" class="even pointer">
					<td>{{ pagination.from+i }}</td>
					<td>{{ employeeData.payroll_id }}</td>
					<td>{{ employeeData.epmloyee_name }}</td>
					<td>{{ employeeData.client }}</td>
					<td>{{ employeeData.position }}</td>
					<td>{{ employeeData.cont_city }}</td>
					<td>{{ employeeData.tax_system }}</td>
					<td class=" last">
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								Action
								<span class="caret"></span>
							</button>
							<ul role="menu" class="dropdown-menu">
								<li><a href="#" data-toggle="modal" data-target="#detailModal" data-backdrop="static" data-keyboard="false" @click=" selectEmployee(employeeData.member_id,'detail'); ">Detail</a></li>
								<!-- <li><a href="#" data-toggle="modal" data-target="#editModal" data-backdrop="static" data-keyboard="false" @click=" selectEmployee(employeeData.member_id,'edit'); ">Edit</a></li> -->
							</ul>
						</div>
					</td>
				</tr>
				<tr v-if="isEmpty"><td colspan="8" style="text-align: center;font-weight: bold;">No Data</td></tr>
			</tbody>
		</table>
		<nav aria-label="pagination">
		  	<ul class="pager">
			    <li class="previous" v-if="showPrevButton">
			    	<a href="#" @click="getAllMembers({page:(pagination.current_page-1)})">
			    		<span aria-hidden="true">&larr;</span> 
			    		Previous
			    	</a>
			    </li>
			    <li>
			    	<input type="number" name="page" class="text-center" id="page-num" v-model.trim="currentPage" @keyup.enter="getAllMembers({page:currentPage})">
			    </li>
			    <li class="next">
			    	<a href="#" @click="getAllMembers({page:(pagination.current_page+1)})">
			    		Next 
			    		<span aria-hidden="true">&rarr;</span>
			    	</a>
			    </li>
		  	</ul>
		</nav>
	</div>

	<!-- detail modal -->
	
</template>

<script>
	export default {
		data() {
			return {
				isEmpty			: false,
				showPrevButton	: false,
				showNextButton	: false,
				personal		: true,
				salary			: false,
				additional		: false,
				showByCompany	: false,
				showInsDeduct	: false,
				showThrVal		: false,
				currentPage 	: 1,
				perPage 		: 10,
				employee 		: [],
				tax_remark		: [],
				client 			: [],
				city 			: [],
				company 		: [],
				marital 		: [],
				bank 			: [],
				nationality		: [],
				kpp 			: [],
				insrPlan		: [],
				premi			: [],
				insurance		: [],
				pegawai_all 	: [],
				clickEmployee 	: {},
				clickSalary 	: {},
				clickAdditional : {},
				selected 		: '',
				selected_client	: '',
				selected_position : '',
				selected_city 	: '',
				selected_tax_remark : '',
				mem_nip 		: '',
				mem_name 		: '',
				pagination 		: [],
				paramSearch 	: [],
				params 			: [],
				currentSort		: 'asc'
			}
		},
		mounted() {
			this.getAllMembers();
		},
		methods:{
			getAllMembers: function(param){
				if(typeof param != 'undefined')
				{
					let objKey = Object.keys(param)[0];

					if(typeof param.mem_nip != 'undefined')
					{
						// console.log(this.params.search(objKey));
						this.paramSearch.push("pegawai[mem_nip]="+encodeURI(param.mem_nip));
						
					}
					if(typeof param.mem_name != 'undefined')
					{
						this.paramSearch.push("pegawai[mem_name]="+encodeURI(param.mem_name));
					}
					if(typeof param.cus_name != 'undefined')
					{
						this.paramSearch.push("pegawai[cus_name]="+encodeURI(param.cus_name));
					}

					if(typeof param.cont_position != 'undefined')
					{
						this.paramSearch.push("pegawai[cont_position]="+encodeURI(param.cont_position));
					}

					if(typeof param.cont_city_name != 'undefined')
					{
						this.paramSearch.push("pegawai[cont_city_name]="+encodeURI(param.cont_city_name));
					}

					if(typeof param.tr_name != 'undefined')
					{
						this.paramSearch.push("pegawai[tr_name]="+encodeURI(param.tr_name));
					}

					if(typeof param.page != 'undefined')
					{
						this.paramSearch.push("page="+encodeURI(param.page));
					}

					if(typeof param.per_page != 'undefined')
					{
						this.paramSearch.push("per_page="+encodeURI(param.per_page));
					}

					if(typeof param.sort_by != 'undefined')
					{
						this.paramSearch.push("sort_by="+encodeURI(param.sort_by+' '+app.currentSort));

						app.currentSort = (app.currentSort === 'asc') ? 'desc' : 'asc';
					}
				}
				else
				{
					this.selected = '';
					this.mem_name = '';
					this.mem_nip = '';
					this.paramSearch = [];
				}

				this.params = '?'+this.paramSearch.join('&');

				// console.log(this.params);
				// return false;
				
				let pageUrl = (typeof param != 'undefined') ? apiUrl+'pegawai'+this.params : apiUrl+'pegawai';

				axios.get(pageUrl)
					.then(response =>{
						// console.log(response.data,999999999);
						// return false;
						
							this.isEmpty 		= (response.data.data.length > 0) ? false : true;
							this.showPrevButton 	= (response.data.paging.prev_page_url != null) ? true : false;
							this.showNextButton 	= (response.data.paging.next_page_url != null) ? true : false;
							this.currentPage 	= response.data.paging.current_page || 1;
							this.employee 		= response.data.data;

							this.pagination 	= response.data.paging;
							this.perPage 		= response.data.paging.per_page;
					})
					.catch(response => {
	                    console.log(response);

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
	                    });
	                });

				axios.get(apiUrl+'tax-remark')
					.then(response =>{
						if(response.data.error)
						{
							this.errorMessage = response.data.message;
						}
						else
						{
							this.tax_remark = response.data.data;
						}
					})
					.catch(response => {
	                    console.log('tax-remark'+response);
	                });

				axios.get(apiUrl+'client')
					.then(response =>{
						if(response.data.error)
						{
							this.errorMessage = response.data.message;
						}
						else
						{
							this.client = response.data.data;
						}
					})
					.catch(response => {
	                    console.log('client'+response);
	                });

				axios.get(apiUrl+'city')
					.then(response =>{
						if(response.data.error)
						{
							this.errorMessage = response.data.message;
						}
						else
						{
							this.city = response.data.data;
						}
					})
					.catch(response => {
	                    console.log('city'+response);
	                });

				axios.get(apiUrl+'pegawai-all')
					.then(response =>{
						if(response.data.error)
						{
							this.errorMessage = response.data.message;
						}
						else
						{
							this.pegawai_all = response.data.data;
						}
					})
					.catch(response => {
	                    console.log('pegawai-all'+response);
	                });
			},
	 
			updateMember(url,dataUpdate){
				$('.loading').fadeIn();

				dataUpdate.birth_date 	= $("input[name=birth_date]").val();
				dataUpdate.join_date 	= $('input[name=join_date]').val();
				dataUpdate.resign_date 	= $('input[name=resign_date]').val();
				
				let memForm = JSON.parse(JSON.stringify(dataUpdate));

				axios.post(apiUrl+url, memForm)
					.then(function(response){
						
						if(response.data.error)
						{
							new PNotify({
	                                  	title: 'Error',
	                                  	text: 'Failed to update this Employee!<br/>Please try again.',
	                                  	type: 'error',
	                                  	styling: 'bootstrap3',
	                                  	animate: {
	                                          		animate: true,
	                                          		in_class: 'rotateInDownLeft',
	                                          		out_class: 'rotateOutUpRight'
	                                    },
	                                    delay: 2000,
	                                    swipeDismiss: true
	                        });
						}
						else
						{
							new PNotify({
	                                  	title: 'Success',
	                                  	text: 'Success to update this Employee',
	                                  	type: 'success',
	                                  	styling: 'bootstrap3',
	                                  	animate: {
	                                          		animate: true,
	                                          		in_class: 'rotateInDownLeft',
	                                          		out_class: 'rotateOutUpRight'
	                                    },
	                                    delay: 2000
	                        });

	                        $('#editModal').modal('hide');
	                        app.getAllMembers();
						}
						$('.loading').fadeOut();
					})
					.catch(function (response) {
	                    console.log(response);

	                    new PNotify({
	                              	title: 'Error',
	                              	text: 'Failed to update this data!<br/>Please contact your IT Team.',
	                              	type: 'error',
	                              	styling: 'bootstrap3',
	                              	animate: {
	                                      		animate: true,
	                                      		in_class: 'rotateInDownLeft',
	                                      		out_class: 'rotateOutUpRight'
	                                },
	                                delay: 2000,
	                                swipeDismiss: true
	                    });
	                });
			},
	 
			selectEmployee(employee_id,type){
				$('.loading').fadeIn();

				if(type == 'detail')
				{
					axios.get(apiUrl+'pegawai-detail?mem_id='+employee_id)
						.then(response =>{
							// console.log(app.isEmpty);
							// return false;
							if(response.data.error)
							{
								app.errorMessage = response.data.message;
							}
							else
							{
								app.clickEmployee = response.data.data;
							}

							$('.loading').fadeOut('slow');
						})
						.catch(response => {
		                    console.log(response);

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
		                    });
		                });

					axios.get(apiUrl+'pegawai-salary?mem_id='+employee_id)
						.then(response =>{
							// console.log(response.data.data);
							// return false;
							if(response.data.error)
							{
								app.errorMessage = response.data.message;
							}
							else
							{
								app.clickSalary = response.data.data;
							}
						})
						.catch(response => {
		                    console.log(response);

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
		                    });
		                });

					axios.get(apiUrl+'pegawai-additional?mem_id='+employee_id)
						.then(response =>{
							// console.log(response.data.data);
							// return false;
							if(response.data.error)
							{
								app.errorMessage = response.data.message;
							}
							else
							{
								app.clickAdditional = response.data.data;

								if(typeof app.clickAdditional.npwp != 'undefined')
								{
									/*S:format NPWP*/
									let oldNpwp 	= app.clickAdditional.npwp.replace(/-/g,'').replace(/\./g,'');
									let totalNpwp 	= oldNpwp.length;
									let newNpwp 	= '';

									for(let i=0;i<totalNpwp;i++)
									{
										newNpwp += oldNpwp[i];

										if(i == 1)
										{
											newNpwp += '-';
										}
										else if(i == 4)
										{
											newNpwp += '-';
										}
										else if(i == 7)
										{
											newNpwp += '-';
										}
										else if(i == 8)
										{
											newNpwp += '-';
										}
										else if(i == 11)
										{
											newNpwp += '-';
										}
									}

									app.clickAdditional.npwp = newNpwp;
									/*E:format NPWP*/
								}
							}
						})
						.catch(response => {
		                    console.log(response);

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
		                    });
		                });
				}
				else if(type == 'edit')
				{
					axios.get(apiUrl+'personal-edit?mem_id='+employee_id)
						.then(function(response){
							// console.log(app.isEmpty);
							// return false;
							if(response.data.error)
							{
								app.errorMessage = response.data.message;
							}
							else
							{
								app.clickEmployee = response.data.data;

								if(app.clickEmployee.birth_date != '-' || app.clickEmployee.join_date != '-' || app.clickEmployee.resign_date != '-')
								{
									$('input[name=birth_date]').daterangepicker({
								        singleDatePicker: true,
								        showDropdowns: true,
								        locale: {
								            format: 'DD-MM-YYYY'
								        },
								        drops: 'up',
								        startDate: app.clickEmployee.birth_date,
								    });
									$('input[name=join_date]').daterangepicker({
								        singleDatePicker: true,
								        showDropdowns: true,
								        locale: {
								            format: 'DD-MM-YYYY'
								        },
								        drops: 'up',
								        startDate: app.clickEmployee.join_date,
								    });
									$('input[name=resign_date]').daterangepicker({
								        singleDatePicker: true,
								        showDropdowns: true,
								        locale: {
								            format: 'DD-MM-YYYY'
								        },
								        drops: 'up',
								        startDate: app.clickEmployee.resign_date,
								    });
								}
							}

							$('.loading').fadeOut('slow');
						})
						.catch(function (response) {
		                    console.log(response);

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
		                    });
		                });

					axios.get(apiUrl+'salary-edit?mem_id='+employee_id)
						.then(function(res){
							let response = JSON.parse(JSON.stringify(res));
							// return false;
							if(response.data.error)
							{
								app.errorMessage = response.data.message;
							}
							else
							{
								app.clickSalary = response.data.data;

								let insType = app.clickSalary.insurance_type;

								if(insType == 4)
								{
									app.showByCompany = true;
									app.showInsDeduct = true;
								}
								else if(insType == 2)
								{
									app.showByCompany = true;
									app.showInsDeduct = false;
								}
								else if(insType == 3)
								{
									app.showByCompany = false;
									app.showInsDeduct = true;
								}
								else
								{
									app.showByCompany = false;
									app.showInsDeduct = false;
								}

								let thrType = app.clickSalary.thr_type;

								if(thrType != 4 && thrType != null)
								{
									app.showThrVal = true;
								}
								else
								{
									app.showThrVal = false;
								}
							}
						})
						.catch(function (response) {
		                    console.log(response);

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
		                    });
		                });

					axios.get(apiUrl+'additional-edit?mem_id='+employee_id)
						.then(function(response){
							// console.log(response.data.data);
							// return false;
							if(response.data.error)
							{
								app.errorMessage = response.data.message;
							}
							else
							{
								app.clickAdditional = response.data.data;

								if(typeof app.clickAdditional.npwp != 'undefined')
								{
									/*S:format NPWP*/
									let oldNpwp 	= app.clickAdditional.npwp.replace(/-/g,'').replace(/\./g,'');
									let totalNpwp 	= oldNpwp.length;
									let newNpwp 	= '';

									for(let i=0;i<totalNpwp;i++)
									{
										newNpwp += oldNpwp[i];

										if(i == 1)
										{
											newNpwp += '-';
										}
										else if(i == 4)
										{
											newNpwp += '-';
										}
										else if(i == 7)
										{
											newNpwp += '-';
										}
										else if(i == 8)
										{
											newNpwp += '-';
										}
										else if(i == 11)
										{
											newNpwp += '-';
										}
									}

									app.clickAdditional.npwp = newNpwp;
									/*E:format NPWP*/
								}
							}
						})
						.catch(function (response) {
		                    console.log(response);

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
		                    });
		                });

		            axios.get(apiUrl+'branch')
						.then(function(response){
							// console.log(app.isEmpty);
							// return false;
							if(response.data.error)
							{
								app.errorMessage = response.data.message;
							}
							else
							{
								app.company = response.data.data;
							}
						})
						.catch(function (response) {
		                    console.log(response);

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
		                    });
		                });

		            axios.get(apiUrl+'marital')
						.then(function(response){
							// console.log(app.isEmpty);
							// return false;
							if(response.data.error)
							{
								app.errorMessage = response.data.message;
							}
							else
							{
								app.marital = response.data.data;
							}
						})
						.catch(function (response) {
		                    console.log(response);

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
		                    });
		                });

		            axios.get(apiUrl+'bank')
						.then(function(response){
							// console.log(app.isEmpty);
							// return false;
							if(response.data.error)
							{
								app.errorMessage = response.data.message;
							}
							else
							{
								app.bank = response.data.data;
							}
						})
						.catch(function (response) {
		                    console.log(response);

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
		                    });
		                });

		            axios.get(apiUrl+'nationality')
						.then(function(response){
							// console.log(app.isEmpty);
							// return false;
							if(response.data.error)
							{
								app.errorMessage = response.data.message;
							}
							else
							{
								app.nationality = response.data.data;
							}
						})
						.catch(function (response) {
		                    console.log(response);

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
		                    });
		                });

		            axios.get(apiUrl+'kpp')
						.then(function(response){
							// console.log(app.isEmpty);
							// return false;
							if(response.data.error)
							{
								app.errorMessage = response.data.message;
							}
							else
							{
								app.kpp = response.data.data;
							}
						})
						.catch(function (response) {
		                    console.log(response);

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
		                    });
		                });

		            axios.get(apiUrl+'insurance-plan')
						.then(function(response){
							// console.log(app.isEmpty);
							// return false;
							if(response.data.error)
							{
								app.errorMessage = response.data.message;
							}
							else
							{
								app.insrPlan = response.data.data;
							}
						})
						.catch(function (response) {
		                    console.log(response);

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
		                    });
		                });

		            axios.get(apiUrl+'premi')
						.then(function(response){
							// console.log(app.isEmpty);
							// return false;
							if(response.data.error)
							{
								app.errorMessage = response.data.message;
							}
							else
							{
								app.premi = response.data.data;
							}
						})
						.catch(function (response) {
		                    console.log(response);

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
		                    });
		                });

		            axios.get(apiUrl+'insurance')
						.then(function(response){
							// console.log(app.isEmpty);
							// return false;
							if(response.data.error)
							{
								app.errorMessage = response.data.message;
							}
							else
							{
								app.insurance = response.data.data;
							}
						})
						.catch(function (response) {
		                    console.log(response);

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
		                    });
		                });
				}
			},
	 
			insuranceType(){
				let insType = this.clickSalary.insurance_type;

				if(insType == 4)
				{
					app.showByCompany = true;
					app.showInsDeduct = true;
				}
				else if(insType == 2)
				{
					app.showByCompany = true;
					app.showInsDeduct = false;
				}
				else if(insType == 3)
				{
					app.showByCompany = false;
					app.showInsDeduct = true;
				}
				else
				{
					app.showByCompany = false;
					app.showInsDeduct = false;
				}
			},

			thrType(){
				let thrType = this.clickSalary.thr_type;

				if(thrType == 4)
				{
					app.showThrVal = false;
				}
				else
				{
					app.showThrVal = true;
				}
			},

			npwpMask(val){
				let result = '';

				if (window.event.keyCode != 8)
				{
					if (val.npwp.match(/^\d{2}$/) !== null)
					{
					    val.npwp = val.npwp + '-';
					}
					else if (val.npwp.match(/^\d{2}\-\d{3}$/) !== null)
					{
					    val.npwp = val.npwp + '-';
					}
					else if (val.npwp.match(/^\d{2}\-\d{3}\-\d{3}$/) !== null)
					{
					    val.npwp = val.npwp + '-';
					}
					else if (val.npwp.match(/^\d{2}\-\d{3}\-\d{3}\-\d{1}$/) !== null)
					{
					    val.npwp = val.npwp + '-';
					}
					else if (val.npwp.match(/^\d{2}\-\d{3}\-\d{3}\-\d{1}\-\d{3}$/) !== null)
					{
					    val.npwp = val.npwp + '-';
					}
				}

				let total = val.npwp.replace(/-/g,'').length;

				if(total > 15)
				{
					val.npwp = val.npwp.substring(0,20);
				}
			},

			toFormData: function(obj){
				let form_data = new FormData();

				for(let key in obj)
				{
					form_data.append(key, obj[key]);
				}

				return form_data;
			}
	 
		}
	}
</script>