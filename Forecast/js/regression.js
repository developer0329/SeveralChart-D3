var data = [];
var actualData = [];
var inRange = false;
var height = 300;
var width = 600;
var margin = {top: 20, right: 20, bottom: 40, left: 80 };
var svg;
var xLabels, xRealLabels;
var xScale;
var yScale;
var title = "New Forecast Chart";

var color_hash = {  0 : ["forecast", "blue"], 1 : ["actual", "red"] };

var yLabel = "Y-Label";
// formatters for axis and labels
var currencyFormat = d3.format("4d");
var decimalFormat = d3.format("0.2f");
var adding = "point";

var the_formula = "";

function setYLabel() {
    //yLabel = document.getElementById('yLabel').value;
    svg.select(".y.axis")
    .select(".text-label")
    .text(yLabel);
}

function getXLabel(){
	var xLabel = "Days";
	
	var date_num;
	
	if (data.length >= actualData.length)
	{
        date_num = data.length;
		
    } else {
        date_num = actualData.length;
    }
	
	if(date_num < 30){
		xLabel = "Days";
	}
	
	if(date_num >= 30 && date_num < 180){
		xLabel = "Weeks";
	} 
	if(date_num >= 180){
		xLabel = "Months";
	}
	console.log("num ; " + date_num + " : " + xLabel );
	return xLabel;
}

function setTitle()
{
	var obj = document.getElementById('new-chart-title');
	document.getElementById('new-chart-title').innerText = title;
}

function saveForecast()
{
	var f = document.forms['frmNext'];
	f.forecast_points.value = getpoints();
}

// build and return json string of points 
 function getpoints() {
	var a = [];
	var s = "";
	 if ( data.length > 0 ) {
		 for ( var i =0; i < data.length;i++ ) {
			 s = "{";
			 s += " \"index\":" + data[i].index;
			 s += ", \"target\":" + data[i].expected;
			 s += ", \"min\":" + data[i].min;
			 s += ", \"max\":" + data[i].max;
			 s += "}";
			 a.push( s );
		 }				 
		 s = a.join(",");
	 }
	 s = "[" + s + "]";
	 return s;
 }

 

function drawaxis() {
    svg.append("g")
        .attr("class", "y axis");

    svg.append("g")
        .attr("class", "x axis");

    var xAxis = d3.svg.axis()
        .scale(xScale)
        .orient("bottom");

    var yAxis = d3.svg.axis()
        .scale(yScale)
        .orient("left");

    svg.select(".x.axis")
        .attr("transform", "translate(0," + (height) + ")")
        .call(xAxis.tickValues(xRealLabels))
        .selectAll("text")
        .style("text-anchor", "middle");

	svg.select(".x.axis").append("text")
        .attr("x", (width + (margin.left + margin.right)) / 2)
        .attr("y", margin.bottom)
        .attr("class", "text-label")
        .attr("text-anchor", "middle")
        .text(getXLabel());
		
    svg.select(".y.axis")
        .attr("transform", "translate(" + (margin.left) + ",0)")
        .call(yAxis.tickFormat(currencyFormat));
		
	svg.select(".y.axis").append("text")
        .attr("x", -(height + margin.top) / 2)
        .attr("y", -65)
        .attr("class", "text-label")
        .attr("transform", "rotate(-90)")
        .attr("text-anchor", "middle")
        .text(yLabel);
}

function clearForecastArray() {
    data = [];
    render();
    create_table();
}

function clearActualArray() {
    actualData = [];
    render();
    create_table();
}


