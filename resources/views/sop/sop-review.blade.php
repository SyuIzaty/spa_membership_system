{{-- @if (isset($sopReview)) --}}
<div class="row">
    <div class="form-group col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr class="card-header text-center" style="background-color:#dad8d8;">
                    <th colspan="5">REVIEW</th>
                </tr>
            </thead>
            <tbody>
                <tr class="card-header text-center">
                    <th>No</th>
                    <th>Date</th>
                    <th>Updated By</th>
                    <th>Section</th>
                    <th>Details</th>
                </tr>
                @php $i = 1 @endphp
                @foreach ($sopReview as $sr)
                    <tr>
                        <td class="text-center">{{ $i }}</td>
                        <td class="text-center">
                            {{ isset($sr->created_at) ? date(' j F Y', strtotime($sr->created_at)) : '' }}</td>
                        <td>{{ isset($sr->staff->staff_name) ? $sr->staff->staff_name : '' }}</td>
                        <td class="text-center">{{ isset($sr->section) ? $sr->section : '' }}</td>
                        <td class="text-center">{{ isset($sr->review_record) ? $sr->review_record : '' }}</td>
                    </tr>
                    @php $i++ @endphp
                @endforeach
            </tbody>
        </table>
    </div>
</div>
