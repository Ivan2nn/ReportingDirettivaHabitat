<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Biogeographicregion extends Model
{
    protected $table = 'biogeographicregions';
	
    protected $fillable = [
        'name'
    ];

    public function cellcodes()
    {
    	return $this->belongsToMany('App\Cellcode');
    }

    public function species() {
        return $this->belongsToMany('App\Species','species_data0712_presence','biogeographicregion_id','species_code');
    }

    public function habitats() {
        return $this->belongsToMany('App\Habitat','habitat_data0712_status_conserve','biogeographicregion_id','habitat_code');
    }
}
