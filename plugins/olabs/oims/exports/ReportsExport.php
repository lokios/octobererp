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
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class ReportsExport implements WithMultipleSheets {

    use Exportable,
        RegistersEventListeners;

    protected $export_data;

    public function __construct($export_data) {
        $this->export_data = $export_data;
    }

    /**
     * @return array
     */
    public function sheets(): array {
        $sheets = [];

        foreach ($this->export_data as $data) {
            $title = isset($data['title']) ? $data['title'] : '';
            $header = isset($data['header']) ? $data['header'] : [];
            $rows = isset($data['rows']) ? $data['rows'] : [];
            $sheets[] = new ReportExportSheet($title, $header, $rows);
        }

        return $sheets;
    }

}

class ReportExportSheet implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize, WithStrictNullComparison {

    private $title;
    private $rows;
    private $header;

    public function __construct($title, $header, $rows) {
        $this->title = $title;
        $this->header = $header;
        $this->rows = $rows;
    }

    public function headings(): array {
        return $this->header;
    }

    public function collection() {
        return new \Illuminate\Database\Eloquent\Collection($this->rows);
    }

    /**
     * @return string
     */
    public function title(): string {
        return $this->title;
    }

}
