( function( $ ) {
	$( function() {
		var container = $( '.article__content' );
		var highlight = $( '#js-highlight' );
		var containerHeight, containerPos, diff, progressPercentage, cssWidth;

		if ( highlight.length > 0 && container.length > 0 ) {
			container = container[0];
			window.onscroll = function() {
				containerHeight = container.offsetHeight - window.innerHeight;
				containerPos = container.getBoundingClientRect();
				diff = containerHeight + containerPos.top;
				progressPercentage = diff / containerHeight * 100;
				cssWidth = Math.floor( 100 - progressPercentage );
				highlight.attr( 'style', 'width:' + cssWidth + '%' );
			};
		}

	});
}( jQuery ) );
