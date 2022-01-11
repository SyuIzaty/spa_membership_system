@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-cogs'></i> TRAINING DETAILS
        </h1>
    </div>

        <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2 style="font-size: 20px;">
                            TRAINING ID : #{{ $train->id }}
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

                                <div class="col-sm-12 col-md-4 mb-4">
                                    {!! Form::open(['action' => ['TrainingController@updateTraining'], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
                                    {{Form::hidden('id', $train->id)}}
                                        <div class="card card-primary card-outline">
                                            <div class="card-header">
                                                <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i>TRAINING INFO</h5>
                                            </div>
                                            <div class="card-body">
                                                @if (Session::has('notification'))
                                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('notification') }}</div>
                                                @endif
                                                <div class="table-responsive">
                                                    <table id="asset" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                        <thead>
                                                            <div style="float: right"><i><b>Updated Date : </b>{{ date(' j F Y | h:i:s A', strtotime($train->updated_at) )}}</i></div><br>
                                                            <p style="margin-bottom: -15px"><span class="text-danger">*</span> Required fields</p>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="title"><span class="text-danger">*</span> Title : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="title" name="title" value="{{ $train->title }}" required>
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="start_date"><span class="text-danger">*</span>  Start Date : </label></td>
                                                                    <td colspan="3">
                                                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ isset($train->start_date) ? date('Y-m-d', strtotime($train->start_date)) : old('start_date') }}" required>
                                                                        @error('start_date')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="end_date"><span class="text-danger">*</span>  End Date : </label></td>
                                                                    <td colspan="3">
                                                                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ isset($train->end_date) ? date('Y-m-d', strtotime($train->end_date)) : old('end_date') }}" required>
                                                                        @error('end_date')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="start_time"><span class="text-danger">*</span>  Start Time : </label></td>
                                                                    <td colspan="3">
                                                                        <input type="time" class="form-control" id="start_time" name="start_time" value="{{ isset($train->start_time) ? date('h:i', strtotime($train->start_time)) : old('start_time') }}" required>
                                                                        @error('start_time')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="end_time"><span class="text-danger">*</span>  End Time : </label></td>
                                                                    <td colspan="3">
                                                                        <input type="time" class="form-control" id="end_time" name="end_time" value="{{ isset($train->end_time) ? date('h:i', strtotime($train->end_time)) : old('end_time') }}" required>
                                                                        @error('end_time')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="type"><span class="text-danger">*</span>  Type : </label></td>
                                                                    <td colspan="3">
                                                                        <select class="form-control" name="type" id="type" required>
                                                                            <option value="">Please Select</option>
                                                                            @foreach ($data_type as $types) 
                                                                                <option value="{{ $types->id }}" {{ $train->type == $types->id ? 'selected="selected"' : '' }}>{{ strtoupper($types->type_name) }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('type')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="category"><span class="text-danger">*</span>  Category : </label></td>
                                                                    <td colspan="3">
                                                                        <select class="form-control" name="category" id="category" required>
                                                                            <option value="">Please Select</option>
                                                                            @foreach ($data_category as $categories) 
                                                                                <option value="{{ $categories->id }}" {{ $train->category == $categories->id ? 'selected="selected"' : '' }}>{{ strtoupper($categories->category_name) }}</option>
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
                                                                    <td width="25%"><label class="form-label" for="venue"><span class="text-danger">*</span>  Venue : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="venue" name="venue" value="{{ $train->venue }}" required>
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="link">  Link : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="link" name="link" value="{{ $train->link }}">
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="claim_hour"><span class="text-danger">*</span>  Claim Hours : </label></td>
                                                                    <td colspan="3">
                                                                        <input type="number" step="any" class="form-control" id="claim_hour" name="claim_hour" value="{{ $train->claim_hour }}" required>
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr class="eval">
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="evaluation"><span class="text-danger">*</span> Evaluation : </label></td>
                                                                    <td colspan="3">
                                                                        <select class="form-control" name="evaluation" id="evaluation" required>
                                                                            <option value="">Please Select</option>
                                                                            @foreach ($data_evaluation as $evaluates) 
                                                                                <option value="{{ $evaluates->id }}" {{ $train->evaluation == $evaluates->id ? 'selected="selected"' : '' }}>{{ strtoupper($evaluates->evaluation) }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('evaluation')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr class="eval">
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="evaluation_status"><span class="text-danger">*</span> Evaluation Status : </label></td>
                                                                    <td colspan="3">
                                                                        <select class="form-control" name="evaluation_status" id="evaluation_status" required>
                                                                            <option value="">Please Select</option>
                                                                            <option value="1" {{ old('evaluation_status', $train->evaluation_status) == '1' ? 'selected':''}} >OPEN</option>
                                                                            <option value="0" {{ old('evaluation_status', $train->evaluation_status) == '0' ? 'selected':''}} >CLOSE</option>
                                                                        </select>
                                                                        @error('evaluation_status')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="upload_image"> Upload Image : </label></td>
                                                                    <td colspan="3">
                                                                        <input type="file" class="form-control" id="upload_image" name="upload_image">
                                                                        @error('upload_image')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label"> Total Participant : </label></td>
                                                                    <td colspan="3">
                                                                        <?php
                                                                            $data = \App\TrainingClaim::where('status', '2')->where('training_id', $train->id)->count();
                                                                        ?>
                                                                        @if($data == '0') 
                                                                            <p style="color : red"><b>NO PARTICIPANT</b></p>
                                                                        @else 
                                                                            <p><b>{{ $data }}</b></p>
                                                                        @endif
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                    <br>
                                                    <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                                    <a style="margin-right:5px" href="/training-list" class="btn btn-success ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a><br><br>
                                                </div>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
                                </div>

                                <div class="col-md-8 col-sm-12">
                                    {{-- Image --}}
                                    <div class="accordion accordion-outline" id="js_demo_accordion-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#image" aria-expanded="false">
                                                    <i class="fal fa-camera width-2 fs-xl"></i>
                                                    TRAINING IMAGE
                                                    <span class="ml-auto">
                                                        <span class="collapsed-reveal">
                                                            <i class="fal fa-minus fs-xl"></i>
                                                        </span>
                                                        <span class="collapsed-hidden">
                                                            <i class="fal fa-plus fs-xl"></i>
                                                        </span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div id="image" class="collapse" data-parent="#image">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <table id="assets" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                                <thead>
                                                                    <tr align="center">
                                                                        @if(isset($train->upload_image))
                                                                            <td colspan="5">
                                                                                <a data-fancybox="gallery" href="/get-train-image/{{ $train->upload_image }}"><img src="/get-train-image/{{ $train->upload_image }}" style="width:100%" class="img-fluid mr-2"></a><br><br>
                                                                            </td>
                                                                        @else
                                                                            <span>No Image Uploaded</span>
                                                                        @endif
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Participant --}}
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h5 class="card-title w-100"><i class="fal fa-users width-2 fs-xl"></i>LIST OF PARTICIPANT
                                                @if($participant->first() != null)
                                                    <a data-page="/training-pdf/{{ $train->id }}" class="float-right" style="cursor: pointer" onclick="Print(this)"><i class="fal fa-file-pdf" style="color: red; font-size: 20px"></i></a>
                                                @endif
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="log" class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr class="bg-primary-50 text-center" style="white-space: nowrap">
                                                            <th>NO</th>
                                                            <th>TICKET #ID</th>
                                                            <th>ID</th>
                                                            <th>NAME</th>
                                                            <th>POSITION</th>
                                                            <th>DEPARTMENT</th>
                                                            <th>EVALUATION</th>
                                                        </tr>
                                                        <tr>
                                                            <td class="hasinput"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Ticket"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search ID"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Name"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Position"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Department"></td>
                                                            <td class="hasinput"></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($participant as $key => $parts)
                                                            <tr style="text-transform: uppercase">
                                                                <td class="text-center">{{ $no++ }}</td>
                                                                <td class="text-center">{{ $parts->id }}</td>
                                                                <td class="text-center">{{ $parts->staff_id ?? '--' }}</td>
                                                                <td>{{ $parts->staffs->staff_name ?? '--' }}</td>
                                                                <td class="text-center">{{ $parts->staffs->staff_position ?? '--' }}</td>
                                                                <td class="text-center">{{ $parts->staffs->staff_dept ?? '--' }}</td>
                                                                <td class="text-center">
                                                                    @if($train->id == '0') {{-- others --}}
                                                                        <button class="btn btn-xs btn-secondary" disabled style="pointer-events: none"><i class="fal fa-link"></i></button>
                                                                    @else {{-- list --}}
                                                                        @if($train->type == '1' || $train->type == '2') {{-- internal --}}
                                                                            @if(\App\TrainingList::where('id', $train->id)->whereNotNull('evaluation')->first()) {{-- evaluation in training not null --}}
                                                                                {{-- exist and evaluation close but can view --}}
                                                                                <a href="/training-evaluation/{{ $train->id }}/{{ $parts->staff_id }}" class="btn btn-info btn-xs" target="_blank"><i class="fal fa-link"></i></a>  
                                                                            @else 
                                                                                <button class="btn btn-xs btn-secondary" disabled style="pointer-events: none"><i class="fal fa-link"></i></button>
                                                                            @endif
                                                                        @else  {{-- external --}}
                                                                            <button class="btn btn-xs btn-secondary" disabled style="pointer-events: none"><i class="fal fa-link"></i></button>
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div>
                                    </div>
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
        $('#evaluation, #type, #category, #evaluation_status').select2();

        $('#log thead tr .hasinput').each(function(i)
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
        });

        var table = $('#log').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [[ 3, "desc" ]],
                "initComplete": function(settings, json) {
                }
        });

        $(".eval").hide();

        $("#type").change(function() {
            var val = $("#type").val();
            if(val=="1" || val=="2" || val=="3" || val=="4"){
                $(".eval").show();
            } else {
                $(".eval").hide();
            }
        });

        $('#type').val(); 
        $("#type").change(); 
        $('#evaluation').val().change();
        $('#evaluation_status').val().change();
 
    })

    function Print(button)
    {
        var url = $(button).data('page');
        var printWindow = window.open( '{{url("/")}}'+url+'', 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
        printWindow.addEventListener('load', function(){
            printWindow.print();
        }, true);
    }

</script>

@endsection
