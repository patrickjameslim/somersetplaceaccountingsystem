@extends('master_layout.master_page_layout')
@section('content')
   	<div class="">
      	<div class="page-title">
         	<div class="title_left">
            	<h3><i class="fa fa-money"></i> Receipt</h3>
         	</div>
      	</div>
      	<div class="clearfix"></div>
      	<div class="col-md-12 col-sm-12 col-xs-12">
         	<div class="x_panel">
            	<div class="x_title">
               		<h2>Receipt Details</h2>
               		<ul class="nav navbar-right panel_toolbox">
                  		<li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  		</li>
               		</ul>
               		<div class="clearfix"></div>
            	</div>
            	<div class="x_content">
               		<section class="content receipt">
                  		<!-- title row -->
                  		<div class="row">
                     		<div class="col-xs-12 invoice-header">
                        		<div class="col-md-4">
                           			<h4>Receipt #: {{$receiptNumber}}</h4>
                        		</div>
                        		<div class="col-md-4">
                           			<h4>Invoice #: {{$invoiceNumber}} </h4>
                        		</div>
                     		</div>
                     		<!-- /.col -->
                  		</div>
                  		<div class="ln_solid"></div>
                  		<!-- info row -->
                  		<div class="row invoice-info">
                     		<div class="col-sm-4 invoice-col">
                        		<div class="form-group">
                           			<label for="" class="control-label">Cashier</label>
                           			<h5>{{$eCashier->first_name}} {{$eCashier->last_name}}</h5>
                        		</div>
                     		</div>
                     		<div class="col-sm-4 invoice-col">
                        		<div class="form-group">
                           			<label class="control-label" for="homeowner">To</label>
                           			<h5>{{$homeOwnerInfo->first_name}} {{$homeOwnerInfo->middle_name}} {{$homeOwnerInfo->last_name}} </h5>
                        		</div>
                     		</div>
                     		<!-- /.col -->
                     		<div class="col-sm-4 invoice-col">
                         		<label class="control-label" for="homeowner">Payment Due:</label>
                        		<div class="form-group">
                           			<h5>{{date('Y-m-d',strtotime($homeOwnerInvoice->payment_due_date))}}</h5>
                        		</div>
                     		</div>
                     		<!-- /.col -->
                  		</div>
                  		<!-- /.row -->
                  		<!-- Table row -->
                  		<div class="row">
                     		<div class="col-md-6">
                        		<table class="table table-striped">
                           			<thead>
                                <tr>
                                    <th style="width: 30%">Payment Type</th>
                                   <th style="width: 59%">Covering Month/s</th>
                                   <th>Amount (PHP)</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($pendingPaymentsList as $pendingPayment)
                                  <tr>
                                    <td>{{$tIncomeAccountTitlesList[$pendingPayment->account_title_id]}}</td>
                                    <td>{{$pendingPayment->remarks}}</td>
                                    <td>{{$pendingPayment->amount}}</td>
                                  </tr>
                                @endforeach
                              </tbody>
                       	 		</table>
                     		</div>
                     		<!-- /.col -->

                     		<div class="col-xs-6 pull-right">
                      			<p class="lead">Amount Due</p>
                       			<div class="table-responsive">
                         			<table class="table">
                         				<tbody>
                                  <tr>
                                    <th style="width:50%">Total:</th>
                                    <td>{{$homeOwnerInvoice->total_amount}}</td>
                                  </tr>
                                </tbody>
                         			</table>
                       			</div>
                     		</div>
                     		<!-- /.col -->
                     		<div class="col-xs-6 pull-right">
                       			<p class="lead">Payment Details</p>
                       			<div class="table-responsive">
                         			<table class="table">
                           				<tbody>
                             				<tr>
                             					<th style="width:50%">Date of Payment:</th>
                             					<td>{{date_format($homeOwnerPaymentTrans->created_at,'m/d/y')}}</td>
                             				</tr>
                             				<tr>

                             					<th>Attached File:</th>
                                      @if($homeOwnerPaymentTrans->file_related==NULL)
                                        <td><strong>No File Attached</strong></td>
                                      @else
                                        <td><a href="#"><strong>{{$homeOwnerPaymentTrans->file_related}}</strong></a></td>
                                      @endif
                             					
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
                        		<button class="btn btn-default pull-right" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                        		<button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>
                     		</div>
                  		</div>
               		</section>
            	</div>
         	</div>
      	</div>
   	</div>
@endsection