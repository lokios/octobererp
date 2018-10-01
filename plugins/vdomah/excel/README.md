# Excel plugin
This plugin is a wrapper for Maatwebsite/Laravel-Excel package. It adds convenient tools to import/export excel files.

The complete documentation can be found at: http://www.maatwebsite.nl/laravel-excel/docs

## Usage
        use Vdomah\Excel\Classes\Excel;

        Excel::excel()->load(base_path() . '/storage/app/media/file.xlsx', function($reader) {

            dd($reader);

        });