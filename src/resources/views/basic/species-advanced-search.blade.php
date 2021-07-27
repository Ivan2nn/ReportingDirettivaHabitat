@extends('partials.layout')

@section('content')

<div class="c-content-box c-size-md c-bg-white">
  <div class="container">
    <div class="row">
      <div class="row" style="padding-left: 15px; padding-right: 15px;">
      <div class="row c-margin-b-40" style="padding-left: 15px;">
        <div class="col-md-5">
        <h1 class="c-font-bold c-margin-b-40 c-margin-t-60 c-margin-l-20">Species</h1>
        <p>Morbi ut elit at arcu aliquet consequat. Ut eget mi gravida, aliquam ligula vitae, posuere lacus.</p>
      </div>
    </div>
      <div class="col-md-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <div class="row">
              <div class="col-sm-8">
                  <h2 class="c-font-bold">Ricerca Avanzata</h2>
              </div>
              <div class="col-sm-4">
                <div class="loader" v-if="loadingAdvancedData"></div>
              </div>
            </div>
          </div>
          <div class="ibox-content col-sm-12">
            <form method="GET" @submit.prevent="searchSpeciesFromSelections">
              {!! csrf_field() !!}
            <div class="row">
                <div class="col-sm-12 col-md-4">
                  <div class="row" style="padding-left: 15px;">
                    @foreach($kingdoms as $kingdom)
                      @if ($kingdom->kingdom_name != 'Bacteria' && $kingdom->kingdom_name != 'Fungi' && $kingdom->kingdom_name != 'Protista')
                        <div class="panel-group" id="accordion">
                          <div class="panel panel-default">
                            <div class="panel-heading">
                              <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="{{ '#' . $kingdom->kingdom_name . '-collapse' }}">
                                  </span>{{ $kingdom->kingdom_name}}</a>
                              </h4>
                            </div>
                            <div id="{{ $kingdom->kingdom_name . '-collapse' }}" class="panel-collapse collapse in">
                              <div id="{{ $kingdom->kingdom_name . '_jstree' }}">
                                <ul>
                                @foreach($kingdom->phyla() as $phylum)
                                  <li data-jstree='{"icon":"../images/phylum_vlittle.png"}' rel="phylum">{{ $phylum->phylum_name }}
                                    <ul>
                                    @foreach($phylum->classes() as $class)
                                      <li data-jstree='{"icon":"../images/class_vlittle.png"}' rel="class">{{ $class->class_name }}
                                        <ul>
                                        @foreach($class->orders() as $order)
                                        <li data-jstree='{"icon":"../images/order_vlittle.png"}' rel="order">{{ $order->order_name }}
                                          <ul>
                                          @foreach($order->families() as $family)
                                          <li data-jstree='{"icon":"../images/family_vlittle.png"}' rel="family">{{ $family->family_name }}
                                            <ul>
                                            @foreach($family->genera() as $genus)
                                              <li data-jstree='{"icon":"../images/genus_vlittle.png"}' rel="genus" code='{{ $genus->genus_code }}'>{{ $genus->genus_name }}</li>
                                            @endforeach
                                            </ul>
                                          </li>
                                          @endforeach
                                          </ul>
                                        </li>
                                        @endforeach
                                        </ul>
                                      </li>
                                    @endforeach
                                    </ul>
                                  </li>
                                @endforeach
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endif
                    @endforeach
                  </div>
                </div>
              <div class="col-sm-12 col-md-4">
                  <div class="row">
                    <div class="panel-group" id="accordion">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h4 class="panel-title">Regioni Biogeografiche</h4>
                        </div>
                        <div class="panel-body">
                          <div class="col-sm-12">
                            <h2>ALP</h2>
                            <input class="js-switch-alp" type="checkbox" data-switchery="true" checked />
                            
                          </div>
                          <div class="col-sm-12">
                            <h2>CON</h2>
                            <input class="js-switch-con" type="checkbox" checked />
                            
                          </div>
                          <div class="col-sm-12">
                            <h2>MED</h2>
                            <input class="js-switch-med" type="checkbox" checked />
                          </div>
			  <div class="col-sm-12">
                            <h2>MMED</h2>
                            <input class="js-switch-mmed" type="checkbox" checked/>
                          </div>
                          <!-- <div class="col-sm-12">
                              <h2>ND</h2>
                              <input class="js-switch-nd" type="checkbox" />
                            </div> -->
                          <!-- <div class="col-sm-12 c-margin-t-20">
                              <div class="wrapper">
                                <div class="c-body">
                                  <div class="c-radio-inline">
                                    <div class="c-radio">
                                        <input id="radio4-112" class="c-radio" checked="" name="radios_biogr" value="OR" type="radio">
                                        <label for="radio4-112">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>OR</label>
                                    </div>
                                    <div class="c-radio">
                                        <input id="radio3-112" class="c-radio" name="radios_biogr" value="OR-FE" type="radio">
                                        <label for="radio3-112">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>OR (Falsi esclusi)</label>
                                    </div>
                                    <div class="c-radio">
                                        <input id="radio5-112" class="c-radio" name="radios_biogr" value="AND" type="radio">
                                        <label for="radio5-112">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>AND</label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div> -->

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-4">
                    <div class="row">
                    <div class="panel-group" id="accordion">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h4 class="panel-title">Stato di Conservazione</h4>
                        </div>
                        <div class="panel-body">
                          <div class="col-sm-12">
                            <h2>Favorevole</h2>
                            <input class="js-switch-status-fv" type="checkbox" checked />
                            
                          </div>
                          <div class="col-sm-12">
                            <h2>Inadeguato</h2>
                            <input class="js-switch-status-u1" type="checkbox" checked />
                            
                          </div>
                          <div class="col-sm-12">
                            <h2>Cattivo</h2>
                            <input class="js-switch-status-u2" type="checkbox" checked />
                            
                          </div>
                          <div class="col-sm-12">
                            <h2>Sconosciuto</h2>
                            <input class="js-switch-status-xx" type="checkbox" checked />
                            
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

                  <div class="row">
                    <div class="col-sm-4">
                      <div class="input-group">
                        
                       <button type="submit" class="button-link btn btn-primary" v-show="true" :disabled="loadingAdvanceData">Cerca</button>      
                      </div>  
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
	<div class="row" v-if="dataAvailable">
		<div class="col-md-6 c-margin-b-30 wow animate fadeInDown" style="opacity: 1; visibility: visible; animation-name: fadeInDown;">
		<div class="col-sm-12">
		  <h2 class="c-font-uppercase c-font-bold c-font-26 c-margin-b-20">Numero di Specie filtrate: @{{ speciesDetails.length }}</h2>
		</div>
	      </div>
      <div class="col-md-6 c-margin-b-30 wow animate fadeInDown" style="opacity: 1; visibility: visible; animation-name: fadeInDown;">
                  <div class="col-sm-12">
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
                  <li class="c-last mimi-legenda-advanced" style="margin-right: 0">
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
	</div>
</div>
	    <div class="row">
		<div class="col-xs-12">
	      <multi-species-info-cell :list="speciesDetails"></multi-species-info-cell>
		</div>
	    </div>
		<div class="row">
		      <div class="col-md-4" v-if="dataAvailable">
			<a href="#" class="btn btn-xlg c-btn-blue c-btn-square c-btn-border-2x" id="export-csv" v-on:click="getCsv">Esporta CSV</a>
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
   <script src="{!! asset('js/vendor/switchery.js') !!}"></script>
	 <script src="{!! asset('js/taxonomy_regbio_status_to_species_IV_report.js') !!}"></script>
   <script src="{!! asset('js/taxonomy_main.js') !!}"></script>
   
@endsection

