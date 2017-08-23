@extends('layouts.template')

@section('title', 'Add New Reward')

@section('reward_menu', 'class="treeview active"')

@section('reward_add', 'class="active"')

@section('content')
<section class="content-header">
  <h1>ADD NEW REWARD</h1>
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

          <form class="form-horizontal" method="post" action="{{ url('reward/add') }}" id="form_add" enctype="multipart/form-data">

            <!-- start row reward code -->
            <div class="row">
              <div class="form-group{{$errors->has('code') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Reward Barcode</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1 col-lg-4 col-lg-offset-1">
                    <input type="text" class="form-control" name="code" value="{{ old('code') }}" required>
                  </div>
                  @if ($errors->has('code'))
                    <div class="col-sm-4 col-sm-offset-5 col-md-4 col-md-offset-5 col-lg-4 col-lg-offset-4">
                      <span class="help-block">{{ $errors->first('code') }}</span>
                    </div>
                  @endif
                </div>
              </div>
            </div>
            <!-- end row reward code -->

            <!-- start row reward name -->
            <div class="row">
              <div class="form-group{{$errors->has('name') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Reward Name</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1 col-lg-4 col-lg-offset-1">
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                  </div>
                  @if ($errors->has('name'))
                    <div class="col-sm-4 col-sm-offset-5 col-md-4 col-md-offset-5 col-lg-4 col-lg-offset-4">
                      <span class="help-block">{{ $errors->first('name') }}</span>
                    </div>
                  @endif
                </div>
              </div>
            </div>
            <!-- end row reward name -->

            <!-- start row reward point use -->
            <div class="row">
              <div class="form-group{{$errors->has('point_use') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Point Use</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1 col-lg-4 col-lg-offset-1">
                    <input type="text" class="form-control" name="point_use" value="{{ old('point_use') }}" required>
                  </div>
                  @if ($errors->has('point_use'))
                    <div class="col-sm-4 col-sm-offset-5 col-md-4 col-md-offset-5 col-lg-4 col-lg-offset-4">
                      <span class="help-block">{{ $errors->first('point_use') }}</span>
                    </div>
                  @endif
                </div>
              </div>
            </div>
            <!-- end row reward point use -->

            <!-- start row reward detail -->
            <div class="row">
              <div class="form-group{{$errors->has('detail') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Reward Detail</label>
                  <div class="col-sm-6 col-sm-offset-1 col-md-7 col-md-offset-1 col-lg-5 col-lg-offset-1">
                    <textarea class="form-control" name="detail" rows="4" cols="50" required>{{ old('detail') }}</textarea>
                  </div>
                  @if ($errors->has('detail'))
                    <div class="col-sm-4 col-sm-offset-5 col-md-4 col-md-offset-5 col-lg-4 col-lg-offset-4">
                      <span class="help-block">{{ $errors->first('detail') }}</span>
                    </div>
                  @endif
                </div>
              </div>
            </div>
            <!-- end row reward detail -->

            <!-- start row reward image -->
            <div class="row">
              <div class="form-group{{$errors->has('image') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Reward Image</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1 col-lg-4 col-lg-offset-1">
                    <input style="padding-top:7px" type="file" name="image">
                  </div>
                </div>
              </div>
            </div>
            <!-- end row reward image -->

            <br>

            <!-- Submit button -->
            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <div class="col-sm-2 col-sm-offset-5 col-md-2 col-md-offset-5 col-lg-2 col-lg-offset-4">
                    <input type="submit" class="btn btn-primary" value="Add Reward">
                  </div>
                </div>
              </div>
            </div>

          </form>

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

  @if(Session::has('flash_message'))
    <script>
      $(document).ready(function() {
        swal({
          title: "Success !",
          text: "Add new reward complete.",
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

  @if (Session::has('error_barcode'))
  <script>
  $(document).ready(function() {
    swal({
      title: "Error... ",
      text: "This reward barcode already use ! ",
      type: "error",
      confirmButtonText: "Close"
    });
  });
  </script>
  @endif

@endsection
