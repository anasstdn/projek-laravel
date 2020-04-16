@extends('layouts.app')

@section('content')
<div class="bg-primary-dark">
  <div class="content content-top">
    <div class="row push">
      <div class="col-md py-10 d-md-flex align-items-md-center text-center">
        <h1 class="text-white mb-0">
          <span class="font-w300">Import ke DB</span>
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
      <a class="breadcrumb-item" href="javascript:void(0)">Tools</a>
      <span class="breadcrumb-item active">Import ke DB</span>
    </nav>
  </div>
  <!-- END Breadcrumb -->

  <!-- Content -->
  <div class="content">
    <!-- Icon Navigation -->
    <!-- Dynamic Table Full Pagination -->
    <div class="block">
      <div class="block-content block-content-full">
        <!-- DataTables functionality is initialized with .js-dataTable-full-pagination class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
        <form action="{{ url('data-importData') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}

            {{-- <label class="col-sm-2 control-label">Import to DB</label> --}}
            <div class="row col-lg-5" style="margin-bottom:1em;font-family: sans-serif;font-weight: bold">
              <div class="col-lg-7">
                <span>Upload File</span>
              </div>
              <div class="col-lg-1">
                :
              </div>
              <div class="col-lg-4" style="text-align:left">
               <button type="button" class="btn btn-primary mr-5 mb-5" onclick="document.getElementById('import_file').click();">
                <i class="fa fa-upload mr-5"></i>Pilih File
              </button>
              <label id="fileLabel"></label>
            </div>
          </div>
          <input type="file" style="display: none" class="" name="import_file" id="import_file">
            <div class="col-sm-3">
             <div class="text-left">
              <button type="submit" name="submit" class="btn btn-success">Simpan</button>
            </div>
          </div>


      </form>
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
$(document).ready(function(){
   $("#import_file").change(function () {
      if(fileExtValidate(this)) { // file extension validation function
         if(fileSizeValidate(this)) { // file size validation function
          // showImg(this);
          var a = document.getElementById('import_file');
          var theSplit = a.value.split('\\');
          fileLabel.innerHTML = theSplit[theSplit.length-1];
         }   
      }    
    });
})


var validExt = ".xls, .xlsx";
function fileExtValidate(fdata) {
   var filePath = fdata.value;
   var getFileExt = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();
   var pos = validExt.indexOf(getFileExt);
   console.log(getFileExt);
   if(pos < 0) {
      toastr.warning('Silahkan upload file ekstensi .xls atau .xlsx','')
      // alert("This file is not allowed, please upload valid file.");
      fdata.value='';
      return false;
  } else {
      return true;
  }
}
//function for validate file size 
var maxSize = '20000';
function fileSizeValidate(fdata) 
{
   if (fdata.files && fdata.files[0]) 
   {
      var fsize = fdata.files[0].size/1024;
      if(fsize > maxSize) 
      {
         toastr.warning('Ukuran file maksimum melebihi 20000 KB. Ukuran file saat ini sebesar: '+fsize+' KB');
         fdata.value='';
         return false;
     } 
     else 
     {
        return true;
    }
  }
}


</script>
@endpush
