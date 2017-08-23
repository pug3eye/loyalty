@if( !is_null($product->image) )
<img class="img-responsive displayed" src="{{ asset("images/products/$product->image") }}" >
@endif
<br>

<div class="row">
  <div class="col-sm-12">
    <table class="table table-bordered">
      <tbody>
        <tr>
          <td style="text-align: center;"><h4><b>Barcode</b></h4></td>
          <td style="text-align: center;"><h4>{{ $product->barcode }}</h4></td>
        </tr>
        <tr>
          <td style="text-align: center;"><h4><b>Name</b></h4></td>
          <td style="text-align: center;"><h4>{{ $product->name }}</h4></td>
        </tr>
        <tr>
          <td style="text-align: center;"><h4><b>Price</b></h4></td>
          <td style="text-align: center;"><h4>{{ $product->price }}</h4></td>
        </tr>
        <tr>
          <td style="text-align: center;"><h4><b>Point</b></h4></td>
          <td style="text-align: center;"><h4>{{ $product->point }}</h4></td>
        </tr>
        @if( $product->has_promotion )
          <tr>
            <td style="text-align: center;"><h4><b>Has Promotion</b></h4></td>
            <td style="text-align: center;"><h4>Yes</h4></td>
          </tr>
          @if ( !is_null($product->promotion_price) )
          <tr>
            <td style="text-align: center;"><h4><b>Promotion Price</b></h4></td>
            <td style="text-align: center;"><h4>{{ $product->promotion_price }}</h4></td>
          </tr>
          @endif
          @if ( !is_null($product->promotion_point) )
          <tr>
            <td style="text-align: center;"><h4><b>Promotion Point</b></h4></td>
            <td style="text-align: center;"><h4>{{ $product->promotion_point }}</h4></td>
          </tr>
          @endif
          <tr>
            <td style="text-align: center;"><h4><b>Promotion Started</b></h4></td>
            <td style="text-align: center;"><h4>{{ $product->promotion_start }}<h4></td>
          </tr>
          <tr>
            <td style="text-align: center;"><h4><b>Promotion Expired</b></h4></td>
            <td style="text-align: center;"><h4>{{ $product->promotion_end }}</h4>
          </tr>
        @else
        <tr>
          <td style="text-align: center;"><h4><b>Has Promotion</b></h4></td>
          <td style="text-align: center;"><h4>No</h4></td>
        </tr>
        @endif
        <tr>
          <td style="text-align: center;"><h4><b>Last Updated</b></h4></td>
          <td style="text-align: center;"><h4>{{ $product->updated_at->format('j F Y g:i A') }}</h4></td>
        </tr>
        <tr>
          <td style="text-align: center;"><h4><b>Created At</b></h4></td>
          <td style="text-align: center;"><h4>{{ $product->created_at->format('j F Y g:i A') }}</h4></td>
        </tr>
        @if( strlen($product->detail) > 0 )
        <tr>
          <td style="word-break: break-all; text-align: center;" colspan="2"><h4>{{ ($product->detail) }}</h4></td>
        </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>

<br>
