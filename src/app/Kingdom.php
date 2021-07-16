<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kingdom extends Model
{
	protected $table = 'tax_01kingdoms';

    protected $primaryKey = 'kingdom_code';

    public function taxonomy() {
    	return $this->hasMany('App\Taxonomy');
    }

    public function phyla() {
    	$phyla_code = Taxonomy::where('kingdom_code',$this->kingdom_code)->select('phylum_code')->get();
    	
    	return Phylum::whereIn('phylum_code', $phyla_code)->get();
    }
}
