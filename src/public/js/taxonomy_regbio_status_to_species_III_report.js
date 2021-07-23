Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('input[name="_token"]').value;

Vue.directive('ajax', {
	
	bind: function() {
		this.el.addEventListener('submit', this.onSubmit.bind(this));
	},

	update: function() {

	},

	onSubmit: function(e) {
		e.preventDefault();


		this.vm.loading = true;
		this.vm.loadingAdvancedData = true;

		if (e.explicitOriginalTarget.id == 'taxonomy_submit')
		{
			
			var checked_ids = []; 
			checked_ids = $("#Animalia_jstree").jstree("get_selected",true);
			
			var checked_leaves = checked_ids.filter(function(elm) {
				if (elm.children.length == 0)
					return elm;		
				}).map(function(elm, index) {
					return elm.li_attr['code'];
				});
				console.log(this.el.action + '.... ')
			this.vm.$http.get(this.el.action, {params: { codes: checked_leaves } }).then((response) => {
				// Inside the response data there are also the taxonomy data, but the google map API cna distinguish by itself
				this.vm.speciesDetails = JSON.parse(response.data);
				this.vm.loading = false;
				this.vm.loadingAdvancedData = false;
			}, (response) => {

			});
		}

		if (e.explicitOriginalTarget.id == 'regbio_submit')
		{
			var switchery_alp = document.querySelector('.js-switch-alp');
			var switchery_con = document.querySelector('.js-switch-con');
			var switchery_med = document.querySelector('.js-switch-med');

			var regbio_checks = {"ALP" : switchery_alp.checked, "CON" : switchery_con.checked, "MED" : switchery_med.checked};
			
			this.vm.$http.get(this.el.action, {params: { regbio_checks: regbio_checks } }).then((response) => {
				// Inside the response data there are also the taxonomy data, but the google map API cna distinguish by itself
				//console.log(JSON.parse(response.data));
				this.vm.speciesDetails = JSON.parse(response.data);
				this.vm.loading = false;
				this.vm.loadingAdvancedData = false;
			}, (response) => {

			});
		}

		if (e.explicitOriginalTarget.id == 'status_conserve_submit')
		{
			var switchery_status_fv = document.querySelector('.js-switch-status-fv');
			var switchery_status_u1 = document.querySelector('.js-switch-status-u1');
			var switchery_status_u2 = document.querySelector('.js-switch-status-u2');
			var switchery_status_xx = document.querySelector('.js-switch-status-xx');

			var status_checks = {"FV" : switchery_status_fv.checked, "U1" : switchery_status_u1.checked, "U2" : switchery_status_u2.checked, "XX" : switchery_status_xx.checked};
			
			this.vm.$http.get(this.el.action, {params: { status_checks: status_checks } }).then((response) => {
				// Inside the response data there are also the taxonomy data, but the google map API cna distinguish by itself
				//console.log(JSON.parse(response.data));
				this.vm.speciesDetails = JSON.parse(response.data);
				this.vm.loading = false;
				this.vm.loadingAdvancedData = false;
			}, (response) => {

			});
		}
	}
});

Vue.component('species', {
	template: '#species-template',

	props: ['list'],

	data: function() {
		return {
			list: []
		};
	},

	methods: {
		notify: function (spec) {
			this.$dispatch('child-obj', spec);
      	}
	}
});

Vue.component('multi-species-info-cell', {
	template: '#multi-species-info-cell-template',

	props: ['list'],

	data: function() {
		return {
			list: []
		};
	},

	methods: {
		notify: function (spec) {
			this.$dispatch('child-obj', spec);
      	},

      	itemStatusStyle: function(item, bioreg) {
      		
      		temp = 'item.species_conservation_' + bioreg;
      		
      		if (eval(temp) == 'U2') {
      			return 'red-rectangle';
      		};

      		if (eval(temp) == 'U1') {
      			return 'yellow-rectangle';
      		};

      		if (eval(temp) == 'FV') {
      			return 'green-rectangle';
      		};

      		if (eval(temp) == 'XX') {
      			return 'grey-rectangle';
      		};

      		/*if (eval(temp) == '') {
      			return 'fa arrow-big fa-minus';
      		};*/

      	},

      	itemTrendStyle: function(item, bioreg) {
      		
      		var temp = 'item.species_trend_' + bioreg;
      		
      		if (eval(temp) == '-') {
      			return "images/red_down.png";
      		};

      		if (eval(temp) == '=') {
      			return "images/yellow_stable.png";
      		};

      		if (eval(temp) == '+') {
      			return "images/green_up.png";
      		};

      		if (eval(temp) == 'x') {
      			return "images/grey_null.png";
      		};

      		/*if (eval(temp) == '') {
      			return "../public/images/grey_null.png";
      		};*/

      	}
	}
});

