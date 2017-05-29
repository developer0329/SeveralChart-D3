
var width = 1000, height = 600;
    
var projection = d3.geo.mercator()
	.center([0, 50 ])
	.scale(100)
	.rotate([0,0]);

// 9. Change the geo projection	
/* var projection = d3.geo.orthographic()
    .scale(290)
    .translate([width / 2, height / 2])
    .clipAngle(90)
    .precision(.9); */
	
var svg2 = d3.select("body").append("svg")
	.attr("width", width)
	.attr("height", height);

var world_path = d3.geo.path().projection(projection);

queue().defer(d3.json, "data/world-110m.json")
	.defer(d3.json, "data/airports.json")
	.await(createVisualization);

function createVisualization(error, data1, data2) {
	svg2.selectAll("path")
		.data(topojson.feature(data1, data1.objects.countries).features)
	  .enter().append("path")
		.attr("d", world_path);
	
	svg2.selectAll(".node")
		.data(data2.nodes)
		.enter().append("circle")
		.attr("r", 5)
		.attr("transform", function(d) {return "translate(" + projection([d.longitude, d.latitude]) + ")"; })

}
