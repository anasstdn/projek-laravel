@extends('layouts.app')

@section('content')
{{-- {{dd('aaaa')}} --}}
{{-- <div class="container"> --}}
  <style>
    .panel-heading h3 {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: normal;
    width: 75%;
    padding-top: 8px;
}

  .ajax-loader{
    position:fixed;
    top:0px;
    right:0px;
    width:100%;
    height:auto;
    background-color:#A9A9A9;
    background-repeat:no-repeat;
    background-position:center;
    z-index:10000000;
    opacity: 0.7;
    filter: alpha(opacity=40); /* For IE8 and earlier */
  }

  .ui-datepicker {
   background: #333;
   border: 1px solid #555;
   color: #EEE;
}
  </style>
  </style>
<div class="ajax-loader" style="display: none">
	<div class="col-md-12">
		<div class="progress progress-striped active">
			<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
				{{-- <span class="sr-only">40% Complete (success)</span> --}}
			</div>
		</div> 
		<div id="status" style="font-size:8pt;font-family: sans-serif;color: white">Loading...Please Wait</div>  
	</div>
</div>
<div class="bg-image" style="background-image: url('{{asset('codebase/')}}/src/assets/media/photos/photo8@2x.jpg');">
  <div class="content content-top">
    <div class="row push">
      <div class="col-md py-10 d-md-flex align-items-md-center text-center">
        <h1 class="text-white mb-0">
          <span class="font-w300">Barang</span>
        </h1>
      </div>
    </div>
  </div>
</div>
<div class="bg-white">
	<!-- Breadcrumb -->
	<div class="content">
		<nav class="breadcrumb mb-0">
			<a class="breadcrumb-item" href="javascript:void(0)">Alat</a>
			<span class="breadcrumb-item active">Barang</span>
			<span class="breadcrumb-item active">Barang</span>
		</nav>
	</div>

	<!-- Content -->
	<div class="content">
		<!-- Icon Navigation -->
		<!-- Dynamic Table Full Pagination -->
		<div class="block">
				<div class="row col-lg-12" style="margin-bottom:1em;font-family: sans-serif;">
					<div class="col-lg-1">
						<span>Page by :</span>
					</div>
					<div class="col-lg-1">
						<select class="form-control form-control-sm" id="per_page">
							<option value="1">1</option>
							<option value="5">5</option>
							<option value="10" selected>10</option>
							<option value="20">20</option>
							<option value="50">50</option>
							<option value="100">100</option>
						</select>
					</div>
					<div class="col-lg-1">
						<span>Sort by :</span>
					</div>
					<div class="col-lg-3">
						<select class="form-control form-control-sm" id="sort">
							<option value="date_desc" selected>date (Latest First)</option>
							<option value="date_asc">date (Oldest First)</option>
						</select>
					</div>
					<div class="col-lg-1">
						<span>Search :</span>
					</div>
					<div class="col-lg-3">
						<input type="text" class="form-control form-control-sm" id="search">
					</div>
					<div class="col-md-2 text-right">
							<a class="btn btn-sm btn-primary data-modal pull-left" style="color: white" id="data-modal" href="#" onclick="show_modal('{{ route('barang.create') }}')" ><i class='si si-plus' style="color: white" aria-hidden='true'></i> Tambah Data</a>
					</div>
				</div>
			<div class="block-content block-content-full">
				<!-- DataTables functionality is initialized with .js-dataTable-full-pagination class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
				{{-- <table class="table table-bordered table-striped table-vcenter" id="table-1">
					<thead>
						<tr>
							<th>No</th>
							<th>Description</th>
							<th>User</th>
							<th>Properties</th>
							<th>Time</th>
						</tr>
					</thead>
					<tbody id="activity_log">
					</tbody>
				</table> --}}
				<div id="table_data">
					@include('barang.index-data')
				</div>
			</div>
		</div>
		<!-- END Dynamic Table Full Pagination -->

	</div>
	<!-- END Content -->
</div>

 <div class="modal fade" id="formModal" aria-hidden="true" aria-labelledby="modal-normal" role="dialog" tabindex="-1">
<!-- END Page Content -->
@endsection
@push('js')
<script type="text/javascript">
	var formData = new FormData();
	$(document).ready(function(){
		$('.datepicker').datepicker({
    // placement: 'button',
    format: "dd-mm-yyyy",
    align: 'left',
    autoclose: true,
})



		$(document).on('click', '.pagination a', function(event){
			event.preventDefault(); 
			var page = $(this).attr('href').split('page=')[1];
			fetch_data(page);
		});
	

		$(document).on('change','#per_page',function(event){
			event.preventDefault();
			if($('.pagination a').length==0)
			{
				var page=1;
				fetch_data(page);
			} 
			else
			{
				var page = 1;
				fetch_data(page);
			}
		})

		$(document).on('change','#sort',function(event){
			event.preventDefault();
			if($('.pagination a').length==0)
			{
				var page=1;
				fetch_data(page);
			} 
			else
			{
				var page = 1;
				fetch_data(page);
			}
		})

		$(document).on('keyup change','#search',function(event){
			event.preventDefault();
			if($('.pagination a').length==0)
			{
				var page=1;
				fetch_data(page);
			} 
			else
			{
				var page = 1;
				fetch_data(page);
			}
		})
	})

function fetch_data(page)
{
	var data_ajax={ 'per_page':$('#per_page').val(),'sort':$('#sort').val(),'search':$('#search').val() };
	$('.ajax-loader').fadeIn();
    $("#status").html("Loading...Please Wait!");
	$.ajax({
		url:"{{url('barang/get-data')}}?page="+page,
		data:data_ajax,
		headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
		xhr: function () {
		var xhr = new window.XMLHttpRequest();
		xhr.upload.addEventListener("progress",
			uploadProgressHandler,
			false
			);
		xhr.addEventListener("load", loadHandler, false);
		xhr.addEventListener("error", errorHandler, false);
		xhr.addEventListener("abort", abortHandler, false);

		return xhr;
	},
		success:function(data)
		{
			$('#table_data').html(data);
		}
	});
}


function uploadProgressHandler(event) {
    // $("#loaded_n_total").html("Uploaded " + event.loaded + " bytes of " + event.total);
    var percent = (event.loaded / event.total) * 100;
    var progress = Math.round(percent);
    $("#percent").html(progress + "%");
    $(".progress-bar").css("width", progress + "%");
    $("#status").html(progress + "% uploaded... please wait");
}

function loadHandler(event) {
	$("#status").html('Load Completed');
	setTimeout(function(){
		$('.ajax-loader').fadeOut()
		$("#percent").html("0%");
		$(".progress-bar").css("width", "100%");
	}, 500);
}

function errorHandler(event) {
	$("#status").html("Send Data Failed");
}

function abortHandler(event) {
	$("#status").html("Send Data Aborted");
}
</script>
@endpush
