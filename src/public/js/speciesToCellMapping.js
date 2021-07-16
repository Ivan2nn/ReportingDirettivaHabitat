var map;
var bermudaTriangleList = [];
var infoWindow;

function initialize() {
    
    var width = window.innerWidth || $(window).width();
    if (width < 992)
     var zoom_start = 4.8;
    else
     var zoom_start = 6;
    
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: zoom_start,
        center: {lat: 42.0131155, lng: 12.4728825}
    });

    infoWindow = new google.maps.InfoWindow();

    //map.data.loadGeoJson('../json/griglia.json');
    /*map.data.setStyle(function(feature) {
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
    });*/

    //map.data.addListener('mouseover', function(event) {
      //  document.getElementById('info-box').textContent = 
        //    event;
    //});
}
google.maps.event.addDomListener(window, 'load', initialize);
google.maps.event.addDomListener(window, "resize", function() {
        var width = window.innerWidth || $(window).width();
	if (width < 992)
	 var zoom = 4.8;
	else
	 var zoom = 6;
	 var center= {lat: 42.0131155, lng: 12.4728825};
	 google.maps.event.trigger(map, "resize");
	 map.setCenter(center);
	 map.setZoom(zoom);
});

function setMappingData(selectedCells) {

    cleanMap();
    

    var parsedMapData = JSON.parse(selectedCells); 
    var tempParsedFeatures = parsedMapData['features'];
    for (var cellIdx in tempParsedFeatures) {
        var cellName = tempParsedFeatures[cellIdx]['properties']['CellCode'];
        var cellRegBio = tempParsedFeatures[cellIdx]['properties']['REG_BIO'];
        var tempPath = tempParsedFeatures[cellIdx]['geometry']['coordinates'];
        var convertedToPolygonPath = convertJSONGeometryToPolygon(tempPath);
        bermudaTriangle = new google.maps.Polygon({
            paths: convertedToPolygonPath,
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 1 ,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            cellName: cellName,
            cellRegBio: cellRegBio,
            map: map
        });

        bermudaTriangleList.push(bermudaTriangle);
        bermudaTriangle.addListener('mouseover', showArrays);

    }


    

    

    /*map.data.addGeoJson(selectedCells);

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
    });*/
}

function showArrays(event) {
    var vertices = this.getPath();

    var contentString = '<b>' + this.cellName + '</b><br>' +
        'Clicked location: <br>(' + event.latLng.lat() + ',' + event.latLng.lng() +
        ')<br>' + 'Biogeographic Region: ' + '<b>' + this.cellRegBio + '</b><br>';

    

    infoWindow.setContent(contentString);
    infoWindow.setPosition(event.latLng);

    infoWindow.open(map);
}

function cleanMap() {
    
    if (infoWindow)
        infoWindow.close();

    while (bermudaTriangleList.length > 0) {
        bermudaTriangleList.pop().setMap(null);
    }
}

function convertJSONGeometryToPolygon(JSONGeometry) {

    var resultPath = [];
    for (var idxAllVertex in JSONGeometry[0]) { 
        resultPath[idxAllVertex] = {'lat':JSONGeometry[0][idxAllVertex][1], 'lng':JSONGeometry[0][idxAllVertex][0]};   
    }

    return resultPath;
}
