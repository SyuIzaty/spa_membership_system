<hr style="height:2px;border-width:0;color:gray;background-color:gray">

@if ($data->status == '1' || $data->status == '2')
    @if ($sop->prepared_by == Auth::user()->id)

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
        @if (isset($sop))
            @if ($sop->prepared_by == Auth::user()->id)
                <button type="submit" style="margin-bottom: 10px;" class="btn btn-sm btn-primary float-right"><i
                        class="fal fa-save"></i> Save
                </button>
            @endif
        @endif
        {!! Form::close() !!}
    @endif
@endif

@if (isset($sopReview))
    @if ($data->status == '1' || $data->status == '2')
        @if ($sop->prepared_by == Auth::user()->id)
            <table class="table table-bordered editable mt-5 w-100" id="editable">
            @else
                <table class="table table-bordered mt-5 w-100">
        @endif
        <thead class="bg-primary-50">
            <tr class="card-header text-center" style="background-color:#dad8d8;">
                <td>No</td>
                <td>Code</td>
                <td>Details</td>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach ($sopForm as $sf)
                <tr>
                    <td class="text-center col-md-1">
                        {{ $i }}</td>
                    <td style="display:none">
                        <input name="id">{{ $sf->id }}
                    </td>
                    <td class='code'> {{ isset($sf->sop_code) ? $sf->sop_code : '' }}</td>
                    <td class='details'>{{ isset($sf->details) ? $sf->details : '' }}</td>
                </tr>
                @php $i++; @endphp
            @endforeach
        </tbody>
        </table>
    @else
        <table class="table table-bordered mt-5 w-100">
            <thead class="bg-primary-50">
                <tr class="card-header text-center" style="background-color:#dad8d8;">
                    <td>No</td>
                    <td>Code</td>
                    <td>Details</td>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($sopForm as $sf)
                    <tr>
                        <td class="text-center col-md-1">
                            {{ $i }}</td>
                        <td class='code'> {{ isset($sf->sop_code) ? $sf->sop_code : '' }}</td>
                        <td class='details'>{{ isset($sf->details) ? $sf->details : '' }}</td>
                    </tr>
                    @php $i++; @endphp
                @endforeach
            </tbody>
        </table>
    @endif
@endif
