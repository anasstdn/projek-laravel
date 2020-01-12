@extends('layouts.app')

@section('content')
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
                        
                        <span class="panel-title" style="font-weight:bold">Laporan Penjualan Tahunan</span>
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
                        
                    </div>
                    
                </div>
                
            </div>
        </div>
{{-- </div> --}}
@endsection

@push('js')
<script>
  var user;
  $(document).ready(function(){
    user=$('#table-1').DataTable({
      stateSave: true,
      processing : true,
      serverSide : true,
        pageLength:20,
        bFilter:false,
        ajax : {
          url:"{{ url('home/load-data') }}",
          data: function (d) {
            return $.extend( {}, d, {

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
  });

</script>
@endpush