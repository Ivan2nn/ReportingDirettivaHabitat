@extends('partials.layout')

@section('content')

<div class="c-content-box c-size-md c-bg-white">
  <div class="container">

    <div class="row" style="padding-left: 15px;">

      <div class="row c-margin-b-40">
        <div class="col-md-5">
          <h1 class="c-font-bold c-margin-b-40 c-margin-t-60 c-margin-l-20">Habitat</h1>
          <p>Ricerca dati 3° report (2007-2012) per gli habitat</p>
        </div>
      </div>


      <div class="col-md-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
              <div class="row">
                  <h2 class="c-font-bold">Ricerca Avanzata</h2>
              </div>
              <div class="col-sm-4">
                <div class="loader" v-if="loadingAdvancedData"></div>
              </div>
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
                    
                    <button type="submit" class="button-link btn btn-primary" v-show="true" :disabled="loadingAdvanceData">Cerca</button>         
                  </div>  
                </div>
              </div>
        </form>

      </div><!-- end of ibox -->
    </div> <!-- end of row -->
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
          <h2 class="c-font-bold c-margin-b-20">Numero di habitat filtrati: @{{ habitatDetails.length }}</h2>
        </div>
      </div>
      <div class="col-md-6">
        <a href="#" class="button-link pull-right hidden-xs" id="export-csv" v-on:click="getCsv">Esporta CSV</a>
        <a href="#" class="button-link pull-left visible-xs c-margin-b-40" id="export-csv" v-on:click="getCsv">Esporta CSV</a>
      </div>
    </div>







    <div class="row">
      <div class="col-xs-12" style="overflow-x:auto;">
        <multi-habitat-info-cell :list="habitatDetails"></multi-habitat-info-cell>
      </div>
    </div>

    
  </div> <!-- end of 2. container -->
</div>

</div> <!-- end of c-content-box -->






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
	        <td>
            <span><img v-bind:src="itemTrendStyle(hab, 'mmed')" class="trend-image" /></span>
            <div class="pull-left" style="margin-right: 5px;" v-bind:class="itemStatusStyle(hab, 'mmed')"></div>
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
   <script src="{!! asset('js/vendor/switchery.js') !!}"></script>
	 <script src="{!! asset('js/macrocategory_regbio_status_to_habitat_III_report.js') !!}"></script>
   <script src="{!! asset('js/macrocategory_main.js') !!}"></script>
   
@endsection
