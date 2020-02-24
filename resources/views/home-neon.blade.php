@extends('layouts.app')

@section('content')
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<style>
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

.order-card {
    color: #fff;
}

.bg-c-blue {
    background: linear-gradient(45deg,#496e98,#4178b7);
}

.bg-c-blue-light {
    background: linear-gradient(45deg,#7b68ee,#9e93e1);
}

.bg-c-semigreen {
    background: linear-gradient(45deg,#09c7a1,#2ed0af);
}

.bg-c-yellow {
  background: linear-gradient(45deg,#ea9821,#f3a535);
}

.bg-c-green {
    background: linear-gradient(45deg,#4CAF50,#9df980);
    
}
.bg-c-pink {
    background: linear-gradient(45deg,#FF5370,#ff869a);
}

.bg-c-orange {
    background: linear-gradient(45deg,#ffa500,#ffcf78);
}

.bg-c-red {
    background: linear-gradient(45deg,#ff0000,#ff7878);
}

.bg-c-light {
    background: linear-gradient(45deg,#c2ffae,#e4ffdb);
}


.card {
    border-radius: 5px;
    -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    border: none;
    margin-bottom: 30px;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
    transition: all 0.3s cubic-bezier(.25,.8,.25,1);
}

.well {
    border-radius: 5px;
    -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    border: none;
    margin-bottom: 30px;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
    transition: all 0.3s cubic-bezier(.25,.8,.25,1);
}

.card:hover {
  box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
}

.well:hover {
  box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
}

.card .card-block {
    padding: 10px 10px 1px 10px;
}

.order-card i {
    font-size: 35px;
}

.f-left {
    float: left;
}

.f-right {
    float: right;
}
.chartdiv {
  width: 100%;
  height: 500px;
}
.m-b-20{
  font-size:10pt;
  font-weight:600;
  font-family: Arial,Helvetica,sans-serif;
}
.m-b-0{
  font-size:9pt;
  font-weight:500;
  font-family: Arial,Helvetica,sans-serif;
}

a.custom-card,
a.custom-card:hover {
  color: inherit;
  text-decoration:none;
}

</style>
{{-- <div class="container"> --}}
  {{--   <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-gradient" data-collapsed="0">
                <div class="panel-heading">
                        <div class="panel-title">Dashboard</div>
                        
                        <div class="panel-options">
                            <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                            <a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
                        </div>
                    </div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-sm-12">
            <a href="" class="custom-card">
                <div class="well bg-c-light">
                    <h4 style="color:#4caf50">Selamat Datang <strong>{{ Auth::user()->name }}</strong> <span id="clockbox" class="f-right" style="color:#4caf50;font-size:11pt;font-family: sans-serif;">
                    </span></h4>
                </div>
            </a>
        </div>
    </div>

    @if(\Auth::user()->can('read-card-admin') || \Auth::user()->can('read-card-manager'))
              <div class="row col-lg-12">
                <div class="col-md-3 col-md-3">
                  <a href="" class="custom-card">
                    <div class="card bg-c-red order-card">
                        <div class="card-block">
                            <h6 class="m-b-20" style="color:white">TOTAL TRANSAKSI</h6>
                            <h1 class="text-right"><i class="md-time f-left" style="color:white"></i><span style="color:white" id="total_transaksi">0</span></h1>
                            {{-- <p class="m-b-0">JUMLAH LEMBUR BELUM DIVERIFIKASI <span class="f-right" id="lembur_not_verif_total">0</span></p> --}}
                        </div>
                    </div>
                  </a>
                </div>
                <div class="col-md-3 col-md-3">
                  <a href="" class="custom-card">
                    <div class="card bg-c-yellow order-card">
                        <div class="card-block">
                            <h6 class="m-b-20" style="color:white">PENJUALAN BULAN INI</h6>
                            <h1 class="text-right"><i class="md-time f-left" style="color:white"></i><span style="color:white" id="total_transaksi_bulan_ini">0</span></h1>
                            {{-- <p class="m-b-0">JUMLAH LEMBUR BELUM DIVERIFIKASI <span class="f-right" id="lembur_not_verif_total">0</span></p> --}}
                        </div>
                    </div>
                  </a>
                </div>
                <div class="col-md-3 col-md-3">
                  <a href="" class="custom-card">
                    <div class="card bg-c-pink order-card">
                        <div class="card-block">
                            <h6 class="m-b-20" style="color:white">PENJUALAN PASIR MINGGU INI</h6>
                            <h1 class="text-right"><i class="md-time f-left" style="color:white"></i><span style="color:white" id="pasir_minggu_ini">0</span></h1>
                            <p class="m-b-0">PENJUALAN MINGGU LALU <span class="f-right" id="psair_minggu_lalu">0</span></p>
                        </div>
                    </div>
                  </a>
                </div>
                <div class="col-md-3 col-md-3">
                  <a href="" class="custom-card">
                    <div class="card bg-c-orange order-card">
                        <div class="card-block">
                            <h6 class="m-b-20" style="color:white">PENJUALAN SPLIT 1/2 MINGGU INI</h6>
                            <h1 class="text-right"><i class="md-time f-left" style="color:white"></i><span style="color:white" id="lembur_total">0</span></h1>
                            <p class="m-b-0">PENJUALAN MINGGU LALU <span class="f-right" id="lembur_not_verif_total">0</span></p>
                        </div>
                    </div>
                  </a>
                </div>
            </div>

            <div class="row col-lg-12">
                <div class="col-md-3 col-md-3">
                  <a href="" class="custom-card">
                    <div class="card bg-c-semigreen order-card">
                        <div class="card-block">
                            <h6 class="m-b-20" style="color:white">PENJUALAN ABU MINGGU INI</h6>
                            <h1 class="text-right"><i class="md-time f-left" style="color:white"></i><span style="color:white" id="lembur_total">0</span></h1>
                            <p class="m-b-0">PENJUALAN MINGGU LALU <span class="f-right" id="lembur_not_verif_total">0</span></p>
                        </div>
                    </div>
                  </a>
                </div>
            </div>
            @endif
  
        

{{-- </div> --}}
@endsection

@push('js')

<script>

var status;
var admin="{{\Auth::user()->can('read-card-admin')}}";
var manager="{{\Auth::user()->can('read-card-manager')}}";

$(document).ready(function(){

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
                    $('#pasir_minggu_ini').html(data.pasir_minggu_ini);
                    $('#pasir_minggu_lalu').html(data.pasir_minggu_lalu);
                     updateList(status);
                }
                else if(status=='manager')
                {
                    $('#total_transaksi').html(data.total_transaksi);
                    $('#total_transaksi_bulan_ini').html(data.total_transaksi_bulan_ini);
                    $('#pasir_minggu_ini').html(data.pasir_minggu_ini);
                    $('#pasir_minggu_lalu').html(data.pasir_minggu_lalu);
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

        $('#pasir_minggu_ini').html(data.pasir_minggu_ini);
        $('#pasir_minggu_lalu').html(data.pasir_minggu_lalu);


        setTimeout(function(){updateList(status)}, 2000);
    }
    else if(status=='user')
    {
        $('#total_transaksi').html(data.total_transaksi);
        $('#total_transaksi_bulan_ini').html(data.total_transaksi_bulan_ini);

        $('#pasir_minggu_ini').html(data.pasir_minggu_ini);
        $('#pasir_minggu_lalu').html(data.pasir_minggu_lalu);

        setTimeout(function(){updateList(status)}, 2000);
    }

     },
     error:function (xhr, status, error){
      toastr.warning(xhr.responseText,'');
    },
  });
  }

var tday=["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];
var tmonth=["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];

  function GetClock(){
    var d=new Date();
    var nday=d.getDay(),nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getFullYear();
    var nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds();
    if(nmin<=9) nmin="0"+nmin;
    if(nsec<=9) nsec="0"+nsec;

    var clocktext=""+tday[nday]+", "+ndate+" "+tmonth[nmonth]+" "+nyear+" "+nhour+":"+nmin+":"+nsec+"";
    document.getElementById('clockbox').innerHTML=clocktext;
  }

  GetClock();
  setInterval(GetClock,1000);

</script>
@endpush