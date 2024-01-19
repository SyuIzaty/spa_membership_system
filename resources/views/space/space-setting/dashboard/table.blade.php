@if($data['block'] != null)
    <table class="table table-bordered mt-2 text-center">
        <tr class="text-center bg-highlight font-weight-bold">
            <td>Block</td>
            <td>Room Type</td>
            <td>Floor</td>
            <td>Opened</td>
            <td>Closed</td>
        </tr>
        <?php $total_opened = $total_closed = 0;?>
        @foreach($data['block'] as $blocks)
            @foreach($blocks->spaceRooms->groupBy(['room_id']) as $room)
                <tr>
                    <td rowspan="{{ $room->groupBy('floor')->count() + 1 }}" class="font-weight-bold align-middl">{{ $blocks->name }}</td>
                    <td rowspan="{{ $room->groupBy('floor')->count() + 1 }}">{{ $room->first()->spaceRoomType->name }}</td>
                </tr>
                @foreach($room->groupBy('floor') as $room_floor)
                    <?php
                        $room_opened = $room_floor->where('status_id','9')->count();
                        $room_closed = $room_floor->where('status_id','10')->count();
                        $total_opened += $room_opened;
                        $total_closed += $room_closed;
                    ?>
                    <tr>
                        <td>{{ $room_floor->first()->floor }}</td>
                        <td>{{ $room_opened }}</td>
                        <td>{{ $room_closed }}</td>
                    </tr>
                @endforeach
            @endforeach
        @endforeach
        <tr class="text-center font-weight-bold">
            <td colspan="3">Total Open & Closed</td>
            <td>{{ $total_opened }}</td>
            <td>{{ $total_closed }}</td>
        </tr>
        <tr class="text-center font-weight-bold">
            <td colspan="3">Overall</td>
            <td colspan="2">{{ $total_opened + $total_closed }}</td>
        </tr>
    </table>

@endif
