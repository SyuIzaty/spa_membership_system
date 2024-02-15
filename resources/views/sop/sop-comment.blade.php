<div class="row">
    <div class="form-group col-md-12">
        <table class="table table-bordered">
            <tbody>
                <tr style="background-color:#ccbd95; vertical-align: middle; text-align: center; font-weight: bold;">
                    <td colspan="3">Comment(s) By QAG</td>
                </tr>

                @if ($data->status == '2' || $data->status == '3')
                    @can('Manage SOP')
                        <tr class="card-header text-center">
                            <th style="background-color:#f0e6ca; vertical-align: middle; text-align: justify" rowspan="2">
                                If the SOP needs an amendment, please enter your comment and click the "Submit"
                                button.
                            </th>
                        </tr>
                        <tr style="text-align: left">
                            <td colspan="2" WIDTH="50%">
                                <form id="form-comment">
                                    @csrf
                                    <input type="hidden" id="id" name="id" value="{{ $id }}">
                                    <textarea class="form-control" rows="5" name="comment" required></textarea> <br>
                                    <button class="btn btn-warning float-right" id="comments" name="submit"><i
                                            class="fal fa-check"></i>
                                        Submit
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endcan
                @endif

                <tr class="text-center" style="font-weight: bold; background-color:#ceb570;">
                    <td>No.</td>
                    <td>Comment</td>
                    <td>Date</td>
                </tr>
                @if (!$comment->isEmpty())

                    @php $i = 1; @endphp
                    @foreach ($comment as $c)
                        <tr>
                            <td WIDTH="10%" class="text-center">{{ $i }}</td>
                            <td>{!! nl2br($c->comment) !!}</td>
                            <td WIDTH="15%" class="text-center">{{ date(' j F Y', strtotime($c->created_at)) }}</td>
                        </tr>
                        @php $i++ @endphp
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-center" style="background-color:#e6e1e1;">Comment is not
                            available</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
