<?php

namespace Olabs\Oims\Exports;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;


use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;


use Olabs\Oims\Models\Project;

class DprExport implements FromQuery, WithMapping, WithHeadings, WithColumnFormatting, ShouldAutoSize, WithTitle, WithEvents {

    use Exportable,
        RegistersEventListeners;

    public function map($project): array {
        return [
            $project->name,
            $project->address,
//            $project->created_at
            \PhpOffice\PhpSpreadsheet\Shared\Date::dateTimeToExcel($project->created_at),
        ];
    }

    public function headings(): array {
        return [
            'Project Name',
            'Address',
            'Created Date',
        ];
    }

    public function columnFormats(): array {
        return [
//            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'C' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY,
//            'C' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
        ];
    }

    /**
     * @return string
     */
    public function title(): string {
        return 'Month ';
    }

    public static function beforeExport(BeforeExport $event) {
        $event->writer->getDelegate()->getProperties()->setCreator('OIMS');
    }

    public static function afterSheet(AfterSheet $event) {

        $event->sheet->getDelegate()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $event->sheet->getDelegate()->getStyle('C1:C28')->applyFromArray(
//                'C1:C28', 
                [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => 'FFFF0000'],
                        ],
                    ]
                ]
        );
    }

    public function query() {
        return Project::query();
    }

    public function collection() {
        return Project::all();
    }

}
