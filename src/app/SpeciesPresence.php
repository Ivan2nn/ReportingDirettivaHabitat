<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpeciesPresence extends Model
{
    protected $table = 'species_data0712_presence';

    protected $fillable = ['species_code, biogeographicregion_id, presence_id'];
}
