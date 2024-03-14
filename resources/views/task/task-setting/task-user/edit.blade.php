@extends('layouts.admin')
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Dashboard ({{ $member->short_name }})
            </h1>
        </div>
        <div class="row">
            <div class="col-md-5 mb-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-header"><i class="fal fa-burn"></i> Progress</div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <canvas id="pieChart"></canvas>
                            </div>
                            <div class="col-6">
                                <table class="table table-bordered table-striped table-sm mt-3">
                                    @foreach($main->groupby('progress_id') as $mains)
                                    <tr class="text-center">
                                        <td>{{ isset($mains->first()->progressStatus->name) ? $mains->first()->progressStatus->name : '' }}</td>
                                        <td>{{ $mains->count() }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 mb-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-header"><i class="fal fa-burn"></i> Priority</div>
                    <div class="card-body">
                        <canvas id="priorityChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><i class="fal fa-table"></i> Report</div>
                    <div class="card-body">
                        <a href="/task/task-setting/task-user" class="btn btn-secondary btn-sm mb-2">Back</a>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="task_table">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
                                        <th>ID</th>
                                        <th>CATEGORY</th>
                                        <th>DEPARTMENT</th>
                                        <th>TYPE</th>
                                        <th>START DATE</th>
                                        <th>END DATE</th>
                                        <th>SUB CATEGORY</th>
                                        <th>DETAIL</th>
                                        <th>PROGRESS</th>
                                        <th>PRIORITY</th>
                                    </tr>
                                    <tr id="filterRow">
                                      <th class="hasInputFilter"></th>
                                      <th class="hasInputFilter"></th>
                                      <th class="hasInputFilter"></th>
                                      <th class="hasInputFilter"></th>
                                      <th class="hasInputFilter"></th>
                                      <th class="hasInputFilter"></th>
                                      <th class="hasInputFilter"></th>
                                      <th class="hasInputFilter"></th>
                                      <th class="hasInputFilter"></th>
                                      <th class="hasInputFilter"></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
<script>
  var pie_chart = document.getElementById('pieChart').getContext('2d');
  var user_id = {!! $id !!}

  function fetchChartData() {
    fetch('/task/task-dashboard/userChartData/'+user_id)
      .then(response => response.json())
      .then(data => {
          var myChart = new Chart(pie_chart, {
              type: 'doughnut',
              data: {
                  labels: data.labels,
                  datasets: [{
                      data: data.data,
                      backgroundColor: data.color,
                  }]
              },
              options: {
                legend: {
                    display: true
                },
                tooltips: {
                    enabled: true
                }
              }
          });
      })
      .catch(error => {
          console.error('Error fetching chart data:', error);
    });
  }

  fetchChartData();

  var priority_chart = document.getElementById('priorityChart').getContext('2d');

  function fetchPriorityChartData() {
      fetch('/task/task-dashboard/userPriorityData/'+user_id)
        .then(response => response.json())
        .then(data => {
          var myPriorityChart = new Chart(priority_chart, {
              type: 'bar',
              data: {
                  labels: data.labels,
                  datasets: data.datasets
              },
              options: {
                legend: {
                    display: true
                },
                tooltips: {
                    enabled: true
                },
                scales: {
                    xAxes: [{
                        stacked: true
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
              },
          });
        })
        .catch(error => {
            console.error('Error fetching chart data:', error);
        });
  }

  fetchPriorityChartData();

  $(document).ready(function() {
    var table = $('#task_table').DataTable({
    processing: true,
    serverSide: true,
    stateSave: false,
    ajax: {
        url: window.location.href,
    },

    columns: [
            { data: 'id', name: 'id'},
            { data: 'category_name', name: 'taskCategory.name'},
            { data: 'department_name', name: 'departmentList.name'},
            { data: 'type_name', name: 'taskType.name'},
            { data: 'start_date', name: 'start_date'},
            { data: 'end_date', name: 'end_date'},
            { data: 'sub_category', name: 'sub_category'},
            { data: 'detail', name: 'detail'},
            { data: 'progress_name', name: 'progressStatus.name'},
            { data: 'priority_name', name: 'priorityStatus.name'},
        ],
    order: [[ 0, "asc" ]],
    orderCellsTop: true,
    dom:"tpr",
    initComplete: function () {
        $("#task_table thead #filterRow .hasInputFilter").each( function ( i ) {
            var colIdx = $(this).index();
            var input = $('<input class="form-control" type="text">')
                .appendTo( $(this).empty() )
                .on( 'keyup', function () {
                    table.column(colIdx)
                        .search( $(this).val() )
                        .draw();
                } );

        } );
    }
    });

    $.ajaxSetup({
    headers:{
    'X-CSRF-Token' : $("input[name=_token]").val()
    }
    });

  });

</script>
@endsection
