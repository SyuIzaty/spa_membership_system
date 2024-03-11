@if($data['block'] != null)
    <ul class="nav nav-tabs nav-fill mt-3" role="tablist">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#summary_view" role="tab" aria-selected="true">Summary</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#detail_view" role="tab">Status & Capacity</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#condition_view" role="tab">Condition</a></li>
        </li>
    </ul>
    <div class="tab-content p-3">
        <div class="tab-pane fade active show" id="summary_view" role="tabpanel">
            <div class="row">
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
                                <td rowspan="{{ $room->groupBy('floor')->count() + 1 }}" class="font-weight-bold align-middle">{{ $blocks->name }}</td>
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
            </div>
        </div>
        <div class="tab-pane fade" id="detail_view" role="tabpanel">
            <div class="row">
                <table class="table table-bordered mt-2 text-center">
                    <tr class="text-center bg-highlight font-weight-bold">
                        <td rowspan="2">Block</td>
                        <td rowspan="2">Room Type</td>
                        <td rowspan="2">Unit</td>
                        <td colspan="2">Status</td>
                        <td rowspan="2">Capacity (Pax)</td>
                        <td rowspan="2">Available</td>
                        <td rowspan="2">Not Available</td>
                    </tr>
                    <tr class="bg-highlight">
                        <td>Open</td>
                        <td>Closed</td>
                    </tr>
                    <?php
                        $total_unit = 0;
                        $total_open = 0;
                        $total_closed = 0;
                        $total_capacity = 0;
                        $total_occupied = 0;
                        $total_not_occupied = 0;
                    ?>
                    @foreach($data['block'] as $blocks)
                        @foreach($blocks->spaceRooms->groupBy(['room_id']) as $room)
                        <?php
                            $total_unit += $room->count(); 
                            $total_open += $room->where('status_id',9)->count(); 
                            $total_closed += $room->where('status_id',10)->count(); 
                            $total_capacity += $room->sum('capacity');
                            $total_occupied += $room->where('status_id',9)->sum('capacity');
                            $total_not_occupied += $room->where('status_id',10)->sum('capacity');
                        ?>
                        <tr>
                            <td>{{ $blocks->name }}</td>
                            <td>{{ $room->first()->spaceRoomType->name }}</td>
                            <td>{{ $room->count() }}</td>
                            <td>{{ $room->where('status_id',9)->count() }}</td>
                            <td>{{ $room->where('status_id',10)->count() }}</td>
                            <td>{{ $room->sum('capacity') }}</td>
                            <td>{{ $room->where('status_id',9)->sum('capacity') }}</td>
                            <td>{{ $room->where('status_id',10)->sum('capacity') }}</td>
                        </tr>
                        @endforeach
                    @endforeach
                    <tr class="bg-highlight text-center font-weight-bold">
                        <td colspan="2">TOTAL</td>
                        <td>{{ $total_unit }}</td>
                        <td>{{ $total_open }}</td>
                        <td>{{ $total_closed }}</td>
                        <td>{{ $total_capacity }}</td>
                        <td>{{ $total_occupied }}</td>
                        <td>{{ $total_not_occupied }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="condition_view" role="tabpanel">
            <div class="row">
                <table class="table table-bordered mt-2 text-center">
                    <tr class="text-center bg-highlight font-weight-bold">
                        <td>Block / Issues</td>
                        @foreach($data['condition'] as $conditions)
                        <td>{{ $conditions->name }}</td>
                        @endforeach
                    </tr>
                    <?php 
                        $total_cond = 0;
                    ?>
                    @foreach($data['block'] as $blocks)
                    <tr>
                        <td>{{ $blocks->name }}</td>
                        @foreach($data['condition'] as $conditions)
                        <?php
                            $selected_status = isset($data['selected_status']) ? [$data['selected_status']] : [9,10];
                            $selected_room = isset($data['selected_room']) ? [$data['selected_room']] : $data['all_type']->pluck('id')->toArray();
                            $room_cond = App\SpaceRoomCondition::where('condition_id',$conditions->id)->wherehas('spaceRoom', function($query) use ($blocks, $selected_status, $selected_room){
                                $query->where('block_id',$blocks->id)->whereIn('status_id',$selected_status)->whereIn('room_id',$selected_room);
                            })->count();
                        ?>
                        <td>{{ $room_cond }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                    <tr>
                        <td>Total</td>
                        @foreach($data['condition'] as $conditions)
                        <?php
                            $selected_status = isset($data['selected_status']) ? [$data['selected_status']] : [9,10];
                            $selected_room = isset($data['selected_room']) ? [$data['selected_room']] : $data['all_type']->pluck('id')->toArray();
                            $selected_block = isset($data['selected_block']) ? [$data['selected_block']] : $data['all_block']->pluck('id')->toArray();
                            $room_conds = App\SpaceRoomCondition::where('condition_id',$conditions->id)->wherehas('spaceRoom', function($query) use ($blocks, $selected_status, $selected_room, $selected_block){
                                $query->whereIn('block_id',$selected_block)->whereIn('status_id',$selected_status)->whereIn('room_id',$selected_room);
                            })->count();
                            $room_cond = App\SpaceRoomCondition::where('condition_id',$conditions->id)->count();
                        ?>
                        <td>{{ $room_conds }}</td>
                        @endforeach
                    </tr>
                </table>
            </div>
        </div>
    </div>


@endif
