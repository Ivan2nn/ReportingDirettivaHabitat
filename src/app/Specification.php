<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    protected $table = 'species_iucn';

	protected $primaryKey = 'species_code';

	public function species() {
		return $this->hasOne('App\Species', 'species_code');
	}
}
