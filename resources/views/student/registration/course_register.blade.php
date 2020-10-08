@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2 style="font-size: 25px;">
                        Course Registration <small>| record of course registration</small> <span class="fw-300"><i> </i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                
                <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fal fa-info"></i> Message</h5>
                  Course registration for student
              </div>
              
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                      <a data-toggle="tab" class="nav-link" href="#courseInfo" role="tab">Course Info</a>
                  </li>
                  <li class="nav-item">
                      <a data-toggle="tab" class="nav-link" href="#courseReg" role="tab">Course Registration</a>
                  </li>
              </ul>

              <div class="tab-content">
                <div class="tab-pane active" id="courseInfo" role="tabpanel"><br>

                  <div class="panel-container show">
                      <div class="panel-content">
                          <div class="card card-primary card-outline">

                              <div class="card-header bg-highlight">
                                  <h5 class="card-title w-100">REGISTRATION INFORMATION</h5>
                              </div>
                              <div class="card-body">
                                  <table class="table table-bordered">
                                      <tbody>
                                          <tr class="bg-highlight">
                                              <th rowspan="2" style="text-align: center;">SESSION/SEMESTER</th>
                                              <th colspan="2" style="text-align: center;">REGISTRATION DATE</th>
                                              <th colspan="2" style="text-align: center;">INSERT/DELETE COURSE DATE</th>
                                              <th colspan="2" style="text-align: center;">CHANGE SECTION DATE</th>
                                              <th rowspan="2" style="text-align: center;">STATUS</th>
                                              <th rowspan="2" style="text-align: center;">SLIP</th>
                                          </tr>
                                          <tr class="bg-highlight">
                                              <th style="text-align: center;">START</th>
                                              <th style="text-align: center;">END</th>
                                              <th style="text-align: center;">START</th>
                                              <th style="text-align: center;">END</th>
                                              <th style="text-align: center;">START</th>
                                              <th style="text-align: center;">END</th>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"></td>
                                              <td style="text-align: center;"></td>
                                              <td style="text-align: center;"></td>
                                              <td style="text-align: center;"></td>
                                              <td style="text-align: center;"></td>
                                              <td style="text-align: center;"></td>
                                              <td style="text-align: center;"></td>
                                              <td style="text-align: center;"></td>
                                              <td style="text-align: center;"><button class="btn btn-primary btn-light bg-light" onClick="myFunction()"><i class="fal fa-print"></i> Print</button></td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>

                          </div>
                      </div>
                  </div>

                </div>

                <div class="tab-pane" id="courseReg" role="tabpanel"><br>

                  <div class="panel-container show">
                    <div class="panel-content">
                      <div class="row">
                          <div class="col-sm-2">
                            <div class="card bg-warning">
                              <div class="card-body">
                                <p class="card-text text-white"><b>Minimum Credits:</b></p>
                                <h1 class="text-white text-center"><b>5</b><sub style="font-size:8px"> credits</sub></h1>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="card bg-danger">
                              <div class="card-body">
                                <p class="card-text text-white"><b>Maximum Credits:</b></p>
                                <h1 class="text-white text-center"><b>10</b><sub style="font-size:8px"> credits</sub></h1>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="card bg-primary">
                              <div class="card-body">
                                <p class="card-text text-white"><b>Credit Registered:</b></p>
                                <h1 class="text-white text-center"><b>8</b><sub style="font-size:8px"> credits</sub></h1>
                              </div>
                            </div>
                          </div>
                      </div>
                    </div>
                  </div>

                  <div class="panel-container show">
                    <div class="panel-content">
                        <div class="card card-primary card-outline">
                            
                            <div class="card-header bg-highlight">
                              <h5 class="card-title w-100">COURSES OFFERED</h5>
                            </div><br>
    
                            <div class="card-body">
                              <table id="course_offer" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="bg-highlight">
                                        <th style="text-align: center;">NO</th>
                                        <th style="text-align: center;">CODE</th>
                                        <th style="text-align: center;">COURSE NAME</th>
                                        <th style="text-align: center;">SECTION/GROUP</th>
                                        <th style="text-align: center;">CREDIT</th>
                                        <th style="text-align: center;">STATUS</th>
                                        <th style="text-align: center;">LIMIT</th>
                                        <th style="text-align: center;">CURRENT</th>
                                        <th style="text-align: center;">ACTION</th>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Code"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Course Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Section"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Credit"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Status"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Limit"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Current"></td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td> <button type="button" class="btn btn-success btn-sm add-course"><i class="fal fa-plus"></i></button></td>
                                </tbody>
                              </table>
                            </div>
    
                        </div>
                    </div>
                  </div>
    
                  <div class="panel-container show">
                      <div class="panel-content">
                        <div class="card card-primary card-outline">
    
                            <div class="card-header bg-highlight">
                              <h5 class="card-title w-100">COURSES REGISTERED</h5>
                            </div><br>
                            <form id="" action="" >
                              <div class="card-body">
                                <table id="dynamic_field" class="table table-bordered">
                                    <thead>
                                      <tr class="bg-highlight">
                                          <th rowspan="2" style="text-align: left; vertical-align:top">NO.</th>
                                          <th rowspan="2" style="text-align: left; vertical-align:top">COURSE CODE</th>
                                          <th rowspan="2" style="text-align: left; vertical-align:top">COURSE NAME</th>
                                          <th rowspan="2" style="text-align: center; vertical-align:top">SECTION/GROUP</th>
                                          <th colspan="2" style="text-align: center; vertical-align:top">STATUS</th>
                                          <th rowspan="2" style="text-align: center; vertical-align:top">CREDIT HOUR(s)</th>
                                          <th rowspan="2" style="text-align: center; vertical-align:top">ACTION</th>
                                      </tr>
                                      <tr class="bg-highlight">
                                          <th style="text-align: center;">COURSE</th>
                                          <th style="text-align: center;">REGISTRATION</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="background-color: maroon; font-weight: bold; color: white;">
                                            <td colspan="6" style="text-align: right;">TOTAL CREDITS REGISTERED</td>
                                            <td style="text-align: center;"></td>
                                        </tr>
                                    </tbody>
                                </table><br>
                                <button class="btn btn-primary ml-auto float-right" type="submit" onclick="return confirm('Register selected course?')"> Register Course</button><br><br>
                              </div>
                            </form>
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

  var i = 1; 
  var no = 0;

  $('.add-course').click(function(){  
 
          i++; 
          no++;

          var newInput = $('<td>'+no+'</td>' + 
                          '<td>' + '</td>' +
                          '<td>' + '</td>' +
                          '<td>' + '</td>' +
                          '<td>' + '</td>' +
                          '<td>' + '</td>' +
                          '<td>' + '</td>'); 

          var newTr = $('<tr id="row'+i+'"></tr>').append(newInput).append('<td style="text-align: center;"><button type="button" name="remove" id="'+i+'" class="btn btn_remove btn-danger btn-sm"><i class="fal fa-minus"></i></td>');
          $('#dynamic_field thead').append(newTr);
      
  }); 

  $(document).on('click', '.btn_remove', function(){  
      var button_id = $(this).attr("id");   
      $('#row'+button_id+'').remove();  
  });  

</script>

<script type="text/javascript">

  function myFunction(){
      window.location.href = '/student/registration/courseSlip_pdf';  
  }

</script>

@endsection

