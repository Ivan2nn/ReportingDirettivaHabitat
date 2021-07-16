<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genus extends Model
{
	protected $table = 'tax_17genera';

    protected $primaryKey = 'genus_code';

    public function taxonomy() {
    	return $this->hasMany('App\Taxonomy');
    }
}
