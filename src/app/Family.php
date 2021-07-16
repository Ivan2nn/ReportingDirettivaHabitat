<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
	protected $table = 'tax_14families';

    protected $primaryKey = 'family_code';

    public function taxonomy() {
    	return $this->hasMany('App\Taxonomy');
    }

    public function genera() {
    	$genera_code = Taxonomy::where('family_code',$this->family_code)->select('genus_code')->get();
    	
    	return Genus::whereIn('genus_code', $genera_code)->get();
    }
}
