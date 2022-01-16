@extends('partials.layout')

@section('content')
<div class="c-content-box c-size-md c-bg-white">
   
    <div class="container">
        <div class="row">
            <!-- <h1 style="padding: 20px 5px; background-color: #99ccff;">Al momento il sito riporta informazioni riferite a specie e habitat terrestri e di acqua dolce.<br>
            I dati relativi a specie e habitat marini sono in corso di inserimento</h1> -->
        </div>

    
        <div class="row c-margin-b-40">
            <div class="col-md-5">
                <h1 class="c-font-bold c-margin-b-40 c-margin-t-60 c-margin-l-20">Habitat</h1>
                <p>Ricerca dati 4° report (2013-2018) per gli habitat</p>
            </div>
        </div>


        <div class="row">
            <div class="col-md-5">
           {{-- <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <div class="row">
                            <div class="col-sm-8">
                                <h2 class="c-font-bold">Ricerca habitat per nome</h2>
                            </div>
                            <div class="col-sm-4">
                                <div class="loader" v-if="loadingNames"></div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="GET" action="/api/habitat/" v-ajax>
                                {!! csrf_field() !!}
                            <div class="row">   
                                <div class="col-sm-8">
                                    <input type="text"
                                    class="form-control input-lg input-font-mimi-normal"
                                    v-model="queryName"
                                    v-on:keyup="searchNames"
                                    v-on:click="resetQueries"
                            :disabled="loadingNames || loadingCodes"
                                    >
                                </div>
                                <div class="col-sm-4">
                                    <button type="submit" class="button-link btn btn-primary btn-lg pull-left" v-show="searchingNames" :disabled="loadingNames">Cerca</button>
                                </div>
                            </div>
                        </form>
                        <div class="row" v-if="!isSearching">
                            <div class="col-sm-8">
                                <habitat-names :list="searchedNames"></habitat-names>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ibox float-e-margins i-box-mimi">
                    <div class="ibox-title">
                        <div class="row">
                            <div class="col-sm-8">
                                <h2 class="c-font-bold">Ricerca habitat per codice</h2>
                            </div>
                            <div class="col-sm-4">
                                <div class="loader" v-if="loadingCodes"></div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="GET" action="/api/habitat/" v-ajax>
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-sm-8">
                                    <input type="text"
                                    class="form-control input-lg input-font-mimi-normal"
                                    v-model="queryCode"
                                    v-on:keyup="searchCodes"
                                    v-on:click="resetQueries"
                                    :disabled="loadingCodes || loadingNames"
                                    >
                                </div>
                                <div class="col-sm-4">
                                    <button type="submit" class="button-link btn btn-primary btn-lg pull-right" v-show="searchingCodes" :disabled="loadingCodes">Cerca</button>
                                </div>
                            </div>  
                        </form>
                        <div class="row" v-if="!isSearching">
                            <div class="col-sm-8">
                                <habitat-codes :list="searchedCodes"></habitat-codes>
                            </div>
                        </div>
                    </div>

                </div> --}}

                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <div class="row">
                            <div class="col-sm-8">
                                <h2 class="c-font-bold">Ricerca habitat per nome o per codice</h2>
                            </div>
                            <div class="col-sm-4">
                                <div class="loader" v-if="loadingNameCode"></div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="GET" action="/api/habitat/" v-ajax>
                            {!! csrf_field() !!}
                            <div class="row">   
                                <div class="col-sm-8">
                                    <input type="text"
                                    class="form-control input-lg input-font-mimi-normal"
                                    v-model="queryNameCode"
                                    v-on:keyup="searchNamesCodes"
                                    v-on:click="resetQueries"
                            :disabled="loadingNames || loadingCodes"
                                    >
                                </div>
                                <div class="col-sm-4">
                                    <button type="submit" class="button-link btn btn-primary btn-lg pull-left" v-show="searchingNameCode" :disabled="loadingNameCode">Cerca</button>
                                </div>
                            </div>
                        </form>

                        <div class="row" v-if="!isSearching">
                            <div class="col-sm-8">
                                <habitat-names-codes :list="searchedNamesCodes"></habitat-names-codes>
                            </div>
                        </div>

                    </div>

                </div>

                @if ($habitat)
                    <input type="hidden" v-model="outCode = '{!! $habitat->habitat_code !!}'">
                    <input type="hidden" v-model="outHabitatName = '{!! $habitat->habitat_name !!}'">
                @endif

                <a href="#results" v-if="dataAvailable" class="text-link">Vai ai risultati</a>

            </div>

            <div class="col-md-7">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <div class="row">
                            <div class="col-sm-12 c-margin-t-5">
                                <h3 class="">Mappa di Distribuzione dell`Habitat</h3>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div id="habitat-map" class="map-style"></div>
                    </div>
                </div>
            </div>

        </div>

    </div> <!-- 1. container ends -->

    <div class="bg-light-grey" id="results">
    <div class="container" v-if="dataAvailable">
        <div class="download-schede">
            <h2 class="c-font-bold c-margin-b-30">Download Schede</h2>
            <a class="c-font-bold text-link" v-bind:href="habitatDetails.document" target="_blank" style="margin-right: 30px;">4° Reporting</a>
            <a class="c-font-bold text-link" v-bind:href="habitatDetails.monitoring" target="_blank" class="">Monitoraggio</a>
        </div>
    </div>


    <div class="container" v-if="dataAvailable"> <!-- data container starts -->

        <!-- New Data Table -->
    
        <div class="row c-margin-t-40 c-margin-b-30">
            <div class="col-md-8">
                <h2 class="c-font-bold">Scheda: @{{ habitatDetails.habitat_name }}</h2>
            </div>
            <div class="col-md-4">
                <a href="#" class="button-link c-margin-t-10 hidden-xs pull-right" id="export-csv" v-on:click="getCsv">Esporta CSV</a>
            </div>
        </div>

        <div class="visible-xs c-margin-b-40">
            <a href="#" class="button-link" id="export-csv" v-on:click="getCsv">Esporta CSV</a>
        </div>

        <div style="overflow-x:auto;">
            <table class="table table-striped c-margin-b-50"> 
                <thead> 
                    <tr> 
                        <th>Codice</th> 
                        <th>Macrocategorie</th> 
                        <th>Hb. Prioritario</th>  
                    </tr> 
                </thead> 
                <tbody> 
                    <tr> 
                        <th style="font-weight: normal;">@{{ habitatDetails.habitat_code }}</th>
                        <td>@{{ habitatDetails.macrocategory }}</td>  
                        <td>
                            <span v-if="habitatDetails.habitat_priority">SI</span>
                            <span v-else>No</span>
                        </td> 
                    </tr> 
                </tbody>
            </table>
        </div>

        <table class="table table-striped c-margin-b-50"> 
            <thead class="bg-light-mint" style="background-color: #C8EDE2;"> 
                <tr> 
                    <th>Regioni Biogeografiche</th> 
                    <th>ALP</th> 
                    <th>CON</th> 
                    <th>MED</th> 
                    <th>MMED</th>   
                </tr> 
            </thead> 
            <tbody> 
                <tr> 
                    <td>Presenza</td>
                    <td>@{{ habitatDetails.habitat_presence_alp }}</td>
                    <td>@{{ habitatDetails.habitat_presence_con }}</td>
                    <td>@{{ habitatDetails.habitat_presence_med }}</td>
                    <td>@{{ habitatDetails.habitat_presence_mmed }}</td>
                </tr> 
                <tr>
                    <td>Stato di Conservazione complessivo (2013- 2018)</td>
                    <td><div :class="itemStatusStyle(habitatDetails, 'alp')"></div></td>
                    <td><div :class="itemStatusStyle(habitatDetails, 'con')"></div></td>
                    <td><div :class="itemStatusStyle(habitatDetails, 'med')"></div></td>
                    <td><div :class="itemStatusStyle(habitatDetails, 'mmed')"></div></td>
                </tr>
                <tr>
                    <td>Trends (2013 - 2018)</td>
                    <td>
                        <div>
                            <span>
                                <img v-bind:src="itemTrendStyle(habitatDetails, 'alp')" class="trend-image" />
                            </span>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span>
                                <img v-bind:src="itemTrendStyle(habitatDetails, 'con')" class="trend-image" />
                            </span>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span>
                                <img v-bind:src="itemTrendStyle(habitatDetails, 'med')" class="trend-image" />
                            </span>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span>
                                <img v-bind:src="itemTrendStyle(habitatDetails, 'mmed')" class="trend-image" />
                            </span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table table-striped c-margin-b-50"> 
            <thead> 
                <tr> 
                    <th>Modifiche nomenclaturali</th>  
                </tr> 
            </thead> 
            <tbody> 
                <tr> 
                    <th style="font-weight: normal;">@{{{ habitatDetails.modified }}}</th>
                </tr> 
            </tbody>
        </table>

        @include('partials.legenda')

    </div></div><!-- New Data Table container ends -->
        

    
        <template id="habitat-names-template">
            <ul class="list-group">      
            <li class="list-group-item" v-for="habitat in list" v-on:click="notify(habitat, 'names')" style="cursor: default;">
                @{{ habitat.habitat_name }} 
            </li>
            </ul>
        </template>

        <template id="habitat-codes-template">
            <ul class="list-group">      
            <li class="list-group-item" v-for="habitat in list" v-on:click="notify(habitat, 'codes')" style="cursor: default;">
                @{{ habitat.habitat_code }} 
            </li>
            </ul>
        </template>

        <template id="habitat-names-codes-template">
            <ul class="list-group">      
                <li class="list-group-item" id="hash" v-for="habitat in list" v-on:click="notify(habitat, 'namescodes')" style="cursor: default;">
                    <span>@{{ habitat.habitat_name }}</span>
                    <span>:@{{ habitat.habitat_code }}</span> 
                </li>
            </ul>
        </template>
</div>

@endsection

@section('added-scripts')
    <script src="{!! asset('js/csv_habitat_generator.js') !!}"></script>
     <script src="{!! asset('js/habitatToCellMapping.js') !!}"></script>
     <script src="{!! asset('js/habitat_base_search_IV_report.js') !!}"></script>
@endsection
