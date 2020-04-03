@extends('layouts.app')

@section('content')
<div class="bg-primary-dark">
<div class="content content-top">
<div class="row push">
<div class="col-md py-10 d-md-flex align-items-md-center text-center">
<h1 class="text-white mb-0">
<span class="font-w300">Dashboard</span>
<span class="font-w400 font-size-lg text-white-op d-none d-md-inline-block">Welcome {{ Auth::user()->name }}</span>
<span id="clockbox" class="font-w400 font-size-lg text-white-op d-flex"></span>
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

<!-- Page Content -->
<div class="bg-white">
  <!-- Breadcrumb -->
  <div class="content">
    <nav class="breadcrumb mb-0">
      <a class="breadcrumb-item" href="javascript:void(0)">Home</a>
      <span class="breadcrumb-item active">Dashboard</span>
    </nav>
  </div>
  <!-- END Breadcrumb -->

  <!-- Content -->
  <div class="content">
    <!-- Icon Navigation -->
    <div class="row gutters-tiny push">
      <div class="col-6 col-md-4 col-xl-3">
        <a class="block block-rounded block-bordered block-link-shadow text-center" href="{{url('/')}}">
          <div class="block-content">
            <p class="mt-5">
              <i class="si si-home fa-3x text-muted"></i>
            </p>
            <p class="font-w600">Dashboard</p>
          </div>
        </a>
      </div>
      <div class="col-6 col-md-4 col-xl-3">
        <a class="block block-rounded block-bordered block-link-shadow ribbon ribbon-primary text-center" href="{{url('/penjualan')}}">
          <div class="block-content">
            <p class="mt-5">
              <i class="si si-basket fa-3x text-muted"></i>
            </p>
            <p class="font-w600">Sales</p>
          </div>
        </a>
      </div>
      <div class="col-6 col-md-4 col-xl-3">
        <a class="block block-rounded block-bordered block-link-shadow text-center" href="{{url('/penjualan/chart')}}">
          <div class="block-content">
            <p class="mt-5">
              <i class="si si-pie-chart fa-3x text-muted"></i>
            </p>
            <p class="font-w600">Chart</p>
          </div>
        </a>
      </div>
      <div class="col-6 col-md-4 col-xl-3">
        <a class="block block-rounded block-bordered block-link-shadow text-center" href="{{url('/peramalan')}}">
          <div class="block-content">
            <p class="mt-5">
              <i class="si si-graph fa-3x text-muted"></i>
            </p>
            <p class="font-w600">Forecasting</p>
          </div>
        </a>
      </div>
    </div>
    <!-- END Icon Navigation -->

    <!-- Mini Stats -->
    @if(\Auth::user()->can('read-card-admin') || \Auth::user()->can('read-card-manager'))
    <div class="row">
      <div class="col-md-6 col-xl-3">
        <a class="block block-rounded block-bordered" href="javascript:void(0)">
          <div class="block-content p-5">
            <div class="py-30 text-center bg-body-light rounded">
              <div class="font-size-h2 font-w700 mb-0 text-muted" id="total_transaksi">0</div>
              <div class="font-size-sm font-w600 text-uppercase">Total Penjualan</div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-6 col-xl-3">
        <a class="block block-rounded block-bordered" href="javascript:void(0)">
          <div class="block-content p-5">
            <div class="py-30 text-center bg-body-light rounded">
              <div class="font-size-h2 font-w700 mb-0 text-muted" id="total_transaksi_bulan_ini">0</div>
              <div class="font-size-sm font-w600 text-uppercase">Penjualan Bulan Ini</div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-6 col-xl-3">
        <a class="block block-rounded block-bordered" href="javascript:void(0)">
          <div class="block-content p-5">
            <div class="py-30 text-center bg-body-light rounded">
              <div class="font-size-h2 font-w700 mb-0 text-muted" id="total_transaksi_minggu_ini">0</div>
              <div class="font-size-sm font-w600 text-uppercase">Penjualan Minggu Ini</div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-6 col-xl-3">
        <a class="block block-rounded block-bordered" href="javascript:void(0)">
          <div class="block-content p-5">
            <div class="py-30 text-center bg-body-light rounded">
              <div class="font-size-h2 font-w700 mb-0 text-muted" id="total_transaksi_hari_ini">0</div>
              <div class="font-size-sm font-w600 text-uppercase">Penjualan Hari Ini</div>
            </div>
          </div>
        </a>
      </div>
    </div>
    @endif
    <!-- END Mini Stats -->

    <!-- Charts -->
    

   
    <!-- END More Data -->
  </div>
  <!-- END Content -->
</div>
<!-- END Page Content -->
@endsection

@push('js')
<script>
var status;
var admin="{{\Auth::user()->can('read-card-admin')}}";
var manager="{{\Auth::user()->can('read-card-manager')}}";

$(document).ready(function(){
  // $.ajax({
  //   url: '{{url('home/weather/')}}',
  //   type: 'GET',
  //   success:function(data){
  //     console.log(data);
  //   },
  //   error:function (xhr, status, error){
  //     toastr.warning(xhr.responseText,'');
  //   },

  // })

    if(admin==true)
    {
      status='admin';
    }
    else if(manager==true)
    {
      status='manager';
    }

    if(status){
           $.ajax({
            url: '{{url('home/card/')}}',
            type: 'GET',
            success:function(data){
               if(status=='admin')
               {
                    $('#total_transaksi').html(data.total_transaksi);
                    $('#total_transaksi_bulan_ini').html(data.total_transaksi_bulan_ini);
                    $('#total_transaksi_minggu_ini').html(data.total_transaksi_minggu_ini);
                    $('#total_transaksi_hari_ini').html(data.total_transaksi_hari_ini);
                    // $('#pasir_minggu_lalu').html(data.pasir_minggu_lalu);
                     updateList(status);
                }
                else if(status=='manager')
                {
                    $('#total_transaksi').html(data.total_transaksi);
                    $('#total_transaksi_bulan_ini').html(data.total_transaksi_bulan_ini);
                    $('#total_transaksi_minggu_ini').html(data.total_transaksi_minggu_ini);
                    $('#total_transaksi_hari_ini').html(data.total_transaksi_hari_ini);
                     updateList(status);
                }
            },
            error:function (xhr, status, error){
              toastr.warning(xhr.responseText,'');
          },

        })
    }
})

 function updateList(status) {
    $.ajax({
    url: '{{url('home/card/')}}',
    type: 'GET',
    success:function(data){

        // console.log(data);
      if(status=='admin')
      {
        // console.log(data);
        $('#total_transaksi').html(data.total_transaksi);
        $('#total_transaksi_bulan_ini').html(data.total_transaksi_bulan_ini);

        $('#total_transaksi_minggu_ini').html(data.total_transaksi_minggu_ini);
        $('#total_transaksi_hari_ini').html(data.total_transaksi_hari_ini);


        setTimeout(function(){updateList(status)}, 2000);
    }
    else if(status=='user')
    {
        $('#total_transaksi').html(data.total_transaksi);
        $('#total_transaksi_bulan_ini').html(data.total_transaksi_bulan_ini);

        $('#total_transaksi_minggu_ini').html(data.total_transaksi_minggu_ini);
        $('#total_transaksi_hari_ini').html(data.total_transaksi_hari_ini);

        setTimeout(function(){updateList(status)}, 2000);
    }

     },
     error:function (xhr, status, error){
      toastr.warning(xhr.responseText,'');
    },
  });
  }

</script>
@endpush