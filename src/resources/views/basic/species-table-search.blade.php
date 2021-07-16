@extends('partials.layout')

@section('content')

   	<div class="row">
	    <div class="col-lg-12">
	        <div class="text-center">
	            <h1>
	                Search By Species
	            </h1>
	            <small>
	                From here the user will be able to perform a real-time search for the species; the map will show in which cells the selected species is present
	            </small>
	        </div>
	    </div>
	</div>
	<div class="p-w-md m-t-sm">
		<div class="row">
			<div class="col-sm-4">
			<form methd="GET" action="api/species/" v-ajax>
                {!! csrf_field() !!}
				<div class="input-group">
					<input type="text"
					class="form-control"
                    v-model="query"
                    v-on:keyup="search"
                    v-on:click="query = ''"
                	>
                	<i v-show="loading" class="fa fa-spinner fa-spin"></i>
                	<span class="input-group-btn">
                	<button type="submit" class="btn btn-primary" v-show="searched[0].species_name == query"><strong>Search</strong></button>
                	</span>
				</div>	
			</form>
			<species :list="searched"></species>
			</div>
			<div class="col-sm-8">
                <div id="map" style="width: 640px; height: 650px;"></div>
			</div>
		</div>
	</div>

	<div class="row">
		<info-cell :list="speciesDetails"></info-cell>
	</div>

	<template id="species-template">
        <ul class="list-group">      
            <li class="list-group-item" v-for="spec in list" v-on:click="notify(spec)" style="cursor: default;">
                @{{ spec.species_name }} 
            </li>
        </ul>
    </template>

    <template id="info-cell-template">
        <table class="table table-hover">
          <thead>
            <tr>
        				<th>Scientific Name</th>
        				<th>Status</th>
              	<th>Trend</th>
              	<th>Biogeographic Region</th>
              	<th>Family</th>
              	<th>Kingdom</th>
              	<th>Order</th>
              	<th>Phylum</th>
              	<th>Class</th>
              	<th>Genus</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>What</td>
              <td>Status</td>
              <td>Trend</td>
              <td>@{{ list.bioregions }}</td>
              <td>@{{ list.family }}</td>
              <td>@{{ list.kingdom }}</td>
              <td>@{{ list.order }}</td>
              <td>@{{ list.phylum }}</td>
              <td>@{{ list.classis }}</td>
              <td>@{{ list.genus }}</td>
            </tr>
          </tbody>
        </table>
    </template>

@endsection

@section('added-scripts')
	 <script src="{!! asset('js/speciesToCellMapping.js') !!}"></script>
     <script src="{!! asset('js/main.js') !!}"></script>
@endsection
