@if( strcmp($reward->image, 'no_image.png') )
<img class="img-responsive displayed" src="{{ asset("images/rewards/$reward->image") }}" >
@endif
<br>

<div class="row">
  <div class="col-sm-12">
    <table class="table table-bordered">
      <tbody>
        <tr>
          <td style="text-align: center;"><h4><b>Barcode</b></h4></td>
          <td style="text-align: center;"><h4>{{ $reward->barcode }}</h4></td>
        </tr>
        <tr>
          <td style="text-align: center;"><h4><b>Name</b></h4></td>
          <td style="text-align: center;"><h4>{{ $reward->name }}</h4></td>
        </tr>
        <tr>
          <td style="text-align: center;"><h4><b>Use Point</b></h4></td>
          <td style="text-align: center;"><h4>{{ $reward->point_use }}</h4></td>
        </tr>
        <tr>
          <td style="text-align: center;"><h4><b>Last Updated</b></h4></td>
          <td style="text-align: center;"><h4>{{ $reward->updated_at->format('j F Y g:i A') }}</h4></td>
        </tr>
        <tr>
          <td style="text-align: center;"><h4><b>Created At</b></h4></td>
          <td style="text-align: center;"><h4>{{ $reward->created_at->format('j F Y g:i A') }}</h4></td>
        </tr>
        <tr>
          <td style="word-break: break-all; text-align: center;" colspan="2"><h4>{{ ($reward->detail) }}</h4></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
