@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-folder'></i> eDocument Management
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Document List</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            
                            <div class="table-responsive" style="padding: 0 25px; margin-top: 10px;">
                                @role('eDocument (Admin)|eDocument (IT)|eDocument (Finance)|eDocument (Corporate)|eDocument (Academic)|eDocument (Operation)|eDocument (Marketing)')
                                <a href= "/upload" class="btn btn-info waves-effect waves-themed float-right" style="margin-bottom: 5px;"><i class="fal fa-upload"></i> Upload</a>
                                @endrole

                                @foreach ($department as $d)
                                    @php $i = 1; @endphp
                                   <h5> <i class='fal fa-caret-right'></i><b> {{$d->name}}</b></h5><br>
                                    <table id="list" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr class="bg-primary-50 text-center">
                                                <th class="text-center">No</th>
                                                <th class="text-center">Document</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($list->where('department_id',$d->id)->isNotEmpty())
                                                @foreach ($list->where('department_id',$d->id) as $l)
                                                    <tr>
                                                        <td class="text-center">{{$i}}</td>
                                                        <td><a target="_blank" href="/get-doc/{{$l->id}}">{{$l->title}}</a></td>
                                                    </tr>
                                                    @php $i++; @endphp
                                                @endforeach

                                            @else
                                                <tr><td colspan="2" class="text-center text-danger"><b>NO DOCUMENTS UPLOADED</b></td></tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <br>
                                @endforeach
                            </div>
                            
                            @role('eDocument (Admin)|eDocument (IT)|eDocument (Finance)|eDocument (Corporate)|eDocument (Academic)|eDocument (Operation)|eDocument (Marketing)')
                                    <a href= "/upload" class="btn btn-info waves-effect waves-themed float-right" style="margin: -25px 25px 15px;"><i class="fal fa-upload"></i> Upload</a>
                            @endrole
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
<script>
</script>
@endsection