function render() {
    svg.select(".x.axis").remove();
    svg.select(".y.axis").remove();
    svg.select("#forecast").remove();
    svg.select(".actual").remove();
    getScale();
    drawaxis(xScale, yScale, xLabels);
	
    if (data.length > 0) {
        drawForecastLine();
    }
    if (actualData.length > 0) {
        drawActualLine();
    }
	
	// add legend   
	var legend = svg.append("g")
		.attr("class", "legend")
		//.attr("x", width - 65)
		//.attr("y", height)
		.attr("height", 100)
		.attr("width", 100)
		.attr('transform', 'translate(0,330)')    
      
    var dataset = [data, actualData];
	
    legend.selectAll('rect')
      .data(dataset)
      .enter()
      .append("rect")
	  .attr("x", width - 65)
      .attr("y", function(d, i){ return i *  20;})
	  .attr("width", 10)
	  .attr("height", 10)
	  .style("fill", function(d) { 
        var color = color_hash[dataset.indexOf(d)][1];
        return color;
      })
      
    legend.selectAll('text')
      .data(dataset)
      .enter()
      .append("text")
	  .attr("x", width - 52)
      .attr("y", function(d, i){ return i *  20 + 9;})
	  .text(function(d) {
        var text = color_hash[dataset.indexOf(d)][0];
        return text;
      });
}

function getScale() {
    // extract the x labels for the axis and scale domain
    if (data.length >= actualData.length)
	{
		xLabels = data.map(function(d) {
            return d['date'];
        });
		xRealLabels = data.map(function(d) {
            return d['date'];
        });
    }
	else
	{        		
		xLabels = actualData.map(function(d) {
            return d['date'];
        });
		xRealLabels = actualData.map(function(d) {
            return d['date'];
        });
    }
	
	var tempo = 0;
	
	if(xRealLabels.length > 7){
		tempo = Math.floor(xRealLabels.length / 8);
		
		for(var i = 1; i < xRealLabels.length; i += (tempo + 1)){			
			for(var j = 0; j < tempo; j++){
				xRealLabels[i + j] = "";
			}
		}
	}
	
	console.log(xRealLabels);
	
    xScale = d3.scale.ordinal()
        .domain(xLabels)
        .rangeRoundPoints([margin.left, width], .1);

    yScale = d3.scale.linear()
        .range([height, 0]);

    var targetMin = 0;
    var targetMax = 0;
    var minMin = 0;
    var minMax = 0;
    var maxMin = 0;
    var maxMax = 0;

    if (data.length > 0) {
        //console.log(data);
        targetMin = Math.round(d3.min(data, function(d) {
            return parseFloat(d['expected']);
        }));
        targetMax = Math.round(d3.max(data, function(d) {
            return parseFloat(d['expected']);
        }));
        minMin = Math.round(d3.min(data, function(d) {
            return parseFloat(d['min']);
        }));
        minMax = Math.round(d3.max(data, function(d) {
            return parseFloat(d['min']);
        }));
        maxMin = Math.round(d3.min(data, function(d) {
            return parseFloat(d['max']);
        }));
        maxMax = Math.round(d3.max(data, function(d) {
            return parseFloat(d['max']);
        }));
    }

    var actMin = 0;
    var actMax = 0;
    if (actualData.length > 0) {
        actMin = Math.round(d3.min(actualData, function(d) {
            return parseFloat(d['value']);
        }));
        actMax = Math.round(d3.max(actualData, function(d) {
            return parseFloat(d['value']);
        }));
    }
    yScale.domain([Math.min(0, targetMin, minMin, maxMin, actMin), Math.max(0, targetMax, minMax, maxMax, actMax)]);
	
}

