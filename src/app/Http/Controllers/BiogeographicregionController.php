<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Biogeographicregion;
use App\Species;
use App\Taxonomy;
use App\Habitat;

class BiogeographicregionController extends Controller
{
    public function getSpeciesFromBiogeographicRegion(Request $request)
    {
    	$list_of_chosen_regbio = $request->get('regbio_checks');

    	$chosen_regbio = collect();
    	$counter = 0;

    	foreach ($list_of_chosen_regbio as $key => $value)
    	{ 
    		if ($value == 'true') 
    		{
    			$counter = $counter + 1;

    			$temp_reg = Biogeographicregion::where('name',$key)->first();
    			
    			if ($counter == 1)
    			{
    				$chosen_regbio = $temp_reg->species;
    			}
    			else 
    			{
    				$chosen_regbio = $chosen_regbio->merge($temp_reg->species);
    			}
    		}
    	}

    	$final_species = $this->get_species_info($chosen_regbio)->unique('species_name');
    	$final_species_sorted = $final_species->sortBy('species_name');
    	
    	return json_encode($final_species_sorted->values()->all());
    }


	public function get_species_info($species_list) {
		$species_info = [];
		$species_info = $species_list->map(function($item, $key) {
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
					'class_name' => $species->taxonomy->tax_classis ? $species->taxonomy->tax_classis->class_name : ' ',
					'family_name' => $species->taxonomy->tax_family ? $species->taxonomy->tax_family->family_name : ' ',
					'kingdom_name' => $species->taxonomy->tax_kingdom ? $species->taxonomy->tax_kingdom->kingdom_name : ' ',
					'order_name' => $species->taxonomy->tax_order ? $species->taxonomy->tax_order->order_name : ' ',
					'phylum_name' => $species->taxonomy->tax_phylum ? $species->taxonomy->tax_phylum->phylum_name : ' ',
					'genus_name' => $species->taxonomy->tax_genus ? $species->taxonomy->tax_genus->genus_name : ' ',
					'bioregions' => $species->biogeographicregions->pluck('name')->toArray(),
					'annexes' => $species->annexes()
				];
			}
		});

		return $species_info;
	}

	public function getHabitatsFromBiogeographicRegion(Request $request) {

    	$list_of_chosen_regbio = $request->get('regbio_checks');

    	$chosen_regbio = collect();
    	$counter = 0;

    	foreach ($list_of_chosen_regbio as $key => $value)
    	{ 
    		if ($value == 'true') 
    		{
    			$counter = $counter + 1;

    			$temp_reg = Biogeographicregion::where('name',$key)->first();
    			
    			if ($counter == 1)
    			{
    				$chosen_regbio = $temp_reg->habitats;
    			}
    			else 
    			{
    				$chosen_regbio = $chosen_regbio->merge($temp_reg->habitats);
    			}
    		}
    	}

	   	$final_habitats = $this->get_habitat_info($chosen_regbio)->unique('habitat_name');
    	$final_habitat_sorted = $final_habitats->sortBy('habitat_code');

    	return json_encode($final_habitat_sorted->values()->all());
    }

    public function get_habitat_info($habitat_list) {
		$habitat_info = [];
		$habitat_info = $habitat_list->map(function($item, $key) {
			$habitat = Habitat::find($item->habitat_code);
			// ERROR :: If the original database of the habitat would be full even with duplicate habitat this could be taken out
			if ($habitat) {
				return [
					'habitat_code' => $habitat->habitat_code,
					'habitat_name' => $habitat->habitat_name,
	                'habitat_conservation_alp' => $habitat->getFormattedConservation("ALP"),
	                'habitat_conservation_con' => $habitat->getFormattedConservation("CON"),
	                'habitat_conservation_med' => $habitat->getFormattedConservation("MED"),
	                'habitat_trend_alp' => $habitat->getFormattedTrend("ALP"),
	                'habitat_trend_con' => $habitat->getFormattedTrend("CON"),
	                'habitat_trend_med' => $habitat->getFormattedTrend("MED"),
					'bioregions' => $habitat->biogeographicregions->pluck('name')->toArray(),
				];
			}
		});
  		
  		return $habitat_info;
	}
}
