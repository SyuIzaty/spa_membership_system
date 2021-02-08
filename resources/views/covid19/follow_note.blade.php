@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Follow Up Notes
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Add Follow Up</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            
                            <div class="card-body">
                                {!! Form::open(['action' => 'CovidController@addFollowup', 'method' => 'POST']) !!}
                                @csrf
                                <input type="hidden" name="cov" value="{{ $declare->id }}">

                                <table class="table table-bordered">
                                    <tr> 
                                        <td width="15%"><label class="form-label" for="follow_up">NOTES :</label></td>
                                        <td colspan="5"><textarea cols="5" rows="10" class="form-control" id="follow_up" name="follow_up"></textarea>
                                            @error('follow_up')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </tr>
                                </table>

                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                                <a href="{{ URL::previous() }}" class="btn btn-success ml-auto float-right mr-2" ><i class="fal fa-window-close"></i> Back</a>
                                {!! Form::close() !!}
                            </div>
                            <br><br>

                            <div class="card-body">
                                @if(session()->has('message'))
                                <div class="alert alert-success" style="color: #650404; background-color: #ff6c6cc9;"> <i class="icon fal fa-check-circle"></i>
                                        {{ session()->get('message') }}
                                    </div>
                                @endif
                                @if(session()->has('notification'))
                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i>
                                        {{ session()->get('notification') }}
                                    </div>
                                @endif
                                @if(session()->has('notify'))
                                <div class="alert alert-success" style="color: #582b04; background-color: #ffa95f;"> <i class="icon fal fa-check-circle"></i>
                                        {{ session()->get('notify') }}
                                    </div>
                                @endif
                                <table class="table table-bordered">
                                    <tr class="bg-primary-50 text-center">
                                        <td><b>NO.</b></td>
                                        <td><b>FOLLOW UP</b></td>
                                        <td><b>CREATED BY</b></td>
                                        <td><b>DATE</b></td>
                                        <td><b>ACTION</b></td>
                                    </tr>
                                    @if(!empty($notes) && $notes->count() > 0)
                                        @foreach ($notes as $el)
                                        <tr align="center">
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $el->follow_up }}</td>
                                            <td>{{ $el->user->name }}</td>
                                            <td>{{ date('d-m-Y | h:i A', strtotime($el->created_at)) }}</td>
                                            <td>
                                                <a href="" data-target="#crud-modals" data-toggle="modal" data-followup="{{ $el->id }}" data-name="{{ $el->follow_up}}" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i> Edit</a>
                                                <a href="{{ action('CovidController@delFollowup', ['id' => $el->id, 'cov_id' => $declare->id]) }}" class="btn btn-danger btn-sm deleteEl"><i class="fal fa-trash"> Delete</i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr align="center" class="data-row">
                                            <td valign="top" colspan="5" class="dataTables_empty">-- NO NOTES AVAILABLE --</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="crud-modals" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header">
                    <h5 class="card-title w-100"><i class="fal fa-plus-square"></i>  Edit Follow Up</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'CovidController@updateFollowup', 'method' => 'POST']) !!}
                    <input type="hidden" name="followup_id" id="followup">
                    <input type="hidden" name="cov" value="{{ $declare->id }}">
                    
                    <td width="15%"><label class="form-label" for="follow_up">NOTES :</label></td>
                    <td colspan="5"><textarea cols="5" rows="10" class="form-control" id="name" name="follow_up"></textarea>
                        @error('follow_up')
                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                        @enderror
                    </td>
                    <br>
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
        $(document).ready(function() {
            
            $('#crud-modals').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) 
            var followup = button.data('followup') 
            var name = button.data('name')

            $('.modal-body #followup').val(followup); 
            $('.modal-body #name').val(name); 
        });

        });
    </script>
@endsection
