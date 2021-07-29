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
    <div class="container">
      <div class="row c-margin-t-40 c-margin-b-40">
        <div class="c-margin-b-30">
          <h2 class="c-font-bold" style="margin-left: 20px">Legenda</h2>
        </div>
        <div class="c-margin-b-40" style="margin-left: 14px;">
          <div class="col-sm-3">
            <h4 class="c-margin-b-20">Regioni Biogeografiche</h4>
            <ul class="list-unstyled">
              <li><span class="c-font-bold">MED</span> = Mediterranea</li>
              <li><span class="c-font-bold">CON</span> = Continentale</li>
              <li><span class="c-font-bold">ALP</span> = Alpina</li>
              <li><span class="c-font-bold">MMED</span> = Marina Mediterranea</li>
            </ul>     
          </div>
          <div class="col-sm-3">
            <h4 class="c-margin-b-20 h4m">Presenza</h4>
            <ul class="list-unstyled">
              <li><span class="c-font-bold">PRE</span> = Presente</li>
              <li><span class="c-font-bold">OCC</span> = Occasionale</li>
              <li><span class="c-font-bold">MAR</span> = Marginale</li>
              <li><span class="c-font-bold">TAX</span> = Tassonomia non definita</li>
              <li><span class="c-font-bold">EXa</span> = Estinta dopo l'entrata in vigore della DH</li>
              <li><span class="c-font-bold">EXp</span> = Estinta prima dell'entrata in vigore della DH</li>
              <li><span class="c-font-bold">NP</span> = Non Presente</li>
            </ul> 
          </div>
          <div class="col-sm-3">
            <h4 class="c-margin-b-20 h4m">Stato di Conservazione</h4>
            <ul class="list-unstyled">
              <li><div class="mimi-legenda-block legenda-green"></div>Favorevole</li>
              <li><div class="mimi-legenda-block legenda-yellow"></div>Inadeguato</li>
              <li><div class="mimi-legenda-block legenda-red"></div>Cattivo</li>
              <li><div class="mimi-legenda-block legenda-grey"></div>Sconosciuto</li>
            </ul> 
          </div>
          <div class="col-sm-3">
            <h4 class="c-margin-b-20 h4m">Trend</h4>
            <ul class="list-unstyled">
              <li><img src="{!! asset('images/green_up.png') !!}" />In miglioramento</li>
              <li><img src="{!! asset('images/yellow_stable.png') !!}" />Stabile</li>
              <li><img src="{!! asset('images/red_down.png') !!}" />In peggioramento</li>
              <li><img src="{!! asset('images/grey_null.png') !!}" />Sconosciuto</li>
            </ul> 
          </div>

        </div>
      </div>

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


    </div><!-- end of 2. container -->
  </div>


</div> <!-- end of the page -->



<template id="multi-habitat-info-cell-template">
  <table class="table table-hover table-fixed">
    <thead>
      <tr>
          <th rowspan="2" class="mimi-table-cell-font">Codice</th>
          <th rowspan="2" class="mimi-table-cell-font">Nome Habitat</th>
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
