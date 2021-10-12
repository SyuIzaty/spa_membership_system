<?php

namespace App\Imports;

use Auth;
use App\TrainingClaim;
use App\TrainingList;
use App\Files;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithValidation;

class BulkClaimImport implements ToModel, WithHeadingRow, WithValidation
{
    public function __construct($id, $title, $type, $category, $start_date, $end_date, $start_time, $end_time, $venue, $claim_hour)
    {
        $this->id = $id;
        $this->title = $title;
        $this->type = $type;
        $this->category = $category;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->venue = $venue;
        $this->claim_hour = $claim_hour;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        TrainingClaim::create([
            'staff_id'          => $row['staff_id'],
            'training_id'       => $this->id,
            'title'             => $this->title,
            'type'              => $this->type,
            'category'          => $this->category,
            'start_date'        => $this->start_date,
            'end_date'          => $this->end_date, 
            'start_time'        => $this->start_time,
            'end_time'          => $this->end_time, 
            'venue'             => $this->venue,
            'claim_hour'        => $this->claim_hour, 
            'status'            => '2',
            'form_type'         => 'AF',
            'approved_hour'     => $this->claim_hour, 
            'assigned_by'       => Auth::user()->id,
        ]);
    }

    public function rules(): array
    {
        return [
        ];
    }
}
