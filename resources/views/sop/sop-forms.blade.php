{!! Form::open([
    'action' => 'SOPController@storeFormRecord',
    'method' => 'POST',
    'enctype' => 'multipart/form-data',
]) !!}

<input type="hidden" name="id" value="{{ $data->id }}">

<table class="table table-bordered" id="addForm">
    <thead>
        <tr class="card-header" style="background-color:#f3ce77;">
            <th colspan="3">Click plus button on the right to add forms details.
                <button type="button" id="form"
                    class="btn btn-sm btn-success btn-icon rounded-circle waves-effect waves-themed float-right">
                    <i class="fal fa-plus"></i>
                </button>
            </th>
        </tr>
        <tr class="card-header text-center" style="background-color:#EEE2C7;">
            <th colspan="3">FORMS</th>
        </tr>
        <tr class="card-header text-center">
            <th>SOP Code</th>
            <th>Details</th>
            <th></th>
        </tr>
    </thead>
</table>
<button type="submit" style="margin-bottom: 10px;" class="btn btn-sm btn-primary float-right"><i
        class="fal fa-save"></i> Save
</button>
{!! Form::close() !!}
