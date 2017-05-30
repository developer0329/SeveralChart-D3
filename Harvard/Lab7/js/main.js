
// Will be used to the save the loaded JSON data
var allData = [];

// Date parser to convert strings to date objects
var parseDate = d3.time.format("%Y").parse;

// Set ordinal color scale
var colorScale = d3.scale.category20();

// Variables for the visualization instances
var areachart, timeline;
var brush, xFocus, x2;


// Start application by loading the data
loadData();

function loadData() {
	d3.json("data/uk-household-purchases.json", function(error, jsonData){
		if(!error){
			allData = jsonData;

			// Convert Pence Sterling (GBX) to USD and years to date objects
			allData.layers.forEach(function(d){
				for (var column in d) {
	        if (d.hasOwnProperty(column) && column != "Year") {
	          d[column] = parseFloat(d[column]) * 1.481105 / 100;
	        } else if(d.hasOwnProperty(column) && column == "Year") {
	        	d[column] = parseDate(d[column].toString());
	        }
	      }
			});

			allData.years.forEach(function(d){
				d.Expenditures = parseFloat(d.Expenditures) * 1.481105 / 100;
				d.Year = parseDate(d.Year.toString());
			});


			// Update color scale (all column headers except "Year")
			// We will use the color scale later for the stacked area chart
			colorScale.domain(d3.keys(allData.layers[0]).filter(function(d){ return d != "Year"; }))

			createVis();
		}
	});
}

function createVis() {

	// TO-DO: Instantiate visualization objects here
	areachart = new StackedAreaChart("stacked-area-chart", allData.layers);
	timeline = new Timeline("timeline", allData.years);
}


function brushed() {
	// TO-DO: React to 'brushed' event
	xFocus.domain(brush.empty() ? x2.domain() : brush.extent());
	//focus.select(".area").attr("d", area);
	//focus.select(".x.axis").call(xAxis);
	
	areachart.wrangleData();

}
