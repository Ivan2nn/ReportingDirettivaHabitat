<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Habitat;
use App\Conservation;
use App\Biogeographicregion;
use App\Macrocategory;

class AdvancedHabitatSearchController extends Controller
{
    public function getHabitatsFromSelections(Request $request)
    {
		$report_number = $request->get('report_number');

    	$list_of_habitat_macrocategories = [];
    	$list_of_status_checks = [];
    	$list_of_biogeographicregions_checks = [];

    	foreach ($request->get('macrocat_checks') as $key => $value)
    	{ 
    		if ($value == 'true') 
    		{
    			$elmsOfKey = explode("-",$key);	
    			array_push($list_of_habitat_macrocategories, $elmsOfKey[count($elmsOfKey)-1]);
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
                    $habitats_from_selections = Habitat::whereIn('habitat_macrocategory_id', $list_of_habitat_macrocategories)
                    ->allBiogeoregOR($list_of_biogeographicregions_checks, $report_number)
                    ->get();
                    
                }
                else {
                    $habitats_from_selections = Habitat::whereIn('habitat_macrocategory_id', $list_of_habitat_macrocategories)
                    ->allBiogeoregOR($list_of_biogeographicregions_checks, $report_number)
                    ->allConservationOR($list_of_status_checks, $report_number)
                    ->get();
                }
            break;
            case 'OR-FE' :
                if ($list_of_biogeographicregions_checks['ND']) {
                    $habitats_from_selections = Habitat::whereIn('habitat_macrocategory_id', $list_of_habitat_macrocategories)
                    ->allBiogeoregOR_FalseExcluded($list_of_biogeographicregions_checks, $report_number)
                    ->get();
                }
                else {
                    $habitats_from_selections = Habitat::whereIn('habitat_macrocategory_id', $list_of_habitat_macrocategories)
                    ->allBiogeoregOR_FalseExcluded($list_of_biogeographicregions_checks, $report_number)
                    ->allConservationOR($list_of_status_checks, $report_number)
                    ->get();
                }
            break;
            case 'AND' :
                $habitats_from_selections = Habitat::whereIn('habitat_macrocategory_id', $list_of_habitat_macrocategories)
                    ->allBiogeoregAND($list_of_biogeographicregions_checks, $report_number)
                    ->allConservationOR($list_of_status_checks, $report_number)
                    ->get();
            break;
        }
        
        return json_encode($this->get_habitat_info($habitats_from_selections, $report_number));
    }

    public function getHabitatFromSelections(Request $request)
    {
		$report_number = $request->get('report_number');

    	$list_of_habitat_macrocategories = [];
    	$list_of_status_checks = [];
    	$list_of_biogeographicregions_checks = [];

    	foreach ($request->get('macrocat_checks') as $key => $value)
    	{ 
    		if ($value == 'true') 
    		{
    			$elmsOfKey = explode("-",$key);	
    			array_push($list_of_habitat_macrocategories, $elmsOfKey[count($elmsOfKey)-1]);
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

    	if (($request->get('radio_buttons_biogeoreg_value') == 'OR')){

	    	$habitats_from_selections = Habitat::whereHas('macrocategory', function($q) use($report_number, $list_of_habitat_macrocategories) { 
	    			$q->whereIn('habitat_macrocategory_id',$list_of_habitat_macrocategories); })
	    			->allBiogeoregOR($report_number, $list_of_biogeographicregions_checks)
	    			->allConservationOR($report_number, $list_of_status_checks)
	    			->get();
    	} else {

    		$habitats_from_selections = Habitat::whereHas('macrocategory', function($q) use($report_number, $list_of_habitat_macrocategories) { 
	    			$q->whereIn('habitat_macrocategory_id',$list_of_habitat_macrocategories); })
	    			->allBiogeoregAND($report_number, $list_of_biogeographicregions_checks)
	    			->allConservationOR($report_number, $list_of_status_checks)
	    			->get();
    	}

    	return json_encode($this->get_habitat_info($habitats_from_selections, $report_number));
    }

    public function get_habitat_info($habitat_list, $report_number) {
		$habitat_info = [];
		$habitat_info = $habitat_list->map(function($item, $key) use($report_number) {
			$habitat = Habitat::find($item->habitat_code);
			// ERROR :: If the original database of the habitat would be full even with duplicate habitat this could be taken out
			if ($habitat) {
				return [
					'habitat_code' => $habitat->habitat_code,
					'habitat_name' => $habitat->habitat_name,
	                'habitat_conservation_alp' => $habitat->getFormattedConservation($report_number,"ALP"),
	                'habitat_conservation_con' => $habitat->getFormattedConservation($report_number,"CON"),
	                'habitat_conservation_med' => $habitat->getFormattedConservation($report_number,"MED"),
	                'habitat_conservation_mmed' => $habitat->getFormattedConservation($report_number,"MMED"),
	                'habitat_trend_alp' => $habitat->getFormattedTrend($report_number,"ALP"),
	                'habitat_trend_con' => $habitat->getFormattedTrend($report_number,"CON"),
	                'habitat_trend_med' => $habitat->getFormattedTrend($report_number,"MED"),
			'habitat_trend_mmed' => $habitat->getFormattedTrend($report_number,"MMED"),
					'bioregions' => $habitat->biogeographicregions()->where('report',$report_number)->get()->pluck('name')->toArray(),
				];
			}
		});
  		
  		return $habitat_info;
	}
}
