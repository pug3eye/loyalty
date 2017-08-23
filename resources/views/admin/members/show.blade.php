@extends('admin.layouts.template')

@section('title', 'Admin | Members')

@section('members', 'class="active"')

@section('content')
<section class="content-header">
  <h1 style="text-transform: uppercase;">{{ $member->customer->firstname.' '.$member->customer->lastname }}</h1>
</section>
<section class="content">

  <div class="row">
    <div class="col-sm-12 col-lg-7">
      <!-- start box -->
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Point History</h3>
        </div>
        <!-- content inside here -->
        <div class="box-body no-padding">

          <!-- data table -->
          <table class="table">
              <tr>
                <th style="text-align:center">Point</th>
                <th>Detail</th>
                <th>Time</th>
              </tr>

              @foreach ($pointHistories as $pointHistory)
                <tr>
                  <td style="text-align:center">
                    @if( $pointHistory->is_add )
                      +
                    @else
                      -
                    @endif
                    {{ $pointHistory->point }}
                  </td>
                  <td>{{ $pointHistory->detail }}</td>
                  <td>{{ Carbon\Carbon::parse($pointHistory->created_at)->format('j F Y g:i A') }}</td>
                </tr>
              @endforeach
          </table>
          <!-- end table -->
        </div>
        <!-- end box body -->
      </div>
      <!-- end box -->
    </div>

    <div class="col-sm-12 col-lg-5">
      <!-- start box -->
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Redeem History</h3>
        </div>
        <!-- content inside here -->
        <div class="box-body no-padding">

          <!-- data table -->
          <table class="table">
              <tr>
                <th>Redeem Reward</th>
                <th>Time</th>
              </tr>
              @foreach ($redeems as $redeem)
                <tr>
                  <td>{{ $redeem->reward->name }}</td>
                  <td>{{ Carbon\Carbon::parse($redeem->created_at)->format('j F Y g:i A') }}</td>
                </tr>
              @endforeach
          </table>
          <!-- end table -->
        </div>
        <!-- end box body -->
      </div>
      <!-- end box -->
    </div>
  </div>

</section>
@endsection
