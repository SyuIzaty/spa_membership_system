@extends('layouts.admin')

@section('content')
<style>
    .td-green td {background-color: rgb(67, 250, 67);}
    .td-yellow td {background-color: rgb(139, 255, 139);}
    .td-red td {background-color: rgb(176, 245, 176);}
</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
      <ol class="breadcrumb page-breadcrumb">
          <li class="breadcrumb-item"><a href="javascript:void(0);">INTEC IDS</a></li>
          <li class="breadcrumb-item">Arkib</li>
          <li class="breadcrumb-item active">Arkib Dashboard</li>
      </ol>

      <div class="subheader">
          <h1 class="subheader-title">
              <div class="row">
                  <div class="col-md-10">
                      <i class="subheader-icon fal fa-chart-area"></i> Arkib <span class="fw-300">Dashboard</span>
                  </div>
              </div>
          </h1>
      </div>

      <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header bg-primary-500"><i class="fal fa-burn"></i> Department Arkib {{ $selected_year }}</div>
                <div class="card-body">
                    <div id="barchart" style="height: 400px;"></div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-primary-500"><i class="fal fa-burn"></i> Arkib Status {{ $selected_year }}</div>
                <div class="card-body">
                    <div id="piechart" style="height: 400px;"></div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
          <div class="card h-100">
              <div class="card-header bg-primary-500"><i class="fal fa-cubes"></i> Top Department with Most Record {{ $selected_year }}</div>
              <div class="card-body">
                  <table class="table m-0">
                      <thead>
                          <tr>
                              <th>Rank</th>
                              <th>Department</th>
                              <th>Total</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($arkib_rank as $arkib_ranks)
                              <tr class="
                                  @if($loop->iteration == 1)
                                      {{ 'td-green' }} 
                                  @elseif($loop->iteration == 2) 
                                      {{ 'td-yellow' }}
                                  @elseif($loop->iteration == 3)
                                      {{ 'td-red' }}
                                  @endif
                              ">
                                  <td class="text-center">{{ $arkib_no++ }}</td>
                                  <td class="text-left">
                                    {{ isset($arkib_ranks->department->department_name) ? Str::title($arkib_ranks->department->department_name) : '' }}
                                  </td>
                                  <td class="text-center">{{ $arkib_ranks->total }}</td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
        </div>

        <div class="col-md-4 mb-4">
          <div class="card h-100">
              <div class="card-header bg-primary-500"><i class="fal fa-cubes"></i> Top Document with Most View {{ $selected_year }}</div>
              <div class="card-body">
                  <table class="table m-0">
                      <thead>
                          <tr>
                              <th>Rank</th>
                              <th>File</th>
                              <th>Total View</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($view_rank as $view_ranks)
                              <tr class="
                                  @if($loop->iteration == 1)
                                      {{ 'td-green' }} 
                                  @elseif($loop->iteration == 2) 
                                      {{ 'td-yellow' }}
                                  @elseif($loop->iteration == 3)
                                      {{ 'td-red' }}
                                  @endif
                              ">
                                  <td class="text-center">{{ $train_no++ }}</td>
                                  <td class="text-left">
                                    {{ isset($view_ranks->arkibAttachment->file_name) ? 
                                    Str::title(substr($view_ranks->arkibAttachment->file_name, 12)) : '' }}
                                  </td>
                                  <td class="text-center">{{ $view_ranks->total }}</td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
        </div>

        <div class="col-md-4 mb-4">
          <div class="card h-100">
              <div class="card-header bg-primary-500"><i class="fal fa-cubes"></i> Top Staff with Most View {{ $selected_year }}</div>
              <div class="card-body">
                <table class="table m-0">
                  <thead>
                      <tr>
                          <th>Rank</th>
                          <th>Staff Name</th>
                          <th>Total View</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($staff_rank as $staff_ranks)
                          <tr class="
                              @if($loop->iteration == 1)
                                  {{ 'td-green' }} 
                              @elseif($loop->iteration == 2) 
                                  {{ 'td-yellow' }}
                              @elseif($loop->iteration == 3)
                                  {{ 'td-red' }}
                              @endif
                          ">
                              <td class="text-center">{{ $staff_no++ }}</td>
                              <td>{{ isset($staff_ranks->user->name) ? Str::title($staff_ranks->user->name) : '' }}</td>
                              <td class="text-center">{{ $staff_ranks->total }}</td>
                          </tr>
                      @endforeach
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
  $('#year').select2();

  $(function () {    
      var category = <?php echo $category; ?>;
          
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart1);
      function drawChart1() {
          var data = google.visualization.arrayToDataTable(category);
          var options = {
              titleTextStyle: {
                  color: '666666',
                  fontName: 'Roboto',
                  fontSize: 16,
                  bold: false,
              },
              bar: {groupWidth: "80%"},
              borderColor: 
                  'rgb(38, 244, 255)',
              legend: { position: 'bottom'},
              is3D: true,
          } 
          var chart = new google.visualization.ColumnChart(document.getElementById('barchart'));
          chart.draw(data, options);
      }
  })
</script>

<script>
    $(function () {    
        var type = <?php echo $type; ?>
            
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart1);
        function drawChart1() {
            var data = google.visualization.arrayToDataTable(type);
            var options = {
            titleTextStyle: {
                color: '666666',
                fontName: 'Roboto',
                fontSize: 16,
                bold: false,
            },
            bar: {groupWidth: "80%"},
            borderColor: 
                'rgb(135, 48, 14)',
            legend: { position: 'bottom'},
            is3D: true,
            } 
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }
    })
</script>
@endsection
