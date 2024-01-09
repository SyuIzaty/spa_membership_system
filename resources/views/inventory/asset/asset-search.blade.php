@extends('layouts.public')

@section('content')
<script src="{{ asset('js/instascan.js') }}"></script>
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{ asset('img/bg-form.jpg') }}); background-size: cover">
    <div class="row">
        <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-center" style="color: black">
                            <div class="p-2">
                                <center><img src="{{ asset('img/intec_logo_new.png') }}" height="120" width="320" class="responsive"/></center><br>
                                <h4 style="text-align: center">
                                    <b>ASSET TRACKING</b>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="panel-container show">
                            <div class="panel-content">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table w-100">
                                            <tr align="center">
                                                <td>
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="card card-primary card-outline">
                                                            <div class="card-body">
                                                                <form action="{{ route('asset_search') }}" method="GET" id="form_find">
                                                                    <div>
                                                                        <div class="table-responsive">
                                                                            <table class="table table-striped w-100">
                                                                                <tr align="center">
                                                                                    <td colspan="2" style="vertical-align: middle"><label class="form-label" for="asset_code"><span class="text-danger">**</span> SCAN HERE</label></td>
                                                                                </tr>
                                                                            </table>
                                                                            <table class="table w-100">
                                                                                <tr align="center">
                                                                                    <td><video id="preview" width="500"></video></td>
                                                                                    <td><select id="cam-list"></select></td>
                                                                                </tr>
                                                                            </table>
                                                                            <table class="table w-100">
                                                                                <tr align="center">
                                                                                    <td style="vertical-align: middle"><input class="form-control" id="asset_code" name="asset_code" placeholder=""></td>
                                                                                    <td style="vertical-align: middle"><button type="button" id="btn-search" class="btn btn-sm btn-danger"><i class="fal fa-location-arrow"></i></button></td>
                                                                                </tr>
                                                                            </table>
                                                                            <span class="text-danger">**</span> Please key in the asset code or scan the QR code to view details
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="panel-container show">
                            <div class="panel-content">
                                <div id="asset-details-container">
                                    @if($request->asset_code != '' && isset($data))
                                        @include('inventory.asset.asset-search-detail')
                                    @else
                                        <div align="center">No Details Available</div>
                                    @endif
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
    <script type="text/javascript">
        $(document).ready(function() {
            // Load Instascan library
            let scanner;
            let selectedCameraIndex = 0;

            function startScanner() {
                scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
                scanner.addListener('scan', function(content) {
                    $("#asset_code").val(content);
                    fetchAssetDetails(content);
                });

                Instascan.Camera.getCameras().then(function(cameras) {
                    if (cameras.length > 0) {
                        updateCameraList(cameras);
                        selectCamera(selectedCameraIndex);
                    } else {
                        console.error('No cameras found.');
                    }
                }).catch(function(e) {
                    console.error(e);
                });
            }

            function updateCameraList(cameras) {
                // Update the camera selection dropdown
                var camList = document.getElementById('cam-list');
                camList.innerHTML = '';

                for (var i = 0; i < cameras.length; i++) {
                    var option = document.createElement('option');
                    option.value = i;
                    option.text = cameras[i].name || 'Camera ' + (i + 1);
                    camList.add(option);
                }

                // Listen for changes in the camera selection dropdown
                camList.addEventListener('change', function() {
                    selectedCameraIndex = parseInt(camList.value, 10);
                    selectCamera(selectedCameraIndex);
                });
            }

            function selectCamera(index) {
                Instascan.Camera.getCameras().then(function(cameras) {
                    var selectedCamera = cameras[index];
                    if (selectedCamera) {
                        scanner.start(selectedCamera);
                    } else {
                        console.error('Selected camera not found.');
                    }
                }).catch(function(e) {
                    console.error(e);
                });
            }

            startScanner();

            $('#asset_code').on('click', '#btn-search', function(e) {
                e.preventDefault();
                fetchAssetDetails($("#asset_code").val());
            });

            function fetchAssetDetails(assetCode) {
                $.ajax({
                    url: "{{ route('asset_search') }}",
                    type: 'GET',
                    data: { asset_code: assetCode },
                    success: function(response) {
                        // Update the asset details container with the fetched details
                        $('#asset-details-container').html(response);
                    },
                    error: function(error) {
                        console.error(error);
                        // Handle the error as needed
                    }
                });
            }
        });
    </script>
@endsection
