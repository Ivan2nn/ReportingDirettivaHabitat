<?php

use Illuminate\Database\Seeder;
use Keboola\Csv\CsvFile;
use App\CellCode;

class CellCodeSeeder extends Seeder
{
    public function run()
    {
		$csv = new CsvFile(base_path().'/database/seeds/csvs/cell_code.csv');

        foreach($csv AS $row) {
            CellCode::create(['cellname' => $row[0]]);
        }
    }
}
