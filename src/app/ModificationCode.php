<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModificationCode extends Model
{
    protected $table = 'species_modified_code';
    protected $primaryKey = 'modified_code';
    public $incrementing=false;

    public function species() {
    	return $this->belongsToMany('App\Species','species_modified','modified_code','species_code');
    }
}
