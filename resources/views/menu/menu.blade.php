@extends('layouts.app')

@section('content')
<div class="bg-primary-dark">
	<div class="content content-top">
		<div class="row push">
			<div class="col-md py-10 d-md-flex align-items-md-center text-center">
				<h1 class="text-white mb-0">
					<span class="font-w300">Menu</span>
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
<div class="bg-white">
	<!-- Breadcrumb -->
	<div class="content">
		<nav class="breadcrumb mb-0">
			<a class="breadcrumb-item" href="javascript:void(0)">Menu</a>
			<span class="breadcrumb-item active">Menu</span>
		</nav>
	</div>
	<!-- END Breadcrumb -->

	<!-- Content -->
	<div class="content">
	</div>
</div>
@endsection  


@push('scripts')
@endpush