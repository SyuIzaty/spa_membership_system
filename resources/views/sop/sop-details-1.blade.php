@if (isset($sop))
    {!! Form::model($sop, ['route' => ['sop.updateDetails', $sop->id], 'method' => 'put']) !!}
@else
    {!! Form::open(['route' => 'sop.storeDetails']) !!}
@endif

<input type="hidden" value="{{ $id }}" name="id">
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header" style="background-color:#ede9e9;">Cover/Front
                Page</div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center" style="background-color:#95BFBC;">
                                    <th>Department Name</th>
                                    <th>Department Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($department as $d)
                                    <tr>
                                        <td class="text-left">
                                            {{ $d->department_name }}</td>
                                        <td class="text-center">
                                            {{ $d->abbreviation }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group col-md-6">
                        <table class="table table-bordered">
                            <tbody>
                                <tr class="card-header text-center">
                                    <th style="background-color:#95BFBC; vertical-align: middle;" rowspan="2">SOP
                                        Code</th>
                                    <td class="text-center" style="background-color:#ffffff;">
                                        (Work Process)/(INTEC Code)/(Department
                                        Code)/(Unit Code)/(No. of Documents)
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        i.e: <b>WP/INTEC/QA/RC/01</b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered">
                            <tbody>
                                <tr class="card-header text-center">
                                    <th style="background-color:#95BFBC; vertical-align: middle;" rowspan="9">
                                        Reminder</th>
                                    <td class="text-left" style="background-color:#ffffff;">
                                        Each of SOPs must have the following details
                                        on:
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Purpose</b> (to briefly explain
                                        the
                                        purpose of SOP).</td>
                                <tr>
                                    <td><b>Scope</b> (who would be affected/
                                        involved with the SOP).</td>
                                </tr>
                                <tr>
                                    <td><b>Reference</b> (any references
                                        would be
                                        used in the SOP process).</td>
                                </tr>
                                <tr>
                                    <td><b>Definition</b> (an abbreviation
                                        formed
                                        from the initial letters used in the
                                        SOP).</td>
                                </tr>
                                <tr>
                                    <td><b>Procedure</b> (main process as
                                        stated in
                                        the flow-chart need to briefly
                                        explain about the process).</td>
                                </tr>
                                <tr>
                                    <td><b>Review Record</b> in <b>Part
                                            B</b> (information to be
                                        inserted if there is review,
                                        revision or amendment been done with
                                        the SOP).</td>
                                </tr>
                                <tr>
                                    <td><b>Forms</b> in <b>Part B</b> (to
                                        list-down all the related forms used
                                        in the SOP).</td>
                                </tr>
                                <tr>
                                    <td><b>Work Flow</b> in <b>Part C</b>
                                        (to list/ draw flow-chart of the
                                        process involved).</td>
                                </tr>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered">
                            <tbody>
                                <tr class="card-header text-center">
                                    <th style="background-color:#95BFBC; vertical-align: middle;" rowspan="9">
                                        Reference</th>
                                    <td class="text-left" style="background-color:#ffffff;">
                                        <a href="/sop-reference" title="Reference" data-filter-tags="Reference"
                                            target="_blank" style="text-decoration: none!important">
                                            <i class="fal fa-info-circle"></i>
                                            <span class="nav-link-text" data-i18n="nav.SOP-Reference">SOP
                                                Sample</span>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                </div>

                <div class="row mt-2">
                    <div class="form-group col-md-12">
                        <div>
                            <span class="input-group-text" style="background-color:#f3f3f37a;">SOP Title
                            </span>
                        </div>
                        <input type="text" id="title" name="title" value="{{ $data->sop }}"
                            class="form-control" disabled>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="form-group col-md-6">
                        <div>
                            <span class="input-group-text" style="background-color:#f3f3f37a;">Department
                            </span>
                        </div>
                        <input type="text" id="department" name="department"
                            value="{{ $data->department->department_name }}" class="form-control" disabled>
                    </div>
                    <div class="form-group col-md-6">
                        <div>
                            <span class="input-group-text">SOP Code
                            </span>
                        </div>
                        <input type="text" id="code" name="code"
                            value="{{ isset($sop) ? $sop->sop_code : old('code') }}" class="form-control"
                            placeholder="Please key-in SOP Code" required>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="form-group col-md-4">
                        <div>
                            <span class="input-group-text" style="background-color:#f3f3f37a;">Prepared
                                By</span>
                        </div>
                        <select class="form-control" name="prepared_by" id="prepared_by" required>
                            <option disabled selected>Choose Staff</option>
                            @foreach ($staff as $s)
                                <option value="{{ $s->staff_id }}"
                                    {{ isset($sop)
                                        ? ($sop->prepared_by == $s->staff_id
                                            ? 'selected'
                                            : '')
                                        : (old('prepared_by') == $s->staff_id
                                            ? 'selected'
                                            : '') }}>
                                    {{ $s->staff_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <div>
                            <span class="input-group-text" style="background-color:#f3f3f37a;">Reviewed
                                By</span>
                        </div>
                        <select class="form-control" name="reviewed_by" id="reviewed_by" required>
                            <option disabled selected>Choose Staff</option>
                            @foreach ($staff as $s)
                                <option value="{{ $s->staff_id }}"
                                    {{ isset($sop)
                                        ? ($sop->reviewed_by == $s->staff_id
                                            ? 'selected'
                                            : '')
                                        : (old('reviewed_by') == $s->staff_id
                                            ? 'selected'
                                            : '') }}>
                                    {{ $s->staff_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <div>
                            <span class="input-group-text" style="background-color:#f3f3f37a;">Approved
                                By</span>
                        </div>
                        <select class="form-control" name="approved_by" id="approved_by" required>
                            <option disabled selected>Choose Staff</option>
                            @foreach ($staff as $s)
                                <option value="{{ $s->staff_id }}"
                                    {{ isset($sop)
                                        ? ($sop->approved_by == $s->staff_id
                                            ? 'selected'
                                            : '')
                                        : (old('approved_by') == $s->staff_id
                                            ? 'selected'
                                            : '') }}>
                                    {{ $s->staff_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 15px;">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header" style="background-color:#ede9e9;">SOP Details
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <div>
                            <span class="input-group-text" style="background-color:#f3f3f37a;">Purpose
                            </span>
                        </div>
                        <textarea class="form-control" id="example-textarea" rows="8" name="purpose"
                            placeholder="Please key-in the purpose" required>{{ isset($sop) ? $sop->purpose : old('purpose') }}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <div>
                            <span class="input-group-text" style="background-color:#f3f3f37a;">Scope
                            </span>
                        </div>
                        <textarea class="form-control" id="example-textarea" rows="8" name="scope"
                            placeholder="Please key-in the scope" required>{{ isset($sop) ? $sop->scope : old('scope') }}</textarea>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="form-group col-md-6">
                        <div>
                            <span class="input-group-text" style="background-color:#f3f3f37a;">Reference
                            </span>
                        </div>
                        <textarea value="" class="form-control summernoteRef" id="reference" name="reference">{{ isset($sop) ? $sop->reference : old('reference') }}</textarea>

                    </div>
                    <div class="form-group col-md-6">
                        <div>
                            <span class="input-group-text" style="background-color:#f3f3f37a;">Definitions
                            </span>
                        </div>
                        <textarea value="" class="form-control summernoteDef" id="definition" name="definition">{{ isset($sop) ? $sop->definition : old('definition') }}</textarea>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="form-group col-md-12">
                        <div>
                            <span class="input-group-text" style="background-color:#f3f3f37a;">Procedures
                            </span>
                        </div>
                        <textarea value="" class="form-control summernotePro" id="procedure" name="procedure" required>{{ isset($sop) ? $sop->procedure : old('procedure') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::button(isset($sop) ? 'Update' : 'Save', [
    'type' => 'submit',
    'class' => 'btn btn-primary ml-auto float-right',
    'style' => 'margin-top:10px',
]) !!}
{!! Form::close() !!}
