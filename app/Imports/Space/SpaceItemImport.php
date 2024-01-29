<?php

namespace App\Imports\Space;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\SpaceBlock;
use App\SpaceRoom;
use App\SpaceItem;


class SpaceItemImport implements ToModel, WithValidation, WithStartRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        $block_id = SpaceBlock::updateOrCreate([
            'name' => $row[0],
        ],[
            'status_id' => 1
        ]);

        $room_id = SpaceRoom::insertGetId([
            'block_id' => $block_id->id,
            'floor' => $row[1],
            'name' => $row[0].$row[2],
            'room_id' => $row[3],
            'status_id' => 9,
        ]);

        for($i=4; $i<=13; $i++){
            SpaceItem::create([
                'room_id' => $room_id,
                'item_category' => (($i==9 || $i == 10 || $i == 11 || $i == 12) ? 3 : 1),
                'item_id' => $i,
                'name' => $row[6],
                'serial_no' => $row[7],
                'quantity' => $row[4],
                'status' => 1
            ]);
        }
    }

    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
        ];
    }
}
