(function() {
window.onload = function() {

var options = {
center: new google.maps.LatLng(37.09, -95.71),
zoom: 3,
mapTypeId: google.maps.MapTypeId.ROADMAP,
backgroundColor: '#ff0000',
mapTypeControl: true,
draggableCursor: 'move',
mapTypeControlOptions: {
style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
position: google.maps.ControlPosition.TOP
}
};
var map = new google.maps.Map(document.getElementById('map-canvas'), options);
/*var marker = new google.maps.Marker({
position: new google.maps.LatLng(40.7257, -74.0047),
map: map,
title: 'Click me'
});


document.getElementById('getValues').onclick = function() {
alert('Current Zoom level is ' + map.getZoom());
alert('Current center is ' + map.getCenter());
alert('The current mapType is ' + map.getMapTypeId());
}
/*
// Creating an InfoWindow with the content text: "Hello World"
var infowindow = new google.maps.InfoWindow({
content:'<div class="info">Hello world</div>'
});
// Adding a click event to the marker
google.maps.event.addListener(marker, 'click', function() {
// Calling the open method of the infoWindow
infowindow.open(map, marker);
});
// Creating an array that will contain the coordinates
// for New York, San Francisco, and Seattle
var places = [];
// Adding a LatLng object for each city
places.push(new google.maps.LatLng(40.756, -73.986));
places.push(new google.maps.LatLng(37.775, -122.419));
places.push(new google.maps.LatLng(47.620, -122.347));
// Looping through the places array

for (var i = 0; i < places.length; i++) {
// Adding the marker as usual
var marker = new google.maps.Marker({
position: places[i],
map: map,
title: 'Place number ' + i
});
// Wrapping the event listener inside an anonymous function
// that we immediately invoke and passes the variable i to.
(function(i, marker) {
// Creating the event listener. It now has access to the values of
// i and marker as they were during its creation
google.maps.event.addListener(marker, 'click', function() {
var infowindow = new google.maps.InfoWindow({
content: 'Place number ' + i
});
infowindow.open(map, marker);
});
})(i, marker);
}
}
})();*/

// Creating a LatLngBounds object
var bounds = new google.maps.LatLngBounds();
// Creating an array that will contain the coordinates
// for New York, San Francisco, and Seattle
var places = [];
// Adding a LatLng object for each city
places.push(new google.maps.LatLng(40.756, -73.986));
places.push(new google.maps.LatLng(37.775, -122.419));
places.push(new google.maps.LatLng(47.620, -122.347));
places.push(new google.maps.LatLng(-22.933, -43.184));
// Creating a variable that will hold
// the InfoWindow object
var infowindow;
// Looping through the places array
for (var i = 0; i < places.length; i++) {
// Adding the markers
var marker = new google.maps.Marker({
position: places[i],
map: map,
title: 'Place number ' + i
});
// Wrapping the event listener inside an anonymous function
// that we immediately invoke and passes the variable i to.
(function(i, marker) {
// Creating the event listener. It now has access to the values of
// i and marker as they were during its creation
google.maps.event.addListener(marker, 'click', function() {
// Check to see if we already have an InfoWindow
if (!infowindow) {
infowindow = new google.maps.InfoWindow();
}
// Setting the content of the InfoWindow
infowindow.setContent('Place number ' + i);
// Tying the InfoWindow to the marker
infowindow.open(map, marker);
});
})(i, marker);
// Extending the bounds object with each LatLng
bounds.extend(places[i]);
}
// Adjusting the map to new bounding box
map.fitBounds(bounds)
};
})();