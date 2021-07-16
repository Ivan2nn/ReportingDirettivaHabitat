<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conservation extends Model
{
    protected $table = 'status_conserve';
	
    protected $fillable = [
        'name',
        'code'
    ];

    public function species() 
    {
    	return $this->belongsToMany('App\Species','species_data0712_status_conserve','status_conserve_id','species_code');
    }

    public function habitats() 
    {
        return $this->belongsToMany('App\Habitat','habitat_data0712_status_conserve','status_conserve_id','habitat_code');
    }
}
