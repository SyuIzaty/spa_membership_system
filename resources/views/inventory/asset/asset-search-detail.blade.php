<div class="panel-container show">
    <div class="panel-content">

        <div class="row">
            <div class="col-sm-12 mb-4">
                <div class="col-sm-12 mb-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header bg-primary-50">
                            <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i>ASSET DETAIL</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="asset" class="table table-bordered table-hover table-striped w-100 mb-1">
                                    <thead>
                                        <tr>
                                            <div class="form-group">
                                                <td width="15%"><label class="form-label" for="department_id"> Department : </label></td>
                                                <td colspan="3">{{ $data->type->department->department_name ?? '--' }}</td>
                                                <td width="15%"><label class="form-label" for="asset_type"> Asset Type : </label></td>
                                                <td colspan="3">{{ $data->type->asset_type ?? '--' }}</td>
                                            </div>
                                        </tr>
                                        <tr>
                                            <div class="form-group">
                                                <td width="15%"><label class="form-label" for="asset_code">Code Type : </label></td>
                                                <td colspan="3">{{ $data->codeType->code_name ?? '--' }}</td>
                                                <td width="15%"><label class="form-label" for="asset_code">Asset Code : </label></td>
                                                <td colspan="3">{{ $data->asset_code ?? '--' }}</td>
                                            </div>
                                        </tr>
                                        <tr>
                                            <div class="form-group">
                                                <td width="15%"><label class="form-label" for="finance_code">Finance Code :</label></td>
                                                <td colspan="3">{{ $data->finance_code ?? '--' }}</td>
                                                <td width="15%"><label class="form-label" for="serial_no">Serial No. : </label></td>
                                                <td colspan="3">{{ $data->serial_no ?? '--' }}</td>
                                            </div>
                                        </tr>
                                        <tr>
                                            <div class="form-group">
                                                <td width="15%"><label class="form-label" for="asset_name">Asset Class :</label></td>
                                                <td colspan="3">{{ $data->assetClass->class_name ?? '--' }}</td>
                                                <td width="15%"><label class="form-label" for="asset_name">Asset Name :</label></td>
                                                <td colspan="3">{{ $data->asset_name ?? '--' }}</td>
                                            </div>
                                        </tr>
                                        <tr>
                                            <div class="form-group">
                                                <td width="15%"><label class="form-label" for="model">Model :</label></td>
                                                <td colspan="3">{{ $data->model ?? '--' }}</td>
                                                <td width="15%"><label class="form-label" for="brand"> Brand : </label></td>
                                                <td colspan="3">{{ $data->brand ?? '--' }}</td>
                                            </div>
                                        </tr>
                                        <tr>
                                            <div class="form-group">
                                                <td width="15%"><label class="form-label" for="custodian_id"> Current Custodian : </label></td>
                                                <td colspan="6">{{ $data->custodian->name ?? '--' }}</td>
                                            </div>
                                        </tr>
                                        <tr>
                                            <div class="form-group">
                                                <td width="15%"><label class="form-label" for="status"> Status :</label></td>
                                                <td colspan="3">
                                                    @if ($data->status == '0')
                                                        INACTIVE
                                                    @else
                                                        ACTIVE
                                                    @endif
                                                    <br><br>
                                                    @if($data->status == '0')
                                                        Date : {{ date('d-m-Y', strtotime($data->inactive_date)) ?? '--' }}
                                                    @endif
                                                </td>
                                                <td width="15%"><label class="form-label" for="status"> Availability :</label></td>
                                                <td colspan="3">
                                                    {{ isset($data->assetAvailability->name) ? strtoupper($data->assetAvailability->name) : '--' }}
                                                </td>
                                            </div>
                                        </tr>
                                        <tr>
                                            <div class="form-group">
                                                <td width="15%"><label class="form-label" for="storage_location"> Location :</label></td>
                                                <td colspan="3">{{ $data->storage_location ?? '--' }}</td>
                                                <td width="15%"><label class="form-label" for="custodian_id"> Set Package : </label></td>
                                                <td colspan="3">
                                                    @if($data->set_package == 'Y')
                                                        YES
                                                    @else
                                                        NO
                                                    @endif
                                                </td>
                                            </div>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            @if($data->set_package == 'Y')
                                <div class="table-responsive">
                                    <table id="assets" class="table table-bordered table-hover w-100 mb-1">
                                        <thead style="background-color: #f7f7f7" class="text-center">
                                            <tr style="white-space: nowrap">
                                                <td>No.</td>
                                                <td>Package Asset Type</td>
                                                <td>Package Serial No.</td>
                                                <td>Package Model</td>
                                                <td>Package Brand</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($data->assetSets) && $data->assetSets->count() > 0)
                                                @foreach ($data->assetSets as $sets)
                                                    <tr align="center">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $sets->type->asset_type }}</td>
                                                        <td>{{ $sets->serial_no }}</td>
                                                        <td>{{ $sets->model }}</td>
                                                        <td>{{ $sets->brand }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr align="center" class="data-row">
                                                    <td valign="top" colspan="6">-- NO SET AVAILABLE --</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
