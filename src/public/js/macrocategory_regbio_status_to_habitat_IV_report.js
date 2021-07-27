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

		if (e.explicitOriginalTarget.id == 'macrocategory_submit')
		{
			var allMacrocatSelectors = document.querySelectorAll('[class^="js-switch-mac"]');
			var macrocat_checks = {};

			allMacrocatSelectors.forEach(function(elm) {
				macrocat_checks["MAC" + elm.className.slice(-1)] = elm.checked;
			});
			console.log(this.el.action);
			this.vm.$http.get(this.el.action, {params: { macrocat_checks: macrocat_checks } }).then((response) => {
				// Inside the response data there are also the taxonomy data, but the google map API cna distinguish by itself
				//console.log(JSON.parse(response.data));
				this.vm.habitatDetails = JSON.parse(response.data);
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
			
			this.vm.loadingAdvancedData = true;			

			this.vm.$http.get(this.el.action, {params: { regbio_checks: regbio_checks } }).then((response) => {
				// Inside the response data there are also the taxonomy data, but the google map API cna distinguish by itself
				//	console.log(JSON.parse(response.data));
				this.vm.habitatDetails = JSON.parse(response.data);
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

			this.vm.loadingAdvancedData = true;
			
			this.vm.$http.get(this.el.action, {params: { status_checks: status_checks } }).then((response) => {
				// Inside the response data there are also the taxonomy data, but the google map API cna distinguish by itself
				//console.log(JSON.parse(response.data));
				this.vm.habitatDetails = JSON.parse(response.data);
				this.vm.loading = false;
				this.vm.loadingAdvancedData = false;
			}, (response) => {

			});
		}
	}
});

Vue.component('habitat', {
	template: '#habitat-template',

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

new Vue({
	el: 'body',

	data: {
		// Taxonomy packet
		report_number: 'IV',

		macrocategories: [],
		habitats: [],
		loading: false,
		loadingAdvancedData: false,
		dataAvailable: false,

		///////////////////////////////////////////

		habitatDetails: [],
		selectedOne: '',
	
	},

	methods: {

		searchHabitatsFromSelections: function() {

			var allMacrocatSelectors = document.querySelectorAll('[class^="js-switch-mac"]');
			var macrocat_checks = {};

			allMacrocatSelectors.forEach(function(elm) {
				var elmOfClassName = elm.className.split('-');
				macrocat_checks["MAC-" + elmOfClassName[elmOfClassName.length - 1]] = elm.checked;
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
			radio_buttons_biogeoreg_value = 'OR';

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

			this.$http.get('/advancedselectiontohabitat', {params: { report_number: vm.report_number, macrocat_checks: macrocat_checks, status_checks: status_checks, radio_buttons_biogeoreg_value: radio_buttons_biogeoreg_value, regbio_checks: regbio_checks } }).then((response) => {
				// Inside the response data there are also the taxonomy data, but the google map API cna distinguish by itself

				this.habitatDetails = JSON.parse(response.data);
				this.loading = false;
				this.dataAvailable = true;
			}, (response) => {

			});

		},

		searchHabitatFromMacrocategory: function() {
			var allMacrocatSelectors = document.querySelectorAll('[class^="js-switch-mac"]');
			var macrocat_checks = {};

			allMacrocatSelectors.forEach(function(elm) {
				macrocat_checks["MAC" + elm.className.slice(-1)] = elm.checked;
			});

			this.loadingAdvancedData = true;
			this.dataAvailable = false;
			
			this.$http.get('/macrocategoriestohabitat', {params: { macrocat_checks: macrocat_checks } }).then((response) => {
				// Inside the response data there are also the taxonomy data, but the google map API cna distinguish by itself
				//console.log(JSON.parse(response.data));
				this.habitatDetails = JSON.parse(response.data);
				this.loading = false;
				this.loadingAdvancedData = false;
				this.dataAvailable = true;
			}, (response) => {

			});
		},

		searchHabitatsFromBioreg: function() {
			var switchery_alp = document.querySelector('.js-switch-alp');
			var switchery_con = document.querySelector('.js-switch-con');
			var switchery_med = document.querySelector('.js-switch-med');
			var switchery_mmed = document.querySelector('.js-switch-mmed');

			var regbio_checks = {"ALP" : switchery_alp.checked, "CON" : switchery_con.checked, "MED" : switchery_med.checked, "MMED" : switchery_mmed.checked};

			this.loadingAdvancedData = true;
			this.dataAvailable = false;
			
			this.$http.get('/biogeographicregtohabitat', {params: { regbio_checks: regbio_checks } }).then((response) => {
				// Inside the response data there are also the taxonomy data, but the google map API cna distinguish by itself
				//	console.log(JSON.parse(response.data));
				this.habitatDetails = JSON.parse(response.data);
				this.loading = false;
				this.loadingAdvancedData = false;
				this.dataAvailable = true;
			}, (response) => {

			});
		},

		searchHabitatsFromConservationStatus: function() {
			var switchery_status_fv = document.querySelector('.js-switch-status-fv');
			var switchery_status_u1 = document.querySelector('.js-switch-status-u1');
			var switchery_status_u2 = document.querySelector('.js-switch-status-u2');
			var switchery_status_xx = document.querySelector('.js-switch-status-xx');

			var status_checks = {"FV" : switchery_status_fv.checked, "U1" : switchery_status_u1.checked, "U2" : switchery_status_u2.checked, "XX" : switchery_status_xx.checked};
			
			this.loadingAdvancedData = true;
			this.dataAvailable = false;
			
			this.$http.get('/conservationstatetohabitat', {params: { status_checks: status_checks } }).then((response) => {
				// Inside the response data there are also the taxonomy data, but the google map API cna distinguish by itself
				//console.log(JSON.parse(response.data));
				this.habitatDetails = JSON.parse(response.data);
				this.loading = false;
				this.loadingAdvancedData = false;
				this.dataAvailable = true;
			}, (response) => {

			});
		},

		getCsv: function() {
			console.log(this.habitatDetails);
	      		csvGenerator = new CsvGenerator(this.habitatDetails, this.habitatDetails.habitat_name + '_' + this.habitatDetails.habitat_code + '.csv');
	    		csvGenerator.download(true);
      	}


	},

	ready: function() {
		vm = this;
		
	},
});
