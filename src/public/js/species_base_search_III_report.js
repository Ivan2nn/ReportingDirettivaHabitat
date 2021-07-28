Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('input[name="_token"]').value;
Vue.config.devtools = true;

Vue.directive('ajax', {
	
	bind: function() {
		this.el.addEventListener('submit', this.onSubmit.bind(this));
	},

	update: function() {

	},

	onSubmit: function(e) {
		e.preventDefault();
		instance = this;
		/* if (this.vm.searchingNames)
			this.vm.loadingNames = true;
		if (this.vm.searchingCodes)
			this.vm.loadingCodes = true; */
		if (this.vm.searchingNameCode)
			this.vm.loadingNameCode = true;
		this.vm.isSearching = true;
		this.vm.dataAvailable = false;
		
		this.vm.$http.get(this.el.action + this.vm.queryCode + '/' + vm.report_number).then(function(response) {
			// Inside the response data there are also the taxonomy data, but the google map API cna distinguish by itself
			instance.vm.$dispatch('final-map-data', response.data);
			instance.vm.speciesDetails = JSON.parse(response.data)['species'];
			//instance.vm.loadingNames = false;
			//instance.vm.loadingCodes = false;
			instance.vm.loadingNameCode = false;
			instance.vm.dataAvailable = true;
		}, function (response) {

		});
	}
});

Vue.component('species-names', {
	template: '#species-names-template',

	props: ['list'],

	data: function() {
		return {
			list: []
		};
	},

	methods: {
		notify: function (spec, searchedField) {
			this.$dispatch('child-obj', spec, searchedField);
      	}
	}
});

Vue.component('species-codes', {
	template: '#species-codes-template',

	props: ['list'],

	data: function() {
		return {
			list: []
		};
	},

	methods: {
		notify: function (spec, searchedField) {
			this.$dispatch('child-obj', spec, searchedField);
      	}
	}
});

Vue.component('species-names-codes', {
	template: '#species-names-codes-template',

	props: ['list'],

	data: function() {
		return {
			list: []
		};
	},

	methods: {
		notify: function (spec, searchedField) {
			this.$dispatch('child-obj', spec, searchedField);
      	}
	}
});

Vue.component('info-cell', {
	template: '#info-cell-template',

	props: ['list'],

	data: function() {
		return {
			list: []
		};
	},

	methods: {
		notify: function (spec, searchedField) {
			this.$dispatch('child-obj', spec, searchedField);
      		}
	}
});

/*Vue.component('species-info', {
	template: '#species-info-template',

	props: ['species-details'],
});*/

