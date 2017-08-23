@extends('layouts.template')

@section('title', 'POS')

@section('sale', 'class="active"')

@section('css')
  <link href="{{ asset ("/bower_components/jquery-ui/jquery-ui.min.css") }}" rel="stylesheet" type="text/css" />
  <style>

    .center {
      text-align: center;
    }

    .promotion {
      color: orange;
    }

    .delete {
      color: red;
      cursor: pointer;
    }

  </style>
@endsection

@section('content')
<section class="content-header">
  <h1>POINT OF SALE</h1>
</section>
<section class="content">
  <!-- first row -->
  <div class="row">
    <!-- sale product box -->
    <div class="col-sm-12 col-lg-8">
      <!-- box product -->
      <div class="box">
        <div class="box-header">
        </div>
        <!-- content inside here -->
        <div class="box-body">

          <!-- product search -->
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></span>
              <input class="form-control" type="text" name="search_product" id="search_product" placeholder="Enter product bardcode or name...">
              <span class="input-group-btn">
                <input type="submit" class="btn btn-primary" onclick="search()" value="VIEW ALL PRODUCTS">
              </span>
            </div>
          </div>
          <!-- end product search -->

          <br>

          <table class="table table-stripe table-hover" id="sale_products">
            <!-- table head -->
            <thead>
              <tr>
                <th style="width:4%;"></th>
                <th style="width:12%; text-align:center;">Barcode</th>
                <th style="width:30%;">Product Name</th>
                <th style="width:10%; text-align:center;">Price</th>
                <th style="width:10%; text-align:center;">Point</th>
                <th style="width:10%; text-align:center;">Qty.</th>
                <th style="width:12%; text-align:center;">Total Price</th>
                <th style="width:12%; text-align:center;">Total Point</th>
              </tr>
            </thead>
            <!-- end table head -->
            <!-- table body -->
            <tbody>

              @foreach ($saleProductsArray as $saleProduct)
                <tr id="sale-product-{{ $saleProduct->getProductBarcode() }}">
                  <td class="center">
                    <span class="glyphicon glyphicon-trash delete" onclick="deleteProduct('{{ $saleProduct->getProductBarcode() }}')"></span>
                  </td>
                  <td class="center">{{ $saleProduct->getProductBarcode() }}</td>
                  <td>{{ $saleProduct->getName() }}</td>
                  <td class="center{{ $saleProduct->getHasPromotionPrice() ? ' promotion' : ''}}">{{ $saleProduct->getPrice() }}</td>
                  <td class="center{{ $saleProduct->getHasPromotionPoint() ? ' promotion' : ''}}">{{ $saleProduct->getPoint() }}</td>
                  <td class="center"><input style="text-align:center" id="qty-{{ $saleProduct->getProductBarcode() }}" size="4" value="{{ $saleProduct->getQuantity() }}" onkeypress="handleKeypress(event)"></td>
                  <td class="center{{ $saleProduct->getHasPromotionPrice() ? ' promotion' : ''}}" id="total-price-{{ $saleProduct->getProductBarcode() }}">{{ number_format((float)$saleProduct->getPrice()*$saleProduct->getQuantity(), 2, '.', '') }}</td>
                  <td class="center{{ $saleProduct->getHasPromotionPoint() ? ' promotion' : ''}}" id="total-point-{{ $saleProduct->getProductBarcode() }}">{{ $saleProduct->getPoint()*$saleProduct->getQuantity() }}</td>
                </tr>
              @endforeach
            </tbody>
            <!-- end table body -->
          </table>


          @if (sizeof($saleProductsArray) == 0)
            <h3 id="no_product" class="text-center">There are no products in the cart.</h3>
          @endif


        </div>
        <!-- end box body -->
        <div style="background-color: #D9EDF7;" class="box-footer" >
          <div class="col-sm-4 text-center">
            @if(!is_null(Auth::user()->discount))
            <h4 id="discount">Discount : {{ isset($member) ? Auth::user()->discount.'%' : '0%'}}</h4>
            @else
            <h4 id="discount">Discount : 0%</h4>
            @endif
          </div>
          <div class="col-sm-4 text-center">
            <h4 id="all-price">Total : {{ $summary['total'] }}$</h4>
          </div>
          <div class="col-sm-4 text-center">
            <h4 id="all-point">Total Points : {{ $summary['get_point'] }}</h4>
          </div>
        </div>
      </div>
      <!-- end box -->
    </div>
    <!-- end sale product box -->

    <!-- member side box -->
    <div class="col-sm-12 col-lg-4">
      <!-- box member -->
      <div class="box">
        <div class="box-header">
        </div>
        <!-- content inside here -->
        <div class="box-body">
          <!-- member search -->
          <div class="form-group">
            <div class="input-group">
              <input class="form-control" type="text" name="search_member" id="search_member" placeholder="Search member...">
              <span class="input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></span>
            </div>
          </div>
          <!-- end member search -->
        </div>
        <!-- end box body -->
        <div style="border-style:none;" class="box-footer" >
        </div>
      </div>
      <!-- end box -->
      <div class="box">
        <div class="box-header">
        </div>
        <div class="box-body text-center" id ="member_section">
          @if(isset($member))
            <h3 id="member_name">{{ $detail->firstname.' '.$detail->lastname }}</h3>
            <h4 id="member_point">Point : {{ $member->point }}</h4>
            <a id="delete_member" class="btn btn-danger" onclick="removeMember()"><i class="fa fa-trash-o fa-lg"></i> Delete</a>
          @else
            <h3 id="member_name">No Member Select</h3>
            <h4 id="member_point"></h4>
          @endif
        </div>
        <div class="box-footer" style="border-style:none;">
        </div>
      </div>

      <div class="box">
        <div class="box-body text-center">
          <div class="col-xs-6 col-lg-6">
            <button class="btn btn-danger btn-block btn-lg" type="button" onclick="clear_sale()">Clear Sale</button>
          </div>
          <div class="col-xs-6 col-lg-6">
            <button class="btn btn-success btn-block btn-lg" type="button" onclick="complete_sale()">Complete Sale</button>
          </div>
        </div>
      </div>

    </div>
    <!-- end member side box -->
  </div>
  <!-- end first row -->

  <!-- modal for show data -->
  <div class="modal fade" id="view_modal" tabindex="-1" role="dialog" aria-labelledby="view_modal_label">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <!-- head of modal -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title product_name" id="view_modal_label">All Products list</h4>
        </div>
        <!-- end head -->
        <!-- content inside here -->
        <div class="modal-body product">
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
  <script src="{{ asset ("/bower_components/jquery-ui/jquery-ui.js") }}" type="text/javascript"></script>
  <script>

    // auto complete product function.
    $('#search_product').autocomplete({
      source: '{{ URL::current().'/product/search' }}',
      minLength: 2,
      select: function(event, ui) {
        var url = '{{ URL::current().'/product/'}}'+ ui.item.id;

        if ($('#no_product').length) {
          removeNoProduct();
        }

        $.get(url, function(result) {
          if (result.is_has) {
            // update data
            updateBySearch(result.barcode);
            updateSummary(result);

          } else {
            // insert new row
            console.log(result);
            insertRow(result);
            updateSummary(result);
          }
        });
        this.value = "";
        return false;
      }
    });

    // auto complete member function.
    $('#search_member').autocomplete({
      source: '{{ URL::current().'/member/search' }}',
      minLength: 2,
      select: function(event, ui) {
        var url = '{{ URL::current().'/member/'}}'+ ui.item.id;
        $.get(url, function(result) {
          console.log(result);
          updateMember(result);
        });
        this.value = "";
        return false;
      }
    });

    // check press key is enter or not.
    function handleKeypress(e) {
      // press enter
      if (e.keyCode == 13) {
        var target_id = e.target.id;
        var barcode = target_id.split("-")[1];
        calculateAndUpdate(barcode);
      }
    }

    // check is number function.
    function checkNumber (qty) {
      return /^\d+$/.test(qty);
    }

    // calculate price, point, total price, tatal point and update.
    function calculateAndUpdate(barcode) {

      // get quantity id and value.
      var qty_id = "qty-"+barcode;
      var qty = document.getElementById(qty_id).value;

      // check quantity is number or not.
      if (checkNumber(qty)) {

        var url = '{{ URL::current() }}/product/' + barcode + '/update';

        $.post(url, {quantity: qty}, function(result) {

          var row_id = "sale-product-"+barcode;
          // get cells of row with row_id.
          var row = document.getElementById(row_id);
          var cells = row.getElementsByTagName("td");

          // update data in table.
          // 6 as total price, 7 as total point.
          cells[6].innerHTML = result.total_price.toFixed(2);
          cells[7].innerHTML = result.total_point;

          updateSummary(result);

        });

      }
    }

    // insert row to table.
    function insertRow(data) {
      $('#sale_products tbody').append(
        '<tr id="sale-product-'+ data.barcode + '">' +
        '<td class="center"><span class="glyphicon glyphicon-trash delete" onclick="deleteProduct(\''+data.barcode+'\')"></span></td>' +
        '<td class="center">' + data.barcode + '</td>' +
        '<td>' + data.name + '</td>' +
        '<td class="center" id="price-' + data.barcode + '">' + data.price + '</td>' +
        '<td class="center" id="point-' + data.barcode + '">' + data.point + '</td>' +
        '<td class="center"><input style="text-align:center" id="qty-' + data.barcode + '" type="text" size="4" value="1" onkeypress="handleKeypress(event)"></td>' +
        '<td class="center" id="total-price-' + data.barcode + '">' + data.price + '</td>' +
        '<td class="center" id="total-point-' + data.barcode + '">' + data.point + '</td>' +
        '</tr>'
      );
      if (data.has_promotion_price) {
        var price_div_id = '#price-' + data.barcode;
        var total_price_div_id = '#total-price-' + data.barcode;
        $(price_div_id).addClass('promotion');
        $(total_price_div_id).addClass('promotion');
      }
      if (data.has_promotion_point) {
        var point_div_id = '#point-' + data.barcode;
        var total_point_div_id = '#total-point-' + data.barcode;
        $(point_div_id).addClass('promotion');
        $(total_point_div_id).addClass('promotion');
      }
    }

    // update quantity and other by search click product that already have.
    function updateBySearch(barcode) {
      // get quantity id and value.
      var qty_id = "qty-"+barcode;
      var qty_value = document.getElementById(qty_id).value;
      var new_qty = parseInt(qty_value) + 1;

      var row_id = "sale-product-"+barcode;

      // get cells of row with row_id.
      var row = document.getElementById(row_id);
      var cells = row.getElementsByTagName("td");

      // get value that need for calculate.
      // 3 as price, 4 as point.
      var price = cells[3].innerText;
      var point = cells[4].innerText;

      // calculate new total price and point.
      var new_total_price = (price*new_qty).toFixed(2);
      var new_total_point = point*new_qty;

      // update data in table.
      // 6 as total price, 7 as total point.
      cells[6].innerHTML = new_total_price;
      cells[7].innerHTML = new_total_point;

      document.getElementById(qty_id).value = new_qty;

    }

    function deleteProduct(barcode) {
      var url = '{{ URL::current() }}/product/' + barcode + '/delete';
      $.get(url, function(result) {
        deleteRow(barcode);
        updateSummary(result);
      });
    }

    function updateSummary(result) {
      $('#all-price').text('Total : ' + result.total + '$');
      $('#all-point').text('Total Points : ' + result.get_point);
    }

    // delete row from table.
    function deleteRow(barcode) {
      var row_id = "sale-product-"+barcode;
      var row = document.getElementById(row_id);
      row.parentNode.removeChild(row);
    }

    function removeNoProduct() {
      $('#no_product').remove();
    }

    function clear_sale() {
      swal({
        title: "Are you sure ?",
        text: "All products in cart will be clear",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Clear it !",
        closeOnConfirm: false
      }, function() {
        swal("Clear Sale Complete", "Wait for refresh a few second", "success");
        var url = "{{ url('sale/clear') }}";
        $.get(url, function(result) {
          console.log(result);
          if(!result.localeCompare('success'));
          window.location.reload();
        });
      });
    }

    function complete_sale() {
      swal({
        title: "Total Cash",
        text: "Enter Cash : ",
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        animation: "slide-from-top",
        inputPlaceholder: "Cash"
      }, function(inputValue){
        if (inputValue === false) return false;
        if (inputValue === "") {
          swal.showInputError("You need to insert cash !");
          return false;
        }
        var url = '{{ url::current() }}';
        $.post(url, { cash: inputValue }, function(result) {
          if(!result.localeCompare('error')) {
            swal({
              title: "Error",
              text: "Cash is less than total price.",
              type: "error",
              confirmButtonText: "Close",
            });
          } else {
            swal({
              title: "Summary",
              text: result,
              html: true,
              confirmButtonText: "Complete Sale"
            }, function() {
              window.location.reload();
            });
          }
        });
      });
    }

    function updateMember(result) {
      $('#member_name').text(result.name);
      $('#member_point').text('Point : ' + result.point);
      if (!$('#delete_member').length) {
        $('#member_section').append('<a id="delete_member" class="btn btn-danger" onclick="removeMember()"><i class="fa fa-trash-o fa-lg"></i> Delete</a>');
      }
      @if(!is_null(Auth::user()->discount))
      $('#discount').text('Discount : ' + {{ Auth::user()->discount }} + '%');
      @endif
      updateSummary(result);
    }

    function removeMember() {
      var url = '{{ URL::current() }}/member';
      $.get(url, function(result) {
        $('#member_name').text('No Member Select');
        $('#member_point').text('');
        $('#discount').text('Discount : 0%');
        $('#delete_member').remove();
        updateSummary(result);
      });
    }

    function search() {
      $.get("{{ url('sale/product/all') }}", function(result) {
        $(".product").html(result);
        $('#view_modal').modal('show');
      });
    }

  </script>
@endsection
