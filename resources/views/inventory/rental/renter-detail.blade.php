@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-cogs'></i> RENTAL FORM DETAIL
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
                        <div class="row">
                            <div class="col-sm-12 col-md-12 mb-4">
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
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="remark"> Remark :</label></td>
                                                            <td colspan="6">
                                                                {{ $rental->remark ?? 'N/A' }}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <a href="/renter-list" class="btn btn-success ml-auto float-right mr-2"><i class="fal fa-arrow-alt-left"></i> Back</a><br><br>
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

</script>

@endsection
