@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon ni ni-briefcase'></i> SOP Management
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10"
                                data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="row">
                                <div class="tab-content col-md-12">
                                    @if (session()->has('message'))
                                        <div class="alert alert-success">
                                            {{ session()->get('message') }}
                                        </div>
                                    @endif
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <strong>Whoops!</strong> There were some problems with your
                                            input.<br><br>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-12 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-header">Review Record</div>
                                                <div class="card-body">
                                                    <textarea value="" class="form-control summernotePro" id="procedure" name="procedure" required>{{ isset($sopReview->review_record) ? $sopReview->review_record : old('procedure') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="/sop/{{ $sopReview->sop_lists_id }}" style="margin-left:20px; margin-bottom:10px;"
                        class="btn btn-success btn-icon rounded-circle waves-effect waves-themed">
                        <i class="fal fa-arrow-alt-left"></i>
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
    <script>
        $('.summernotePro').summernote({
            height: 500,
            spellCheck: true,
            placeholder: 'Please key-in the procedure',
            toolbar: [],
            readOnly: true,
            callbacks: {
                onInit: function() {
                    $('.note-editable').attr('contenteditable', false);
                    $('.note-editor').addClass('disabled');
                    $('.note-editor').off();
                }
            }
        });
    </script>
@endsection
