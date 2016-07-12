@extends('master_layout.master_page_layout')
@section('content')
	<div class="">
	    <div class="page-title">
	     	<div class="title_left">
	       		<h3><i class="fa fa-users"></i> Users</h3>
	      	</div>
	    </div>
	    <div class="clearfix"></div>

	    <div class="col-md-12 col-sm-12 col-xs-12">
	    	<div class="x_panel">
	      		<div class="x_title">
	        		<h2>List of All Users</h2>
	        		<ul class="nav navbar-right panel_toolbox">
	          			<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
	          			</li>
	        		</ul>
	        		<div class="clearfix"></div>
	      		</div>
	      		<div class="x_content">
	        		<table id="datatable" class="table table-striped table-bordered">
	          			<thead>
	            			<tr>
	              				<th>Name</th>
	              				<th>User Type</th>
	              				<th>Mobile</th>
	              				<th>Email</th>
	              				<th>Date Created</th>
	              				<th>Actions</th>
	            			</tr>
	          			</thead>
	          			<tbody>
		          			@foreach($users_list as $user)
				          		<tr>
				          			@if($user->home_owner_id == NULL)
						          		<td>{{ $user -> first_name }} {{ $user -> last_name }} </td>
						          		@if($user->user_type_id != NULL)
						          			<td align="center">{{ $user_type_list[$user->user_type_id] }} </td>
						          		@else
						          			<td align="center"> - </td>
						          		@endif
						          		@if($user -> mobile_number != NULL)
						          			<td>{{ $user -> mobile_number }} </td>
						          		@else
						          			<td align="center"> - </td>
						          		@endif

						          		<td>{{ $user -> email }} </td>
						        	@else
						        		<td>{{ $eHomeOwnersList[$user->home_owner_id]->first_name }} {{ $eHomeOwnersList[$user->home_owner_id]->last_name }} </td>
						        		@if($user->user_type_id != NULL)
						          			<td align="center">{{ $user_type_list[$user->user_type_id] }} </td>
						          		@else
						          			<td align="center"> - </td>
						          		@endif
						          		@if( $eHomeOwnersList[$user->home_owner_id]->member_mobile_no != NULL)
						          			<td>{{ $eHomeOwnersList[$user->home_owner_id]->member_mobile_no }} </td>
						          		@else
						          			<td align="center"> - </td>
						          		@endif
						          		<td>{{ $eHomeOwnersList[$user->home_owner_id]->member_email_address }} </td>
				          			@endif
				          			<td>{{ date('m/d/Y',strtotime($user -> created_at)) }} </td>
				          			<td align="center">
						                <a href="{{ route('users.edit',$user->id) }}" role="button" class="btn btn-default">
						                <i class="fa fa-pencil"></i> 
						                </a>
						                {!! Form::model($user, ['method'=>'DELETE','action' => ['user\UserController@destroy',$user->id] , 'class' => 'form-horizontal form-label-left']) !!}
						                    <button type="submit" class="btn btn-default" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </button>
						               	{!! Form::close() !!}
						            </td>
				          		</tr>
				          	@endforeach
	          			</tbody>
	        		</table>
	      		</div>
	    	</div>
	  	</div>
	  	<div class="clearfix"></div>
	</div>
@endsection