<head>
  <meta charset="UTF-8">
  <title>REPORT</title>
</head>

<body>
  <table width="100%">
    <tr>
      <th style="background-color: #A8B6E3;border:1px solid black" rowspan="3">BLOCK</th>
      <th style="background-color: #A8B6E3;border:1px solid black" rowspan="3">FLOOR</th>
      <th style="background-color: #A8B6E3;border:1px solid black" rowspan="3">TYPE</th>
      <th style="background-color: #A8B6E3;border:1px solid black" rowspan="3">NAME</th>
      <th style="background-color: #A8B6E3;border:1px solid black" colspan="{{ ($type->count() + $category->count()) * 3 }}">EQUIPMENT</th>
    </tr>
    <tr>
      @foreach($type as $types)
        <td colspan="3" style="border:1px solid black">{{ $types->asset_type }}</td>
      @endforeach
      @foreach($category as $categories)
        <td colspan="3" style="border:1px solid black">{{ $categories->name }}</td>
      @endforeach
    </tr>
    <?php
      $total = $type->count() + $category->count();
    ?>
    <tr>
      @for($i=1;$i<=$total;$i++)
        <td style="border:1px solid black">Brand</td>
        <td style="border:1px solid black">Serial No</td>
        <td style="border:1px solid black">Quantity</td>
      @endfor
    </tr>
    @foreach($room as $rooms)
      <?php
        if($item_1->where('room_id',$rooms->id)->groupby('item_id')->count() >= 1){
          $all = [];
          foreach($item_1->where('room_id',$rooms->id)->groupby('item_id') as $test){
              $all[] = $test->count();
          }
          $max_all = max($all);
        }
      ?>
      <tr>
        <td style="border:1px solid black">{{ $rooms->spaceBlock->name }}</td>
        <td style="border:1px solid black">{{ $rooms->floor }}</td>
        <td style="border:1px solid black">{{ $rooms->spaceRoomType->name }}</td>
        <td style="border:1px solid black">{{ $rooms->name }}</td>
        @foreach($type as $types)
          <td style="border:1px solid black">
            @foreach($rooms->spaceItems->where('item_category',1)->where('item_id',$types->id) as $it)
            {{ $it->name ?? '-' }} 
              @if($rooms->spaceItems->where('item_category',1)->where('item_id',$types->id)->count() >= 2)
              <br>
              @endif
            @endforeach
          </td>
          <td style="border:1px solid black">
            @foreach($rooms->spaceItems->where('item_category',1)->where('item_id',$types->id) as $it)
            {{ ($it->serial_no) ?? '-' }}
              @if($rooms->spaceItems->where('item_category',1)->where('item_id',$types->id)->count() >= 2)
                <br>
              @endif
            @endforeach
          </td>
          <td style="border:1px solid black">
            @foreach($rooms->spaceItems->where('item_category',1)->where('item_id',$types->id) as $it)
            {{ $it->quantity ?? '-' }}
            @if($rooms->spaceItems->where('item_category',1)->where('item_id',$types->id)->count() >= 2)
              <br>
            @endif
            @endforeach
          </td>
        @endforeach
        @foreach($category as $categories)
          <td style="border:1px solid black">
            @foreach($rooms->spaceItems->where('item_category',3)->where('item_id',$categories->id) as $it)
            {{ $it->name ?? '-' }} 
              @if($rooms->spaceItems->where('item_category',3)->where('item_id',$categories->id)->count() >= 2)
              <br>
              @endif
            @endforeach
          </td>
          <td style="border:1px solid black">
            @foreach($rooms->spaceItems->where('item_category',3)->where('item_id',$categories->id) as $it)
            {{ ($it->serial_no) ?? '-' }}
              @if($rooms->spaceItems->where('item_category',3)->where('item_id',$categories->id)->count() >= 2)
                <br>
              @endif
            @endforeach
          </td>
          <td style="border:1px solid black">
            @foreach($rooms->spaceItems->where('item_category',3)->where('item_id',$categories->id) as $it)
            {{ $it->quantity ?? '-' }}
            @if($rooms->spaceItems->where('item_category',3)->where('item_id',$categories->id)->count() >= 2)
              <br>
            @endif
            @endforeach
          </td>
        @endforeach
      </tr>
    @endforeach
  </table>
</body>
