@extends('partials.layout')

@section('content')

<div class="c-content-box c-size-md c-bg-white">


	<div class="container">
		<div class="row">
			<!-- <h1 style="padding: 20px 5px; background-color: #99ccff;">Al momento il sito riporta informazioni riferite a specie e habitat terrestri e di acqua dolce.<br>
			I dati relativi a specie e habitat marini sono in corso di inserimento</h1> -->
		</div>

		<div class="row">
			<div class="c-margin-b-40" style="padding-left: 15px;">
				<h1 class="c-font-bold c-margin-b-40 c-margin-t-60 c-margin-l-20">Specie</h1>
				<p>Ricerca dati 4° report (2013-2018) per le specie animali e vegetali</p>
			</div>
		</div>
		
		<div class="col-md-5">
		{{-- <div class="ibox float-e-margins">

	        	<div class="ibox-title">
	            	<div class="row">
	            		<div class="col-sm-8">
	                		<h2 class="c-font-bold">Ricerca specie per nome o per codice</h2>
						</div>
						<div class="col-sm-4">
							<div class="loader" v-if="loadingNames"></div>
						</div>
	                </div>
	            </div>

	            <div class="ibox-content">
	                <form method="GET" action="/api/species/" v-ajax>
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
				            	<button type="submit" class="btn btn-primary btn-lg pull-right" v-show="searchingNames" :disabled="loadingNames"><strong>Search</strong></button>
				            </div>
		            	</div>
					</form>

					<div class="row" v-if="!isSearching">
						<div class="col-sm-8">
				 			<!-- <ul class="list-group">      
							    <li class="list-group-item" v-for="spec in searchedNames" v-on:click="notify(spec, 'names')" style="cursor: default;">
								@{{ spec.species_name }} 
							    </li>
							</ul> -->
							<species-names :list="searchedNames"></species-names>
				 		</div>
				 	</div>

	            </div>
	        </div> --}}

            {{-- <div class="ibox float-e-margins i-box-mimi">
	            <div class="ibox-title">
	                <div class="row">
	            		<div class="col-sm-8">
	                		<h2 class="c-font-bold">Ricerca specie per nome o per codice</h2>
						</div>
						<div class="col-sm-4">
							<div class="loader" v-if="loadingCodes"></div>
						</div>
	                </div>
	            </div>

	            <div class="ibox-content">
	                <form method="GET" action="/api/species/" v-ajax>
		            	{!! csrf_field() !!}
		            	<div class="row">
							<div class="col-sm-8">
								<input type="text"
								class="form-control input-lg input-font-mimi-normal"
			                	v-model="queryCode"
			                	v-on:keyup="searchCodes"
			                	v-on:click="resetQueries"
								:disabled="loadingNames || loadingCodes"
			            		>
		            		</div>
			            	<div class="col-sm-4">
			            		<button type="submit" class="button-link btn btn-primary btn-lg pull-left" v-show="searchingCodes" :disabled="loadingCodes">Cerca</button>
			            	</div>
						</div>	
					</form>

					<div class="row" v-if="!isSearching">
						<div class="col-sm-8">
			 				<species-codes :list="searchedCodes"></species-codes>
			 			</div>
			 		</div>
	           	</div>

	        </div> --}}

			<div class="ibox float-e-margins i-box-mimi">

	            <div class="ibox-title">
	            	<div class="row">
	            		<div class="col-sm-8">
	               			<h2 class="c-font-bold">Ricerca specie per nome o per codice</h2>
						</div>
						<div class="col-sm-4">
							<div class="loader" v-if="loadingNameCode"></div>
						</div>
	                </div>
	            </div>

	            <div class="ibox-content">
	                <form method="GET" action="/api/species/" v-ajax>
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
			 				<species-names-codes :list="searchedNamesCodes"></species-names-codes>
			 			</div>
			 		</div>
	            </div>
	        </div>

	        @if ($species)
            	<input type="hidden" v-model="outCode = '{!! $species->species_code !!}'">
            	<input type="hidden" v-model="outSpeciesName = '{!! $species->species_name !!}'">
            @endif
            
	    </div>

		<div class="col-md-7">
			<div class="ibox float-e-margins">
	            <div class="ibox-title">
	            	<div class="row">
	            		<div class="col-xs-12 c-margin-t-25">
	                		<h3 class="">Mappa di Distribuzione Specie</h3>
						</div>
	                </div>
	            </div>
	            <div class="ibox-content">
            		<div id="map" class="map-style"></div>
            	</div>
            </div>
		</div>

	</div> <!-- first container ends -->

	<div class="container" v-if="dataAvailable">
    	<div class="col-sm-8 download-schede">
           	<h2 class="c-font-bold c-margin-b-30">Download Schede</h2>
           	<a class="c-font-bold text-link" v-bind:href="speciesDetails.document" target="_blank" style="margin-right: 30px;">4° Reporting</a>
            <a class="c-font-bold text-link" v-bind:href="speciesDetails.monitoring" target="_blank" class="">Monitoraggio</a>
		</div>
	</div>

	<div class="bg-light-grey">
		<div class="container animated bounceInRight bg-light-grey" v-if="dataAvailable">
		
			<div class="row">
				<div class="clearfix c-margin-t-40 c-margin-b-30">
					<h2 class="c-font-bold pull-left" style="margin-left:30px;">Scheda: @{{ speciesDetails.species_name }} / @{{ speciesDetails.species_code }} </h2>
					<a href="#" class="button-link pull-right hidden-xs" id="export-csv" v-on:click="getCsv">Esporta CSV</a>
				</div>
				<div class="visible-xs">
					<a href="#" style="margin-left:15px;" class="button-link" id="export-csv" v-on:click="getCsv">Esporta CSV</a>
				</div>

				<div style="overflow-x:auto;">
					<table class="table table-striped c-margin-b-50"> 
						<thead> 
							<tr> 
								<th>Codice</th> 
								<th>Regno</th> 
								<th>Classe</th> 
								<th>Sp. Prioritaria</th> 
								<th>Sp. Endemica</th> 
								<th>Allegati DH</th> 
								<th>Lista rossa IUCN (*)</th> 
							</tr> 
						</thead> 
						<tbody> 
							<tr> 
								<th style="font-weight: normal;">@{{ speciesDetails.species_code }}</th> 
								<td>@{{ speciesDetails.kingdom }}</td> 
								<td>@{{ speciesDetails.classis }}</td> 
								<td>
									<span v-if="speciesDetails.priority">SI</span>
									<span v-else>No</span>
								</td> 
								<td>
									<span v-if="speciesDetails.endemic">SI</span>
									<span v-else>No</span>
								</td> 
								<td>
									<span v-for="annex in speciesDetails.annexes">@{{ annex }} </span>
								</td> 
								<td>
									@{{ speciesDetails.lri_specs }}
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
                            <td>@{{ speciesDetails.species_presence_alp }}</td>
                            <td>@{{ speciesDetails.species_presence_con }}</td>
                            <td>@{{ speciesDetails.species_presence_med }}</td>
		    				<td>@{{ speciesDetails.species_presence_mmed }}</td>
	                    </tr>
	                    <tr>
                            <td>Stato di Conservazione complessivo (2013- 2018)</td>
                            <td>
                            	<div :class="itemStatusStyle(speciesDetails, 'alp')"></div>
                            </td>
                            <td>
                            	<div :class="itemStatusStyle(speciesDetails, 'con')"></div>
                            </td>
                            <td>
                            	<div :class="itemStatusStyle(speciesDetails, 'med')"></div>
                            </td>
		    				<td>
		    					<div :class="itemStatusStyle(speciesDetails, 'mmed')"></div>
		    				</td>
	                    </tr>
	                    <tr>
	                        <td>Trend (20013 - 2018)</td>
	                        <td>
	                        	<div>
	                        		<span>
	                        			<img v-bind:src="itemTrendStyle(speciesDetails, 'alp')" class="trend-image" />
	                        		</span>
	                        	</div>
	                        </td>
	                        <td>
	                        	<div>
	                        		<span>
	                        			<img v-bind:src="itemTrendStyle(speciesDetails, 'con')" class="trend-image" />
	                        		</span>
	                        	</div>
	                        </td>
	                        <td>
	                        	<div>
	                        		<span>
	                        			<img v-bind:src="itemTrendStyle(speciesDetails, 'med')" class="trend-image" />
	                        		</span>
	                        	</div>
	                        </td>
					    	<td>
					    		<div>
					    			<span>
					    				<img v-bind:src="itemTrendStyle(speciesDetails, 'mmed')" class="trend-image" />
					    			</span>
					    		</div>
					    	</td>
	                    </tr>
                	</tbody>    
				</table>

				<table class="table table-striped c-margin-b-50"> 
					<thead> 
						<tr> 
							<th>Modifiche nomenclaturali e/o tassonomiche</th>  
						</tr> 
					</thead> 
					<tbody> 
						<tr> 
							<th style="font-weight: normal;">@{{{ speciesDetails.modified }}}</th>
						</tr> 
					</tbody>
				</table>
			</div>

			<div class="row">
				<div class="c-margin-b-30">
					<h2 class="c-font-bold">Legenda</h2>
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
		</div>

	</div>
		

	<template id="species-names-template">
		<ul class="list-group">      
		    <li class="list-group-item" v-for="spec in list" v-on:click="notify(spec, 'names')" style="cursor: default;">
		        @{{ spec.species_name }} 
		    </li>
		</ul>
	</template>

    <template id="species-codes-template">
        <ul class="list-group">      
            <li class="list-group-item" v-for="spec in list" v-on:click="notify(spec, 'codes')" style="cursor: default;">
                @{{ spec.species_code }} 
            </li>
        </ul>
    </template>

	<template id="species-names-codes-template">
        <ul class="list-group">      
            <li class="list-group-item" id="hash" v-for="spec in list" v-on:click="notify(spec, 'namescodes')" style="cursor: default;">
                <span>@{{ spec.species_name }}</span>
				<span>:@{{ spec.species_code }}</span> 
            </li>
        </ul>
    </template>

</div><!-- page container ends -->

@endsection

@section('added-scripts')
	<script src="{!! asset('js/csv_species_generator.js') !!}"></script>
	 <script src="{!! asset('js/speciesToCellMapping.js') !!}"></script>
     <script src="{!! asset('js/species_base_search_III_report.js') !!}?<?=time()?>"></script>
@endsection
