@extends('layouts.form')

@section('content')
<div class="row">
    <div class="col-xl-6">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Daftar <span class="fw-300">Rondaan</span>
                </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <form novalidate="">
                        <div class="form-group">
                            <label class="form-label" for="shift">Waktu Bertugas</label>
                            <select id="shift" class="form-control" size="0">
                                <option value="A">SYIF A (0700 - 1500 hrs)</option>
                                <option value="B">SYIF A (0700 - 1500 hrs)</option>
                                <option value="C">SYIF C (2300 - 0700 hrs)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="location">Lokasi Rondaan</label>
                            <select id="location" class="form-control" size="0">
                                <option value="A">SYIF A (0700 - 1500 hrs)</option>
                                <option value="B">SYIF A (0700 - 1500 hrs)</option>
                                <option value="C">SYIF C (2300 - 0700 hrs)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="location">Sub Lokasi</label>
                            <select id="location" class="form-control" size="0">
                                <option value="A">SYIF A (0700 - 1500 hrs)</option>
                                <option value="B">SYIF A (0700 - 1500 hrs)</option>
                                <option value="C">SYIF C (2300 - 0700 hrs)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="radio-group-1">KEROSAKAN</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadio1">Ada</label>
                                        </div>
                                    </div>
                                    <div class="input-group-text">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadio2">Tiada</label>
                                        </div>
                                    </div>
                                </div>
                                <input type="text" class="form-control" aria-label="Text input with radio button" id="radio-group-1" placeholder="Muat naik bukti bergambar">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="radio-group-1">PEMBAZIRAN</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadio1">Ada</label>
                                        </div>
                                    </div>
                                    <div class="input-group-text">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadio2">Tiada</label>
                                        </div>
                                    </div>
                                </div>
                                <input type="text" class="form-control" aria-label="Text input with radio button" id="radio-group-1" placeholder="Muat naik bukti bergambar">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="radio-group-1">KECUAIAN</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadio1">Ada</label>
                                        </div>
                                    </div>
                                    <div class="input-group-text">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadio2">Tiada</label>
                                        </div>
                                    </div>
                                </div>
                                <input type="text" class="form-control" aria-label="Text input with radio button" id="radio-group-1" placeholder="Muat naik bukti bergambar">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="radio-group-1">BENCANA</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadio1">Ada</label>
                                        </div>
                                    </div>
                                    <div class="input-group-text">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadio2">Tiada</label>
                                        </div>
                                    </div>
                                </div>
                                <input type="text" class="form-control" aria-label="Text input with radio button" id="radio-group-1" placeholder="Muat naik bukti bergambar">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="radio-group-1">AKTIVITI</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadio1">Ada</label>
                                        </div>
                                    </div>
                                    <div class="input-group-text">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadio2">Tiada</label>
                                        </div>
                                    </div>
                                </div>
                                <input type="text" class="form-control" aria-label="Text input with radio button" id="radio-group-1" placeholder="Muat naik bukti bergambar">
                            </div>
                        </div>

                        <div class="row no-gutters">
                            <div class="col-lg-12 pr-lg-1 my-2">
                                <button type="submit" class="btn btn-info btn-block btn-lg waves-effect waves-themed">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
