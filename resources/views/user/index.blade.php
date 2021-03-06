@extends('layouts.app')

@section('content')
<div class="bg-primary-dark">
<div class="content content-top">
<div class="row push">
<div class="col-md py-10 d-md-flex align-items-md-center text-center">
<h1 class="text-white mb-0">
<span class="font-w300">Users</span>
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
      <a class="breadcrumb-item" href="javascript:void(0)">Master ACL</a>
      <span class="breadcrumb-item active">Users</span>
    </nav>
  </div>
  <!-- END Breadcrumb -->

  <!-- Content -->
  <div class="content">
    <!-- Icon Navigation -->
     <!-- Dynamic Table Full Pagination -->
                    <div class="block">
                        <div class="block-header block-header-default">
                         <a class="btn btn-sm btn-primary data-modal pull-left" style="color: white" id="data-modal" href="#" onclick="show_modal('{{ route('user.create') }}')" ><i class='si si-plus' style="color: white" aria-hidden='true'></i> Add</a>
                            {{-- <h3 class="block-title">Dynamic Table <small>Full pagination</small></h3> --}}
                        </div>
                        <div class="block-content block-content-full">
                            <!-- DataTables functionality is initialized with .js-dataTable-full-pagination class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                            <table class="table table-bordered table-striped table-vcenter" id="table-1">
                                <thead>
                                    <tr>
                                      <th>No</th>
                                      <th>Username</th>
                                      <th>Name</th>
                                      <th>Email</th>
                                      <th>Verified</th>
                                      <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- END Dynamic Table Full Pagination -->
    
  </div>
  <!-- END Content -->
</div>
 <div class="modal fade" id="formModal" aria-hidden="true" aria-labelledby="modal-normal" role="dialog" tabindex="-1">
 </div>
 <div class="modal fade" id="formModal1" aria-hidden="true" aria-labelledby="modal-normal" role="dialog" tabindex="-1">
 </div>
<!-- END Page Content -->
@endsection

@push('js')
<script>
  var user;
  $(document).ready(function(){
    $('.trash-ck').click(function(){
    if ($('.trash-ck').prop('checked')) {
      document.location = '{{ url("user?status=trash") }}';
    } else {
      document.location = '{{ url("user") }}';
    }
  });
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
            return '<a class="btn btn-success btn-sm" href="#" data-toggle="click-ripple" style="color:white;font-family:Arial" title="Nonaktifkan User" onclick="con(\'' + data.id + '\',\'' + data.status_aktif + '\')">Verified</a>';
          }
          else
          {
            return '<a class="btn btn-danger btn-sm" href="#" data-toggle="click-ripple" style="color:white;font-family:Arial" title="Aktifkan User" onclick="con(\'' + data.id + '\',\'' + data.status_aktif + '\')">Not Verified</a>';
          }
        }},
        // { data: 'verified', name: 'verified' },
        // { data: 'password', name: 'password' },
        // { data: 'remember_token', name: 'remember_token' },
        // { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false, searchable: false },
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
    user.ajax.reload(null,false); //reload datatable ajax 
}

function reset(url)
{
    var con = confirm('Apakah anda yakin untuk reset password?');

    if(con==true)
    {
     var token = $("meta[name='csrf-token']").attr("content");
     $.ajax({
      url : url,
      type: 'GET',
      dataType:'JSON',
      headers: {
        'X-CSRF-TOKEN': token
      },
      success:function(data){
        // console.log(data.status);
        if(data.status==true)
        {
         toastr_notif(data.msg,'sukses');
         setTimeout(function() {
    //your code to be executed after 1 second
         reload_table();
         }, 1000);
       }
       else
       {
         toastr_notif(data.msg,'gagal');
         setTimeout(function() {
    //your code to be executed after 1 second
         reload_table();
         }, 1000)
       }

     },
   });
   } 
   else
   {
    return false;
  }

}


</script>
@endpush
