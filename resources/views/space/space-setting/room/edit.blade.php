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
                            {!! Form::open(['action' => ['Space\SpaceSetting\RoomController@update', $room['id']], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                            <table class="table table-bordered">
                              <tr>
                                <td style="width: 15%">Floor <span class="text-danger">*</span></td>
                                <td style="width: 35%"><input type="number" class="form-control" name="room_floor" value="{{ $room->floor }}"></td>
                                <td style="width: 15%">Room No / Name <span class="text-danger">*</span></td>
                                <td style="width: 35%"><input type="text" class="form-control" name="room_name" value="{{ $room->name }}"></td>
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
                                <td style="width: 35%"><input type="text" class="form-control" name="room_description" value="{{ $room->description }}"></td>
                              </tr>
                              <tr>
                                <td style="width: 15%">Capacity</td>
                                <td style="width: 35%"><input type="number" class="form-control" name="room_capacity" value="{{ $room->capacity }}"></td>
                                <td style="width: 15%">Open / Closed <span class="text-danger">*</span></td>
                                <td style="width: 35%">
                                  <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="status" id="store_status" {{ $room->status_id == 9 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="store_status"></label>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td style="width: 15%">Remark</td>
                                <td style="width: 85%" colspan="3"><input type="text" name="remark" class="form-control" value="{{ $room->remark }}"></td>
                              </tr>
                            </table>

                            @if($item->count() >= 1)
                            <table class="table table-bordered" id="item_table">
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
                                @foreach($item as $items)
                                <tr>
                                  <td style="width: 10%">{{ $items->id }} </td>
                                  <td style="width: 30%">
                                    <select class="form-control select" name="asset_id[{{$items->id}}]">
                                      <option value disabled selected>Please Select</option>
                                      @foreach($asset as $assets)
                                      <option value="{{ $assets->id }}-1" {{ ($items->item_category == 1) ? ($assets->id == $items->item_id ? 'selected' : '') : '' }}>
                                        {{ $assets->asset_name }} [{{ $assets->serial_no }}]
                                      </option>
                                      @endforeach
                                      @foreach($stock as $stocks)
                                      <option value="{{ $stocks->id }}-2" {{ ($items->item_category == 2) ? ($stocks->id == $items->item_id ? 'selected' : '') : '' }}>
                                        {{ $stocks->stock_name }} [{{ $stocks->model }}]
                                      </option>
                                      @endforeach
                                    </select>
                                  </td>
                                  <td style="width: 20%"><input type="number" class="form-control" name="item_quantity[{{$items->id}}]" value="{{ $items->quantity }}"></td>
                                  <td style="width: 30%"><input type="text" class="form-control" name="item_description[{{$items->id}}]" value="{{ $items->description }}"></td>
                                  <td style="width: 10%">
                                    <button type="button" class="btn btn-sm btn-danger btn-delete delete" data-remote="/space/space-setting/room/{{ $items->id }}"> <i class="fal fa-trash"></i></button>
                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                            @endif
                        
                            <button class="btn btn-success btn-sm float-right mb-2">Update</button>
                            <a href="/space/space-setting/block/1/edit" class="btn btn-secondary btn-sm float-right mr-2">Back</a>
                            <a class="btn btn-info btn-sm mb-2 mr-2" href="javascript:;" data-toggle="modal" id="new">Add Item</a>
                            {{Form::hidden('_method', 'PUT')}}
                            {!! Form::close() !!}
                          </div>
                        </div>

                        <div class="modal fade" id="crud-modal" aria-hidden="true" >
                          <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h4 class="modal-title"> Add Item</h4>
                                  </div>
                                  <div class="modal-body">
                                      {!! Form::open(['action' => 'Space\SpaceSetting\SpaceItemController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                      <input type="hidden" name="room_id" value="{{ $room['id'] }}">
                                      <table class="table table-bordered">
                                        <tr>
                                          <td>Item <span class="text-danger">*</span></td>
                                          <td>
                                            <select class="form-control" name="item_id" id="item_id">
                                              <option disabled selected>Please Select</option>
                                              @foreach($asset as $assets)
                                                <option value="{{ $assets->id }}-1">{{ $assets->asset_name }} [{{ $assets->serial_no }}]</option>
                                              @endforeach
                                              @foreach($stock as $stocks)
                                                <option value="{{ $stocks->id }}-2">{{ $stocks->stock_name }} [{{ $stocks->model }}]</option>
                                              @endforeach
                                            </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Description</td>
                                          <td><input type="text" class="form-control" name="item_description"></td>
                                        </tr>
                                        <tr>
                                          <td>Quantity</td>
                                          <td>
                                            <input type="number" class="form-control" name="item_quantity">
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Department <span class="text-danger">*</span></td>
                                          <td>
                                            <select class="form-control" name="department_id" id="department_id">
                                              <option disabled selected>Please Select</option>
                                              @foreach($department as $departments)
                                              <option value="{{ $departments->id }}">{{ $departments->name }}</option>
                                              @endforeach
                                            </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Active</td>
                                          <td>
                                            <div class="custom-control custom-switch">
                                              <input type="checkbox" class="custom-control-input" name="item_status" id="item_status">
                                              <label class="custom-control-label" for="item_status"></label>
                                            </div>
                                          </td>
                                        </tr>
                                      </table>
                                      <button class="btn btn-success btn-sm float-right">Submit</button>
                                      {!! Form::close() !!}
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
  $('#new').click(function () {
      $('#crud-modal').modal('show');
  });

  $('#item_id, #department_id').select2({
    dropdownParent: $('#crud-modal')
  });

  $('.item_id, #room_type, .select').select2();
  $('#item_table').on('click', '.btn-delete[data-remote]', function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var url = $(this).data('remote');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
            url: url,
            type: 'DELETE',
            dataType: 'json',
            data: {method: '_DELETE', submit: true}
            }).always(function (data) {
              location.reload();
            });
        }
    })
  });
</script>
@endsection
