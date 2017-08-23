@extends('layouts.template')

@section('title', 'Redeem Reward')

@section('redeem', 'class="active"')

@section('content')
<section class="content-header">
  <h1>REDEEM REWARD</h1>
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
          <div class="col-sm-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            <div class="form-group">
              <div class="input-group">
                <input class="form-control" type="text" name="redeem_code" id="redeem_code" placeholder="Enter redeem code...">
                <span class="input-group-btn">
                  <input type="submit" class="btn btn-primary" onclick="redeem()" value="REDEEM">
                </span>
              </div>
            </div>
          </div>
        </div>
        <!-- end content -->
      </div>
      <!-- end box -->
    </div>
  </div>
</section>
@endsection

@section('js')
<script>
  function redeem() {
    var code = $( "#redeem_code" ).val();
    $.post("{{ url('redeem') }}", { code:code }, function(result) {
      if(!result.localeCompare('guest')) {
        window.location.assign("{{ url('login') }}");
      } else if (!result.localeCompare('error')) {
        swal({
          title: "Error",
          text: "Your code is not valid",
          type: "error",
          confirmButtonText: "Close"
        });
      } else {
        swal({
          title: "Complete",
          text: "Redeem reward \"" + result + "\" complete" ,
          type: "success",
          confirmButtonText: "Next"
        }, function() {
          $.post("{{ url('redeem/result') }}", { code:code}, function(result) {
            swal({
              title: "Member Detail",
              text: result,
              html: true,
              confirmButtonText: "Close"
            });
          });
        });
      }
    });
  }
</script>
@endsection
