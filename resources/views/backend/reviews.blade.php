@extends('backend.layouts.app')

@section('content')
<!-- BEGIN: Subheader -->
<div class="m-subheader">
	<div class="d-flex align-items-center">
		<div class="mr-auto">
			<h3 class="m-subheader__title">Reviews</h3>
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
						{{ Form::select('status', collect(['Y' => 'Approved', 'N' => 'Unapproved'])->prepend('Select status', ''), null, array('class' => 'form-control m-input filter_status')) }}
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
						<th><label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"><input type="checkbox" value="" class="m-group-checkable"><span></span></label></th>
						<th>No</th>
						<th>Name</th>
						<th>Rating</th>
						<th>Comment</th>
						<th>Status</th>
						<th width="100px">Action</th>
					</tr>
				</thead>
				<tbody>
				</tbody>	
			</table>
			<button class="btn btn-danger" id="mass-delete" data-url="{{route('backend.reviews.mass-delete')}}">Mass Delete</button>
			{{-- <button class="btn btn-success" id="mass-approve" data-url="">Mass Approve</button> --}}
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
			ajax:{
				url:"{{ route('backend.reviews.index') }}",
				data: function (d) {
					d.search = $('input[type="search"]').val(),
					d.status = $('.filter_status').val()
				}
			},
			columns: [
			{data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
			{data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
			{data: 'name', name: 'name'},
			{data: 'rating', name: 'rating'},
			{data: 'comment', name: 'comment'},
			{data: 'status', name: 'status'},
			{data: 'action', name: 'action', orderable: false, searchable: false},
			],
			fnInitComplete : function() {
				if ($(this).find('tbody tr').length <= 1) {
					$('#mass-delete').hide();
				}
			}
		});

		//multi select
		table.on("change", ".m-group-checkable", function () {
			var e = $(this).closest("table").find("td:first-child .m-checkable"),
			a = $(this).is(":checked");
			$(e).each(function () {
				a ? ($(this).prop("checked", !0), $(this).closest("tr").addClass("active")) : ($(this).prop("checked", !1), $(this).closest("tr").removeClass("active"));
			});
		});

		table.on("change", "tbody tr .m-checkbox", function () {
			$(this).parents("tr").toggleClass("active");
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
		
		/* Change status */
		$(document).on('click', '.change-status', function (e) {
			var url = $(this).data('url');

			var status = 'Approve';
			if($(this).data('value') == 'Y'){
				status = 'Unapprove';
			}

			swal({ 
				title: "Are you sure?",
				text: "Do you want to "+status+" review!",
				type: "warning",
				showCancelButton: true,
				confirmButtonText: "Yes!"
			}).then(function (e) {
				if(e.value){
					mApp.blockPage({
						overlayColor: "#000000",
						type: "loader",
						state: "success",
						message: "Please wait..."
					});

					$.ajax({
						headers: {
							'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
						},
						type: "post",
						url: url,
						success: function (result) {
							mApp.unblockPage();
							if (result.status == 'success') {
								table.draw();
								toastr.success(result.message);
							} else {
								toastr.error(result.message);
							}
						},
						error: function (jqXHR, textStatus, errorThrown) {
							mApp.unblockPage();
						}
					});
				}
			});
		});

		/* Delete record */
		$(document).on('click', '.delete-record', function (e) {
			var url = $(this).data('url');

			swal({ 
				title: "Are you sure?",
				text: "You won't be able to revert this!",
				type: "warning",
				showCancelButton: true,
				confirmButtonText: "Yes, delete it!"
			}).then(function (e) {
				if(e.value){
					mApp.blockPage({
						overlayColor: "#000000",
						type: "loader",
						state: "success",
						message: "Please wait..."
					});

					$.ajax({
						headers: {
							'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
						},
						type: "delete",
						url: url,
						success: function (result) {
							mApp.unblockPage();
							if (result.status == 'success') {
								table.draw();
								toastr.success(result.message);
							} else {
								toastr.error(result.message);
							}
						},
						error: function (jqXHR, textStatus, errorThrown) {
							mApp.unblockPage();
						}
					});
				}
			});
		});

		/* Mass Delete */
		$(document).on('click', '#mass-delete', function (e) {
			var url = $(this).data('url');

			var ids = [];

			$('.m-checkable:checked').each(function(){
				ids.push($(this).val());
			});

			if(ids.length > 0){

				swal({ 
					title: "Are you sure you want to Delete selected "+ids.length+" records?",
					text: "You won't be able to revert this!",
					type: "warning",
					showCancelButton: true,
					confirmButtonText: "Yes, delete it!"
				}).then(function (e) {
					if(e.value){
						mApp.blockPage({
							overlayColor: "#000000",
							type: "loader",
							state: "success",
							message: "Please wait..."
						});

						$.ajax({
							headers: {
								'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
							},
							type: "post",
							url: url,
							data: {'ids': ids},
							success: function (result) {
								mApp.unblockPage();
								if (result.status == 'success') {
									table.draw();
									toastr.success(result.message);
								} else {
									toastr.error(result.message);
								}
							},
							error: function (jqXHR, textStatus, errorThrown) {
								mApp.unblockPage();
							}
						});
					}
				});
			}else{
				toastr.error('Please select atleast one checkbox.');
			}
		});

	});
</script>
@endsection