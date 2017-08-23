@extends('layouts.template')

@section('title', 'Edit Reward')

@section('reward_menu', 'class="treeview active"')

@section('content')
<section class="content-header">
  <h1 style="font-size:36px;">EDIT REWARD</h1>
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

          <form class="form-horizontal" method="post" action="{{ URL::current() }}" id="form_edit" enctype="multipart/form-data">

            <!-- start row reward code -->
            <div class="row">
              <div class="form-group{{$errors->has('code') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Reward Barcode</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1 col-lg-4 col-lg-offset-1">
                    <input type="text" class="form-control" name="code" value="{{ $reward->barcode }}" disabled="disabled" required>
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
                    <input type="text" class="form-control" name="name" value="{{ $reward->name }}" required>
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
                    <input type="text" class="form-control" name="point_use" value="{{ $reward->point_use }}" required>
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
                    <textarea class="form-control" name="detail" rows="4" cols="50" required>{{ $reward->detail }}</textarea>
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

            <!-- show image if have -->
            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3"></label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1 col-lg-4 col-lg-offset-1">
                    @if (strcmp($reward->image, 'no_image.png'))
                    <img style="max-height: 75%; max-width: 75%; cursor:pointer;" onclick="deleteRewardImage({{ $reward->id }})" class="img-responsive" src="{{ asset("images/rewards/$reward->image") }}"><br>
                    Click image to delete it.
                    @else
                    <img style="max-height: 75%; max-width: 75%;" class="img-responsive" src="{{ asset("images/rewards/$reward->image") }}">
                    @endif
                  </div>
                </div>
              </div>
            </div>
            <!-- end show image -->

            <!-- Submit button -->
            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <div class="col-sm-2 col-sm-offset-5 col-md-2 col-md-offset-5 col-lg-2 col-lg-offset-4">
                    <input type="submit" class="btn btn-primary" value="Edit Reward">
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
  @if (strcmp($reward->image, 'no_image.png'))
    <script>
      function deleteRewardImage(id) {
        swal({
          title: "Delete Confirm",
          text: "Are you sure you want to delete image",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Delete",
          closeOnConfirm: false
        }, function() {
          swal("Deleted !", "Wait for refresh in a few second", "success");
          $.post("{{ url('reward') }}/" + id + "/image", function(result) {
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
