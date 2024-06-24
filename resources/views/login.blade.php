@extends('layout.master')
@section('main-content')
<section class="tab-background">
	<div class="margin-wrap">
		<div class="tab-header">
			<h2>Sign in to continue</h2>
			<div class="h-border"></div>
		</div>
		@if($errors->any())
			<div class="alert alert-danger text-center">
				Invalid Credentials !
			</div>
		@endif
		<form action="{{ route('authenticate') }}" method="POST" name="login_form" id="login-form">
			@csrf
			<div class="form-group">
				<input type="text" class="form-control custom-input" name="login" id="login" placeholder="Enter Username or Email" required>
			</div>
			<div class="form-group">
				<input type="password" class="form-control custom-input" name="password" id="login" placeholder="Enter Password" required>
			</div>
			<div class="form-group">
				<button class="btn btn-primary btn-login" type="submit"><i class="fas fa-key"></i> &nbsp; Login</button>
			</div>
		</form>
		<p class="text-center" style="margin-top: 30px;">Don't have account ? <a href="{{ route('register') }}">Register</a></p>
	</div>
</section>
@endsection
@section('scripts')
<script>
	@if(Session::has('message'))
		toastr.success('{{ Session::get('message') }}');	
	@endif
</script>
@endsection