<?php

namespace App\Http\Controllers\Space\SpaceSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\FacilityRoomType;
use App\FacilityRoom;
use App\FacilityBlock;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $all_block = FacilityBlock::get();
        $all_type = FacilityRoomType::get();
        $open = FacilityRoom::StatusId(1)->get();
        $closed = FacilityRoom::StatusId(2)->get();
        if(isset($request->block_id) || isset($request->status_id)){
            $selected_block = $request->block_id;
            $selected_status = $request->status_id;
            $selected_room = $request->room_id;
        }else{
            $block = $selected_block = $selected_status = $selected_room = null;
        }

        return view('space.space-setting.dashboard.index',compact('open','closed','all_block','all_type','selected_block','selected_status','selected_room'));
    }

    public function getChartData()
    {
        $type = FacilityRoomType::get();
        $all_room = $total_room = [];
        foreach ($type as $types) {
            $all_room[] = $types->name;
            $all_color[] = $types->color;
            $total_room[] = FacilityRoom::RoomId($types->id)->count();
        }

        $data = [
            'labels' => $all_room,
            'data' => $total_room,
            'color' => $all_color,
        ];

        return response()->json($data);
    }

    public function getStackChartData()
    {
        $all_blocks = FacilityBlock::get();
        $data = [];

        foreach ($all_blocks as $block) {
        $openCount = FacilityRoom::where('status_id', 1)->where('block_id', $block->id)->count();
        $closedCount = FacilityRoom::where('status_id', 2)->where('block_id', $block->id)->count();

            $data[] = [
                'name' => $block->name,
                'color' => $block->color,
                'openCount' => $openCount,
                'closedCount' => $closedCount,
            ];
        }

        return response()->json($data);
    }

    public function getGroupChartData()
    {
        $types = FacilityRoomType::get();
        $all_blocks = FacilityBlock::get();
        $labels = $all_blocks->pluck('name')->toArray();
        $datasets = [];

        foreach ($types as $type) {
            $label = $type->name;
            $data = FacilityRoom::where('room_id', $type->id)
                ->selectRaw('block_id, count(*) as count')
                ->groupBy('block_id')
                ->get();

            $dataset = [
                'label' => $label,
                'backgroundColor' => $type->color,
                'data' => $this->mergeDataWithAllBlocks($data, $all_blocks),
            ];

            $datasets[] = $dataset;
        }

        return response()->json([
            'labels' => $labels,
            'datasets' => $datasets,
        ]);
    }
    
    private function mergeDataWithAllBlocks($data, $all_blocks)
    {
        $mergedData = [];

        foreach ($all_blocks as $block) {
            $found = $data->firstWhere('block_id', $block->id);

            if ($found) {
                $mergedData[] = $found->count;
            } else {
                $mergedData[] = 0;
            }
        }

        return $mergedData;
    }

    public function getTableData(Request $request)
    {
        $filters = [
            'block_id' => $request->block_id ?? null,
            'status_id' => $request->status_id ?? null,
            'room_id' => $request->room_id ?? null,
        ];
    
        $all_block = FacilityBlock::get();
        $open = FacilityRoom::StatusId(1)->get();
        $closed = FacilityRoom::StatusId(2)->get();
    
        if ($filters['block_id'] == 'All') {
            $filters['block_id'] = null;
        }
    
        if ($filters['status_id'] == 'All') {
            $filters['status_id'] = null;
        }

        if ($filters['room_id'] == 'All') {
            $filters['room_id'] = null;
        }
    
        $facility_room = $filters['status_id'] ? FacilityRoom::StatusId($filters['status_id'])->pluck('id')->toArray() : FacilityRoom::pluck('id')->toArray();
        $facility_room_id = $filters['room_id'] ? FacilityRoom::RoomId($filters['room_id'])->pluck('id')->toArray() : FacilityRoom::pluck('id')->toArray();
    
        $combine = array_intersect($facility_room, $facility_room_id);
        $cond = "1";
        if ($filters['block_id'] !== null) {
            $cond .= " AND (id = '" . $filters['block_id'] . "')";
        }
    
        $block = FacilityBlock::whereRaw($cond)
            ->when($filters['status_id'], function ($query) use ($combine) {
                return $query->whereHas('facilityRooms', function ($query) use ($combine) {
                    $query->whereIn('id', $combine);
                });
            })
            ->with(['facilityRooms' => function ($query) use ($combine) {
                $query->whereIn('id', $combine);
            }])
            ->get();
    
        $data = [
            'block' => $block,
            'selected_block' => $filters['block_id'],
            'selected_status' => $filters['status_id'],
            'selected_room' => $filters['room_id'],
        ];
    
        return response()->json(['table_html' => view('space.space-setting.dashboard.table', compact('data'))->render()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
