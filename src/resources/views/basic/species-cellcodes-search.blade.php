@extends('partials.layout')

@section('content')
<div class="c-content-box c-size-md c-bg-white">
  <div class="container">
   	<div class="row">
      <div class="col-md-5">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <div class="row">
              <div class="col-sm-8">
                  <h4 class="input-font-mimi-big">Ricerca per Cella</h4>
              </div>
              <div class="col-sm-4">
                <div class="loader" v-if="loading"></div>
              </div>
            </div>
          </div>
          <div class="ibox-content">
            <form methd="GET" action="/cellcodes/species/" v-ajax>
              {!! csrf_field() !!}
              <div class="row">
                <div class="col-sm-8 has-success">
                  <input type="text"
                    class="form-control"
                    v-model="selectedCell"
                    id="cellCodeSelectionBox"
		    :disabled="loading"/>
                </div>
                <div class="col-sm-4">
                  <button type="submit" class="btn btn-primary btn-lg pull-right" :disabled="loading"><strong>Cerca</strong></button>
                </div>
              </div>  
            </form>

          </div>
        </div>
      </div>
      <div class="col-md-7">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <div class="row">
              <div class="col-sm-12">
                  <h4 class="input-font-mimi-big">Mappa di Distribuzione Specie <span style="font-size: 14px">    [disponibile solo per le specie terrestri e di acqua dolce]</span></h4>
              </div>
            </div>
          </div>
          <div class="ibox-content">
            <div id="map" class="map-style"></div>
          </div>
        </div>
      </div>
    </div>

	<div class="row" v-if="dataAvailable">
		<div class="col-md-5 c-margin-b-30 wow animate fadeInDown" style="opacity: 1; visibility: visible; animation-name: fadeInDown;">
        <div class="col-sm-12">
          <h2 class="c-font-uppercase c-font-bold c-font-26 c-margin-b-20">Numero di Specie filtrate nella cella @{{ selectedCell }} : @{{ speciesDetails.length }}</h2>
        </div>
      </div>
      <div class="col-md-7 c-margin-b-30 wow animate fadeInDown" style="opacity: 1; visibility: visible; animation-name: fadeInDown;">
               
                <ul class="c-works pull-right">
                  <li class="c-first mimi-legenda-advanced">
            <h4 class="c-font-black">Regioni Biogeografiche</h4>
            <ul class="c-legenda">
              <li>MED = Mediterranea</li>
              <li>CON = Continentale</li>
              <li>ALP = Alpina</li>
	      <li>MMED = Marina Mediterranea</li>
            </ul>                   
                  </li>
                  <li class="mimi-legenda-advanced">
            <h4 class="c-font-black">Stato di Conservazione</h4>
            <ul class="c-legenda">
              <li><div class="mimi-legenda-block legenda-green"></div>Favorevole</li>
              <li><div class="mimi-legenda-block legenda-yellow"></div>Inadeguato</li>
              <li><div class="mimi-legenda-block legenda-red"></div>Cattivo</li>
              <li><div class="mimi-legenda-block legenda-grey"></div>Sconosciuto</li>
            </ul>                                     
                  </li>
                  <li class="c-last mimi-legenda-advanced">
            <h4 class="c-font-black">Trend</h4>
            <ul class="c-legenda">
              <li><img src="{!! asset('images/green_up.png') !!}" />In miglioramento</li>
              <li><img src="{!! asset('images/yellow_stable.png') !!}" />Stabile</li>
              <li><img src="{!! asset('images/red_down.png') !!}" />In peggioramento</li>
              <li><img src="{!! asset('images/grey_null.png') !!}" />Sconosciuto</li>
            </ul>                   
                  </li>
                </ul>
      
    </div>
	</div>

    <div class="row">
      <multi-species-info-cell :list="speciesDetails"></multi-species-info-cell>
    </div>
	<div class="row">
	      <div class="col-md-4" v-if="dataAvailable">
		<a href="#" class="btn btn-xlg c-btn-blue c-btn-square c-btn-border-2x" id="export-csv" v-on:click="getCsv">Esporta CSV</a>
      </div>
    </div>
  </div>
</div>
</div>

<template id="multi-species-info-cell-template">
  <table class="table table-hover table-fixed">
    <thead>
      <tr>
          <th rowspan="2" class="mimi-table-cell-font">Codice</th>
          <th rowspan="2" class="mimi-table-cell-font">Nome Specie</th>
          <th colspan="4" class="mimi-table-cell-font">Stato di Conservazione</th>
          <th colspan="4" class="mimi-table-cell-font">Trend</th>
          <th rowspan="2" class="mimi-table-cell-font">Reg. Biog.</th>
          <th rowspan="2" class="mimi-table-cell-font">Allegati</th>
          <th rowspan="2" class="mimi-table-cell-font">Tassonomia</th>
      </tr>
      <tr>
          <th>ALP</th>
          <th>CON</th>
          <th>MED</th>
	  <th>MMED</th>
          <th>ALP</th>
          <th>CON</th>
          <th>MED</th>
	  <th>MMED</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="spec in list">
        <td class="mimi-table-cell-font"><a v-bind:href=" '/species-basic-search/'+spec.species_code" target="_blank" >@{{ spec.species_code }}</a></td>
        <td class="mimi-table-cell-font">@{{ spec.species_name }}</td>
        <td><div v-bind:class="itemStatusStyle(spec, 'alp')"></div></td>
        <td><div v-bind:class="itemStatusStyle(spec, 'con')"></div></td>
        <td><div v-bind:class="itemStatusStyle(spec, 'med')"></div></td>
	<td><div v-bind:class="itemStatusStyle(spec, 'mmed')"></div></td>
        <td><div><span><img v-bind:src="itemTrendStyle(spec, 'alp')" class="trend-image" /></span></div></td>
        <td><div><span><img v-bind:src="itemTrendStyle(spec, 'con')" class="trend-image" /></span></div></td>
        <td><div><span><img v-bind:src="itemTrendStyle(spec, 'med')" class="trend-image" /></span></div></td>
	<td><div><span><img v-bind:src="itemTrendStyle(spec, 'mmed')" class="trend-image" /></span></div></td>
        <td>
            <div v-for="bioreg in spec.bioregions" class="mimi-table-cell-font">@{{ bioreg }}</div>
        </td>
        <td>
            <div v-for="annex in spec.annexes" class="mimi-table-cell-font">@{{ annex }}</div>
        </td>
        <td>
            <div><img src="{!! asset('images/kingdom_vlittle.png') !!}" /> @{{ spec.kingdom_name }}</div>
            <!--<div><img src="{!! asset('images/phylum_vlittle.png') !!}" /> @{{ spec.phylum_name }}</div>-->
            <div><img src="{!! asset('images/class_vlittle.png') !!}" /> @{{ spec.class_name }}</div> 
            <!--<div><img src="{!! asset('images/order_vlittle.png') !!}" /> @{{ spec.order_name }}</div>
            <div><img src="{!! asset('images/family_vlittle.png') !!}" /> @{{ spec.family_name }}</div>
            <div><img src="{!! asset('images/genus_vlittle.png') !!}" /> @{{ spec.genus_name }}</div>-->
        </td>
      </tr>
    </tbody>
  </table>          
</template>

@endsection

@section('added-scripts')
	<script src="{!! asset('js/csv_species_generator.js') !!}"></script>
	<script src="{!! asset('js/cellToSpeciesMapping.js') !!}"></script>
  <script src="{!! asset('js/main_cells_to_species_III_report.js') !!}"></script>
@endsection
