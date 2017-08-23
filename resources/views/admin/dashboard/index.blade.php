@extends('admin.layouts.template')

@section('title', 'Admin | Dashboard')

@section('dashboard', 'class="active"')

@section('content')
<section class="content-header">
	<h1>Dashboard <small>Version 1.0</small></h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-3">
			<div class="info-box">
				<span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>
				<div class="info-box-content">
					<span class="info-box-text">Customer Accounts</span>
		    	<span class="info-box-number">{{ $count['customers'] }}</span>
				</div>
			</div>
		</div>

		<div class="col-xs-12 col-sm-6 col-md-3">
			<div class="info-box">
				<span class="info-box-icon bg-blue"><i class="fa fa-home"></i></span>
				<div class="info-box-content">
					<span class="info-box-text">Shop Accounts</span>
		    	<span class="info-box-number">{{ $count['shops'] }}</span>
				</div>
			</div>
		</div>

		<div class="col-xs-12 col-sm-6 col-md-3">
			<div class="info-box">
				<span class="info-box-icon bg-yellow"><i class="fa fa-shopping-cart"></i></span>
				<div class="info-box-content">
					<span class="info-box-text">Products</span>
		    	<span class="info-box-number">{{ $count['products'] }}</span>
				</div>
			</div>
		</div>

		<div class="col-xs-12 col-sm-6 col-md-3">
			<div class="info-box">
				<span class="info-box-icon bg-green"><i class="fa fa-gift"></i></span>
				<div class="info-box-content">
					<span class="info-box-text">Rewards</span>
		    	<span class="info-box-number">{{ $count['rewards'] }}</span>
				</div>
			</div>
		</div>

	</div>
</section>

@endsection
