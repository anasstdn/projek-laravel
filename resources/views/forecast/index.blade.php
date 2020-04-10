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
  <div class="bg-primary-dark">
  <div class="content content-top">
    <div class="row push">
      <div class="col-md py-10 d-md-flex align-items-md-center text-center">
        <h1 class="text-white mb-0">
          <span class="font-w300">Peramalan</span>
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
      <span class="breadcrumb-item active">Peramalan</span>
    </nav>
  </div>
  <!-- END Breadcrumb -->

  <!-- Content -->
  <div class="content">
    <div class="block">
      <div class="block-content block-content-full">

    <div class="row" style="margin-bottom: 3em">
    <div class="col-lg-12">
           <div class="card">
              <div class="card-header text-uppercase">FILTER PENCARIAN</div>
              <div class="card-body">
                <br>
        {{--     <div class="col-md-12 row" style="margin-bottom: 1em">
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
            </div> --}}
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
                  <option value="gendol">Pasir Gendol</option>
                  <option value="pasir">Pasir Biasa</option>
                   <option value="split1_2">Split 1/2</option>
                  <option value="split2_3">Split 2/3</option>
                  <option value="lpa">LPA</option>
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
  
  <div class="row" style="margin-bottom: 3em">
    <div class="col-lg-12">
      <div class="card">
              <div class="card-header text-uppercase">PERAMALAN MENGGUNAKAN METODE ARRSES</div>
              <div class="card-body">
          <div class="table-responsive">
           <table class="table table-striped table-vcenter datatable">
            <thead>
              <tr>
                <th>Minggu</th>
                <th>Nilai Aktual</th>
                <th>Nilai Peramalan</th>
                <th>Galat</th>
                <th>Galat Pemulusan</th>
                <th>Galat Pemulusan Absolut</th>
                <th>Alpha</th>
                <th>Deviasi Absolut (MAD)</th>
                <th>Prosentase Error (MAPE)</th>
              </tr>
            </thead> 
            <tbody id="arrses">
            </tbody>
            <tfoot>
              <tr>
                <td colspan="7">Jumlah</td>
                <td id="jumlah_mad_arrses" style="font-weight: bold"></td>
                <td id="jumlah_mape_arrses" style="font-weight: bold"></td>
              </tr>
              <tr>
                <td colspan="7">Nilai</td>
                <td id="nilai_mad_arrses" style="font-weight: bold"></td>
                <td id="nilai_mape_arrses" style="font-weight: bold"></td>
              </tr>
              <tr>
                <td colspan="7">Kriteria Nilai MAPE</td>
                <td id="kriteria_mape_arrses" style="font-weight: bold"></td>
                <td>
                  <a href="#" id="arrses_detail" style="display: none" target="_blank" class="btn btn-sm btn-info">DETAIL</a>
                </td>
              </tr>
            </tfoot> 
          </table>
        </div>
      </div>
    </div>
      </div>
    {{-- </div> --}}
  </div>
  <div class="row" style="margin-bottom: 3em">
    <div class="col-lg-12">
      <div class="card">
              <div class="card-header text-uppercase">PERAMALAN MENGGUNAKAN DES METODE BROWN</div>
              <div class="card-body">
          <div class="table-responsive">
           <table class="table table-striped table-vcenter datatable" >
            <thead>
              <tr>
                <th>Minggu</th>
                <th>Nilai Aktual</th>
                <th>Nilai Peramalan (at + bt)</th>
                <th>Smoothing Pertama (St')</th>
                <th>Smoothing Kedua (St'')</th>
                <th>Konstanta (at)</th>
                <th>Slope (bt)</th>
                <th>Alpha</th>
                <th>Deviasi Absolut (MAD)</th>
                <th>Prosentase Error (MAPE)</th>
              </tr>
            </thead>
            <tbody id="des">
            </tbody>
                <tfoot>
              <tr>
                <td colspan="8">Jumlah</td>
                <td id="jumlah_mad_des" style="font-weight: bold"></td>
                <td id="jumlah_mape_des" style="font-weight: bold"></td>
              </tr>
              <tr>
                <td colspan="8">Nilai</td>
                <td id="nilai_mad_des" style="font-weight: bold"></td>
                <td id="nilai_mape_des" style="font-weight: bold"></td>
              </tr>
              <tr>
                <td colspan="8">Kriteria Nilai MAPE</td>
                <td id="kriteria_mape_des" style="font-weight: bold"></td>
                 <td>
                  <a href="#" id="des_detail" style="display: none" target="_blank" class="btn btn-sm btn-info">DETAIL</a>
                </td>
              </tr>
            </tfoot>   
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12 col-xl-12">
    <div class="card">
      <div class="card-header text-uppercase">FORECASTING GRAPH</div>
      <div class="card-body">
       <div id="grafik_penjualan"></div>
     </div>
   </div>
 </div>
</div>

 <div class="modal fade" id="formModal" aria-hidden="true" aria-labelledby="formModalLabel" role="dialog" tabindex="-1">
 </div>
 <div class="modal fade" id="formModal1" aria-hidden="true" aria-labelledby="formModalLabel" role="dialog" tabindex="-1">
 </div>
</div>
</div>
</div>

{{-- </div> --}}
@endsection

@push('js')
<script>
  var html;
  var mode;
  var aktual_arrses=[];
  var peramalan_arrses=[];
  var peramalan_des=[];
  var label=[];
  $(document).ready(function(){
     $('.input-daterange').datepicker({format: "dd-mm-yyyy"}); 
    
   
    // checkbox();
    // $(".check").change(function() {
    //   $(".check").prop('checked', false);
    //   $(this).prop('checked', true);
    // });

    // $('.check').on('change',function(){
    //   checkbox1();
    // })

    $('#cari').click(function(){
      // checkbox();
      arrses('date');
      des('date');

    })

    $('#reset').click(function(){
      $('#date_start').val('{{date('d-m-Y')}}');
      $('#date_end').val('{{date('d-m-Y', strtotime("+1 month"))}}');
      $('#arrses').empty();
      $('#des').empty();
      $('#jumlah_mad_arrses').empty();
        $('#jumlah_mape_arrses').empty();
        $('#nilai_mad_arrses').empty();
        $('#nilai_mape_arrses').empty();

        $('#jumlah_mad_des').empty();
        $('#jumlah_mape_des').empty();
        $('#nilai_mad_des').empty();
        $('#nilai_mape_des').empty();

         $('#kriteria_mape_des').empty();

          $('#kriteria_mape_arrses').empty();

          $('#arrses_detail').fadeOut();
          $("a#arrses_detail").prop("href", "#");

          $('#des_detail').fadeOut();
          $("a#des_detail").prop("href", "#");

      aktual_arrses.length = 0
          peramalan_arrses.length = 0
          label.length = 0
          peramalan_des.length = 0

          chart_total();

    })

  })

  // function checkbox()
  // {
  //   if($('#year').is(':checked'))
  //   {
  //    $('#date_start').attr('readonly',true);
  //    $('#date_end').attr('readonly',true);
  //    mode='year';
  //   }
  //   else
  //   {
  //     $('#date_start').attr('readonly',false);
  //    $('#date_end').attr('readonly',false);
  //     mode='date';
  //   }
  //   arrses(mode);
  //   des(mode);
  // }

  //   function checkbox1()
  // {
  //   if($('#year').is(':checked'))
  //   {
  //    $('#date_start').attr('readonly',true);
  //    $('#date_end').attr('readonly',true);
  //    // mode='year';
  //   }
  //   else
  //   {
  //     $('#date_start').attr('readonly',false);
  //    $('#date_end').attr('readonly',false);
  //     // mode='date';
  //   }
  //   // arrses(mode);
  //   // des(mode);
  // }

  function arrses(mode)
  {
        aktual_arrses.length = 0
          peramalan_arrses.length = 0
          label.length = 0
          var sum_mad=0;
          var sum_per=0;
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
        if(data.length==0)
        {
          toastr_notif('Tidak ditemukan data penjualan','gagal');
        }
        else
        {
        $('#arrses_detail').fadeIn();
       $("a#arrses_detail").prop("href", "{{url('detail-arrses/')}}/"+$('#produk').val()+"/"+$('#date_start').val()+"/"+$('#date_end').val()+"");
          $('#arrses').empty();
          $('#jumlah_mad_arrses').empty();
          $('#jumlah_mape_arrses').empty();
          $('#nilai_mad_arrses').empty();
          $('#nilai_mape_arrses').empty();
          $.each(data,function(index,value){


            aktual_arrses.push(Math.floor(value.aktual,-3));
            peramalan_arrses.push(Math.floor(value.peramalan,-3));
            label.push(value.periode);



            html='<tr><td>'+value.periode+'</td>\n\
            <td>'+value.aktual+'</td>\n\
            <td>'+value.peramalan+'</td>\n\
            <td>'+value.galat+'</td>\n\
            <td>'+value.galat_pemulusan+'</td>\n\
            <td>'+value.galat_pemulusan_absolut+'</td>\n\
            <td>'+value.alpha+'</td>\n\
            <td>'+value.MAD+'</td>\n\
            <td>'+value.percentage_error+' %</td>\n\
            </tr>';
            $('#arrses').append(html);

            if(index<data.length)
            {
              sum_mad+=value.MAD;
              sum_per+=value.percentage_error;
            }
          // console.log(value);
        })
          $('#jumlah_mad_arrses').html(sum_mad);
          $('#jumlah_mape_arrses').html(sum_per);
          $('#nilai_mad_arrses').html((sum_mad/(data.length-1)));
          $('#nilai_mape_arrses').html((sum_per/(data.length-1))+' %');

          if(sum_per/(data.length-1) < 10)
          {
            $('#kriteria_mape_arrses').html('SANGAT BAIK');
          }
          else if(sum_per/(data.length-1) >= 10 && sum_per/(data.length-1) <= 20)
          {
            $('#kriteria_mape_arrses').html('BAIK');
          }
          else if(sum_per/(data.length-1) > 20 && sum_per/(data.length-1) <= 50)
          {
            $('#kriteria_mape_arrses').html('CUKUP');
          }
          else if(sum_per/(data.length-1) > 50)
          {
            $('#kriteria_mape_arrses').html('BURUK');
          }

          chart_total();
        }
      },
      error:function (xhr, status, error){
        toastr_notif(xhr.responseText,'gagal');
      },
    });
  }

  function des(mode)
  {
      peramalan_des.length = 0
      var sum_mad=0;
          var sum_per=0;
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
        // console.log(data.length);
        if(data.length==0)
        {
          toastr_notif('Tidak ditemukan data penjualan','gagal');
        }
        else
        {
          $('#des_detail').fadeIn();
        $("a#des_detail").prop("href", "{{url('detail-des/')}}/"+$('#produk').val()+"/"+$('#date_start').val()+"/"+$('#date_end').val()+"");
          $('#des').empty();
          $('#jumlah_mad_des').empty();
          $('#jumlah_mape_des').empty();
          $('#nilai_mad_des').empty();
          $('#nilai_mape_des').empty();
          $.each(data,function(index,value){
          // aktual_des.push(value.aktual);


          peramalan_des.push(Math.floor(value.peramalan,-3));

          html='<tr><td>'+value.periode+'</td>\n\
          <td>'+value.aktual+'</td>\n\
          <td>'+value.peramalan+'</td>\n\
          <td>'+value.s1+'</td>\n\
          <td>'+value.s2+'</td>\n\
          <td>'+value.at+'</td>\n\
          <td>'+value.bt+' %</td>\n\
          <td>'+value.alpha+'</td>\n\
          <td>'+value.MAD+'</td>\n\
          <td>'+value.PE+' %</td>\n\
          </tr>';
          $('#des').append(html);
          // console.log(value)
          if(index<data.length)
          {
            sum_mad+=value.MAD;
            sum_per+=value.PE;
          }
        })

          $('#jumlah_mad_des').html(sum_mad);
          $('#jumlah_mape_des').html(sum_per);
          $('#nilai_mad_des').html((sum_mad/(data.length-1)));
          $('#nilai_mape_des').html((sum_per/(data.length-1))+' %');

          if(sum_per/(data.length-1) < 10)
          {
            $('#kriteria_mape_des').html('SANGAT BAIK');
          }
          else if(sum_per/(data.length-1) >= 10 && sum_per/(data.length-1) <= 20)
          {
            $('#kriteria_mape_des').html('BAIK');
          }
          else if(sum_per/(data.length-1) > 20 && sum_per/(data.length-1) <= 50)
          {
            $('#kriteria_mape_des').html('CUKUP');
          }
          else if(sum_per/(data.length-1) > 50)
          {
            $('#kriteria_mape_des').html('BURUK');
          }
        }

      },
      error:function (xhr, status, error){
        toastr_notif(xhr.responseText,'gagal');
      },
    });
  }

  function chart_total()
{
    var options = {
            chart: {
                height: 500,
                type: 'area',
                stacked: false,
                zoom: {
                      enabled: false
                    },
                foreColor: '#4e4e4e',
                toolbar: {
                      show: false
                    },
                shadow: {
                    enabled: false,
                    color: '#000',
                    top: 3,
                    left: 2,
                    blur: 3,
                    opacity: 1
                },
            },
            stroke: {
                width: 4,   
                curve: 'smooth',
            },
            series: [
            {
                name: 'Data Aktual',
                data: aktual_arrses,
            },
            {
                name: 'ARRSES',
                data: peramalan_arrses,
            },
            {
                name: 'DES',
                data: peramalan_des,
            },
            ],

            tooltip: {
                enabled: true,
                theme: 'dark',
            },
            markers:{
                size:3
            },

            xaxis: {
                labels: {
                    format: 'dd/MM',
                },
                categories: label,
            },
            fill: {
                type: 'gradient',
                gradient: {
                    // shade: 'dark',
                    // gradientToColors: [ '#00dbde'],
                    // shadeIntensity: 1,
                    // type: 'horizontal',
                    shadeIntensity: 1,
                    inverseColors: false,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [20, 100, 100, 100]
                },
            },
            colors: ['#2E93fA', '#66DA26', '#546E7A', '#E91E63', '#FF9800'],
            grid:{
                show: true,
                borderColor: 'rgba(66, 59, 116, 0.15)',
            },
            yaxis: {
                // min: -10,
                // max: 3000,                
            }
        }

       var chart = new ApexCharts(
            document.querySelector("#grafik_penjualan"),
            options
        );
        
        chart.render();
}

</script>
@endpush
