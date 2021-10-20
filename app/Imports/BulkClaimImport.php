<?php

namespace App\Imports;

use DB;
use Auth;
use App\TrainingClaim;
use App\TrainingList;
use App\Files;
use Carbon\Carbon;
use App\TrainingHourYear;
use App\TrainingHourTrail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;

class BulkClaimImport implements ToModel, WithHeadingRow, WithValidation, WithStartRow
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
    public function startRow(): int
    {
        return 2;
    }
    
    public function model(array $row)
    {
        $exists = TrainingClaim::where('training_id', $this->id)->where('staff_id', $row['staff_id'])->first();

        if(!isset($exists)) {

            $claim = TrainingClaim::create([
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

            $year = date('Y', strtotime($claim->start_date));
            $totalApprove = TrainingClaim::where( DB::raw('YEAR(start_date)'), '=', $year )->where('staff_id', $claim->staff_id)->where('status', '2')->sum('approved_hour');
            $totalHour = TrainingHourYear::where('year', $year)->first();

            if($totalApprove >= $totalHour->training_hour) {
                $exist = TrainingHourTrail::where('staff_id', $claim->staff_id)->where('year', $year)->where('status', '4')->first();

                if(!isset($exist)) {

                    TrainingHourTrail::where('staff_id', $claim->staff_id)->where('year', $year)->update([
                        'status'            => '4',
                    ]);
                }
            }
        }
    }

    public function rules(): array
    {
        return [
        ];
    }
}
