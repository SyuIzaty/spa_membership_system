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
                        <h2>Create Room</h2>
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
                            {!! Form::open(['action' => 'Space\SpaceSetting\RoomController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                            <input type="hidden" name="block_id" value="{{ $id }}">
                            <table class="table table-bordered">
                              <tr>
                                <td style="width: 15%">Room Type <span class="text-danger">*</span></td>
                                <td style="width: 35%">
                                  <select class="form-control" name="room_type" id="room_type">
                                    <option disabled selected>Please Select</option>
                                    @foreach($type as $types)
                                    <option value="{{ $types->id }}">{{ $types->name }}</option>
                                    @endforeach
                                  </select>
                                </td>
                                <td style="width: 15%">Floor <span class="text-danger" name="">*</span></td>
                                <td style="width: 35%"><input type="number" class="form-control" name="room_floor"></td>
                              </tr>
                              <tr>
                                <td style="width: 15%">Room No / Name</td>
                                <td style="width: 35%"><input type="text" class="form-control" name="room_name"></td>
                                <td style="width: 15%">Description</td>
                                <td style="width: 35%"><input type="text" class="form-control" name="room_description"></td>
                              </tr>
                              <tr>
                                <td style="width: 15%">Capacity</td>
                                <td style="width: 35%"><input type="number" class="form-control" name="room_capacity"></td>
                                <td style="width: 15%">Open / Closed <span class="text-danger">*</span></td>
                                <td style="width: 35%">
                                  <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="room_status" id="store_status">
                                    <label class="custom-control-label" for="store_status"></label>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td style="width: 15%">Remark</td>
                                <td style="width: 85%" colspan="3"><input type="text" class="form-control" name="room_remark"></td>
                              </tr>
                            </table>

                            <table class="table table-bordered" id="head_field">
                              <tr class="bg-primary-50">
                                  <td>Item</td>
                                  <td>Quantity</td>
                                  <td>Remark</td>
                                  <td>Action</td>
                              </tr>
                              <tr>
                                  <td>
                                      <select class="form-control item_id" name="item_id[]" required>
                                          <option disabled selected>Please Select</option>
                                          @foreach($asset as $assets)
                                            <option value="{{ $assets->id }}-1">{{ $assets->asset_name }} [{{ $assets->serial_no }}]</option>
                                          @endforeach
                                          @foreach($stock as $stocks)
                                            <option value="{{ $stocks->id }}-2">{{ $stocks->stock_name }} [{{ $stocks->model }}]</option>
                                          @endforeach
                                      </select>
                                  </td>
                                  <td style="width: 20%">
                                      <input type="number" class="form-control" id="item_quantity" name="item_quantity[]">
                                  </td>
                                  <td style="width: 20%">
                                      <input type="text" class="form-control" id="item_remark" name="item_remark[]">
                                  </td>
                                  <td><button type="button" name="addhead" id="addhead" class="btn btn-primary btn-sm">Add More</button></td>
                              </tr>
                            </table>
                            
                            <button class="btn btn-success btn-sm float-right mb-2">Create</button>
                            {!! Form::close() !!}
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
  $('#room_type, .item_id').select2();

  $(document).ready(function() {
    $('#addhead').click(function(){
        i++;
        $('#head_field').append(`
        <tr id="row${i}" class="head-added">
        <td>
          <select class="form-control item_id" name="item_id[]" required>
            <option value="" disabled selected>Please select</option>
            @foreach ($asset as $assets) 
                <option value="{{ $assets->id }}-1">{{ $assets->asset_name }} [{{ $assets->serial_no }}]</option>
            @endforeach
            @foreach ($stock as $stocks) 
                <option value="{{ $stocks->id }}-2">{{ $stocks->stock_name }} [{{ $stocks->model }}]</option>
            @endforeach
          </select>
        </td>
        <td>
            <input type="number" class="form-control" id="item_quantity" name="item_quantity[]">
        </td>
        <td>
            <input type="text" class="form-control" id="item_remark" name="item_remark[]">
        </td>
        <td><button type="button" name="remove" id="${i}" class="btn btn-danger btn_remove btn-sm">X</button></td>
        </tr>
        `);
        $('.item_id').select2();
    });

    var i=1;

    $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id");
        $('#row'+button_id+'').remove();
    });

    $.ajaxSetup({
        headers:{
        'X-CSRF-Token' : $("input[name=_token]").val()
        }
    });


  });
</script>
@endsection
