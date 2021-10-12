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
                                        <th>CLAIM HOUR(S)</th>
                                        <th>TOTAL PARTICIPANT</th>
                                        <th>OPEN ATTENDANCE</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Title"></td>
                                        <td class="hasinput">
                                            <select id="data_type" name="data_type" class="form-control">
                                                <option value="">All</option>
                                                @foreach($data_type as $data_types)
                                                    <option value="{{$data_types->type_name}}">{{ $data_types->type_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="hasinput">
                                            <select id="data_category" name="data_category" class="form-control">
                                                <option value="">All</option>
                                                @foreach($data_category as $data_categorys)
                                                    <option value="{{$data_categorys->category_name}}">{{ $data_categorys->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Date"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Venue"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Hours"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Participant"></td>
                                        <td class="hasinput"></td>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i>NEW TRAINING INFO</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'TrainingController@storeTraining', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <table class="table">
                        <thead>
                            <p><span class="text-danger">*</span> Required fields</p>
                            <tr>
                                <div class="form-group">
                                    <td width="12%"><label class="form-label" for="title"><span class="text-danger">*</span> Title :</label></td>
                                    <td colspan="4"><input value="{{ old('title') }}" class="form-control" id="title" name="title" style="text-transform: uppercase" required>
                                        @error('title')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td width="12%"><label class="form-label" for="start_date"><span class="text-danger">*</span>  Start Date :</label></td>
                                    <td colspan="2"><input type="date" class="form-control" id="start_date" name="start_date" required>
                                        @error('start_date')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                    <td width="12%"><label class="form-label" for="end_date"><span class="text-danger">*</span>  End Date :</label></td>
                                    <td colspan="2"><input type="date" class="form-control" id="end_date" name="end_date" required>
                                        @error('end_date')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td width="12%"><label class="form-label" for="start_time"><span class="text-danger">*</span>  Start Time :</label></td>
                                    <td colspan="2"><input type="time" class="form-control" id="start_time" name="start_time" required>
                                        @error('start_time')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                    <td width="12%"><label class="form-label" for="end_time"><span class="text-danger">*</span>  End Time :</label></td>
                                    <td colspan="2"><input type="time" class="form-control" id="end_time" name="end_time" required>
                                        @error('end_time')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td width="12%"><label class="form-label" for="type"><span class="text-danger">*</span>  Type :</label></td>
                                    <td colspan="2">
                                        <select name="type" id="type" class="form-control" required>
                                            <option value="">Please Select</option>
                                            @foreach ($data_type as $type) 
                                                <option value="{{ $type->id }}" {{ old('type') ? 'selected' : '' }}>{{ $type->type_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('type')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                    <td width="12%"><label class="form-label" for="category"><span class="text-danger">*</span>  Category :</label></td>
                                    <td colspan="2">
                                        <select name="category" id="category" class="form-control" required>
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
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td width="12%"><label class="form-label" for="venue"><span class="text-danger">*</span> Venue :</label></td>
                                    <td colspan="4"><input value="{{ old('venue') }}" class="form-control" id="venue" name="venue" style="text-transform: uppercase" readonly>
                                        @error('venue')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                            </tr>
                            <tr class="eval">
                                <div class="form-group">
                                    <td width="12%"><label class="form-label" for="evaluation"><span class="text-danger">*</span> Evaluation :</label></td>
                                    <td colspan="4">
                                        <select name="evaluation" id="evaluation" class="form-control">
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
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td width="12%"><label class="form-label"><span class="text-danger">*</span> Claim Hours :</label></td>
                                    <td colspan="2">
                                        <input type="number" step="any" class="form-control" id="claim_hour" name="claim_hour" value="{{ old('claim_hour') }}" required>
                                        @error('claim_hour')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                    <td width="12%"><label class="form-label" for="upload_image"> Image : <i class="fal fa-info-circle fs-xs mr-1" data-toggle="tooltip" data-placement="right" title="" data-original-title="Banner / Poster / Any image related to the training (.jpg, .png)"></i></label></td>
                                    <td colspan="2">
                                        <input type="file" class="form-control" id="upload_image" name="upload_image">
                                        @error('upload_image')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                            </tr>
                        </thead>
                    </table>
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

    $(document).ready(function()
    {
        $('#data_type, #data_category, #data_evaluation').select2();

        $(".eval").hide();

        $( "#type" ).change(function() {
            var val = $("#type").val();
            if(val=="1" || val=="2"){
                $(".eval").show();
            } else {
                $(".eval").hide();
            }
        });

        $('#type').val('{{ old('type') }}'); 
        $("#type").change(); 
        $('#evaluation').val('{{ old('evaluation') }}');

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
                    { className: 'text-center', data: 'venue', name: 'venue' },
                    { className: 'text-center', data: 'claim_hour', name: 'claim_hour' },
                    { className: 'text-center', data: 'participant', name: 'id' },
                    { className: 'text-center', data: 'open', name: 'open', orderable: false, searchable: false},
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 4, "desc" ]],
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
