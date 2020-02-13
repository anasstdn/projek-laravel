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
   {{--  <div class="boxes">
  <input type="checkbox" id="box-1">
  <label for="box-1">Sustainable typewriter cronut</label>

  <input type="checkbox" id="box-2" checked>
  <label for="box-2">Gentrify pickled kale chips </label>

  <input type="checkbox" id="box-3">
  <label for="box-3">Gastropub butcher</label>
</div> --}}
{{ Form::model($role,array('route' => array((!$role->exists) ? 'role.createpermissionrole':'role.createpermissionrole',$role->id),
  'class'=>'','id'=>'role-form','method'=>(!$role->exists) ? 'POST' : 'POST')) }}

    <div class="col-lg-12">
      <div class="panel panel-gradient" data-collapsed="0">
        <div class="panel-heading">
          <div class="panel-title pull-left">Edit Permissions
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
          <hr/>
          <div class="text-right">
            <button class="btn btn-primary" id="simpan">Save</button>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
 {{ Form::close() }}
</div>
 <div class="modal fade" id="formModal" aria-hidden="true" aria-labelledby="formModalLabel" role="dialog" tabindex="-1">
 </div>
 <div class="modal fade" id="formModal1" aria-hidden="true" aria-labelledby="formModalLabel" role="dialog" tabindex="-1">
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