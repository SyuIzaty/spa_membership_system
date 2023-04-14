<form method="post" action="{{ url('store-work-flow') }}" enctype="multipart/form-data"
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
            <strong>.pdf,.doc,.docx,.jpeg,.jpg,.png</strong>
            are actually uploaded.</span>
    </div>
</form>
