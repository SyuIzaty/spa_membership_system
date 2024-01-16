@extends('layouts.admin')
@section('content')
<style>
</style>
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Space Setting
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Edit Room</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container">
                        <div class="panel-content">
                          <div class="col-md-12">
                            @if ($errors->any())
                              <div class="alert alert-danger">
                                  <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                  <ul>
                                      @foreach ($errors->all() as $error)
                                          <li>{{ $error }}</li>
                                      @endforeach
                                  </ul>
                              </div>
                            @endif
                            @if(session()->has('message'))
                              <div class="alert alert-success">
                                  {{ session()->get('message') }}
                              </div>
                            @endif
                            <table class="table table-bordered">
                              <tr>
                                <td style="width: 15%">Floor <span class="text-danger">*</span></td>
                                <td style="width: 35%"><input type="number" class="form-control" value="{{ $room->floor }}"></td>
                                <td style="width: 15%">Room No / Name <span class="text-danger">*</span></td>
                                <td style="width: 35%"><input type="text" class="form-control" value="{{ $room->name }}"></td>
                              </tr>
                              <tr>
                                <td style="width: 15%">Room Type <span class="text-danger">*</span></td>
                                <td style="width: 35%">
                                  <select class="form-control" name="room_type" id="room_type">
                                    <option disabled>Please Select</option>
                                    @foreach($type as $types)
                                    <option value="{{ $types->id }}" {{ $types->id == $room->room_id ? 'selected' : '' }}>{{ $types->name }}</option>
                                    @endforeach
                                  </select>
                                </td>
                                <td style="width: 15%">Description</td>
                                <td style="width: 35%"><input type="text" class="form-control" value="{{ $room->description }}"></td>
                              </tr>
                              <tr>
                                <td style="width: 15%">Capacity</td>
                                <td style="width: 35%"><input type="number" class="form-control" value="{{ $room->capacity }}"></td>
                                <td style="width: 15%">Open / Closed <span class="text-danger">*</span></td>
                                <td style="width: 35%">
                                  <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="status" id="store_status" {{ $room->status_id == 1 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="store_status"></label>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td style="width: 15%">Remark</td>
                                <td style="width: 85%" colspan="3"><input type="text" class="form-control" value="{{ $room->remark }}"></td>
                              </tr>
                            </table>

                            {{-- <table class="table table-bordered">
                              <thead>
                                <tr class="bg-primary-50 text-center">
                                  <th>ID</th>
                                  <th>Item</th>
                                  <th>Quantity</th>
                                  <th>Remark</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr data-toggle="collapse" data-target=".order2">
                                  <td>1</td>
                                  <td>Projector</td>
                                  <td>2</td>
                                  <td>ok</td>
                                  <td><i class="btn btn-secondary btn-sm fal fa-pencil"></i></td>
                                </tr>
                                <tr class="collapse order2">
                                  <td colspan="5">
                                    <div class="row">
                                      <div class="col-md-4">
                                        <p>Item</p>
                                        <p>
                                          <select class="form-control item_id">
                                            <option>Laptop</option>
                                            <option selected>Projector</option>
                                            <option>Table</option>
                                          </select>
                                        </p>
                                      </div>
                                      <div class="col-md-4">
                                          <p>Quantity</p>
                                          <p><input type="number" class="form-control" value="2"></p>
                                      </div>
                                      <div class="col-md-4">
                                          <p>Remark</p>
                                          <p><input type="text" class="form-control" value="ok"></p>
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                                <tr data-toggle="collapse" data-target=".order3">
                                  <td>2</td>
                                  <td>Table</td>
                                  <td>30</td>
                                  <td></td>
                                  <td><i class="btn btn-secondary btn-sm fal fa-pencil"></i></td>
                                </tr>
                                <tr class="collapse order3">
                                  <td colspan="5">
                                    <div class="row">
                                      <div class="col-md-4">
                                        <p>Item</p>
                                        <p>
                                          <select class="form-control item_id">
                                            <option>Laptop</option>
                                            <option selected>Table</option>
                                            <option>Projector</option>
                                          </select>
                                        </p>
                                      </div>
                                      <div class="col-md-4">
                                          <p>Quantity</p>
                                          <p><input type="number" class="form-control" value="30"></p>
                                      </div>
                                      <div class="col-md-4">
                                          <p>Remark</p>
                                          <p><input type="text" class="form-control" value=""></p>
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table> --}}
                        
                            <button class="btn btn-success btn-sm float-right mb-2">Update</button>
                            <a href="/space/space-setting/block/1/edit" class="btn btn-secondary btn-sm float-right mr-2">Back</a>
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
  $('.item_id, #room_type').select2();
</script>
@endsection
