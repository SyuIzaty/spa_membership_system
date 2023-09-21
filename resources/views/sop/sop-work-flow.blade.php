@if (!isset($sop))
    <div class="row">
        <div class="form-group col-md-12">
            <p style="color: red">Please filling out SOP Details
                section
            </p>
        </div>
    </div>
@else
    <div class="row">
        <div class="form-group col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr class="card-header" style="background-color:#EBCEDE;">
                        <td>REMINDER</td>
                    </tr>
                    <tr>
                        <th>
                            <ol>
                                <li>Design the work flow in Visio or in any preference medium.</li>
                                <li>Please make sure the orientation is <b style="color:red">potrait</b> and the size is
                                    <b style="color:red">A4 (8.27" x 11.69").</b>
                                </li>
                                <li>Save the file as <b style="color:red">.jpeg, .jpg or .png</b> only.</li>
                                <li>Drag and drop the <b style="color:red">file</b> in the dropzone.</li>
                                <li>Please append a sequential number to the <b style="color:red">end of each file's
                                        name</b>
                                    when you have <b style="color:red">multiple files</b>.
                                    For example, you can name them 'Flowchart 1,' 'Flowchart 2,' and so on.
                                </li>
                                <li>Drag a new file with the <b style="color:red">same name</b> to replace the uploaded
                                    file.
                                </li>
                            </ol>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @if (isset($workFlow))
        @if (isset($sop))
            @if ($sop->prepared_by == Auth::user()->id)
                <div class="row">
                    <div class="form-group col-md-12">
                        <form method="post" action="{{ url('store-new-work-flow') }}" enctype="multipart/form-data"
                            class="dropzone needsclick dz-clickable" id="dropzone">
                            @csrf
                            <input type="hidden" name="id" value="{{ $id }}">
                            <div class="dz-message needsclick">
                                <i class="fal fa-cloud-upload text-muted mb-3"></i>
                                <br>
                                <span class="text-uppercase">Drop files here or
                                    click to
                                    upload.</span>
                                <br>
                                <span class="fs-sm text-muted">This is a dropzone.
                                    Selected
                                    files
                                    <strong>.jpeg,.jpg,.png</strong>
                                    are actually uploaded.</span>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @endif

        @foreach ($workFlow as $wf)
            <div class="row mt-4">
                <div class="form-group col-md-12 text-center">
                    <div style="position: relative; display: inline-block;">
                        <img src="/get-work-flow/{{ $wf->id }}" alt="" title=""
                            style="max-width: 100%;" />
                        <a href="#" data-path="{{ $wf->id }}" class="btn btn-danger btn-sm btn-delete"
                            style="position: absolute; top: 0; right: -10%;">
                            <i class="fal fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <form method="post" action="{{ url('store-work-flow') }}" enctype="multipart/form-data"
            class="dropzone needsclick dz-clickable" id="dropzone2">
            @csrf
            <input type="hidden" name="id" value="{{ $id }}">
            <div class="dz-message needsclick">
                <i class="fal fa-cloud-upload text-muted mb-3"></i>
                <br>
                <span class="text-uppercase">Drop files here or
                    click to
                    upload.</span>
                <br>
                <span class="fs-sm text-muted">This is a dropzone.
                    Selected
                    files
                    <strong>.jpeg,.jpg,.png</strong>
                    are actually uploaded.</span>
            </div>
        </form>
    @endif
@endif
