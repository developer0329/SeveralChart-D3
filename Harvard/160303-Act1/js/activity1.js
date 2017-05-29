
	var width = 400, height = 400;
    var color = d3.scale.category10();//generates a range of ten colours

    //create the containing svg
    var svg = d3.select("#chart-area").append("svg")
		.attr("width", width)
		.attr("height", height);


	// 1) INITIALIZE FORCE-LAYOUT
	var force = d3.layout.force()
            .charge(-100)//like an electrical charge. Nevative values repel, positive values attract
            .linkDistance(100)//distance between nodes - d3 won't use it strictly as it considers other factors
            .size([width, height]);

	// Load data
	d3.json("data/airports.json", function(data) {
	
		force.nodes(data.nodes)
            .links(data.links)
			.on("tick", tick)
            .start();
			
		// 2a) DEFINE 'NODES' AND 'EDGES'
		var link = svg.selectAll(".link")
            .data(data.links)
            .enter().append("line")
            .attr("class", "link")
            .style("stroke-width", function(d) {
				var dd = 0;
				return Math.sqrt(d.value);
				});
			
		var node = svg.selectAll(".node")
            .data(data.nodes)
            .enter().append("g")
            .attr("class", "node")
			.on("mouseover", function(d){
				var g = d3.select(this);
			
				g.append("text")
					.classed("info", true)
					.attr("x", 12)
					.attr("dy", ".35em")
					.text(function(d) { return d.name; });
			})
			.on("mouseout", function(){
				d3.select(this).select('text.info').remove();
			})
            .call(force.drag);//select a colour using the node's id as an index
			
		node.append("circle")
			.attr("r", 10)
            .style("fill", function(d) {
				if(d.country == "United States")
					return "blue";
				else
					return "red";
				//return color(d.id);
			});
			
		
		
		
		// 2b) START RUNNING THE SIMULATION
		// 3) DRAW THE LINKS (SVG LINE)
		// 4) DRAW THE NODES (SVG CIRCLE)
		
		// 5) LISTEN TO THE 'TICK' EVENT AND UPDATE THE X/Y COORDINATES FOR ALL ELEMENTS
		function tick() {
			link.attr("x1", function(d) { return d.source.x; })
				.attr("y1", function(d) { return d.source.y; })
				.attr("x2", function(d) { return d.target.x; })
				.attr("y2", function(d) { return d.target.y; });

			node.attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });;
		};
		

	});