//I changed here
function drawForecastLine() {

    var line = d3.svg.line()
        .x(function(d) {
            return xScale(d['date']);
        })
        .y(function(d) {
            return yScale(d['expected']);
        });

    var area = d3.svg.area()
        .x(function(d) {
            return xScale(d['date']);
        })
        .y0(function(d) {
            return yScale(d['min']);
        })
        .y1(function(d) {
            return yScale(d['max']);
        });
    var container = svg.append("g").attr("id", "forecast");

    container.append("path")
        .datum(data)
        .attr("class", "line")
        .attr("d", line)
        .attr("style", "fill:none")
        .attr("stroke", "blue")
		.attr("data-legend",function(d) { return d.name})
        .attr("stroke-width", "2");

    container.append("path")
        .datum(data)
        .attr("class", "area")
        .attr("d", area);

    container.selectAll("circle")
        .data(data)
        .enter().append("circle")
        .attr("cx", function(d) {
            return xScale(d['date']);
        })
        .attr("cy", function(d) {
            return yScale(d['expected']);
        })
        .attr("r", 2)
        .attr("style", "fill:white")
        .attr("stroke", "steelblue")
        .attr("stroke-width", "1");

    // x axis label
    container.append("text")
        .attr("x", (width + (margin.left + margin.right)) / 2)
        .attr("y", height + margin.bottom)
        .attr("class", "text-label")
        .attr("text-anchor", "middle")
        .text(getXLabel());

    if (data.length > 1) {
        var xDataLabels = data.map(function(d) {
                return d['date'];
            })
            // get the x and y values for least squares
        var xSeries = d3.range(1, xDataLabels.length + 1);
        var ySeries = data.map(function(d) {
            return parseFloat(d['expected']);
        });

        var leastSquaresCoeff = leastSquares(xSeries, ySeries);

        // apply the reults of the least squares regression
        var x1 = xDataLabels[0];
        var y1 = leastSquaresCoeff[0] + leastSquaresCoeff[1];
        var x2 = xDataLabels[xDataLabels.length - 1];
        var y2 = leastSquaresCoeff[0] * xSeries.length + leastSquaresCoeff[1];
        var trendData = [
            [x1, y1, x2, y2]
        ];

        var trendline = container.selectAll(".trendline")
            .data(trendData);

        trendline.enter()
            .append("line")
            .attr("class", "trendline")
            .attr("x1", function(d) {
                return xScale(d[0]);
            })
            .attr("y1", function(d) {
                return yScale(d[1]);
            })
            .attr("x2", function(d) {
                return xScale(d[2]);
            })
            .attr("y2", function(d) {
                return yScale(d[3]);
            })
            .attr("stroke", "black")
            .attr("stroke-width", 1);

        // display equation on the chart
        container.append("text")
            .text("eq: " + decimalFormat(leastSquaresCoeff[0]) + "x + " +
                decimalFormat(leastSquaresCoeff[1]))
            .attr("class", "text-label")
            .attr("x", function(d) {
                return xScale(x2);
            })
            .attr("y", function(d) {
                return yScale(y2) - 30;
            });

        // display r-square on the chart
        container.append("text")
            .text("r-sq: " + decimalFormat(leastSquaresCoeff[2]))
            .attr("class", "text-label")
            .attr("x", function(d) {
                return xScale(x2);
            })
            .attr("y", function(d) {
                return yScale(y2) - 10;
            });
    }
}

// returns slope, intercept and r-square of the line
function leastSquares(xSeries, ySeries) {
    var reduceSumFunc = function(prev, cur) {
        return prev + cur;
    };

    var xBar = xSeries.reduce(reduceSumFunc) * 1.0 / xSeries.length;
    var yBar = ySeries.reduce(reduceSumFunc) * 1.0 / ySeries.length;

    var ssXX = xSeries.map(function(d) {
            return Math.pow(d - xBar, 2);
        })
        .reduce(reduceSumFunc);

    var ssYY = ySeries.map(function(d) {
            return Math.pow(d - yBar, 2);
        })
        .reduce(reduceSumFunc);

    var ssXY = xSeries.map(function(d, i) {
            return (d - xBar) * (ySeries[i] - yBar);
        })
        .reduce(reduceSumFunc);

    var slope = ssXY / ssXX;
    var intercept = yBar - (xBar * slope);
    var rSquare = Math.pow(ssXY, 2) / (ssXX * ssYY);

    return [slope, intercept, rSquare];
}

