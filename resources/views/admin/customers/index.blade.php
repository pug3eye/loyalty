@extends('admin.layouts.template')

@section('title', 'Admin | Customers')

@section('customers', 'class="active"')

@section('content')
<section class="content-header">
	<h1>Customers List</h1>
</section>
<section class="content">

	@if($errors->any())
	<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-ban"></i> Error !</h4>
    <ul>
    @foreach($errors->all() as $error)
    	<li> {{	 $error }} </li>
    @endforeach
    <ul>
  </div>
  @endif

  @if(Session::has('flash_message'))
	<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-check"></i> Success !</h4>
    {{ Session::get('flash_message') }}
  </div>
  @endif

	<div class="row">
		<div class="col-sm-12">
			<div class="box">
				<div class="box-header">
					<p class="btn btn-sm btn-success btn-flat pull-left" data-toggle="modal" data-target="#add_modal">Add New Customer</p>
				</div>
				<div class="box-body">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Username</th>
								<th>Full Name</th>
								<th>E-mail</th>
								<th>Phone Number</th>
                <th style="width:5%; text-align:center;">View</th>
                <th style="width:5%; text-align:center;">Edit</th>
                <th style="width:5%; text-align:center;">Delete</th>
							</tr>
						</thead>
						<tbody>
							@foreach($customers as $customer)
							<tr>
								<td>{{ $customer->id }}</td>
								<td>{{ $customer->username }}</td>
								<td>{{ $customer->firstname }} {{ $customer->lastname }}</td>
								<td>{{ $customer->email }}</td>
								<td>{{ $customer->phone_number }}</td>
								<td style="text-align:center;"><a href="{{ url('admin/customer/'.$customer->id) }}"><span class="glyphicon glyphicon-eye-open"></span></a>
								<td style="text-align:center;"><span class="glyphicon glyphicon-pencil" style="cursor:pointer" onclick="edit({{ $customer->id }})"></span></a></td>
								<td style="text-align:center;"><span class="glyphicon glyphicon-trash" style="color:red; cursor:pointer;" onclick="deleteCustomer({{ $customer->id }})"></span></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-labelledby="add_modal_label">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="add_modal_label">Add New Customer</h4>
				</div>
				<div class="modal-body">
				<form action="{{ url('admin/customer/add') }}" method="post" role="form">


						<div class="form-group">
							<label>Username</label>
							<input type="text" class="form-control" name="username" required>
						</div>

						<div class="form-group">
							<label>Password</label>
							<input type="password" class="form-control" name="password" required>
						</div>

						<div class="form-group">
							<label>First Name</label>
							<input type="text" class="form-control" name="firstname" required>
						</div>

						<div class="form-group">
							<label>Last Name</label>
							<input type="text" class="form-control" name="lastname" required>
						</div>

						<div class="form-group">
							<label>E-mail</label>
							<input type="email" class="form-control" name="email" required>
						</div>

						<div class="form-group">
							<label>Phone Number</label>
							<input type="text" class="form-control" name="phone_number" required>
						</div>

				</div>
				<div class="modal-footer">
          <input type="submit" class="btn btn-primary" value="Add New Customer">
        </div>
      	</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="edit_modal_label">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="edit_modal_label">Edit Customer</h4>
				</div>
				<div class="modal-body edit-customer">
					...
				</div>

			</div>
		</div>
	</div>

</section>
@endsection

@section('js')
<script>

	function edit(id)
	{
		$.get("{{ url('admin/customer') }}/" + id + "/edit", function(result) {
			$( ".edit-customer" ).html(result)
			$( "#edit_modal" ).modal('show');
		});
	}

	function deleteCustomer(id)
	{
		swal({
			title: "Delete Confirm",
			text: "Are you sure to delete ?",
			type: "warning",
			showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Delete",
      closeOnConfirm: false
		}, function() {
			swal("Deleted !", "Wait for refresh in a few second", "success");
			$.post("{{ url('admin/customer') }}/" + id, function(result) {
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
