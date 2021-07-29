@extends('partials.layout')

@section('content')
<div class="c-content-box c-size-md c-bg-white">
  <div class="container">
   	<div class="row">
      <div class="row" style="padding-left: 15px; padding-right: 15px;">
      <div class="row c-margin-b-40" style="padding-left: 15px;">
        <div class="col-md-5">
        <h1 class="c-font-bold c-margin-b-40 c-margin-t-60 c-margin-l-20">Species</h1>
        <p>Ricerca dati 4° report (2013-2018) per le specie animali e vegetali</p>
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


  </div> <!-- end of the 2. container -->
</div>





</div> <!-- end of the page -->



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
  <script src="{!! asset('js/main_cells_to_species_IV_report.js') !!}"></script>
@endsection
