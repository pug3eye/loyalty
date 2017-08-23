@extends('layouts.template')

@section('title', 'Create Branch')

@section('branch_menu', 'class="treeview active"')

@section('branch_add', 'class="active"')

@section('content')
<section class="content-header">
  <h1>CREATE BRANCH</h1>
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
          <form class="form-horizontal" method="post" action="{{ url('/branch/add') }}" id="form_add">

            <!-- start row branch username. -->
            <div class="row">
              <div class="form-group{{$errors->has('username') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Branch Username</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1 col-lg-4 col-lg-offset-1">
                    <input type="text" class="form-control" name="username" value="{{ old('username') }}" required>
                  </div>
                  @if ($errors->has('username'))
                    <div class="col-sm-4 col-sm-offset-5 col-md-4 col-md-offset-5 col-lg-4 col-lg-offset-4">
                      <span class="help-block">{{ $errors->first('username') }}</span>
                    </div>
                  @endif
                </div>
              </div>
            </div>

            <!-- start row branch password. -->
            <div class="row">
              <div class="form-group{{$errors->has('password') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Branch Password</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1 col-lg-4 col-lg-offset-1">
                    <input type="password" class="form-control" name="password" required>
                  </div>
                  @if ($errors->has('password'))
                    <div class="col-sm-4 col-sm-offset-5 col-md-4 col-md-offset-5 col-lg-4 col-lg-offset-4">
                      <span class="help-block">{{ $errors->first('password') }}</span>
                    </div>
                  @endif
                </div>
              </div>
            </div>

            <!-- start row password confirmation. -->
            <div class="row">
              <div class="form-group{{$errors->has('password_confirmation') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Confirm Pasword</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1 col-lg-4 col-lg-offset-1">
                    <input type="password" class="form-control" name="password_confirmation" required>
                  </div>
                  @if ($errors->has('password_confirmation'))
                    <div class="col-sm-4 col-sm-offset-5 col-md-4 col-md-offset-5 col-lg-4 col-lg-offset-4">
                      <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                    </div>
                  @endif
                </div>
              </div>
            </div>

            <!-- start row branch name. -->
            <div class="row">
              <div class="form-group{{$errors->has('name') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Branch Name</label>
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

            <!-- start row branch email. -->
            <div class="row">
              <div class="form-group{{$errors->has('email') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Branch E-mail</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1 col-lg-4 col-lg-offset-1">
                    <input type="text" class="form-control" name="email" value="{{ old('email') }}" required>
                  </div>
                  @if ($errors->has('email'))
                    <div class="col-sm-4 col-sm-offset-5 col-md-4 col-md-offset-5 col-lg-4 col-lg-offset-4">
                      <span class="help-block">{{ $errors->first('email') }}</span>
                    </div>
                  @endif
                </div>
              </div>
            </div>

            <!-- start row branch username. -->
            <div class="row">
              <div class="form-group{{$errors->has('address') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Branch Address</label>
                  <div class="col-sm-6 col-sm-offset-1 col-md-7 col-md-offset-1 col-lg-5 col-lg-offset-1">
                    <input type="text" class="form-control" name="address" value="{{ old('address') }}" >
                  </div>
                  @if ($errors->has('address'))
                    <div class="col-sm-4 col-sm-offset-5 col-md-4 col-md-offset-5 col-lg-4 col-lg-offset-4">
                      <span class="help-block">{{ $errors->first('address') }}</span>
                    </div>
                  @endif
                </div>
              </div>
            </div>

            <!-- Submit button -->
            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <div class="col-sm-2 col-sm-offset-5 col-md-2 col-md-offset-5 col-lg-2 col-lg-offset-4">
                    <input type="submit" class="btn btn-primary" value="Create Branch">
                  </div>
                </div>
              </div>
            </div>

          </form>

        </div>

      </div>
      <!-- end box. -->
    </div>
  </div>
</section>
@endsection

@section('js')
  @if (Session::has('flash_message'))
  <script>
  $(document).ready(function() {
    swal({
      title: "Success !",
      text: "Add new branch complete.",
      type: "success",
      timer: 1500,
      showConfirmButton: false
    });
  });
  </script>
  @endif
@endsection
