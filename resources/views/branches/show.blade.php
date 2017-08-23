@if( !is_null($shop->image) )
<img class="img-responsive displayed" src="{{ asset("images/shops/$shop->image") }}" >
@endif
<br>

<div class="row">
  <div class="col-sm-12">
    <table class="table table-bordered">
      <tbody>
        <tr>
          <td style="text-align: center;"><h4><b>Username</b></h4></td>
          <td style="text-align: center;"><h4>{{ $shop->username }}</h4></td>
        </tr>
        <tr>
          <td style="text-align: center;"><h4><b>Branch E-mail</b></h4></td>
          <td style="text-align: center;"><h4>{{ $shop->email }}</h4></td>
        </tr>

        @if( !is_null($shop->address) )
          <tr>
            <td style="text-align: center;"><h4><b>Branch E-mail</b></h4></td>
            <td style="text-align: center;"><h4>{{ $shop->email }}</h4></td>
          </tr>
        @endif

        @if( !is_null($shop->discount) )
          <tr>
            <td style="text-align: center;"><h4><b>Discount for member</b></h4></td>
            <td style="text-align: center;"><h4>{{ $shop->discount }}%</h4></td>
          </tr>
        @else
          <tr>
            <td style="text-align: center;"><h4><b>Discount for member</b></h4></td>
            <td style="text-align: center;"><h4>0%</h4></td>
          </tr>
        @endif

        @if( !is_null($shop->discount) )
          <tr>
            <td style="text-align: center;"><h4><b>Start points for new member</b></h4></td>
            <td style="text-align: center;"><h4>{{ $shop->start_point }}</h4></td>
          </tr>
        @else
          <tr>
            <td style="text-align: center;"><h4><b>Start points for new member</b></h4></td>
            <td style="text-align: center;"><h4>0</h4></td>
          </tr>
        @endif

        <tr>
          <td style="text-align: center;"><h4><b>Last Updated</b></h4></td>
          <td style="text-align: center;"><h4>{{ $shop->updated_at->format('j F Y g:i A') }}</h4></td>
        </tr>
        <tr>
          <td style="text-align: center;"><h4><b>Created At</b></h4></td>
          <td style="text-align: center;"><h4>{{ $shop->created_at->format('j F Y g:i A') }}</h4></td>
        </tr>

        @if(!is_null($shop->point_condition) && !is_null($shop->point_get))
          <tr>
            <td style="word-break: break-all; text-align: center;" colspan="2"><h4>{{ $shop->point_get }} Points Every {{ $shop->point_condition }} Bath</h4></td>
          </tr>
        @endif

        @if( strlen($shop->detail) > 0 )
        <tr>
          <td style="word-break: break-all; text-align: center;" colspan="2"><h4>{{ ($shop->detail) }}</h4></td>
        </tr>
        @endif

      </tbody>
    </table>
  </div>
</div>
