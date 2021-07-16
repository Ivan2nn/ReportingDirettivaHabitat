<?php

use Illuminate\Database\Seeder;
use Keboola\Csv\CsvFile;

class SpeciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = new CsvFile(base_path().'/database/seeds/csvs/species_code.csv');

        foreach($csv AS $row) {
	        DB::table('species')->insert([
	            'name' => $row[1],
	            'n2k_code' => $row[0],
        	]);
        }
    }
}
