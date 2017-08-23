@extends('admin.layouts.template')

@section('title', 'Admin | Members')

@section('members', 'class="active"')

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
	<h1>Members List</h1>
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
                <th>Customer Name</th>
                <th>Shop Name</th>
                <th>Is Member</th>
                <th>Point</th>
                <th>Register At</th>
                <th style="width:5%; text-align:center;">View</th>
                <th style="width:5%; text-align:center;">Delete</th>
              </tr>
            </thead>
            <tbody>
              @foreach($members as $member)
              <tr>
                <td>{{ $member->id }}</td>
                <td>{{ $member->customer->firstname }} {{ $member->customer->lastname}}</td>
                <td>{{ $member->shop->name }}</td>
                @if($member->is_member)
                <td>Yes</td>
                <td>{{ $member->point }}
                @else
                <td>No</td>
                <td>0</td>
                @endif
                <td>{{ $member->created_at->format('j F Y g:i A') }}</td>
                <td style="text-align:center;"><a href="{{ url('admin/member/'.$member->id) }}"><span class="glyphicon glyphicon-eye-open"></span></a>
                <td style="text-align:center;"><span class="glyphicon glyphicon-trash" style="color:red; cursor:pointer;" onclick="deleteMember({{ $member->id }})"></span></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    </div>
  </div>

</section>
@endsection

@section('js')
<script>

	function deleteMember(id) {
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
			$.post("{{ url('admin/member') }}/" + id, function(result) {
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
