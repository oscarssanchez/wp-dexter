jQuery( document ).ready( function() {
	var pokestats = JSON.parse( pokemon_stats );

	var width = 500;
	var barHeight = 20;

	var xScale = d3.scaleLinear()
		.domain( [0, 255] )
		.range( [0, width] );

	var pokechart = d3.select( ".pokestats" )
		.attr( "width", width )
		.attr( "height", barHeight * pokestats.stats.length );

	var pokebar = pokechart.selectAll( "g" )
		.data( pokestats.stats )
		.enter()
		.append( "g" )
		.attr( "transform", function(d, i) { return "translate(0," + i * barHeight + ")"; } );

	pokebar.append( "rect" )
		.attr( "width", function(d) { return xScale(d.base_stat) } )
		.attr( "height", barHeight - 4 );

	pokebar.append( "text" )
		.attr( "x", 3 )
		.attr( "y", barHeight / 2 )
		.attr( "dy", ".35em" )
		.text( function(d) { return d.stat.name + ": " + d.base_stat; } );
});
