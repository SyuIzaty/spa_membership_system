<?php

namespace App\Exports;

use App\Models\ShortCourseManagement\EventModuleEventParticipant;
use App\Models\ShortCourseManagement\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;


use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use DateTime;

class ApplicantByModuleExport implements FromCollection, WithStyles, WithMapping, WithEvents, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($data)
    {
        $this->event = $data;
    }

    public function collection()
    {

        $this->first_row = 1;
        $participantList = EventModuleEventParticipant::join('scm_event_module', 'scm_event_module_event_participant.event_module_id', '=', 'scm_event_module.id')
            ->where('scm_event_module.event_id', '=', $this->event->id)->orderBy('event_module_id')->get(['scm_event_module_event_participant.*'])->load(['event_participant.participant', 'event_module']);

        return collect($participantList);
    }
    // public function columnFormats(): array
    // {
    //     return [
    //         'B2:B10' => NumberFormat::FORMAT_TEXT,
    //         'D2:D10' => NumberFormat::FORMAT_DATE_DATETIME,
    //     ];
    // }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->getStyle('A1:F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('F7E7E4');
    }

    // public function headings(): array
    // {
    //     return [
    //         'Id',
    //         'event_module_id',
    //         'event_participant_id',
    //         'created_at',
    //         'created_by',
    //     ];
    // }

    // public function map($collection): array
    // {
    //     return [
    //         $collection->id,
    //         $collection->event_module_id,
    //         $collection->event_participant_id,
    //         Date::dateTimeToExcel($collection->created_at),
    //         $collection->created_by,
    //     ];
    // }

    public function getHeadings(): array
    {
        return [
            'Modules Name',
            'Participant Name',
            'Participant IC',
            'Participant Contact Number',
            'Participant Email',
            'Application DateTime'
        ];
    }

    public function map($collection): array
    {
        $participants = [
            $collection->event_module->name,
            $collection->event_participant->participant->name,
            $collection->event_participant->participant->ic,
            $collection->event_participant->participant->phone,
            $collection->event_participant->participant->email,
            $collection->event_participant->participant->created_at
        ];

        $headers = $this->getHeadings();
        if ($this->first_row) {

            $columns = [
                $headers, $participants,
            ];
        } else {
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
