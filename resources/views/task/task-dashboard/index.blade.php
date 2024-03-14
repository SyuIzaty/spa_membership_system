@extends('layouts.admin')
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Space Dashboard
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
                        <tbody id="progressTableBody">
                        </tbody>
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
          <div class="col-md-12 mb-4 d-flex">
            <div class="card flex-fill">
                <div class="card-header"><i class="fal fa-burn"></i> Members</div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-9" style="height: 400px">
                      <canvas id="memberChart"></canvas>
                    </div>
                    <div class="col-3">
                      <table class="table table-bordered table-striped table-sm mt-5">
                        <tbody id="userTableBody">
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
            </div>
          </div>
          <div class="col-md-6 mb-4 d-flex">
            <div class="card flex-fill">
                <div class="card-header"><i class="fal fa-burn"></i> Today Task</div>
                <div class="card-body">
                  @foreach($task as $tasks)
                  <div class="card mb-2" style="border-left: 3px solid {{ isset($tasks->taskUser->color) ? $tasks->taskUser->color : 'blue' }}">
                    <div class="card-body">
                      <div class="d-flex justify-content-between bg-light font-weight-bold">
                        <div>{{ $tasks->sub_category }}</div>
                        <div>{{ isset($tasks->taskUser->short_name) ? $tasks->taskUser->short_name : 'blue' }}</div>
                      </div>
                      <p class="card-text">{{ $tasks->detail }}</p>
                    </div>
                  </div>
                  @endforeach
                  {{ $task->links() }}
                </div>
            </div>
          </div>
          <div class="col-md-6 mb-4 d-flex">
            <div class="card flex-fill">
                <div class="card-header"><i class="fal fa-burn"></i> Department</div>
                <div class="card-body">
                  <table class="table table-bordered table-sm">
                    <thead>
                        <tr class="text-center bg-highlight">
                            <td>Department</td>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
        </div>
    </main>
@endsection
@section('script')
<script>
  var pie_chart = document.getElementById('pieChart').getContext('2d');

  function fetchChartData() {
    fetch('/task/task-dashboard/getChartData')
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
      fetch('/task/task-dashboard/getPriorityData')
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


  var member_chart = document.getElementById('memberChart').getContext('2d');

  function fetchMemberChartData() {
      fetch('/task/task-dashboard/getMemberData')
        .then(response => response.json())
        .then(data => {
            var myPriorityChart = new Chart(member_chart, {
                type: 'horizontalBar',
                data: {
                    labels: data.labels,
                    datasets: data.datasets
                },
                options: {
                  maintainAspectRatio: false,
                  legend: {
                      display: true
                  },
                  tooltips: {
                      enabled: true
                  },
                  scales: {
                      xAxes: [{
                          stacked: true,
                          barPercentage: 0.4
                      }],
                      yAxes: [{
                          stacked: true,
                          barPercentage: 0.4
                      }]
                  }
                },
            });
        })
        .catch(error => {
            console.error('Error fetching chart data:', error);
        });
  }

  fetchMemberChartData();


  $(document).ready(function () {
    $.ajax({
      url: "/task/task-dashboard/fetchMemberTask",
      type: 'GET',
      success: function (data) {
        var userTableBody = $('#userTableBody');
        userTableBody.empty();
        data.forEach(function (user) {
          userTableBody.append(`
            <tr class="text-center">
                <td>${user.short_name}</td>
                <td>${user.task_mains_count}</td>
            </tr>
          `);
        });
      }
    });

    $.ajax({
      url: "/task/task-dashboard/fetchProgressTask",
      type: 'GET',
      success: function (data) {
        var progressTableBody = $('#progressTableBody');
        progressTableBody.empty();
        data.forEach(function (user) {
          progressTableBody.append(`
            <tr class="text-center">
                <td>${user.name}</td>
                <td>${user.task_progresses_count}</td>
            </tr>
          `);
        });
      }
    });

    $.ajax({
      url: "/task/task-dashboard/fetchDepartmentTask",
      type: 'GET',
      success: function (datas) {
        var tableBody = $('#tableBody');
        var tableHeader = $('.bg-highlight');

        tableBody.empty();
        
        tableHeader.html('<td>Department</td>');

        $.each(datas.statuses, function(index, status) {
            tableHeader.append('<td>' + status.name + '</td>');
        });

        $.each(datas.departments, function(index, department) {
            var row = "<tr><td>" + department.name + "</td>";
            
            $.each(datas.statuses, function(index, status) {
                var statusCount = datas.status_counts[department.id][status.id];
                row += "<td class='text-center'>" + statusCount + "</td>";
            });
            
            row += "</tr>";
            tableBody.append(row);
        });
      }
    });
  });

</script>
@endsection
