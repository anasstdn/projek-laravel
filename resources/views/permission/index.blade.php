@extends('layouts.app')

@section('content')
<div class="bg-image" style="background-image: url('{{asset('codebase/')}}/src/assets/media/photos/photo8@2x.jpg');">
  <div class="content content-top">
    <div class="row push">
      <div class="col-md py-10 d-md-flex align-items-md-center text-center">
        <h1 class="text-white mb-0">
          <span class="font-w300">Permission</span>
        </h1>
      </div>
    </div>
  </div>
</div>

<!-- Page Content -->
<div class="bg-white">
  <!-- Breadcrumb -->
  <div class="content">
    <nav class="breadcrumb mb-0">
      <a class="breadcrumb-item" href="javascript:void(0)">Master ACL</a>
      <span class="breadcrumb-item active">Permission</span>
    </nav>
  </div>
  <!-- END Breadcrumb -->

  <!-- Content -->
  <div class="content">
    <!-- Icon Navigation -->
     <!-- Dynamic Table Full Pagination -->
                    <div class="block">
                        {{-- <div class="block-header block-header-default"> --}}
                         {{-- <a class="btn btn-sm btn-primary data-modal pull-left" style="color: white" id="data-modal" href="#" onclick="show_modal('{{ route('user.create') }}')" ><i class='si si-plus' style="color: white" aria-hidden='true'></i> Add</a> --}}
                            {{-- <h3 class="block-title">Dynamic Table <small>Full pagination</small></h3> --}}
                        {{-- </div> --}}
                        <div class="block-content block-content-full">
                          <!-- DataTables functionality is initialized with .js-dataTable-full-pagination class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                          <table class="table table-bordered table-striped table-vcenter" id="table-1">
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
                    <!-- END Dynamic Table Full Pagination -->
    
  </div>
  <!-- END Content -->
</div>
 <div class="modal fade" id="formModal" aria-hidden="true" aria-labelledby="modal-normal" role="dialog" tabindex="-1">
 </div>
 {{-- <div class="modal fade" id="formModal1" aria-hidden="true" aria-labelledby="modal-normal" role="dialog" tabindex="-1"> --}}

<!-- END Page Content -->
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
