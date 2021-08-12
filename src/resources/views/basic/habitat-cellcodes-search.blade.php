@extends('partials.layout')

@section('content')
<div class="c-content-box c-size-md c-bg-white">
  <div class="container">
   	<div class="row" style="padding-left: 15px;">

       <div class="row c-margin-b-40">
        <div class="col-md-5">
          <h1 class="c-font-bold c-margin-b-40 c-margin-t-60 c-margin-l-20">Habitat</h1>
          <p>Ricerca dati 4° report (2013-2018) per gli habitat</p>
        </div>
      </div>

      <div class="col-md-5">
        <div class="ibox float-e-margins">

          <div class="ibox-title">
            <div class="row">
             <h2 class="c-font-bold">Ricerca per Cella</h2>
              <div class="col-sm-4">
                <div class="loader" v-if="loading"></div>
              </div>
            </div>
          </div>

          <div class="ibox-content">
            <form methd="GET" action="/cellcodes/habitat/" v-ajax>
              {!! csrf_field() !!}
              <div class="row">
                <div class="col-sm-8" style="padding-left: 0!important;">
                  <input style="height: 42px;" type="text"
                    class="form-control"
                    v-model="selectedCell"
                    id="cellCodeSelectionBox"
		    :disabled="loading" />
                </div>
                <div class="col-sm-4" style="padding-left: 0!important;">
                  <button type="submit" class="button-link btn btn-primary btn-lg pull-left" :disabled="loading">Cerca</button>
                </div>
              </div>  
            </form>

          </div>
        </div>
        <a href="#results" v-if="dataAvailable" class="text-link">Vai ai resultati</a>

      </div>
      <div class="col-md-7">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <div class="row">
              <div class="col-sm-12">
                  <h3 class="">Mappa di Distribuzione Habitat</h3>
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
    <div class="container" id="results">
     

      <div class="row c-margin-t-40" v-if="dataAvailable">
        <div class="col-md-6 c-margin-b-30">
          <div class="col-sm-12">
            <h2 class="c-font-bold c-margin-b-20">Numero di Habitat filtrati nella cella @{{ selectedCell }} : @{{ habitatDetails.length }}</h2>
          </div>
        </div>
        <div class="col-md-6">
          <a href="#" class="button-link pull-right hidden-xs" id="export-csv" v-on:click="getCsv">Esporta CSV</a>
          <a href="#" class="button-link pull-left visible-xs" id="export-csv" v-on:click="getCsv">Esporta CSV</a>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12" style="overflow-x:auto;">
          <multi-habitat-info-cell :list="habitatDetails"></multi-habitat-info-cell>
        </div>
    </div>

    @include('partials.legenda')

    </div><!-- end of 2. container -->
  </div>


</div> <!-- end of the page -->



<template id="multi-habitat-info-cell-template">
  <table class="table table-hover table-fixed">
    <thead>
      <tr>
          <th rowspan="2" class="mimi-table-cell-font">Codice</th>
          <th rowspan="2" class="mimi-table-cell-font" style="width: 300px;">Nome Habitat</th>
          <th colspan="4" class="mimi-table-cell-font" style="border-bottom: 2px solid #00B783!important;">Stato di Conservazione / Trend</th>
          <th rowspan="2" class="mimi-table-cell-font">Reg. Biog.</th>
      </tr>
      <tr>
          <th>ALP</th>
          <th>CON</th>
          <th>MED</th>
	        <th>MMED</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="hab in list">
        <td class="mimi-table-cell-font"><a v-bind:href=" '/habitat-basic-search/'+hab.habitat_code" target="_blank" >@{{ hab.habitat_code }}</a></td>
        <td class="mimi-table-cell-font">@{{ hab.habitat_name }}</td>
        <td>
          <span><img v-bind:src="itemTrendStyle(hab, 'alp')" class="trend-image" /></span>
          <div class="pull-left" style="margin-right: 5px;" v-bind:class="itemStatusStyle(hab, 'alp')"></div>
        </td>
        <td>
          <span><img v-bind:src="itemTrendStyle(hab, 'con')" class="trend-image" /></span>
          <div class="pull-left" style="margin-right: 5px;" v-bind:class="itemStatusStyle(hab, 'con')"></div>
        </td>
        <td>
          <span><img v-bind:src="itemTrendStyle(hab, 'med')" class="trend-image" /></span>
          <div class="pull-left" style="margin-right: 5px;" v-bind:class="itemStatusStyle(hab, 'med')"></div>
        </td>
        <span><img v-bind:src="itemTrendStyle(hab, 'mmed')" class="trend-image" /></span>
	      <td><div class="pull-left" style="margin-right: 5px;" v-bind:class="itemStatusStyle(hab, 'mmed')"></div>
        </td>
        <td>
            <div v-for="bioreg in hab.bioregions" class="mimi-table-cell-font">@{{ bioreg }}</div>
        </td>
      </tr>
    </tbody>
  </table>          
</template>

@endsection

@section('added-scripts')
	<script src="{!! asset('js/csv_habitat_generator.js') !!}"></script>
	<script src="{!! asset('js/cellToSpeciesMapping.js') !!}"></script>
  <script src="{!! asset('js/main_cells_to_habitats_IV_report.js') !!}"></script>
@endsection
