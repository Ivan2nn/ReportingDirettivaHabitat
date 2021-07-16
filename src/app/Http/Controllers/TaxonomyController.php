<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Taxonomy;
use App\Species;

class TaxonomyController extends Controller
{
	// Api ::

	public function getSpeciesFromTaxonomy(Request $request) {
		
		$allSpecies = array();
		$list_of_genera_code = $request->get('codes');
		//$returnSpecies = $this->family_species($list_of_families_code[0]);
		foreach ($list_of_genera_code as $single_genus_code) {
			$species_group = $this->genus_species($single_genus_code);
			$species_group->each(function($item, $key) use(&$allSpecies) {
				if ($item) {
					array_push($allSpecies, $item);
				}
			});
		}
		
		return json_encode($allSpecies);
	}

	// Kingdom Section ////////////

    public function kingdom_index() {
    	$kingdoms = App\Kingdom::all();

    	return json_encode($kingdoms);
    }

    public function kingdom_show($code) {
    	$kingdom = App\Kingdom::find($code);

    	return json_encode($kingdom);
    }

    public function kingdom_species($code) {
    	return get_species_from_taxonomy('kingdom',$code);
    }

    // Phylum Section ////////////

    public function phylum_index() {
    	$phyla = App\Phylum::all();

    	return json_encode($phyla);
    }

    public function phylum_show($code) {
    	$phylum = App\Phylum::find($code);

    	return json_encode($phylum);
    }

    public function phylum_species($code) {
    	return get_species_from_taxonomy('phylum',$code);
    }

    // Classis Section ////////////

    public function classis_index() {
    	$classes = App\Classis::all();

    	return json_encode($classes);
    }

    public function classis_show($code) {
    	$classis = App\Classis::find($code);

    	return json_encode($classis);
    }

    public function classis_species($code) {
    	return get_species_from_taxonomy('classis',$code);
    }

    // Order Section ////////////

    public function order_index() {
    	$orders = App\Order::all();

    	return json_encode($orders);
    }

    public function order_show($code) {
    	$order = App\Order::find($code);

    	return json_encode($order);
    }

    public function order_species($code) {
    	return get_species_from_taxonomy('order',$code);
    }

    // Family Section ////////////

    public function family_index() {
    	$families = App\Family::all();

    	return json_encode($families);
    }

    public function family_show($code) {
    	$family = App\Family::find($code);

    	return json_encode($family);
    }

    public function family_species($code) {
    	return $this->get_species_from_taxonomy('family',$code);
    }

    // Genus Section ////////////
    
    public function genus_index() {
    	$genera = App\Genus::all();

    	return json_encode($genera);
    }

    public function genus_show($code) {
    	$genus = App\Genus::find($code);

    	return json_encode($genus);
    }

    public function genus_species($code) {
    	return $this->get_species_from_taxonomy('genus',$code);
    }

    ////////////////// Helpers Section

    public function get_species_from_taxonomy($taxonomy, $code) {
    	$taxonomies = Taxonomy::where($taxonomy . '_code',$code)->get();

    	return $this->get_species_info($taxonomies);
    }

    public function get_species_info($taxonomies) {
    	$species_info = [];
    	$species_info = $taxonomies->map(function($item, $key) {
    		$species = Species::find($item->species_code);
    		// ERROR :: If the original database of the species would be full even with duplicate species this could be taken out
    		if ($species && $species->taxonomy) {
    			return [
    				'species_code' => $species->species_code,
    				'species_name' => $species->species_name,
                    'species_conservation_alp' => $species->getFormattedConservation("ALP"),
                    'species_conservation_con' => $species->getFormattedConservation("CON"),
                    'species_conservation_med' => $species->getFormattedConservation("MED"),
                    'species_trend_alp' => $species->getFormattedTrend("ALP"),
                    'species_trend_con' => $species->getFormattedTrend("CON"),
                    'species_trend_med' => $species->getFormattedTrend("MED"),
    				'class_name' => $species->taxonomy->tax_classis ? $species->taxonomy->tax_classis->class_name : '',
    				'family_name' => $species->taxonomy->tax_family ? $species->taxonomy->tax_family->family_name : '',
    				'kingdom_name' => $species->taxonomy->tax_kingdom ? $species->taxonomy->tax_kingdom->kingdom_name : '',
    				'order_name' => $species->taxonomy->tax_order ? $species->taxonomy->tax_order->order_name : '',
    				'phylum_name' => $species->taxonomy->tax_phylum ? $species->taxonomy->tax_phylum->phylum_name : '',
    				'genus_name' => $species->taxonomy->tax_genus ? $species->taxonomy->tax_genus->genus_name : '',
    				'bioregions' => $species->biogeographicregions->pluck('name')->toArray(),
    				'annexes' => $species->annexes()
    			];
    		}
    	});

    	return $species_info;
    }

}
