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
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-gradient" data-collapsed="0">
        <div class="panel-heading">
          <div class="panel-title pull-left">Peramalan Adaptive Response Rate Single Exponential Smoothing (ARRSES)
          </div>  
          <div class="panel-options">
            {{-- <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> --}}
            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
            {{-- <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> --}}
            {{-- <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> --}}
          </div>
        </div>

        <div class="panel-body">
          <div class="panel-body">
          <div class="table-responsive">
           <table class="table table-bordered datatable" id="arrses">
            <thead>
              <tr>
                <th>Minggu</th>
                <th>Nilai Aktual</th>
                <th>Galat</th>
                <th>Galat Pemulusan</th>
                <th>Galat Pemulusan Absolut</th>
                <th>Alpha</th>
                <th>Prosentase Error</th>
                <th>Nilai Peramalan</th>
              </tr>
            </thead>  
          </table>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-gradient" data-collapsed="0">
        <div class="panel-heading">
          <div class="panel-title pull-left">Peramalan Double Exponential Smoothing Metode Brown
          </div>  
          <div class="panel-options">
            {{-- <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> --}}
            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
            {{-- <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> --}}
            {{-- <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> --}}
          </div>
        </div>

        <div class="panel-body">
          <div class="panel-body">
          <div class="table-responsive">
           <table class="table table-bordered datatable" id="des">
            <thead>
              <tr>
                <th>Minggu</th>
                <th>Nilai Aktual</th>
                <th>Smoothing Pertama (St')</th>
                <th>Smoothing Kedua (St'')</th>
                <th>Konstanta (at)</th>
                <th>Slope (bt)</th>
                <th>Nilai Peramalan (at + bt)</th>
              </tr>
            </thead>  
          </table>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
 <div class="modal fade" id="formModal" aria-hidden="true" aria-labelledby="formModalLabel" role="dialog" tabindex="-1">
 </div>
 <div class="modal fade" id="formModal1" aria-hidden="true" aria-labelledby="formModalLabel" role="dialog" tabindex="-1">
 </div>
{{-- </div> --}}
@endsection

@push('js')
<script>
  var html;
  $(document).ready(function(){
    arrses();
    des();
  })

  function arrses()
  {
    $('.ajax-loader').fadeIn();
    $("#status").html("Loading...Please Wait!");
    $.ajax({
      url: '{{url('peramalan/forecast')}}',
      type: 'GET',
      data: {tahun:$('#tahun').val()},
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
      success:function(data){
        // console.log(data);
        $.each(data,function(index,value){
          html='<tr><td>'+value.periode+'</td>\n\
          <td>'+value.aktual+'</td>\n\
          <td>'+value.galat+'</td>\n\
          <td>'+value.galat_pemulusan+'</td>\n\
          <td>'+value.galat_pemulusan_absolut+'</td>\n\
          <td>'+value.alpha+'</td>\n\
          <td>'+value.percentage_error+' %</td>\n\
          <td>'+value.peramalan+'</td>\n\
          </tr>';
          $('#arrses').append(html);
          console.log(value);
        })
      },
      error:function (xhr, status, error){
        toastr_notif(xhr.responseText,'gagal');
      },
    });
  }

  function des()
  {
    $('.ajax-loader').fadeIn();
    $("#status").html("Loading...Please Wait!");
    $.ajax({
      url: '{{url('peramalan/forecast-des')}}',
      type: 'GET',
      data: {tahun:$('#tahun').val()},
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
      success:function(data){
        // console.log(data);
        $.each(data,function(index,value){
          html='<tr><td>'+value.minggu+'</td>\n\
          <td>'+value.aktual+'</td>\n\
          <td>'+value.s1+'</td>\n\
          <td>'+value.s2+'</td>\n\
          <td>'+value.nilaiA+'</td>\n\
          <td>'+value.nilaiB+' %</td>\n\
          <td>'+value.prediksi+'</td>\n\
          </tr>';
          $('#des').append(html);
          console.log(value);
        })
      },
      error:function (xhr, status, error){
        toastr_notif(xhr.responseText,'gagal');
      },
    });
  }
</script>
@endpush
