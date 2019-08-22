@extends('layout.main')

@section('title', 'Change Password')

@section('css')

@endsection

@section('content')

<h2>Change Password</h2>
<hr/>
<div id="changePassword">
	
	<input type="hidden" id="token" value="{{session('token')}}">
	<input type="hidden" id="user_role" value="{{session('user_role')}}">
	<input type="hidden" id="user_id" value="{{session('user_id')}}">

	<div class="row">
		<div class="col-md-6">
			<form @submit.prevent="validateBeforeSubmit()">

		        <label for="oldPassword">
		        	Old Password
		        </label>
		        <input
		        	type="password"
		        	id="oldPassword"
		        	class="form-control"
		        	name="oldPassword"
		        	v-model="oldPassword"
		        >

		        <br>

		        <label for="newPassword">
		        	New Password
		        </label>
		        <input
		        	v-validate="'required'"
		        	type="password"
		        	id="newPassword"
		        	class="form-control"
		        	name="newPassword"
		        	v-model="newPassword"
		        	ref="newPassword"
		        >

		        <br>

		        <label for="rePassword">
		        	Re-type New Password
		        </label>
		        <input
		        	v-validate="'required|confirmed:newPassword'"
		        	type="password"
		        	id="rePassword"
		        	class="form-control"
		        	name="rePassword"
		        	v-model="rePassword"
		        	data-vv-as="password"
		        	data-vv-as="password"
		        >

		        <br>

          	    <div class="alert alert-danger" v-show="errors.any()">
          	        <div v-if="errors.has('newPassword')">
          	          @{{ errors.first('newPassword') }}
          	        </div>
          	        <div v-if="errors.has('rePassword')">
          	          @{{ errors.first('rePassword') }}
          	        </div>
          	    </div>

	          	<span
	          		class="btn btn-primary"
	          		@click="setChangePassword()"
	          	>
	          		Submit
	          	</span>

	        </form>
		</div>
	</div>
	
</div>

@endsection

@section('script')

<script src="{{ URL::asset(env('PUBLIC_PATH').'js/vee-validate.js') }}"></script>
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/change-password.js') }}"></script>

@endsection