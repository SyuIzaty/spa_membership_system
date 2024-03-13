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
                        @foreach($status->where('category','Progress') as $statuses)
                        <tr>
                          <td>{{ $statuses->name }}</td>
                          <td>{{ $main->where('progress_id',$statuses->id)->count() }}</td>
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
          <div class="col-md-12 mb-4 d-flex">
            <div class="card flex-fill">
                <div class="card-header"><i class="fal fa-burn"></i> Members</div>
                <div class="card-body" style="height: 400px">
                  <canvas id="memberChart"></canvas>
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

</script>
@endsection
