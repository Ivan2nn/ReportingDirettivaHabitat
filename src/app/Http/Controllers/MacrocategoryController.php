<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Macrocategory;
use App\Habitat;


class MacrocategoryController extends Controller
{
    public function getHabitatsFromMacrocategory(Request $request) {

    	$list_of_chosen_macrocategories = $request->get('macrocat_checks');

    	$chosen_macrocategories = collect();
    	$counter = 0;

    	foreach ($list_of_chosen_macrocategories as $key => $value)
    	{ 
    		if ($value == 'true') 
    		{
    			$counter = $counter + 1;
    			// since the key is MAC1, MAC2, MAC3,etc...we have to split the final number

    			$temp_macrocategory = Macrocategory::where('habitat_macrocategory_id', substr($key,-1))->first();
    			
    			if ($counter == 1)
    			{
    				$chosen_macrocategories = $temp_macrocategory->habitats;
    			}
    			else 
    			{
    				$chosen_macrocategories = $chosen_macrocategories->merge($temp_macrocategory->habitats);
    			}
    		}
    	}

	   	$final_habitats = $this->get_habitat_info($chosen_macrocategories)->unique('habitat_name');
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
