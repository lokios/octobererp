# Excel plugin
This plugin is a wrapper for Maatwebsite/Laravel-Excel package. It adds convenient tools to import/export excel files.

The complete documentation can be found at: http://www.maatwebsite.nl/laravel-excel/docs

## Upgrading from 2.x to 3.x version of Maatwebsite.Laravel-Excel.

###Changes in Vdomah\Excel\Classes\Excel class 
- use of Singleton trait
- use instance() method instead of getInstance()
- export method added which implements Excel::download method of Maatwebsite.Laravel-Excel v3

###Example export from page code section
````
use Vdomah\Excel\Classes\Excel;
use Vdomah\Excel\Classes\ExportExample;
function onStart()
{
    return Excel::export(ExportExample::class, 'my_export_filename');
}
````

###New export code paradigm
Now instead of closures in v2 you need to create new class to export your data in v3. 
The main goal while moving from v2 to v3 is to pass your export data into collection() method of your Export class (see demo using faker).
Example export class is provided with plugin: 

````
<?php namespace Vdomah\Excel\Classes;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportExample implements FromCollection, WithHeadings, WithEvents
{
    // set the headings
    public function headings(): array
    {
        return [
            'Company name', 'Flyer name', 'Co Company', 'Post Code', 'Online invitation', 'Pending'
        ];
    }

    // freeze the first row with headings
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->freezePane('A2', 'A2');
            },
        ];
    }

    // get the data
    public function collection()
    {
        $data = [];

        $faker = \Faker\Factory::create();

        $limit = 10;

        for ($i = 0; $i < $limit; $i++) {
            $data[] = [$faker->name, $faker->word, 'N', $faker->postcode, $faker->word, $faker->word];
        }

        return collect($data);
    }
}
````


## 2.x version usage
        use Vdomah\Excel\Classes\Excel;

        Excel::excel()->load(base_path() . '/storage/app/media/file.xlsx', function($reader) {

            dd($reader);

        });

### Importing a file

To start importing a file, you can use __->load($filename)__. The callback is optional.

        Excel::load('file.xls', function($reader) {

        // Getting all results  
        $results = $reader->get();

        // ->all() is a wrapper for ->get() and will work the same  
        $results = $reader->all();

        });

### Collections

Sheets, rows and cells are collections, this means after doing a __->get()__ you can use all default collection methods.

        // E.g. group the results  
        $reader->get()->groupBy('firstname');

Getting the first sheet or row

To get the first sheet or row, you can __utilise ->first()__.

        $reader->first();
