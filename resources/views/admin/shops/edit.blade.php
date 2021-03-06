@extends('admin.layouts.template')

@section('title', 'Admin | Edit Shop')

@section('shops', 'class="active"')

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
  <h1>{{ $shop->name }}</h1>
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
                  <label class="control-label col-sm-3 col-md-3 col-lg-3">Username</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-5 col-md-offset-1 col-lg-5 col-lg-offset-1">
                    <input type="text" class="form-control" name="username" value="{{ $shop->username }}">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-3 col-md-3 col-lg-3">Password</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-5 col-md-offset-1 col-lg-5 col-lg-offset-1">
                    <input type="password" class="form-control" name="password">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-3 col-md-3 col-lg-3">Shop Name</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-5 col-md-offset-1 col-lg-5 col-lg-offset-1">
                    <input type="text" class="form-control" name="name" value="{{ $shop->name }}">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-3 col-md-3 col-lg-3">Owner</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-5 col-md-offset-1 col-lg-5 col-lg-offset-1">
                    <input type="text" class="form-control" name="owner" value="{{ $shop->owner }}">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-3 col-md-3 col-lg-3">E-mail</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-5 col-md-offset-1 col-lg-5 col-lg-offset-1">
                    <input type="email" class="form-control" name="email" value="{{ $shop->email }}">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-3 col-md-3 col-lg-3">Address</label>
                  <div class="col-sm-6 col-sm-offset-1 col-md-7 col-md-offset-1 col-lg-6 col-lg-offset-1">
                    <input type="text" class="form-control" name="address" value="{{ $shop->address}}">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-3 col-md-3 col-lg-3">Detail</label>
                  <div class="col-sm-6 col-sm-offset-1 col-md-7 col-md-offset-1 col-lg-6 col-lg-offset-1">
                    <textarea class="form-control" name="detail" rows="4" cols="50">{{ $shop->detail }}</textarea>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-3 col-md-3 col-lg-3">Discount for member (%)</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-5 col-md-offset-1 col-lg-5 col-lg-offset-1">
                    <input type="text" class="form-control" name="discount" value="{{ $shop->discount}}">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-3 col-md-3 col-lg-3">Point for new members</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-5 col-md-offset-1 col-lg-5 col-lg-offset-1">
                    <input type="text" class="form-control" name="start_point" value="{{ $shop->start_point}}">
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
                        <input type="text" class="form-control input-sm" size="7" name="point_get" value="{{ $shop->point_get }}">
                        <div class="input-group-addon no-border">Points,</div>
                        <div class="input-group-addon no-border">Every</div>
                        <input type="text" class="form-control input-sm" size="7" name="point_condition" value="{{ $shop->point_condition }}">
                        <div class="input-group-addon no-border">Bath.</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group{{$errors->has('image') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Logo</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1 col-lg-4 col-lg-offset-1">
                    <input style="padding-top:7px" type="file" name="image">
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
                    @if ( !is_null($shop->image))
                    <img style="max-height: 75%; max-width: 75%; cursor:pointer;" onclick="deleteImage()" class="img-responsive" src="{{ asset("images/shops/".$shop->image) }}"><br>
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
  @if (!is_null($shop->image))
    <script>
      function deleteImage() {
        swal({
          title: "Delete Confirm",
          text: "Are you sure you want to delete logo",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Delete",
          closeOnConfirm: false
        }, function() {
          swal("Deleted !", "Wait for refresh in a few second", "success");
          $.post("{{ url('admin/shop/'.$shop->id.'/logo') }}", function(result) {
            if ( !result.localeCompare('guest') ) {
              window.location.assign("{{ url('admin/login') }}");
            } else {
              window.location.reload();
            }
          });
        });
      }
    </script>
  @endif
@endsection
