var latLng = [-1.5333, 113.7500];
var map = L.map('map').setView(latLng, 7);
var marker;
layer  = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

var latInput = document.querySelector("[name=latitude]");
var lngInput = document.querySelector("[name=longitude]");
map.on("click", function(e){
    var lat=e.latlng.lat;
    var lng=e.latlng.lng;
    
    if(!marker) {
        marker = L.marker(e.latlng).addTo(map)
    }else{
        marker.setLatLng(e.latlng);
    }

    latInput.value = lat;
    lngInput.value = lng;
})