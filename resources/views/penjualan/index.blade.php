@extends('layouts.app')

@section('content')
<div class="bg-primary-dark">
<div class="content content-top">
<div class="row push">
<div class="col-md py-10 d-md-flex align-items-md-center text-center">
<h1 class="text-white mb-0">
<span class="font-w300">Sales</span>
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

<!-- Page Content -->
<div class="bg-white">
  <!-- Breadcrumb -->
  <div class="content">
    <nav class="breadcrumb mb-0">
      <a class="breadcrumb-item" href="javascript:void(0)">Sales</a>
      <span class="breadcrumb-item active">Sales</span>
    </nav>
  </div>
  <!-- END Breadcrumb -->

  <!-- Content -->
  <div class="content">
    <!-- Icon Navigation -->
     <!-- Dynamic Table Full Pagination -->
                    <div class="block">
                        <div class="block-content block-content-full">
                          <div class="col-md-12 row" style="margin-bottom: 1em">
                            <label class="col-md-2">Filter By</label>
                            <div class="col-6">
                              <label class="css-control css-control-primary css-radio">
                                <input type="radio" class="css-control-input" name="pilih" value="harian" id="test1" checked>
                                <span class="css-control-indicator"></span> Harian
                              </label>
                              <label class="css-control css-control-primary css-radio">
                                <input type="radio" class="css-control-input"  name="pilih" value="mingguan" id="test2" >
                                <span class="css-control-indicator"></span> Mingguan
                              </label>
                               <label class="css-control css-control-primary css-radio">
                                <input type="radio" class="css-control-input"  name="pilih" value="bulanan" id="test3" >
                                <span class="css-control-indicator"></span> Bulanan
                              </label>
                               <label class="css-control css-control-primary css-radio">
                                <input type="radio" class="css-control-input"  name="pilih" value="tahunan" id="test4" >
                                <span class="css-control-indicator"></span> Tahunan
                              </label>
                            </div>
                          </div>
                          <div class="col-md-12 row" style="margin-bottom: 1em" id="hari">
                            <label class="col-md-2">Date</label>
                            <div class="col-lg-4">
                              <div class="input-daterange input-group" data-date-format="dd-mm-yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                <input type="text" class="form-control" id="start_date" name="start_date" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true" value="{{date('d-m-Y')}}">
                                <div class="input-group-prepend input-group-append">
                                  <span class="input-group-text font-w600">to</span>
                                </div>
                                <input type="text" class="form-control" id="end_date" name="end_date" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true" value="{{date('d-m-Y')}}">
                              </div>
                            </div>
                          </div>
                           <div class="col-md-12 row" style="margin-bottom: 1em;display:none" id="week">
                            <label class="col-md-2">Week</label>
                            <div class="col-lg-4">
                              <input type="text" class="calendar form-control" id="week_input" name="example-week_input" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="dd-mm-yyyy" placeholder="Week">
                            </div>
                          </div>
                          <div class="col-md-12 row" style="margin-bottom: 1em;display: none" id="tahun_a">
                            <label class="col-md-2">Year</label>
                            <div class="col-lg-4">
                              <select class="form-control" id="tahun">
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
                          </div>
                          <div class="col-md-4 row" style="margin-bottom: 1em">
                            <div class="text-left">
                              <button class="btn btn-md btn-primary" id="cari" style="color:white;">Cari</button>
                              &nbsp&nbsp
                              <button class="btn btn-md btn-outline-primary" id="reset">Reset</button>
                            </div>
                          </div>
                            <!-- DataTables functionality is initialized with .js-dataTable-full-pagination class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                            <div id="tahunan" style="display: none">
                            <table class="table table-bordered table-striped table-vcenter" width="100%" id="table-1" >
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
              </div>
              <div id="minggu-table" style="display:none">
              <table width="100%" class="table table-bordered datatable" id="table-minggu">
                        <thead>
                          <tr>
                            <th rowspan="2" style="vertical-align: middle">No</th>
                            <th rowspan="2" style="vertical-align: middle">Tanggal Transaksi</th>
                            <th colspan="6" style="text-align: center">Jumlah (Meter Kubik)</th>
                        </tr>
                        <tr>
                            <th style="text-align: center">Pasir</th>
                            <th style="text-align: center">Gendol</th>
                            <th style="text-align: center">Abu</th>
                            <th style="text-align: center">Split 1/2</th>
                            <th style="text-align: center">Split 2/3</th>
                            <th style="text-align: center">LPA</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
              </div>
                          
                        </div>
                    </div>
                    <!-- END Dynamic Table Full Pagination -->
    
  </div>
  <!-- END Content -->
</div>
 <div class="modal fade" id="formModal" aria-hidden="true" aria-labelledby="modal-normal" role="dialog" tabindex="-1">
 </div>
<!-- END Page Content -->
@endsection

@push('js')
<script>
var pilih=$('input[name="pilih"]:checked').val();
var tahun;
var minggu;
$(document).ready(function(){

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

minggu=$('#table-minggu').DataTable({
      stateSave: true,
      processing : true,
      serverSide : true,
        pageLength:20,
        bFilter:false,
        ajax : {
          url:"{{ url('penjualan/load-data-mingguan') }}",
          data: function (d) {
            return $.extend( {}, d, {
                week_input:$('#week_input').val(),
            } );
          }
        },
        columns: [
        { data: 'nomor', name: 'nomor',searchable:false,orderable:false },
        { data: 'tgl_transaksi', name: 'tgl_transaksi' },
        { data: 'pasir', name: 'pasir' },
        { data: 'gendol', name: 'gendol' },
        { data: 'abu', name: 'abu' },
        { data: 'split2_3', name: 'split2_3' },
        { data: 'split1_2', name: 'split1_2' },
        { data: 'lpa', name: 'lpa' },
       
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
  
  $('input[type=radio][name=pilih]').change(function() {
    pilih=$('input[name="pilih"]:checked').val();
    set();
  });

     $('.input-daterange').datepicker({format: "dd-mm-yyyy"}); 

     $(".calendar").datepicker({
      format: "dd-mm-yyyy"
    });

    //  $(".check").change(function() {
    //   $(".check").prop('checked', false);
    //   $(this).prop('checked', true);
    // });

    function set()
{
      switch(pilih)
    {
      case 'harian':
      $('#tahunan').fadeOut();
      $('#hari').fadeIn();
      $('#tahun_a').fadeOut();
      $('#minggu-table').fadeOut();
      $('#week').fadeOut();
      break;
      case 'mingguan':
      reload_week();
      $('#tahunan').fadeOut();
      $('#hari').fadeOut();
      $('#tahun_a').fadeOut();
      $('#minggu-table').fadeIn();
      $('#week').fadeIn();
       $('#cari').click(function(){
        reload_week();
        // graph();
    })
      break;
      case 'bulanan':
      $('#tahunan').fadeOut();
      $('#hari').fadeOut();
      $('#tahun_a').fadeOut();
      $('#minggu-table').fadeOut();
      $('#week').fadeOut();
      break;
      case 'tahunan':
      reload();
      $('#tahunan').fadeIn();
      $('#hari').fadeOut();
      $('#tahun_a').fadeIn();
      $('#minggu-table').fadeOut();
      $('#week').fadeOut();
    $('#cari').click(function(){
        reload();
        // graph();
    })
      break;
    }
}
    
  });

function reload()
{
  tahun.ajax.reload(null,false);
}

function reload_week()
{
  minggu.ajax.reload(null,false);
}

</script>
@endpush
