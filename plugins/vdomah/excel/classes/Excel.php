<?php namespace Vdomah\Excel\Classes;

use October\Rain\Support\Traits\Singleton;
use Maatwebsite\Excel\Sheet;

class Excel
{
    use Singleton;

    protected $excel;

    protected function init()
    {
        \App::register('\Maatwebsite\Excel\ExcelServiceProvider');

        $facade = \Illuminate\Foundation\AliasLoader::getInstance();
        $facade->alias('Excel', '\Maatwebsite\Excel\Facades\Excel');

        $this->excel = \App::make('excel');

        Sheet::macro('freezePane', function (Sheet $sheet, $pane) {
            $sheet->getDelegate()->getActiveSheet()->freezePane($pane);  // <-- https://stackoverflow.com/questions/49678273/setting-active-cell-for-excel-generated-by-phpspreadsheet
        });
    }
    
    public static function excel()
    {
        return self::instance()->excel;
    }

    public static function export($class, $filename, $type = 'csv')
    {
        if (! in_array($type, ['xls', 'csv'])) {
            $type = 'csv';
        }

        $fn = $filename;

        return self::excel()->download(new $class, $fn.'.'.$type);
    }


}