@extends('layouts.app')

@section('content')
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
     <div class="ajax-loader">
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
            <div class="col-sm-12">
                <div class="well">
                    <h1>{{date_indo(date('Y-m-d'))}}</h1>
                    <h3>Selamat Datang <strong>{{ Auth::user()->name }}</strong></h3>
                </div>
            </div>
        </div>
    <div class="row">
    <div class="col-md-12">
                
                <div class="panel panel-info" data-collapsed="0">
                    
                    <!-- panel head -->
                    <div class="panel-heading">
                        <div class="panel-title">Tabel Penjualan</div>
                        
                        <div class="panel-options">
                            {{-- <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> --}}
                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            {{-- <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> --}}
                            {{-- <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> --}}
                        </div>
                    </div>
                    
                    <!-- panel body -->
                    <div class="panel-body">
                        <div class="col-md-3">
                        <span class="panel-title" style="font-weight:bold">Laporan Penjualan Tahunan</span>
                    </div>
                        &nbsp&nbsp&nbsp&nbsp&nbsp
                        <div class="col-md-2">
                        <select class="form-control col-2" id="tahun">
                            <?php $start=2017?>
                            <?php for($start;$start<=date('Y');$start++)
                            {?>
                                @if($start==date('Y'))
                                <option value="{{$start}}" selected="">{{$start}}</option>
                                @else
                                <option value="{{$start}}">{{$start}}</option>
                                @endif
                            <?php }?>                
                        </select>
                    </div>
                        <hr/>

                        <table class="table table-bordered datatable" id="table-1">
                            <thead>
                              <tr>
                                <th rowspan="2" style="vertical-align: middle">No</th>
                                <th rowspan="2" style="vertical-align: middle">Nama Produk</th>
                                <th colspan="12" style="text-align: center">Jumlah (Meter Kubik)</th>
                            </tr>
                            <tr>
                                <th style="text-align: center">Jan</th>
                                <th style="text-align: center">Feb</th>
                                <th style="text-align: center">Mar</th>
                                <th style="text-align: center">Apr</th>
                                <th style="text-align: center">Mei</th>
                                <th style="text-align: center">Jun</th>
                                <th style="text-align: center">Jul</th>
                                <th style="text-align: center">Aug</th>
                                <th style="text-align: center">Sep</th>
                                <th style="text-align: center">Okt</th>
                                <th style="text-align: center">Nov</th>
                                <th style="text-align: center">Des</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        </table>

                        <hr/>
                        <div class="col-md-12">
                        <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
        

{{-- </div> --}}
@endsection