new Vue({
	el: 'body',

	data: {
		report_number: 'III',

		// Taxonomy packet
		taxonomies: [],
		kingdoms: [],
		phyla: [],
		classes: [],
		orders: [],
		families: [],
		genera: [],

		selectedKingdom: '',
		selectedPhylum: '',
		selectedClassis: '',
		selectedOrder: '',
		selectedFamily: '',
		selectedGenus: '',
		loading: false,
		loadingAdvancedData: false,
		dataAvailable: false,

		///////////////////////////////////////////

		speciesDetails: [],
		selectedOne: '',

		columns: [
			{
				name: 'species_code',
				title: 'Species Code'
			},
			{
				name: 'species_name',
				title: 'Species Name'
			},
			{
				name: 'kingdom_name',
				title: 'Kingdom'
			},
			{
				name: 'phylum_name',
				title: 'Phylum'
			},
			{
				name: 'classis_name',
				title: 'Class'
			},
			{
				name: 'order_name',
				title: 'Order'
			},
			{
				name: 'family_name',
				title: 'Family'
			},
			{
				name: 'genus_name',
				title: 'Genus'
			},          
        ]
	},

	ready: function() {
		vm = this;
		this.$http.get('/api/taxonomy').then((response) => {
			vm.kingdoms = response.data['kingdoms'];
			vm.phyla = response.data['phyla'];
			vm.classes = response.data['classes'];
			vm.orders = response.data['orders'];
			vm.families = response.data['families'];
			vm.genera = response.data['genera'];

		}, (response) => {
			alert('No data avilable');
		});
	},

	computed: {
		searched: function() {
			vm = this;
			searchedValues = [];
			if (this.query) {
				searchedValues = this.species.filter(this.filterQuery(this.query));
			}

			return searchedValues;
		},

		// We create a computed property to check if at least one of the multiple options has been chosen (otherwise they just could see all the species)
		searchActivated: function() {
			vm = this;
			return (vm.selectedKingdom != '' || vm.selectedPhylum != '' 
				|| vm.selectedClassis != '' || vm.selectedOrder != '' || vm.selectedFamily != '' 
				|| vm.selectedGenus != '');
		},

		// We will use a computed property where we will keep all the specific parameters that we have to use for the research of the species
		// It will be an array consumed by the api/taxonomy
		/*taxonomyParameters: function() {
			vm = this;
			taxParameters = [];
			if (vm.searchActivated) {
				taxParameters['selectedKingdom'] = vm.selectedKingdom; 
				taxParameters['selectedPhylum'] = vm.selectedPhylum;
				taxParameters['selectedClassis'] = vm.selectedClassis;
				taxParameters['selectedOrder'] = vm.selectedOrder;
				taxParameters['selectedFamily'] = vm.selectedFamily;
				taxParameters['selectedGenus'] = vm.selectedGenus;
			}	
			return taxParameters;
		}*/
	},

	methods: {

		searchSpeciesFromSelections: function() {
			var checked_ids = []; 
			checked_ids = $("#Animalia_jstree").jstree("get_selected",true);
			check_ids_plantae = $("#Plantae_jstree").jstree("get_selected",true);
			Array.prototype.push.apply(checked_ids,check_ids_plantae); 
			
			var checked_leaves = checked_ids.filter(function(elm) {
			if (elm.children.length == 0)
				return elm;		
			}).map(function(elm, index) {
				return elm.li_attr['code'];
			});

			var switchery_alp = document.querySelector('.js-switch-alp');
			var switchery_con = document.querySelector('.js-switch-con');
			var switchery_med = document.querySelector('.js-switch-med');
			var switchery_mmed = document.querySelector('.js-switch-mmed');
			//var switchery_nd = document.querySelector('.js-switch-nd');

			var regbio_checks = {"ALP" : switchery_alp.checked, "CON" : switchery_con.checked, "MED" : switchery_med.checked, "MMED" : switchery_mmed.checked, "ND" : false};

			var radio_buttons_biogeoreg_value = '';
			var radioButtonsBiogeoreg = document.getElementsByName('radios_biogr');
		    for (var i = 0; i < radioButtonsBiogeoreg.length; i++) {
		        if (radioButtonsBiogeoreg[i].checked)  radio_buttons_biogeoreg_value = radioButtonsBiogeoreg[i].value;
		    }

			/* JUST the OR */
			radio_buttons_biogeoreg_value = 'OR'

		    /*var radio_buttons_conservation_value = '';
			var radioButtonsConservation = document.getElementsByName('radios_cons');
		    for (var i = 0; i < radioButtonsConservation.length; i++) {
		        if (radioButtonsConservation[i].checked)  radio_buttons_conservation_value = radioButtonsConservation[i].value;
		    }*/

			var switchery_status_fv = document.querySelector('.js-switch-status-fv');
			var switchery_status_u1 = document.querySelector('.js-switch-status-u1');
			var switchery_status_u2 = document.querySelector('.js-switch-status-u2');
			var switchery_status_xx = document.querySelector('.js-switch-status-xx');

			var status_checks = {"FV" : switchery_status_fv.checked, "U1" : switchery_status_u1.checked, "U2" : switchery_status_u2.checked, "XX" : switchery_status_xx.checked};

			this.dataAvailable = false;

			this.$http.get('/advancedselectiontospecies', {params: { report: vm.report_number, codes: checked_leaves, status_checks: status_checks, radio_buttons_biogeoreg_value: radio_buttons_biogeoreg_value, regbio_checks: regbio_checks } }).then((response) => {
				// Inside the response data there are also the taxonomy data, but the google map API cna distinguish by itself
				console.log(response.data);
				this.speciesDetails = JSON.parse(response.data);
				this.loading = false;
				this.dataAvailable = true;
			}, (response) => {

			});

		},

		searchSpeciesFromTaxonomy: function() {
			
			var checked_ids = []; 
			checked_ids = $("#Animalia_jstree").jstree("get_selected",true);
			
			var checked_leaves = checked_ids.filter(function(elm) {
				if (elm.children.length == 0)
					return elm;		
				}).map(function(elm, index) {
					return elm.li_attr['code'];
				});

			this.loadingAdvancedData = true;	
			this.dataAvailable = false;		

			this.$http.get('/taxonomytospecies', {params: { codes: checked_leaves } }).then((response) => {
				// Inside the response data there are also the taxonomy data, but the google map API cna distinguish by itself
				this.speciesDetails = JSON.parse(response.data);
				this.loading = false;
				this.loadingAdvancedData = false;
				this.dataAvailable = true;
			}, (response) => {

			});
		},

		searchSpeciesFromBioreg: function() {
			var switchery_alp = document.querySelector('.js-switch-alp');
			var switchery_con = document.querySelector('.js-switch-con');
			var switchery_med = document.querySelector('.js-switch-med');

			var regbio_checks = {"ALP" : switchery_alp.checked, "CON" : switchery_con.checked, "MED" : switchery_med.checked};
			
			this.loadingAdvancedData = true;
			this.dataAvailable = false;

			this.$http.get('/biogeographicregtospecies', {params: { regbio_checks: regbio_checks } }).then((response) => {
				// Inside the response data there are also the taxonomy data, but the google map API cna distinguish by itself
				//console.log(JSON.parse(response.data));
				this.speciesDetails = (JSON.parse(response.data)).filter(function(spec){
					return spec != null;
				});
				this.loading = false;
				this.loadingAdvancedData = false;
				this.dataAvailable = true;
			}, (response) => {

			});
		},

		searchSpeciesFromConservationStatus: function() {
			var switchery_status_fv = document.querySelector('.js-switch-status-fv');
			var switchery_status_u1 = document.querySelector('.js-switch-status-u1');
			var switchery_status_u2 = document.querySelector('.js-switch-status-u2');
			var switchery_status_xx = document.querySelector('.js-switch-status-xx');

			var status_checks = {"FV" : switchery_status_fv.checked, "U1" : switchery_status_u1.checked, "U2" : switchery_status_u2.checked, "XX" : switchery_status_xx.checked};
			
			this.loadingAdvancedData = true;
			this.dataAvailable = false;

			this.$http.get('/conservationstatetospecies', {params: { status_checks: status_checks } }).then((response) => {
				// Inside the response data there are also the taxonomy data, but the google map API cna distinguish by itself
				//console.log(JSON.parse(response.data));
				this.speciesDetails = JSON.parse(response.data);
				this.loading = false;
				this.loadingAdvancedData = false;
				this.dataAvailable = true;
			}, (response) => {

			});
		},

		filterQuery: function(queryString) {
			return function(element) {
				return element.species_name.toLowerCase().startsWith(queryString.toLowerCase());
			}
		},

		search: function() {
			vm = this;
			if (this.query) {
				this.searched = this.species.filter(this.filterQuery(this.query));
			} else {
				this.searched = [];
			}
		},

		getSpeciesGeographicPositions: function() {
			vm = this;
			this.$http.get('/api/species/').then((response) => {
				vm.species = response.data;
			}, (response) => {
				alert('No data available');
			});
		},
		
		getCsv: function() {
      			csvGenerator = new CsvGenerator(this.speciesDetails, 'ricerca_avanzata' + '.csv');
    			csvGenerator.download(false);
      		}
	},

	events: {
    	'child-obj': function (childObj) {
	      	// `this` in event callbacks are automatically bound
	      	// to the instance that registered it
	      	this.selectedOne = childObj;
	      	this.query = childObj.species_name;
    	},

    	'final-map-data': function(finalMapData) {
    		window.setMappingData(finalMapData);
    	}
  	}
});
