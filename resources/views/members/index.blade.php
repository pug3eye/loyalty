@extends('layouts.template')

@section('title', 'Membesr List')

@section('member_menu', 'class="treeview active"')

@section('member_list', 'class="active"')

@section('content')
<section class="content-header">
  <h1>MEMBERS LIST</h1>
</section>
<section class="content">
  <div class="row">
    <div class="col-sm-12">
      <!-- start box -->
      <div class="box">
        <div class="box-header">
        </div>
        <!-- content inside here -->
        <div class="box-body">

          <!-- data table -->
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Member ID</th>
                <th>Name</th>
                <th>E-mail</th>
                <th>Phone Number</th>
                <th style="text-align:center;">Point</th>
                <th style="width:5%; text-align:center;">View</th>
                <th style="width:5%; text-align:center;">Delete</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($members as $member)
                <tr>
                  <td>{{ $member->id }}</td>
                  <td>{{ $member->customer->firstname }} {{ $member->customer->lastname }}</td>
                  <td>{{ $member->customer->email }}</td>
                  <td>{{ $member->customer->phone_number }}</td>
                  <td style="text-align:center">{{ $member->point }}</td>
                  <td style="text-align:center;"><a href="{{ url('/member/'.$member->id) }}"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                  @if(!App\CheckBranch::isBranch())
                  <td style="text-align:center;"><span class="glyphicon glyphicon-trash" style="color:red; cursor:pointer;" onclick="deleteConfirm({{ $member->id }})"></span></td>
                  @else
                  <td style="text-align:center;"><span class="glyphicon glyphicon-trash" style="color:red;"></span></td>
                  @endif
                </tr>
              @endforeach
            </tbody>
          </table>
          <!-- end table -->

        </div>
        <!-- end box body -->
        <div style="border-style:none;" class="box-footer" >
        </div>
      </div>
      <!-- end box -->

    </div>
  </div>
</section>
@endsection

@section('js')

@if(!App\CheckBranch::isBranch())
<script>
  // sweet alert confirm when delete icon is click.
  function deleteConfirm(id) {
    swal({
      title: "Delete Confirm",
      text: "Are you sure you want to delete " + name,
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Delete",
      closeOnConfirm: false
    }, function() {
      swal("Deleted !", "Wait for refresh in a few second", "success");
      $.post("{{ url('member') }}/" + id, function(result){
        if ( !result.localeCompare('guest') ) {
          window.location.assign("{{ url('login') }}");
        } else {
          window.location.reload();
        }
      });
    });
  }
</script>
@endif

@endsection
