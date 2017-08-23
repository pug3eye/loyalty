@extends('layouts.template')

@section('title', 'Rewards List')

@section('reward_menu', 'class="treeview active"')

@section('reward_history', 'class="active"')

@section('css')
  <style>
    .displayed {
      displayed: block;
      margin-left: auto;
      margin-right: auto;
      max-height: 75%;
      max-width: 75%;
    }
  </style>
@endsection

@section('content')
<section class="content-header">
  <h1>REDEEM REWARDS HISTORIES</h1>
</section>
<section class="content">
  <div class="row">
    <div class="col-sm-12">
      <!-- start box -->
      <div class="box">

        <!-- content inside here -->
        <div class="box-body no-padding">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Member ID</th>
                <th>Name</th>
                <th>Redeemed Reward</th>
                <th>Time</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($histories as $history)
                <tr>
                  <td>{{ $history->member_id }}</td>
                  <td>{{ $history->firstname }} {{ $history->lastname }}</td>
                  <td>{{ $history->name }}</td>
                  <td>{{ Carbon\Carbon::parse($history->created_at)->format('j F Y g:i A') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- end box body -->

      </div>
      <!-- end box -->
    </div>
  </div>
</section>
@endsection
