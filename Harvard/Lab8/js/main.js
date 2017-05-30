
var allData = [];

// Variable for the visualization instance
var stationMap;

// Start application by loading the data
loadData();


function loadData() {

  // Hubway XML station feed
 var url = 'https://www.thehubway.com/data/stations/bikeStations.xml';

	
	var yql='http://query.yahooapis.com/v1/public/yql?q='+encodeURIComponent('SELECT * FROM xml WHERE url="'+url+'"')+'&format=json&callback=?';
	
	$.getJSON(yql,function(jsonData){
		console.log(jsonData);
		allData=jsonData.query.results.stations.station;
		$('#station-count').html(allData.length);
		stationMap=new StationMap("ny-map",allData,[42.360082,-71.058880]);
	});


}


function createVis() {

  // TO-DO: INSTANTIATE VISUALIZATION

}