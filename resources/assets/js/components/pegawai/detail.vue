<template>
	<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>	
					<h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>{{ clickEmployee.epmloyee_name }}</h4>
				</div>
				<div class="modal-body">
			      	<div class="row">
			      		<div class="col-xs-2">
			      			<ul class="nav nav-tabs tabs-left">
							    <li class="active">
							    	<a href="#personal-detail" data-toggle="tab">
							    		Personal Detail
							    	</a>
							    </li>
							    <li>
							    	<a href="#salary" data-toggle="tab">
								    	Salary
								    </a>
							    </li>
							    <li>
							    	<a href="#additional" data-toggle="tab">
							    		Additional
							    	</a>
							    </li>
						  	</ul>
			      		</div>
	  					<div class="col-xs-10">
	  					  	<div class="tab-content">
	  						    <div class="tab-pane active" id="personal-detail">
	  						      	<p class="lead">Personal Detail</p>
	  						      	<hr>
	  						      	<div class="row">
	  						      		<div class="col-xs-6">
	  						      			<div class="row">
	  						      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="payroll_id">
	  							      				Payroll ID 
	  							      			</label>
	  							      			<div class="col-md-8 col-sm-6 col-xs-12">
	  							      				:{{ clickEmployee.payroll_id }}
	  							      			</div>
	  						      			</div>
	  						      			<div class="row">
	  						      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="nama">
	  							      				Nama 
	  							      			</label>
	  							      			<div class="col-md-8 col-sm-6 col-xs-12">
	  							      				:{{ clickEmployee.epmloyee_name }}
	  							      			</div>
	  						      			</div>
	  						      			<div class="row">
	  						      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="epmloyee_gender">
	  							      				Jenis Kelamin 
	  							      			</label>
	  							      			<div class="col-md-8 col-sm-6 col-xs-12" id="epmloyee_gender">
	  							      				:{{ clickEmployee.epmloyee_gender }}
	  							      			</div>
	  						      			</div>
	  						      			<div class="row">
	  						      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="email">
	  							      				Email 
	  							      			</label>
	  							      			<div class="col-md-8 col-sm-6 col-xs-12" id="email">
	  							      				:{{ clickEmployee.email }}
	  							      			</div>
	  						      			</div>
	  						      			<div class="row">
	  						      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="phone">
	  							      				Phone 
	  							      			</label>
	  							      			<div class="col-md-8 col-sm-6 col-xs-12" id="phone">
	  							      				:{{ clickEmployee.phone }}
	  							      			</div>
	  						      			</div>
	  						      			<div class="row">
	  						      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="epmloyee_address">
	  							      				Alamat 
	  							      			</label>
	  							      			<div class="col-md-8 col-sm-6 col-xs-12" id="epmloyee_address">
	  							      				:{{ clickEmployee.epmloyee_address }}
	  							      			</div>
	  						      			</div>
	  						      		</div>
	  						      		<div class="col-xs-6">
	  						      			<div class="row">
	  						      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="company_name">
	  							      				Perusahaan 
	  							      			</label>
	  							      			<div class="col-md-8 col-sm-6 col-xs-12" id="company_name">
	  							      				:{{ clickEmployee.company_name }}
	  							      			</div>
	  						      			</div>
	  						      			<div class="row">
	  						      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="client">
	  							      				Client 
	  							      			</label>
	  							      			<div class="col-md-8 col-sm-6 col-xs-12" id="client">
	  							      				:{{ clickEmployee.client }}
	  							      			</div>
	  						      			</div>
	  						      			<div class="row">
	  						      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="client_city">
	  							      				Kota 
	  							      			</label>
	  							      			<div class="col-md-8 col-sm-6 col-xs-12" id="client_city">
	  							      				:{{ clickEmployee.client_city }}
	  							      			</div>
	  						      			</div>
	  						      			<div class="row">
	  						      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="marital_status">
	  							      				Status Pajak 
	  							      			</label>
	  							      			<div class="col-md-8 col-sm-6 col-xs-12" id="marital_status">
	  							      				:{{ clickEmployee.tax_status }}
	  							      			</div>
	  						      			</div>
	  						      			<div class="row">
	  						      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="tax_status">
	  							      				Status Kawin 
	  							      			</label>
	  							      			<div class="col-md-8 col-sm-6 col-xs-12" id="tax_status">
	  							      				:{{ clickEmployee.marital_status }}
	  							      			</div>
	  						      			</div>
	  						      			<div class="row">
	  						      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="tax_system">
	  							      				Tax System 
	  							      			</label>
	  							      			<div class="col-md-8 col-sm-6 col-xs-12" id="tax_system">
	  							      				:{{ clickEmployee.tax_system }}
	  							      			</div>
	  						      			</div>
	  						      			<div class="row">
	  						      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="bpjs_type">
	  							      				BPJS 
	  							      			</label>
	  							      			<div class="col-md-8 col-sm-6 col-xs-12" id="bpjs_type">
	  							      				:{{ clickEmployee.bpjs_type }}
	  							      			</div>
	  						      			</div>
	  						      		</div>
	  						      	</div>
	  						      	<hr/>
	  						      	<div class="row">
	  						      		<div class="col-xs-6">
	  						      			<div class="row">
	  						      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="bank_name">
	  							      				Nama Bank 
	  							      			</label>
	  							      			<div class="col-md-8 col-sm-6 col-xs-12" id="bank_name">
	  							      				:{{ clickEmployee.bank_name }}
	  							      			</div>
	  						      			</div>
	  						      			<div class="row">
	  						      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="epmloyee_bank_branch">
	  							      				Cabang 
	  							      			</label>
	  							      			<div class="col-md-8 col-sm-6 col-xs-12" id="epmloyee_bank_branch">
	  							      				:{{ clickEmployee.epmloyee_bank_branch }}
	  							      			</div>
	  						      			</div>
	  						      			<div class="row">
	  						      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="epmloyee_name_bank">
	  							      				Nama 
	  							      			</label>
	  							      			<div class="col-md-8 col-sm-6 col-xs-12" id="epmloyee_name_bank">
	  							      				:{{ clickEmployee.epmloyee_name_bank }}
	  							      			</div>
	  						      			</div>
	  						      			<div class="row">
	  						      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="epmloyee_bank_no">
	  							      				No. Rekening 
	  							      			</label>
	  							      			<div class="col-md-8 col-sm-6 col-xs-12" id="epmloyee_bank_no">
	  							      				:{{ clickEmployee.epmloyee_bank_no }}
	  							      			</div>
	  						      			</div>
	  						      		</div>
	  						      		<div class="col-xs-6">
	  						      			<div class="row">
	  						      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="birth_place">
	  							      				Tempat Lahir 
	  							      			</label>
	  							      			<div class="col-md-8 col-sm-6 col-xs-12" id="birth_place">
	  							      				: {{ clickEmployee.birth_place }}
	  							      			</div>
	  						      			</div>
	  						      			<div class="row">
	  						      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="birth_date">
	  							      				Tanggal Lahir 
	  							      			</label>
	  							      			<div class="col-md-8 col-sm-6 col-xs-12" id="birth_date">
	  							      				: {{ clickEmployee.birth_date }}
	  							      			</div>
	  						      			</div>
	  						      			<div class="row">
	  						      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="join_date">
	  							      				Tanggal Masuk 
	  							      			</label>
	  							      			<div class="col-md-8 col-sm-6 col-xs-12" id="join_date">
	  							      				: {{ clickEmployee.join_date }}
	  							      			</div>
	  						      			</div>
	  						      			<div class="row">
	  						      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="resign_date">
	  							      				Tanggal Keluar 
	  							      			</label>
	  							      			<div class="col-md-8 col-sm-6 col-xs-12" id="resign_date">
	  							      				: {{ clickEmployee.resign_date }}
	  							      			</div>
	  						      			</div>
	  						      		</div>
	  						      	</div>
	  						    </div>
	  						    <div class="tab-pane" id="salary">
	  						      	<ul class="list-unstyled timeline">
	  						      	  	<li>
	  							      	    <div class="block">
	  							      	      	<div class="tags">
	  								      	        <a href="#" class="tag">
	  								      	          	<span>Basic Salary</span>
	  								      	        </a>
	  							      	      	</div>
	  							      	      	<div class="block_content">
	  								      	        <h2 class="title text-right" id="basic_salary">
	  								      	        	{{ clickSalary.basic_salary }}
	  								      	        </h2>
	  								      	        <div class="byline"></div>
	  								      	        <p class="excerpt"></p>
	  							      	      	</div>
	  							      	    </div>
	  						      	  	</li>
	  						      	  	<li>
	  							      	    <div class="block">
	  							      	      	<div class="tags">
	  								      	        <a href="#" class="tag">
	  								      	          	<span>Allowance</span>
	  								      	        </a>
	  							      	      	</div>
	  							      	      	<div class="block_content">
	  								      	        <h2 class="title">
	  								      	        	<div class="row" id="allowance" v-html="clickSalary.allowance">
	  								      	        		{{ clickSalary.allowance }}
	  								      	        	</div>
	  								      	        </h2>
	  								      	        <div class="byline"></div>
	  								      	        <p class="excerpt"></p>
	  							      	      	</div>
	  							      	    </div>
	  						      	  	</li>
	  						      	  	<li>
	  							      	    <div class="block">
	  							      	      	<div class="tags">
	  								      	        <a href="#" class="tag">
	  								      	          	<span>Insurance</span>
	  								      	        </a>
	  							      	      	</div>
	  							      	      	<div class="block_content">
	  								      	        <div class="row">
	  								      	        	<div class="col-xs-8">
	  								      	        		Plan Asuransi
	  								      	        	</div>
	  								      	        	<div class="col-xs-4 text-right" id="plan_asuransi">
	  								      	        		{{ clickSalary.plan_asuransi }}
	  								      	        	</div>
	  								      	        </div>
	  								      	        <div class="row">
	  								      	        	<div class="col-xs-8">
	  								      	        		Premi Type
	  								      	        	</div>
	  								      	        	<div class="col-xs-4 text-right" id="premi_type">
	  								      	        		{{ clickSalary.premi_type }}
	  								      	        	</div>
	  								      	        </div>
	  								      	        <hr/>
	  								      	        <div class="row">
	  								      	        	<div class="col-xs-8">
	  								      	        		<h2><b>Tipe Asuransi</b></h2>
	  								      	        	</div>
	  								      	        	<div class="col-xs-4 text-right" id="insurance_type">
	  								      	        		{{ clickSalary.insurance_type }}
	  								      	        	</div>
	  								      	        </div>
	  								      	        <div class="row">
	  								      	        	<div class="col-xs-8">
	  								      	        		By Company
	  								      	        	</div>
	  								      	        	<div class="col-xs-4 text-right" id="by_company_value">
	  								      	        		{{ clickSalary.by_company_value }}
	  								      	        	</div>
	  								      	        </div>
	  								      	        <div class="row">
	  								      	        	<div class="col-xs-8">
	  								      	        		Insurance Deduction
	  								      	        	</div>
	  								      	        	<div class="col-xs-4 text-right" id="insurance_deduction">
	  								      	        		{{ clickSalary.insurance_deduction }}
	  								      	        	</div>
	  								      	        </div>
	  								      	        <div class="byline"></div>
	  								      	        <p class="excerpt"></p>
	  							      	      	</div>
	  							      	    </div>
	  						      	  	</li>
	  						      	  	<li>
	  							      	    <div class="block">
	  							      	      	<div class="tags">
	  								      	        <a href="#" class="tag">
	  								      	          	<span>THR</span>
	  								      	        </a>
	  							      	      	</div>
	  							      	      	<div class="block_content">
	  								      	        <div class="row">
	  								      	        	<div class="col-xs-8" id="thr_type"></div>
	  								      	        	<div class="col-xs-4 text-right" id="thr">
	  								      	        		{{ clickSalary.thr }}
	  								      	        	</div>
	  								      	        </div>
	  								      	        <div class="byline"></div>
	  								      	        <p class="excerpt"></p>
	  							      	      	</div>
	  							      	    </div>
	  						      	  	</li>
	  						      	</ul>
	  						    </div>
	  						    <div class="tab-pane" id="additional">
	  						    	<div class="row">
	  						      		<div class="col-xs-12">
	  						      			<fieldset>
	  						      				<legend>BPJS :</legend>
	  		      				      			<div class="row">
	  		      				      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="bpjstk">
	  		      					      				BPJS Ketenagakerjaan 
	  		      					      			</label>
	  		      					      			<div class="col-md-8 col-sm-6 col-xs-12" id="bpjstk">
	  		      					      				: {{ clickAdditional.bpjstk }}
	  		      					      			</div>
	  		      				      			</div>
	  		      				      			<div class="row">
	  		      				      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="insurance">
	  		      					      				BPJS Pensiun 
	  		      					      			</label>
	  		      					      			<div class="col-md-8 col-sm-6 col-xs-12" id="bpjs_pensiun">
	  		      					      				: {{ clickAdditional.bpjs_pensiun }}
	  		      					      			</div>
	  		      				      			</div>
	  		      				      			<div class="row">
	  		      				      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="bpjsk">
	  		      					      				BPJS Kesehatan 
	  		      					      			</label>
	  		      					      			<div class="col-md-8 col-sm-6 col-xs-12" id="bpjsk">
	  		      					      				: {{ clickAdditional.bpjsk }}
	  		      					      			</div>
	  		      				      			</div>
	  							      		</fieldset>
	  						      		</div>
	  						      	</div>
	  						      	<div class="clearfix"></div>
	  						      	<div class="row">
	  						      		<div class="col-xs-12">
	  						      			<fieldset>
	  						      				<legend>Tax :</legend>
	  						      				<div class="row">
	  		      				      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="npwp">
	  		      					      				NPWP 
	  		      					      			</label>
	  		      					      			<div class="col-md-8 col-sm-6 col-xs-12" id="npwp">
	  		      					      				: {{ clickAdditional.npwp }}
	  		      					      			</div>
	  		      				      			</div>
	  		      				      			<div class="row">
	  		      				      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="nationality">
	  		      					      				Country 
	  		      					      			</label>
	  		      					      			<div class="col-md-8 col-sm-6 col-xs-12" id="nationality">
	  		      					      				: {{ clickAdditional.nationality }}
	  		      					      			</div>
	  		      				      			</div>
	  		      				      			<div class="row">
	  		      				      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="ktp">
	  		      					      				KTP 
	  		      					      			</label>
	  		      					      			<div class="col-md-8 col-sm-6 col-xs-12" id="ktp">
	  		      					      				: {{ clickAdditional.ktp }}
	  		      					      			</div>
	  		      				      			</div>
	  		      				      			<div class="row">
	  		      				      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="kpp">
	  		      					      				KPP 
	  		      					      			</label>
	  		      					      			<div class="col-md-8 col-sm-6 col-xs-12" id="kpp">
	  		      					      				: {{ clickAdditional.kpp }}
	  		      					      			</div>
	  		      				      			</div>
	  		      				      			<div class="row">
	  		      				      				<label class="control-label col-md-4 col-sm-3 col-xs-12" for="passport">
	  		      					      				Passport No. 
	  		      					      			</label>
	  		      					      			<div class="col-md-8 col-sm-6 col-xs-12" id="passport">
	  		      					      				: {{ clickAdditional.passport }}
	  		      					      			</div>
	  		      				      			</div>
	  							      		</fieldset>
	  						      		</div>
	  						      	</div>
	  						    </div>
	  					  	</div>
	  					</div>
			      	</div>
				</div>
			</div>
		</div>
	</div>
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