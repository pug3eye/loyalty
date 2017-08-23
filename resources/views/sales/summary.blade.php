@if(isset($member))
  <h2>Member : {{$detail->firstname.' '.$detail->lastname}}<h2>
@endif
<h3>Total : {{ $summary['total'] }}$ &nbsp; Points : {{ $summary['get_point'] }}</h3>
<h3>Cash : {{ $cash }}$ &nbsp; Change : {{ $cash-$summary['total'] }}$</h3>
