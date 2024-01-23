@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-cogs'></i> RENTAL FORM DETAIL MANAGEMENT
        </h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Edit Rental Detail
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        @if (Session::has('message'))
                            <div class="alert alert-success" style="color: #3b6324"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                        @endif
                        {!! Form::open(['action' => ['Inventory\RentalManagementController@update_rental_detail'], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
                        {{Form::hidden('id', $rental->id)}}
                        <div class="row">
                            <div class="col-sm-12 col-md-12 mb-4">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h5 class="card-title w-100"><i class="fal fa-user width-2 fs-xl"></i>RENTER DETAIL</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <p><span class="text-danger">*</span> Required fields</p>
                                            <table class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="department_id"> Staff ID : </label></td>
                                                            <td colspan="3">
                                                                {{ $rental->staff->staff_id ?? 'N/A' }}
                                                            </td>
                                                            <td width="15%"><label class="form-label" for="staff_name"> Name : </label></td>
                                                            <td colspan="3">
                                                                {{ $rental->staff->staff_name ?? 'N/A' }}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="staff_email"> Email : </label></td>
                                                            <td colspan="3">
                                                                {{ $rental->staff->staff_email ?? 'N/A' }}
                                                            </td>
                                                            <td width="15%"><label class="form-label" for="staff_phone"> Phone No. :</label></td>
                                                            <td colspan="3">
                                                                {{ $rental->staff->staff_phone ?? 'N/A' }}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="staff_dept"> Department : </label></td>
                                                            <td colspan="3">
                                                                {{ $rental->staff->staff_dept ?? 'N/A' }}
                                                            </td>
                                                            <td width="15%"><label class="form-label" for="staff_position"> Position:</label></td>
                                                            <td colspan="3">
                                                                {{ $rental->staff->staff_position ?? 'N/A' }}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i>RENTAL DETAIL</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="department_id"> Asset Code : </label></td>
                                                            <td colspan="3">
                                                                {{ $rental->asset->asset_code ?? 'N/A' }}
                                                            </td>
                                                            <td width="15%"><label class="form-label" for="staff_name"> Asset Name : </label></td>
                                                            <td colspan="3">
                                                                {{ $rental->asset->asset_name ?? 'N/A' }}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="staff_email"> Asset Type : </label></td>
                                                            <td colspan="3">
                                                                {{ $rental->asset->type->asset_type ?? 'N/A' }}
                                                            </td>
                                                            <td width="15%"><label class="form-label" for="staff_phone"> Serial No. :</label></td>
                                                            <td colspan="3">
                                                                {{ $rental->asset->serial_no ?? 'N/A' }}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="staff_dept"> Model : </label></td>
                                                            <td colspan="3">
                                                                {{ $rental->asset->model ?? 'N/A' }}
                                                            </td>
                                                            <td width="15%"><label class="form-label" for="staff_position"> Brand:</label></td>
                                                            <td colspan="3">
                                                                {{ $rental->asset->brand ?? 'N/A' }}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="staff_dept"> Checkout By : </label></td>
                                                            <td colspan="3">
                                                                {{ $rental->user->name ?? 'N/A' }}
                                                            </td>
                                                            <td width="15%"><label class="form-label" for="staff_position"> Checkout Date:</label></td>
                                                            <td colspan="3">
                                                                {{ isset($rental->checkout_date) ? date('d/m/Y | h:i A', strtotime($rental->checkout_date)) : 'N/A' }}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="reason"> Reason : </label></td>
                                                            <td colspan="3">
                                                                {{ $rental->reason ?? 'N/A' }}
                                                            </td>
                                                            <td width="15%"><label class="form-label" for="status"> Current Status:</label></td>
                                                            <td colspan="3">
                                                                @if($rental->status=='0')
                                                                    <div style="text-transform: uppercase; color:red"><b>CHECKOUT</b></div>
                                                                @else
                                                                    <div style="text-transform: uppercase; color:green"><b>RETURNED</b></div>
                                                                @endif
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @if($rental->status=='0')
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="15%"><label class="form-label" for="return_date"><span class="text-danger">*</span> Return Date:</label></td>
                                                                <td colspan="3">
                                                                    <input type="datetime-local" class="form-control" id="return_date" name="return_date" value="{{ isset($rental->return_date) ? $rental->return_date : old('return_date')  }}" required/>
                                                                    @error('return_date')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                                <td width="15%"><label class="form-label" for="space_room_id"><span class="text-danger">*</span> Location : </label></td>
                                                                <td colspan="3">
                                                                    <select class="form-control space_room_id" name="space_room_id" id="space_room_id" required>
                                                                        <option value="">Please Select</option>
                                                                        @foreach ($space as $spaces)
                                                                            <option value="{{ $spaces->id }}" {{ old('space_room_id', ($rental->asset->space_room_id ? $rental->asset->spaceRoom->id : '')) ==  $spaces->id  ? 'selected' : '' }}>
                                                                                {{ $spaces->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('asset_class')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror

                                                                    <input class="form-control" id="space_room_id" name="space_room_id" value="{{ $rental->asset->space_room_id ?? 'N/A' }}" required>
                                                                    @error('space_room_id')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                                </td>
                                                            </div>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="15%"><label class="form-label" for="return_date"> Return To :</label></td>
                                                                <td colspan="3">
                                                                    {{ $rental->returnTo->name ?? 'N/A' }}
                                                                </td>
                                                                <td width="15%"><label class="form-label" for="return_date"> Return Date:</label></td>
                                                                <td colspan="3">
                                                                    {{ isset($rental->return_date) ? date('d/m/Y | h:i A', strtotime($rental->return_date)) : 'N/A' }}
                                                                </td>
                                                            </div>
                                                        </tr>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="15%"><label class="form-label" for="space_room_id"> Location : </label></td>
                                                                <td colspan="6">
                                                                    {{ $rental->asset->spaceRoom->name ?? 'N/A' }}
                                                                </td>
                                                            </div>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="remark"> Remark :</label></td>
                                                            <td colspan="6">
                                                                <textarea class="form-control" id="remark" name="remark">{{ $rental->remark ?? old('remark') }}</textarea>
                                                                @error('remark')
                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                @enderror
                                                            </td>
                                                        </div>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                {!! Form::close() !!}
                                @if($rental->status=='0')
                                    {!! Form::open(['action' => ['Inventory\RentalManagementController@rental_reminder'], 'method' => 'POST', 'id' => 'reminderData', 'enctype' => 'multipart/form-data']) !!}
                                    {{ Form::hidden('id', $rental->id) }}
                                        <button type="submit" id="reminderBtn" class="btn btn-danger ml-auto float-right mr-2"><i class="fal fa-location-arrow"></i> Send Reminder</button>
                                    {!! Form::close() !!}
                                @endif
                                <a href="/rental-list" class="btn btn-success ml-auto float-right mr-2"><i class="fal fa-arrow-alt-left"></i> Back</a><br><br>
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

    document.addEventListener('DOMContentLoaded', function () {
        const reminderBtn = document.getElementById('reminderBtn');
        const reminderForm = document.getElementById('reminderData');

        reminderBtn.addEventListener('click', function () {
            event.preventDefault();

            Swal.fire({
                title: 'Rental Reminder',
                text: 'Are you sure you want to send a reminder for this rental?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value) {
                    reminderForm.submit();
                } else {
                    //
                }
            });
        });
    });

</script>

@endsection
