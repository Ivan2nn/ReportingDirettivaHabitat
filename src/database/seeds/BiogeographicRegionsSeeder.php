<?php

use Illuminate\Database\Seeder;
use App\BiogeographicRegion;

class BiogeographicRegionsSeeder extends Seeder {

	public function run() {
		BiogeographicRegion::create(['name' => 'ALP']);
		BiogeographicRegion::create(['name' => 'CON']);
		BiogeographicRegion::create(['name' => 'MED']);
	}
}