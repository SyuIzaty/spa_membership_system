@extends('layouts.admin')
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Space Dashboard
            </h1>
        </div>
        <div class="row">
          <div class="col-sm-6 col-xl-6">
              <div class="p-3 bg-success-300 rounded overflow-hidden position-relative text-white mb-g">
                  <div class="">
                      <h3 class="display-4 d-block l-h-n m-0 fw-500">
                          {{ $open->count() }}
                          <small class="m-0 l-h-n">OPEN 
                            {{-- <b style="font-weight: 900">ROOM</b> --}}
                          </small>
                      </h3>
                  </div>
                  <i class="fal fa-table position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
              </div>
          </div>
          <div class="col-sm-6 col-xl-6">
              <div class="p-3 bg-danger-300 rounded overflow-hidden position-relative text-white mb-g">
                  <div class="">
                      <h3 class="display-4 d-block l-h-n m-0 fw-500">
                          {{ $closed->count() }}
                          <small class="m-0 l-h-n">CLOSED 
                            {{-- <b style="font-weight: 900">ROOM</b> --}}
                          </small>
                      </h3>
                  </div>
                  <i class="fal fa-table position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
              </div>
          </div>
          <div class="col-md-12 mb-4 d-flex">
            <div class="card flex-fill">
                <div class="card-header"><i class="fal fa-burn"></i> Room Type by Block</div>
                <div class="card-body">
                  <canvas id="groupChart" style="height: 400px"></canvas>
                </div>
            </div>
          </div>
          <div class="col-md-6 mb-4 d-flex">
            <div class="card flex-fill">
                <div class="card-header"><i class="fal fa-burn"></i> Room Type</div>
                <div class="card-body">
                  <canvas id="pieChart"></canvas>
                </div>
            </div>
          </div>
          <div class="col-md-6 mb-4 d-flex">
            <div class="card flex-fill">
                <div class="card-header"><i class="fal fa-burn"></i> Open / Closed Room</div>
                <div class="card-body">
                  <canvas id="horizontal-stacker-bar-chart"></canvas>
                </div>
            </div>
          </div>
          <div class="col-md-12 mb-4 d-flex">
            <div class="card flex-fill">
                <div class="card-header"><i class="fal fa-burn"></i> Summary</div>
                <div class="card-body">
                  <form method="get" id="department-form">
                    <div class="row">
                      <div class="col-md-4">
                        <p>Block</p>
                        <select class="form-control select" name="block_id" id="block-select">
                          <option disabled selected>Select Block</option>
                          <option value="All" {{ 'All' == $selected_block ? 'selected' : '' }}>All</option>
                          @foreach ($all_block as $blocks)
                              <option value="{{ $blocks->id }}" {{ $blocks->id == $selected_block ? 'selected' : '' }}>{{ $blocks->name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-4">
                        <p>Room Type</p>
                        <select class="form-control select" name="room_id" id="room-select">
                          <option value="">Select Status</option>
                          <option value="All" {{ 'All' == $selected_room ? 'selected' : '' }}>All</option>
                          @foreach ($all_type as $types)
                              <option value="{{ $types->id }}" {{ $types->id == $selected_room ? 'selected' : '' }}>{{ $types->name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-4">
                        <p>Status</p>
                        <select class="form-control select" name="status_id" id="status-select">
                          <option value="">Select Status</option>
                          <option value="All" {{ 'All' == $selected_status ? 'selected' : '' }}>All</option>
                          <option value="9" {{ 9 == $selected_status ? 'selected' : '' }}>Opened</option>
                          <option value="10" {{ 10 == $selected_status ? 'selected' : '' }}>Closed</option>
                        </select>
                      </div>
                    </div>
                  </form>
                
                  <div id="table-container"></div>
                </div>
            </div>
          </div>
        </div>
    </main>
@endsection
@section('script')
<script>
  $('.select').select2();

  $(document).ready(function () {
    $('#block-select, #status-select, #room-select').change(function () {
        var blockId = $('#block-select').val();
        var statusId = $('#status-select').val();
        var roomId = $('#room-select').val();

        $.ajax({
            type: 'GET',
            url: '/space/getTableData',
            data: {block_id: blockId, status_id: statusId, room_id: roomId},
            dataType: 'json',
            success: function (data) {
                updateTable(data);
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    });

    function updateTable(data) {
        $('#table-container').html(data.table_html);
    }
});
  

  var pie_chart = document.getElementById('pieChart').getContext('2d');

  function fetchChartData() {
    fetch('/space/getChartData')
      .then(response => response.json())
      .then(data => {
          var myChart = new Chart(pie_chart, {
              type: 'pie',
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

  $.ajax({
    url: '/space/getStackChartData',
    method: 'GET',
    success: function (data) {
      var ctx = document.getElementById("horizontal-stacker-bar-chart").getContext('2d');
      var myChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
          labels: ["Opened", "Closed"],
          datasets: data.map(function (block) {
            return {
              label: block.name,
              backgroundColor: block.color,
              data: [block.openCount, block.closedCount],
            };
          }),
        },
        options: {
          hover: {
            mode: 'index',
            intersect: false,
          },
          scales: {
            x: {
              stacked: true,
            },
            y: {
              stacked: true,
            }
          },
          plugins: {
            legend: {
              display: true,
            },
          },
        }
      });
    },
    error: function (error) {
      console.error('Error fetching data:', error);
    }
  });

	
  
  var chartOptions = {
      responsive: true,
      maintainAspectRatio: false,
      legend: {
          position: "top"
      },
      title: {
          display: true,
          text: "Room Type by Block"
      },
      scales: {
          yAxes: [{
              ticks: {
                  beginAtZero: true
              }
          }]
      }
  };

  document.addEventListener("DOMContentLoaded", function () {
      fetchGroupChartData();

      function fetchGroupChartData() {
          fetch('/space/getGroupChartData')
              .then(response => response.json())
              .then(data => {
                  updateGroupChart(data);
              })
              .catch(error => {
                  console.error('Error fetching group chart data:', error);
              });
      }

      function updateGroupChart(data) {
          var group_chart = document.getElementById("groupChart").getContext("2d");
          if (window.myBar) {
              window.myBar.destroy();
          }

          window.myBar = new Chart(group_chart, {
              type: "bar",
              data: {
                  labels: data.labels,
                  datasets: data.datasets,
              },
              options: chartOptions
          });
      }
  });

</script>
@endsection
