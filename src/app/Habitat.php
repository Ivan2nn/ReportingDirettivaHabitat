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

    public function scopeBiogeoregAND(Builder $query, $biogeoregName, $biogeoregBoolean, $report_number) {
        if ($biogeoregBoolean) {
            return $query->whereHas('biogeographicregions', function($q) use($biogeoregName, $report_number) {
                $q->where('name',$biogeoregName)->where('report',$report_number);
            });
        } else {
            return $query->whereDoesntHave('biogeographicregions', function($q) use($biogeoregName, $report_number) {
                $q->where('name',$biogeoregName)->where('report',$report_number);
            });
        }
    }

    public function scopeConservationAND(Builder $query, $conservationCode, $conservationBoolean, $report_number) {
        if ($conservationBoolean) {
            return $query->whereHas('conservations', function($q) use($conservationCode, $report_number) {
                $q->where('code',$conservationCode)->where('report',$report_number);
            });
        } else {
            return $query->whereDoesntHave('conservations', function($q) use($conservationCode, $report_number) {
                $q->where('code',$conservationCode)->where('report',$report_number);
            });
        }
    }

    public function scopeAllBiogeoregAND(Builder $query, $list_of_biogeoreg, $report_number) {
        foreach ($list_of_biogeoreg as $elmName => $elmBool) {
            $query->biogeoregAND($report_number, $elmName, $elmBool);
        }

        return $query;
    }

    public function scopeAllConservationAND(Builder $query, $list_of_conservation, $report_number) {
        foreach ($list_of_conservation as $elmName => $elmBool) {
            $query->conservationAND($report_number, $elmName, $elmBool);
        }

        return $query;
    }

    public function scopeAllBiogeoregOR_FalseExcluded(Builder $query, $list_of_biogeoreg, $report_number) {
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
            return $query->whereHas('biogeographicregions', function($q) use($included, $report_number) {
                        $q->whereIn('name',$included)->where('report',$report_number);
                    })->whereDoesntHave('biogeographicregions', function($q) use($notIncluded, $report_number) {
                        $q->whereIn('name',$notIncluded)->where('report',$report_number);
                    });
        }

        if ($list_of_biogeoreg['ND'] == true) {
            return $query
                ->where(function($qq) use ($notIncluded, $included, $report_number) {
                    $qq->whereHas('biogeographicregions', function($q) use($included, $report_number) {
                            $q->whereIn('name',$included)->where('report',$report_number);
                        })->whereDoesntHave('biogeographicregions', function($q) use($notIncluded, $report_number) {
                            $q->whereIn('name',$notIncluded)->where('report',$report_number);
                        });
                })->orWhere(function($qq) use($report_number) {
                    $qq->whereDoesntHave('biogeographicregions', function($q) use($report_number) {
                            $q->whereIn('name',['ALP','MED','CON','MMED'])->where('report',$report_number);
                        }); 
                });
        }
        
    }

    public function scopeAllBiogeoregOR(Builder $query, $list_of_biogeoreg, $report_number) {
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
            return $query->whereHas('biogeographicregions', function($q) use($included, $report_number) {
                        $q->whereIn('name',$included)->where('report',$report_number);
                    });
        }

        if ($list_of_biogeoreg['ND'] == true) {
            return $query
                ->where(function($qq) use ($notIncluded, $included, $report_number) {
                    $qq->whereHas('biogeographicregions', function($q) use($included, $report_number) {
                            $q->whereIn('name',$included)->where('report',$report_number);
                        });
                })->orWhere(function($qq) use($report_number) {
                    $qq->whereDoesntHave('biogeographicregions', function($q) use($report_number) {
                            $q->whereIn('name',['ALP','MED','CON','MMED'])->where('report',$report_number);
                        }); 
                });
        }
    }

    public function scopeAllConservationOR(Builder $query, $list_of_conservation, $report_number) {
        $included = [];
        $notIncluded = [];

        foreach ($list_of_conservation as $key => $value) {
            if ($value == true)
                array_push($included, $key);
            else
                array_push($notIncluded, $key);

        }

        return $query->whereHas('conservations', function($q) use($included, $report_number) {
                    $q->whereIn('code',$included)->where('report',$report_number);
                })->whereDoesntHave('conservations', function($q) use($notIncluded, $report_number) {
                    $q->whereIn('code',$notIncluded)->where('report',$report_number);
                });
    }
}
