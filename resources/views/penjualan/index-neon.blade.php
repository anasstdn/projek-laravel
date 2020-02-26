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
        <div class="panel-body">
          <div class="panel-body">
            <div class="col-md-12 row" style="margin-bottom: 1em">
              <label class="col-md-2">Select By</label>
              <div class="col-md-2">
                <div class="boxes">    
                  <input type="checkbox" class="check" id="harian" value="harian" checked>
                  <label id="harian_notif" for="harian">Harian</label>      
                </div>
              </div>
              <div class="col-md-2">
                <div class="boxes">      
                  <input type="checkbox" class="check" id="mingguan" value="mingguan">
                  <label id="mingguan_notif" for="mingguan">Mingguan</label>
                </div>
              </div>
              <div class="col-md-2">
                <div class="boxes">      
                  <input type="checkbox" class="check" id="bulanan" value="bulanan">
                  <label id="bulanan_notif" for="bulanan">Bulanan</label>
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
            <div class="col-md-4 row" style="margin-bottom: 1em">
              <div class="text-left">
                <a class="btn btn-md btn-primary" id="cari">Cari</a>
                &nbsp&nbsp
                <a class="btn btn-md btn-default" id="reset">Reset</a>
              </div>
            </div>
        </div>
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

            </div>

        </div>

    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function(){
     $('.input-daterange').datepicker({format: "dd-mm-yyyy"}); 

     $(".check").change(function() {
      $(".check").prop('checked', false);
      $(this).prop('checked', true);
    });
     
    tahun=$('#table-1').DataTable({
      stateSave: true,
      processing : true,
      serverSide : true,
        pageLength:20,
        bFilter:false,
        ajax : {
          url:"{{ url('penjualan/load-data') }}",
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
        // graph();
    })
  });
</script>
@endpush