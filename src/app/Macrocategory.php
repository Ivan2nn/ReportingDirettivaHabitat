<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Macrocategory extends Model
{
    protected $table = 'habitat_macrocategory';

	protected $primaryKey = 'habitat_macrocategory_id';

	public function habitats() {
		return $this->hasMany('App\Habitat','habitat_macrocategory_id');
	}
}
