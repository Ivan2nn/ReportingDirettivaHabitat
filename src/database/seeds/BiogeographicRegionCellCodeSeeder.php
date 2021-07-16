<?php

use Illuminate\Database\Seeder;
use Keboola\Csv\CsvFile;

class BiogeographicRegionCellCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = new CsvFile(base_path().'/database/seeds/csvs/biogeographic_regions_cell_codes.csv');

        foreach($csv AS $row) {
	        DB::table('biogeographicregion_cellcode')->insert([
	            'biogeographicregion_id' => $row[1],
	            'cellcode_id' => $row[0],
        	]);
        }
    }
}
