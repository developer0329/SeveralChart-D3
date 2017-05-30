
// The function is called every time when an order comes in or an order gets processed
// The current order queue is stored in the variable 'orders'

var width = 600, height = 200;
var datas = [];

var svg = d3.select("#chart-area").append("svg")
		 .attr("width", width)
		 .attr("height", height);
var text = svg.append("text")
    .attr("x", 50)
    .attr("y", 80)
    .attr("dy", ".35em");
function updateVisualization(orders) {
	console.log(orders);

	// Data-join (circle now contains the update selection)

	text.text("Orders:" + orders.length);

	var circle = svg.selectAll("circle").data(orders);

	// Enter (initialize the newly added elements)
	circle.enter().append("circle")
		.attr("class", "dot")
		.attr("fill", function(d) {
			if(d.product == "coffee")
			{
				return "#432a2a";
			}
			else // tea
			{
				return "#68d581";
			}
			
		}); 

	// Update (set the dynamic properties of the elements)
	circle
	 	.attr("r", 10)
	 	.attr("cx", function(d, index) { return (index * 30) + 150 })
	 	.attr("cy", 80);

	// Exit
	circle.exit().remove();
}
