@extends('master_layout.master_page_layout')
@section('content')
	<meta name="csrf-token" content="{{ csrf_token() }}">
   	<div class="">
      	<div class="page-title">
         	<div class="title_left">
            	<h3><i class="fa fa-credit-card"></i> Expenses</h3>
         	</div>
      	</div>
      	<div class="clearfix"></div>
      	<div class="col-md-12 col-sm-12 col-xs-12">
         	<div class="x_panel">
            	<div class="x_title">
               		<h2>Create New Cash Voucher</h2>
               		<ul class="nav navbar-right panel_toolbox">
                  		<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  		</li>
               		</ul>
               		<div class="clearfix"></div>
            	</div>
            	<div class="x_content">
               		<section class="content invoice">
                  		<!-- title row -->
                  		<div class="row">
                     		<div class="col-xs-12 invoice-header">
                        		<h4>Cash Voucher #: {{$receiptNumber}} <span class="pull-right">Date: {{$dateToday}}</span></h4>
                     		</div>
                     		<!-- /.col -->
                  		</div>
                  		<!-- info row -->
                  		<div class="row invoice-info">
                     		<div class="col-sm-4 invoice-col">
		                        <div class="form-group">
		                           <label for="" class="control-label">Creted By:</label>
		                           <div class="form-group">
		                              @if(Auth::user()->home_owner_id != NULL)
		                                <input id="cashier" class="form-control" value="{{Auth::user()->homeOwner->first_name}} {{Auth::user()->homeOwner->last_name}}" type="text" readonly>
		                              @else
		                                <input id="cashier" class="form-control" value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" type="text" readonly>
		                              @endif
		                            </div>
		                        </div>
		                    </div>
                     		<div class="col-sm-4 invoice-col">
                        		<div class="form-group">
                           			<label class="control-label" for="homeowner">Paid To</label>
                           			<input id="paid_to" name="paid_to" type="text" class="form-control">
                        		</div>
                     		</div>
                     		<!-- /.col -->
                  		</div>
                  		<!-- /.row -->
                  		<!-- Table row -->
                  		<div class="row">
                     		<div class="col-md-6">
                        		<table class="table table-striped" id="itemsTable">
                           			<thead>
                              			<tr>
                              				<th style="width: 30%">Item</th>
				                            <th style="width: 60%">Description</th>
				                            <th style="width: 10%">Amount (PHP)</th>
				                        </tr>
                           			</thead>
                           			<tbody class="items-wrapper">
                           			</tbody>
                        		</table>
                        		<button class="btn btn-primary pull-right add-item" id="addItemRow" data-toggle="modal" data-target="#myModal">
			                        Add
			                    </button>
                     		</div>
                     		<!-- /.col -->

                     		<!-- Modal used for adding row in table -->
		                    <!-- Modal content-->
		                    <div id="myModal" class="modal fade" role="dialog">
		                      <div class="modal-dialog">
		                        <div class="modal-content pull-right col-md-12">
		                          <div class="modal-header">
		                            <button type="button" class="close" data-dismiss="modal">&times;</button>
		                            <h4 class="modal-title">New Item</h4>
		                          </div>
		                          <div class="modal-body">
		                            <form id="nPaymentTrans">
		                              <div class="form-group">
		                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Particulars<span class="required">*</span>
		                                </label>
		                                <div class="col-md-9 col-sm-6 col-xs-12">
		                                  <select id="nPaymentItem" name="account_group_id" class="select2_single form-control" tabindex="-1" style="width:100%;">
		                                    <option></option>
		                                    @foreach($eExpenseAccountTitlesList as $eExpenseTitle)
		                                      <option value="{{$eExpenseTitle->id}}">{{$eExpenseTitle->account_sub_group_name}}</option>
		                                    @endforeach
		                                  </select>
		                                  <!--input value="" type="text" id="nPaymentItem" class="form-control col-md-7 col-xs-12" style="margin-bottom:2% !important" required="required"-->
		                                </div>
		                              </div>
		                              <div class="form-group">
		                              </br>
		                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description<span class="required">*</span>
		                                </label>
		                                <div class="col-md-9 col-sm-6 col-xs-12">
		                                  <input value="" type="text" id="nPaymentDesc" class="form-control col-md-7 col-xs-12" style="margin-bottom:2% !important" required="required">
		                                </div>
		                              </div>
		                      
		                              <div class="form-group">
		                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Amount (PHP) <span class="required">*</span>
		                                </label>
		                                <div class="col-md-9 col-sm-6 col-xs-12">
		                                  <input value="" type="number" step="0.01" id="nPaymentCost" class="form-control col-md-7 col-xs-12" style="margin-bottom:2% !important" required="required">
		                                </div>
		                              </div>
		                              <div class="form-group">
		                                <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3"> 
		                                  <button type="submit" class="btn btn-success pull-right add-item" id="nPaymentBtn" data-dismiss="modal">Add Item</button>
		                                </div>
		                              </div>
		                            </form>
		                          </div>
		                        </div>
		                      </div>
		                    </div>
		                    <!-- End of Modal content-->

		                     <!-- Modal used for editing row in table -->
		                     <!-- Modal content-->
		                     <div id="myModalEdit" class="modal fade" role="dialog">
		                      <div class="modal-dialog">
		                        <div class="modal-content pull-right col-md-12">
		                          <div class="modal-header">
		                            <button type="button" class="close" data-dismiss="modal">&times;</button>
		                            <h4 class="modal-title">Update Item</h4>
		                          </div>
		                          <div class="modal-body">
		                            <form id="nPaymentTrans">
		                             <div class="form-group">
		                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Particulars<span class="required">*</span>
		                                </label>
		                                <div class="col-md-9 col-sm-6 col-xs-12">
		                                  <select id="ePaymentItem" name="account_group_id" class="select2_single form-control" tabindex="-1" style="width:100%;">
		                                    <option></option>
		                                    @foreach($eExpenseAccountTitlesList as $eExpenseAccountTitle)
		                                      <option value="{{$eExpenseAccountTitle->id}}">{{$eExpenseAccountTitle->account_sub_group_name}}</option>
		                                    @endforeach
		                                  </select>
		                                  <!--input value="" type="text" id="nPaymentItem" class="form-control col-md-7 col-xs-12" style="margin-bottom:2% !important" required="required"-->
		                                </div>
		                              </div>
		                              <div class="form-group">
		                              </br>
		                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description<span class="required">*</span>
		                                </label>
		                                <div class="col-md-9 col-sm-6 col-xs-12">
		                                  <input value="" type="text" id="ePaymentDesc" class="form-control col-md-7 col-xs-12" style="margin-bottom:2% !important" required="required">
		                                </div>
		                              </div>
		                      
		                              <div class="form-group">
		                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Amount (PHP) <span class="required">*</span>
		                                </label>
		                                <div class="col-md-9 col-sm-6 col-xs-12">
		                                  <input value="" type="number" step="0.01" id="ePaymentCost" class="form-control col-md-7 col-xs-12" style="margin-bottom:2% !important" required="required">
		                                </div>
		                              </div>  
		                              <div class="form-group">
		                                <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3"> 
		                                  <button type="submit" class="btn btn-success pull-right add-item" id="ePaymentBtn" data-dismiss="modal">Update Item</button>
		                                </div>
		                              </div>
		                            </form>
		                          </div>
		                        </div>
		                      </div>
		                    </div>
		                    <!-- End of Modal content-->

                     		<div class="col-xs-6 pull-right">
                       			<p class="lead">Amount Due</p>
                       			<div class="table-responsive">
                         			<table class="table" id="amountCalc">
                           				<tbody>
                             				<tr>
                               					<th style="width:50%">Total:</th>
                               					<td>PHP 0</td>
                             				</tr>
                           				</tbody>
                         			</table>
                       			</div>
                     		</div>
                     		<!-- /.col -->
                  		</div>
                  		<!-- this row will not appear when printing -->
                  		<div class="row no-print">
                     		<div class="col-xs-12">
                        		<!--button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button -->
                        		<button class="btn btn-success pull-right" id="createExpBtn"><i class="fa fa-credit-card"></i> Create Expense Record</button>
                        		<!--button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button-->
                     		</div>
                  		</div>
               		</section>
            	</div>
         	</div>
      	</div>
   	</div>
<!-- /page content -->
@endsection