@extends('backend.layouts.app')

@section('content')
<!-- BEGIN: Subheader -->
<div class="m-subheader">
	<div class="d-flex align-items-center">
		<div class="mr-auto">
			<h3 class="m-subheader__title">Orders</h3>
		</div>
	</div>
</div>
<!-- END: Subheader -->
<div class="m-content">
	
	@include('backend.layouts.partials.alert-messages')

	<!--begin::Portlet-->
	<div class="m-portlet m-portlet--mobile">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						{{-- Department List --}}
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body">
			
			<!--begin: Search Form -->
			<form class="m-form m-form--fit m--margin-bottom-20">
				<div class="row m--margin-bottom-20">
					<div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
						{{ Form::select('status', collect(config('constants.chainswap_status'))->prepend('Select status', ''), null, array('class' => 'form-control m-input filter_status')) }}
					</div>
					<div class="col-lg-3 offset-md-6 m--margin-bottom-10-tablet-and-mobile">
						<button type="button" class="btn btn-brand m-btn m-btn--icon" id="submit_filters">
							<span>
								<i class="la la-search"></i>
								<span>Search</span>
							</span>
						</button>
						&nbsp;&nbsp;
						<button type="button" class="btn btn-secondary m-btn m-btn--icon" id="reset_filters">
							<span>
								<i class="la la-close"></i>
								<span>Reset</span>
							</span>
						</button>
					</div>
				</div>
			</form>
			<!--end: Search Form -->
			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
				<thead>
					<tr>
						<th>No</th>
						<th>Order ID</th>
						<th>Actual Order ID</th>
						<th>Rate Mode</th>
						<th>Exchange</th>
						<th>Address From</th>
						<th>Address To</th>
						<th>Order At</th>
	                    <th>User Ip</th>
						<th>User Agent</th>
						<th>Refund Address</th>
						<th>Network From</th>
						<th>Network To</th>
				   {{--<th>Exchange By</th>--}}
						<th>Used Referral Id</th>
				        <th>Hash In</th>
						<th>Hash Out</th>
						<th>Status</th>
				   {{--<th width="100px">Action</th>--}}
					</tr>
				</thead>
				<tbody>
				</tbody>	
			</table>
			<!--end: Datatable -->
		</div>	
	</div>
	<!--end::Portlet-->

</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){

		var table = $('#m_table_1').DataTable({
			processing: true,
			serverSide: true,
			responsive: true,
			ajax:{
				url:"{{ route('backend.orders.index') }}",
				data: function (d) {
                	d.search = $('input[type="search"]').val()
                	d.status = $('.filter_status').val()
            	}
			},
			columns: [
			{data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
			{data: 'orderid', name: 'orderid'},
			{data: 'actual_order_id', name: 'actual_order_id'},
			{data: 'rate_mode', name: 'rate_mode'},
			{data: 'exchange', name: 'exchange'},
			{data: 'from_address', name: 'from_address'},
			{data: 'to_address', name: 'to_address'},
			{data: 'order_at', name: 'order_at'},
            {data: 'user_ip', name: 'user_ip'},
			{data: 'user_agent', name: 'user_agent'},
			{data: 'refund_address', name: 'refund_address'},
            // {data: 'exchange_api', name: 'exchange_api'},
            {data: 'networks_from', name: 'networks_from'},
            {data: 'networks_to', name: 'networks_to'},
            {data: 'referral_id', name: 'referral_id'},
			{data: 'hash_in', name: 'hash_in'},
			{data: 'hash_out', name: 'hash_out'},
			{data: 'status', name: 'status'},
			// {data: 'action', name: 'action', orderable: false, searchable: false},
			]
		});

		/* Filter records */
		$('#submit_filters').click(function(){
			table.draw();
		});

		$('#reset_filters').click(function(){
			$('.filter_status').val('');
			$('input[type="search"]').val('');
			table.draw();
		});

	});
</script>
@endsection