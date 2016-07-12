@extends('master_layout.master_page_layout')
@section('content')
    <div class="">
        <div class="page-title">
          	<div class="title_left">
            	<h3><i class="fa fa-users"></i> Account Titles</h3>
          	</div>
        </div>

        <div class="clearfix"></div>

        <div class="col-md-12 col-sm-12 col-xs-12">
	        <div class="x_panel">
	          	<div class="x_title">
		            <h2>List of All Account Titles</h2>
		            <ul class="nav navbar-right panel_toolbox">
		           
		              	<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
		              	</li>
		            </ul>
		            <div class="clearfix"></div>
	         	</div>
	        	<div class="x_content">
	            	<div class="pull-right">
	              		<a href="{{ route('accounttitle.create') }}" class="btn btn-primary">
	                		<i class="fa fa-plus"></i> Create New Account Title
	              		</a>
	            	</div>
	            	<div class="clearfix"></div>
	            	<br>
	            </div>
	            <table id="datatable" class="table table-striped table-bordered">
	              	<thead>
		                <tr>
		                  	<th>Account Title Name</th>
		                  	<th>Account Group </th>
		                  	<!--th>Opening Balance</th-->
		                  	<th>Description</th>
		                  	<th>Date Created</th>
		                  	<th>Actions</th>
		                </tr>
	              	</thead>
	              	<tbody>
		                @foreach($accountTitleList as $accountTitle)
			          		<tr>
				          		<td><a href="{{ route('accounttitle.show',$accountTitle->id) }}">{{ $accountTitle -> account_sub_group_name }}</a></td>
				          		<td>{{$accountGroupList[$accountTitle->account_group_id]->account_group_name}}</td>
				          		<!--td>
				          			@if(($accountGroupList[$accountTitle->account_group_id]->account_group_name == 'Asset' || $accountGroupList[$accountTitle->account_group_id]->account_group_name == 'Expense'))
				          				Dr
				          			@else
				          				Cr
				          			@endif
				          			{{$accountTitle->opening_balance}}
				          		</td-->
				          		<td>{{ $accountTitle -> description }}</td>
				          		<td> {{date('m-d-Y',strtotime($accountTitle -> created_at)) }} </td>
				          		<td align="center">
					                <a href="{{ route('accounttitle.edit',$accountTitle->id) }}" role="button" class="btn btn-default">
					                	<i class="fa fa-pencil"></i> 
					                </a>
					                {!! Form::model($accountTitle, ['method'=>'DELETE','action' => ['accountTitle\AccountTitleController@destroy',$accountTitle->id] , 'class' => 'form-horizontal form-label-left']) !!}
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
		</div>
@endsection