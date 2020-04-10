@extends('layouts.app')

@section('content')
<div class="bg-primary-dark">
	<div class="content content-top">
		<div class="row push">
			<div class="col-md py-10 d-md-flex align-items-md-center text-center">
				<h1 class="text-white mb-0">
					<span class="font-w300">Detail ARRSES</span>
					<span id="clockbox" class="font-w400 font-size-lg text-white-op d-none d-md-inline-block"></span>
				</h1>
			</div>
  {{--   <div class="col-md py-10 d-md-flex align-items-md-center justify-content-md-end text-center">
        <button type="button" class="btn btn-alt-primary">
            <i class="fa fa-user-plus mr-5"></i> New Account
        </button>
    </div> --}}
</div>
</div>
</div>
<!-- END Header -->
<div class="bg-white">
	<!-- Breadcrumb -->
	<div class="content">
		<nav class="breadcrumb mb-0">
			<a class="breadcrumb-item" href="javascript:void(0)">Peramalan</a>
			<span class="breadcrumb-item active">Detail ARRSES</span>
		</nav>
	</div>

	<!-- Content -->
	<div class="content">
		<!-- Icon Navigation -->
		<!-- Dynamic Table Full Pagination -->
		<div class="block">
			<div class="row col-lg-5" style="margin-bottom:1em;font-family: sans-serif;font-weight: bold">
				<div class="col-lg-7">
					<span>Total Array Uji Beta</span>
				</div>
				<div class="col-lg-1">
					:
				</div>
				<div class="col-lg-4" style="text-align:left">
					<span>{{count($beta)}}</span>
				</div>
			</div>
			<div class="row col-lg-5" style="margin-bottom:1em;font-family: sans-serif;font-weight: bold">
				<div class="col-lg-7">
					<span>Nilai Beta / MAPE Terkecil</span>
				</div>
				<div class="col-lg-1">
					:
				</div>
				<div class="col-lg-4" style="text-align:left">
					<span>{{$beta[$bestBetaIndex]}} &nbsp / &nbsp{{round($MAPE[$bestBetaIndex],4)}} %</span>
				</div>
			</div>

	<div class="block-content block-content-full">
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-vcenter" style="text-align:center">
				<tr>
					<td>No</td>
					<td>Nilai Beta</td>
					<td>MAD (Mean Absolute Deviation)</td>
					<td>MAPE (Mean Absolute Percentage Error)</td>
				</tr>
				<tbody>
					@if(isset($beta) && !empty($beta))
					@foreach($beta as $key=>$val)
					@if($key==$bestBetaIndex)
					<tr style="background-color: yellow">
						<td>{{$key+1}}</td>
						<td>{{$val}}</td>
						<td>{{$MADTotal[$key]}}</td>
						<td>{{$MAPE[$key]}} %</td>
					</tr>
					@else
					<tr>
						<td>{{$key+1}}</td>
						<td>{{$val}}</td>
						<td>{{$MADTotal[$key]}}</td>
						<td>{{$MAPE[$key]}} %</td>
					</tr>
					@endif
					
					@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
</div>
@endsection