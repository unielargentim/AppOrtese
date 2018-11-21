$(document).ready(function(){


var svg = d3.select("svg"),
    margin = {top: 30, right: 55, bottom: 110, left: 50},
    margin2 = {top: 490, right: 55, bottom: 20, left: 50},
    width = +svg.attr("width") - margin.left - margin.right,
    height = +svg.attr("height") - margin.top - margin.bottom,
    height2 = +svg.attr("height") - margin2.top - margin2.bottom;

var parseDate = d3.timeParse("%Y-%m-%d %H:%M:%S");

var x = d3.scaleTime().range([0, width]),

	y = d3.scaleLinear().range([height, 0]),
    yIntensity = d3.scaleLinear().range([height, 0]),
	yThreshold = d3.scaleLinear().range([height, 0]),
    
	x2 = d3.scaleTime().range([0, width]),
	y2 = d3.scaleLinear().range([height2, 0]);

var xAxis = d3.axisBottom(x),
    xAxis2 = d3.axisBottom(x2),
    
	yEmgAxis = d3.axisLeft(y);
	yIntensityEmgAxis = d3.axisRight(yIntensity);
	yThresholdAxis = d3.axisRight(yThreshold);

var brush = d3.brushX()
    .extent([[0, 0], [width, height2]])
    .on("brush end", brushed);

var zoom = d3.zoom()
    .scaleExtent([1, Infinity])
    .translateExtent([[0, 0], [width, height]])
    .extent([[0, 0], [width, height]])
    .on("zoom", zoomed);

var emgLine = d3.line()
    .x(function(d) { return x(d.date); })
    .y(function(d) { return y(d.value); });

var area2 = d3.line()
    .x(function(d) { return x2(d.date); })
    .y(function(d) { return y2(d.value); });

var intensityLine = d3.line()
    .x(function(d) { return x(d.date); })
    .y(function(d) { return yIntensity(d.intensity); });

var thresholdLine = d3.line()
    .x(function(d) { return x(d.date); })
    .y(function(d) { return yThreshold(d.threshold); });


svg.append("defs").append("clipPath")
    .attr("id", "clip")
  .append("rect")
    .attr("width", width)
    .attr("height", height);

var focus = svg.append("g")
    .attr("class", "focus")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

var context = svg.append("g")
    .attr("class", "context")
    .attr("transform", "translate(" + margin2.left + "," + margin2.top + ")");


  d3.csv("emgFiles/"+fileName, type, function(error, data) {
  if (error) throw error;
  
   
  x.domain(d3.extent(data, function(d) { return d.date; }));
  
  y.domain([d3.min(data, function(d) { return d.value; }) - 10, d3.max(data, function(d) { return d.value; }) + 10]);
  yIntensity.domain([d3.min(data, function(d) { return d.intensity; }) - 10, d3.max(data, function(d) { return d.intensity; }) + 10]);
  
  yThreshold.domain(y.domain());
  x2.domain(x.domain());
  y2.domain(y.domain());

  focus.append("path")
      .datum(data)
      .attr("class", "emgLine")
      .attr("d", emgLine);
 
  focus.append("path")
      .datum(data)
      .attr("class", "intensityLine")
      .attr("d", intensityLine);

  focus.append("path")
      .datum(data)
      .attr("class", "thresholdLine")
      .attr("d", thresholdLine);

	  
  focus.append("g")
      .attr("class", "axis axis--x")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis);
	  
   svg.append("text")             
      .attr("transform",
            "translate(" + ((width+80)/2) + " ," + 
                           (height + margin.top + 35) + ")")
      .style("text-anchor", "middle")
      .text("Marca Temporal [hh:mm:ss]");

  focus.append("g")
      .attr("class", "axisBlue")
      .call(yEmgAxis);

  focus.append("g")
      .attr("class", "axisGreen")
	  .call(yThresholdAxis);

  svg.append("text")
      .attr("transform", "rotate(-90)")
      .attr("y", 4)
      .attr("x",0 - (height / 2))
      .attr("dy", "1em")
      .style("text-anchor", "middle")
      .text("[mV]");  

  focus.append("g")
      .attr("class", "axisRed")
	  .attr("transform", "translate( " + width + ", 0 )")
	  .call(yIntensityEmgAxis);

  svg.append("text")
      .attr("transform", "rotate(-90)")
      .attr("y", width + 80)
      .attr("x",0 - (height / 2))
      .attr("dy", "1em")
      .style("text-anchor", "middle")
      .text("[mA]");

  context.append("path")
      .datum(data)
      .attr("class", "emgLine")
      .attr("d", area2);
	  
  context.append("g")
      .attr("class", "axis axis--x")
      .attr("transform", "translate(0," + height2 + ")")
      .call(xAxis2);

  context.append("g")
      .attr("class", "brush")
      .call(brush)
      .call(brush.move, x.range());

  svg.append("rect")
      .attr("class", "zoom")
      .attr("width", width)
      .attr("height", height)
      .attr("transform", "translate(" + margin.left + "," + margin.top + ")")
      .call(zoom);


	// add legend 
	var keys = (["Sinal EMG", "Threshold", "Intensidade"]);
	var z = d3.scaleOrdinal()
        .range(["steelblue", "green", "red"]);

    
	 var legend = svg.append("g")
        .attr("font-family", "sans-serif")
        .attr("font-size", 12)
        .attr("text-anchor", "end")
        .selectAll("g")
        .data(keys.slice())
        .enter().append("g")
        .attr("transform", function(d, i) {
          return "translate(" + i * 115 +",0 )";
        });

	legend.append("rect")
        .attr("x", (width/2) - 55)
		.attr("y", height/2 - 200)
        .attr("width", 19)
        .attr("height", 19)
        .attr("fill", z);

      legend.append("text")
        .attr("x", (width/2) - 60)
        .attr("y", 15.5)
        .attr("dy", "0.32em")
        .text(function(d) {
          return d;
        });

});

function brushed() {
  if (d3.event.sourceEvent && d3.event.sourceEvent.type === "zoom") return; // ignore brush-by-zoom
  var s = d3.event.selection || x2.range();
  x.domain(s.map(x2.invert, x2));
  focus.select(".emgLine").attr("d", emgLine);
  focus.select(".intensityLine").attr("d", intensityLine);
  focus.select(".thresholdLine").attr("d", thresholdLine);
  focus.select(".axis--x").call(xAxis);
  svg.select(".zoom").call(zoom.transform, d3.zoomIdentity
      .scale(width / (s[1] - s[0]))
      .translate(-s[0], 0));
}

function zoomed() {
  if (d3.event.sourceEvent && d3.event.sourceEvent.type === "brush") return; // ignore zoom-by-brush
  var t = d3.event.transform;
  x.domain(t.rescaleX(x2).domain());
  focus.select(".emgLine").attr("d", emgLine);
  focus.select(".intensityLine").attr("d", intensityLine);
  focus.select(".thresholdLine").attr("d", thresholdLine);
  focus.select(".axis--x").call(xAxis);
  context.select(".brush").call(brush.move, x.range().map(t.invertX, t));
}

function type(d) {
  d.date = parseDate(d.date);
  d.value = +d.value;
  d.stimulating = +d.stimulating; 
  d.threshold = +d.threshold; 
  d.intensity = +d.intensity;
  return d;
}

});