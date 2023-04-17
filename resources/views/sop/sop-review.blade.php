@if (isset($sopReview))
    <div class="row">
        <div class="form-group col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr class="card-header text-center" style="background-color:#dad8d8;">
                        <th colspan="3">REVIEW</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="card-header text-center">
                        <th>No</th>
                        <th>Date</th>
                        <th>Details</th>
                    </tr>
                    @php $i = 1 @endphp
                    @foreach ($sopReview as $sr)
                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td class="text-center">
                                {{ isset($sr->created_at) ? date(' j F Y ', strtotime($sr->created_at)) : '' }}</td>
                            <td>{{ isset($sr->review_record) ? $sr->review_record : '' }}</td>
                        </tr>
                        @php $i++ @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
<hr style="height:2px;border-width:0;color:gray;background-color:gray">
<div class="row mt-4">
    <div class="form-group col-md-12">
        {!! Form::open([
            'action' => 'SOPController@storeReviewRecord',
            'method' => 'POST',
            'enctype' => 'multipart/form-data',
        ]) !!}

        <input type="hidden" name="id" value="{{ $data->id }}">

        <table class="table table-bordered" id="addReview">
            <thead>
                <tr class="card-header" style="background-color:#e3c5f5;">
                    <th colspan="3">Click plus button on the right to add the review record.
                        <button type="button" id="review"
                            class="btn btn-sm btn-success btn-icon rounded-circle waves-effect waves-themed float-right">
                            <i class="fal fa-plus"></i>
                        </button>
                    </th>
                </tr>
                <tr class="card-header text-center" style="background-color:#B99FC9;">
                    <th colspan="3">REVIEW</th>
                </tr>
                <tr class="card-header text-center">
                    <th>Date</th>
                    <th>Details</th>
                    <th></th>
                </tr>
            </thead>
        </table>
        <button type="submit" style="margin-bottom: 10px;" class="btn btn-sm btn-primary float-right"><i
                class="fal fa-save"></i> Save
        </button>
        {!! Form::close() !!}
    </div>
</div>
