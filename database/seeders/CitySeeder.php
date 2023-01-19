<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::truncate();
        $csvData = fopen(base_path('database/csv/cities.csv'), 'r');
        $transRow = true;
        while (($data = fgetcsv($csvData, 555, ',')) !== false) {
            if (!$transRow) {
                if (empty($data['2'])){
                    continue;
                }
                City::create([
                    'persian_name' => $data['2'],
                    'english_name' => $data['5'],
                    'code' => $data['6'],
                    'lat' => $data['7'],
                    'lng' => $data['8'],
                    'province_id' => $data['1'],
                ]);
            }
            $transRow = false;
        }
        fclose($csvData);
    }
}
