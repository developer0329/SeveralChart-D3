
var detail_m = {top: 0, right: 0, bottom: 0, left: 0},
    detail_w = 100 - detail_m.left - detail_m.right,
    detail_h = 70 - detail_m.top - detail_m.bottom;

var parseDate = d3.time.format("%d-%b-%y").parse;

var detail_x = d3.time.scale().range([0, detail_w]);
var detail_y = d3.scale.linear().range([detail_h, 0]);

var detail_xAxis = d3.svg.axis()
    .scale(detail_x)
    .orient("bottom")
    .ticks(5);

var detail_yAxis = d3.svg.axis()
    .scale(detail_y)
    .orient("left")
    .ticks(5);

var area = d3.svg.area()
    .x(function(d) { return detail_x(d.date); })
    .y0(detail_h)
    .y1(function(d) { return detail_y(d.close); });

var valueline = d3.svg.line()
    .x(function(d) { return detail_x(d.date); })
    .y(function(d) { return detail_y(d.close); });
    
var svgDetail = d3.select("#tooltip-chart")
    .append("svg")
        .attr("width", detail_w + detail_m.left + detail_m.right)
        .attr("height", detail_h + detail_m.top + detail_m.bottom)
    .append("g")
        .attr("transform", 
              "translate(" + detail_m.left + "," + detail_m.top + ")");

// function for the x grid lines
function make_x_axis() {
    return d3.svg.axis()
        .scale(detail_x)
        .orient("bottom")
        .ticks(5)
}

// function for the y grid lines
function make_y_axis() {
  return d3.svg.axis()
      .scale(detail_y)
      .orient("left")
      .ticks(5)
}

// Get the data
d3.csv("data/data.csv", function(error, data) {
    data.forEach(function(d) {
        d.date = parseDate(d.date);
        d.close = +d.close;
    });

    // Scale the range of the data
    detail_x.domain(d3.extent(data, function(d) { return d.date; }));
    detail_y.domain([0, d3.max(data, function(d) { return d.close; })]);

    // Add the filled area
    svgDetail.append("path")
        .datum(data)
        .attr("class", "area")
        .attr("d", area);

    // Draw the x Grid lines
    svgDetail.append("g")
        .attr("class", "grid")
        .attr("transform", "translate(0," + detail_h + ")")
        .call(make_x_axis()
            .tickSize(-detail_h, 0, 0)
            .tickFormat("")
        )

    // Draw the y Grid lines
    svgDetail.append("g")            
        .attr("class", "grid")
        .call(make_y_axis()
            .tickSize(-detail_w, 0, 0)
            .tickFormat("")
        )

    // Add the valueline path.
    svgDetail.append("path")
        .attr("d", valueline(data));

    // Add the X Axis
    svgDetail.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + detail_h + ")")
        .call(detail_xAxis);

    // Add the Y Axis
    svgDetail.append("g")
        .attr("class", "y axis")
        .call(detail_yAxis);

    // Add the text label for the X axis
    svgDetail.append("text")
        .attr("transform",
              "translate(" + (detail_w/2) + " ," + 
                             (detail_h+detail_m.bottom) + ")")
        .style("text-anchor", "middle")
        .text("Date");

    // Add the white background to the y axis label for legibility
    svgDetail.append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 6)
        .attr("x", detail_m.top - (detail_h / 2))
        .attr("dy", ".71em")
        .style("text-anchor", "end")
        .attr("class", "shadow")
        .text("Price ($)");

    // Add the text label for the Y axis
    svgDetail.append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 6)
        .attr("x", detail_m.top - (detail_h / 2))
        .attr("dy", ".71em")
        .style("text-anchor", "end")
        .text("Price ($)");

    // Add the title
    svgDetail.append("text")
        .attr("x", (width / 2))     
        .attr("y", 0 - (detail_m.top / 2))
        .attr("text-anchor", "middle")
        .style("font-size", "16px")
        .style("text-decoration", "underline")
        .text("Price vs Date Graph");

});
