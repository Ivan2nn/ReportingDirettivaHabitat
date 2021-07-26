<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Habitat extends Model
{
    protected $table = 'habitat';

	public $incrementing = false;

	protected $primaryKey = 'habitat_code';

	public function macrocategory() {
		return $this->belongsTo('App\Macrocategory','habitat_macrocategory_id','habitat_macrocategory_id');
	}

	public function cellcodes()
    {
    	return $this->belongsToMany('App\Cellcode','cellcode_habitat','habitat_code','cellcode_id')->withPivot('report');
    }

    public function biogeographicregions() 
    {
        return $this->belongsToMany('App\Biogeographicregion','habitat_data0712_status_conserve','habitat_code','biogeographicregion_id');
    }

    public function presences()
    {
        return $this->belongsToMany('App\Presence','habitat_data0712_presence','habitat_code','status_presence_id')->withPivot(['biogeographicregion_id','report']);
    }

    public function conservations()
    {
        return $this->belongsToMany('App\Conservation','habitat_data0712_status_conserve','habitat_code','status_conserve_id')->withPivot(['biogeographicregion_id','report']);
    }

    public function trends()
    {
        return $this->belongsToMany('App\Trend','habitat_data0712_trend','habitat_code','trend_id')->withPivot(['biogeographicregion_id','report']);
    }

    public function getFormattedPresence($report_number, $bioreg)
    {
        $specificBioregionPresence = $this->presences()->where('report',$report_number)->get()->filter(function($item, $key) use($bioreg, $report_number){
        	return Biogeographicregion::where('id', $item->pivot->biogeographicregion_id)->first()->name == $bioreg;
        });

        if ($specificBioregionPresence->count() > 0) {
        	return $specificBioregionPresence->first()->code;
        } else {
        	return '';
        }
    }

    public function getFormattedConservation($report_number, $bioreg)
    {
        $specificBioregionConservation = $this->conservations()->where('report',$report_number)->get()->filter(function($item, $key) use($bioreg){
        	return Biogeographicregion::where('id', $item->pivot->biogeographicregion_id)->first()->name == $bioreg;
        });

        if ($specificBioregionConservation->count() > 0) {
        	return $specificBioregionConservation->first()->code;
        } else {
        	return '';
        }
    }

    public function getFormattedTrend($report_number, $bioreg)
    {
        $specificBioregionTrend = $this->trends()->where('report',$report_number)->get()->filter(function($item, $key) use($bioreg){
        	return Biogeographicregion::where('id',$item->pivot->biogeographicregion_id)->first()->name == $bioreg;
        });

        if ($specificBioregionTrend->count() > 0) {
        	return $specificBioregionTrend->first()->code;
        } else {
        	return '';
        }
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

    public function scopeUsingReport(Builder $query, $report_version) {
        return $query->where('report', $report_version);
    }
}
