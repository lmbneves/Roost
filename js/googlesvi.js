//googlesvi.js - Kedar Shashidhar
//Google Sreet View Image URL generator
//This simple script pulls the address of all house results in a search/browse
//then generates an image url from google's street view services for use as a thumbnail 

//Global Objects for Street View Service and Geocoder
var svs;
var geocoder;
var maxRad;
var imgURL;

window.onload = initialize();
//Initialize Function Intializes key variables and functions needed for processing
function initialize(){
	
	//initialize global objects
	svs = new google.maps.StreetViewService();
	geocoder = new google.maps.Geocoder();
	maxRad = 50;
	
	//retreive list of house and image results
	var houseList = document.getElementsByClassName("address");
	//var imgList = getElementsByClassName("img");
/*
	//process each house
	for(var i = 0; i < houseList.length; i++){
		//alert(houseList[i].innerText);
		setSVC(houseList[i]);
    	        document.getElementById("img"+i).setAttribute("src",imgURL);

	}*/
	setSVC(houseList[0]);
	document.getElementByID("img"+i).setAttribute("src",imgURL);
}

function setSVC(node){
 
	//pull house address
	var hAddress = node.innerText;
	
	//retreive LatLng coordinates
	var hLatLng;
	geocoder.geocode( {'address': hAddress}, function(result, status){
		if(status == google.maps.GeocoderStatus.OK){
			alert('Result: '+result[0]);
			hLatLng = result[0].geometry.location;
		}
		else{
			alert('Geocode Error: ' + status + ' ' + hAddress );
		}
	});
	//SCRIPT RUNS TO HERE THEN BREAKS NEEDS MORE DEBUG
	//retreive closest svsCam pos
	var pLatLng;
	svs.getPanoramaByLocation(hLatLng, maxRad, function(data,status){
	alert("load");
		if(status == google.maps.StreetViewStatus.OK){
				

			pLatLng = data.location.latLng;
		}
		else{
			alert('Street View Status Error Error: ' + status);
		}
	});

	//retreive heading and getimageURL
		alert('House: '+hLatLng+'Pano: '+pLatLng);

	var heading = google.maps.geometry.spherical.computeHeading(pLatLng, hLatLng);
	imgURL = "http://maps.googleapis.com/maps/api/streetview?size=200x200&location=" + pLatLng + "&heading=" + heading + "&fov=360&heading=235&sensor=false";
}

//google.maps.event.addDomListener(window, 'load', initialize);