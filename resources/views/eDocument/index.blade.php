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
                            <div class="table-responsive">
                                @can('upload file')                                
                                    <a href= "/upload" class="btn btn-info waves-effect waves-themed float-right"><i class="fal fa-upload"></i> Upload</a>
                                @endcan

                                @foreach ($count as $c)
                                    @php $i = 1; @endphp
                                   <h5 style="margin-top: 10px;"><b> {{$c->name}}</b></h5><br>
                                    <table id="list" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr class="bg-primary-50 text-center">
                                                <th class="text-center">No</th>
                                                <th class="text-center">Document</th>
                                                <th class="text-center">Category</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($c->document_count != 0)
                                                @foreach ($list->where('department_id',$c->id) as $l)
                                                    <tr>
                                                        <td class="text-center col-md-1">{{$i}}</td>
                                                        <td><a target="_blank" href="/get-doc/{{$l->id}}">{{$l->title}}</a></td>
                                                        <td class="text-center col-md-2">{{ isset($l->category) ? $l->getCategory->description : 'N/A' }}</td>
                                                        <td class="text-center col-md-2">
                                                            <a href="/get-doc/{{$l->id}}" class="btn btn-sm btn-primary" download="{{$l->title}}"><i class="fal fa-download"></i></a>
                                                            
                                                            @if( ($admins->whereIn('department_id',$c->id)->count() > 0) || ($superAdmin->count() > 0)) 
                                                                <a href="#" data-target="#edit" data-toggle="modal" data-id="{{$l->id}}" data-title="{{$l->title}}" data-category="{{$l->category}}"
                                                                class="btn btn-sm btn-success"><i class="fal fa-pencil"></i></a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @php $i++; @endphp
                                                @endforeach

                                            @else
                                                <tr><td colspan="4" class="text-center text-danger"><b>NO DOCUMENTS UPLOADED</b></td></tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <br>
                                @endforeach
                            </div>
                            @can('upload file')
                                <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                                    <a href="/upload" class="btn btn-info waves-effect waves-themed float-right" style="margin-bottom: 10px;"><i class="fal fa-upload"></i> Upload</a>
                                </div>
                            @endcan
                        </div>
                    </div>

                    <div class="modal fade" id="edit" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="card-header">
                                    <h5 class="card-title w-100">Edit</h5>
                                </div>
                                <div class="modal-body">
                                {!! Form::open(['action' => 'DocumentManagementController@edit', 'method' => 'POST']) !!}
                                <input type="hidden" name="id" id="id">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Title</span>
                                            </div>
                                            <input class="form-control"  name="title" id="title">
                                        </div>
                                    </div>
            
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Category</span>
                                            </div>
                                            <select class="custom-select form-control" name="category" id="category">
                                                <option disabled selected value="">Select Category</option>
                                                @foreach ($category as $c)
                                                    <option value="{{$c->id}}">{{$c->description}}</option>
                                                @endforeach
                                             </select>
                                        </div>
                                    </div>
            
                                    <div class="footer">
                                        <button type="submit" id="btn_search" class="btn btn-primary ml-auto float-right waves-effect waves-themed"><i class="fal fa-save"></i> Save</button>
                                        <button type="button" class="btn btn-success ml-auto float-right mr-2 waves-effect waves-themed" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
            
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
<script>
        $(document).ready(function()
    {
        $('#edit').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) 
        var id = button.data('id') // data-id
        var title = button.data('title') // data-title
        var category = button.data('category') // data-category

        $('.modal-body #id').val(id);
        $('.modal-body #title').val(title);
        $('.modal-body #category').val(category);

        });
    });

</script>
@endsection
