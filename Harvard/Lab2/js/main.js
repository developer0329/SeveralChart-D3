
// SVG drawing area

var margin = {top: 40, right: 10, bottom: 60, left: 60};

var width = 870 - margin.left - margin.right,
    height = 300 - margin.top - margin.bottom;

var ranking = "stores";

var svg = d3.select("#chart-area").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");


// Scales
var x = d3.scale.ordinal().rangeRoundBands([0, width], .1);
var y = d3.scale.linear().range([height, 0]);
var xAxis = d3.svg.axis().scale(x).orient("bottom");
var yAxis = d3.svg.axis().scale(y).orient("left").ticks(10, "");


// Initialize data
loadData();

// Coffee chain data
var data;

// Load CSV file
function loadData() {
	d3.csv("data/coffee-house-chains.csv", function(error, csv) {

		csv.forEach(function(d){
			d.revenue = +d.revenue;
			d.stores = +d.stores;
		});

		// Store csv data in global variable
		data = csv;
		data.sort(function(a, b) { return b.stores - a.stores; });
    	// Draw the visualization for the first time
		updateVisualization();
	});
}

d3.select("#ranking-type").on("change", function() {
	var value= this.value;
	ranking = value;
	if(value=="stores")
	{
		data.sort(function(a, b) { return b.stores - a.stores; });
		x.domain(data.map(function(d) { return d.company; }));
  		y.domain([0, d3.max(data, function(d) { return d.stores; })]);

  		var bar = svg.selectAll(".bar").data(data);
			bar.exit().remove();

			bar.attr("class", "bar")
			    .attr("x", function(d) { return x(d.company); })
			    .attr("width", x.rangeBand())
			    .attr("y", function(d) { return y(d.stores); })
			    .attr("height", function(d) { return height - y(d.stores); });

		svg.select("#Y-Anchor").text("Stores");
		svg.select(".x.axis").transition().duration(500).ease("linear").call(xAxis);
		svg.select(".y.axis").transition().duration(500).ease("linear").call(yAxis);
	}
	else
	{
		data.sort(function(a, b) { return b.revenue - a.revenue; });
		x.domain(data.map(function(d) { return d.company; }));
  		y.domain([0, d3.max(data, function(d) { return d.revenue; })]);

  		var bar = svg.selectAll(".bar").data(data);
			bar.exit().remove();
			bar.attr("class", "bar")
			    .attr("x", function(d) { return x(d.company); })
			    .attr("width", x.rangeBand())
			    .attr("y", function(d) { return y(d.revenue); })
			    .attr("height", function(d) { return height - y(d.revenue); });

  		svg.select("#Y-Anchor").text("Revenue");
  		svg.select(".x.axis").transition().duration(700).ease("linear").call(xAxis);
		svg.select(".y.axis").transition().duration(700).ease("linear").call(yAxis);
	}

	//Update y scale
	


});

// Render visualization
function updateVisualization() {

  	console.log(data);
    x.domain(data.map(function(d) { return d.company; }));
  	y.domain([0, d3.max(data, function(d) { return d.stores; })]);

  	svg.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis);

  	svg.append("g")
      .attr("class", "y axis")
      .call(yAxis)
    .append("text")
    	.attr("id", "Y-Anchor")
      	.attr("transform", "rotate(0)")
      	.attr("y", -6)
      	.attr("dy", ".1em")
      	.style("text-anchor", "end")
      	.text("Stores");

  	svg.selectAll(".bar")
      .data(data)
    .enter().append("rect")
      .attr("class", "bar")
      .attr("x", function(d) { return x(d.company); })
      .attr("width", x.rangeBand())
      .attr("y", function(d) { return y(d.stores); })
      .attr("height", function(d) { return height - y(d.stores); });

  	d3.select("#sort").on("change", change);

	var sortTimeout = setTimeout(function() {
	    d3.select("#sort").property("checked", true).each(change);
	}, 2000);

    function change() {
	    clearTimeout(sortTimeout);

	    // Copy-on-write since tweens are evaluated after a delay.
	    var x0 = x.domain(data.sort(this.checked
	        ? function(a, b) {
	        	if(ranking == "stores") return b.stores - a.stores;
	        	if(ranking == "revenue") return b.revenue - a.revenue;
	        }
	        : function(a, b) { return d3.ascending(a.company, b.company); })
	        .map(function(d) { return d.company; }))
	        .copy();

	    svg.selectAll(".bar")
	        .sort(function(a, b) { return x0(a.company) - x0(b.company); });

	    var transition = svg.transition().duration(750),
	        delay = function(d, i) { return i * 50; };

	    transition.selectAll(".bar")
	        .delay(delay)
	        .attr("x", function(d) { return x0(d.company); });

	    transition.select(".x.axis")
	        .call(xAxis)
	      .selectAll("g")
	        .delay(delay);
	}
}
