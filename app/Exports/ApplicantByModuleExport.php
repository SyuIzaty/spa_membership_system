<?php

namespace App\Exports;

use App\Models\ShortCourseManagement\ShortCourseICDLModuleEventParticipant;
use App\Models\ShortCourseManagement\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DateTime;

class ApplicantByModuleExport implements FromCollection, WithMapping, WithEvents, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($data)
    {
        $this->event = $data;
        $this->shortcourse = $data->events_shortcourses[0]->shortcourse;
    }

    public function collection()
    {

        $this->first_row = 1;

        $participantList = ShortCourseICDLModuleEventParticipant::join('scm_shortcourse_icdl_module', 'scm_shortcourse_icdl_module_event_participant.shortcourse_icdl_module_id', '=', 'scm_shortcourse_icdl_module.id')
            ->where('scm_shortcourse_icdl_module.shortcourse_id', '=', $this->shortcourse->id)->orderBy('shortcourse_icdl_module_id')->get(['scm_shortcourse_icdl_module_event_participant.*'])->load(['event_participant.participant','shortcourse_icdl_module']);

            return collect($participantList);
    }

    // public function headings(): array
    // {
    //     return [
    //         'Id',
    //         'shortcourse_icdl_module_id',
    //         'event_participant_id',
    //         'created_at',
    //         'created_by',
    //     ];
    // }

    // public function map($collection): array
    // {
    //     return [
    //         $collection->id,
    //         $collection->shortcourse_icdl_module_id,
    //         $collection->event_participant_id,
    //         Date::dateTimeToExcel($collection->created_at),
    //         $collection->created_by,
    //     ];
    // }

    public function getHeadings(): array
    {
        return [
            'Modules Name',
            'Participant IC',
            'Participant Name',
            'Application DateTime'
        ];
    }

    public function map($collection): array
    {
        $participants = [
            $collection->shortcourse_icdl_module->name,
            $collection->event_participant->participant->ic,
            $collection->event_participant->participant->name,
            $collection->event_participant->participant->created_at
        ];

        $headers = $this->getHeadings();
        if($this->first_row){

            $columns = [
                $headers, $participants,
            ];

        }else{
            $columns = $participants;
        }
        $this->first_row = 0;
        return $columns;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $canvas) {

                // $canvas->sheet->setCellValue('A1', 'Event name:');

                // $canvas->sheet->setCellValue('A2', 'Start DateTime:');

                // $canvas->sheet->setCellValue('A3', 'End DateTime:');

                // $canvas->sheet->setCellValue('A4', 'Venue:');



                // $canvas->sheet->setCellValue('B1', $this->event->name);

                // $canvas->sheet->setCellValue('B2', $this->event->datetime_start);

                // $canvas->sheet->setCellValue('B3', $this->event->datetime_end);

                // $canvas->sheet->setCellValue('B4', $this->event->venue->name);


            }
        ];
    }
}
