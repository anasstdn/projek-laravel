@extends('layouts.app')

@section('content')
{{-- {{dd('aaaa')}} --}}
{{-- <div class="container"> --}}
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-gradient" data-collapsed="0">
        <div class="panel-heading">
          <div class="panel-title">Users</div>

          <div class="panel-options">
            <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
            <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
            <a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
          </div>
        </div>

        <div class="panel-body">
          <div class="panel-body">
           <table class="table table-bordered datatable" id="table-1">
            <thead>
              <tr>
                <th>No</th>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Verified</th>
              </tr>
            </thead>
            
          </table>
        </div>
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
        // pageLength:20,
        ajax : {
          url:"{{ url('user/load-data') }}",
          data: function (d) {

          }
        },
        columns: [
        { data: 'nomor', name: 'nomor',searchable:false,orderable:false },
        { data: 'username', name: 'username' },
        { data: 'name', name: 'name' },
        { data: 'email', name: 'email' },
        // { data: 'role', name: 'role',searchable:false,orderable:false },
        { data: 'verified', name: 'verified',searchable:false,orderable:false , "render":function(data,type,row){
          if(data.status_aktif==1)
          {
            return '<a class="btn btn-success btn-xs" href="#" style="color:white;font-family:Arial" title="Nonaktifkan User" onclick="con(\'' + data.id + '\',\'' + data.status_aktif + '\')">Verified</a>';
          }
          else
          {
            return '<a class="btn btn-danger btn-xs" href="#" style="color:white;font-family:Arial" title="Aktifkan User" onclick="con(\'' + data.id + '\',\'' + data.status_aktif + '\')">Not Verified</a>';
          }
        }},
        // { data: 'verified', name: 'verified' },
        // { data: 'password', name: 'password' },
        // { data: 'remember_token', name: 'remember_token' },
        // { data: 'created_at', name: 'created_at' },
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
