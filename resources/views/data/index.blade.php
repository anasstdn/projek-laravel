@extends('layouts.app')

@section('content')
<div class="bg-image" style="background-image: url('{{asset('codebase/')}}/src/assets/media/photos/photo8@2x.jpg');">
  <div class="content content-top">
    <div class="row push">
      <div class="col-md py-10 d-md-flex align-items-md-center text-center">
        <h1 class="text-white mb-0">
          <span class="font-w300">Import to DB</span>
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
      <a class="breadcrumb-item" href="javascript:void(0)">Tools</a>
      <span class="breadcrumb-item active">Import / Export to DB</span>
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
                        <div class="form-group">
                            {{-- <label class="col-sm-2 control-label">Import to DB</label> --}}
                            <div class="col-sm-12">

                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <span class="btn btn-info btn-file">
                                        <span class="fileinput-new">Select file</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="import_file">
                                    </span>
                                    <span class="fileinput-filename"></span>
                                    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                                </div>

                            </div>
                            <div class="col-sm-3">
                               <div class="text-left">
                                <button type="submit" name="submit" class="btn btn-success">Upload</button>
                            </div>
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



</script>
@endpush
