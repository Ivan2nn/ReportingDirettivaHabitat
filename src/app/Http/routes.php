<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('test', function(){
	/* Let's test the php json function */
	return view('cellSelectionView');
	

});

Route::get('api/species/{species}/{report_number}', 'SpeciesController@showFromReport');

Route::resource('api/species','SpeciesController');
Route::resource('api/habitat','HabitatController');
//

Route::resource('api/cellcodes','CellCodeController');

Route::get('/', array('as' => 'home', function () {
	return view('basic.landing');
}));

Route::get('/contesto-riferimento', array('as' => 'contesto-riferimento', function () {
	return view('basic.reference-context');
}));

Route::get('/downloads', array('as' => 'downloads', function () {
	return view('basic.downloads');
}));

Route::get('/links', array('as' => 'links', function () {
	return view('basic.links');
}));



Route::get('species-basic-search/{code?}', array('as' => 'species-basic-search', function($code = null) {
	$species = null;
	if ($code) {
		$species = App\Species::where('species_code',$code)->first();
	}
	return view('basic.species-graphic-search', compact('species'));
}));

Route::get('habitat-basic-search/{code?}', array('as' => 'habitat-basic-search', function($code = null) {
	$habitat = null;
	if ($code) {
		$habitat = App\Habitat::where('habitat_code',$code)->first();
	}
	return view('basic.habitat-graphic-search', compact('habitat'));
}));

Route::get('habitat', function() {
	return App\Habitat::all();
});

Route::get('species', function() {
	return App\Species::all();
});

Route::get('/api/species/multi/{speciesCodes}',['as' => 'api.species.multi', 'uses' => 'SpeciesController@multipleShow']);

Route::get('/species-table', function () {
	$species = App\Species::all();
    return view('basic.species-table-search', compact('species'));
});

Route::get('api/taxonomy', function() {
	$kingdoms = App\Kingdom::all();
	$orders = App\Order::all();
	$families = App\Family::all();
	$genera = App\Genus::all();
	$classes = App\Classis::all();
	$phyla = App\Phylum::all();

	return array('kingdoms' => $kingdoms, 'orders' =>$orders, 'families' => $families, 'genera' => $genera, 'classes' => $classes, 'phyla' => $phyla);
});

Route::get('api/taxonomy/{ids}', function($ids) {
	$pieces = explode(":", $ids);
	foreach ($pieces as $piece) {
		switch ($piece[0]) {
			case 'k':
				$kingdom_id = substr($piece, 1);
			break;
			case 'p':
				$phylum_id = substr($piece, 1);
			break;
			case 'c':
				$class_id = substr($piece, 1);
			break;
			case 'o':
				$order_id = substr($piece, 1);
			break;
			case 'f':
				$family_id = substr($piece, 1);
			break;
			case 'g':
				$genus_id = substr($piece, 1);
			break;
		}
	}
	$matchThese = ['kingdom_id' => $kingdom_id, 'phylum_id' => $phylum_id, 'class_id' => $class_id, 'order_id' => $order_id, 'family_id' => $family_id, 'genus_id' => $genus_id];

	$taxonomy = App\Taxonomy::where($matchThese)->get();

	return $taxonomy;

});

Route::get('advancedselectiontospecies','AdvancedSpeciesSearchController@getSpeciesFromSelections');

Route::get('advancedselectiontohabitat','AdvancedHabitatSearchController@getHabitatsFromSelections');

Route::get('taxonomytospecies/', 'TaxonomyController@getSpeciesFromTaxonomy');

Route::get('biogeographicregtospecies', 'BiogeographicregionController@getSpeciesFromBiogeographicRegion');

Route::get('conservationstatetospecies', 'StatusConserveController@getSpeciesFromStatusConserve');

Route::get('macrocategoriestohabitat', 'MacrocategoryController@getHabitatsFromMacrocategory');

Route::get('biogeographicregtohabitat', 'BiogeographicregionController@getHabitatsFromBiogeographicRegion');

Route::get('conservationstatetohabitat', 'StatusConserveController@getHabitatsFromStatusConserve');

Route::get('cellcodes/species/{id}/{report_number}', 'CellCodeController@getSpeciesFromCellcodes');

Route::get('cellcodes/habitat/{id}', 'CellCodeController@getHabitatsFromCellcodes');

/*Route::get('api/taxonomy-to-species/{ids}', function($ids) {
	$pieces = explode(":", $ids);
	foreach ($pieces as $piece) {
		switch ($piece[0]) {
			case 'k':
				$kingdom_id = substr($piece, 1);
			break;
			case 'p':
				$phylum_id = substr($piece, 1);
			break;
			case 'c':
				$class_id = substr($piece, 1);
			break;
			case 'o':
				$order_id = substr($piece, 1);
			break;
			case 'f':
				$family_id = substr($piece, 1);
			break;
			case 'g':
				$genus_id = substr($piece, 1);
			break;
		}
	}

	$matchThese = ['kingdom_id' => $kingdom_id, 'phylum_id' => $phylum_id, 'class_id' => $class_id, 'order_id' => $order_id, 'family_id' => $family_id, 'genus_id' => $genus_id];

	$taxonomies = App\Taxonomy::where($matchThese)->get();
	
	$outputData = [];

	if ($taxonomies->count() > 0) {
		foreach ($taxonomies as $taxonomy) {
			$selectedSpecies = App\Species::find($taxonomy->species_code);

			$tempData['species_code'] = $selectedSpecies->species_code;
            $tempData['species_name'] = $selectedSpecies->species_name;
            $tempData['classis_name'] = ($selectedSpecies->taxonomy->tax_classis) ? $selectedSpecies->taxonomy->tax_classis->class_name : '';
            $tempData['family_name'] = ($selectedSpecies->taxonomy->tax_family) ? $selectedSpecies->taxonomy->tax_family->family_name : '';
            $tempData['kingdom_name'] = ($selectedSpecies->taxonomy->tax_kingdom) ? $selectedSpecies->taxonomy->tax_kingdom->kingdom_name : '';
            $tempData['order_name'] = ($selectedSpecies->taxonomy->tax_order) ? $selectedSpecies->taxonomy->tax_order->order_name : '';
            $tempData['phylum_name'] = ($selectedSpecies->taxonomy->tax_phylum) ? $selectedSpecies->taxonomy->tax_phylum->phylum_name : '';
            $tempData['genus_name'] = ($selectedSpecies->taxonomy->tax_genus) ? $selectedSpecies->taxonomy->tax_genus->genus_name : '';
            $tempData['bioregions'] = $selectedSpecies->biogeographicregions();

            array_push($outputData,$tempData);
		}
	}

	return json_encode($outputData);
});*/

Route::get('species-advanced-search', array('as'=>'species-advanced-search', function () {

	$kingdoms = App\Kingdom::all();
	$orders = App\Order::all();
	$families = App\Family::all();
	$genera = App\Genus::all();
	$classes = App\Classis::all();
	$phyla = App\Phylum::all();

    return view('basic.species-advanced-search', compact('kingdoms','phyla','classes','order','families','genera'));
}));

Route::get('habitat-advanced-search', array('as'=>'habitat-advanced-search', function () {

	$macrocategories = App\Macrocategory::all();
    return view('basic.habitat-advanced-search', compact('macrocategories'));
}));

Route::get('species-cellcodes-search', array('as' => 'species-cellcodes-search', function() {
	return view('basic.species-cellcodes-search');
}));

Route::get('habitat-cellcodes-search', array('as' => 'habitat-cellcodes-search', function() {
	return view('basic.habitat-cellcodes-search');
}));


