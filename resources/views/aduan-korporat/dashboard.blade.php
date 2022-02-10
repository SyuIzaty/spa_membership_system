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
                                        <select class="form-control selectfilter" name="year" id="year" required>
                                            <option disabled selected>Please Select</option>
                                            @foreach ($year as $y)
                                                <option value="{{ $y }}">{{ $y }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <h6>Month</h6>
                                        <select class="form-control selectfilter" name="months" id="month"></select>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="card-body">
                                <div class="p-0">
                                    <div class="chart">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive" style="overflow:hidden;">
                                                    <div id="chart1" style="height: 500px"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr style="border-top: 1px solid #b9b8b8;">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive" style="overflow:hidden;">
                                                    <div id="chart2" style="height: 500px"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr style="border-top: 1px solid #b9b8b8;">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive" style="overflow:hidden;">
                                                    <div id="chart4" style="height: 700px"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr style="border-top: 1px solid #b9b8b8;">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive" style="overflow:hidden;">
                                                    <div id="chart3" style="height: 700px"></div>
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
        //chart1
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

        //chart2
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

        //chart3
        var department = <?php echo $department; ?>;
        console.log(department);
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(barchart3);

        function barchart3() {
            var data = google.visualization.arrayToDataTable(department);
            var options = {
            title: 'REPORT BASED ON DEPARTMENT',
            titleTextStyle: {
                color: '333333',
                fontName: 'Arial',
                fontSize: 16,
            },
            bar: {groupWidth: "50%"},
            borderColor: 
                'rgb(135, 48, 14)',
            legend: { position: 'bottom'},
            colors: ['#A7D6AA'],
            } 
            var chart = new google.visualization.BarChart(document.getElementById('chart3'));
            chart.draw(data, options);
        }
        
        //chart4
        var subcategory = <?php echo $subcategory; ?>;
        console.log(subcategory);
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(barchart4);

        function barchart4() {
            var data = google.visualization.arrayToDataTable(subcategory);
            var options = {
            title: 'REPORT BASED ON SUBCATEGORY',
            titleTextStyle: {
                color: '333333',
                fontName: 'Arial',
                fontSize: 16,
            },
            bar: {groupWidth: "50%"},
            borderColor: 
                'rgb(135, 48, 14)',
            legend: { position: 'bottom'},
            colors: ['#ADDCF4'],
            } 
            var chart = new google.visualization.BarChart(document.getElementById('chart4'));
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

            $('#year').on('change',function(){
            $('#month').val('').change();
        });

        $('.selectfilter').on('change',function(){
            var year = $('#year').val();
            var month = $('#month').val();
            if(year && month){

                $.ajax({
                url: "/year-month-dashboard",
                data: {year:year, month:month},
                type: 'POST',
                dataType: "json",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response)
                {
                    console.log(response);
                    if(response)
                    {
                        var userCategory2 = response.countUserCat;
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(barchart1);

                        function barchart1() {
                            var data = google.visualization.arrayToDataTable(userCategory2);
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

                        var category2 = response.countCat;
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(barchart2);

                        function barchart2() {
                            var data = google.visualization.arrayToDataTable(category2);
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

                        var department2 = response.countDepartment;
                        console.log(department2);
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(barchart3);

                        function barchart3() {
                            var data = google.visualization.arrayToDataTable(department2);
                            var options = {
                            title: 'REPORT BASED ON DEPARTMENT',
                            titleTextStyle: {
                                color: '333333',
                                fontName: 'Arial',
                                fontSize: 16,
                            },
                            bar: {groupWidth: "50%"},
                            borderColor: 
                                'rgb(135, 48, 14)',
                            legend: { position: 'bottom'},
                            colors: ['#A7D6AA'],
                            } 
                            var chart = new google.visualization.BarChart(document.getElementById('chart3'));
                            chart.draw(data, options);
                        }

                    }
                },
                error:function(error){
                    console.log(error)
                    alert("Error");
                }
            });

            }
        });
        });




</script>
@endsection

