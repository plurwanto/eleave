@section('HRIS/layout.main')

@section('title', $title)

@section('breadcrumbs')
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="{{ URL::asset(env('APP_URL').'hris/dashboard') }}">Dashboard</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>Master Data</span>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>{{$title}}</span>
    </li>
</ul>
@endsection


@section('css')
<style type="text/css">
	thead a{
		color: inherit;
		vertical-align: middle;
	}
	thead a:hover{
		color: inherit;
	}
	thead a:visited{
		color: inherit;
	}
	[v-cloak] {
	  	background-color: #e0dcdc;
	  	color: #e0dcdc;
	}
	[v-cloak]:after {

	  animation: shine 1s ease-in-out  infinite;
	  animation-fill-mode: forwards;
	  content: "";
	  position: absolute;
	  top: -110%;
	  left: -210%;
	  width: 200%;
	  height: 200%;
	  opacity: 0;
	  transform: rotate(30deg);

	  background: rgba(255, 255, 255, 0.13);
	  background: linear-gradient(
	    to right,
	    rgba(255, 255, 255, 0.13) 0%,
	    rgba(255, 255, 255, 0.13) 77%,
	    rgba(255, 255, 255, 0.5) 92%,
	    rgba(255, 255, 255, 0.0) 100%
	  );
	}
	@keyframes shine{
	  10% {
	    opacity: 1;
	    top: -30%;
	    left: -30%;
	    transition-property: left, top, opacity;
	    transition-duration: 0.7s, 0.7s, 0.15s;
	    transition-timing-function: ease;
	  }
	  100% {
	    opacity: 0;
	    top: -30%;
	    left: -30%;
	    transition-property: left, top, opacity;
	  }
	}

</style>
@endsection


