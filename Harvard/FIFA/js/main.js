
	// SVG drawing area
	var tooltip = d3.select("body")
		.append("div")
		.style("position", "absolute")
		.style("z-index", "10")
		.style("visibility", "hidden")
		.text("a simple tooltip");
	
	var detail = d3.select("#detail-view")
			.style("width", "250px")
		    .style("position", "absolute")
		    .style("left", "750px")
		    .style("top", "150px")
		    .style("padding", "5px")
			.text("");

	var margin = {top: 40, right: 40, bottom: 60, left: 60};

	var width = 600 - margin.left - margin.right,
		height = 400 - margin.top - margin.bottom;

	var svg = d3.select("#chart-area").append("svg")
			.attr("width", width + margin.left + margin.right)
			.attr("height", height + margin.top + margin.bottom)
		.append("g")
			.attr("transform", "translate(" + margin.left + "," + margin.top + ")");


	// Date parser (https://github.com/mbostock/d3/wiki/Time-Formatting)
	var formatDate = d3.time.format("%Y");

	//Set the range
	var x = d3.time.scale().range([0, width]);
	var y = d3.scale.linear().range([height,0]);

	//Define the axes
	var xAxis = d3.svg.axis().scale(x).orient("bottom").ticks(5);
	var yAxis = d3.svg.axis().scale(y).orient("left").ticks(5);

	var line =  d3.svg.line()
				.interpolate(
					//"linear"
					"cardinal"
					)
				.x(function(d){ return x(d.YEAR); })
				.y(function(d){ return y(d.GOALS); });


	// Initialize data
	loadData();

	// FIFA world cup
	var data, init_data;


	// Load CSV file
	function loadData() {
		d3.csv("data/fifa-world-cup.csv", function(error, csv) {

			csv.forEach(function(d){
				// Convert string to 'date object'
				d.YEAR = formatDate.parse(d.YEAR);
				
				// Convert numeric values to 'numbers'
				d.TEAMS = +d.TEAMS;
				d.MATCHES = +d.MATCHES;
				d.GOALS = +d.GOALS;
				d.AVERAGE_GOALS = +d.AVERAGE_GOALS;
				d.AVERAGE_ATTENDANCE = +d.AVERAGE_ATTENDANCE;
			});

			// Store csv data in global variable
			data = csv;
			init_data = data;
			// Draw the visualization for the first time
			updateVisualization();
		});
	}

	// Render visualization
	function updateVisualization() {
		
		console.log(data);
		// Scale the range of the data
		x.domain(d3.extent(data, function(d) { return d.YEAR; }));
		y.domain([0, d3.max(data, function(d) { return d.GOALS; })]);

		// Add the valueline path.
		svg.append("path")		
			.attr("class", "line")
			.attr("d", line(data));

	// draw the scatterplot
		svg.selectAll(".dot")									// provides a suitable grouping for the svg elements that will be added
			.data(data)											// associates the range of data to the group of elements
		.enter().append("circle")								// adds a circle for each data point
			.attr("class", "dot")
			.attr("r", 7)										// with a radius of 3.5 pixels
			.attr("cx", function(d) { return x(d.YEAR); })		// at an appropriate x coordinate 
			.attr("cy", function(d) { return y(d.GOALS); }) 	// and an appropriate y coordinate
	    .on("mouseover", function(d){
	        tooltip.html(d.EDITION + "<br/>" + "Goals: " + d.GOALS );
	        return tooltip.style("visibility", "visible");
	        })
	    .on("mousemove", function(){
	    	return tooltip.style("top", (event.pageY-10)+"px")
	    				  .style("left",(event.pageX+10)+"px")
	    				  .style("border", "1px solid black")
	    				  .style("padding", "10px");})
	    .on("mouseout", function(){return tooltip.style("visibility", "hidden");})
	    .on("click",  showEdition);


		// Add the X Axis
		svg.append("g")			// Add the X Axis
			.attr("class", "x axis")
			.attr("transform", "translate(0," + height + ")")
			.call(xAxis);

		// Add the Y Axis
		svg.append("g")			// Add the Y Axis
			.attr("class", "y axis")
			.call(yAxis)
			.append("text")
	    	.attr("id", "Y-Anchor")
	      	.attr("transform", "rotate(0)")
	      	.attr("y", -6)
	      	.attr("dy", ".1em")
	      	.style("text-anchor", "end")
	      	.text("Goals");

	}

	var dType = "goals";
	d3.select("#data-type").on("change", function() {
		dType = this.value;
		update();
	});

	function update(){
		x.domain(d3.extent(data, function(d) { return d.YEAR; }));
		y.domain([0, d3.max(data, function(d) {
			if(dType == "goals") return d.GOALS;
			if(dType == "average_goals") return d.AVERAGE_GOALS;
			if(dType == "matches") return d.MATCHES;
			if(dType == "teams") return d.TEAMS;
			if(dType == "average_attendance") return d.AVERAGE_ATTENDANCE;
		})]);



		var dot = svg.selectAll(".dot").data(data);
			//dot.exit().remove();
			dot.attr("class", "dot")
				.attr("r", 7)
				.transition().duration(800).ease("linear")
				.attr("cx", function(d) { return x(d.YEAR); })
				.attr("class", function(d) {
					var group = x(d.YEAR);
	                if(group < 0)
						return "dot hidden";
					else
						return "dot visible";
	              })
				.attr("cy", function(d) {
					if(dType == "goals") return y(d.GOALS);
					if(dType == "average_goals") return y(d.AVERAGE_GOALS);
					if(dType == "matches") return y(d.MATCHES);
					if(dType == "teams") return y(d.TEAMS);
					if(dType == "average_attendance") return y(d.AVERAGE_ATTENDANCE); 
				});
			
		var path = svg.selectAll("path");
			path.remove();

		line =  d3.svg.line()
				.interpolate(
					//"linear"
					"cardinal"
					)
				.x(function(d){ return x(d.YEAR); })
				.y(function(d){
					if(dType == "goals") return y(d.GOALS);
					if(dType == "average_goals") return y(d.AVERAGE_GOALS);
					if(dType == "matches") return y(d.MATCHES);
					if(dType == "teams") return y(d.TEAMS);
					if(dType == "average_attendance") return y(d.AVERAGE_ATTENDANCE); 
				});

		svg.append("path")		
				.attr("class", "line")
				.transition().duration(800).ease("linear")
				.attr("d", line(data));


		if(dType == "goals") svg.select("#Y-Anchor").text("Goals");
		if(dType == "average_goals") svg.select("#Y-Anchor").text("Ave Goals");
		if(dType == "matches") svg.select("#Y-Anchor").text("Matches");
		if(dType == "teams") svg.select("#Y-Anchor").text("Teams");
		if(dType == "average_attendance") svg.select("#Y-Anchor").text("Attendance");

		svg.select(".y.axis").transition().duration(800).ease("linear").call(yAxis);
		svg.select(".x.axis").transition().duration(800).ease("linear").call(xAxis);
	}

	d3.select("#filter_btn").on("click", function() {

		var start = formatDate.parse(document.getElementById("start_time").value);
		var end = formatDate.parse(document.getElementById("end_time").value);
		
		d3.csv("data/fifa-world-cup.csv", function(error, csv) {

			csv.forEach(function(d){
				// Convert string to 'date object'
				d.YEAR = formatDate.parse(d.YEAR);
				
				// Convert numeric values to 'numbers'
				d.TEAMS = +d.TEAMS;
				d.MATCHES = +d.MATCHES;
				d.GOALS = +d.GOALS;
				d.AVERAGE_GOALS = +d.AVERAGE_GOALS;
				d.AVERAGE_ATTENDANCE = +d.AVERAGE_ATTENDANCE;
			});

			data = csv;

			data = init_data.filter(function(d) {
				if(start == null && end == null) return d.YEAR; 
				if(start != null && end != null) return d.YEAR > start && d.YEAR < end;
				if(start != null && end == null) return d.YEAR > start;
				if(start == null && end == null) return d.YEAR < end;
		      
		    })

		    // Scale the range of the data again 
	    	x.domain(d3.extent(data, function(d) { return d.YEAR; }));
		    y.domain([0, d3.max(data, function(d) {
		    	if(dType == "goals") return d.GOALS;
				if(dType == "average_goals") return d.AVERAGE_GOALS;
				if(dType == "matches") return d.MATCHES;
				if(dType == "teams") return d.TEAMS;
				if(dType == "average_attendance") return d.AVERAGE_ATTENDANCE;
		    })]);

		    // Select the section we want to apply our changes to
		    var svg = d3.select("#chart-area").transition();

		    svg.selectAll(".line")		
				.transition().duration(800).ease("linear")
				.attr("d", line(data));

		    // Make the changes
	        var dot = svg.selectAll(".dot");

	            dot.attr("r", 7)
					.transition().duration(800).ease("linear")
					.attr("class", function(d) {
						var group = x(d.YEAR);
						if(group < 0)
							return "dot hidden";
						else
							return "dot visible";
		              })
					.attr("cx", function(d) { return x(d.YEAR); })
					.attr("cy", function(d) {
						if(dType == "goals") return y(d.GOALS);
						if(dType == "average_goals") return y(d.AVERAGE_GOALS);
						if(dType == "matches") return y(d.MATCHES);
						if(dType == "teams") return y(d.TEAMS);
						if(dType == "average_attendance") return y(d.AVERAGE_ATTENDANCE); 
					});

	        svg.select(".x.axis").duration(750).call(xAxis);
	        svg.select(".y.axis").duration(750).call(yAxis);


		});

	});

	// Show details for a specific FIFA World Cup
	function showEdition(d){

    	detail.html(
    		"<h5 style='margin:0px;'>" + d.EDITION + "</h5><br/>" +
    		"<strong>Winner: </strong>" + d.TEAMS + "<br/>" + 
    		"<strong>Goals: </strong>" + d.GOALS + "<br/>" + 
    		"<strong>Ave Goals: </strong>" + d.AVERAGE_GOALS + "<br/>" + 
    		"<strong>Matches: </strong>" + d.MATCHES + "<br/>" + 
    		"<strong>AVe Atten: </strong>" + d.AVERAGE_ATTENDANCE
		);
    	return detail.style("border", "1px solid black");
	}
