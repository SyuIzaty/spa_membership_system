<div class="row">
    <div class="form-group col-md-12">
        <table class="table table-bordered">
            <tbody>
                <tr style="background-color:#c4cc95; vertical-align: middle; text-align: center; font-weight: bold;">
                    <td colspan="2">Verification from QAG</td>
                </tr>

                @if ($data->status == '2')
                    <tr class="card-header text-center">
                        <th style="background-color:#e8eec7; vertical-align: middle; text-align: justify" rowspan="2">
                            If the SOP is completed and does not require any amendments, please click the "Verify SOP"
                            button.
                        </th>
                    </tr>
                    <tr>
                        <td class="text-center" WIDTH="50%" style="vertical-align: middle;">
                            <a href="#" data-path="{{ $data->id }}" class="btn btn-info btn-md verify"
                                id="verify"><i class="fal fa-check"></i> Verify SOP
                            </a>
                        </td>
                    </tr>
                @else
                    <tr colspan="2">
                        <td class="text-center" WIDTH="60%" style="vertical-align: middle; color: red;">
                            <span style="font-weight: bold;">VERIFIED</span>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@if ($data->status == '3' || $data->status == '4')
    <hr style="border-top: 1px solid rgb(206, 202, 202);">

    <div class="row">
        <div class="form-group col-md-12">
            <table class="table table-bordered">
                <tbody>
                    <tr
                        style="background-color:#afb9d8; vertical-align: middle; text-align: center; font-weight: bold;">
                        <td colspan="2">Approval By Chief Executive (CE)</td>
                    </tr>
                    @if ($data->status == '3')
                        <tr class="card-header" style="text-align: justify">
                            <th style="background-color:#c7d1ee; vertical-align: middle;" rowspan="2">
                                Once the SOP has received approval from the Chief Executive (CE),
                                kindly proceed to click the "Approve SOP" button.
                                The finalized SOP will then be made accessible to all INTEC Staff members.
                            </th>
                        </tr>
                        <tr style="text-align: left">
                            <td class="text-center" WIDTH="50%" style="vertical-align: middle;">
                                <a href="#" data-path="{{ $data->id }}" class="btn btn-info btn-md approve"
                                    id="approve"><i class="fal fa-check"></i> Approve SOP
                                </a>
                            </td>
                        </tr>
                    @elseif ($data->status == '4')
                        <tr colspan="2">
                            <td class="text-center" WIDTH="60%" style="vertical-align: middle; color: red;">
                                <span style="font-weight: bold;">APPROVED</span>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endif
