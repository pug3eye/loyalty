@extends('admin.layouts.template')

@section('title', 'Admin | Customers')

@section('customers', 'class="active"')

@section('content')
<section class="content-header">
	<h1>{{ $customer->firstname }} {{ $customer->lastname }}</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-4">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Customer Detail</h3>
				</div>
				<div class="box-body no-padding">
					<table class="table">
						<tr>
							<td><b>Customer ID</b></td>
							<td>{{ $customer->id }}</td>
						</tr>
						<tr>
							<td><b>Unique ID</b></td>
							<td>{{ $customer->unique_id }}</td>
						</tr>
						<tr>
							<td><b>Username</b></td>
							<td>{{ $customer->username }}</td>
						</tr>
						<tr>
							<td><b>First Name</b></td>
							<td>{{ $customer->firstname }}</td>
						</tr>
						<tr>
							<td><b>Last Name</b></td>
							<td>{{ $customer->lastname }}</td>
						</tr>
						<tr>
							<td><b>E-mail</b></td>
							<td>{{ $customer->email }}</td>
						</tr>
						<tr>
							<td><b>Phone Number</b></td>
							<td>{{ $customer->phone_number }}</td>
						</tr>
						<tr>
							<td><b>Last Updated</b></td>
							<td>{{ $customer->updated_at->format('j F Y g:i A') }}</td>
						</tr>
						<tr>
							<td><b>Created At</b></td>
							<td>{{ $customer->created_at->format('j F Y g:i A') }}</td>
						</tr>

					</table>
				</div>
			</div>
		</div>

		<div class="col-md-8">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Members of customer</h3>
				</div>
				<div class="box-body no-padding">
					<table class="table">
						<tr>
							<th>Member ID</th>
							<th>Shop Name</th>
							<th>Point</th>
							<th>Register At</th>
						</tr>
						@foreach($members as $member)
						<tr>
							<td>{{ $member->id }}</td>
							<td>{{ $member->shop->name }}</td>
							<td>{{ $member->point }}</td>
							<td>{{ $member->created_at->format('j F Y g:i A') }}</td>
						</tr>
						@endforeach
					</table>
				</div>
			</div>
		</div>

	</div>
</section>
@endsection
