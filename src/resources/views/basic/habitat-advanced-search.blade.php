@extends('partials.layout')

@section('content')

<div class="c-content-box c-size-md c-bg-white">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <div class="row">
              <div class="col-sm-8">
                  <h4 class="input-font-mimi-big">Ricerca Avanzata</h4>
              </div>
              <div class="col-sm-4">
                <div class="loader" v-if="loadingAdvancedData"></div>
              </div>
            </div>
          </div>
          <div class="ibox-content col-sm-12">
        <form method="GET" @submit.prevent="searchHabitatsFromSelections">
            {!! csrf_field() !!}
              <div class="row">
                <div class="col-sm-12 col-md-4">
                  <div class="row">
  		              <div class="panel-group" id="accordion">
  		              	<div class="panel panel-default">
        				        <div class="panel-heading">
        				          <h4 class="panel-title">Macrocategorie</h4>
        				        </div>
    				            <div class="panel-body">
            				  		@foreach ($macrocategories as $macrocategory)
            					    	<div class="col-sm-12">
            					      	<h2>{!! $macrocategory->habitat_macrocategory_name !!}</h2>
            					      	<input class="js-switch-mac-{!! $macrocategory->habitat_macrocategory_id !!}" type="checkbox" data-switchery="true" />
            					    	</div>
            				    		@endforeach
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
          		              <input class="js-switch-mmed" type="checkbox" checked />
          		              
          		            </div>
                          <!--<div class="col-sm-12">
                            <h2>ND</h2>
                            <input class="js-switch-nd" type="checkbox" />
                          </div>-->
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
                            </div>-->

                          </div><!-- ENDoF PANELbODY -->
                        </div><!-- END OF pANEL -->
                      </div><!--end of panel group -->
                    </div><!-- end of row -->
                  </div><!-- end of col-sm-12 -->
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
          		              <input class="js-switch-status-u1" type="checkbox" checked/>
          		              
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
              </div><!-- end of the mega row of the 3 panels -->
              <div class="row">
                <div class="col-sm-4">
                  <div class="input-group">
                    
                    <button type="submit" class="btn btn-primary" v-show="true" :disabled="loadingAdvanceData"><strong>Cerca</strong></button>         
                  </div>  
                </div>
              </div>
            </form>

          </div><!-- end of ibox -->

        </div>
      </div>
    </div>

	<div class="row" v-if="dataAvailable">
		<div class="col-md-5 c-margin-b-30 wow animate fadeInDown" style="opacity: 1; visibility: visible; animation-name: fadeInDown;">
        <div class="col-sm-12">
          <h2 class="c-font-uppercase c-font-bold c-font-26 c-margin-b-20">Numero di Habitat filtrati: @{{ habitatDetails.length }}</h2>
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
                  <li class="c-last mimi-legenda-advanced" style="margin-right: 0">
            <h4 class="c-font-black">Trend</h4>
            <ul class="c-legenda">
              <li><img src="{!! asset('public/images/green_up.png') !!}" />In miglioramento</li>
              <li><img src="{!! asset('public/images/yellow_stable.png') !!}" />Stabile</li>
              <li><img src="{!! asset('public/images/red_down.png') !!}" />In peggioramento</li>
              <li><img src="{!! asset('public/images/grey_null.png') !!}" />Sconosciuto</li>
            </ul>                   
                  </li>
                </ul>
     
    </div>
	</div>
  	<div class="row">
  		<multi-habitat-info-cell :list="habitatDetails"></multi-habitat-info-cell>
  	</div>
  	<div class="row">
  	      <div class="col-md-4" v-if="dataAvailable">
  		<a href="#" class="btn btn-xlg c-btn-blue c-btn-square c-btn-border-2x" id="export-csv" v-on:click="getCsv">Esporta CSV</a>
  	      </div>
  	    </div>
  </div>
</div>

<template id="habitat-template">
    <ul class="list-group">      
        <li class="list-group-item" v-for="spec in list" v-on:click="notify(spec)" style="cursor: default;">
            @{{ hab.habitat_name }} 
        </li>
    </ul>
</template>

<template id="multi-habitat-info-cell-template">
    <table class="table table-hover table-fixed">
      <thead>
        <tr>
            <th rowspan="2" class="mimi-table-cell-font">Codice</th>
      			<th rowspan="2" class="mimi-table-cell-font">Nome Habitat</th>
      			<th colspan="4" class="mimi-table-cell-font">Stato di Conservazione</th>
          	<th colspan="4" class="mimi-table-cell-font">Trend</th>
          	<th rowspan="2" class="mimi-table-cell-font">Reg. Biog.</th>
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
        <tr v-for="hab in list">
          <td class="mimi-table-cell-font"><a v-bind:href=" '/habitat-basic-search/'+hab.habitat_code" target="_blank" >@{{ hab.habitat_code }}</a></td>
          <td class="mimi-table-cell-font">@{{ hab.habitat_name }}</td>
          <td><div v-bind:class="itemStatusStyle(hab, 'alp')"></div></td>
          <td><div v-bind:class="itemStatusStyle(hab, 'con')"></div></td>
          <td><div v-bind:class="itemStatusStyle(hab, 'med')"></div></td>
	  <td><div v-bind:class="itemStatusStyle(hab, 'mmed')"></div></td>
          <td><div><span><img v-bind:src="itemTrendStyle(hab, 'alp')" class="trend-image" /></span></div></td>
          <td><div><span><img v-bind:src="itemTrendStyle(hab, 'con')" class="trend-image" /></span></div></td>
          <td><div><span><img v-bind:src="itemTrendStyle(hab, 'med')" class="trend-image" /></span></div></td>
          <td><div><span><img v-bind:src="itemTrendStyle(hab, 'mmed')" class="trend-image" /></span></div></td>
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
   <script src="{!! asset('js/vendor/switchery.js') !!}"></script>
	 <script src="{!! asset('js/macrocategory_regbio_status_to_habitat.js') !!}"></script>
   <script src="{!! asset('js/macrocategory_main.js') !!}"></script>
   
@endsection
