<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Property;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Property::truncate();

        $csvFile = fopen(base_path("property-data.csv"), "r");

        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            if (!$firstline) {

                Property::create([
                    "name" => strval($data['0']),
                    "price" => intval($data['1']),
                    "bedrooms" => intval($data['2']),
                    "bathrooms" => intval($data['3']),
                    "storeys" => intval($data['4']),
                    "garages" => intval($data['5']),
                ]);
            }

            $firstline = false;

        }

        fclose($csvFile);
    }
}