@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- BEGIN PAGE BREADCRUMBS -->
        @yield('breadcrumbs')

        <!-- END PAGE BREADCRUMBS -->

        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="page-content-inner">
            <div class="row">
                <div class="col-lg-12 col-xs-12 col-sm-12">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject bold uppercase font-dark">{{$subtitle}}</span>
                            </div>
                            <div class="actions">
                                <!-- <a class="btn btn-circle btn-icon-only btn-default" href="#">
                                    <i class="icon-cloud-upload"></i>
                                </a>
                                <a class="btn btn-circle btn-icon-only btn-default" href="#">
                                    <i class="icon-wrench"></i>
                                </a>
                                <a class="btn btn-circle btn-icon-only btn-default" href="#">
                                    <i class="icon-trash"></i>
                                </a> -->
                                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="#"> </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                                <!-- start content -->
                                <div id="userHRIS">
                                    <div class="row" style="margin-bottom:30px">
                                        <div class="col-xs-2 col-md-2">
                                            <select name="per_page" id="per_page" class="form-control" v-model="perPage" @change="getUserHRIS({per_page:perPage})">
                                                <option value="10">10</option>
                                                <option value="15">15</option>
                                                <option value="20">20</option>
                                                <option value="25">25</option>
                                                <option value="30">30</option>
                                            </select>
                                            </div>
                                            <div class="col-xs-4 col-md-3 pull-right">
                                                <a href="#" class="btn btn-info pull-right" @click="reset();getUserHRIS()">Add User HRIS</a>
                                            </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" v-if="showTable">
                                            <thead>
                                                <tr class="headings">
                                                    <th class="column-title text-center">No. </th>
                                                    <th class="column-title text-center">
                                                            Action
                                                    </th>
                                                    <th class="column-title text-center">
                                                        <a href="#" @click="getUserHRIS({sort_by:'nama'})">
                                                            Name
                                                        </a>
                                                    </th>
                                                    <th class="column-title text-center">
                                                        <a href="#" @click="getUserHRIS({sort_by:'email'})">
                                                            Email
                                                        </a>
                                                    </th>
                                                    <th class="column-title text-center">
                                                        <a href="#" @click="getUserHRIS({sort_by:'br_name'})">
                                                            Branch
                                                        </a>
                                                    </th>
                                                    <th class="column-title text-center">
                                                        <a href="#" @click="getUserHRIS({sort_by:'div_name'})">
                                                            Position
                                                        </a>
                                                    </th>
                                                    <th class="column-title text-center">
                                                        <a href="#" @click="getUserHRIS({sort_by:'user_active'})">
                                                            IsActive
                                                        </a>
                                                    </th>
                                                    <th class="column-title text-center">
                                                        <a href="#" @click="getUserHRIS({sort_by:'recruitment_position'})">
                                                            Recruitment Position
                                                        </a>
                                                    </th>

                                                </tr>
                                                <tr class="headings">
                                                    <th class="column-title"></th>
                                                    <th class="column-title"></th>
                                                    <th class="column-title">
                                                        <input type="text" name="code" id="code" class="form-control column-search" placeholder="Search Nama" v-model.trim="nama" @keyup="getUserHRIS({nama:nama})" autocomplete="off">
                                                    </th>
                                                    <th class="column-title">
                                                        <input type="text" name="code" id="code" class="form-control column-search" placeholder="Search Email" v-model.trim="email" @keyup="getUserHRIS({email:email})" autocomplete="off">
                                                    </th>
                                                    <th class="column-title">
                                                        <input type="text" name="br_name" id="br_name" class="form-control column-search" placeholder="Search Branch" v-model.trim="br_name" @keyup="getUserHRIS({br_name:br_name})" autocomplete="off">
                                                    </th>
                                                    <th class="column-title">
                                                        <input type="text" name="div_name" id="div_name" class="form-control column-search" placeholder="Search Position" v-model.trim="div_name" @keyup="getUserHRIS({div_name:div_name})" autocomplete="off">
                                                    </th>
                                                    <th class="column-title no-link">
                                                        <select name="code" id="user_active" class="form-control dropdown-search" v-model="user_active" @change="getUserHRIS({user_active:user_active})">
                                                            <option value="">-- Select Status --</option>
                                                            <option value="Y">Active</option>
                                                            <option value="N">Not Active</option>
                                                        </select>
                                                    </th>
                                                    <th class="column-title">
                                                        <input type="text" name="code" id="code" class="form-control column-search" placeholder="Search Recruitment" v-model.trim="recruitment_position" @keyup="getUserHRIS({recruitment_position:recruitment_position})" autocomplete="off">
                                                    </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(user, i) in userHRIS" class="even pointer text-left">
                                                    <td><span v-cloak>@{{ pagination.from+i }}</span></td>
                                                    <td style="width: 150px;text-align: center;">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-primary">Action</button>
                                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa fa-angle-down"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" role="menu">
                                                                <li>
                                                                    <a href="javascript:;"> Edit </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:;"> User Access </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:;"> Change Password </a>
                                                                </li>
                                                                <li class="divider"> </li>
                                                                <li>
                                                                    <a href="javascript:;"> Delete </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <td><span v-cloak>@{{ user.nama }}</span></td>
                                                    <td><span v-cloak>@{{ user.email }}</span></td>
                                                    <td><span v-cloak>@{{ user.br_name }}</span></td>
                                                    <td><span v-cloak>@{{ user.div_name }}</span></td>
                                                    <td>
                                                    <span v-if="user.user_active === 'Y'">
                                                        <button class="btn btn-success btn-sm">Active</button>
                                                    </span>
                                                    <span v-if="user.user_active === 'N'">
                                                        <button class="btn btn-danger btn-sm">Not Active</button>
                                                    </span>
                                                    </td>
                                                    <!-- <td><span v-cloak>@{{ user.user_active }}</span></td> -->
                                                    <td><span v-cloak>@{{ user.recruitment_position }}</span></td>

                                                </tr>
                                                <tr v-if="isEmpty"><td colspan="8" style="text-align: center;font-weight: bold;">No Data</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <nav aria-label="pagination" v-if="showPagination">
                                        <ul class="pager">
                                            <li class="previous" v-if="showPrevButton" >
                                                <a  v-cloak href="#" @click="getUserHRIS({page:(pagination.current_page-1)})">
                                                    <span aria-hidden="true">&larr;</span>
                                                    Previous
                                                </a>
                                            </li>
                                            <li v-if="showPageInput">
                                                <input type="number" name="page" class="text-center" id="page-num" v-model.trim="currentPage" @keyup.enter="getUserHRIS({page:currentPage})"> / @{{ pagination.last_page }} Page
                                            </li>
                                            <li class="next" v-if="showNextButton">
                                                <a href="#" @click="getUserHRIS({page:(pagination.current_page+1)})">
                                                    Next
                                                    <span aria-hidden="true">&rarr;</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                    <br/>
                                </div>
                                <!-- end content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>













	<!-- submit modal -->
	<div class="modal fade" id="submitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" @click="showSearch = false">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><span class="fa fa-file-text-o" aria-hidden="true"></span> Project Acceptance</h4>
				</div>
				<div class="modal-body">
			      	<div class="row">
			      		<div class="col-xs-12">
					      	<div class="row" style="margin-left: 20px;">
					      		<form class="form-horizontal form-label-left">
						      		<div class="col-xs-9">
						      			<div class="form-group">
						      				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="month">
							      				Period
							      			</label>
							      			<div class="col-md-4 col-sm-6 col-xs-12">
							      				<select id="month" name="month" required="required" class="form-control col-md-4 col-xs-6" v-model="newProject.month" @change="validatePeriod(newProject)">
							      					<option value="">Select Month</option>

							      					@for($k=1;$k <= date('n');$k++)
							      						<option :value="{{$k}}">{{date('F',strtotime(date('Y').'-'.$k.'-01'))}}</option>
							      					@endfor
							      				</select>
							      			</div>
							      			<div class="col-md-4 col-sm-6 col-xs-12">
							      				<select id="years" name="years" required="required" class="form-control col-md-4 col-xs-6" v-model="newProject.years" @change="validatePeriod(newProject)">
							      					<option value="">Select Years</option>

							      					@for($i=date('Y');$i >= 2017;$i--)
							      						<option :value="{{$i}}">{{$i}}</option>
							      					@endfor
							      				</select>
							      			</div>
						      			</div>
						      			<div class="form-group">
						      				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="delivery_unit">
							      				Delivery Unit
							      			</label>
							      			<div class="col-md-9 col-sm-6 col-xs-12" id="delivery_unit">
							      				<!-- <select id="du_id" name="du_id" required="required" class="form-control col-md-7 col-xs-12" v-model="newProject.du_id" @change="getDocType(newProject.du_id, 'add')">
							      					<option value="">Choose Delivery Unit</option>
							      					<option v-for="dus in duList" :value="dus.du_id">@{{dus.du_name}}</option>
							      				</select> -->
							      				<input type="text" id="du_keyword" name="du_keyword" required="required" class="form-control col-md-8 col-xs-12" placeholder="Type Delivery Unit" v-model.trim="du_keyword" @keyup.enter="getDU(du_keyword)" @change="validatePeriod(newProject)" autocomplete="off">
							      				<div class="search-result" v-if="showSearch">
							      					<ul class="list">
							      						<li v-for="dus in duList" @click="newProject.du_id = dus.du_id;du_keyword = dus.du_codeName;showSearch = false;getDocType(dus.du_id, 'add', dus.da_id)" v-html="dus.du_codeName"></li>
							      					</ul>
							      				</div>
							      			</div>
						      			</div>
						      			<div class="form-group" v-if="showDocType">
						      				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="document_type">
							      				Document Type
							      			</label>
							      			<div class="col-md-9 col-sm-6 col-xs-12" id="document_type">
							      				<select id="dd_id" name="dd_id" required="required" class="form-control col-md-7 col-xs-12" v-model="newProject.dd_id" @change="validatePeriod(newProject)">
							      					<option value="">Select Document Type</option>
							      					<option v-for="docTypes in docTypeList" :value="docTypes.dd_id">@{{docTypes.dd_name}}</option>
							      				</select>
							      			</div>
						      			</div>
						      			<div class="form-group" v-if="showApprover">
						      				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="approver">
							      				Approver
							      			</label>
							      			<div class="col-md-9 col-sm-6 col-xs-12" id="approver">
							      				<select id="approve_by" name="approve_by" required="required" class="form-control col-md-7 col-xs-12" v-model="newProject.approve_by">
							      					<option value="">Select Approver</option>
							      					<option v-for="approversx in approversList" :value="approversx.approver_id">@{{approversx.approver_name}}</option>
							      				</select>
							      			</div>
						      			</div>
						      			<div class="form-group">
						      				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="total_doc">
							      				Total
							      			</label>
							      			<div class="col-md-9 col-sm-6 col-xs-12" id="total_doc">
		      				      				<input type="number" id="doc_total" name="doc_total" required="required" class="form-control col-md-7 col-xs-12" placeholder="Total" v-model.number="newProject.doc_total">
		      				      			</div>
						      			</div>
						      		</div>
						      	</form>
					      	</div>
	  					</div>
			      	</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">
						<span class="fa fa-close" aria-hidden="true"></span>
						Close
					</button>
					<button type="button" class="btn btn-primary edit-btn" @click="saveProject(newProject)" :disabled="disabledBtn">
						<span class="fa fa-save" aria-hidden="true"></span>
						Save
					</button>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('script')


<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/HRIS/user-hris.js') }}"></script>





@endsection
