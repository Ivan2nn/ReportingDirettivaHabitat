var map;
var bermudaTriangleList = [];
var infoWindow;
var shiftPressed = false;

function initialize() {
    
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 6,
        center: {lat: 42.0131155, lng: 11.8728825}
    });

    infoWindow = new google.maps.InfoWindow();
    map.data.loadGeoJson('json/griglia_IV_report_d.json');
    map.data.setStyle(function(feature) {
        var color = 'white';
        if (feature.getProperty('isColorful')) {
            color = 'red';
        }

        return ({
            fillColor: color,
            strokeColor: 'red',
            strokeWeight: 1,
            strokeOpacity: 0.3,
            clickable: true
        });
    });

    map.data.addListener('click', function(event) {
	window.myVue.selectedCell = event.feature.getProperty('CellCode');
        map.data.revertStyle();
        map.data.overrideStyle(event.feature, {fillColor: 'blue'});
    });
}
google.maps.event.addDomListener(window, 'load', initialize);


// Here we should handle multiple requests....
/*window.keydown(function(evt) {
    if (evt.ctrlKey) { // shift
      ctrlKey = true;
    }
}).keyup(function(evt) {
    if (evt.ctrlKey) { // shift
      ctrlKey = false;
    }
});*/
