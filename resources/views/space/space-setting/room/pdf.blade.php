<style>
  @page { margin: 0mm; }
  body {
    margin: 0mm;
    background: url('img/intec_logo.png') no-repeat center center/cover;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 9pt;
  }
  @font-face {
      font-family: 'Montserrat';
      src: url({{ storage_path('fonts/Montserrat-Regular.ttf') }});
  }
  @font-face {
      font-family: 'Butler';
      src: url({{ storage_path('fonts/Butler_Black.otf') }});
  }
  .first-table {
    border-collapse: collapse;
    background-color: white;
    overflow: hidden;
    width: 190mm;
    margin-top: 500px;
    margin-left: 300px;
  }

  .second-table {
    border-collapse: collapse;
    background-color: white;
    overflow: hidden;
    width: 190mm;
    margin-top: 100px;
    margin-left: 300px;
  }

  .course th {
      text-align: center;
  }

  th,
  td {
      font-family: "Motnserrat", sans-serif;
      text-align: left;
      font-size: 9pt;
      padding: 10px;
      border: 1px solid black;
  }
</style>
<body style="background-image:url('img/space_background.jpg'); ">
  <table class="first-table">
    <tr style="background-color: #4a4645">
      <th style="text-align: center; height: 100px; color: white"></th>
      <th style="text-align: center; color: white">NAME</th>
      <th style="text-align: center; color: white">SIGNATURE</th>
      <th style="text-align: center; color: white">DATE</th>
    </tr>
    <tr>
      <td style="height: 100px; width: 20%">Checked by</td>
      <td style="width: 40%">{{ Auth::user()->name }}</td>
      <td style="width: 20%"></td>
      <td style="width: 20%"></td>
    </tr>
    <tr>
      <td style="height: 100px">Verified by</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td style="height: 100px">Approved by</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </table>
  <table class="second-table">
    <tr>
      <th style="text-align: center; width: 20%; height: 50px">LOCATION</th>
      <th style="text-align: center; width: 80%">{{ isset($room->spaceBlock->name) ? $room->spaceBlock->name : '' }}</th>
    </tr>
    <tr>
      <th style="text-align: center; width: 20%; height: 50px">ROOM NO</th>
      <th style="text-align: center; width: 80%">{{ $room->name }}</th>
    </tr>
  </table>
  <table class="second-table">
    <tr style="background-color: #4a4645">
      <th style="text-align: center; width: 10%; height: 100px; color: white">NO</th>
      <th style="text-align: center; width: 40%; color: white">ITEMS</th>
      <th style="text-align: center; width: 10%; color: white">QUANTITY</th>
      <th style="text-align: center; width: 30%; color: white">BRAND</th>
      <th style="text-align: center; width: 20%; color: white">REMARK(S)</th>
    </tr>
    @foreach($item as $items)
    <tr>
      <td style="margin-top: 30px; margin-bottom: 30px; text-align: center">{{ $loop->iteration }}</td>
      <td style="margin-top: 30px; margin-bottom: 30px;">{{ isset($items->spaceCategory->name) ? $items->spaceCategory->name : '' }}</td>
      <td style="margin-top: 30px; margin-bottom: 30px; text-align: center">{{ $items->quantity }}</td>
      <td style="margin-top: 30px; margin-bottom: 30px;">{{ $items->name }}</td>
      <td style="margin-top: 30px; margin-bottom: 30px;">{{ $items->description }}</td>
    </tr>
    @endforeach
  </table>
</body>