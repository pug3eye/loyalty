@extends('layouts.template')

@section('title', 'Add Product')

@section('css')
  <link href="{{ asset ("/bower_components/jquery-ui/jquery-ui.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('product_menu', 'class="treeview active"')

@section('product_add', 'class="active"')

@section('content')
<section class="content-header">
  <h1>ADD NEW PRODUCT</h1>
</section>
<section class="content">
  <div class="row">
    <div class="col-sm-12">
      <!-- start box.  -->
      <div class="box">
        <div class="box-header">
        </div>
        <!-- content inside here. -->
        <div class="box-body">

          <form class="form-horizontal" method="post" action="{{ url('/product/add') }}" id="form_add" enctype="multipart/form-data">

            <!-- start row product code -->
            <div class="row">
              <div class="form-group{{$errors->has('code') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Product Barcode</label>
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
            <!-- end row product code -->

            <!-- start row product name -->
            <div class="row">
              <div class="form-group{{$errors->has('name') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Product Name</label>
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
            <!-- end row product name -->

            <!-- start row product price -->
            <div class="row">
              <div class="form-group{{$errors->has('price') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Product Price</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1 col-lg-4 col-lg-offset-1">
                    <input type="text" class="form-control" name="price" value="{{ old('price') }}" required>
                  </div>
                  @if ($errors->has('price'))
                    <div class="col-sm-4 col-sm-offset-5 col-md-4 col-md-offset-5 col-lg-4 col-lg-offset-4">
                      <span class="help-block">{{ $errors->first('price') }}</span>
                    </div>
                  @endif
                </div>
              </div>
            </div>
            <!-- end row product price -->

            <!-- start row product point -->
            <div class="row">
              <div class="form-group{{$errors->has('point') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Product Point</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1 col-lg-4 col-lg-offset-1">
                    <input type="text" class="form-control" name="point" value="{{ old('point') }}" required>
                  </div>
                  @if ($errors->has('point'))
                    <div class="col-sm-4 col-sm-offset-5 col-md-4 col-md-offset-5 col-lg-4 col-lg-offset-4">
                      <span class="help-block">{{ $errors->first('point') }}</span>
                    </div>
                  @endif
                </div>
              </div>
            </div>
            <!-- end row product point -->

            <!-- start row radio promotion -->
            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Has Promotion</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1 col-lg-4 col-lg-offset-1">
                    <label class="radio-inline">
                      <input type="radio" name="has_promotion" id="has_promotion_yes" value="1" required> Yes
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="has_promotion" id="has_promotion_no" value="0" checked="checked" required> No
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <!-- end row promotion -->

            <!-- start row promotion price -->
            <div class="row">
              <div class="form-group{{$errors->has('promotion_price') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Promotion Price</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1 col-lg-4 col-lg-offset-1">
                    <input type="text" class="form-control" name="promotion_price" id="promotion_price" value="{{ old('promotion_price') }}" disabled>
                  </div>
                  @if ($errors->has('promotion_price'))
                    <div class="col-sm-4 col-sm-offset-5 col-md-4 col-md-offset-5 col-lg-4 col-lg-offset-4">
                      <span class="help-block">{{ $errors->first('promotion_price') }}</span>
                    </div>
                  @endif
                </div>
              </div>
            </div>
            <!-- end row promotion price -->

            <!-- start row promotion point -->
            <div class="row">
              <div class="form-group{{$errors->has('promotion_point') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Promotion Point</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1 col-lg-4 col-lg-offset-1">
                    <input type="text" class="form-control" name="promotion_point" id="promotion_point" value="{{ old('promotion_point') }}" disabled>
                  </div>
                  @if ($errors->has('promotion_point'))
                    <div class="col-sm-4 col-sm-offset-5 col-md-4 col-md-offset-5 col-lg-4 col-lg-offset-4">
                      <span class="help-block">{{ $errors->first('promotion_point') }}</span>
                    </div>
                  @endif
                </div>
              </div>
            </div>
            <!-- end row promotion point -->

            <!-- start row select start date -->
            <div class="row">
              <div class="form-group{{$errors->has('start_date') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Promotion Start Date</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1 col-lg-4 col-lg-offset-1">
                    <input type="text" class="form-control" name="start_date" id="datepicker_start" disabled>
                  </div>
                  @if ($errors->has('start_date'))
                    <div class="col-sm-4 col-sm-offset-5 col-md-4 col-md-offset-5 col-lg-4 col-lg-offset-4">
                      <span class="help-block">{{ $errors->first('start_date') }}</span>
                    </div>
                  @endif
                </div>
              </div>
            </div>
            <!-- end row select start date -->

            <!-- start row select start date -->
            <div class="row">
              <div class="form-group{{$errors->has('end_date') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Promotion End Date</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1 col-lg-4 col-lg-offset-1">
                    <input type="text" class="form-control" name="end_date" id="datepicker_end" disabled>
                  </div>
                  @if ($errors->has('end_date'))
                    <div class="col-sm-4 col-sm-offset-5 col-md-4 col-md-offset-5 col-lg-4 col-lg-offset-4">
                      <span class="help-block">{{ $errors->first('end_date') }}</span>
                    </div>
                  @endif
                </div>
              </div>
            </div>
            <!-- end row select start date -->

            <!-- start row product detail -->
            <div class="row">
              <div class="form-group{{$errors->has('detail') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Product Detail</label>
                  <div class="col-sm-6 col-sm-offset-1 col-md-7 col-md-offset-1 col-lg-5 col-lg-offset-1">
                    <textarea class="form-control" name="detail" rows="4" cols="50">{{ old('detail') }}</textarea>
                  </div>
                  @if ($errors->has('detail'))
                    <div class="col-sm-4 col-sm-offset-5 col-md-4 col-md-offset-5 col-lg-4 col-lg-offset-4">
                      <span class="help-block">{{ $errors->first('detail') }}</span>
                    </div>
                  @endif
                </div>
              </div>
            </div>
            <!-- end row product detail -->

            <!-- start row product image -->
            <div class="row">
              <div class="form-group{{$errors->has('image') ? ' has-error' : ''}}">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <label class="control-label col-sm-4 col-md-4 col-lg-3">Product Image</label>
                  <div class="col-sm-5 col-sm-offset-1 col-md-6 col-md-offset-1 col-lg-4 col-lg-offset-1">
                    <input style="padding-top:7px" type="file" name="image">
                  </div>
                </div>
              </div>
            </div>
            <!-- end row product image -->

            <br>

            <!-- Submit button -->
            <div class="row">
              <div class="form-group">
                <div class="col-sm-12 col-md-10 col-lg-8">
                  <div class="col-sm-2 col-sm-offset-5 col-md-2 col-md-offset-5 col-lg-2 col-lg-offset-4">
                    <input type="submit" class="btn btn-primary" value="Add Product">
                  </div>
                </div>
              </div>
            </div>

          </form>

        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('js')
  <script src="{{ asset ("/bower_components/jquery-ui/jquery-ui.js") }}" type="text/javascript"></script>
  <script>
    $(function() {

      $( "#datepicker_start" ).datepicker({
        dateFormat: "yy-mm-dd",
        minDate: 0,
        onClose: function(selectedDate) {
          if (selectedDate.length != 0) {
            $( "#datepicker_end" ).datepicker("option", "minDate", selectedDate);
          }
        }
      });

      $( "#datepicker_end" ).datepicker({
        dateFormat: "yy-mm-dd",
        minDate: 0,
        onClose: function(selectedDate) {
          $( "#datepicker_start" ).datepicker("option", "maxDate", selectedDate);
        }
      });

      $("#has_promotion_yes").click(function()
      {
        $("#datepicker_start").removeAttr("disabled");
        $("#datepicker_start").attr("required", "required");
        $( "#datepicker_start" ).datepicker("option", "minDate", 0);
        $( "#datepicker_start" ).datepicker("option", "maxDate", null);

        $("#datepicker_end").removeAttr("disabled");
        $("#datepicker_end").attr("required", "required");
        $( "#datepicker_end" ).datepicker("option", "minDate", 0);
        $( "#datepicker_end" ).datepicker("option", "maxDate", null);

        $("#promotion_price").removeAttr("disabled");
        $("#promotion_point").removeAttr("disabled");
      });

      $("#has_promotion_no").click(function()
      {
        $("#datepicker_start").attr("disabled", "disabled");
        $("#datepicker_start").removeAttr("required");
        $("#datepicker_start").val("");
        $("#datepicker_end").attr("disabled", "disabled");
        $("#datepicker_end").removeAttr("required");
        $("#datepicker_end").val("");
        $("#promotion_price").attr("disabled", "disabled");
        $("#promotion_price").val("");
        $("#promotion_point").attr("disabled", "disabled");
        $("#promotion_point").val("");
      });

    });
  </script>

  @if (Session::has('flash_message'))
  <script>
  $(document).ready(function() {
    swal({
      title: "Success !",
      text: "Add new product complete.",
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
      text: "This product barcode already use ! ",
      type: "error",
      confirmButtonText: "Close"
    });
  });
  </script>
  @endif
@endsection
