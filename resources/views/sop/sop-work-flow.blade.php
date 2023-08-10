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
                            <li>Drag and drop only <b style="color:red">one file</b> in the dropzone.</li>
                            <li>Drag a new file to replace the uploaded file.</li>
                        </ol>
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@if (isset($workFlow))
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
    <div class="row mt-4">
        <div class="form-group col-md-12 text-center">
            <img src="/get-work-flow/{{ $workFlow->id }}" alt="" title="" style="max-width: 100%;" />
        </div>
    </div>
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
