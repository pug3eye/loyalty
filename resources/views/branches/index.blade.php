@extends('layouts.template')

@section('title', 'Branch')

@section('branch_menu', 'class="treeview active"')

@section('branch_list', 'class="active"')

@section('css')
  <style>
    .displayed {
      displayed: block;
      margin-left: auto;
      margin-right: auto;
      max-height: 75%;
      max-width: 75%;
    }
  </style>
@endsection

@section('content')
<section class="content-header">
  <h1>BRANCHES LIST</h1>
</section>
<section class="content">
  <div class="row">
    <div class="col-sm-12">
      <!-- start box. -->
      <div class="box">
        <div class="box-header">
        </div>
        <!-- content inside here. -->
        <div class="box-body">

          <!-- data table. -->
          <table class="table table-hover">
            <thead>
              <th>Branch Name</th>
              <th>Branch E-mail</th>
              <th>Branch Address</th>
              <th style="width:5%; text-align:center;">View</th>
              <th style="width:5%; text-align:center;">Edit</th>
              <th style="width:5%; text-align:center;">Delete</th>
            </thead>
            <tbody>
              @foreach ($branches as $branch)
                <tr>
                  <td>{{ $branch->name }}</td>
                  <td>{{ $branch->shop->email }}</td>
                  <td>{{ $branch->shop->address }}</td>
                  <td style="text-align:center;"><span style="cursor:pointer;" class="glyphicon glyphicon-eye-open" onclick="showDetail({{ $branch->sub_id }}, '{{  $branch->name }}')"></span></td>
                  <td style="text-align:center;"><a href="{{ url('/branch/'.$branch->sub_id.'/edit') }}"><span class="glyphicon glyphicon-pencil"></span></a></td>
                  <td style="text-align:center;"><span class="glyphicon glyphicon-trash" style="color:red; cursor:pointer;" onclick="deleteConfirm({{ $branch->sub_id }}, '{{ $branch->name }}')"></span></td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <!-- end table. -->

        </div>
        <div style="border-style:none;" class="box-footer" >
        </div>
      </div>
      <!-- end box. -->
    </div>
  </div>

  <!-- modal for show data -->
  <div class="modal fade" id="view_modal" tabindex="-1" role="dialog" aria-labelledby="view_modal_label">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <!-- head of modal -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title branch_name" id="view_modal_label">Branch Name</h3>
        </div>
        <!-- end head -->
        <!-- content inside here -->
        <div class="modal-body show_branch">
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
  // sweet alert confirm when delete icon is click.
  function deleteConfirm(id, name) {
    swal({
      title: "Delete Confirm",
      text: "Are you sure you want to delete branch \"" + name + "\"",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Delete",
      closeOnConfirm: false
    }, function() {
      swal("Deleted !", "Wait for refresh in a few second", "success");
      $.post("{{ url('branch') }}/" + id, function(result){
        if ( !result.localeCompare('guest') ) {
          window.location.assign("{{ url('login') }}");
        } else {
          window.location.reload();
        }
      });
    });
  }
</script>

<script>
  function showDetail(id, name) {
    $.get("{{ url('branch') }}/" + id, function(result) {
      $( ".show_branch" ).html(result);
      $( ".branch_name").html(name);
      $('#view_modal').modal('show');
    });
  }
</script>

@if (Session::has('flash_message'))
<script>
$(document).ready(function() {
  swal({
    title: "Success !",
    text: "Edit branch complete.",
    type: "success",
    timer: 1500,
    showConfirmButton: false
  });
});
</script>
@endif

@if (Session::has('error_message'))
<script>
$(document).ready(function() {
  swal({
    title: "Oops... ",
    text: "Some errors have occur. Please try again ! ",
    type: "error",
    confirmButtonText: "Close"
  });
});
</script>
@endif

@endsection
