@extends('layouts.admin')

@section('content')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-file-alt'></i> i-Complaint
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr bg-primary">
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
            
                <div class="panel-container show">
                    <div class="panel-content">
                        
                        <div class="card">
                            <div class="card-header">
                            <div class="card-tools">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h6>Year</h6>
                                        <select class="form-control" name="year" id="year" required>
                                            <option disabled selected>Please Select</option>
                                            @foreach ($year as $y)
                                                <option value="{{ $y }}">{{ $y }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <h6>Month</h6>
                                        <select class="form-control" name="months" id="month"></select>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="card-body">
                                <div class="p-0">
                                    <div class="chart">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <div id="chart1" style="height: 500px"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <div id="chart2" style="height: 500px"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
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

    $(function () {    
        var userCategory = <?php echo $userCategory; ?>;
        console.log(userCategory);
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(barchart1);

        function barchart1() {
            var data = google.visualization.arrayToDataTable(userCategory);
            var options = {
            title: 'REPORT BASED ON USER CATEGORY',
            titleTextStyle: {
                color: '333333',
                fontName: 'Arial',
                fontSize: 16,
            },
            bar: {groupWidth: "80%"},
            borderColor: 
                'rgb(135, 48, 14)',
            legend: { position: 'bottom'},
            colors: ['#F4C7B1'],
            } 
            var chart = new google.visualization.BarChart(document.getElementById('chart1'));
            chart.draw(data, options);
        }

    })

    $(function () {    
        var category = <?php echo $category; ?>;
        console.log(category);
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(barchart2);

        function barchart2() {
            var data = google.visualization.arrayToDataTable(category);
            var options = {
            title: 'REPORT BASED ON CATEGORY',
            titleTextStyle: {
                color: '333333',
                fontName: 'Arial',
                fontSize: 16,
            },
            bar: {groupWidth: "80%"},
            borderColor: 
                'rgb(135, 48, 14)',
            legend: { position: 'bottom'},
            colors: ['#F8ABB3'],
            } 
            var chart = new google.visualization.BarChart(document.getElementById('chart2'));
            chart.draw(data, options);
        }

    })

    $(document).ready(function() {
            $('#year').on('change', function() {
                var year = $(this).val();
                if(year) {
                    $.ajax({
                        url: '/searchYear/' + year,
                        type: "GET",
                        data : {"_token":"{{ csrf_token() }}"},
                        dataType: "json",
                        success:function(data) {
                            if(data){
                                $('#month').empty();
                                $('#month').focus;
                                $('select[name="months"]').append(`<option value="" selected disabled>Please Choose</option>`);
                                $.each(data, function(key, value){
                                    $('select[name="months"]').append('<option value="'+ value +'">' + value + '</option>');
                                });
                            }else{
                                $('#month').empty();
                            }
                        }
                    });
                }else{
                $('#month').empty();
                }
            });
        });

        //---------------------

        $(document).ready(function()
    {
        function createDatatable(year = null ,month = null)
        {
            var check = $.fn.DataTable.isDataTable('#class-group');

            if(check){
                $('#class-group').DataTable().destroy();
            }

            var table = $('#class-group').DataTable({
            processing: true,
            serverSide: true,
            autowidth: false,
            ajax: {
                url: "/data_classgroup",
                data: {year:year, month:month},
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'id', name: 'id'},
                    { data: 'academic_session', name: 'academic_session'},
                    { data: 'programme_code', name: 'programme_code'},
                    { data: 'course_code', name: 'course_code'},
                    { data: 'group_code', name: 'group_code'},
                    { data: 'lect_one', name: 'lect_one'},
                    { data: 'lect_two', name: 'lect_two'},
                    { data: 'lect_venue', name: 'lect_venue'},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {
                },
            });
        }

        $.ajaxSetup({
            headers:{
            'X-CSRF-Token' : $("input[name=_token]").val()
            }
        });

        $('#year').on('change',function(){
            $('#month').val('').change();
        });

        $('.selectfilter').on('change',function(){
            var year = $('#year').val();
            var month = $('#month').val();
            if(year && month){

                createDatatable(year,month);
            }
        });

    });


        //---------------------


</script>
@endsection

