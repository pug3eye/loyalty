@extends('layouts.template')

@section('title', 'Edit Branch Info')

@section('shop_edit', 'class="active"')

@section('css')
  <style>
    .no-border {
      border: none;
    }

    .bt {
      background-color: #d2d6de;
    }
  </style>
@endsection

@section('content')
<section class="content-header">
  <h1>EDIT BRANCH INFORMATION</h1>
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

            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-3 col-md-3 col-lg-3">Shop Owner</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-5 col-md-offset-1 col-lg-5 col-lg-offset-1">
                    <p class="form-control" readonly>{{ $user->owner }}</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-3 col-md-3 col-lg-3">E-mail</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-5 col-md-offset-1 col-lg-5 col-lg-offset-1">
                    <p class="form-control" readonly>{{ $user->email }}</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-3 col-md-3 col-lg-3">Shop Address</label>
                  <div class="col-sm-6 col-sm-offset-1 col-md-7 col-md-offset-1 col-lg-6 col-lg-offset-1">
                    <input type="text" class="form-control" name="address" value="{{ $user->address}}">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-3 col-md-3 col-lg-3">Shop Detail</label>
                  <div class="col-sm-6 col-sm-offset-1 col-md-7 col-md-offset-1 col-lg-6 col-lg-offset-1">
                    <textarea class="form-control" name="detail" rows="4" cols="50" readonly>{{ $user->detail }}</textarea>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-3 col-md-3 col-lg-3">Discount for member (%)</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-5 col-md-offset-1 col-lg-5 col-lg-offset-1">
                    <p class="form-control" readonly>{{ $user->discount}}</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-3 col-md-3 col-lg-3">Point for new members</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-5 col-md-offset-1 col-lg-5 col-lg-offset-1">
                    <p class="form-control" readonly>{{ $user->start_point}}</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-3 col-md-3 col-lg-3">Point Condition</label>
                  <div class="col-sm-8 col-sm-offset-1 col-md-8 col-md-offset-1 col-lg-8 col-lg-offset-1">
                    <div class="form-inline">
                      <div class="input-group">
                        <input type="text" class="form-control input-sm" size="7" name="point_get" value="{{ $user->point_get }}" readonly>
                        <div class="input-group-addon no-border">Points,</div>
                        <div class="input-group-addon no-border">Every</div>
                        <input type="text" class="form-control input-sm" size="7" name="point_condition" value="{{ $user->point_condition }}" readonly>
                        <div class="input-group-addon no-border">Bath.</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- show image if have -->
            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3"></label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1 col-lg-4 col-lg-offset-1">
                    @if ( !is_null($user->image))
                    <img style="max-height: 75%; max-width: 75%; cursor:pointer;" onclick="deleteRewardImage()" class="img-responsive" src="{{ asset("images/shops/$user->image") }}"><br>
                    Click image to delete it.
                    @else
                    <img style="max-height: 75%; max-width: 75%;" class="img-responsive" src="{{ asset("images/shops/no_image.png") }}">
                    @endif
                  </div>
                </div>
              </div>
            </div>
            <!-- end show image -->

            <br>

            <!-- Submit button -->
            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <div class="col-sm-2 col-sm-offset-5 col-md-2 col-md-offset-5 col-lg-2 col-lg-offset-4">
                    <input type="submit" class="btn btn-block btn-primary" value="Submit">
                  </div>
                </div>
              </div>
            </div>


          </form>

        </div>
        <!-- end content -->
      </div>
      <!-- end box -->
    </div>
  </div>
</section>
@endsection

@section('js')

  @if (Session::has('flash_message'))
    <script>
      $(document).ready(function() {
        swal({
          title: "Success",
          text: "Edit Shop Information Complete.",
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
