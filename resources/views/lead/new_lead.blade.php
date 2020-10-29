@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Lead Registration
        </h1>
    </div>
    <div class="row">

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Register <span class="fw-300"><i>New Lead</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      
                        <form action="{{ route('newLead') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <table id="new_lead" class="table table-bordered table-hover table-striped w-100">
                                <thead>

                                    <tr>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="leads_name">Name</label></td>
                                        <td colspan="1"><input value="{{ old('leads_name') }}" class="form-control" id="leads_name" name="leads_name">
                                            @error('leads_name')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                            
                                        <td width="15%"><label class="form-label" for="leads_email">Email</label></td>
                                        <td colspan="3"><input value="{{ old('leads_email') }}" class="form-control" id="leads_email" name="leads_email">
                                            @error('leads_email')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </div>
                                    </tr>

                                    <tr>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="leads_ic">IC Number</label></td>
                                            <td colspan="1"><input value="{{ old('leads_ic') }}" class="form-control" id="leads_ic" name="leads_ic">
                                                @error('leads_ic')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                            </td>

                                                <td width="15%"><label class="form-label" for="leads_phone">Phone Number</label></td>
                                                <td colspan="3"><input value="{{ old('leads_phone') }}" class="form-control" id="leads_phone" name="leads_phone">
                                                    @error('leads_phone')
                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                    @enderror
                                                </td>
                                        </div>
                                    </tr>

                                    <tr>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="leads_source">Source</label></td>
                                            <td width="35%">

                                                <select class="form-control" name="leads_source" id="leads_source" >
                                                    <option value="">-- Select Source --</option>
                                                        <option name="leads_source" id="leads_source" value="Education Carnival" {{ old('leads_source') == "Education Carnival" ? 'selected' : '' }}>Education Carnival</option>
                                                        <option name="leads_source" id="leads_source" value="Social Media" {{ old('leads_source') == "Social Media" ? 'selected' : '' }}> Social Media</option><br>
                                                        <option name="leads_source" id="leads_source" value="Print Media" {{ old('leads_source') == "Print Media" ? 'selected' : '' }}> Print Media</option><br>
                                                        <option name="leads_source" id="leads_source" value="Broadcast Media" {{ old('leads_source') == "Broadcast Media" ? 'selected' : '' }}> Broadcast Media</option><br>
                                                        <option name="leads_source" id="leads_source" value="Family, Friends" {{ old('leads_source') == "Family, Friends" ? 'selected' : '' }}> Family, Friends</option><br>
                                                        <option name="leads_source" id="leads_source" value="Others" {{ old('leads_source') == "Others" ? 'selected' : '' }}> Others</option><br>
                                                    
                                                        @error('leads_source')
                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                        @enderror
                                                </select><br>
                                                
                                            </td>
                                            <td width="15%"><label class="form-label" for="leads_event">Events</label></td>
                                            <td colspan="2">
                                                <input value="{{ old('leads_event') }}" class="form-control" id="leads_event" name="leads_event">
                                                @error('leads_event')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                            </td>
                                        </div>
                                    </tr>
                                     
                                </thead>
                            </table>

                            <table id="lead_prog" class="table table-bordered table-hover table-striped w-100">
                                <tbody>
                                <tr>
                                    <div class="form-group">
                                        <td width="20%"><label class="form-label">Programme Interested</label>
                                        
                                        <td width="20%"><label class="form-label" for="leads_prog1">Programme 1 :</label></td>
                                        <td width="60%">
                                            <select name="leads_prog1" id="leads_prog1" class="leads_prog1 form-control">
                                                <option value="">-- Select Programme --</option>
                                                @foreach ($programme as $program) 
                                                    <option value="{{ $program->programme_code }}" {{ old('leads_prog1') ? 'selected' : '' }}>
                                                        {{ $program->programme_name }}</option>
                                                @endforeach
                                             </select>
                                        </td>
                                        
                                        <tr>
                                            <div class="form-group">
                                                <td></td>
                                                <td width="20%"><label class="form-label" for="leads_prog2">Programme 2 :</label></td>
                                                <td width="60%">
                                                    <select name="leads_prog2" id="leads_prog2" class="leads_prog2 form-control">
                                                        <option value="">-- Select Programme --</option>
                                                        @foreach ($programme as $program) 
                                                            <option value="{{ $program->programme_code }}" {{ old('leads_prog2') ? 'selected' : '' }}>
                                                                {{ $program->programme_name }}</option>
                                                        @endforeach
                                                     </select>
                                                </td>
                                            </div>
                                        </tr>

                                        <tr>
                                            <div class="form-group">
                                                <td></td>
                                                <td width="20%"><label class="form-label" for="leads_prog3">Programme 3 :</label></td>
                                                <td width="60%">
                                                    <select name="leads_prog3" id="leads_prog3" class="leads_prog3 form-control">
                                                        <option value="">-- Select Programme --</option>
                                                        @foreach ($programme as $program) 
                                                            <option value="{{ $program->programme_code }}" {{ old('leads_prog3') ? 'selected' : '' }}>
                                                                {{ $program->programme_name }}</option>
                                                        @endforeach
                                                     </select>
                                                </td>
                                            </div>
                                        </tr>
                                        
                                        </td>
                                        
                                    </div>
                                </tr>
                                </tbody>
                            </table>

                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i></button>	
                                <button style="margin-right:5px" type="reset" class="btn btn-danger ml-auto float-right"><i class="fal fa-redo"></i></button>
                                <a style="margin-right:5px" href="/lead/active_lead" onclick="return confirm('Are you sure to discard data?')" class="btn btn-success ml-auto float-right"><i class="fal fa-trash-alt"></i></a><br><br>
                        </form>
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
