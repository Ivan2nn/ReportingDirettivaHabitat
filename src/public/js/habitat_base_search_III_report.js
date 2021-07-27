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
		/* if (this.vm.searchingNames)
			this.vm.loadingNames = true;
		if (this.vm.searchingCodes)
			this.vm.loadingCodes = true; */
		if (this.vm.searchingNameCode)
			this.vm.loadingNameCode = true;
		this.vm.isSearching = true;
		this.vm.dataAvailable = false;
		//console.log(this.el.action + this.vm.queryCode);
		this.vm.$http.get(this.el.action + this.vm.queryCode + '/' + vm.report_number).then((response) => {
			// Inside the response data there are also the taxonomy data, but the google map API cna distinguish by itself
			//console.log(response.data);
			this.vm.$dispatch('final-map-data', response.data);
			this.vm.habitatDetails = JSON.parse(response.data)['habitat'];
/* 			this.vm.loadingNames = false;
			this.vm.loadingCodes = false; */
			this.vm.loadingNameCode = false;
			this.vm.dataAvailable = true;
		}, (response) => {

		});
	}
});

Vue.component('habitat-names', {
	template: '#habitat-names-template',

	props: ['list'],

	data: function() {
		return {
			list: []
		};
	},

	methods: {
		notify: function (hab, searchedField) {
			this.$dispatch('child-obj', hab, searchedField);
      	}
	}
});

Vue.component('habitat-codes', {
	template: '#habitat-codes-template',

	props: ['list'],

	data: function() {
		return {
			list: []
		};
	},

	methods: {
		notify: function (hab, searchedField) {
			this.$dispatch('child-obj', hab, searchedField);
      	}
	}
});

Vue.component('habitat-names-codes', {
	template: '#habitat-names-codes-template',

	props: ['list'],

	data: function() {
		return {
			list: []
		};
	},

	methods: {
		notify: function (hab, searchedField) {
			this.$dispatch('child-obj', hab, searchedField);
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
		notify: function (hab, searchedField) {
			this.$dispatch('child-obj', hab, searchedField);
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
		outCode: '',
		outHabitatName: '',
		habitats: [],
		habitatDetails: [],
		selectedOne: '',
		dataAvailable: false,
		filterHabitat: true,
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
		this.$http.get('/habitat').then((response) => {
			vm.habitats = response.data;
		}, (response) => {
			alert('No data avilable');
		});

		// We keep the filterSpecies boolean true if we land on the page without any data requested from other pages
		// If we land on the page with a specific species requested from other pages we will not activate the filter on the species
		// If someone clicks inside the input box we can reactivate the filter cause it means that he wants to make a new search
		if (vm.outHabitatName != '') {
			vm.queryName = vm.outHabitatName;
			vm.queryCode = vm.outCode;
			vm.filterHabitat = false;
			vm.loadingNames = true;
			this.dataAvailable = false;
			vm.$http.get('/api/habitat/' + vm.queryCode + '/' + vm.report_number).then((response) => {
				// Inside the response data there are also the taxonomy data, but the google map API cna distinguish by itself
				this.$dispatch('final-map-data', response.data);
				this.habitatDetails = JSON.parse(response.data)['habitat'];
				this.dataAvailable = true;
				this.loadingNames = false;
			}, (response) => {

			});
		}
	},

	computed: {
		searchedNames: function() {
			if (this.filterHabitat == true) {
				vm = this;
				searchedNamesValues = [];
				if (this.queryName) {
					searchedNamesValues = this.habitats.filter(this.filterQueryNames(this.queryName));
				}
				return searchedNamesValues;
			}
		},

		searchedCodes: function() {
			if (this.filterHabitat == true) {
				vm = this;
				searchedCodesValues = [];
				if (this.queryCode) {
					searchedCodesValues = this.habitats.filter(this.filterQueryCodes(this.queryCode));
				}
				return searchedCodesValues;
			}
		},

		searchedNamesCodes: function() {
			if (this.filterHabitat == true) {
				vm = this;
				searchedNamesCodesValues = [];
				if (this.queryNameCode) {
					searchedNamesCodesValues = this.habitats.filter(this.filterQueryNamesCodes(this.queryNameCode));
				}
				return searchedNamesCodesValues;
			}
		},

		document_url: function() {
			return 'documents/habitat/' + this.queryCode + '.pdf';
		}
	},

	methods: {

		resetQueries: function() {
			this.queryName = '';
			this.queryCode = '';
			this.queryNameCode = '';
			this.filterHabitat = true;
			this.outHabitatName = '';
			this.outCode = '';
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
				var cleanName = element.habitat_name.charAt(0) == '*' ? element.habitat_name.substring(2) : element.habitat_name;
				return cleanName.toLowerCase().startsWith(queryString.toLowerCase());
			}
		},

		filterQueryCodes: function(queryString) {
			return function(element) {
				return element.habitat_code.toString().startsWith(queryString.toLowerCase());
			}
		},

		filterQueryNamesCodes: function(queryString) {
			return function(element) {
				if (vm.isLetter(queryString[0])) {
					vm.isName = true;
					return element.habitat_name.toLowerCase().startsWith(queryString.toLowerCase());
				}
				else {
					vm.isName = false;
					return element.habitat_code.toString().startsWith(queryString.toLowerCase());
				}
			}
		},

		searchNames: function() {	
			vm = this;
			if (this.queryName) {
				this.searchedNames = this.habitats.filter(this.filterQueryNames(this.queryName)); 
			} else {
				this.searchedNames = [];
			}	
			
		},

		searchCodes: function() {	
			vm = this;
			if (this.queryCode) {
				this.searchedCodes = this.habitats.filter(this.filterQueryCodes(this.queryCode));
			} else {
				this.searchedCodes = [];
			}	
		},

		searchNamesCodes: function() {	
			vm = this;
			if (this.queryNameCode) {
				if (vm.isLetter(this.queryNameCode[0])) {
					vm.isName = true;
					this.searchedNamesCodes = this.habitats.filter(this.filterQueryNames(this.queryNameCode));
				} else {
					vm.isName = false;
					this.searchedNamesCodes = this.habitats.filter(this.filterQueryCodes(this.queryNameCode));
				}
			} else {
				this.searchedNamesCodes = [];
			}	
		},

		getHabitatGeographicPositions: function() {
			vm = this;
			this.$http.get('/habitat').then((response) => {
				vm.habitat = response.data;
			}, (response) => {
				alert('No data available');
			});
		},

		itemStatusStyle: function(item, bioreg) {
      		
      		temp = 'item.habitat_conservation_' + bioreg;
      		
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
      		
      		var temp = 'item.habitat_trend_' + bioreg;
      		
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

      	},
		getCsv: function() {
	      		csvGenerator = new CsvGenerator(this.habitatDetails, this.habitatDetails.habitat_name + '_' + this.habitatDetails.habitat_code + '.csv');
	    		csvGenerator.download(true);
	      	}
	},

	events: {
    	'child-obj': function (childObj, searchedField) {
	      	// `this` in event callbacks are automatically bound
	      	// to the instance that registered it
	      	// searchedField can be 'names' or 'codes'
	      	this.selectedOne = childObj;
	      	this.queryName = childObj.habitat_name;
	      	this.queryCode = childObj.habitat_code;
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
