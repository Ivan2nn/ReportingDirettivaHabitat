<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BiogeographicRegionsSeeder::class);
        $this->call(CellCodeSeeder::class);
        $this->call(BiogeographicRegionCellCodeSeeder::class);
        $this->call(SpeciesSeeder::class);
        $this->call(CellCodeSpeciesSeeder::class);
    }
}
