<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Cellcode;
use App\Species;
use App\Habitat;

class CellCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('basic.species-map-search');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $cellCodeName
     * @return \Illuminate\Http\Response
     */
    public function show($cellCodeName)
    {
        
    }

    public function getSpeciesFromCellcodes($cellCodeName, $report_number)
    {
        $cellCodeData = [];
        $selectedCellCode = Cellcode::where('cellname',$cellCodeName)->first();
        $species_in_cellcodes = $selectedCellCode->species()->where('report',$report_number)->get();
        
        $final_species = $this->get_species_info($species_in_cellcodes, $report_number)->unique('species_name');
        $final_species_sorted = $final_species->sortBy('species_name');
        
        return json_encode($final_species_sorted->values()->all());
    }

    public function get_species_info($species_list, $report_number) {
        $species_info = [];
        $species_info = $species_list->map(function($item, $key) use($report_number) {
            $species = Species::find($item->species_code);
            // ERROR :: If the original database of the species would be full even with duplicate species this could be taken out
            if ($species && $species->taxonomy) {

                return [
                    'species_code' => $species->species_code,
                    'species_name' => $species->species_name,
                    'species_conservation_alp' => $species->getFormattedConservation($report_number,"ALP"),
                    'species_conservation_con' => $species->getFormattedConservation($report_number,"CON"),
                    'species_conservation_med' => $species->getFormattedConservation($report_number,"MED"),
                    'species_conservation_mmed' => $species->getFormattedConservation($report_number, "MMED"),
                    'species_trend_alp' => $species->getFormattedTrend($report_number,"ALP"),
                    'species_trend_con' => $species->getFormattedTrend($report_number,"CON"),
                    'species_trend_med' => $species->getFormattedTrend($report_number,"MED"),
                    'species_trend_mmed' => $species->getFormattedTrend($report_number, "MMED"),
                    'class_name' => $species->taxonomy->tax_classis ? $species->taxonomy->tax_classis->class_name : ' ',
                    'family_name' => $species->taxonomy->tax_family ? $species->taxonomy->tax_family->family_name : ' ',
                    'kingdom_name' => $species->taxonomy->tax_kingdom ? $species->taxonomy->tax_kingdom->kingdom_name : ' ',
                    'order_name' => $species->taxonomy->tax_order ? $species->taxonomy->tax_order->order_name : ' ',
                    'phylum_name' => $species->taxonomy->tax_phylum ? $species->taxonomy->tax_phylum->phylum_name : ' ',
                    'genus_name' => $species->taxonomy->tax_genus ? $species->taxonomy->tax_genus->genus_name : ' ',
                    'bioregions' => $species->biogeographicregions()->where('report',$report_number)->get()->pluck('name')->toArray(),
                    'annexes' => $species->annexes($report_number)
                ];
            }
        });

        return $species_info;
    }

    public function getHabitatsFromCellcodes($cellCodeName, $report_number)
    {
        $cellCodeData = [];
        $selectedCellCode = Cellcode::where('cellname',$cellCodeName)->first();
        $habitats_in_cellcodes = $selectedCellCode->habitats()->where('report',$report_number)->get();
        
        $final_habitats = $this->get_habitat_info($habitats_in_cellcodes, $report_number)->unique('habitat_name');
        $final_habitat_sorted = $final_habitats->sortBy('habitat_code');

        return json_encode($final_habitat_sorted->values()->all());
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
                    'habitat_conservation_alp' => $habitat->getFormattedConservation($report_number, "ALP"),
                    'habitat_conservation_con' => $habitat->getFormattedConservation($report_number, "CON"),
                    'habitat_conservation_med' => $habitat->getFormattedConservation($report_number, "MED"),
                    'habitat_trend_alp' => $habitat->getFormattedTrend($report_number, "ALP"),
                    'habitat_trend_con' => $habitat->getFormattedTrend($report_number, "CON"),
                    'habitat_trend_med' => $habitat->getFormattedTrend($report_number, "MED"),
                    'bioregions' => $habitat->biogeographicregions()->where('report',$report_number)->get()->pluck('name')->toArray(),
                ];
            }
        });
        
        return $habitat_info;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
