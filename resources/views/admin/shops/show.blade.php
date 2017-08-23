@extends('admin.layouts.template')

@section('title', 'Admin | Shops')

@section('shops', 'class="active"')

@section('content')
<section class="content-header">
	<h1>{{ $shop->name }}</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-4">

			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Shop Information @if( $shop->is_branch ) (branch) @endif</h3>
				</div>
				<div class="box-body no-padding">

          @if (!is_null($shop->image))
            <br>
            <img class="profile-user-img img-responsive" src="{{ asset("images/shops/".$shop->image) }}"/>
            <br>
          @endif

					<table class="table">
						<tr>
							<td><b>Shop ID</b></td>
							<td>{{ $shop->id }}</td>
						</tr>
						<tr>
							<td><b>Username</b></td>
							<td>{{ $shop->username }}</td>
						</tr>
						<tr>
							<td><b>Shop Name</b></td>
							<td>{{ $shop->name }}</td>
						</tr>
						<tr>
							<td><b>Owner</b></td>
							<td>{{ $shop->owner }}</td>
						</tr>
						<tr>
							<td><b>E-mail</b></td>
							<td>{{ $shop->email }}</td>
						</tr>
						<tr>
							<td><b>Discount for member</b></td>
							<td>{{ $shop->discount }}</td>
						</tr>
            <tr>
              <td><b>Start Points</b></td>
              <td>{{ $shop->start_point }}</td>
            </tr>
            <tr>
              <td><b>Point Condition</b></td>
              <td>Get {{ $shop->point_get }} points, every {{ $shop->point_condition }} bath.</td>
            </tr>
            <tr>
              <td><b>Last Updated</b></td>
              <td>{{ $shop->updated_at->format('j F Y g:i A') }}</td>
            </tr>
            <tr>
              <td><b>Created At</b></td>
              <td>{{ $shop->created_at->format('j F Y g:i A') }}</td>
            </tr>
            <tr>
              <td style="word-break: break-all; text-align: center;" colspan="2">{{ $shop->detail }}</td>
            </tr>
					</table>

				</div>
			</div>

			@if( !$shop->is_branch )
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Branches of shop</h3>
        </div>
        <div class="box-body no-padding">
          <table class="table">
            <tr>
              <th>Branch ID</th>
              <th>Username</th>
              <th>Branch Name</th>
            </tr>
            @foreach($branches as $branch)
            <tr>
              <td>{{ $branch->sub_id }}</td>
              <td>{{ $branch->shop->username }}</td>
              <td>{{ $branch->name }}</td>
            </tr>
            @endforeach
          </table>
        </div>
      </div>
			@endif

		</div>

		<div class="col-md-8">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Members of shop</h3>
				</div>
				<div class="box-body no-padding">
					<table class="table">
						<tr>
							<th>Member ID</th>
							<th>Customer Name</th>
							<th>Point</th>
							<th>Register At</th>
						</tr>
            @foreach($members as $member)
            <tr>
              <td>{{ $member->id }}</td>
              <td>{{ $member->customer->firstname }} {{ $member->customer->lastname }}</td>
              <td>{{ $member->point }}</td>
              <td>{{ $member->created_at->format('j F Y g:i A') }}</td>
            </tr>
            @endforeach
					</table>
				</div>
			</div>

      <div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Products of shop</h3>
				</div>
				<div class="box-body no-padding">
					<table class="table">
						<tr>
              <th>ID</th>
							<th>Barcode</th>
							<th>Name</th>
              <th>Price</th>
              <th>Point</th>
              <th>Has Promotion</th>
							<th>Created At</th>
						</tr>
            @foreach($products as $product)
              <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->barcode }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->point }}</td>
                @if($product->has_promotion)
                <td>Yes</td>
                @else
                <td>No</td>
                @endif
                <td>{{ $product->created_at->format('j F Y g:i A') }}</td>
              </tr>
            @endforeach
					</table>
				</div>
			</div>

      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Rewards of shop</h3>
        </div>
        <div class="box-body no-padding">
          <table class="table">
            <tr>
              <th>ID</th>
              <th>Barcode</th>
              <th>Name</th>
              <th>Point Use</th>
              <th>Created At</th>
            </tr>
            @foreach($rewards as $reward)
            <tr>
              <td>{{ $reward->id }}</td>
              <td>{{ $reward->barcode }}</td>
              <td>{{ $reward->name }}</td>
              <td>{{ $reward->point_use }}</td>
              <td>{{ $reward->created_at->format('j F Y g:i A') }}</td>
            </tr>
            @endforeach
          </table>
        </div>
      </div>

		</div>

	</div>
</section>
@endsection