// create a table with column headers, types, and data
function create_table() {
    // table stats
    var keys = d3.keys(data[0]);
    d3.select("#stats").remove();
    var stats = d3.select("#stats")
        .html("")

    stats.append("div")
        .text("Columns: " + keys.length)

    stats.append("div")
        .text("Rows: " + data.length)

    d3.select("#table")
        .html("")
        .append("tr")
        .attr("class", "fixed")
        .selectAll("th")
        .data(keys)
        .enter().append("th")
        .text(function(d) {
            return d;
        });

    d3.select("#table")
        .selectAll("tr.row")
        .data(data)
        .enter().append("tr")
        .attr("class", "row")
        .selectAll("td")
        .data(function(d) {
            return keys.map(function(key) {
                return d[key]
            });
        })
        .enter().append("td")
        .text(function(d) {
            return d;
        });
}


//I changed here
function drawActualLine() {

    var container = svg.append("g").attr("class", "actual");
    var line = d3.svg.line()
        .x(function(d) {
            return xScale(d['date']);
        })
        .y(function(d) {
            return yScale(d['value']);
        });
    container.append("path")
        .datum(actualData)
        .attr("class", "line")
        .attr("d", line)
		.attr("data-legend",function(d) { return d.name})
        .attr("style", "fill:none")
        .attr("stroke", function() {
            if (inRange) {
                return "green"
            } else {
                return "red"
            }
        })
        .attr("stroke-width", "2");

    container.selectAll("circle")
        .data(actualData)
        .enter().append("circle")
        .attr("cx", function(d) {
            return xScale(d['date']);
        })
        .attr("cy", function(d, i) {
            return yScale(d['value']);
        })
        .attr("r", 2)
        .attr("style", "fill:white")
        .attr("stroke", function() {
            if (inRange) {
                return "green"
            } else {
                return "red"
            }
        })
        .attr("stroke-width", "1");
}

function addActualData() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var dataStr = xhttp.responseText;
            console.log(dataStr);
            jsonObj = JSON.parse(dataStr)
            actualValues = jsonObj.values;
			actualDates = jsonObj.dates;
            inRange = jsonObj.flag;
            actualData = [];
            for (var i = 0; i < actualValues.length; i++) {
                actualData.push({
                    "index": (i + 1),
                    "value": actualValues[i],
					"date": actualDates[i]
                });
            }
            console.log(actualValues + ", " + inRange + ", " + actualDates)
            render();
        }
    }
	var product_id = product.split(".")[0];
	
    xhttp.open("GET", "alert/data.php?product_id=" + product_id, true);
    xhttp.send();
}

function addForecastByPoint() {
    if (adding == "csv") {
        adding = "point";
        data = [];
    }
    
	var min = Number(document.getElementById('min').value);
    var max = Number(document.getElementById('max').value);
    var expected = Number(document.getElementById('expected').value);
	
    if (min > max) {
        var tmp = min;
        min = max;
        max = tmp;
    }
    var obj = {
        'index': data.length + 1,
        'expected': expected,
        'min': min,
        'max': max
    };
    
	data.push(obj);
    document.getElementById('expected').value = "";
    document.getElementById('min').value = "";
    document.getElementById('max').value = "";
	
    console.log("forecast added");
    render();
    create_table();
}

// handle upload button
function upload_button(el) {
    var uploader = document.getElementById(el);
    var reader = new FileReader();

    reader.onload = function(e) {
        var contents = e.target.result;
        if (adding == "point") {
            adding = "csv";
        }
        data = d3.csv.parse(contents)
        for (var i = 0; i < data.length; i++) {
            data[i].index = i + 1;
        }
        create_table(data);
        render();
    };

    uploader.addEventListener("change", handleFiles, false);

    function handleFiles() {
        d3.select("#table").text("loading...");
        var file = this.files[0];
        reader.readAsText(file);
    };
};

function init() {

    d3.select("#chart").select("svg").select(".actual").remove();
    svg = d3.select("#chart").append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom);
    //.attr("transform", "translate(" + (margin.left) + "," + margin.top + ")");

    upload_button("uploader");
}

init();
