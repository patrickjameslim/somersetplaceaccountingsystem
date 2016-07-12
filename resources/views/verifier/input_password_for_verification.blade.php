@extends('master_layout.master_auth_layout')
@section('content')
<div>
	<div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            {!! Form::open(['url'=>'auth/verify','method'=>'POST']) !!}
              <h1>Verification Form</h1>
              @include('errors.validator')
              <div>
                <input type="hidden" class="form-control" name="userid" value="{{$user->id}}"/>
              </div>
              <div>
                <input type="password" class="form-control" name="password" placeholder="Password"/>
              </div>
              <div>
                <input type="password" class="form-control" name="confirmation_password" placeholder="Confirm Password"/>
              </div>
              <div>
              	<input type="submit" class="btn btn-default submit" value="Confirm">
              </div>

              <div class="clearfix"></div>
              <div class="separator">
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
      </div>
    </div>
</div>
@endsection