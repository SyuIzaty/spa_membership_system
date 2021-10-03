@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-clipboard-list'></i>TRAINING LIST MANAGEMENT
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        TRAINING <span class="fw-300"><i>LIST</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-sm-6 col-xl-4">
                                <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            {{ \App\TrainingList::all()->count() }}
                                            <small class="m-0 l-h-n">TOTAL OVERALL TRAINING</small>
                                        </h3>
                                    </div>
                                    <i class="fal fa-cubes position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-4">
                                <div class="p-3 bg-primary-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            {{ \App\TrainingList::whereDate('start_date', '>=', \Carbon\Carbon::today())->get()->count() }}
                                            <small class="m-0 l-h-n">ACTIVE TRAINING</small>
                                        </h3>
                                    </div>
                                    <i class="fal fa-cube position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                        </div>
                        @if (Session::has('message'))
                            <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                        @endif
                        @if (Session::has('notification'))
                            <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('notification') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table id="train" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="text-center bg-primary-50">
                                        <th>#ID</th>
                                        <th>TITLE</th>
                                        <th>TYPE</th>
                                        <th>CATEGORY</th>
                                        <th>DATE</th>
                                        <th>VENUE</th>
                                        <th>EVALUATION</th>
                                        <th>TOTAL ATTENDEE</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Title"></td>
                                        <td class="hasinput">
                                            <select id="data_type" name="data_type" class="form-control">
                                                <option value="">All</option>
                                                @foreach($data_type as $data_types)
                                                    <option value="{{$data_types->id}}">{{ $data_types->type_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="hasinput">
                                            <select id="data_category" name="data_category" class="form-control">
                                                <option value="">All</option>
                                                @foreach($data_category as $data_categorys)
                                                    <option value="{{$data_categorys->id}}">{{ $data_categorys->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Date"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Venue"></td>
                                        <td class="hasinput">
                                            <select id="data_evaluation" name="data_evaluation" class="form-control">
                                                <option value="">All</option>
                                                @foreach($data_evaluation as $data_evaluations)
                                                    <option value="{{$data_evaluations->id}}">{{ $data_evaluations->evaluation }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Attendee"></td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex pull-right">
                        <a href="javascript:;" data-toggle="modal" id="new" class="btn btn-primary ml-auto float-right"><i class="fal fa-plus-square"></i> Add New Training</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crud-modal" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i>NEW TRAINING INFO</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'TrainingController@storeTraining', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <p><span class="text-danger">*</span> Required fields</p>

                    <div class="form-group">
                        <td width="10%"><label class="form-label" for="title"><span class="text-danger">*</span> Title :</label></td>
                        <td colspan="4"><input value="{{ old('title') }}" class="form-control" id="title" name="title" style="text-transform: uppercase" required>
                            @error('title')
                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                            @enderror
                        </td>
                    </div>
                    <div class="form-group">
                        <td width="10%"><label class="form-label" for="start_date"> Start Date :</label></td>
                        <td colspan="4"><input type="date" class="form-control" id="start_date" name="start_date">
                            @error('start_date')
                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                            @enderror
                        </td>
                    </div>
                    <div class="form-group">
                        <td width="10%"><label class="form-label" for="end_date"> End Date :</label></td>
                        <td colspan="4"><input type="date" class="form-control" id="end_date" name="end_date">
                            @error('end_date')
                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                            @enderror
                        </td>
                    </div>
                    <div class="form-group">
                        <td width="10%"><label class="form-label" for="type"> Type :</label></td>
                        <td colspan="4">
                            <select name="type" id="type" class="form-control">
                                <option value="">Please Select</option>
                                @foreach ($data_type as $type) 
                                    <option value="{{ $type->id }}" {{ old('type') ? 'selected' : '' }}>{{ $type->type_name }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                            @enderror
                        </td>
                    </div>
                    <div class="form-group">
                        <td width="10%"><label class="form-label" for="category">Category :</label></td>
                        <td colspan="4">
                            <select name="category" id="category" class="form-control">
                                <option value="">Please Select</option>
                                @foreach ($data_category as $category) 
                                    <option value="{{ $category->id }}" {{ old('category') ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                            @enderror
                        </td>
                    </div>
                    <div class="form-group">
                        <td width="10%"><label class="form-label" for="venue"> Venue :</label></td>
                        <td colspan="4"><input value="{{ old('venue') }}" class="form-control" id="venue" name="venue" style="text-transform: uppercase">
                            @error('venue')
                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                            @enderror
                        </td>
                    </div>
                    <div class="form-group">
                        <td width="10%"><label class="form-label" for="evaluation"><span class="text-danger">*</span> Evaluation Form :</label></td>
                        <td colspan="4">
                            <select name="evaluation" id="evaluation" class="form-control" required>
                                <option value="">Please Select</option>
                                @foreach ($data_evaluation as $evaluate) 
                                    <option value="{{ $evaluate->id }}" {{ old('evaluation') ? 'selected' : '' }}>{{ $evaluate->evaluation }}</option>
                                @endforeach
                            </select>
                            @error('evaluation')
                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                            @enderror
                        </td>
                    </div>
                    <div class="form-group">
                        <td width="10%"><label class="form-label" for="upload_image"> Image :</label></td>
                        <td colspan="4">
                            <input type="file" class="form-control" id="upload_image" name="upload_image">
                            @error('upload_image')
                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                            @enderror
                        </td>
                    </div>
                     
                    <div class="footer">
                        <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                        <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

</main>
@endsection

@section('script')

<script>

    $('#data_type, #data_category, #data_evaluation').select2();

    $(document).ready(function()
    {
        $('#evaluation, #category, #type').select2({ 
            dropdownParent: $('#crud-modal') 
        }); 

        $('#new').click(function () {
            $('#crud-modal').modal('show');
        });

        $('#train thead tr .hasinput').each(function(i)
        {
            $('input', this).on('keyup change', function()
            {
                if (table.column(i).search() !== this.value)
                {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });

            $('select', this).on('keyup change', function()
            {
                if (table.column(i).search() !== this.value)
                {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#train').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-training",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { data: 'title', name: 'title' },
                    { className: 'text-center', data: 'type', name: 'type' },
                    { className: 'text-center', data: 'category', name: 'category' },
                    { className: 'text-center', data: 'date', name: 'start_date' },
                    { data: 'venue', name: 'venue' },
                    { data: 'evaluation', name: 'evaluation' },
                    { className: 'text-center', data: 'attendee', name: 'id' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                } 
        });

        $('#train').on('click', '.btn-delete[data-remote]', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {method: '_DELETE', submit: true}
                    }).always(function (data) {
                        $('#train').DataTable().draw(false);
                    });
                }
            })
        });

    });

</script>

@endsection
