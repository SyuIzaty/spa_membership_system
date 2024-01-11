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
                            <b>ROOM & SPACE REQUEST FORM</b>
                        </h4>

                        <div class="panel-container show">
                            <div class="panel-content">
                              @if(session()->has('error'))
                                <div class="alert alert-danger">
                                    {{ session()->get('error') }}
                                </div>
                              @endif
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
                              @if(session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                              @endif                              

                              <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                  <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true" style="display: none;">Tab 1</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false" style="display: none;">Tab 2</a>
                                </li>
                              </ul>
                              
                              <div class="progress mb-3">
                                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              
                              {!! Form::open(['action' => 'Space\BookingController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                              <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                                  <div>
                                      <div class="table-responsive">
                                        <p style="font-style: italic"><span class="text-danger">*</span> Required Fields</p>
                                        <table class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Applicant Name :</label></td>
                                                        <td colspan="3">
                                                            {{ $user->name ?? '--'}}
                                                        </td>
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Staff / Student ID :</label></td>
                                                        <td colspan="3">
                                                            {{ $user->id ?? '--'}}
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Department / Programme :</label></td>
                                                        <td colspan="5">
                                                            @if($user->category == 'STF')
                                                              {{ isset($user->staff->staff_dept) ? $user->staff->staff_dept : '--' }}
                                                            @endif
                                                            @if($user->category == 'STD')
                                                              {{ isset($user->student->students_programme) ? $user->student->students_programme : '--' }}
                                                            @endif
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                  <div class="form-group">
                                                      <td width="20%" style="vertical-align: middle"><label class="form-label"> Office No :</label></td>
                                                      <td colspan="3">
                                                          <input type="text" class="form-control" name="office_no">
                                                      </td>
                                                      <td width="20%" style="vertical-align: middle"><span class="text-danger">*</span> <label class="form-label"> H/P :</label></td>
                                                      <td colspan="3">
                                                        @if($user->category == 'STF')
                                                          <input type="text" class="form-control" name="phone_number" value="{{ isset($user->staff->staff_phone) ? $user->staff->staff_phone : '--' }}">
                                                        @endif
                                                        @if($user->category == 'STD')
                                                          <input type="text" class="form-control" name="phone_number" value="{{ isset($user->student->students_phone) ? $user->student->students_phone : '--' }}">
                                                        @endif
                                                      </td>
                                                  </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Purpose :</label></td>
                                                        <td colspan="6">
                                                          <input type="text" class="form-control" name="purpose">
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Number of User :</label></td>
                                                        <td colspan="6">
                                                          <input type="number" class="form-control" name="no_user">
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Start Date :</label></td>
                                                        <td colspan="3">
                                                            <input type="date" class="form-control" id="start_date" name="start_date">
                                                          
                                                        </td>
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> End Date :</label></td>
                                                        <td colspan="3">
                                                            <input type="date" class="form-control" id="end_date" name="end_date">
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Start Time :</label></td>
                                                        <td colspan="3">
                                                            <input type="time" class="form-control" id="start_time" name="start_time">
                                                        </td>
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> End Time :</label></td>
                                                        <td colspan="3">
                                                            <input type="time" class="form-control" id="end_time" name="end_time">
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Venue :</label></td>
                                                        <td colspan="5">
                                                          <div class="frame-wrap">
                                                            @php
                                                              $input_per_line = 3;
                                                              $venue_array = $venue->toArray();
                                                              $venue_count = count($venue_array);
                                                            @endphp
                                                            @for ($i = 0; $i < $venue_count; $i += $input_per_line)
                                                            <div class="row mb-2">
                                                              @foreach(array_slice($venue_array, $i, $input_per_line) as $venues)
                                                                <div class="col">
                                                                  <div class="custom-control custom-checkbox custom-control-inline custom-checkbox-circle">
                                                                    <input type="checkbox" class="custom-control-input" id="defaultInline{{ $venues['id'] }}" name="venue[{{ $venues['id'] }}]">
                                                                    <label class="custom-control-label" for="defaultInline{{ $venues['id'] }}">
                                                                      {{ $venues['name'] }} <span class="text-danger font-weight-bold">({{ $venues['maximum'] }} MAX)</span>
                                                                    </label>
                                                                  </div>
                                                                </div>
                                                              @endforeach
                                                            </div>
                                                            @endfor
                                                          </div>
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label">Requirement :</label></td>
                                                        <td colspan="5">
                                                          <div class="alert alert-info" role="alert">
                                                            <strong>Note:</strong><br>
                                                            @if($id == 10)
                                                            <ul>
                                                              <li><strong>Lab B : </strong> PA System, LCD (1), Microphone (2)</li>
                                                              <li><strong>Lab C: </strong> LCD, Microphone Portable</li>
                                                              <li><strong>Dewan Seminar: </strong> PA System, Microphone (2), LCD</li>
                                                              <li><strong>Discussion Room: </strong> TV</li>
                                                              <li><strong>Gallery & Reading Room: </strong>TV. The use of PA systems, LCD, microphone can be requested at Unit Majlis INTEC</li>
                                                            </ul>
                                                            <b>
                                                              Additional PA systems or changing the layout of the space can be requested at Unit Majlis INTEC.
                                                            </b>
                                                            @endif
                                                            @if($id == 1)
                                                            <ul>
                                                              <li><strong>Lab C : </strong> Projector (1)</li>
                                                              <li><strong>Lab U123 : </strong> Projector (1)</li>
                                                              <li><strong>Lab R201 : </strong> Projector (1)</li>
                                                              <li><strong>Lab R202 : </strong> Projector (1)</li>
                                                              <li><strong>Lab R203 : </strong> Projector (1)</li>
                                                              <li><strong>Lab R204 : </strong> Projector (1)</li>
                                                            </ul>
                                                            @endif
                                                          </div>
                                                          <div class="frame-wrap">
                                                            @php
                                                              $item_per_line = 1;
                                                              $item_array = $item->toArray();
                                                              $item_count = count($item_array);
                                                            @endphp
                                                          
                                                            @for ($i = 0; $i < $item_count; $i += $item_per_line)
                                                              <div class="row mb-2">
                                                                @foreach(array_slice($item_array, $i, $item_per_line) as $items)
                                                                  <div class="col-md-12">
                                                                    <label>
                                                                        <input type="checkbox" name="checks[{{ $items['id'] }}]" >
                                                                    </label>
                                                                    <label>{{ $items['name'] }}</label>
                                                                  </div>
                                                                @endforeach
                                                              </div>
                                                            @endfor
                                                          </div>
                                                          
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label">Remark :</label></td>
                                                        <td colspan="5">
                                                          <input type="text" class="form-control" id="remark" name="remark">
                                                        </td>
                                                    </div>
                                                </tr>
                                                @if($id == 11)
                                                <tr>
                                                  <div class="form-group">
                                                    <td width="20%" style="vertical-align: middle"><label class="form-label"></label>Attachment <b>(Floor Plan for Dewan Besar INTEC, Old Library & etc)</b> :</label></td>
                                                    <td colspan="5">
                                                      <input type="file" name="attachment_booked" class="form-control" accept="image/png, image/jpeg, application/pdf">
                                                    </td>
                                                  </div>
                                                </tr>
                                                @endif
                                            </thead>
                                        </table>                          
                                      </div>
                                  </div>
                                  <a href="#" type="button" class="btn btn-primary float-right mb-3" id="nextBtn">Next</a>
                                </div>

                                <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                                  <h5 style="text-align: center" class="mt-3">
                                    @if($id == 10)
                                    <b>PERATURAN PENGGUNAAN RUANG PERPUSTAKAAN</b>
                                    @endif
                                    @if($id == 1)
                                    <b>PERATURAN PENGGUNAAN RUANG LAB KOMPUTER</b>
                                    @endif
                                    @if($id == 11)
                                    <b>PERATURAN PENGGUNAAN RUANG FASILITI</b>
                                    @endif
                                    @if($id == 7)
                                    <b>PERATURAN PENGGUNAAN RUANG PEJABAT KETUA EKSEKUTIF</b>
                                    @endif
                                  </h5>
                                  <ol>
                                    <li style="margin-bottom:10pt">
                                      Tempahan ruang 
                                      @if($id == 10)
                                      <b>perpustakaan</b>
                                      @endif
                                      @if($id == 1)
                                      <b>lab komputer</b>
                                      @endif 
                                      @if($id == 1)
                                      <b>fasiliti</b>
                                      @endif 
                                      @if($id == 7)
                                      <b>pejabat ketua eksekutif</b>
                                      @endif 
                                      hendaklah dibuat selewat - lewatnya 3 hari sebelum tarikh penggunaan. 
                                      (Sebarang tembahan tanpa borang tidak akan dilayan)
                                    </li>
                                    @if($id == 10)
                                    <li style="margin-bottom:10pt">
                                      Pemohon hendaklah menghubungi pegawai yang bertugas di kaunter IT dan kaunter Perkhidmatan Pelanggan untuk
                                      memastikan kekosongan ruang sebelum mengisi borang tempahan.
                                    </li>
                                    <li style="margin-bottom:10pt">
                                      Sebarang tempahan Makmal IT hendaklah berurusan dengan pegawai di kaunter Makmal IT (ext: 7097) sahaja.
                                    </li>
                                    <li style="margin-bottom:10pt">
                                      Sebarang tempahan ruang lain di perpustakaan selain Makmal IT hendaklah berurusan dengan pegawai 
                                      Kaunter Perkhidmatan Pelanggan (ext: 7219) sahaja.
                                    </li>
                                    @endif
                                    @if($id == 10 && $id == 1)
                                    <li style="margin-bottom:10pt">
                                      Pihak 
                                      @if($id == 10)
                                      <b>perpustakaan</b>
                                      @endif
                                      @if($id == 1)
                                      <b>IITU</b>
                                      @endif
                                      tidak menyediakan sebarang perkhidmatan mengubah susun atur bilik / ruang perpustakaan.
                                    </li>
                                    @endif
                                    <li style="margin-bottom:10pt">
                                      Sekiranya memerlukan tambahan peralatan atau mengubah susun atur ruang, boleh terus berurusan dengan pihak unit majlis
                                      INTEC sehingga program selesai. (urusan ini di antara pegawai yang menempah ruang perpustakaan dengan unit majlis sahaja)
                                    </li>
                                    <li style="margin-bottom:10pt">
                                      Sebarang pembatalan tempahan ruang, mohon untuk memaklumkan kepada pegawai yang bertugas sekurang - kurangnya
                                      sehari sebelum tarikh penggunaan.
                                    </li>
                                    <li style="margin-bottom:10pt">
                                      Sila pastikan keadaan bilik / ruang
                                      @if($id == 10)
                                      <b>perpustakaan</b>
                                      @endif
                                      @if($id == 1)
                                      <b>lab komputer</b>
                                      @endif 
                                      yang telah digunakan berkeadaan baik seperti sediakala selepas
                                      penggunaan untuk memberi keselesaan kepada pengguna seterusnya.
                                    </li>
                                  </ol>

                                  <h5 style="text-align: center" class="mt-5">
                                    <b>AKUAN PEMOHON</b><br>
                                    @if($id == 10)
                                    <b>PINJAMAN PERALATAN DI BILIK DAN RUANG PERPUSTAKAAN</b>
                                    @endif
                                    @if($id == 1)
                                    <b>PINJAMAN PERALATAN DI BILIK DAN RUANG LAB KOMPUTER</b>
                                    @endif
                                    @if($id == 7)
                                    <b>PINJAMAN PERALATAN DI BILIK DAN RUANG PEJABAT KETUA EKSEKUTIF</b>
                                    @endif
                                  </h5>
                                  Saya yang bernama <b>{{Auth::user()->name}}</b> Mengaku memohon pinjaman dan penggunaan peralatan di Bilik dan Ruang 
                                  @if($id == 10)
                                  <b>perpustakaan</b>
                                  @endif
                                  @if($id == 1)
                                  <b>lab komputer</b>
                                  @endif 
                                  @if($id == 7)
                                  <b>pejabat ketua eksekutif</b>
                                  @endif 
                                  dan saya telah membaca
                                  serta memahami peraturan dan prosedur dibawah ini:
                                  <ol >
                                    <li style="margin-bottom:10pt">Saya mengaku bahawa butiran diri yang saya berikan adalah sah dan benar.</li>
                                    <li style="margin-bottom:10pt">Saya bertanggungjawab sepenuhnya ke atas peralatan yang dipinjamkan dan digunakan.</li>
                                    <li style="margin-bottom:10pt">
                                      Saya bersedia menanggung segala kos pembayaran jika peralatan yang dipinjam dan digunakan hilang,
                                      rosak atau gagal dipulangkan. Kadar gantirugi adalah sama dengan harga asal peralatan.
                                    </li>
                                    <li style="margin-bottom:10pt">
                                      Saya mengaku bahawa saya akan membayar segala denda yang dikenakan ke atas saya akibat kecuaian 
                                      saya sendiri.
                                    </li>
                                  </ol>
                                  <button class="btn btn-success float-right mb-3 mt-3">Submit</button>
                                  <a href="#" type="button" class="btn btn-primary float-right mb-3 mr-2 mt-3" id="prevBtn" disabled>Previous</a>
                                </div>
                              </div>
                              {!! Form::close() !!}

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
  $(document).ready(function() {
    var progressBar = $(".progress-bar");
    var tabs = $(".nav-link");
    var currentIndex = 0;
  
    function updateProgress() {
      var tabCount = tabs.length;
      var progressPercentage = (currentIndex / (tabCount - 1)) * 100;
      progressBar.css("width", progressPercentage + "%");
      progressBar.attr("aria-valuenow", progressPercentage);
    }
  
    $("#nextBtn").click(function() {
      currentIndex++;
      updateProgress();
  
      if (currentIndex >= tabs.length - 1) {
        $("#nextBtn").prop("disabled", true);
        currentIndex = tabs.length - 1;
      }
  
      // Show the next tab
      tabs.eq(currentIndex).tab("show");
  
      $("#prevBtn").prop("disabled", false);
    });
  
    $("#prevBtn").click(function() {
      currentIndex--;
      updateProgress();
  
      if (currentIndex <= 0) {
        currentIndex = 0;
      }
  
      // Show the previous tab
      tabs.eq(currentIndex).tab("show");
  
      $("#nextBtn").prop("disabled", false);
    });
  
    // Disable clicking the tabs directly
    tabs.click(function(e) {
      e.preventDefault();
    });
  
    $("#prevBtn").prop("disabled", false);
  });

  function toggleInput(checkbox) 
  {
    var inputField = checkbox.parentNode.parentNode.nextElementSibling.querySelector('input[type="number"]');
    
    if (checkbox.checked) {
        inputField.removeAttribute('disabled');
    } else {
        inputField.setAttribute('disabled', 'disabled');
        inputField.value = '';
    }
  }

</script>
@endsection

