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
                                        <td colspan="5"><label class="form-label" for="follow_up">NOTES :</label>
                                            @error('follow_up')
                                                <p style="color: red"><strong> * not more than 225 words </strong></p>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr> 
                                        <td colspan="5"><textarea class="form-control summernote" id="follow_up" name="follow_up">{{ old('follow_up') }}</textarea></td>
                                    </tr>
                                </table>

                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                                <a href="{{ URL::previous() }}" class="btn btn-success ml-auto float-right mr-2" ><i class="fal fa-arrow-alt-left"></i> Back</a>
                                {!! Form::close() !!}
                            </div>
                            <br><br>

                            <div class="card-body">
                                <div class="table-responsive">
                                    @if(session()->has('message'))
                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i>
                                            {{ session()->get('message') }}
                                        </div>
                                    @endif
                                    @if(session()->has('notification'))
                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i>
                                            {{ session()->get('notification') }}
                                        </div>
                                    @endif
                                    @if(session()->has('notify'))
                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i>
                                            {{ session()->get('notify') }}
                                        </div>
                                    @endif
                                    <table class="table table-bordered">
                                        <tr class="bg-primary-50 text-center" style="white-space: nowrap">
                                            <td><b>NO.</b></td>
                                            <td><b>FOLLOW UP</b></td>
                                            <td><b>CREATED BY</b></td>
                                            <td><b>DATE</b></td>
                                            <td><b>ACTION</b></td>
                                        </tr>
                                        @if(!empty($notes) && $notes->count() > 0)
                                            @foreach ($notes as $el)
                                            <tr>
                                                <td align="center">{{ $no++ }}</td>
                                                <td style="width: 775px">{!! $el->follow_up !!} </td>
                                                <td align="center">{{ $el->user->name }}</td>
                                                <td align="center">{{ date('d-m-Y | h:i A', strtotime($el->created_at)) }}</td>
                                                <td align="center">
                                                    <a href="/followup-edit/{{ $el->id}}" data-cov="{{$el->id}}" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i> Edit</a>
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
        </div>
</main>
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $('.summernote').summernote({
                height: 200,
                spellCheck: true
            });
            
        });
    </script>
@endsection
