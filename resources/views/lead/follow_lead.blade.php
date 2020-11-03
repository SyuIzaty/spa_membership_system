@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Follow Up 
        </h1>
    </div>

        <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2 style="font-size: 25px;">
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
                                    <div class="col-sm-4">
                                    {!! Form::open(['action' => ['LeadController@updateFollow'], 'method' => 'POST'])!!}
                                    {{Form::hidden('id', $lead->id)}}
                                        <div class="card card-primary card-outline">
                                            <div class="card-header">
                                                <h5 class="card-title w-100">LEAD PROFILE</h5>
                                            </div>
                                            
                                            <div class="card-body">
                                                @if (Session::has('message'))
                                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                            @endif
                                                <table id="new_lead" class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="16%"><label class="form-label" for="leads_name"> Name:</label></td>
                                                                <td colspan="7">
                                                                    {{ Form::text('leads_name', $lead->leads_name, ['class' => 'form-control' , 'placeholder' => 'Name']) }} <br>
                                                                        @error('leads_name')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="16%"><label class="form-label" for="leads_ic"> IC Number:</label></td>
                                                                <td colspan="7">
                                                                    {{ Form::text('leads_ic', $lead->leads_ic, ['class' => 'form-control', 'placeholder' => 'Identification Number']) }}<br>
                                                                        @error('leads_ic')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="16%"><label class="form-label" for="leads_phone"> Phone Number:</label></td>
                                                                <td colspan="7">
                                                                    {{ Form::text('leads_phone', $lead->leads_phone, ['class' => 'form-control', 'placeholder' => 'Phone Number']) }}<br>
                                                                        @error('leads_phone')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                </td>
                                                            </div>
                                                        </tr>
                    
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="16%"><label class="form-label" for="leads_email"> Email:</label></td>
                                                                <td colspan="7">
                                                                    {{ Form::email('leads_email', $lead->leads_email, ['class' => 'form-control', 'placeholder' => 'Email']) }}<br>
                                                                        @error('leads_email')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="16%"><label class="form-label" for="leads_source"> Source:</label></td>
                                                                <td colspan="7">
                                                                        <select class="form-control" name="leads_source" id="leads_source" >
                                                                            <option value="">-- Select Source --</option>
                                                                                <option name="leads_source" id="leads_source" value="Education Carnival" {{ $lead->leads_source == "Education Carnival" ? 'selected="selected"' : '' }}>Education Carnival</option>
                                                                                <option name="leads_source" id="leads_source" value="Social Media" {{ $lead->leads_source == "Social Media" ? 'selected="selected"' : '' }}> Social Media</option>
                                                                                <option name="leads_source" id="leads_source" value="Print Media" {{ $lead->leads_source == "Print Media" ? 'selected="selected"' : '' }}> Print Media</option>
                                                                                <option name="leads_source" id="leads_source" value="Broadcast Media" {{ $lead->leads_source == "Broadcast Media" ? 'selected="selected"' : '' }}> Broadcast Media</option>
                                                                                <option name="leads_source" id="leads_source" value="Family, Friends" {{ $lead->leads_source == "Family, Friends" ? 'selected="selected"' : '' }}> Family, Friends</option>
                                                                                <option name="leads_source" id="leads_source" value="Others" {{ $lead->leads_source == "Others" ? 'selected="selected"' : '' }}> Others</option>
                                                                        </select>
                                                                </td>
                                                            </div>
                                                        </tr>
                    
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="16%"><label class="form-label" for="leads_event"> Events:</label></td>
                                                                <td colspan="7">
                                                                    {{ Form::text('leads_event', $lead->leads_event, ['class' => 'form-control', 'placeholder' => 'Event']) }}<br>
                                                                        @error('leads_event')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="16%"><label class="form-label" for="edu_level"> Education Level:</label></td>
                                                                <td colspan="7">
                                                                    <select class="form-control" name="edu_level" id="edu_level" >
                                                                        <option value="">-- Select Education Level --</option>
                                                                        @foreach($qualification as $qualify)
                                                                            <option value="{{$qualify->id}}"  {{ $lead->edu_level == $qualify->id ? 'selected="selected"' : '' }} placeholder="Education Level">{{$qualify->qualification_name}}</option><br>
                                                                        @endforeach
                                                                        @error('edu_level')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </select><br>
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="16%"><label class="form-label" for="progs">Lead Programmes:</label></td>
                                                                    <td colspan="7">
                                                                        <select class="form-control" name="leads_prog1" id="leads_prog1" >
                                                                            <option value="">-- Select First Programme --</option>
                                                                            @foreach($programme as $programm)
                                                                                <option value="{{$programm->programme_code}}"  {{ $lead->leads_prog1 == $programm->programme_code ? 'selected="selected"' : '' }} placeholder="First Choice Programme">{{$programm->programme_name}}</option><br>
                                                                            @endforeach
                                                                            @error('leads_prog1')
                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                            @enderror
                                                                        </select><br>
                                                                        <select class="form-control" name="leads_prog2" id="leads_prog2" >
                                                                            <option value="">-- Select Second Programme --</option>
                                                                            @foreach($programme as $programm)
                                                                                <option value="{{$programm->programme_code}}"  {{ $lead->leads_prog2 == $programm->programme_code ? 'selected="selected"' : '' }} placeholder="Second Choice Programme">{{$programm->programme_name}}</option><br>
                                                                            @endforeach
                                                                            @error('leads_prog2')
                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                            @enderror
                                                                        </select><br>
                                                                        <select class="form-control" name="leads_prog3" id="leads_prog3" >
                                                                            <option value="">-- Select Third Programme --</option>
                                                                            @foreach($programme as $programm)
                                                                                <option value="{{$programm->programme_code}}"  {{ $lead->leads_prog3 == $programm->programme_code ? 'selected="selected"' : '' }} placeholder="Third Choice Programme">{{$programm->programme_name}}</option><br>
                                                                            @endforeach
                                                                            @error('leads_prog3')
                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                            @enderror
                                                                        </select>
                                                                    </td>
                                                            </div>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                    <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                                
                                <br>

                                <div class="col-sm-8">

                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h5 class="card-title w-100">LEAD TRACKS</h5>
                                        </div>
                                        <div class="card-body">
                                            <table id="track" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    @if(!empty($applicant) && $applicant->count() > 0)
                                                        @foreach ($applicant as $applicant)
                                                            <tr>
                                                                <div class="form-group">
                                                                        <td width="12%"><label class="form-label" for="progs">Programme 1:</label></td>
                                                                        <td colspan="2">
                                                                            <input type="text" class="form-control" value="{{ $applicant->programme->programme_name ?? '-- NO DATA --' }}" disabled></div><br>
                                                                        </td>
                                                                        <td width="12%"><label class="form-label" for="progs">Programme 2:</label></td>
                                                                        <td colspan="2">
                                                                            <input type="text" class="form-control" value="{{ $applicant->programmeTwo->programme_name ?? '-- NO DATA --' }}" disabled></div><br>
                                                                        </td>
                                                                        <td width="12%"><label class="form-label" for="progs">Programme 3:</label></td>
                                                                        <td colspan="2">
                                                                            <input type="text" class="form-control" value="{{ $applicant->programmeThree->programme_name ?? '-- NO DATA --' }}" disabled></div>
                                                                        </td>
                                                                </div>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="12%"><label class="form-label" for="intake"> Intake:</label></td>
                                                                    <td colspan="2">
                                                                        <input type="text" class="form-control"  value="{{ $applicant->applicantIntake->intake_code ?? '-- NO DATA -- ' }}" disabled>
                                                                    </td>
                                                                    <td width="12%"><label class="form-label" for="offer_prog"> Offer Programme:</label></td>
                                                                    <td colspan="2">
                                                                        <input type="text" class="form-control"  value="{{ $applicant->offeredProgramme->programme_name ?? '-- NO DATA -- ' }}" disabled>
                                                                    </td>
                                                                    <td width="12%"><label class="form-label" for="stat"> Status:</label></td>
                                                                    <td colspan="2">
                                                                        <input type="text" class="form-control"  value="{{ $applicant->status->status_description ?? '-- NO DATA -- ' }}" disabled>
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="12%"><label class="form-label" for="progs">Programme 1:</label></td>
                                                                <td colspan="2">
                                                                    <input type="text" class="form-control" value="-- NO DATA --" disabled></div>
                                                                </td>
                                                                <td width="12%"><label class="form-label" for="progs">Programme 2:</label></td>
                                                                <td colspan="2">
                                                                    <input type="text" class="form-control" value="-- NO DATA --" disabled></div>
                                                                </td>
                                                                <td width="12%"><label class="form-label" for="progs">Programme 3:</label></td>
                                                                <td colspan="2">
                                                                    <input type="text" class="form-control" value="-- NO DATA --" disabled></div>
                                                                </td>
                                                            </div>
                                                        </tr>
                                        
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="12%"><label class="form-label" for="intake"> Intake:</label></td>
                                                                <td colspan="2">
                                                                    <input type="text" class="form-control" value="-- NO DATA --" disabled>
                                                                </td>
                                                                <td width="12%"><label class="form-label" for="offer_prog"> Offer Programme:</label></td>
                                                                <td colspan="2">
                                                                    <input type="text" class="form-control" value="-- NO DATA --" disabled>
                                                                </td>
                                                                <td width="12%"><label class="form-label" for="stat"> Status:</label></td>
                                                                <td colspan="2">
                                                                    <input type="text" class="form-control" value="-- NO DATA --" disabled>
                                                                </td>
                                                            </div>
                                                        </tr>
                                                    @endif 
                                                </thead>
                                            </table>
                                        </div>

                                    </div>

                                    <br>

                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h5 class="card-title w-100">FOLLOW UP LISTS</h5>
                                        </div>
                                        
                                        <div class="card-body">
                                            <table class="table table-bordered table-hover table-striped w-100" style="table-layout:fixed">
                                                <thead>
                                                    <tr align="center" class="card-header">
                                                        <th style="width: 50px;">No.</th>
                                                        <th>Follow Up Type</th>
                                                        <th>Remarks</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        @role('sales manager|sales executive')
                                                        <th>Action</th>
                                                        @endrole
                                                    </tr>
                                                    @foreach($lead->lead_notes as $leadNotes)
                                                    <tr align="center"  class="data-row">
                                                        <td>{{ $no++ }}</td>
                                                        <td class="follow_type_id">{{$leadNotes->follow_types->follow_name}}</td>
                                                        <td class="follow_remark">{{$leadNotes->follow_remark}}</td>
                                                        <td class="follow_date">{{ date('Y-m-d | h:i A', strtotime($leadNotes->follow_date)) }}</td>
                                                        <td >
                                                            @if ($leadNotes->status_id == '0') New Lead @endif
                                                            @if ($leadNotes->status_id == '1') Ongoing @endif
                                                            @if ($leadNotes->status_id == '2') Registered @endif
                                                            @if ($leadNotes->status_id == '3') Not Show @endif
                                                            @if ($leadNotes->status_id == '4') Agreed COL @endif
                                                            @if ($leadNotes->status_id == '5') Decline COL @endif
                                                            @if ($leadNotes->status_id == '6') DUMB @endif
                                                            @if ($leadNotes->status_id == '7') COL Out @endif
                                                            @if ($leadNotes->status_id == '8') OL Out @endif
                                                        </td>
                                                        @role('sales manager|sales executive')
                                                        <td>
                                                            <a href="/lead/edit_followLead/{{ $leadNotes->id }}" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i> Edit</a>
                                                            <button class="btn btn-danger btn-sm deleteFollow" data-id="{{$leadNotes->id}}" data-action="{{route('deleteFollowInfo', $leadNotes->id)}}"><i class="fal fa-trash"></i> Delete</button>
                                                            <meta name="csrf-token" content="{{ csrf_token() }}">
                                                        </td>
                                                        @endrole
                                                    </tr>
                                                    @endforeach
                                                    
                                                </thead>
                                            </table>
                                        @role('sales manager|sales executive')
                                        <a href="javascript:;" data-toggle="modal" id="new" class="btn btn-primary ml-auto float-right"><i class="fal fa-plus-square"></i> Add Follow Up</a>
                                        @endrole
                                        </div>

                                    </div>
                                </div>
                                   
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="crud-modal" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="card-header">
                                    <h5 class="card-title w-100">NEW FOLLOW UP NOTES</h5>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(['action' => 'LeadController@createFollowInfo', 'method' => 'POST']) !!}
                                    {{Form::hidden('id', $lead->id)}}

                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="follow_type_id"> Follow Up Type :</label></td>
                                            <td colspan="7">
                                                <select name="follow_type_id" id="follow_type_id" class="follow_type_id form-control">
                                                    <option value="">-- Select Follow Up Type --</option>
                                                    @foreach ($followType as $type) 
                                                            @php 
                                                                $select_lead = empty($lead_note) ? old('follow_type_id') : $lead_note->follow_type_id;
                                                            @endphp
                                                            <option value="{{ $type->id }}">
                                                                {{ $type->follow_name }}
                                                            </option> 
                                                    @endforeach
                                                    @error('follow_type_id')
                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                    @enderror
                                                </select>
                                        </div>
                                     
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="follow_remark"> Content / Remarks :</label></td>
                                            <td colspan="7">
                                                <textarea rows="10" class="form-control" id="follow_remark" name="follow_remark">{{ old('follow_remark') }}</textarea>
                                                @error('follow_remark')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                            </td>
                                        </div>
                                    
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="status_id"> Lead Status :</label></td>
                                            <td colspan="7">
                                                <select class="form-control" name="status_id" id="status_id" >
                                                    <option value="">-- Select Status --</option>
                                                        @foreach($status as $stat)
                                                            <option value="{{$stat->id}}"  {{  $lead->leads_status == $stat->id ? 'selected="selected"' : '' }} >{{$stat->status_name}}</option>
                                                        @endforeach
                                                        @error('status_id')
                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                        @enderror
                                                </select>
                                                
                                            </td>
                                        </div>
                                    
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="follow_date"> Date | Time:</label></td>
                                            <td colspan="7">
                                                <input type="datetime-local" value="{{ empty($lead_note) ?? date('Y-m-d | h:i A', strtotime($lead_note->follow_date)) }}" class="form-control" id="follow_date" name="follow_date">
                                                @error('follow_date')
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
                       
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')

<script>
    $(document).ready(function()
    {
        $('#new').click(function () {
            $('#crud-modal').modal('show');
        });

        $('#follow_track thead tr .hasinput').each(function(i)
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

        var table = $('#follow_track').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/api/followTrack/list",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'follow_title', name: 'follow_title' },
                    { data: 'follow_type_id', name: 'follow_type_id' },
                    { data: 'follow_date', name: 'follow_date' },
                    { data: 'status_id', name: 'status_id'},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                } 
        });

    });

    $('.deleteFollow').click(function() {
            console.log('asdaa');
            var id = $(this).data('id');
            var url = '{{route("deleteFollowInfo", "id")}}';
            url = url.replace('id', id );
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
                        type: 'DELETE',
                        url: url,
                        data: {_token: CSRF_TOKEN},
                        dataType: 'JSON',
                        success: function () {
                            Swal.fire({ text: "Successfully delete the data.", icon: 'success'
                            }).then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            })
        })

</script>

@endsection
