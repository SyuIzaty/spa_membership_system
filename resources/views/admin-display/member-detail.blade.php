@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        @php
            $mem = \App\Customer::where('user_id', $member->user_id)->whereHas('customerPlans', function ($query) {
                        $query->active();
                    })->first();
        @endphp
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-user'></i> @if(isset($mem)) MEMBER @else NON-MEMBER @endif DETAIL MANAGEMENT
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 mb-4">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i>@if(isset($mem)) MEMBER @else NON-MEMBER @endif DETAIL</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="asset" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                    <thead>
                                                        <div style="float: right"><b>Updated Date : </b>{{ date(' Y/m/d | h:i:s A', strtotime($member->updated_at) )}}</div><br>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="25%"><label class="form-label" for="user_id"> ID : </label></td>
                                                                <td colspan="3">{{ $member->user_id ?? 'No information to display' }}</td>
                                                                <td width="25%"><label class="form-label" for="customer_name"> Name : </label></td>
                                                                <td colspan="3">{{ $member->customer_name ?? 'No information to display' }}</td>
                                                            </div>
                                                        </tr>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="25%"><label class="form-label" for="customer_ic"> Identification Card/Passport No. : </label></td>
                                                                <td colspan="3">{{ $member->customer_ic ?? 'No information to display' }}</td>
                                                                <td width="25%"><label class="form-label" for="customer_email"> Email : </label></td>
                                                                <td colspan="3">{{ $member->customer_email ?? 'No information to display' }}</td>
                                                            </div>
                                                        </tr>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="25%"><label class="form-label" for="customer_phone"> Phone No. : </label></td>
                                                                <td colspan="3">{{ $member->customer_phone ?? 'No information to display' }}</td>
                                                                <td width="25%"><label class="form-label" for="customer_gender"> Gender : </label></td>
                                                                <td colspan="3">
                                                                    @if($member->customer_gender == 'M')
                                                                        Male
                                                                    @else
                                                                        Female
                                                                    @endif
                                                                </td>
                                                            </div>
                                                        </tr>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="25%"><label class="form-label" for="customer_address"> Address : </label></td>
                                                                <td colspan="3">{{ $member->customer_address ?? 'No information to display' }}</td>
                                                                <td width="25%"><label class="form-label" for="customer_state"> State : </label></td>
                                                                <td colspan="3">{{ $member->customer_state ?? 'No information to display' }}</td>
                                                            </div>
                                                        </tr>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="25%"><label class="form-label" for="customer_postcode"> Postcode : </label></td>
                                                                <td colspan="3">{{ $member->customer_postcode ?? 'No information to display' }}</td>
                                                                <td width="25%"><label class="form-label" for="customer_start_date"> Join Date : </label></td>
                                                                <td colspan="3">{{ $member->customer_start_date ?? 'No information to display' }}</td>
                                                            </div>
                                                        </tr>
                                                        @if(isset($mem))
                                                            @php
                                                                $activePlan = $mem->customerPlans()
                                                                    ->active()
                                                                    ->orderBy('start_date', 'asc')
                                                                    ->first();
                                                            @endphp
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%" style="background-color: #fbc0ff"><label class="form-label" for="membership_id"> Current Membership ID : </label></td>
                                                                    <td colspan="3" style="background-color: #fbc0ff">{{ $activePlan->membership_id ?? 'No information to display' }}</td>
                                                                    <td width="25%" style="background-color: #fbc0ff"><label class="form-label" for="plan_id"> Current Membership Plan : </label></td>
                                                                    <td colspan="3" style="background-color: #fbc0ff">{{ $activePlan->membershipPlan->plan_name ?? 'No information to display' }}</td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%" style="background-color: #fbc0ff"><label class="form-label" for="start_date"> Current Membership Start : </label></td>
                                                                    <td colspan="3" style="background-color: #fbc0ff">{{ date('Y/m/d', strtotime($activePlan->start_date)) ?? 'No information to display' }}</td>
                                                                    <td width="25%" style="background-color: #fbc0ff"><label class="form-label" for="end_date"> Current Membership End : </label></td>
                                                                    <td colspan="3" style="background-color: #fbc0ff">{{ date('Y/m/d', strtotime($activePlan->end_date)) ?? 'No information to display' }}</td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%" style="background-color: #fbc0ff"><label class="form-label" for="membership_payment"> Current Membership Price (RM) : </label></td>
                                                                    <td colspan="3" style="background-color: #fbc0ff">{{ $activePlan->membership_payment ?? 'No information to display' }}</td>
                                                                    <td width="25%" style="background-color: #fbc0ff"><label class="form-label" for="membership_payment_status"> Current Membership Payment Status : </label></td>
                                                                    <td colspan="3" style="background-color: #fbc0ff">{{ $activePlan->membership_payment_status ?? 'No information to display' }}</td>
                                                                </div>
                                                            </tr>
                                                        @endif
                                                    </thead>
                                                </table>
                                                <br>
                                                <a style="margin-right:5px" href="/list-member" class="btn btn-secondary ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a><br><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h5 class="card-title w-100"><i class="fal fa-cogs width-2 fs-xl"></i>BOOKING LIST</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="bkg" class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr class="text-center bg-danger-50" style="white-space: nowrap">
                                                            <th>Booking ID</th>
                                                            <th>Booking Date</th>
                                                            <th>Booking Time</th>
                                                            <th>Booking Status</th>
                                                            <th>Booking Payment</th>
                                                            <th>Booking Payment Status</th>
                                                            <th>Booking Services</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
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
        $(document).ready(function()
        {
            var id = "{{ $member->user_id }}";

            var table = $('#bkg').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/data-member-booking/" + id,
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                },
                columns: [
                        { className: 'text-center', data: 'id', name: 'id' },
                        { className: 'text-center', data: 'booking_date', name: 'booking_date' },
                        { className: 'text-center', data: 'booking_time', name: 'booking_time' },
                        { className: 'text-center', data: 'booking_status', name: 'booking_status'},
                        { className: 'text-center', data: 'booking_payment', name: 'booking_payment' },
                        { className: 'text-center', data: 'booking_payment_status', name: 'booking_payment_status' },
                        { className: 'text-center', data: 'service_id', name: 'service_id', orderable: false, searchable: false }
                    ],
                    orderCellsTop: true,
                    "order": [[ 1, "desc" ]],
                    "initComplete": function(settings, json) {

                    }
            });
        });
    </script>
@endsection
