@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
  
  <div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr" style="background-color:rgb(97 63 115)">
                <h2>
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                </div>
            </div>
            <div class="panel-container show">
              <div class="panel-content">
                <center><img src="{{ asset('img/intec_logo_new.png') }}" style="height: 120px; width: 320px;"></center><br>
                        <h4 style="text-align: center">
                            <b>ICT EQUIPMENT RENTAL FORM</b>
                        </h4>
              </div> 
              <div class="panel-container show">
                <div class="panel-content">
                  {!! Form::open(['action' => 'TestController@store', 'method' => 'POST', 'id' => 'data', 'enctype' => 'multipart/form-data']) !!}
                  <div class="table-responsive"> 
                    <b><span class="text-danger">*</span> Please enter the following details. <span class="text-danger">*</span> Denotes mandatory information</b>
                    <table id="rent" class="table table-bordered table-hover table-striped w-100">
                      <tr>
                        <th>Name : </th>
                          <td>
                            <input class="form-control" type="text" name="username" size="40" required="required" placeholder="Name" value="{{$staff->staff_name}}" disabled>
                          </td>
                        <th>Designation : </th>
                          <td>
                            <input class="form-control" type="text" name="des" size="40" placeholder="Designation" value="{{$staff->staff_position}}" disabled>
                          </td>
                      </tr>
                      <tr>
                        <th>Staff ID No : </th>
                          <td>
                            <input class="form-control" type="text" name="id" size="40" placeholder="Staff ID No" value="{{$staff->staff_id}}" disabled>
                          </td>
                        <th><span class="text-danger">*</span> HP/ Extension No. : </th>
                        <td>
                          <input class="form-control" type="text" name="hpno" size="40" placeholder="Number phone" required>
                          @error('rentdate')
                            <p style="color: red"><strong> {{ $message }} </strong></p>
                          @enderror
                        </td>
                      </tr> <br><br>
                      <tr>
                        <th>Department : </th>
                          <td>
                            <input class="form-control" type="text" name="department" size="40" placeholder="department" value="{{$staff->staff_dept}}" disabled>
                          </td>
                        <th><span class="text-danger">*</span> Room No : </th>
                          <td>
                            <input class="form-control" type="text" name="room_no" size="40" placeholder="Room No" required>
                            @error('rentdate')
                              <p style="color: red"><strong> {{ $message }} </strong></p>
                            @enderror
                          </td>
                      </tr>
                      <tr>
                        <th><span class="text-danger">*</span> Rental Date Commences : </th>
                          <td>
                            <input class="form-control" type="date" name="rentdate" size="40" required>
                              @error('rentdate')
                                <p style="color: red"><strong> {{ $message }} </strong></p>
                              @enderror
                          </td>
                        <th><span class="text-danger">*</span> Returned Date : </th>
                          <td>
                            <input class="form-control" type="date" name="retdate" size="40" required>
                              @error('rentdate')
                              <p style="color: red"><strong> {{ $message }} </strong></p>
                              @enderror
                          </td>
                      </tr>
                      <tr>
                        <th><span class="text-danger">*</span> Purpose : </th>
                          <td>
                            <input class="form-control" type="text" name="purpose" size="40" placeholder="purpose" required>
                              @error('rentdate')
                              <p style="color: red"><strong> {{ $message }} </strong></p>
                              @enderror
                          </td>
                      </tr>
                    </table><br><br>
                  </div>
                  <div class="subheader">
                    <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                      <li>
                        <a href="#" disabled style="pointer-events: none">
                          <span class=""> Equipment Rented</span>
                        </a>
                      </li><p>
                    </ol>
                  </div>
                  <table class="table table-bordered table-hover table-striped w-80" align="center" required>
                    <tr align="center">
                      <th></th>
                      <th style="width:400px">Item</th>
                      <th style="width:400px">Serial Number</th>
                      <th style="width:400px">Description</th>
                    </tr>
                    {{-- take from database --}}
                    {{-- equipment from controller-fx index --}}
              
                    @foreach($equipment as $equipments) 
                    <tr>
                      <td>
                        <input name="equipment_id" id="{{$equipments->id}}" type="checkbox" value="{{$equipments->id}}">
                      </td>
                      <td>{{$equipments->equipment_name}}</td>
                      <td><input class="form-control" type="text" name="sn[{{$equipments->id}}]" width="400"></td>
                      <td><input class="form-control" type="text" name="des[{{$equipments->id}}]" size="50"></td>
                    </tr>
                    @endforeach
                  </table><br/>
                  <div align="center">
                    <button type="submit" id="btnSubmit" class="btn btn-primary ml-auto float-center waves-effect waves-themed"><i class="fal fa-location-arrow"></i> Submit Form</button>                    <button style="margin-right:5px" type="reset" class="btn btn-danger ml-auto float-center waves-effect waves-themed"><i class="fal fa-redo"></i> Reset</button>                  </div>
                  {!! Form::close() !!}
      
                  <div class="subheader">
                    <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                      <li>
                        <a href="#" disabled style="pointer-events: none">
                          <span background-color:> Renter's Terms and Conditions</span>
                        </a>
                      </li><p></p>
                    </ol>
                  </div>
                  <h4>1. I agree to be responsible for all the equipment I am renting, as documented on this form.</h4>
                  <h4>2. Borrowed equipment will be returned no later than 1 DAY after the last date of use.</h4>
                  <h4>3. I may be subject to action if I do not comply with the rules.</h4><br><br><br>
                  <table>
                    <tr>
                      <th>.......................................</th>
                      <th></th>
                      <th>.......................................</th>
                    </tr>
                    <tr>
                      <td>Application's Signature</td>
                      <td></td>
                      <td>Checked Out By :</td>
                    </tr>
                    <tr>
                      <td>Date :</td>
                      <td width="400">&nbsp;</td>
                      <td>Date :</td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td>Stamp :</td>
                    </tr>
                  </table><br><br>
                  <div class="subheader">
                    <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                      <li>
                          <a href="#" disabled style="pointer-events: none">
                              <span class=""> Returned Equipment</span>
                          </a>
                      </li>
                      <p>
                  </ol>
                  </div><br><br>
                  <table>
                    <tr>
                      <th>.......................................</th>
                      <th></th>
                      <th>.......................................</th>
                    </tr>
                    <tr>
                      <td>Application's Signature</td>
                      <td width="400">&nbsp;</td>
                      <td>Checked Out By :</td>
                    </tr>
                    <tr>
                      <td>Date :</td>
                      <td></td>
                      <td>Date :</td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td>Stamp :</td>
                    </tr>
                  </table> <br><br><br>
                  <h6>* Application can only be made by INTEC staff.</h6>
                  <h6>** Loan is subject to availability of equipment in the IT Office</h6><br><br>
                      <a href="javascript:window.print()" download="document.docx" class="btn btn-primary float-center waves-effect waves-themed">Download File</a>      
                      <a href="/show" class="btn btn-primary float-center waves-effect waves-themed">View Record</a>
                </div>
              </div>
            </div>
          </div>
      </div>
  </div>
</main>
@endsection