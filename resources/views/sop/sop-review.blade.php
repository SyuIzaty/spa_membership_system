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
                @if (!$sopReview->isEmpty())
                    @php $i = 1 @endphp
                    @foreach ($sopReview as $sr)
                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td class="text-center">
                                {{ isset($sr->created_at) ? date(' j F Y h:i:s A', strtotime($sr->created_at)) : '' }}
                            </td>
                            <td>{{ isset($sr->staff->staff_name) ? $sr->staff->staff_name : '' }}</td>
                            <td class="text-center">{{ isset($sr->section) ? $sr->section : '' }}</td>
                            <td class="text-center">{{ isset($sr->review_record) ? $sr->review_record : '' }}</td>
                        </tr>
                        @php $i++ @endphp
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center" style="background-color:#e6e1e1;">Review Record is not
                            available</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
