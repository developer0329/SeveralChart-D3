<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Download Repair Market Information</title>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="https://d3js.org/d3.v3.min.js"></script>
		<script src="https://d3js.org/topojson.v1.min.js"></script>
		<script src="https://d3js.org/queue.v1.min.js"></script>
		
	</head>
	<body>
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3" id="figure1">
				<div style="padding:10px; text-align:center;">The market potential of your area is AAAA €. There are already CC companies like yours on this market. Which mean the theorical share for each is : (AAAA /(CC)</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6" id="figure2">
				<div style="padding:10px; text-align:center;">Your market potential ranking in the country and the average</div>
			</div>
			<div class="col-sm-6" id="figure3">
				<div style="padding:10px; text-align:center;">Your competition level ranking in the country and the average</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6" id="figure4">
				<div style="padding:10px; text-align:center;">The geographic distribution of your market potential</div>
			</div>
			<div class="col-sm-6" id="figure5">
				<div style="padding:10px; text-align:center;">The geographic distribution of your competitors</div>
			</div>
		</div>
	<script>
		var dept_code_string;
		var dept_code;
		
		function cleanArray(actual) {
			var newArray = new Array();
			for (var i = 0; i < actual.length; i++) {
				if (actual[i]) {
					newArray.push(actual[i]);
				}
			}
			return newArray;
		}
		
		function getParameterByName(name, url) {
			if (!url) url = window.location.href;
			name = name.replace(/[\[\]]/g, "\\$&");
			var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
				results = regex.exec(url);
			if (!results) return null;
			if (!results[2]) return '';			
			
			$.get("enc_dec.php", { data: results[2] }, function(result){
				dept_code_string = decodeURIComponent(result.replace(/\+/g, " "));
				dept_code = cleanArray(dept_code_string.split(","));
				draw();
			});
						
			
		}
		
		//var dept_code_string = getParameterByName('data');
		//var dept_code = cleanArray(dept_code_string.split(","));
		
		var fixed_param = 470;
		var bar_width = 55;
		var data_num = 10;
					
		var margin = {top: 10, right: 20, bottom: 80, left: 80},
			width = bar_width * data_num - margin.left - margin.right,
			height = 400 - margin.top - margin.bottom;
		
		var x = d3.scale.ordinal().rangeRoundBands([0, width], .1, .3);
		var x3 = d3.scale.ordinal().rangeRoundBands([0, width], .1, .3);
		
		var y = d3.scale.linear().range([height, 0]);
		var y3 = d3.scale.linear().range([height, 0]);
		
		var xAxis = d3.svg.axis().scale(x).orient("bottom");
		var xAxis3 = d3.svg.axis().scale(x3).orient("bottom");
		
		var yAxis = d3.svg.axis().scale(y).orient("left").ticks(10, "€");
		var yAxis3 = d3.svg.axis().scale(y3).orient("left").ticks(10);
			  
		var svg2 = d3.select("#figure2").append("svg")
			.attr("width", width + margin.left + margin.right)
			.attr("height", height + margin.top + margin.bottom)
		  .append("g")
			.attr("transform", "translate(" + margin.left + "," + margin.top + ")");
		
		var svg3 = d3.select("#figure3").append("svg")
			.attr("width", width + margin.left + margin.right)
			.attr("height", height + margin.top + margin.bottom)
		  .append("g")
			.attr("transform", "translate(" + margin.left + "," + margin.top + ")");
		
		var w  = 500, h = 500;
		
		var svg1 = d3.select("#figure1").append("svg")
			.attr("width", w)
			.attr("height", h)
			.attr("id", "figure1-svg"); 
			
		var svg4 = d3.select("#figure4").append("svg")
			.attr("width", w)
			.attr("height", h)
			.attr("id", "figure4-svg");  
		
		var svg5 = d3.select("#figure5").append("svg")
			.attr("width", w)
			.attr("height", h)
			.attr("id", "figure5-svg"); 
			
		var dept_name = ['', '', '', '', '', '', '', '', '', ''];
		function draw()
		{
			
		
		d3.csv("data/departments.csv", type, function(error, data) {
			if (error) throw error;
			
			data = data.filter(
				function(d, i){
					var code = d['Code département'];
					
					if(code == dept_code[0]){
						dept_name[0] = d['Nom du département']
						return d;
					}
					if(code == dept_code[1]){
						dept_name[1] = d['Nom du département']
						return d;
					}
					if(code == dept_code[2]){
						dept_name[2] = d['Nom du département']
						return d;
					}
					if(code == dept_code[3]){
						dept_name[3] = d['Nom du département']
						return d;
					}
					if(code == dept_code[4]){
						dept_name[4] = d['Nom du département']
						return d;
					}
					if(code == dept_code[5]){
						dept_name[5] = d['Nom du département']
						return d;
					}
					if(code == dept_code[6]){
						dept_name[6] = d['Nom du département']
						return d;
					}
					if(code == dept_code[7]){
						dept_name[7] = d['Nom du département']
						return d;
					}
					if(code == dept_code[8]){
						dept_name[8] = d['Nom du département']
						return d;
					}
					if(code == dept_code[9]){
						dept_name[9] = d['Nom du département']
						return d;
					}
				}
			);
						
			data.sort(function(a, b) {
				return parseFloat(a['Population totale']) - parseFloat(b['Population totale']);
			});

			x.domain(data.map(function(d) { return d['Nom du département']; }));
			y.domain([0, d3.max(data, function(d) { return d['Population totale']; })]);

			svg2.append("g")
			  .attr("class", "x axis")
			  .attr("transform", "translate(0," + height + ")")
			  .call(xAxis)
			.selectAll(".tick text")
				.call(wrap, x.rangeBand());

			svg2.append("g")
				.attr("class", "y axis")
				.call(yAxis)
				.append("text")
				.attr("transform", "rotate(-90)")
				.attr("y", 6)
				.attr("dy", ".71em")
				.style("text-anchor", "end")
				.text("Market Potentials(€)");
				
			svg2.selectAll(".bar")
			  .data(data)
			.enter().append("rect")
			  .attr("class", "bar")
			  .attr("x", function(d) { return x(d['Nom du département']); })
			  .attr("width", x.rangeBand())
			  .attr("y", function(d) { return y(d['Population totale']); })
			  .attr("height", function(d) { return height - y(d['Population totale']); })
			  .on("mouseover", function(d) {					
					div.transition()        
						.duration(200)      
						.style("opacity", .9);      
					div.html("Département : " + d['Nom du département'] + "<br/>"
							+  "Région : " + d['Nom de la région'] + "<br/>"
							+  "Code : " + d['Code département']
						  )  
						.style("left", (d3.event.pageX) + "px")     
						.style("top", (d3.event.pageY - 30) + "px")
				})
				.on("mouseout", function(d) {
					div.transition()
						.duration(500)
						.style("opacity", 0);
					div.html("")
						.style("left", "0px")
						.style("top", "0px");
				});
		});
		
		d3.csv("data/garages.csv", function(error, data) {
			
			var count = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
			
			data = data.filter(				
				function(d, i){
					var dept = d['code postal'].substring(0, d['code postal'].length-3);
					
					if( dept == dept_code[0])
					{
						count[0]++;
						return d;
					}
					
					if(dept == dept_code[1]){
						count[1]++;
						return d;
					}
					if(dept == dept_code[2]){
						count[2]++;
						return d;
					}
					if(dept == dept_code[3]){
						count[3]++;
						return d;
					}
					if(dept == dept_code[4]){
						count[4]++;
						return d;
					}
					if(dept == dept_code[5]){
						count[5]++;
						return d;
					}
					if(dept == dept_code[6]){
						count[6]++;
						return d;
					}
					if(dept == dept_code[7]){
						count[7]++;
						return d;
					}
					if(dept == dept_code[8]){
						count[8]++;
						return d;
					}
					if(dept == dept_code[9]){
						count[9]++;
						return d;
					}
					
				}
			)
			
			var data3 = [];
			for(var i = 0; i < 10; i++)
			{
				data3.push({ "dept" : dept_name[i], "count" : count[i], "code" : dept_code[i] })
			}
			
			data3.sort(function(a, b) {
				return parseFloat(a.count) - parseFloat(b.count);
			});

			x3.domain(data3.map(function(d) { return d.dept; }));
			y3.domain([0, d3.max(data3, function(d) { return d.count; })]);

			svg3.append("g")
			  .attr("class", "x axis")
			  .attr("transform", "translate(0," + height + ")")
			  .call(xAxis3)
			.selectAll(".tick text")
				.call(wrap, x3.rangeBand());

			svg3.append("g")
				.attr("class", "y axis")
				.call(yAxis3)
				.append("text")
				.attr("transform", "rotate(-90)")
				.attr("y", 6)
				.attr("dy", ".71em")
				.style("text-anchor", "end")
				.text("Companies");
				
			svg3.selectAll(".bar")
			  .data(data3)
			.enter().append("rect")
				.attr("class", "bar")
				.attr("x", function(d) { return x3(d.dept); })
				.attr("width", x3.rangeBand())
				.attr("y", function(d) { return y3(d.count); })
				.attr("height", function(d) { return height - y3(d.count); })
				.on("mouseover", function(d) {					
					div.transition()        
						.duration(200)      
						.style("opacity", .9);      
					div.html("Département : " + d.dept + "<br/>"
							+  "Count : " + d.count + "<br/>"
							+  "Code : " + d.code
						  )  
						.style("left", (d3.event.pageX) + "px")     
						.style("top", (d3.event.pageY - 30) + "px")
					})
				.on("mouseout", function(d) {
					div.transition()
						.duration(500)
						.style("opacity", 0);
					div.html("")
						.style("left", "0px")
						.style("top", "0px");
				});
					
			console.log("Figure3 OK");
		})
		
		queue()
			.defer(d3.json, 'data/departments.json')
			.defer(d3.csv, 'data/communes_gps.csv')
			.defer(d3.csv, 'data/commune.csv')
			.defer(d3.csv, 'data/garages.csv')
			.await(drawFigure45);
			
		function drawFigure45(error, departments, communes_gps, commune, garages) {
			
			if (error) throw error;
			
			departments.features = departments.features.filter(
				function(d){
					return d.properties.CODE_DEPT == dept_code[0];
				}
			);
			
			var center = d3.geo.centroid(departments)
			var scale  = 300;
			var offset = [w / 2, h / 2];
			var projection = d3.geo.mercator().scale(scale).center(center).translate(offset);
			// create the path
			var path = d3.geo.path().projection(projection);

			// using the path determine the bounds of the current map and use 
			// these to determine better values for the scale and translation
			var bounds  = path.bounds(departments);
			var hscale  = scale * w  / (bounds[1][0] - bounds[0][0]);
			var vscale  = scale * h  / (bounds[1][1] - bounds[0][1]);
			var scale   = (hscale < vscale) ? hscale : vscale;
			var offset  = [w - (bounds[0][0] + bounds[1][0])/2, h - (bounds[0][1] + bounds[1][1])/2 + 15];

			// new projection
			projection = d3.geo.mercator()
				.center(center)
				.scale(scale).translate(offset);
			
			path = path.projection(projection);

			svg1.selectAll("path")
				.data(departments.features)
				.enter()
				.append("path")
				.attr("d", path);
				
			svg4.selectAll("path")
				.data(departments.features)
				.enter()
				.append("path")
				.attr("d", path);
			
			svg5.selectAll("path")
				.data(departments.features)
				.enter()
				.append("path")
				.attr("d", path);
			
			commune = commune.filter(
				function(d, i){
					var code = d['Code département'];					
					if(code == dept_code[0]){
						return d;
					}
				}
			);
			
			
			communes_gps = communes_gps.filter(
				function(d, i){
					var code = d['code_insee'].substring(0, d['code_insee'].length - 3);
					
					if(code == dept_code[0]){
						return d;
					}
				}
			);
			
			garages = garages.filter(				
				function(d, i){
					var dept = d['code postal'].substring(0, d['code postal'].length - 3);
					
					if( dept == dept_code[0])
					{
						return d;
					}
				}
			);
			
			for(var i = 0; i < commune.length; i++)
			{
				var code_postal = commune[i]['Code département'] + commune[i]['Code commune'];
				
				var companies = garages.filter(				
					function(d){
						return d['code postal'] == code_postal;
					}
				);
				
				commune[i].companies = companies.length;
			}
					
			var mapData = [];
			for(var i = 0; i < commune.length; i++)
			{
				var gps = communes_gps.filter(
					function(d){
						if(d.code_insee == (commune[i]['Code département']+commune[i]['Code commune']))
						{
							return d;
						};
					}
				);
				var object = $.extend({}, commune[i], gps[0]);
				mapData.push(object);
			}
			
			var node1 = d3.select("#figure1-svg").selectAll("g")
					.data(mapData)
					.enter().append("g")
					.attr("transform", function(d) { 
						return "translate(" + projection([+d.longitude, +d.latitude]) + ")"; 
					})
					.attr("id", function(d){
						return "svg1-" + d.code_insee;
					});
			var color1 = d3.scale.threshold()
					.domain([10, 50, 100, 250, 500, 1000, 2000, 5000, 10000, 15000])
					.range(["#01D015", "#16BB14", "#2BA713", "#419213", "#567E12", "#6C6A12", "#815511", "#964110", "#AC2C10", "#C1180F", "#D7040F"]);
					
			node1.append("circle")                       
				.attr("id", function(d){ return d.id;})
				.attr("class", "node")
				.attr('fill',function(d) {
						var companies;
						if(d['companies'] == 0)
							companies = 1;
						else
							companies = d['companies'];
						
						return color1(d['Population totale']* fixed_param/companies);
					}
				)
				.attr('opacity',0.6)
				.attr('r', function(d) {
					var companies;
					if(d['companies'] == 0)
						companies = 1;
					else
						companies = d['companies'];
							
					return Math.sqrt(+d['Population totale']/(15*companies));}
				)
				.on("mouseover", function(d) {
					
					div.transition()        
						.duration(200)      
						.style("opacity", .9);      
					div.html(" City Name : " + d['Nom de la commune'] + "<br/>"
							+  "Région : " + d['nom_région'] + "<br/>"
							+  "Population : " + d['Population totale'] + "<br/>"
							+  "Companies : " + d['companies'] + "<br/>"
							+  "Market Potentials : " + (d['Population totale']* fixed_param)
						  )  
						.style("left", (d3.event.pageX) + "px")     
						.style("top", (d3.event.pageY - 30) + "px")
				})
				.on("mouseout", function(d) {
					div.transition()
						.duration(500)
						.style("opacity", 0);
					div.html("")
						.style("left", "0px")
						.style("top", "0px");
				});
				
			node1.append("text")
					.attr("dx", 12)
					.attr("dy", ".35em")
					.text(function(d) {
						if(d['companies'] != 0)
							return d['Code commune'];
						else
							return "";
					});
					
			var node4 = d3.select("#figure4-svg").selectAll("g")
					.data(mapData)
					.enter().append("g")
					.attr("transform", function(d) { 
						return "translate(" + projection([+d.longitude, +d.latitude]) + ")"; 
					})
					.attr("id", function(d){
						return "svg4-" + d.code_insee;
					});
			
			var color4 = d3.scale.threshold()
					.domain([100, 200, 300, 500, 1500, 2000, 4000, 8000, 10000, 15000])
					.range(["#01D015", "#16BB14", "#2BA713", "#419213", "#567E12", "#6C6A12", "#815511", "#964110", "#AC2C10", "#C1180F", "#D7040F"]);

				   
			node4.append("circle")                       
				.attr("id", function(d){ return d.id;})
				.attr("class", "node")
				.attr('fill',function(d) {
						return color4(+d['Population totale']);
					}
				)
				.attr('opacity',0.6)
				.attr('r', function(d) {
					return Math.sqrt(+d['Population totale']/15);}
				)
				.on("mouseover", function(d) {					
					div.transition()        
						.duration(200)      
						.style("opacity", .9);      
					div.html(" City Name : " + d['Nom de la commune'] + "<br/>"
							+  "Région : " + d['nom_région'] + "<br/>"
							+  "Market Potentials : " + (d['Population totale']* fixed_param) + "€" 
						  )  
						.style("left", (d3.event.pageX) + "px")     
						.style("top", (d3.event.pageY - 30) + "px")
				})
				.on("mouseout", function(d) {
					div.transition()
						.duration(500)
						.style("opacity", 0);
					div.html("")
						.style("left", "0px")
						.style("top", "0px");
				});
				
			node4.append("text")
					.attr("dx", 12)
					.attr("dy", ".35em")
					.text(function(d) {
						if(d['companies'] != 0)
							return d['Code commune'];
						else
							return "";
					});
			
			var node5 = d3.select("#figure5-svg").selectAll("g")
					.data(mapData)
					.enter().append("g")
					.attr("transform", function(d) { 
						return "translate(" + projection([+d.longitude, +d.latitude]) + ")";
					})
					.attr("id", function(d){
						return "svg5-" + d.code_insee;
					});
			
			var color5 = d3.scale.threshold()
					.domain([2, 4, 8, 15, 30])
					.range(["#61ff96","#4fde78","#3ebe5b","#2c9d3e","#1b7d21"]);

				   
			node5.append("circle")                       
				.attr("id", function(d){ return d.id;})
				.attr("class", "node")
				.attr('fill',function(d) {
						return color5(+d['companies']);
					}
				)
				.attr('opacity',0.6)
				.attr('r', function(d) {
					console.log(d['companies']);
					return d['companies']*3;}
				)
				.on("mouseover", function(d) {					
					div.transition()        
						.duration(200)      
						.style("opacity", .9);      
					div.html("Région : " + d['nom_région'] + "<br/>"
							+  "City : " + d['Nom de la commune'] + "<br/>"
							+  "Companies : " + d['companies']
						  )  
						.style("left", (d3.event.pageX) + "px")     
						.style("top", (d3.event.pageY - 30) + "px")
				})
				.on("mouseout", function(d) {
					div.transition()
						.duration(500)
						.style("opacity", 0);
					div.html("")
						.style("left", "0px")
						.style("top", "0px");
				});
			
			node5.append("text")
				.attr("dx", 12)
				.attr("dy", ".35em")
				.text(function(d) {
					if(d['companies'] != 0)
						return d['Code commune'];
					else
						return "";
				});
		
		}		
	
		
		function wrap(text, width) {
		  text.each(function() {
			var text = d3.select(this),
				words = text.text().split(/[\s-]+/).reverse(),
				word,
				line = [],
				lineNumber = 0,
				lineHeight = 1.1, // ems
				y = text.attr("y"),
				dy = parseFloat(text.attr("dy")),
				tspan = text.text(null).append("tspan").attr("x", 0).attr("y", y).attr("dy", dy + "em");
				
				while (word = words.pop()) {
					line.push(word);
					tspan.text(line.join(" "));
					if (tspan.node().getComputedTextLength() > width) {
						line.pop();
						tspan.text(line.join(" "));
						line = [word];
						tspan = text.append("tspan").attr("x", 0).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
					}
				}
		  });
		}

		function type(d) {
			d['Population totale'] = +d['Population totale'] * fixed_param;
			return d;
		}
		
		// Append a DIV for the tooltip
		var div = d3.select("body").append("div")   
			.attr("class", "bar-tooltip")               
			.style("opacity", 0);
		
		}
		
		getParameterByName('data');
		
	</script>