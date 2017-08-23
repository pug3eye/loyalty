@extends('layouts.template')

@section('title', 'Products List')

@section('product_menu', 'class="treeview active"')

@section('product_list', 'class="active"')

@section('css')
  <style>
    .displayed {
      displayed: block;
      margin-left: auto;
      margin-right: auto;
      max-height: 40%;
      max-width: 40%;
    }
  </style>
@endsection

@section('content')
<section class="content-header">
  <h1>PRODUCTS LIST</h1>
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
                <th>Barcode</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Point</th>
                <th>Last Updated</th>
                <th>Created At</th>
                <th style="width:5%; text-align:center;">View</th>
                <th style="width:5%; text-align:center;">Edit</th>
                <th style="width:5%; text-align:center;">Delete</th>
              </tr>
            </thead>
            <tbody>
              @if (count($products) > 0)
                @foreach ($products as $product)
                  <tr>
                    <td>{{ $product->barcode }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->point }}</td>
                    <td>{{ $product->updated_at->format('j F Y g:i A') }}</td>
                    <td>{{ $product->created_at->format('j F Y g:i A') }}</td>
                    <td style="text-align:center;"><span style="cursor:pointer;" class="glyphicon glyphicon-eye-open" onclick="showModal({{ $product->id }}, '{{ $product->name }}')"></span></td>

                    @if(!App\CheckBranch::isBranch())
                    <td style="text-align:center;"><a href="{{ url('/product/'.$product->id.'/edit') }}"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    @else
                    <td style="text-align:center;"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    @endif

                    @if(!App\CheckBranch::isBranch())
                    <td style="text-align:center;"><span class="glyphicon glyphicon-trash" style="color:red; cursor:pointer;" onclick="deleteConfirm({{ $product->id }}, '{{ $product->name }}')"></span></td>
                    @else
                    <td style="text-align:center;"><span class="glyphicon glyphicon-trash" style="color:red;"></span></td>
                    @endif

                  </tr>
                @endforeach
              @endif
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

  <!-- modal for show data -->
  <div class="modal fade" id="view_modal" tabindex="-1" role="dialog" aria-labelledby="view_modal_label">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <!-- head of modal -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title product_name" id="view_modal_label">Product Name</h3>
        </div>
        <!-- end head -->
        <!-- content inside here -->
        <div class="modal-body show_product">
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
    // sweet alert confirm when delete icon is click.
    function deleteConfirm(id, name) {
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
        $.post("{{ url('product') }}/" + id, function(result){
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


  <script>
    // show modal when click view icon.
    function showModal(id, name) {
      $.get("{{ url('product') }}/" + id, function(result){
        $( ".show_product" ).html(result);
        $( ".product_name").html(name);
        $('#view_modal').modal('show');
      });
    }
  </script>

  @if (Session::has('flash_message'))
  <script>
  $(document).ready(function() {
    swal({
      title: "Success !",
      text: "Edit product complete.",
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
