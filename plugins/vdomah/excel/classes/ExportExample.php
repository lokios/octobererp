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