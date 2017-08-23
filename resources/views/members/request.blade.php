@extends('layouts.template')

@section('title', 'New Member')

@section('member_menu', 'class="treeview active"')

@section('member_add', 'class="active"')

@section('content')
<section class="content-header">
  <h1>ACCEPT NEW MEMBER</h1>
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
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Member ID</th>
                <th>Name</th>
                <th>E-mail</th>
                <th>Phone Number</th>
                <th style="width:15%">Register At</th>
                <th style="width:5%;"></th>
                <th style="width:5%;"></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($members as $member)
                <tr>
                  <td>{{ $member->id }}</td>
                  <td>{{ $member->customer->firstname }} {{ $member->customer->lastname }}</td>
                  <td>{{ $member->customer->email }}</td>
                  <td>{{ $member->customer->phone_number }}</td>
                  <td>{{ $member->created_at->format('j F Y g:i A') }}</td>
                  <td>
                    <a class="btn btn-success btn-sm" onclick="accept({{ $member->id }})"><i class="fa fa-check fa-lg"></i> Accept</a>
                  </td>
                  <td>
                    <a class="btn btn-danger btn-sm" onclick="deleteRequest({{ $member->id }})"><i class="fa fa-trash-o fa-lg"></i> Delete</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- end content -->
        <div style="border-style:none;" class="box-footer" >
        </div>
      </div>
      <!-- end box -->
    </div>
  </div>
</section>
@endsection

@section('js')
  <script>
    function accept(id) {
      $.post("{{ url('member')}}/" + id + "/accept", function(result) {
        if (!result.localeCompare('guest')) {
          window.location.assign("{{ url('login') }}");
        } else {
          window.location.reload();
        }
      });
    }

    function deleteRequest(id) {
      $.post("{{ url('member')}}/" + id + "/delete", function(result) {
        if (!result.localeCompare('guest')) {
          window.location.assign("{{ url('login') }}");
        } else {
          window.location.reload();
        }
      });
    }
  </script>
@endsection
