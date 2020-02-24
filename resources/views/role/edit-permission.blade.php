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

  .boxes {
  margin: auto;
/*  padding: 50px;
  background: #484848;*/
}

/*Checkboxes styles*/
input[type="checkbox"] { display: none; }

input[type="checkbox"] + label {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 20px;
  font: 14px/20px 'Open Sans', Arial, sans-serif;
  color: #4CAF50;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
}

input[type="checkbox"] + label:last-child { margin-bottom: 0; }

input[type="checkbox"] + label:before {
  content: '';
  display: block;
  width: 20px;
  height: 20px;
  border: 1px solid #4CAF50;
  position: absolute;
  left: 0;
  top: 0;
  opacity: .6;
  -webkit-transition: all .12s, border-color .08s;
  transition: all .12s, border-color .08s;
}

input[type="checkbox"]:checked + label:before {
  width: 10px;
  top: -5px;
  left: 5px;
  border-radius: 0;
  opacity: 1;
  border-top-color: transparent;
  border-left-color: transparent;
  -webkit-transform: rotate(45deg);
  transform: rotate(45deg);
}

  </style>
<div class="bg-primary-dark">
<div class="content content-top">
<div class="row push">
<div class="col-md py-10 d-md-flex align-items-md-center text-center">
<h1 class="text-white mb-0">
<span class="font-w300">Edit Roles</span>
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
      <a class="breadcrumb-item" href="javascript:void(0)">Roles</a>
      <span class="breadcrumb-item active">Edit Roles</span>
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
                   {{ Form::model($role,array('route' => array((!$role->exists) ? 'role.createpermissionrole':'role.createpermissionrole',$role->id),
  'class'=>'','id'=>'role-form','method'=>(!$role->exists) ? 'POST' : 'POST')) }}


           <table class="table table-bordered table-striped table-vcenter" id="table-1">
            <thead>
              <tr>
                <th>No</th>
                <th>Permission Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($permissionmenu as $num =>$row )
              <tr>
                <td>{{$num+1}}</td>
                <td> {{ $row['nama_perm'] }}</td>
                <?php
                $check=\App\Models\PermissionRole::select('*')
                ->where('permission_id',$row['id_perm'])
                ->where('role_id',$role_id)
                ->first();
                ?>
                <td >
                 <div class="boxes">
                  @if($check != null)
                  <input type="checkbox" id="{{$num}}" name="role[{{ $num }}][flag_aktif]" onchange="check();" checked>
                  <label id="active_{{$num}}" for="{{$num}}">Active</label>
                  @else
                  <input type="checkbox" id="{{$num}}" onchange="check();" name="role[{{ $num }}][flag_aktif]">
                  <label id="active_{{$num}}" for="{{$num}}">Inactive</label>
                  @endif
                </div>
              </td>
              <input type="hidden" name="role[{{ $num }}][id_perm]" value="{{ $row['id_perm'] }}" class="checkbox-custom checkbox-default"> 
              </tr>
              @endforeach
              <input type="hidden" name="role_id" value="{{ $role_id }}" class="checkbox-custom checkbox-default">
            </tbody>
            
          </table>
          <div class="text-right">
            <button class="btn btn-primary" id="simpan">Save</button>
          </div>
 {{ Form::close() }}
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
{{-- </div> --}}
@endsection

@push('js')
<script>
$(document).ready(function(){
  // $('#table-1').DataTable();
  check();
})

function check()
{
  $('table > tbody  > tr').each(function(index, tr) { 
    if($('#'+index+'').is(':checked')==true)
    {
      $('#active_'+index).html('Active');
    }
    else
    {
      $('#active_'+index).html('Inactive');
    }
});
}
</script>
@endpush