<?php

namespace Maatwebsite\Excel\Jobs;

use Illuminate\Bus\Queueable;
use Maatwebsite\Excel\Writer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AppendDataToSheet implements ShouldQueue
{
    use Queueable, Dispatchable;

    /**
     * @var array
     */
    public $data = [];

    /**
     * @var string
     */
    public $filePath;

    /**
     * @var string
     */
    public $writerType;

    /**
     * @var int
     */
    public $sheetIndex;

    /**
     * @var object
     */
    public $sheetExport;

    /**
     * @param object $sheetExport
     * @param string $filePath
     * @param string $writerType
     * @param int    $sheetIndex
     * @param array  $data
     */
    public function __construct($sheetExport, string $filePath, string $writerType, int $sheetIndex, array $data)
    {
        $this->sheetExport = $sheetExport;
        $this->data        = $data;
        $this->filePath    = $filePath;
        $this->writerType  = $writerType;
        $this->sheetIndex  = $sheetIndex;
    }

    /**
     * @param Writer $writer
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function handle(Writer $writer)
    {
        $writer = $writer->reopen($this->filePath, $this->writerType);

        $sheet = $writer->getSheetByIndex($this->sheetIndex);

        $sheet->appendRows($this->data, $this->sheetExport);

        $writer->write($this->filePath, $this->writerType);
    }
}
