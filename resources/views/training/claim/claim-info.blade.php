@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr" style="background-color:rgb(97 63 115)">
                    <h2>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>

                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <center><img src="{{ asset('img/intec_logo.png') }}" style="height: 120px; width: 270px;"></center><br>
                        <h4 style="text-align: center">
                            <b>INTEC EDUCATION COLLEGE TRAINING HOURS CLAIM DETAILS</b>
                        </h4>

                        <div class="panel-container show">
                            <div class="panel-content">
                                <div>
                                    <div class="table-responsive">
                                        @if (Session::has('message'))
                                            <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                        @endif
                                            <table class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <div style="float: left"><i>Submitted Date : {{ date(' j F Y | h:i:s A', strtotime($claim->created_at) )}}</i></div><br>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Full Name :</label></td>
                                                            <td colspan="3">
                                                                {{ $claim->staffs->staff_name ?? '--'}}
                                                            </td>
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Staff ID :</label></td>
                                                            <td colspan="3">
                                                                {{ $claim->staffs->staff_id ?? '--'}}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Position :</label></td>
                                                            <td colspan="3">
                                                                {{ $claim->staffs->staff_position ?? '--'}}
                                                            </td>
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Department :</label></td>
                                                            <td colspan="3">
                                                                {{ $claim->staffs->staff_dept ?? '--'}}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Training Title :</label></td>
                                                            <td colspan="6" style="text-transform: uppercase">
                                                                #{{ $claim->training_id ?? '--'}} : {{ $claim->title ?? '--'}}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Type of Training :</label></td>
                                                            <td colspan="3" style="text-transform: uppercase">
                                                                {{ $claim->types->type_name ?? '--'}}
                                                            </td>
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Category of Training :</label></td>
                                                            <td colspan="3" style="text-transform: uppercase">
                                                                {{ $claim->categories->category_name ?? '--'}}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Start Date :</label></td>
                                                            <td colspan="3">
                                                                {{ date(' d/m/Y ', strtotime($claim->start_date) ) ?? '--'}}
                                                            </td>
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> End Date :</label></td>
                                                            <td colspan="3">
                                                                {{ date(' d/m/Y ', strtotime($claim->end_date) ) ?? '--'}}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @if($claim->status == '1')
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Time :</label></td>
                                                            <td colspan="3">
                                                                {{ date(' h:i A ', strtotime($claim->start_time) ) ?? '--'}} -  {{ date(' h:i A ', strtotime($claim->end_time) ) ?? '--'}}
                                                            </td>
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Claim Hours :</label></td>
                                                            <td colspan="3">
                                                                {{ $claim->claim_hour ?? '--'}} HOURS
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @endif
                                                    @if($claim->status == '2' || $claim->status == '3')
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Start Time :</label></td>
                                                            <td colspan="3">
                                                                {{ date(' h:i A ', strtotime($claim->start_time) ) ?? '--'}}
                                                            </td>
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> End Time :</label></td>
                                                            <td colspan="3">
                                                                {{ date(' h:i A ', strtotime($claim->end_time) ) ?? '--'}} 
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Claim Hours :</label></td>
                                                            <td colspan="3">
                                                                {{ $claim->claim_hour ?? '--'}} HOURS
                                                            </td>
                                                            @if($claim->status == '2')
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Approved Hours :</label></td>
                                                            <td colspan="3">
                                                                {{ $claim->approved_hour ?? '--'}} HOURS
                                                            </td>
                                                            @endif
                                                            @if($claim->status == '3')
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Reject Reason :</label></td>
                                                            <td colspan="3">
                                                                {{ $claim->reject_reason ?? '--'}} 
                                                            </td>
                                                            @endif
                                                        </div>
                                                    </tr>
                                                    @endif
                                                    {{-- @if($claim->form_type == 'SF') --}}
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Link :</label></td>
                                                            <td colspan="3" style="vertical-align: middle">
                                                                @if(isset($claim->link ))
                                                                    <a href="{{ $claim->link ?? '--'}}" target="_blank"> {{ $claim->link }} </a>
                                                                @else 
                                                                    --
                                                                @endif
                                                            </td>
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Attachment : <i class="fal fa-info-circle fs-xs mr-1" data-toggle="tooltip" data-placement="right" title="" data-original-title="Maximum attachment 5 (.pdf, .jpg, .jpeg, .png)"></i></label></td>
                                                            <td colspan="3">
                                                                @if($attachment->first())
                                                                <ol style="margin-left: -25px">
                                                                    @foreach ($attachment as $attachments)
                                                                        <li class="mt-1">
                                                                            <div style="clear: both;">
                                                                                <a style="float: left" target="_blank" href="{{ url('claim')."/".$attachments->file_name }}/Download">{{ $attachments->file_name }}</a>
                                                                                {{-- <button style="float : right" type="submit" class="btn btn-danger btn-xs delete-alert"><i class="fal fa-trash"></i></button> --}}

                                                                                <a style="float : right" href="{{ action('TrainingController@deleteFile', ['id' => $attachments->id]) }}" class="btn btn-danger btn-xs delete-alert"><i class="fal fa-trash"></i></a>
                                                                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ol>
                                                                @else 
                                                                    No Supporting Document
                                                                @endif
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    {{-- @endif --}}
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Venue :</label></td>
                                                            <td colspan="3" style="text-transform: uppercase">
                                                                {{ $claim->venue ?? '--'}}
                                                            </td>
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Status : </label></td>
                                                            <td colspan="3">
                                                                @if($claim->status=='1')
                                                                <span class="badge badge-done" style="padding : 0.8em 1.6em">{{ strtoupper($claim->claimStatus->status_name) }}</span>
                                                                @elseif($claim->status=='2')
                                                                    <span class="badge badge-success" style="padding : 0.8em 1.6em">{{ strtoupper($claim->claimStatus->status_name) }}</span>
                                                                @else
                                                                    <span class="badge badge-duplicate" style="padding : 0.8em 1.6em">{{ strtoupper($claim->claimStatus->status_name) }}</span>
                                                                @endif
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @if($claim->status != '1')
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%" style="vertical-align: middle"><label class="form-label"> Assigned By :</label></td>
                                                            <td colspan="6" style="text-transform: uppercase">
                                                                {{ $claim->users->name ?? '--'}}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <div class="form-group">
                                                            <td colspan="6">
                                                                <form method="post" action="{{url('store-file')}}" enctype="multipart/form-data" class="dropzone needsclick dz-clickable" id="dropzone">
                                                                    @csrf
                                                                    <input type="hidden" name="ids" value="{{ $claim->id }}">
                                                                    <div class="dz-message needsclick">
                                                                        <i class="fal fa-cloud-upload text-muted mb-3"></i> <br>
                                                                        <span class="text-uppercase">Drop files here or click to upload.</span>
                                                                        <br>
                                                                        <span class="fs-sm text-muted">This is a dropzone. Selected files <strong>.pdf,.jpeg,.jpg,.png</strong> are actually uploaded.</span>
                                                                    </div>
                                                                </form>   
                                                                <script type="text/javascript">
                                                                    Dropzone.options.dpzMultipleFiles = {
                                                                         maxFilesize: 15, // MB
                                                                         maxFiles: 5,
                                                                         renameFile: function(file) {
                                                                             var dt = new Date();
                                                                             var time = dt.getTime();
                                                                            return time+file.name;
                                                                         },
                                                                         acceptedFiles: ".jpeg,.jpg,.png",
                                                                         addRemoveLinks: true,
                                                                         timeout: 50000,
                                                                         init: function () {
                                                                            this.on('removedfile', function (file) {
                                                                                var name = file.upload.filename;
                                                                                $.ajax({
                                                                                    headers: {
                                                                                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                                                                            },
                                                                                    type: 'POST',
                                                                                    url: '{{ url("delete-file") }}',
                                                                                    data: {filename: name},
                                                                                    success: function (data){
                                                                                        console.log("File has been successfully removed!!");
                                                                                    },
                                                                                    error: function(e) {
                                                                                        console.log(e);
                                                                                    }});
                                                                                    var fileRef;
                                                                                    return (fileRef = file.previewElement) != null ? 
                                                                                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
                                                                            });
                                                                            this.on('success', function (file, response) {
                                                                                console.log(response);
                                                                                location.reload();
                                                                            });
                                                                            this.on('error', function(file, response) {
                                                                                return false;
                                                                            }); 
                                                                             
                                                                        }
                                                                    };
                                                                </script>
                                                            </td>
                                                        </div>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <a href="{{ url()->previous() }}" class="btn btn-success ml-auto float-right mr-2"><i class="fal fa-arrow-alt-left"></i> Back</a>
                                        
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

    $(document).ready( function() {
        $('#type, #category').select2();
    })

</script>

  
@endsection

