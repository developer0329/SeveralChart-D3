
var data = [];
var the_formula = "";

function saveForecast() {
	var f = document.forms['frmNext'];
	var points = getpoints();
	f.points.value = getpoints();
	f.formula.value = window.the_formula;	
	f.p.value = "settings";
	f.submit();
}

// build and return json string of points 
 function getpoints() {
	var a = [];
	var s = "";
	 if ( data.length > 0 ) {
		 for ( var i =0; i < data.length;i++ ) {
			 s = "{";
			 s += " \"index\":" + data[i].index;
			 s += ", \"target\":" + data[i].target;
			 s += ", \"min\":" + data[i].min;
			 s += ", \"max\":" + data[i].max;
			 s += "}";
			 a.push( s );
		 }				 
		 s = a.join(",");
		 s = "\"points\"=[" + s + "]";
	 }
	 s = "{" + s + "}";
	 return s;
 }

		 
function clearArray(){
	data = [];
	console.log("clear");
	d3.select("body").select("#chart").select("svg").remove();

}

function addForecast(){
	document.getElementById('chartdiv').style.display="";
	var min = Number(document.getElementById('min').value);
	var max = Number(document.getElementById('max').value);
	var target = Number(document.getElementById('target').value);
	if(min>max){
		var tmp = min;
		min = max;
		max = tmp;
	}
	var obj = {'index':data.length+1,'target':target, 'min':min, 'max':max};
	data.push(obj);
	document.getElementById('target').value = "";
	document.getElementById('min').value = "";
	document.getElementById('max').value = "";
	console.log("forecast added");
	drawLine();
}


var height = 300;
var width = 600;
var margin = {top: 20, right:20, bottom: 40, left: 40};

// formatters for axis and labels
var currencyFormat = d3.format("4d");
var decimalFormat = d3.format("0.2f");

