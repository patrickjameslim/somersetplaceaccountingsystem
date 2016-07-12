@extends('master_layout.master_auth_layout')
@section('content')
	<div>
		<div>
	      <a class="hiddenanchor" id="signup"></a>
	      <a class="hiddenanchor" id="signin"></a>

	      <div class="login_wrapper">
	        <div class="animate form login_form">
	          <section class="login_content">
	            {!! Form::open(['url'=>'auth/login','method'=>'POST']) !!}
	              <h1>Login Form</h1>
	              @include('errors.validator')
	              <div>
	                <input type="email" class="form-control" name="email" placeholder="Username" value="{{ old('email') }}"/>
	              </div>
	              <div>
	                <input type="password" class="form-control" name="password" placeholder="Password"/>
	              </div>
	              <div>
	              	<input type="submit" class="btn btn-default submit" value="Login">
	                <a class="reset_pass" href="#">Lost your password?</a>
	              </div>

	              <div class="clearfix"></div>

	              <div class="separator">
	                <p class="change_link">New to site?
	                  <a href="#signup" class="to_register"> Create Account </a>
	                </p>

	                <div class="clearfix"></div>
	                <br />

	                <div>
	                  <h1><i class="fa fa-home"></i> Somerset Homeowners Management System</h1>
	                  <p>©2016 All Rights Reserved. </p>
	                </div>
	              </div>
	            {!! Form::close() !!}
	          </section>
	        </div>

	        <div id="register" class="animate form registration_form">
	          <section class="login_content">
	            {!! Form::open(['url'=>'auth/register']) !!}
	              <h1>Create Account</h1>
	              @include('errors.validator')
	              <div>
	                <input type="text" name="first_name" class="form-control" placeholder="First Name" required="" value="{{ old('first_name') }}"/>
	              </div>
	              <div>
	                <input type="text" name="middle_name" class="form-control" placeholder="Middle Name" required="" value="{{ old('middle_name') }}"/>
	              </div>
	              <div>
	                <input type="text" name="last_name" class="form-control" placeholder="Last Name" required="" value="{{ old('last_name') }}"/>
	              </div>
	              <div>
	                <input type="email" name="email" class="form-control" placeholder="Email" required="" value="{{ old('email') }}"/>
	              </div>
	              <!--div>
	                <input type="password" name="password" class="form-control" placeholder="Password" required="" />
	              </div>

	              <div>
	                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmation Password" required="" />
	              </div-->
	              <div>
	                <input type="submit" class="btn btn-default submit" value="Register">
	              </div>

	              <div class="clearfix"></div>

	              <div class="separator">
	                <p class="change_link">Already a member ?
	                  <a href="#" class="to_register"> Log in </a>
	                </p>

	                <div class="clearfix"></div>
	                <br />

	                <div>
	                  <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
	                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
	                </div>
	              </div>
	            {!! Form::close() !!}
	          </section>
	        </div>
	      </div>
	    </div>
	</div>
@endsection