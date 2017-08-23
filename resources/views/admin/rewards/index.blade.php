@extends('admin.layouts.template')

@section('title', 'Admin | Rewards')

@section('rewards', 'class="active"')

@section('css')
  <style>
    .displayed {
      displayed: block;
      margin-left: auto;
      margin-right: auto;
      max-height: 40%;
      max-width: 40%;
    }
  </style>
@endsection

@section('content')
<section class="content-header">
	<h1>Rewards List</h1>
</section>
<section class="content">

  <div class="row">
    <div class="col-sm-12">
      <div class="box">
        <div class="box-header">
        </div>
        <div class="box-body">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Shop Name</th>
                <th>Barcode</th>
                <th>Name</th>
                <th>Point Use</th>
                <th>Last Updated</th>
                <th>Created At</th>
                <th style="width:5%; text-align:center;">View</th>
                <th style="width:5%; text-align:center;">Delete</th>
              </tr>
            </thead>
            <tbody>
              @foreach($rewards as $reward)
              <tr>
                <td>{{ $reward->id }}</td>
                <td>{{ $reward->owner->name }}</td>
                <td>{{ $reward->barcode }}</td>
                <td>{{ $reward->name }}</td>
                <td>{{ $reward->point_use }}</td>
                <td>{{ $reward->updated_at->format('j F Y g:i A') }}</td>
                <td>{{ $reward->created_at->format('j F Y g:i A') }}</td>
                <td style="text-align:center;"><span style="cursor:pointer;" class="glyphicon glyphicon-eye-open" onclick="showModal({{ $reward->id }}, '{{ $reward->name }}')"></span></td>
                <td style="text-align:center;"><span class="glyphicon glyphicon-trash" style="color:red; cursor:pointer;" onclick="deleteReward({{ $reward->id }})"></span></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    </div>
  </div>

	<!-- modal for show data -->
	<div class="modal fade" id="view_modal" tabindex="-1" role="dialog" aria-labelledby="view_modal_label">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<!-- head of modal -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title product_name" id="view_modal_label">Product Name</h3>
				</div>
				<!-- end head -->
				<!-- content inside here -->
				<div class="modal-body show_product">
					.....
				</div>
				<!-- end content -->
				<!-- footer of modal -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				<!-- end footer -->
			</div>
		</div>
	</div>
	<!-- end modal -->

</section>
@endsection

@section('js')
<script>

	function showModal(id, name) {
		$.get("{{ url('admin/reward') }}/" + id, function(result) {
			$( ".show_product" ).html(result);
			$( ".product_name").html(name);
			$('#view_modal').modal('show');
		});
	}

	function deleteReward(id) {
		swal({
			title: "Delete Confirm",
			text: "Are you sure you want to delete",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Delete",
			closeOnConfirm: false
		}, function() {
			swal("Deleted !", "Wait for refresh in a few second", "success");
			$.post("{{ url('admin/reward') }}/" + id, function(result) {
				if ( !result.localeCompare('guest') ) {
					window.location.assign("{{ url('admin/login') }}");
				} else {
					window.location.reload();
				}
			});
		});
	}

</script>
@endsection