function drawLine(){
	d3.select("#chart").select("svg").remove();
	var svg = d3.select("#chart").append("svg")
		.attr("width", width + margin.left + margin.right)
		.attr("height", height + margin.top + margin.bottom);

	svg.append("g")
		.attr("class", "y axis");
		
	svg.append("g")
		.attr("class", "x axis");
		
	// extract the x labels for the axis and scale domain
	var xLabels = data.map(function (d) { return d['index']; })

	var xScale = d3.scale.ordinal()
		.domain(xLabels)
		.rangeRoundPoints([margin.left, width], .1);
		
	var yScale = d3.scale.linear()
		.range([height, 0]);

	var xAxis = d3.svg.axis()
		.scale(xScale)
		.orient("bottom");
		
	var yAxis = d3.svg.axis()
		.scale(yScale)
		.orient("left");

	var targetMin = Math.round(d3.min(data, function(d) { return parseFloat(d['target']); }));
	var targetMax = Math.round(d3.max(data, function(d) { return parseFloat(d['target']); }));

	var minMin = Math.round(d3.min(data, function(d) { return parseFloat(d['min']); }));
	var minMax = Math.round(d3.max(data, function(d) { return parseFloat(d['min']); }));

	var maxMin = Math.round(d3.min(data, function(d) { return parseFloat(d['max']); }));
	var maxMax = Math.round(d3.max(data, function(d) { return parseFloat(d['max']); }));
	
	yScale.domain([Math.min(0,targetMin,minMin,maxMin), Math.max(0,targetMax,minMax,maxMax)]);
	
	var line = d3.svg.line()
		.x(function(d) { return xScale(d['index']); })
		.y(function(d) { return yScale(d['target']); });
	
	var area = d3.svg.area()
	    .x(function(d) { return xScale(d['index']); })
	    .y0(function(d) { return yScale(d['min']); })
	    .y1(function(d) { return yScale(d['max']); });

	svg.append("path")
		.datum(data)
		.attr("class","line")
		.attr("d", line);

	svg.append("path")
      .datum(data)
      .attr("class", "area")
      .attr("d", area);

	svg.selectAll("circle")
	    .data(data)
	  .enter().append("circle")
	    .attr("cx", function(d) { return xScale(d['index']);})
	    .attr("cy", function(d) { return yScale(d['target']); })
	    .attr("r", 5)
	    .attr("style","fill:white")
	    .attr("stroke","steelblue")
	    .attr("stroke-width","2");

	//console.log(svg);
	
	svg.select(".x.axis")
		.attr("transform", "translate(0," + (height) + ")")
		.call(xAxis.tickValues(xLabels))
		.selectAll("text")
		.style("text-anchor","end");
	
	svg.select(".y.axis")
		.attr("transform", "translate(" + (margin.left) + ",0)")
		.call(yAxis.tickFormat(currencyFormat));
		
	// x axis label
	svg.append("text")
		.attr("x", (width + (margin.left + margin.right) )/ 2)
		.attr("y", height + margin.bottom)
		.attr("class", "text-label")
		.attr("text-anchor", "middle")
		.text("Month");
	
	if(data.length>1){
		// get the x and y values for least squares
		var xSeries = d3.range(1, xLabels.length + 1);
		var ySeries = data.map(function(d) { return parseFloat(d['target']); });
	
		var leastSquaresCoeff = leastSquares(xSeries, ySeries);
		
		// apply the reults of the least squares regression
		var x1 = xLabels[0];
		var y1 = leastSquaresCoeff[0] + leastSquaresCoeff[1];
		var x2 = xLabels[xLabels.length - 1];
		var y2 = leastSquaresCoeff[0] * xSeries.length + leastSquaresCoeff[1];
		var trendData = [[x1,y1,x2,y2]];
		
		var trendline = svg.selectAll(".trendline")
			.data(trendData);
			
		trendline.enter()
			.append("line")
			.attr("class", "trendline")
			.attr("x1", function(d) { return xScale(d[0]); })
			.attr("y1", function(d) { return yScale(d[1]); })
			.attr("x2", function(d) { return xScale(d[2]); })
			.attr("y2", function(d) { return yScale(d[3]); })
			.attr("stroke", "black")
			.attr("stroke-width", 1);
		
		// display equation on the chart
		svg.append("text")
			.text("eq: " + decimalFormat(leastSquaresCoeff[0]) + "x + " + 
				decimalFormat(leastSquaresCoeff[1]))
			.attr("class", "text-label")
			.attr("x", function(d) {return xScale(x2);})
			.attr("y", function(d) {return yScale(y2) - 30;});
		
		// display r-square on the chart
		svg.append("text")
			.text("r-sq: " + decimalFormat(leastSquaresCoeff[2]))
			.attr("class", "text-label")
			.attr("x", function(d) {return xScale(x2);})
			.attr("y", function(d) {return yScale(y2) - 10;});
	}
}

// returns slope, intercept and r-square of the line
function leastSquares(xSeries, ySeries) {
	var reduceSumFunc = function(prev, cur) { return prev + cur; };
	
	var xBar = xSeries.reduce(reduceSumFunc) * 1.0 / xSeries.length;
	var yBar = ySeries.reduce(reduceSumFunc) * 1.0 / ySeries.length;

	var ssXX = xSeries.map(function(d) { return Math.pow(d - xBar, 2); })
		.reduce(reduceSumFunc);
	
	var ssYY = ySeries.map(function(d) { return Math.pow(d - yBar, 2); })
		.reduce(reduceSumFunc);
		
	var ssXY = xSeries.map(function(d, i) { return (d - xBar) * (ySeries[i] - yBar); })
		.reduce(reduceSumFunc);
		
	var slope = ssXY / ssXX;
	var intercept = yBar - (xBar * slope);
	var rSquare = Math.pow(ssXY, 2) / (ssXX * ssYY);
	
	window.the_formula = slope + "x+" + intercept + " r-sq:" + rSquare;
	
	return [slope, intercept, rSquare];
}