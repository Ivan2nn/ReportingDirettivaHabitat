Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('input[name="_token"]').value;

Vue.directive('ajax', {
	
	bind: function() {
		this.el.addEventListener('submit', this.onSubmit.bind(this));
	},

	update: function() {

	},

	// Remeber that we have to put a regex forcing the cellcode to start with 10 to block attacks
	// (in the routes?)...at the moments selectedOne is a string
	onSubmit: function(e) {
		e.preventDefault();
		this.vm.loading = true;
		this.vm.dataAvailable = false;
		
		this.vm.$http.get(this.el.action + this.vm.selectedCell).then((response) => {
		//this.vm.$dispatch('final-cell-data', response.data);
		//console.log(response.data);
		this.vm.habitatDetails = JSON.parse(response.data);
		this.vm.loading = false;
		this.vm.dataAvailable = true;
		}, (response) => {

		});
	}
});

Vue.component('multi-habitat-info-cell', {
	template: '#multi-habitat-info-cell-template',

	props: ['list'],

	data: function() {
		return {
			list: []
		};
	},

	methods: {
		notify: function (hab) {
			this.$dispatch('child-obj', hab);
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
	}
});

this.myVue = new Vue({
	el: 'body',

	data: {
		habitats: [],
		selectedCell: '',
		loading: false,
		habitatDetails: [],
		dataAvailable: false
	},

	methods: {

		getCsv: function() {
	  		csvGenerator = new CsvGenerator(this.habitatDetails, this.selectedCell + '.csv');
			csvGenerator.download(true);
	  	}

		/*getSpeciesFromCellCode: function() {
			vm = this;
			this.$http.get('/api/cell/').then((response) => {
				vm.species = response.data;
			}, (response) => {
				alert('No data avilable');
			});
		}*/
	},

	events: {
    	'child-obj': function (childObj) {
	      	// `this` in event callbacks are automatically bound
	      	// to the instance that registered it
	      	this.selectedOne = childObj;
	      	this.query = childObj.name;
    	},

    	'final-map-data': function(finalMapData) {
    		window.setMappingData(finalMapData);
    	}
  	}
});
