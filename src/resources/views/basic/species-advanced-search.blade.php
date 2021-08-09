@extends('partials.layout')

@section('content')

  <div class="c-content-box c-size-md c-bg-white">

    <div class="container">

      <div class="row">
        <div class="c-margin-b-40" style="padding-left: 15px;">
          <h1 class="c-font-bold c-margin-b-40 c-margin-t-60 c-margin-l-20">Specie</h1>
          <p>Ricerca dati 4° report (2013-2018) per le specie animali e vegetali</p>
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

<!-- here -->


</div> <!-- end of 1. container -->


<div class="bg-light-grey">
  <div class="container">
    

    <div class="row c-margin-t-40" v-if="dataAvailable">
      <div class="col-md-6 c-margin-b-30">
        <div class="col-sm-12">
          <h2 class="c-font-bold c-margin-b-20">Numero di Specie filtrate: @{{ speciesDetails.length }}</h2>
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
  

    <template id="multi-species-info-cell-template">
    <table class="table table-hover table-fixed">
      <thead>
        <tr>
            <th rowspan="2" class="mimi-table-cell-font">Codice</th>
            <th rowspan="2" class="mimi-table-cell-font">Nome Specie</th>
            <th colspan="4" class="mimi-table-cell-font" style="border-bottom: 2px solid #00B783!important;">Stato di Conservazione / Trend</th>
            <!--<th colspan="4" class="mimi-table-cell-font">Trend</th>-->
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
          <td class="mimi-table-cell-font">
            <a v-bind:href=" '/species-basic-search/'+spec.species_code" target="_blank" >@{{ spec.species_code }}</a>
          </td>
          <td class="mimi-table-cell-font">@{{ spec.species_name }}</td>
          <td>
             <span>
                <img v-bind:src="itemTrendStyle(spec, 'alp')" class="trend-image" />
              </span>
            <div class="pull-left" style="margin-right: 5px;" v-bind:class="itemStatusStyle(spec, 'alp')"></div>
          </td>
          <td>
            <span>
                <img v-bind:src="itemTrendStyle(spec, 'con')" class="trend-image" />
            </span>
            <div class="pull-left" style="margin-right: 5px;" v-bind:class="itemStatusStyle(spec, 'con')"></div>
          </td>
          <td>
            <span>
              <img v-bind:src="itemTrendStyle(spec, 'med')" class="trend-image" />
            </span>
            <div class="pull-left" style="margin-right: 5px;" v-bind:class="itemStatusStyle(spec, 'med')"></div>
          </td>
          <td>
            <span>
              <img v-bind:src="itemTrendStyle(spec, 'mmed')" class="trend-image" />
            </span>
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

  @include('partials.legenda')

  </div> <!-- 2. container ends -->
</div>




</div>

@endsection

@section('added-scripts')
	<script src="{!! asset('js/csv_species_generator.js') !!}"></script>
   <script src="{!! asset('js/vendor/switchery.js') !!}"></script>
	 <script src="{!! asset('js/taxonomy_regbio_status_to_species_IV_report.js') !!}"></script>
   <script src="{!! asset('js/taxonomy_main.js') !!}"></script>
   
@endsection

