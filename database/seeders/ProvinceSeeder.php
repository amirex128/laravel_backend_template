<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::truncate();
        $csvData = fopen(base_path('database/csv/provinces.csv'), 'r');
        $transRow = true;
        while (($data = fgetcsv($csvData, 555, ',')) !== false) {
            if (!$transRow) {
                Province::create([
                    'id' => $data['0'],
                    'persian_name' => $data['1'],
                    'english_name' => $data['2'],
                    'COD' => $data['3'],

                ]);
            }
            $transRow = false;
        }
        fclose($csvData);
    }
}
