@extends('layouts.applicant')
@section('content')
<body>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-center">
                        <div class="p-2">
                            <img src="{{ asset('img/intec_logo.png') }}" class="ml-5"/>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <hr class="mt-2 mb-3">
                    <h2>CHECK APPLICATION</h2>
                    <div class="d-flex justify-content-lg-center">
                        <div class="p-2">
                            {{Form::label('title', 'IC Number')}}
                            {{Form::number('search', '', ['class' => 'form-control', 'placeholder' => 'IC Number', 'id' => 'search'])}}
                        </div>
                        <div class="p-2">
                            <button class="btn btn-primary mt-4" id="but_search">Submit</button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-lg-center" id="userTable">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#but_search').click(function(){
            var userid = Number($('#search').val().trim());
            if(userid > 0){
                fetchRecords(userid);
            }
        });
    });

    function fetchRecords(id){
        $.ajax({
            url: 'check/'+id,
            type: 'get',
            dataType: 'json',
            success: function(response){
                // console.log(response['data']);
                var len = 0;
                $('#userTable tbody').empty();
                if(response['data'] != null){
                    len = response['data'].length;
                }

                if(len > 0){
                    for(var i=0; i<len; i++){
                        var id = response['data'][i].id;
                        var applicant_name = response['data'][i].applicant_name;
                        var status = response['data'][i].applicant_status;
                        var status_1 = response['data'][i].programme_status;
                        var status_2 = response['data'][i].programme_status_2;
                        var status_3 = response['data'][i].programme_status_3;
                        if(status == '3')
                        {
                            var applicantstatus = response['data'][i].applicantstatus.applicant_status;
                            var applicant_programme = response['data'][i].applicantstatus.programme.programme_name;
                            var applicant_major = response['data'][i].applicantstatus.major.major_name;
                            var applicant_year = response['data'][i].applicantstatus.programme.programme_duration;
                            var tr_str =
                            "<div class='row'>"+
                                "<div class='col-md-12'>"+
                                    "<div class='card-header bg-primary text-white'>"+
                                        "<div class='col-md-12'><h5>Congratulation " + applicant_name + "!</h5></div>"+
                                    "</div>"+
                                    "<div class='card'>"+
                                        "<div class='card-body'>"+
                                        "INTEC Education College is pleased to inform you of your admission to our Institute. <br>Please refer to the attachment below for your offer letter and registration instruction."+
                                        "<table class='table table-bordered mt-3'>"+
                                            "<tr><td colspan='2' style='text-align:center'>Programme Details</td></tr>"+
                                            "<tr>"+
                                                "<td>Programme</td>"+
                                                "<td>" + applicant_programme + "</td>"+
                                            "</tr>"+
                                            "<tr>"+
                                                "<td>Major</td>"+
                                                "<td>" + applicant_major + "</td>"+
                                            "</tr>"+
                                            "<tr>"+
                                                "<td>Duration</td>"+
                                                "<td>" + applicant_year + "</td>"+
                                            "</tr>"+
                                        "</table>"+
                                            "<div class='card m-3'>"+
                                                "<div class='row'>"+
                                                    "<div class='col-md-3 ml-3 mb-3'>"+
                                                        "<i class='fal fa-file fa-2x mt-3'></i><a href='/letter?applicant_id="+id+"'> Offer Letter</a>"+
                                                    "</div>"+
                                                "</div>"+
                                            "</div>"+
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                            "</div>";
                        }if(status_1 == '2' && status_2 == '2' && status_3 == '2'){
                            var tr_str = "<h4 class='mt-3'>Sorry " + applicant_name + " you did not meet minimum qualififcation</h4>";
                        }

                        $("#userTable").append(tr_str);
                    }
                }else{
                    var tr_str = "<tr>" +
                        "<td align='center' colspan='4'>No record found.</td>" +
                    "</tr>";

                    $("#userTable").append(tr_str);
                }
            }
        });
    }
</script>
@endsection
