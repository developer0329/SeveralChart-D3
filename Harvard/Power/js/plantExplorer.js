
/*
 *  plantExplorer - Object constructor function
 *  @param _parentElement   -- HTML element in which to draw the visualization
 *  @param _data            -- Array with all stations of the bike-sharing network
 */

plantExplorer = function(_parentElement, _data) {
  this.parentElement = _parentElement;
  this.data = _data;

  this.initVis();
}


/*
 *  Initialize station map
 */

plantExplorer.prototype.initVis = function() {
  var vis = this;

  vis.margin = { top: 40, right: 0, bottom: 60, left: 60 };

  vis.width = 800 - vis.margin.left - vis.margin.right,
      vis.height = 400 - vis.margin.top - vis.margin.bottom;

  // SVG drawing area
  vis.svg = d3.select("#" + vis.parentElement).append("svg")
      .attr("width", vis.width + vis.margin.left + vis.margin.right)
      .attr("height", vis.height + vis.margin.top + vis.margin.bottom)
      .append("g")
      .attr("transform", "translate(" + vis.margin.left + "," + vis.margin.top + ")");

  // Create map

  plantExplorer = L.map("plant-explorer").setView([37.0902, -95.7129], 4);
	
	L.Icon.Default.imagePath='img';
	
	

  L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(plantExplorer);


  vis.wrangleData();
}


/*
 *  Data wrangling
 */

plantExplorer.prototype.wrangleData = function() {
  var vis = this;

  // Currently no data wrangling/filtering needed
  // vis.displayData = vis.data;

  // Update the visualization
  vis.updateVis();
}


/*
 *  The drawing function
 */

plantExplorer.prototype.updateVis = function() {

  // Add empty layer group for the markers
	var LeafIcon = L.Icon.extend({
		options: {
	//		shadowUrl: 'img/marker-shadow.png',
			iconSize: [12, 20],
			iconAnchor: [12, 41],
			popupAnchor: [0, -28]
		}
	});
	var Marker_icon = new LeafIcon({ iconUrl: 'img/marker-blue.png' });
	
	
  powerPlants = L.layerGroup().addTo(plantExplorer);
//	console.log(plantsData.length);
  for (i = 0; i < plantsData.length; i++) {
		
	//	console.log("i:"+i+",lat:"+plantsData[i].lat+",long:"+plantsData[i].long);
		
    // Create popups
		if(plantsData[i].lat == null  && plantsData[i].lat == null) continue;
    var popupContent =  "<strong>" + plantsData[i].name + "</strong><br/>"
    popupContent += plantsData[i].city + ", " + plantsData[i].state;

		
    // Create a marker and bind a popup with a particular HTML content
    var marker = L.marker([plantsData[i].lat, plantsData[i].long],{ icon: Marker_icon })
        .bindPopup(popupContent);
 //       .addTo(plantExplorer);
	

		powerPlants.addLayer(marker);
		
  }

}
