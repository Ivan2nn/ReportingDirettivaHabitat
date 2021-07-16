<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    protected $table = 'taxonomy';

	public function species() {
		return $this->belongsTo('App\Species', 'species_code', 'species_code');
	}

	public function hasClassis() {
    	return count($this->tax_classis) > 0;
    }

    public function tax_classis() {
    	return $this->belongsTo('App\Classis','class_code');
    }

    public function hasFamily() {
    	return count($this->tax_family) > 0;
    }

    public function tax_family() {
    	return $this->belongsTo('App\Family','family_code');
    }

    public function hasGenus() {
    	return count($this->tax_genus) > 0;
    }

    public function tax_genus() {
    	return $this->belongsTo('App\Genus','genus_code');
    }

    public function hasPhylum() {
    	return count($this->tax_phylum) > 0;
    }

    public function tax_phylum() {
    	return $this->belongsTo('App\Phylum','phylum_code');
    }

    public function hasKingdom() {
    	return count($this->tax_kingdom) > 0;
    }

    public function tax_kingdom() {
    	return $this->belongsTo('App\Kingdom','kingdom_code');
    }

    public function hasOrder() {
    	return count($this->tax_order) > 0;
    }

    public function tax_order() {
    	return $this->belongsTo('App\Order','order_code');
    }
}
