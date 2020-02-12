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
          <div class="panel-title pull-left">Permissions
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
           <table class="table table-bordered datatable" id="table-1">
            <thead>
              <tr>
                <th>No</th>
                <th>Name</th>
                <th>Display Name</th>
                <th>Description</th>
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
  var permission;
  $(document).ready(function(){
    permission=$('#table-1').DataTable({
      stateSave: true,
      processing : true,
      serverSide : true,
        // pageLength:20,
        ajax : {
          url:"{{ url('permission/load-data') }}",
          data: function (d) {

          }
        },
        columns: [
        { data: 'nomor', name: 'nomor',searchable:false,orderable:false },
        { data: 'name', name: 'name' },
        { data: 'display_name', name: 'display_name' },
        { data: 'description', name: 'description' },
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


function reload_table()
{
    permission.ajax.reload(null,false); //reload datatable ajax 
}


</script>
@endpush
