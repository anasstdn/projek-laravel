@extends('layouts.app')

@section('content')
{{-- {{dd('aaaa')}} --}}
{{-- <div class="container"> --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-gradient" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">Import / Export to Database</div>

                    <div class="panel-options">
                        <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                        <a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
                    </div>
                </div>

                <div class="panel-body">
                    <p><h4><b>Import to DB (xlsx)</b></h4></p>
                    <form action="{{ url('data-importData') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            {{-- <label class="col-sm-2 control-label">Import to DB</label> --}}
                            <div class="col-sm-4">

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
                <hr/>
                 <p><h4><b>Export from DB</b></h4></p>
                <a href="{{ url('downloadData/xlsx') }}"><button class="btn btn-dark">Download Excel xlsx</button></a>
                <a href="{{ url('downloadData/xls') }}"><button class="btn btn-success">Download Excel xls</button></a>
                <a href="{{ url('downloadData/csv') }}"><button class="btn btn-info">Download CSV</button></a>
            </div>
        </div>
    </div>
</div>
{{-- </div> --}}
@endsection
