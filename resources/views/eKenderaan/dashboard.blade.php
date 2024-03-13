@extends('layouts.admin')
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-car'></i> e-Kenderaan
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Dashboard</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10"
                                data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Driver</label>
                                    <select class="selectfilter form-control driver" name="driver" id="driver">
                                        <option value="">All</option>
                                        @foreach ($driver as $d)
                                            <option value="{{ $d->id }}">{{ $d->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Year</label>
                                    <select class="form-control selectfilter year" name="year" id="year">
                                        <option value="">All</option>
                                        @php
                                            $currentYear = date('Y');
                                        @endphp
                                        @for ($year = 2023; $year <= $currentYear; $year++)
                                            <option value="{{ $year }}">{{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                {{-- <div class="col-md-3">
                                    <label>Month</label>
                                    <select class="form-control selectfilter month" name="month[]" id="month"
                                        multiple="multiple">
                                        <option value="">All</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div> --}}
                            </div>
                        </div>

                        <div class="panel-content">
                            <div class="alert alert-danger alert-dismissible fade show p-2 mb-3">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                                </button>
                                <div class="d-flex align-items-center">
                                    <div class="alert-icon width-8">
                                        <span class="icon-stack icon-stack-md">
                                            <i class="base-2 icon-stack-3x color-danger-400"></i>
                                            <i class="base-10 text-white icon-stack-1x"></i>
                                            <i class="fal fa-info-circle color-danger-800 icon-stack-2x"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1 pl-1">
                                        Please be advised that loading times may be longer due to the retrieval of extensive
                                        information.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel-tag"
                                        style="border-left: 3px solid #886ab5; background: #f5f0fd; color: black">
                                        <b>Summary</b>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="driverSummary"
                                            class="table table-bordered table-hover table-striped w-100"
                                            style="white-space: nowrap">
                                            <thead id="monthHeader"></thead>
                                            <tbody id="driverDataBody"></tbody>
                                            <tfoot id="totalFooter"></tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#driver, #year, #month').select2();

            function updaateDriverData() {
                var filters = {
                    driver: $('#driver').val(),
                    year: $('#year').val(),
                    month: $('#month').val(),
                };

                $.ajax({
                    type: 'GET',
                    url: '/dashboard-driver',
                    data: filters,
                    success: function(data) {
                        $('#monthHeader').html(data.monthData);
                        $('#driverDataBody').html(data.driverData);
                        $('#totalFooter').html(data.totalData);
                    },
                    error: function(error) {
                        console.error('Error fetching summary data:', error);
                    }
                });
            }

            $('.selectfilter').change(function() {
                updaateDriverData();
            });

            updaateDriverData();
        });
    </script>
@endsection
