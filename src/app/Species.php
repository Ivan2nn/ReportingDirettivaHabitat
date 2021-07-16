<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class Species extends Model
{
	protected $table = 'species';

	protected $primaryKey = 'species_code';

    protected $fillable = ['species_name'];

    public function taxonomy() {
    	return $this->hasOne('App\Taxonomy','species_code');
    }

    public function cellcodes()
    {
    	return $this->belongsToMany('App\Cellcode','cellcode_species','species_code','cellcode_id');
    }

    public function biogeographicregions() 
    {
        return $this->belongsToMany('App\Biogeographicregion','species_data0712_status_conserve','species_code','biogeographicregion_id');
    }

    public function presences()
    {
        return $this->belongsToMany('App\Presence','species_data0712_presence','species_code','status_presence_id')->withPivot('biogeographicregion_id');
    }

    public function conservations()
    {
        return $this->belongsToMany('App\Conservation','species_data0712_status_conserve','species_code','status_conserve_id')->withPivot('biogeographicregion_id');
    }

    public function trends()
    {
        return $this->belongsToMany('App\Trend','species_data0712_trend','species_code','trend_id')->withPivot('biogeographicregion_id');
    }

    public function modification_codes() {
        return $this->belongsToMany('App\ModificationCode','species_modified','species_code','modified_code');
    }
    
    public function hasSpecification() {
    	return DB::table('species_iucn')->where('species_code',$this->species_code)->first() != null;
    }

    public function hasSpecificationLRI() {
    	return ($this->specification->lri_category != '' || $this->specification->lri_criterion != '');
    }

    public function hasSpecificationIUCN() {
    	return ($this->specification->iucn_category != '' || $this->specification->iucn_criterion != '');
    }

    public function specification() {
		return $this->belongsTo('App\Specification','species_code');
    }

    // This method gives back a formatted array with the values REGBIO[STATUS_PRESERVE]
    public function getFormattedPresences()
    {
        $allPresences = $this->presences->map(function($item, $key){
            return [
                Biogeographicregion::where('id',$item->pivot->biogeographicregion_id)->first()->name . '[' . $item->name . ']',
            ];
        });

        return $allPresences;
    }

    public function getFormattedPresence($bioreg)
    {
        $specificBioregionPresence = $this->presences->filter(function($item, $key) use($bioreg){
            return Biogeographicregion::where('id', $item->pivot->biogeographicregion_id)->first()->name == $bioreg;
        });

        if ($specificBioregionPresence->count() > 0) {
            return $specificBioregionPresence->first()->code;
        } else {
            return '';
        }
    }

    public function getFormattedConservations()
    {
        $allConservations = $this->conservations->map(function($item, $key){
            return [
                Biogeographicregion::where('id', $item->pivot->biogeographicregion_id)->first()->name . '[' . $item->code . ']',
            ];
        });

        return $allConservations;
    }

    public function getFormattedConservation($bioreg)
    {
        $specificBioregionConservation = $this->conservations->filter(function($item, $key) use($bioreg){
        	return Biogeographicregion::where('id', $item->pivot->biogeographicregion_id)->first()->name == $bioreg;
        });

        if ($specificBioregionConservation->count() > 0) {
        	return $specificBioregionConservation->first()->code;
        } else {
        	return '';
        }
    }

    public function getFormattedTrends()
    {
        $allTrends = $this->trends->map(function($item, $key){
            return [
                Biogeographicregion::where('id',$item->pivot->biogeographicregion_id)->first()->name . '[' . $item->name . ']',
            ];
        });

        return $allTrends;
    }

    public function getFormattedTrend($bioreg)
    {
        $specificBioregionTrend = $this->trends->filter(function($item, $key) use($bioreg){
        	return Biogeographicregion::where('id',$item->pivot->biogeographicregion_id)->first()->name == $bioreg;
        });

        if ($specificBioregionTrend->count() > 0) {
        	return $specificBioregionTrend->first()->code;
        } else {
        	return '';
        }
    }

    public function isInAnnexII() {
    	return DB::table('species_annex0712_ii')->where('species_code',$this->species_code)->first() != null;
    }

    public function isInAnnexIV() {
    	return DB::table('species_annex0712_iv')->where('species_code',$this->species_code)->first() != null;
    }

    public function isInAnnexV() {
    	return DB::table('species_annex0712_v')->where('species_code',$this->species_code)->first() != null;
    }

    public function annexList() {
    	$finalList = '';
    	if ($this->isInAnnexII())
    		$finalList = $finalList . 'II - ';
    	if ($this->isInAnnexIV())
    		$finaList = $finalList . 'IV - ';
    	if ($this->isInAnnexV())
    		$finaList = $finalList . 'V';

    	return $finalList;
    }

    // Better to have list of the annexes as an array
    public function annexes() 
    {
    	$finalList = [];
    	if ($this->isInAnnexII())
    		array_push($finalList, 'II');
    	if ($this->isInAnnexIV())
    		array_push($finalList, 'IV');
    	if ($this->isInAnnexV())
    		array_push($finalList, 'V');

    	return $finalList;
    }

    // This section is about the modified Species... at the moment the system is not optimized so se must base the search on the table itself

    public function isModified() {
        // since it is a collection that can be empty
    	return count($this->modification_codes) != 0;
    }

    public function handleModifiedSpecies() {
    	$out_collection = collect();
        foreach ($this->modification_codes as $mod_code) {
        	switch ($mod_code->modified_code) {
        		case 'NN':
        			$out_collection = $out_collection->merge($this->handleNN());
        		break;

        		case 'SP':
        			$out_collection =  $out_collection->merge($this->handleSP());
        		break;

        		case 'CO':
        			$out_collection =  $out_collection->merge($this->handleCO());
        		break;

        		case 'AD':
        			$out_collection =  $out_collection->merge($this->hanldeAD());
        		break;
        	}
        }
        return $out_collection;
    }

    private function handleNN() {
    	if (DB::table('species_modified_nn')->where('species_code',$this->species_code)->exists()) {
    		$connected_species['text_of_modification'] = 'Specie a cui è stato modificato il nome dopo il report 2007/2012';

    		$tempData = DB::table('species_modified_nn')->where('species_code',$this->species_code)->pluck('species_code_new');
    		$connected_species['species'] = Species::whereIn('species_code', $tempData)->get();
    	}

    	if (DB::table('species_modified_nn')->where('species_code_new',$this->species_code)->exists()) {
    		$connected_species['text_of_modification'] = 'Specie con nome modificato da specie originale dopo il report 2007/2012';
    		$tempData = DB::table('species_modified_nn')->where('species_code_new',$this->species_code)->pluck('species_code');
    		$connected_species['species'] = Species::whereIn('species_code', $tempData)->get();
    	}
    	return $connected_species;
    }

    private function handleSP() {
    	if (DB::table('species_modified_sp')->where('species_code',$this->species_code)->exists()) {
    		$connected_species['text_of_modification'] = 'Specie splittata dopo il report 2007/2012';
    		$tempData = DB::table('species_modified_sp')->where('species_code',$this->species_code)->pluck('species_code_new');
    		$connected_species['species'] = Species::whereIn('species_code', $tempData)->get();
    	}

    	if (DB::table('species_modified_sp')->where('species_code_new',$this->species_code)->exists()) {
    		$connected_species['text_of_modification'] = 'Specie derivata da uno split di una specie originale dopo il report 2007/2012';
    		$tempData = DB::table('species_modified_sp')->where('species_code_new',$this->species_code)->pluck('species_code');
    		$connected_species['species'] = Species::whereIn('species_code', $tempData)->get();
    	}
    	return $connected_species;
    }

    private function handleCO() {
    	if (DB::table('species_modified_co')->where('species_code',$this->species_code)->exists()) {
    		$connected_species['text_of_modification'] = 'Specie modificata in complex dopo il report 2007/2012';
    		$tempData = DB::table('species_modified_co')->where('species_code',$this->species_code)->pluck('species_code_new');
    		$connected_species['species'] = Species::whereIn('species_code', $tempData)->get();
    	}

    	if (DB::table('species_modified_co')->where('species_code_new',$this->species_code)->exists()) {
    		$connected_species['text_of_modification'] = 'Specie complex modificata da una specie originale dopo il report 2007/2012';
    		$tempData = DB::table('species_modified_co')->where('species_code_new',$this->species_code)->pluck('species_code');
    		$connected_species['species'] = Species::whereIn('species_code', $tempData)->get();
    	}
    	return $connected_species;
    }

    private function handleAD() {
    	//$connected_species['text_of_modification'] = 'Specie aggiunta dopo il report 2007/2012';
    	//connected_species['species'] = '';
        //return $connected_species;
    }

    public function scopeBiogeoregAND(Builder $query, $biogeoregName, $biogeoregBoolean) {
        if ($biogeoregBoolean) {
            return $query->whereHas('biogeographicregions', function($q) use($biogeoregName) {
                $q->where('name',$biogeoregName);
            });
        } else {
            return $query->whereDoesntHave('biogeographicregions', function($q) use($biogeoregName) {
                $q->where('name',$biogeoregName);
            });
        }
    }

    public function scopeConservationAND(Builder $query, $conservationCode, $conservationBoolean) {
        if ($conservationBoolean) {
            return $query->whereHas('conservations', function($q) use($conservationCode) {
                $q->where('code',$conservationCode);
            });
        } else {
            return $query->whereDoesntHave('conservations', function($q) use($conservationCode) {
                $q->where('code',$conservationCode);
            });
        }
    }

    public function scopeAllBiogeoregAND(Builder $query, $list_of_biogeoreg) {
        foreach ($list_of_biogeoreg as $elmName => $elmBool) {
            if ($elmName != 'ND')
                $query->biogeoregAND($elmName, $elmBool);
        }

        return $query;
    }

    public function scopeAllConservationAND(Builder $query, $list_of_conservation) {
        foreach ($list_of_conservation as $elmName => $elmBool) {
            $query->conservationAND($elmName, $elmBool);
        }

        return $query;
    }

    public function scopeAllBiogeoregOR_FalseExcluded(Builder $query, $list_of_biogeoreg) {
        // In case of ND (not defined biogeographic regions) since it's not a code of biogeoregion we have to take it out from
        // the array and works it apart. Of course it can't be used with AND but only with OR .... I want among the 
        // selected species the ones in the ALP and that have not defined biogeoregion; NOT ALP and NOT DEFINED
        $included = [];
        $notIncluded = [];

        foreach ($list_of_biogeoreg as $key => $value) {
            if ($key != 'ND') {
                if ($value == true)
                    array_push($included, $key);
                else
                    array_push($notIncluded, $key);
            }

        }

        if ($list_of_biogeoreg['ND'] == false) {
            return $query->whereHas('biogeographicregions', function($q) use($included) {
                        $q->whereIn('name',$included);
                    })->whereDoesntHave('biogeographicregions', function($q) use($notIncluded) {
                        $q->whereIn('name',$notIncluded);
                    });
        }

        if ($list_of_biogeoreg['ND'] == true) {
            return $query
                ->where(function($qq) use ($notIncluded, $included) {
                    $qq->whereHas('biogeographicregions', function($q) use($included) {
                            $q->whereIn('name',$included);
                        })->whereDoesntHave('biogeographicregions', function($q) use($notIncluded) {
                            $q->whereIn('name',$notIncluded);
                        });
                })->orWhere(function($qq) {
                    $qq->whereDoesntHave('biogeographicregions', function($q) {
                            $q->whereIn('name',['ALP','MED','CON','MMED']);
                        }); 
                });
        }
        
    }

    public function scopeAllBiogeoregOR(Builder $query, $list_of_biogeoreg) {

        // In case of ND (not defined biogeographic regions) since it's not a code of biogeoregion we have to take it out from
        // the array and works it apart. Of course it can't be used with AND but only with OR .... I want among the 
        // selected species the ones in the ALP and that have not defined biogeoregion; NOT ALP and NOT DEFINED
        $included = [];
        $notIncluded = [];

        foreach ($list_of_biogeoreg as $key => $value) {
            if ($key != 'ND') {
                if ($value == true)
                    array_push($included, $key);
                else
                    array_push($notIncluded, $key);
            }

        }

        if ($list_of_biogeoreg['ND'] == false) {
            return $query->whereHas('biogeographicregions', function($q) use($included) {
                        $q->whereIn('name',$included);
                    });
        }

        if ($list_of_biogeoreg['ND'] == true) {
            return $query
                ->where(function($qq) use ($notIncluded, $included) {
                    $qq->whereHas('biogeographicregions', function($q) use($included) {
                            $q->whereIn('name',$included);
                        });
                })->orWhere(function($qq) {
                    $qq->whereDoesntHave('biogeographicregions', function($q) {
                            $q->whereIn('name',['ALP','MED','CON','MMED']);
                        }); 
                });
        }
        
        
    }

    public function scopeAllConservationOR(Builder $query, $list_of_conservation) {
        $included = [];
        $notIncluded = [];

        foreach ($list_of_conservation as $key => $value) {
            if ($value == true)
                array_push($included, $key);
            else
                array_push($notIncluded, $key);

        }

        return $query->whereHas('conservations', function($q) use($included) {
                    $q->whereIn('code',$included);
                })->whereDoesntHave('conservations', function($q) use($notIncluded) {
                    $q->whereIn('code',$notIncluded);
                });
    }
   
}
