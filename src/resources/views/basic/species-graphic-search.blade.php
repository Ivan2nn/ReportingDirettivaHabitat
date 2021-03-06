@extends('partials.layout')

@section('content')

<div class="c-content-box c-size-md c-bg-white">
    <div class="container">
		<div class="row">
			<div class="btn btn-primary" id="3_report">
				III Report
			</div>
			<div class="btn btn-primary" id="4_report">
				IV Report
			</div>
			<!-- <h1 style="padding: 20px 5px; background-color: #99ccff;">Al momento il sito riporta informazioni riferite a specie e habitat terrestri e di acqua dolce.<br>
			I dati relativi a specie e habitat marini sono in corso di inserimento</h1> -->
		</div>
		<div class="row">
			<div class="col-md-5">
				<div class="ibox float-e-margins">
		            <div class="ibox-title">
		            	<div class="row">
		            		<div class="col-sm-8">
		                		<h4 class="input-font-mimi-big">Ricerca per Nome</h4>
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
					            <div class="col-sm-8 has-success">
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
		        </div>
	            <div class="ibox float-e-margins i-box-mimi">
		            <div class="ibox-title">
		                <div class="row">
		            		<div class="col-sm-8">
		                		<h4 class="input-font-mimi-big">Ricerca per Codice</h4>
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
							<div class="col-sm-8 has-success">
								<input type="text"
								class="form-control input-lg input-font-mimi-normal"
				                v-model="queryCode"
				                v-on:keyup="searchCodes"
				                v-on:click="resetQueries"
						:disabled="loadingNames || loadingCodes"
				            	>
			            	</div>
			            	<div class="col-sm-4">
			            		<button type="submit" class="btn btn-primary btn-lg pull-right" v-show="searchingCodes" :disabled="loadingCodes"><strong>Cerca</strong></button>
			            	</div>
						</div>	
						</form>
						<div class="row" v-if="!isSearching">
							<div class="col-sm-8">
				 				<species-codes :list="searchedCodes"></species-codes>
				 			</div>
				 		</div>
		            </div>
		        </div>
				<div class="ibox float-e-margins i-box-mimi">
		            <div class="ibox-title">
		                <div class="row">
		            		<div class="col-sm-8">
		                		<h4 class="input-font-mimi-big">Ricerca mista</h4>
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
							<div class="col-sm-8 has-success">
								<input type="text"
								class="form-control input-lg input-font-mimi-normal"
				                v-model="queryNameCode"
				                v-on:keyup="searchNamesCodes"
				                v-on:click="resetQueries"
						:disabled="loadingNames || loadingCodes"
				            	>
			            	</div>
			            	<div class="col-sm-4">
			            		<button type="submit" class="btn btn-primary btn-lg pull-right" v-show="searchingCodes" :disabled="loadingCodes"><strong>Cerca</strong></button>
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
		            		<div class="col-xs-12">
		                		<h4 class="input-font-mimi-big">Mappa di Distribuzione Specie <span style="font-size: 14px;">    [disponibile solo per le specie terrestri e di acqua dolce]</span></h4>
							</div>
					
		                </div>
		            </div>
		            <div class="ibox-content">
	            		<div id="map" class="map-style"></div>
	            	</div>
	            </div>
			</div>
		</div>

            <div class="container c-bg-grey-1 animated bounceInRight" v-if="dataAvailable">
			<div class="row">
                <div class="col-md-6 c-margin-b-30 wow animate fadeInDown" style="opacity: 1; visibility: visible; animation-name: fadeInDown;">
                    <div class="col-sm-12">
            			<h2 class="c-font-uppercase c-font-bold c-font-26 c-margin-b-20">Scheda della Specie</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-9"> 
					<div class="row">
						<div class="col-md-5">
							<div class="c-content-v-center c-info-species-head-theme-bg">
	                            <div class="c-wrapper c-margin-bottom-10">
	                                <div class="c-body c-padding-8">
	                                    <h3 class="c-font-19 c-line-height-18 c-font-white c-font-italic">Nome: @{{ speciesDetails.species_name }}</h3>
	                                </div>
	                            </div>
	                        </div>
						</div>
						<div class="col-md-5">
							<div class="c-content-v-center c-info-species-head-theme-bg">
	                            <div class="c-wrapper c-margin-bottom-10">
	                                <div class="c-body c-padding-8">
	                                    <h3 class="c-font-19 c-line-height-18 c-font-white c-font-italic">Codice : @{{ speciesDetails.species_code }}</h3>
	                                </div>
	                            </div>
	                        </div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5">
							<table class="table mimi-table-striped">
	                            <thead>
	                                <tr>
	                                    <th class="c-font-17 c-font-bold">Tassonomia</th>
	                                    <th></th>	
	                                </tr>
	                            </thead>
	                            <tbody>
	                                <tr>
	                                    <td>Regno</td>
	                                    <td>@{{ speciesDetails.kingdom }}</td>
	                                </tr>
	                                <tr>
	                                    <td>Classe</td>
	                                    <td>@{{ speciesDetails.classis }}</td>
	                                </tr>
	                            </tbody>
	                        </table>
                        </div>
                        <div class="col-md-5">
							<table class="table mimi-table-striped">
	                            <tbody>
	                                <tr>
	                                    <td>Sp. Prioritaria</td>
	                                    <td><span v-if="speciesDetails.priority">SI</span>
											<span v-else>No</span>
										</td>
	                                </tr>
	                                <tr>
	                                    <td>Sp. Endemica</td>
	                                    <td><span v-if="speciesDetails.endemic">SI</span>
											<span v-else>No</span>
										</td>
	                                </tr>
	                                <tr>
	                                    <td>Allegati DH</td>
	                                    <td><span v-for="annex in speciesDetails.annexes">@{{ annex }} </span></td>
	                                </tr>
	                                <tr>
	                                    <td>Lista rossa IUCN (*)</td>
	                                    <td>@{{ speciesDetails.lri_specs }}</td>
	                                </tr>
	                            </tbody>
	                        </table>
                        </div>
					</div>
					<div class="row">
						<div class="col-md-10 c-margin-b-10">
							<h4>(*) Per maggiore dettaglio vedere scheda di monitoraggio</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-10">
							<table class="table mimi-table-striped mimi-table-red-heading">
	                            <thead>
	                                <tr>
	                                    <th class="c-font-bold">Regioni Biogeografiche</th>
	                                    <th class="c-font-bold">ALP</th>	
	                                    <th class="c-font-bold">CON</th>	
	                                    <th class="c-font-bold">MED</th>
					    <th class="c-font-bold">MMED</th>	
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
	                                    <td>Stato di Conservazione complessivo (2007- 2012)</td>
	                                    <td><div :class="itemStatusStyle(speciesDetails, 'alp')"></div></td>
	                                    <td><div :class="itemStatusStyle(speciesDetails, 'con')"></div></td>
	                                    <td><div :class="itemStatusStyle(speciesDetails, 'med')"></div></td>
					    <td><div :class="itemStatusStyle(speciesDetails, 'mmed')"></div></td>
	                                </tr>
	                                <tr>
	                                    <td>Trend (2007 - 2012)</td>
	                                    <td><div><span><img v-bind:src="itemTrendStyle(speciesDetails, 'alp')" class="trend-image" /></span></div></td>
	                                    <td><div><span><img v-bind:src="itemTrendStyle(speciesDetails, 'con')" class="trend-image" /></span></div></td>
	                                    <td><div><span><img v-bind:src="itemTrendStyle(speciesDetails, 'med')" class="trend-image" /></span></div></td>
					    <td><div><span><img v-bind:src="itemTrendStyle(speciesDetails, 'mmed')" class="trend-image" /></span></div></td>
	                                </tr>
	                            </tbody>
	                        </table>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-10">
							<div class="c-content-v-center c-info-species-head-theme-bg">
							    <div class="c-wrapper">
							        <div class="c-body c-padding-8">
							            <h3 class="c-font-19 c-line-height-18 c-font-white c-font-bold">Modifiche nomenclaturali e/o tassonomiche</h3>
							        </div>
							    </div>
							</div>
							<div class="c-content-v-center c-info-species-body-theme-bg">
							    <div class="c-wrapper c-margin-bottom-10">
							        <div class="c-body c-padding-8">
							            <h4 class="c-font-18 c-line-height-20 c-font-black c-font-thin">@{{{ speciesDetails.modified }}}</h4>
							        </div>
							    </div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="row">
						<div class="col-md-12">
							<div class="c-content-v-center c-info-species-head-theme-bg">
	                            <div class="c-wrapper c-margin-bottom-10">
	                                <div class="c-body c-padding-8">
	                                    <h3 class="c-font-19 c-line-height-18 c-font-white c-font-bold">Download Schede</h3>
	                                </div>
	                            </div>
	                        </div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<table class="table mimi-table-striped">
	                            <tbody>
	                                <tr>
	                                    <td>3?? Reporting</td>
	                                    <td><a v-bind:href="speciesDetails.document" target="_blank" class="btn btn-files-link">Visualizza</a>
										</td>
	                                </tr>
	                                <tr>
	                                    <td>Monitoraggio</td>
	                                    <td><a v-bind:href="speciesDetails.monitoring" target="_blank" class="btn btn-files-link">Visualizza</a>
										</td>
	                                </tr>
	                            </tbody>
	                        </table>
                        </div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<span class="c-font-30">Legenda</span>
						</div>
						<div class="col-md-12">
							<ul class="c-works">
                				<li class="c-first mimi-legenda">
									<h4 class="c-font-black">Regioni Biogeografiche</h4>
									<ul class="c-legenda">
										<li><span class="c-font-bold">MED</span> = Mediterranea</li>
										<li><span class="c-font-bold">CON</span> = Continentale</li>
										<li><span class="c-font-bold">ALP</span> = Alpina</li>
										<li><span class="c-font-bold">MMED</span> = Marina Mediterranea</li>
									</ul>										
                				</li>
                				
                				<li class="mimi-legenda">
									<h4 class="c-font-black">Presenza</h4>
									<ul class="c-legenda">
										<li><span class="c-font-bold">PRE</span> = Presente</li>
										<li><span class="c-font-bold">OCC</span> = Occasionale</li>
										<li><span class="c-font-bold">MAR</span> = Marginale</li>
										<li><span class="c-font-bold">TAX</span> = Tassonomia non definita</li>
										<li><span class="c-font-bold">EXa</span> = Estinta dopo l'entrata in vigore della DH</li>
										<li><span class="c-font-bold">EXp</span> = Estinta prima dell'entrata in vigore della DH</li>
										<li><span class="c-font-bold">NP</span> = Non Presente</li>
									</ul>																			
                				</li>
						<li class="mimi-legenda">
									<h4 class="c-font-black">Stato di Conservazione</h4>
									<ul class="c-legenda">
										<li><div class="mimi-legenda-block legenda-green"></div>Favorevole</li>
										<li><div class="mimi-legenda-block legenda-yellow"></div>Inadeguato</li>
										<li><div class="mimi-legenda-block legenda-red"></div>Cattivo</li>
										<li><div class="mimi-legenda-block legenda-grey"></div>Sconosciuto</li>
									</ul>																			
                				</li>
                				<li class="c-last mimi-legenda">
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
		        	<div class="col-md-4" v-if="dataAvailable">
		        		<a href="#" class="btn btn-xlg c-btn-blue c-btn-square c-btn-border-2x" id="export-csv" v-on:click="getCsv">Esporta CSV</a>
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
	</div>
</div>

@endsection

@section('added-scripts')
	<script src="{!! asset('js/csv_species_generator.js') !!}"></script>
	 <script src="{!! asset('js/speciesToCellMapping.js') !!}"></script>
     <script src="{!! asset('js/main.js') !!}?<?=time()?>"></script>
@endsection
