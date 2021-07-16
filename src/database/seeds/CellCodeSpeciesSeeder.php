<?php

use Illuminate\Database\Seeder;
use Keboola\Csv\CsvFile;

class CellCodeSpeciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = new CsvFile(base_path().'/database/seeds/csvs/species_code_cell_code.csv');

        foreach($csv AS $row) {
	        DB::table('cellcode_species')->insert([
	            'species_code' => $row[1],
	            'cellcode_id' => $row[0],
        	]);
        }
    }
}
