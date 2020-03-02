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
          <div class="panel-title pull-left">Filter Pencarian <span><i class="entypo-search"></i></span>
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
            <div class="col-md-12 row" style="margin-bottom: 1em">
              <label class="col-md-2">Select By</label>
              <div class="col-md-2">
                <div class="boxes">    
                  <input type="checkbox" class="check" id="year" value="year" checked>
                  <label id="year_notif" for="year">1 Tahun Terakhir</label>      
                </div>
              </div>
              <div class="col-md-2">
                <div class="boxes">      
                  <input type="checkbox" class="check" id="date" value="date">
                  <label id="date_notif" for="date">Range Tanggal</label>
                </div>
              </div>
            </div>
            <div class="col-md-12 row" style="margin-bottom: 1em">
              <label class="col-md-2">Tanggal</label>
              <div class="col-md-4">
            <div class="input-group input-large input-daterange" >
                {{-- <input type="text" class="form-control tanggal-picker" id="date_from" value="{{ date('d-m-Y') }}"> --}}
                <input type="text" class="form-control form-control-sm" style="width:150px;" id="date_start" value="{{ date("d-m-Y") }}" name="date_start" />
                <input type="text" class="form-control" id="date_from2" value="{{ date('d-m-Y') }}" style="display:none;">
                          <span class="input-group-addon form-control-sm" style="color:#4CAF50">sd</span>
                        <input type="text" class="form-control form-control-sm" style="width:150px;" value="{{ date('d-m-Y', strtotime("+1 month")) }}" id="date_end" name="date_end" />
                        <input type="text" class="form-control" id="date_to2" value="{{ date('d-m-Y', strtotime("+1 month")) }}" style="display:none;">
                </div>
            </div>
          </div>
            <div class="col-md-12 row" style="margin-bottom: 1em">
              <label class="col-md-2">Produk</label>
              <div class="col-md-4">
                <select class="form-control" id="produk">
                  <option value="abu">Abu</option>
                  <option value="split1_2">Split 1/2</option>
                  <option value="pasir">Pasir</option>
                </select>
              </div>
            </div>
            <div class="col-md-4 row" style="margin-bottom: 1em">
              <div class="text-left">
                <a class="btn btn-md btn-primary" id="cari">Cari</a>
                &nbsp&nbsp
                <a class="btn btn-md btn-default" id="reset">Reset</a>
              </div>
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
                <th>Alpha</th>
                <th>Prosentase Error</th>
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
  var mode;
  $(document).ready(function(){
     $('.input-daterange').datepicker({format: "dd-mm-yyyy"}); 
    
   
    checkbox();
    $(".check").change(function() {
      $(".check").prop('checked', false);
      $(this).prop('checked', true);

      
    });

    $('.check').on('change',function(){
      checkbox1();
    })

    $('#cari').click(function(){
      checkbox();
    })

  })

  function checkbox()
  {
    if($('#year').is(':checked'))
    {
     $('#date_start').attr('readonly',true);
     $('#date_end').attr('readonly',true);
     mode='year';
    }
    else
    {
      $('#date_start').attr('readonly',false);
     $('#date_end').attr('readonly',false);
      mode='date';
    }
    arrses(mode);
    des(mode);
  }

    function checkbox1()
  {
    if($('#year').is(':checked'))
    {
     $('#date_start').attr('readonly',true);
     $('#date_end').attr('readonly',true);
     // mode='year';
    }
    else
    {
      $('#date_start').attr('readonly',false);
     $('#date_end').attr('readonly',false);
      // mode='date';
    }
    // arrses(mode);
    // des(mode);
  }

  function arrses(mode)
  {
    $('.ajax-loader').fadeIn();
    $("#status").html("Loading...Please Wait!");
    $.ajax({
      url: '{{url('peramalan/forecast')}}',
      type: 'GET',
      data: {mode:mode,date_start:$('#date_start').val(),date_end:$('#date_end').val(),produk:$('#produk').val()},
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
        $('#arrses tbody').empty();
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
          // console.log(value);
        })
      },
      error:function (xhr, status, error){
        toastr_notif(xhr.responseText,'gagal');
      },
    });
  }

  function des(mode)
  {
    $('.ajax-loader').fadeIn();
    $("#status").html("Loading...Please Wait!");
    $.ajax({
      url: '{{url('peramalan/forecast-des')}}',
      type: 'GET',
      data: {mode:mode,date_start:$('#date_start').val(),date_end:$('#date_end').val(),produk:$('#produk').val()},
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
        $('#des tbody').empty();
        $.each(data,function(index,value){
          html='<tr><td>'+value.minggu+'</td>\n\
          <td>'+value.aktual+'</td>\n\
          <td>'+value.s1+'</td>\n\
          <td>'+value.s2+'</td>\n\
          <td>'+value.nilaiA+'</td>\n\
          <td>'+value.nilaiB+' %</td>\n\
            <td>'+value.alpha+'</td>\n\
           <td>'+value.error+' %</td>\n\
          <td>'+value.prediksi+'</td>\n\
          </tr>';
          $('#des').append(html);
          // console.log(value);
        })
      },
      error:function (xhr, status, error){
        toastr_notif(xhr.responseText,'gagal');
      },
    });
  }
</script>
@endpush