@push('js')
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
  var tahun;
      let i;
    var dataPoints = [];
    var dataPoints1 = [];
    var dataPoints2 = [];
    var dataPoints3 = [];
    var dataPoints4 = [];
     var dataPoints5 = [];
  $(document).ready(function(){
    tahun=$('#table-1').DataTable({
      stateSave: true,
      processing : true,
      serverSide : true,
        pageLength:20,
        bFilter:false,
        ajax : {
          url:"{{ url('home/load-data') }}",
          data: function (d) {
            return $.extend( {}, d, {
                tahun:$('#tahun').val(),
            } );
          }
        },
        columns: [
        { data: 'nomor', name: 'nomor',searchable:false,orderable:false },
        { data: 'produk', name: 'produk' },
        { data: 'jan', name: 'jan' },
        { data: 'feb', name: 'feb' },
        { data: 'mar', name: 'mar' },
        { data: 'apr', name: 'apr' },
        { data: 'mei', name: 'mei' },
        { data: 'jun', name: 'jun' },
        { data: 'jul', name: 'jul' },
        { data: 'aug', name: 'aug' },
        { data: 'sep', name: 'sep' },
        { data: 'okt', name: 'okt' },
        { data: 'nov', name: 'nov' },
        { data: 'des', name: 'des' },
        // { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        language: {
          lengthMenu : '{{ "Menampilkan _MENU_ data" }}',
          zeroRecords : '{{ "Data tidak ditemukan" }}' ,
          info : '{{ "_PAGE_ dari _PAGES_ halaman" }}',
          infoEmpty : '{{ "Data tidak ditemukan" }}',
          infoFiltered : '{{ "(Penyaringan dari _MAX_ data)" }}',
          loadingRecords : '{{ "Memuat data dari server" }}' ,
          processing :    '{{ "Memuat data data" }}',
          sSearchPlaceholder: "Pencarian..",
          lengthMenu: "_MENU_",
          search: "_INPUT_",
          paginate : {
            first :     '{{ "<" }}' ,
            last :      '{{ ">" }}' ,
            next :      '{{ ">>" }}',
            previous :  '{{ "<<" }}'
          }
        },
        aoColumnDefs: [{
          bSortable: false,
          aTargets: [-1]
        }],
        iDisplayLength: 5,
        aLengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        // sDom: '<"dt-panelmenu clearfix"Bfr>t<"dt-panelfooter clearfix"ip>',
        // buttons: ['copy', 'excel', 'csv', 'pdf', 'print'],
      });

    $('#tahun').bind('click change',function(){
        tahun.ajax.reload(null,false);
        graph();
    })
  });

  $(window).on('load',function(){
    graph();
    
})

  function graph()
  {

      $('.ajax-loader').fadeIn();
    $("#status").html("Loading...Please Wait!");
    $.ajax({
      url: '{{url('home/get-chart')}}',
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
        for(i=0;i<data.dates.length;i++)
        {
            dataPoints.push({x:new Date(parseInt(data.dates[i].slice(0,4)),parseInt(data.dates[i].slice(5,7))-1,parseInt(data.dates[i].slice(8,10))),y:data.pasir[i]});

            dataPoints1.push({x:new Date(parseInt(data.dates[i].slice(0,4)),parseInt(data.dates[i].slice(5,7))-1,parseInt(data.dates[i].slice(8,10))),y:data.gendol[i]});

            dataPoints2.push({x:new Date(parseInt(data.dates[i].slice(0,4)),parseInt(data.dates[i].slice(5,7))-1,parseInt(data.dates[i].slice(8,10))),y:data.abu[i]});

            dataPoints3.push({x:new Date(parseInt(data.dates[i].slice(0,4)),parseInt(data.dates[i].slice(5,7))-1,parseInt(data.dates[i].slice(8,10))),y:data.split2[i]});

            dataPoints4.push({x:new Date(parseInt(data.dates[i].slice(0,4)),parseInt(data.dates[i].slice(5,7))-1,parseInt(data.dates[i].slice(8,10))),y:data.split1[i]});

            dataPoints5.push({x:new Date(parseInt(data.dates[i].slice(0,4)),parseInt(data.dates[i].slice(5,7))-1,parseInt(data.dates[i].slice(8,10))),y:data.lpa[i]});

        }
        chart = new CanvasJS.Chart("chartContainer",{
        title:{
            text:"Grafik Penjualan Tahun "+$('#tahun').val()+"",
            fontFamily : "arial"
        },
        axisX: {
        valueFormatString: "MMM YYYY",
        maximum:new Date(parseInt($('#tahun').val()),11,31)
    },
    toolTip: {
        shared: true
    },
    axisY2: {
        title: "Jumlah",
        prefix: "",
        suffix: " m3"
    },
        legend: {
        cursor: "pointer",
        verticalAlign: "top",
        horizontalAlign: "center",
        dockInsidePlotArea: true,
        itemclick: toogleDataSeries
    },
            data: [
            {
        type:"line",
        axisYType: "secondary",
        name: "Pasir",
        showInLegend: true,
        markerSize: 0,
        yValueFormatString: "#### m3",
        dataPoints: dataPoints
    },
    {
        type: "line",
        axisYType: "secondary",
        name: "Gendol",
        showInLegend: true,
        markerSize: 0,
        yValueFormatString: "#### m3",
        dataPoints: dataPoints1
    },
    {
        type: "line",
        axisYType: "secondary",
        name: "Abu",
        showInLegend: true,
        markerSize: 0,
        yValueFormatString: "#### m3",
        dataPoints: dataPoints2
    },
    {
        type: "line",
        axisYType: "secondary",
        name: "Split 2/3",
        showInLegend: true,
        markerSize: 0,
        yValueFormatString: "#### m3",
        dataPoints: dataPoints3
    },
    {
        type: "line",
        axisYType: "secondary",
        name: "Split 1/2",
        showInLegend: true,
        markerSize: 0,
        yValueFormatString: "#### m3",
        dataPoints: dataPoints4
    },
    {
        type: "line",
        axisYType: "secondary",
        name: "LPA",
        showInLegend: true,
        markerSize: 0,
        yValueFormatString: "#### m3",
        dataPoints: dataPoints5
    },
    ]
    });
    chart.render();
    // updateChart();
      },
      error:function (xhr, status, error){
        alert(xhr.responseText);
      },
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
    $("#status").html("Upload Failed");
  }

  function abortHandler(event) {
    $("#status").html("Upload Aborted");
  }

  function updateChart() {
   $.getJSON("{{url('home/get-chart')}}",{tahun:$('#tahun').val()}, function(data) {
           for(i=0;i<data.dates.length;i++)
            {
                // console.log(data.dates[1]);
                // console.log(data.pasir[1]);
                // var d=;
                // console.log(parseInt(value[i].slice(0,4))); 
                // console.log(parseInt(value[0].slice(5,7))); 
                // console.log(parseInt(value[0].slice(8,10))); 
                // console.log(value[i]);
                dataPoints.push({x:new Date(parseInt(data.dates[i].slice(0,4)),parseInt(data.dates[i].slice(5,7))-1,parseInt(data.dates[i].slice(8,10))),y:data.pasir[i]});

                dataPoints1.push({x:new Date(parseInt(data.dates[i].slice(0,4)),parseInt(data.dates[i].slice(5,7))-1,parseInt(data.dates[i].slice(8,10))),y:data.gendol[i]});

                dataPoints2.push({x:new Date(parseInt(data.dates[i].slice(0,4)),parseInt(data.dates[i].slice(5,7))-1,parseInt(data.dates[i].slice(8,10))),y:data.abu[i]});

                 dataPoints3.push({x:new Date(parseInt(data.dates[i].slice(0,4)),parseInt(data.dates[i].slice(5,7))-1,parseInt(data.dates[i].slice(8,10))),y:data.split2[i]});

                 dataPoints4.push({x:new Date(parseInt(data.dates[i].slice(0,4)),parseInt(data.dates[i].slice(5,7))-1,parseInt(data.dates[i].slice(8,10))),y:data.split1[i]});

                  dataPoints5.push({x:new Date(parseInt(data.dates[i].slice(0,4)),parseInt(data.dates[i].slice(5,7))-1,parseInt(data.dates[i].slice(8,10))),y:data.lpa[i]});

            }
      chart.render();
      setTimeout(function(){updateChart()}, 500);
   });
}

//   window.onload = function () {

// var chart = new CanvasJS.Chart("chartContainer", {
//     title: {
//         text: "Grafik Penjualan Tahun "+$('#tahun').val()+"",
//         fontFamily : "arial"
//     },
//     axisX: {
//         valueFormatString: "MMM YYYY"
//     },
//     axisY2: {
//         title: "Jumlah",
//         prefix: "",
//         suffix: " Cubic Meter"
//     },
//     toolTip: {
//         shared: true
//     },
//     legend: {
//         cursor: "pointer",
//         verticalAlign: "top",
//         horizontalAlign: "center",
//         dockInsidePlotArea: true,
//         itemclick: toogleDataSeries
//     },
//     data: [{
//         type:"line",
//         axisYType: "secondary",
//         name: "San Fransisco",
//         showInLegend: true,
//         markerSize: 0,
//         yValueFormatString: "#### m3",
//         dataPoints: [       
//             { x: new Date(2014, 00, 01), y: 850 },
//             { x: new Date(2014, 01, 01), y: 889 },
//             { x: new Date(2014, 02, 01), y: 890 },
//             { x: new Date(2014, 03, 01), y: 899 },
//             { x: new Date(2014, 04, 01), y: 903 },
//             { x: new Date(2014, 05, 01), y: 925 },
//             { x: new Date(2014, 06, 01), y: 899 },
//             { x: new Date(2014, 07, 01), y: 875 },
//             { x: new Date(2014, 08, 01), y: 927 },
//             { x: new Date(2014, 09, 01), y: 949 },
//             { x: new Date(2014, 10, 01), y: 946 },
//             { x: new Date(2014, 11, 01), y: 927 },
//             { x: new Date(2015, 00, 01), y: 950 },
//             { x: new Date(2015, 01, 01), y: 998 },
//             { x: new Date(2015, 02, 01), y: 998 },
//             { x: new Date(2015, 03, 01), y: 1050 },
//             { x: new Date(2015, 04, 01), y: 1050 },
//             { x: new Date(2015, 05, 01), y: 999 },
//             { x: new Date(2015, 06, 01), y: 998 },
//             { x: new Date(2015, 07, 01), y: 998 },
//             { x: new Date(2015, 08, 01), y: 1050 },
//             { x: new Date(2015, 09, 01), y: 1070 },
//             { x: new Date(2015, 10, 01), y: 1050 },
//             { x: new Date(2015, 11, 01), y: 1050 },
//             { x: new Date(2016, 00, 01), y: 995 },
//             { x: new Date(2016, 01, 01), y: 1090 },
//             { x: new Date(2016, 02, 01), y: 1100 },
//             { x: new Date(2016, 03, 01), y: 1150 },
//             { x: new Date(2016, 04, 01), y: 1150 },
//             { x: new Date(2016, 05, 01), y: 1150 },
//             { x: new Date(2016, 06, 01), y: 1100 },
//             { x: new Date(2016, 07, 01), y: 1100 },
//             { x: new Date(2016, 08, 01), y: 1150 },
//             { x: new Date(2016, 09, 01), y: 1170 },
//             { x: new Date(2016, 10, 01), y: 1150 },
//             { x: new Date(2016, 11, 01), y: 1150 },
//             { x: new Date(2017, 00, 01), y: 1150 },
//             { x: new Date(2017, 01, 01), y: 1200 },
//             { x: new Date(2017, 02, 01), y: 1200 },
//             { x: new Date(2017, 03, 01), y: 1200 },
//             { x: new Date(2017, 04, 01), y: 1190 },
//             { x: new Date(2017, 05, 01), y: 1170 }
//         ]
//     },
//     {
//         type: "line",
//         axisYType: "secondary",
//         name: "Manhattan",
//         showInLegend: true,
//         markerSize: 0,
//         yValueFormatString: "#### m3",
//         dataPoints: [
//             { x: new Date(2014, 00, 01), y: 1200 },
//             { x: new Date(2014, 01, 01), y: 1200 },
//             { x: new Date(2014, 02, 01), y: 1190 },
//             { x: new Date(2014, 03, 01), y: 1180 },
//             { x: new Date(2014, 04, 01), y: 1250 },
//             { x: new Date(2014, 05, 01), y: 1270 },
//             { x: new Date(2014, 06, 01), y: 1300 },
//             { x: new Date(2014, 07, 01), y: 1300 },
//             { x: new Date(2014, 08, 01), y: 1358 },
//             { x: new Date(2014, 09, 01), y: 1410 },
//             { x: new Date(2014, 10, 01), y: 1480 },
//             { x: new Date(2014, 11, 01), y: 1500 },
//             { x: new Date(2015, 00, 01), y: 1500 },
//             { x: new Date(2015, 01, 01), y: 1550 },
//             { x: new Date(2015, 02, 01), y: 1550 },
//             { x: new Date(2015, 03, 01), y: 1590 },
//             { x: new Date(2015, 04, 01), y: 1600 },
//             { x: new Date(2015, 05, 01), y: 1590 },
//             { x: new Date(2015, 06, 01), y: 1590 },
//             { x: new Date(2015, 07, 01), y: 1620 },
//             { x: new Date(2015, 08, 01), y: 1670 },
//             { x: new Date(2015, 09, 01), y: 1720 },
//             { x: new Date(2015, 10, 01), y: 1750 },
//             { x: new Date(2015, 11, 01), y: 1820 },
//             { x: new Date(2016, 00, 01), y: 2000 },
//             { x: new Date(2016, 01, 01), y: 1920 },
//             { x: new Date(2016, 02, 01), y: 1750 },
//             { x: new Date(2016, 03, 01), y: 1850 },
//             { x: new Date(2016, 04, 01), y: 1750 },
//             { x: new Date(2016, 05, 01), y: 1730 },
//             { x: new Date(2016, 06, 01), y: 1700 },
//             { x: new Date(2016, 07, 01), y: 1730 },
//             { x: new Date(2016, 08, 01), y: 1720 },
//             { x: new Date(2016, 09, 01), y: 1740 },
//             { x: new Date(2016, 10, 01), y: 1750 },
//             { x: new Date(2016, 11, 01), y: 1750 },
//             { x: new Date(2017, 00, 01), y: 1750 },
//             { x: new Date(2017, 01, 01), y: 1770 },
//             { x: new Date(2017, 02, 01), y: 1750 },
//             { x: new Date(2017, 03, 01), y: 1750 },
//             { x: new Date(2017, 04, 01), y: 1730 },
//             { x: new Date(2017, 05, 01), y: 1730 }
//         ]
//     },
//     {
//         type: "line",
//         axisYType: "secondary",
//         name: "Seatle",
//         showInLegend: true,
//         markerSize: 0,
//         yValueFormatString: "#### m3",
//         dataPoints: [
//             { x: new Date(2014, 00, 01), y: 409 },
//             { x: new Date(2014, 01, 01), y: 415 },
//             { x: new Date(2014, 02, 01), y: 419 },
//             { x: new Date(2014, 03, 01), y: 429 },
//             { x: new Date(2014, 04, 01), y: 429 },
//             { x: new Date(2014, 05, 01), y: 450 },
//             { x: new Date(2014, 06, 01), y: 450 },
//             { x: new Date(2014, 07, 01), y: 445 },
//             { x: new Date(2014, 08, 01), y: 450 },
//             { x: new Date(2014, 09, 01), y: 450 },
//             { x: new Date(2014, 10, 01), y: 440 },
//             { x: new Date(2014, 11, 01), y: 429 },
//             { x: new Date(2015, 00, 01), y: 435 },
//             { x: new Date(2015, 01, 01), y: 450 },
//             { x: new Date(2015, 02, 01), y: 475 },
//             { x: new Date(2015, 03, 01), y: 475 },
//             { x: new Date(2015, 04, 01), y: 475 },
//             { x: new Date(2015, 05, 01), y: 489 },
//             { x: new Date(2015, 06, 01), y: 495 },
//             { x: new Date(2015, 07, 01), y: 495 },
//             { x: new Date(2015, 08, 01), y: 500 },
//             { x: new Date(2015, 09, 01), y: 508 },
//             { x: new Date(2015, 10, 01), y: 520 },
//             { x: new Date(2015, 11, 01), y: 525 },
//             { x: new Date(2016, 00, 01), y: 525 },
//             { x: new Date(2016, 01, 01), y: 529 },
//             { x: new Date(2016, 02, 01), y: 549 },
//             { x: new Date(2016, 03, 01), y: 550 },
//             { x: new Date(2016, 04, 01), y: 568 },
//             { x: new Date(2016, 05, 01), y: 575 },
//             { x: new Date(2016, 06, 01), y: 579 },
//             { x: new Date(2016, 07, 01), y: 575 },
//             { x: new Date(2016, 08, 01), y: 585 },
//             { x: new Date(2016, 09, 01), y: 589 },
//             { x: new Date(2016, 10, 01), y: 595 },
//             { x: new Date(2016, 11, 01), y: 595 },
//             { x: new Date(2017, 00, 01), y: 595 },
//             { x: new Date(2017, 01, 01), y: 600 },
//             { x: new Date(2017, 02, 01), y: 624 },
//             { x: new Date(2017, 03, 01), y: 635 },
//             { x: new Date(2017, 04, 01), y: 650 },
//             { x: new Date(2017, 05, 01), y: 675 }
//         ]
//     },
//     {
//         type: "line",
//         axisYType: "secondary",
//         name: "Los Angeles",
//         showInLegend: true,
//         markerSize: 0,
//         yValueFormatString: "#### m3",
//         dataPoints: [
//             { x: new Date(2014, 00, 01), y: 529 },
//             { x: new Date(2014, 01, 01), y: 540 },
//             { x: new Date(2014, 02, 01), y: 539 },
//             { x: new Date(2014, 03, 01), y: 565 },
//             { x: new Date(2014, 04, 01), y: 575 },
//             { x: new Date(2014, 05, 01), y: 579 },
//             { x: new Date(2014, 06, 01), y: 589 },
//             { x: new Date(2014, 07, 01), y: 579 },
//             { x: new Date(2014, 08, 01), y: 579 },
//             { x: new Date(2014, 09, 01), y: 579 },
//             { x: new Date(2014, 10, 01), y: 569 },
//             { x: new Date(2014, 11, 01), y: 525 },
//             { x: new Date(2015, 00, 01), y: 535 },
//             { x: new Date(2015, 01, 01), y: 575 },
//             { x: new Date(2015, 02, 01), y: 599 },
//             { x: new Date(2015, 03, 01), y: 619 },
//             { x: new Date(2015, 04, 01), y: 639 },
//             { x: new Date(2015, 05, 01), y: 648 },
//             { x: new Date(2015, 06, 01), y: 640 },
//             { x: new Date(2015, 07, 01), y: 645 },
//             { x: new Date(2015, 08, 01), y: 648 },
//             { x: new Date(2015, 09, 01), y: 649 },
//             { x: new Date(2015, 10, 01), y: 649 },
//             { x: new Date(2015, 11, 01), y: 649 },
//             { x: new Date(2016, 00, 01), y: 650 },
//             { x: new Date(2016, 01, 01), y: 665 },
//             { x: new Date(2016, 02, 01), y: 675 },
//             { x: new Date(2016, 03, 01), y: 695 },
//             { x: new Date(2016, 04, 01), y: 690 },
//             { x: new Date(2016, 05, 01), y: 699 },
//             { x: new Date(2016, 06, 01), y: 699 },
//             { x: new Date(2016, 07, 01), y: 699 },
//             { x: new Date(2016, 08, 01), y: 699 },
//             { x: new Date(2016, 09, 01), y: 699 },
//             { x: new Date(2016, 10, 01), y: 709 },
//             { x: new Date(2016, 11, 01), y: 699 },
//             { x: new Date(2017, 00, 01), y: 700 },
//             { x: new Date(2017, 01, 01), y: 700 },
//             { x: new Date(2017, 02, 01), y: 724 },
//             { x: new Date(2017, 03, 01), y: 739 },
//             { x: new Date(2017, 04, 01), y: 749 },
//             { x: new Date(2017, 05, 01), y: 740 }
//         ]
//     },
//      {
//         type: "line",
//         axisYType: "secondary",
//         name: "Newark",
//         showInLegend: true,
//         markerSize: 0,
//         yValueFormatString: "#### m3",
//         dataPoints: [
//             { x: new Date(2014, 00, 01), y: 529 },
//             { x: new Date(2014, 01, 01), y: 540 },
//             { x: new Date(2014, 02, 01), y: 539 },
//             { x: new Date(2014, 03, 01), y: 565 },
//             { x: new Date(2014, 04, 01), y: 575 },
//             { x: new Date(2014, 05, 01), y: 579 },
//             { x: new Date(2014, 06, 01), y: 589 },
//             { x: new Date(2014, 07, 01), y: 579 },
//             { x: new Date(2014, 08, 01), y: 579 },
//             { x: new Date(2014, 09, 01), y: 579 },
//             { x: new Date(2014, 10, 01), y: 569 },
//             { x: new Date(2014, 11, 01), y: 525 },
//             { x: new Date(2015, 00, 01), y: 535 },
//             { x: new Date(2015, 01, 01), y: 575 },
//             { x: new Date(2015, 02, 01), y: 599 },
//             { x: new Date(2015, 03, 01), y: 619 },
//             { x: new Date(2015, 04, 01), y: 639 },
//             { x: new Date(2015, 05, 01), y: 648 },
//             { x: new Date(2015, 06, 01), y: 640 },
//             { x: new Date(2015, 07, 01), y: 645 },
//             { x: new Date(2015, 08, 01), y: 648 },
//             { x: new Date(2015, 09, 01), y: 649 },
//             { x: new Date(2015, 10, 01), y: 649 },
//             { x: new Date(2015, 11, 01), y: 649 },
//             { x: new Date(2016, 00, 01), y: 650 },
//             { x: new Date(2016, 01, 01), y: 665 },
//             { x: new Date(2016, 02, 01), y: 675 },
//             { x: new Date(2016, 03, 01), y: 695 },
//             { x: new Date(2016, 04, 01), y: 690 },
//             { x: new Date(2016, 05, 01), y: 699 },
//             { x: new Date(2016, 06, 01), y: 699 },
//             { x: new Date(2016, 07, 01), y: 699 },
//             { x: new Date(2016, 08, 01), y: 699 },
//             { x: new Date(2016, 09, 01), y: 699 },
//             { x: new Date(2016, 10, 01), y: 709 },
//             { x: new Date(2016, 11, 01), y: 699 },
//             { x: new Date(2017, 00, 01), y: 700 },
//             { x: new Date(2017, 01, 01), y: 700 },
//             { x: new Date(2017, 02, 01), y: 724 },
//             { x: new Date(2017, 03, 01), y: 739 },
//             { x: new Date(2017, 04, 01), y: 749 },
//             { x: new Date(2017, 05, 01), y: 740 }
//         ]
//     }

//     ]
// });
// chart.render();

function toogleDataSeries(e){
    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    } else{
        e.dataSeries.visible = true;
    }
    chart.render();
}

// }

</script>
@endpush