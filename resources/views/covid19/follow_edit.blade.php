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
                        <h2>Edit Follow Up</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="card-body">
                                {!! Form::open(['action' => 'CovidController@updateFollowup', 'method' => 'POST']) !!}
                                <input type="hidden" name="cov" value="{{ $notes->id }}">
                                <input type="hidden" name="covD" value="{{ $declare->id }}">

                                <table class="table table-bordered">
                                    <tr> 
                                        <td colspan="5" class="bg-primary-50"><label class="form-label" for="follow_up">NOTES :</label>
                                            @error('follow_up')
                                                <p style="color: red"><strong> * not more than 225 words </strong></p>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr> 
                                        <td colspan="5"><textarea value="{{ old('follow_up') }}" class="form-control summernote" id="follow_up" name="follow_up">{!! $notes->follow_up !!}</textarea></td>
                                    </tr>
                                </table>

                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                <a href="/followup-list/{{ $declare->id }}" class="btn btn-success ml-auto float-right mr-2" ><i class="fal fa-arrow-alt-left"></i> Back</a>
                                {!! Form::close() !!}
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</main>
@endsection
@section('script')
    <script>
        $('.summernote').summernote({
            height: 200,
            spellCheck: true
        });
    </script>
@endsection