new Vue({
	el: 'body',

	data: {
		report_number: 'III',
		queryName: '',
		queryCode: '',
		queryNameCode: '',
		isName: true,
		outCode: '',
		outSpeciesName: '',
		outNameCode: '',
		species: [],
		speciesDetails: [],
		selectedOne: '',
		dataAvailable: false,
		filterSpecies: true,
		loadingNames: false,
		loadingCodes: false,
		loadingNameCode: false,
		isSearching: false,
		searchingNames: false,
		searchingCodes: false,
		searchingNameCode: false
	},

	ready: function() {
		vm = this;
		this.$http.get('/species').then(function(response) {
			vm.species = response.data;
		}, function(response) {
			alert('No data avilable');
		});

		// We keep the filterSpecies boolean true if we land on the page without any data requested from other pages
		// If we land on the page with a specific species requested from other pages we will not activate the filter on the species
		// If someone clicks inside the input box we can reactivate the filter cause it means that he wants to make a new search
		if (vm.outSpeciesName != '') {
			vm.queryName = vm.outSpeciesName;
			vm.queryCode = vm.outCode;
			vm.queryNameCode = vm.outSpeciesName;
			vm.filterSpecies = false;
			vm.loadingNameCode = true;
			vm.loadingNames = true;
			vm.dataAvailable = false;
			vm.$http.get('/api/species/' + vm.queryCode + '/' + vm.report_number).then(function(response) {
				// Inside the response data there are also the taxonomy data, but the google map API cna distinguish by itself
				vm.$dispatch('final-map-data', response.data);
				vm.speciesDetails = JSON.parse(response.data)['species'];
				vm.dataAvailable = true;
				vm.loadingNameCode = false;
				vm.loadingNames = false;
			}, function(response) {

			});
		}
	},

	computed: {
		searchedNames: function() {
			if (this.filterSpecies == true) {
				vm = this;
				searchedNamesValues = [];
				if (this.queryName) {
					searchedNamesValues = this.species.filter(this.filterQueryNames(this.queryName));
				}
				return searchedNamesValues;
			}
		},

		searchedCodes: function() {
			if (this.filterSpecies == true) {
				vm = this;
				searchedCodesValues = [];
				if (this.queryCode) {
					searchedCodesValues = this.species.filter(this.filterQueryCodes(this.queryCode));
				}
				return searchedCodesValues;
			}
		}, 

		searchedNamesCodes: function() {
			if (this.filterSpecies == true) {
				vm = this;
				searchedNamesCodesValues = [];
				if (this.queryNameCode) {
					searchedNamesCodesValues = this.species.filter(this.filterQueryNamesCodes(this.queryNameCode));
					//console.log(vm.isName);
				}
				return searchedNamesCodesValues;
			}
		}
	},

	methods: {

		resetQueries: function() {
			this.queryName = '';
			this.queryCode = '';
			this.queryNameCode = '';
			this.isName = true;
			this.filterSpecies = true;
			this.outSpeciesName = '';
			this.outCode = '';
			this.outNameCode = '';
			this.isSearching = false;
			this.loadingNames = false;
			this.searchingNames = false;
			this.searchingCodes = false;
			this.searchingNameCode= false;
			this.loadingNameCode = false;
		},

		isLetter: function(firstCharacter) {
			return firstCharacter.toLowerCase() != firstCharacter.toUpperCase();
		},

		filterQueryNames: function(queryString) {
			return function(element) {
				return element.species_name.toLowerCase().startsWith(queryString.toLowerCase());
			}
		},

		filterQueryCodes: function(queryString) {
			return function(element) {
				return element.species_code.toString().startsWith(queryString.toLowerCase());
			}
		},
		
		filterQueryNamesCodes: function(queryString) {
			return function(element) {
				if (vm.isLetter(queryString[0])) {
					vm.isName = true;
					return element.species_name.toLowerCase().startsWith(queryString.toLowerCase());
				}
				else {
					vm.isName = false;
					return element.species_code.toString().startsWith(queryString.toLowerCase());
				}
			}
		},

		searchNames: function() {	
			vm = this;
			if (this.queryName) {
				this.searchedNames = this.species.filter(this.filterQueryNames(this.queryName));
			} else {
				this.searchedNames = [];
			}	
		},

		notify: function (spec, searchedField) {
			this.$dispatch('child-obj', spec, searchedField);
      		},

		searchCodes: function() {	
			vm = this;
			if (this.queryCode) {
				this.searchedCodes = this.species.filter(this.filterQueryCodes(this.queryCode));
			} else {
				this.searchedCodes = [];
			}	
		},

		searchNamesCodes: function() {	
			vm = this;
			if (this.queryNameCode) {
				if (vm.isLetter(this.queryNameCode[0])) {
					vm.isName = true;
					this.searchedNamesCodes = this.species.filter(this.filterQueryNames(this.queryNameCode));
				} else {
					vm.isName = false;
					this.searchedNamesCodes = this.species.filter(this.filterQueryCodes(this.queryNameCode));
				}
			} else {
				this.searchedNamesCodes = [];
			}	
		},

		getSpeciesGeographicPositions: function() {
			vm = this;
			this.$http.get('/species').then(function(response) {
				vm.species = response.data;
			}, function (response) {
				alert('No data available');
			});
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
      			return "/images/red_down.png";
      		};

      		if (eval(temp) == '=') {
      			return "/images/yellow_stable.png";
      		};

      		if (eval(temp) == '+') {
      			return "/images/green_up.png";
      		};

      		if (eval(temp) == 'x') {
      			return "/images/grey_null.png";
      		};

      		/*if (eval(temp) == '') {
      			return "../public/images/grey_null.png";
      		};*/

		},
	
		getCsv: function() {
				csvGenerator = new CsvGenerator(this.speciesDetails, this.speciesDetails.species_name + '_' + this.speciesDetails.species_code + '.csv');
				csvGenerator.download(true);
			}
		},

	events: {
    	'child-obj': function (childObj, searchedField) {
	      	// `this` in event callbacks are automatically bound
	      	// to the instance that registered it
	      	// searchedField can be 'names' or 'codes'
	      	this.selectedOne = childObj;
	      	//this.queryName = childObj.species_name;
	      	this.queryCode = childObj.species_code;
			this.queryNameCode = childObj.species_name;
	      	this.isSearching = true;

			this.searchingNameCode = true;

	      	/* if (searchedField == 'names') {
	      		this.searchingNames = true;
	      	}

	      	if (searchedField == 'codes') {
	      		this.searchingCodes = true;
	      	} */
    	},

    	'final-map-data': function(finalMapData) {
    		window.setMappingData(finalMapData);
    	}
  	}
});
