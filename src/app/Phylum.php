<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phylum extends Model
{
	protected $table = 'tax_03phyla';

    protected $primaryKey = 'phylum_code';

    public function taxonomies() {
    	return $this->hasMany('App\Taxonomy');
    }

    public function classes() {
    	$classes_code = Taxonomy::where('phylum_code',$this->phylum_code)->select('class_code')->get();
    	
    	return Classis::whereIn('class_code', $classes_code)->get();
    }
}
