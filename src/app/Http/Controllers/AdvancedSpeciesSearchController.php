<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Taxonomy;
use App\Species;
use App\Conservation;
use App\Biogeographicregion;

class AdvancedSpeciesSearchController extends Controller
{
    public function getSpeciesFromSelections(Request $request)
    {
		$report_number = $request->get('report');

    	$list_of_species_code = [];
    	$list_of_status_checks = [];
    	$list_of_biogeographicregions_checks = [];

    	foreach ($request->get('codes') as $single_genus_code) {
			$list_of_species_from_same_genus = $this->genus_species($single_genus_code);
			foreach($list_of_species_from_same_genus as $single_species_from_genus) {
				array_push($list_of_species_code, $single_species_from_genus);
			}
		}

    	foreach ($request->get('status_checks') as $key => $value)
    	{ 
    		if ($value == 'true') 
    		{
    			$list_of_status_checks[$key] = true;
    		} else {
  				$list_of_status_checks[$key] = false;  			
    		}
    	}

    	foreach ($request->get('regbio_checks') as $key => $value)
    	{ 
    		if ($value == 'true') 
    		{
    			$list_of_biogeographicregions_checks[$key] = true;
    		} else {
  				$list_of_biogeographicregions_checks[$key] = false;  			
    		}
    	}

    	switch ($request->get('radio_buttons_biogeoreg_value')) {
    		case 'OR' :
    			if ($list_of_biogeographicregions_checks['ND']) {
		    	$species_from_selections = Species::whereIn('species_code',$list_of_species_code)
		    			->allBiogeoregOR($list_of_biogeographicregions_checks, $report_number)
		    			->get();
		    	}
		    	else {
		    		$species_from_selections = Species::whereIn('species_code',$list_of_species_code)
			    			->allBiogeoregOR($list_of_biogeographicregions_checks, $report_number)
			    			->allConservationOR($list_of_status_checks, $report_number)
			    			->get();
		    	}
    		break;
    		case 'OR-FE' :
    			if ($list_of_biogeographicregions_checks['ND']) {
		    	$species_from_selections = Species::whereIn('species_code',$list_of_species_code)
		    			->allBiogeoregOR_FalseExcluded($list_of_biogeographicregions_checks, $report_number)
		    			->get();
		    	}
		    	else {
		    		$species_from_selections = Species::whereIn('species_code',$list_of_species_code)
			    			->allBiogeoregOR_FalseExcluded($list_of_biogeographicregions_checks)
			    			->allConservationOR($list_of_status_checks, $report_number)
			    			->get();
		    	}
    		break;
    		case 'AND' :
    			$species_from_selections = Species::whereIn('species_code',$list_of_species_code)
	    			->allBiogeoregAND($list_of_biogeographicregions_checks, $report_number)
	    			->allConservationOR($list_of_status_checks, $report_number)
	    			->get();
    		break;
    	}
		
    	return json_encode($this->get_species_info($species_from_selections, $report_number));
    }

    public function genus_species($code) {
    	return $this->get_species_from_taxonomy('genus',$code);
    }

    ////////////////// Helpers Section

    public function get_species_from_taxonomy($taxonomy, $code) {
    	return Taxonomy::where($taxonomy . '_code',$code)->pluck('species_code');

    	//return $this->get_species_info($taxonomies);
    }

    public function get_species_info($species_list, $report_number) {
		$species_info = [];
		$species_info = $species_list->map(function($item, $key) use($report_number) {
			$species = Species::find($item->species_code);
			// ERROR :: If the original database of the species would be full even with duplicate species this could be taken out
			if ($species && $species->taxonomy ) {
				return [
					'species_code' => $species->species_code,
					'species_name' => $species->species_name,
	                'species_conservation_alp' => $species->getFormattedConservation($report_number, "ALP"),
	                'species_conservation_con' => $species->getFormattedConservation($report_number, "CON"),
	                'species_conservation_med' => $species->getFormattedConservation($report_number, "MED"),
			'species_conservation_mmed' => $species->getFormattedConservation($report_number, "MMED"),
	                'species_trend_alp' => $species->getFormattedTrend($report_number, "ALP"),
	                'species_trend_con' => $species->getFormattedTrend($report_number, "CON"),
	                'species_trend_med' => $species->getFormattedTrend($report_number, "MED"),
			'species_trend_mmed' => $species->getFormattedTrend($report_number, "MMED"),
					'class' => $species->taxonomy->tax_classis ? $species->taxonomy->tax_classis->class_name : ' ',
					'family' => $species->taxonomy->tax_family ? $species->taxonomy->tax_family->family_name : ' ',
					'kingdom' => $species->taxonomy->tax_kingdom ? $species->taxonomy->tax_kingdom->kingdom_name : ' ',
					'order' => $species->taxonomy->tax_order ? $species->taxonomy->tax_order->order_name : ' ',
					'phylum' => $species->taxonomy->tax_phylum ? $species->taxonomy->tax_phylum->phylum_name : ' ',
					'genus' => $species->taxonomy->tax_genus ? $species->taxonomy->tax_genus->genus_name : ' ',
					'bioregions' => $species->biogeographicregions()->where('report',$report_number)->get()->pluck('name')->toArray(),
					'priority' => $species->priority,
					'endemic' => $species->endemic,
					'lri_specs' => trim($species->specification->lri_category),
					'iucn_specs' => trim($species->specification->iucn_category_global),
					'annexes' => $species->annexes($report_number)
				];
			}
		});
  		
  		return $species_info;
	}
}

/*if (($request->get('radio_buttons_biogeoreg_value') == 'OR') &&  ($request->get('radio_buttons_conservation_value') == 'OR')){

	$species_from_selections = Species::whereIn('species_code',$list_of_species_code)
			->allBiogeoregOR($list_of_biogeographicregions_checks)
			->allConservationOR($list_of_status_checks)
			->get();
}
// In case of AND the biogeographic regions must be present both in the species
elseif (($request->get('radio_buttons_biogeoreg_value') == 'AND') &&  ($request->get('radio_buttons_conservation_value') == 'OR')) {

	$species_from_selections = Species::whereIn('species_code',$list_of_species_code)
			->allBiogeoregAND($list_of_biogeographicregions_checks)
			->allConservationOR($list_of_status_checks)
			->get();

}

elseif (($request->get('radio_buttons_biogeoreg_value') == 'OR') &&  ($request->get('radio_buttons_conservation_value') == 'AND')) {

	$species_from_selections = Species::whereIn('species_code',$list_of_species_code)
			->allBiogeoregOR($list_of_biogeographicregions_checks)
			->allConservationAND($list_of_status_checks)
			->get();

}

else {
	$species_from_selections = Species::whereIn('species_code',$list_of_species_code)
			->allBiogeoregAND($list_of_biogeographicregions_checks)
			->allConservationAND($list_of_status_checks)
			->get();
}*/
