@extends('layouts.app')

@section('content')
<div class="bg-image" style="background-image: url('{{asset('codebase/')}}/src/assets/media/photos/photo8@2x.jpg');">
  <div class="content content-top">
    <div class="row push">
      <div class="col-md py-10 d-md-flex align-items-md-center text-center">
        <h1 class="text-white mb-0">
          <span class="font-w300">Settings</span>
        </h1>
      </div>
    </div>
  </div>
</div>
<!-- END Header -->
<div class="bg-white">
     <div class="content">
    <nav class="breadcrumb mb-0">
      <a class="breadcrumb-item" href="javascript:void(0)">Settings</a>
    </nav>
  </div>
 <div class="content">
    <!-- Icon Navigation -->
     <!-- Dynamic Table Full Pagination -->
                    <div class="block">
        <div class="form-group row">
            <div class="col-md-8 col-md-offset-2">

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="post" action="{{ route('settings.store') }}" class="form-horizontal" role="form">
                    {!! csrf_field() !!}

                    @if(count(config('setting_fields', [])) )

                        @foreach(config('setting_fields') as $section => $fields)
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <i class="{{ array_get($fields, 'icon', 'glyphicon glyphicon-flash') }}"></i>
                                    {{ $fields['title'] }}
                                </div>

                                <div class="panel-body">
                                    <p class="text-muted">{{ $fields['desc'] }}</p>
                                </div>

                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-7  col-md-offset-2">
                                            @foreach($fields['elements'] as $field)
                                                @includeIf('setting.fields.' . $field['type'] )
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- end panel for {{ $fields['title'] }} -->
                        @endforeach

                    @endif

                    <div class="row m-b-md">
                        <div class="col-md-12">
                            <button class="btn-primary btn">
                                Save Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection