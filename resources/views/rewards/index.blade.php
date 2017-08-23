@extends('layouts.template')

@section('title', 'Rewards List')

@section('reward_menu', 'class="treeview active"')

@section('reward_list', 'class="active"')

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
  <h1>REWARDS LIST</h1>
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
          <table class="table table-hover">
            <thead>
              <tr>
                <th style="width:9%;">Barcode</th>
                <th>Reward Name</th>
                <th>Point Use</th>
                <th style="width:18%;">Last Updated</th>
                <th style="width:18%;">Created At</th>
                <th style="width:5%; text-align:center;">View</th>
                <th style="width:5%; text-align:center;">Edit</th>
                <th style="width:5%; text-align:center;">Delete</th>
              </tr>
            </thead>
            <tbody>
              @if (count($rewards) > 0)
                @foreach ($rewards as $reward)
                  <tr>
                    <td>{{ $reward->barcode }}</td>
                    <td>{{ $reward->name }}</td>
                    <td>{{ $reward->point_use }}</td>
                    <td>{{ $reward->updated_at->format('j F Y g:i A') }}</td>
                    <td>{{ $reward->created_at->format('j F Y g:i A') }}</td>
                    <td style="text-align:center;"><span style="cursor:pointer;" class="glyphicon glyphicon-eye-open" onclick="showRewardDetail({{ $reward->id }}, '{{ $reward->name }}')"></span></td>
                    <td style="text-align:center;"><a href="{{ url('/reward/'.$reward->id.'/edit') }}"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    @if(!App\CheckBranch::isBranch())
                    <td style="text-align:center;"><span class="glyphicon glyphicon-trash" style="color:red; cursor:pointer;" onclick="deleteRewardConfirm({{ $reward->id }}, '{{ $reward->name }}')"></span></td>
                    @else
                      <td style="text-align:center;"><span class="glyphicon glyphicon-trash" style="color:red;"></span></td>
                    @endif
                  </tr>
                @endforeach
              @endif
            </tbody>
          </table>
        </div>
        <!-- end box body -->
        <div style="border-style:none;" class="box-footer" >
        </div>
      </div>
      <!-- end box -->
    </div>
  </div>

  <!-- modal for show data -->
  <div class="modal fade" id="view_modal" tabindex="-1" role="dialog" aria-labelledby="view_modal_label">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <!-- head of modal -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title reward_name" id="view_modal_label">Reward Name</h3>
        </div>
        <!-- end head -->
        <!-- content inside here -->
        <div class="modal-body show_reward">
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

  @if(!App\CheckBranch::isBranch())
  <script>
    // delete reward confirm.
    function deleteRewardConfirm(id, name) {
      swal({
        title: "Delete Confirm",
        text: "Are you sure you want to delete \"" + name + "\"",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Delete",
        closeOnConfirm: false
      }, function() {
        swal("Deleted !", "Wait for refresh in a few second", "success");
        $.post("{{ url('reward') }}/" + id, function(result) {
          if (!result.localeCompare('guest')) {
            window.location.assign("{{ url('login') }}");
          } else {
            window.location.reload();
          }
        });
      });
    }
  </script>
  @endif


  <script>
    // show image and detail.
    function showRewardDetail(id, name) {
      $.get("{{ url('reward') }}/" + id, function(result) {
        $( ".show_reward" ).html(result);
        $( ".reward_name").html(name);
        $('#view_modal').modal('show');
      });
    }
  </script>

  @if (Session::has('flash_message'))
  <script>
  $(document).ready(function() {
    swal({
      title: "Success !",
      text: "Edit reward complete.",
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
