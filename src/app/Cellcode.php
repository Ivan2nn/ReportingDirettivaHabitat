<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cellcode extends Model
{
    protected $table = 'cellcodes';
	
    protected $fillable = [
        'cellname'
    ];

    public function species()
    {
    	return $this->belongsToMany('App\Species','cellcode_species','cellcode_id','species_code');
    }

    public function habitats()
    {
        return $this->belongsToMany('App\Habitat','cellcode_habitat','cellcode_id','habitat_code');
    }

    public function biogeographicregions()
    {
    	return $this->belongsToMany('App\Biogeographicregion','biogeographicregion_cellcode');
    }
}
