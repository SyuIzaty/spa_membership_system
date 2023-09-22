@extends('layouts.applicant')

@section('content')
    <style>
        .table {
            border: 0.5px solid #000000;
        }

        .table-bordered>thead>tr>th,
        .table-bordered>tbody>tr>th,
        .table-bordered>tfoot>tr>th,
        .table-bordered>thead>tr>td,
        .table-bordered>tbody>tr>td,
        .table-bordered>tfoot>tr>td {
            border: 0.5px solid #000000;
        }

        #footer {
            position: fixed;
            width: 100%;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 10px;
        }

        #container {
            display: flex;
            /* establish flex container */
            justify-content: space-between;
            /* switched from default (flex-start, see below) */
            margin-top: 350px;
        }

        .page-break {
            page-break-after: always;
        }

        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
        }
    </style>
    <main id="js-page-content" role="main" class="page-content">
        <div class="row">
            <div class="col-xl-12" style="padding: 100px; margin-bottom: 20px; font-size: 15px; color: black;">
                <center><img src="{{ URL::to('/') }}/img/INTEC_PRIMARY_LOGO.png" height="110" width="300" alt="INTEC"
                        style="margin-top: -65px"></center><br>
                <center>
                    <h1 style="margin-bottom: 55px;margin-top: 60px"><b>STANDARD OPERATING PROCEDURE</b></h1>
                    <h1 style="margin-bottom: 50px">
                        <b>{{ isset($data->sop) ? strtoupper($data->sop) : 'SOP TITLE IS NOT AVAILABLE' }}</b>
                    </h1>
                    <h1 style="margin-bottom: 50px">
                        <b>{{ isset($data->department->department_name) ? $data->department->department_name : 'DEPARTMENT NAME IS NOT AVAILABLE' }}</b>
                    </h1>
                    <h1 style="margin-bottom: 50px">
                        <b>{{ isset($sop->sop_code) ? $sop->sop_code : 'SOP CODE IS NOT AVAILABLE' }}</b>
                    </h1>
                </center>

                <div id="container">
                    <div>
                        <table class="table table-bordered">
                            <thead>
                                <tr
                                    style="background-color: rgb(216, 215, 215); text-align: center;
                                vertical-align: middle;">
                                    <th
                                        style="text-align: center;
                                    vertical-align: middle;">
                                        PREPARED BY</th>
                                </tr>
                                <tr>
                                    <td>Name:
                                        {{ isset($sop->prepare->staff_name) ? strtoupper($sop->prepare->staff_name) : 'NOT AVAILABLE' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Designation:
                                        {{ isset($sop->prepare->staff_position) ? strtoupper($sop->prepare->staff_position) : 'NOT AVAILABLE' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date: {{ date(' j F Y', strtotime($sop->created_at)) }}</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div>
                        <table class="table table-bordered">
                            <thead>
                                <tr
                                    style="background-color: rgb(216, 215, 215); text-align: center;
                                    vertical-align: middle;">
                                    <th
                                        style="text-align: center;
                                    vertical-align: middle;">
                                        REVIEWED BY</th>
                                </tr>
                                <tr>
                                    <td>Name:
                                        {{ isset($sop->review->staff_name) ? strtoupper($sop->review->staff_name) : 'NOT AVAILABLE' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Designation:
                                        {{ isset($sop->review->staff_position) ? strtoupper($sop->review->staff_position) : 'NOT AVAILABLE' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date: {{ date(' j F Y', strtotime($sop->created_at)) }}</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center"
                                    style="background-color: rgb(216, 215, 215); text-align: center;
                                    vertical-align: middle;">
                                    <th
                                        style="text-align: center;
                                    vertical-align: middle;">
                                        APPROVED BY</th>
                                </tr>
                                <tr>
                                    <td>Name:
                                        {{ isset($sop->approve->staff_name) ? strtoupper($sop->approve->staff_name) : 'NOT AVAILABLE' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Designation:
                                        {{ isset($sop->approve->staff_position) ? strtoupper($sop->approve->staff_position) : 'NOT AVAILABLE' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date: {{ date(' j F Y', strtotime($data->approved_at)) }}</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="page-break"></div>

                <div class="table-responsive" style="margin-top: 10px;">
                    <table class="table table-bordered w-100">
                        <thead>
                            <tr style="text-align: center;
                            vertical-align: middle;">
                                <td rowspan="2">
                                    <img src="{{ URL::to('/') }}/img/INTEC_PRIMARY_LOGO.png" height="60" width="180"
                                        alt="INTEC">
                                </td>
                                <td colspan="2">INTEC EDUCATION COLLEGE</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;
                                vertical-align: middle;">
                                    {{ isset($sop->sop_code) ? $sop->sop_code : 'SOP CODE IS NOT AVAILABLE' }}</td>
                                <td>REVIEW NO. :
                                    @php
                                        $c = '';
                                        if ($sopReview->count() < 0) {
                                            $c = 0;
                                        } else {
                                            $c = $sopReview->count();
                                        }
                                    @endphp
                                    {{ $c }}
                                </td>
                            </tr>
                            <tr style="text-align: center;
                            vertical-align: middle;">
                                <td colspan="3">TITLE: {{ strtoupper($data->sop) }}</td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered w-100">
                        <thead>
                            <tr>
                                <th style="text-align: center;
                                vertical-align: middle;"
                                    colspan="5">
                                    REVIEW RECORD</th>
                            </tr>
                            <tr style="text-align: center;
                            vertical-align: middle;">
                                <td>No.</td>
                                <td>Date</td>
                                <td>Updated By</td>
                                <td>Section</td>
                                <td>Details</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1 @endphp
                            @if (isset($sopReview))
                                @foreach ($sopReview as $sr)
                                    <tr>
                                        <td style="text-align: center; vertical-align: middle;">
                                            {{ $i }}</td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            {{ isset($sr->created_at) ? date(' j F Y', strtotime($sr->created_at)) : '' }}
                                        </td>
                                        <td>{{ isset($sr->staff->staff_name) ? $sr->staff->staff_name : '' }}</td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            {{ isset($sr->section) ? $sr->section : '' }}</td>
                                        <td>
                                            {{ isset($sr->review_record) ? $sr->review_record : '' }}</td>
                                    </tr>
                                    @php $i++ @endphp
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">REVIEW RECORD IS NOT AVAILABLE</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                    <table class="table table-bordered w-100">
                        <thead>
                            <tr>
                                <th style="text-align: center;
                                vertical-align: middle;"
                                    colspan="5">FORMS</th>
                            </tr>
                            <tr style="text-align: center;
                            vertical-align: middle;">
                                <td>No.</td>
                                <td>Code</td>
                                <td>Details</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1 @endphp

                            @if (isset($sopForm))
                                @foreach ($sopForm as $sf)
                                    <tr>
                                        <td
                                            style="text-align: center;
                                    vertical-align: middle;">
                                            {{ $i }}</td>
                                        <td
                                            style="text-align: center;
                                    vertical-align: middle;">
                                            {{ isset($sf->sop_code) ? $sf->sop_code : '' }}</td>
                                        <td>{{ isset($sf->details) ? $sf->details : '' }}</td>
                                    </tr>
                                    @php $i++ @endphp
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3">FORM IS NOT AVAILABLE</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>

                <div class="page-break"></div>

                <div class="table-responsive" style="margin-top: 10px;">
                    <table class="table table-bordered w-100">
                        <thead>
                            <tr style="text-align: center;
                            vertical-align: middle;">
                                <td rowspan="2">
                                    <img src="{{ URL::to('/') }}/img/INTEC_PRIMARY_LOGO.png" height="60" width="180"
                                        alt="INTEC">
                                </td>
                                <td colspan="2">INTEC EDUCATION COLLEGE</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;
                                vertical-align: middle;">
                                    {{ isset($sop->sop_code) ? $sop->sop_code : 'SOP CODE NOT AVAILABLE' }}</td>
                                <td>REVIEW NO. :
                                    @php
                                        $c = '';
                                        if ($sopReview->count() < 0) {
                                            $c = 0;
                                        } else {
                                            $c = $sopReview->count();
                                        }
                                    @endphp
                                    {{ $c }}
                                </td>
                            </tr>
                            <tr style="text-align: center;
                            vertical-align: middle;">
                                <td colspan="3">TITLE: {{ strtoupper($data->sop) }}</td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="table-responsive" style="margin-top: 10px;">
                    <table class=" w-100" style="border: none;">
                        <tr>
                            <td style="font-weight: bold">1.0</td>
                            <td style="font-weight: bold"> Purpose</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td> {!! isset($sop->purpose) ? nl2br($sop->purpose) : 'N/A' !!}</td>
                        </tr>
                    </table>

                    <table class=" w-100" style="border: none; margin-top: 20px;">
                        <tr>
                            <td style="font-weight: bold">2.0</td>
                            <td style="font-weight: bold"> Scope</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{!! isset($sop->scope) ? nl2br($sop->scope) : 'N/A' !!}</td>
                        </tr>
                    </table>

                    <table class=" w-100" style="border: none; margin-top: 20px;">
                        <tr>
                            <td style="font-weight: bold">3.0</td>
                            <td style="font-weight: bold"> Reference</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{!! isset($sop->reference) ? nl2br($sop->reference) : 'N/A' !!}</td>
                        </tr>
                    </table>

                    <table class=" w-100" style="border: none; margin-top: 20px;">
                        <tr>
                            <td style="font-weight: bold">4.0</td>
                            <td style="font-weight: bold"> Definitions</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{!! isset($sop->definition) ? nl2br($sop->definition) : 'N/A' !!}</td>
                        </tr>
                    </table>
                </div>

                <div class="page-break"></div>

                <div class="table-responsive" style="margin-top: 10px;">
                    <table class="table table-bordered w-100">
                        <thead>
                            <tr style="text-align: center;
                            vertical-align: middle;">
                                <td rowspan="2">
                                    <img src="{{ URL::to('/') }}/img/INTEC_PRIMARY_LOGO.png" height="60" width="180"
                                        alt="INTEC">
                                </td>
                                <td colspan="2">INTEC EDUCATION COLLEGE</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;
                                vertical-align: middle;">
                                    {{ isset($sop->sop_code) ? $sop->sop_code : 'SOP CODE IS NOT AVAILABLE' }}</td>
                                <td>REVIEW NO. :
                                    @php
                                        $c = '';
                                        if ($sopReview->count() < 0) {
                                            $c = 0;
                                        } else {
                                            $c = $sopReview->count();
                                        }
                                    @endphp
                                    {{ $c }}
                                </td>
                            </tr>
                            <tr style="text-align: center;
                            vertical-align: middle;">
                                <td colspan="3">TITLE: {{ strtoupper($data->sop) }}</td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="table-responsive" style="margin-top: 10px;">
                    <table class=" w-100" style="border: none;">
                        <tr>
                            <td style="font-weight: bold">5.0</td>
                            <td style="font-weight: bold"> Procedures</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td> {!! isset($sop->procedure) ? nl2br($sop->procedure) : 'N/A' !!}</td>
                        </tr>
                    </table>
                </div>

                <div class="page-break"></div>

                <div class="table-responsive" style="margin-top: 10px;">
                    <table class="table table-bordered w-100">
                        <thead>
                            <tr style="text-align: center;
                            vertical-align: middle;">
                                <td rowspan="2">
                                    <img src="{{ URL::to('/') }}/img/INTEC_PRIMARY_LOGO.png" height="60"
                                        width="180" alt="INTEC">
                                </td>
                                <td colspan="2">INTEC EDUCATION COLLEGE</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;
                                vertical-align: middle;">
                                    {{ isset($sop->sop_code) ? $sop->sop_code : 'SOP CODE IS NOT AVAILABLE' }}</td>
                                <td>REVIEW NO. :
                                    @php
                                        $c = '';
                                        if ($sopReview->count() < 0) {
                                            $c = 0;
                                        } else {
                                            $c = $sopReview->count();
                                        }
                                    @endphp
                                    {{ $c }}
                                </td>
                            </tr>
                            <tr style="text-align: center;
                            vertical-align: middle;">
                                <td colspan="3">TITLE: {{ strtoupper($data->sop) }}</td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="table-responsive" style="margin-top: 10px;">
                    <table class=" w-100" style="border: none;">
                        <tr>
                            <td style="font-weight: bold">6.0</td>
                            <td style="font-weight: bold"> Work Flow of Application for Provisional Accreditation (MQA)
                            </td>
                        </tr>
                    </table>
                    @if (isset($workFlow))
                        @foreach ($workFlow as $wf)
                            <img src="/get-work-flow/{{ $wf->id }}" alt="" title="" class="center"
                                style="max-width: 100%; margin-top: 10px;" />
                        @endforeach
                    @else
                        <p>FLOWCHART IS NOT AVAILABLE</p>
                    @endif
                </div>

                {{-- <div id="footer" class="text-center">
                    <p>UiTM Private Education Sdn Bhd, 947874-D, INTEC Education College, Jalan Senangin Satu 17/2A, Seksyen
                        17, 40200 Shah Alam, Selangor Darul Ehsan, MALAYSIA
                        No Tel : +603 5522 7000 No Fax : +603 5522 7010
                    </p>
                </div> --}}
            </div>
        </div>
    </main>
@endsection
