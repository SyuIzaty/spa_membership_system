@if (isset($sopReview))
    <div class="row">
        <div class="form-group col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr class="card-header text-center" style="background-color:#dad8d8;">
                        <th colspan="3">FORM</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="card-header text-center">
                        <th>No</th>
                        <th>Code</th>
                        <th>Details</th>
                    </tr>
                    @php $i = 1 @endphp
                    @foreach ($sopForm as $sf)
                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td class="text-center">
                                {{ isset($sf->sop_code) ? $sf->sop_code : '' }}</td>
                            <td>{{ isset($sf->details) ? $sf->details : '' }}</td>
                        </tr>
                        @php $i++ @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
<hr style="height:2px;border-width:0;color:gray;background-color:gray">

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
