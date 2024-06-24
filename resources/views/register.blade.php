@extends('layout.master')
@section('main-content')
<section class="tab-background">
	<div class="margin-wrap">
		<div class="tab-header">
			<h2>Sign up to continue</h2>
			<div class="h-border" style="margin-bottom: 25px;"></div>
		</div>
		@if ($errors->any())
			<ul class="alert alert-danger">
			    @foreach ($errors->all() as $error)
			    	<li>{{ $error }}</li>
			    @endforeach
			</ul>
		@endif
		<form action="{{ route('signup') }}" method="POST" name="register_form" id="register-form">
			@csrf
			<div class="form-group">
				<input type="text" class="form-control custom-input" name="name" id="name" placeholder="Enter Fullname" required value="{{ old('name') }}">
			</div>
			<div class="form-group">
				<input type="text" class="form-control custom-input" name="username" id="username" placeholder="Enter Username" required value="{{ old('username') }}">
			</div>
			<div class="form-group">
				<input type="email" class="form-control custom-input" name="email" id="email" placeholder="Enter Email" required value="{{ old('email') }}">
			</div>
			<div class="form-group">
				<input type="password" class="form-control custom-input" name="password" id="password" placeholder="Enter Password" required>
			</div>
			<div class="form-group">
				<button class="btn btn-primary btn-login" type="submit"><i class="fas fa-key"></i> &nbsp; Register</button>
			</div>
		</form>
	</div>
</section>
@endsection