@extends('partials.layout')

@section('content')
<div class="c-content-box c-size-md c-bg-white">
  <div class="container">
   	<div class="row">
      <div class="row" style="padding-left: 15px; padding-right: 15px;">
      <div class="row c-margin-b-40" style="padding-left: 15px;">
        <div class="col-md-5">
        <h1 class="c-font-bold c-margin-b-40 c-margin-t-60 c-margin-l-20">Specie</h1>
        <p>Ricerca dati 3° report (2007-2012) per le specie animali e vegetali</p>
      </div>
    </div>
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
                <div class="col-sm-8">
                  <input style="height: 39px;" type="text"
                    class="form-control"
                    v-model="selectedCell"
                    id="cellCodeSelectionBox"
		    :disabled="loading"/>
                </div>
                <div class="col-sm-4">
                  <button type="submit" class="button-link btn btn-primary btn-lg pull-left" :disabled="loading">Cerca</button>
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
                  <h3 class="">Mappa di Distribuzione Specie</h3>
              </div>
            </div>
          </div>
          <div class="ibox-content">
            <div id="map" class="map-style"></div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>




<div class="bg-light-grey">
  <div class="container">

      <div class="row c-margin-t-40" v-if="dataAvailable">
      <div class="col-md-6 c-margin-b-30">
        <div class="col-sm-12">
          <h2 class="c-font-bold c-margin-b-20">Numero di Specie filtrate nella cella @{{ selectedCell }} : @{{ speciesDetails.length }}</h2>
        </div>
      </div>
      <div class="col-md-6">
        <a href="#" class="button-link pull-right hidden-xs" id="export-csv" v-on:click="getCsv">Esporta CSV</a>
        <a href="#" class="button-link pull-left visible-xs" id="export-csv" v-on:click="getCsv">Esporta CSV</a>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12" style="overflow-x:auto;">
        <multi-species-info-cell :list="speciesDetails"></multi-species-info-cell>
      </div>
    </div>

    @include('partials.legenda')

  </div> <!-- end of the 2. container -->
</div>





</div> <!-- end of the page -->



<template id="multi-species-info-cell-template">
  <table class="table table-hover table-fixed">
    <thead>
      <tr>
          <th rowspan="2" class="mimi-table-cell-font">Codice</th>
          <th rowspan="2" class="mimi-table-cell-font">Nome Specie</th>
          <th colspan="4" class="mimi-table-cell-font" style="border-bottom: 2px solid #00B783!important;">Stato di Conservazione / Trend</th>
          <th rowspan="2" class="mimi-table-cell-font">Reg. Biog.</th>
          <th rowspan="2" class="mimi-table-cell-font">Allegati</th>
          <th rowspan="2" class="mimi-table-cell-font">Tassonomia</th>
      </tr>
      <tr>
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
        <td>
          <span><img v-bind:src="itemTrendStyle(spec, 'alp')" class="trend-image" /></span>
          <div class="pull-left" style="margin-right: 5px;" v-bind:class="itemStatusStyle(spec, 'alp')"></div>
        </td>
        <td>
          <span><img v-bind:src="itemTrendStyle(spec, 'con')" class="trend-image" /></span>
          <div class="pull-left" style="margin-right: 5px;" v-bind:class="itemStatusStyle(spec, 'con')"></div>
        </td>
        <td>
          <span><img v-bind:src="itemTrendStyle(spec, 'med')" class="trend-image" /></span>
          <div class="pull-left" style="margin-right: 5px;" v-bind:class="itemStatusStyle(spec, 'med')"></div>
        </td>
	      <td>
          <span><img v-bind:src="itemTrendStyle(spec, 'mmed')" class="trend-image" /></span>
          <div class="pull-left" style="margin-right: 5px;" v-bind:class="itemStatusStyle(spec, 'mmed')"></div>
        </td>

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
