/* exported Analytics */
/* global dataLayer, jQuery */
/* eslint-disable-next-line */
var Analytics = ( function() {

	var dataLayerUAB = function( data ) {
		if ( typeof dataLayer !== 'undefined' && typeof data !== 'undefined' ) {
			dataLayer.push({
				'campaña': ( typeof data.campaign === 'undefined' ) ? '(not available)' : data.campaign,
				'paisBelcorp': ( typeof data.country === 'undefined' ) ? '(not available)' : data.country,
				'codigoConsultora': ( typeof data.consultant === 'undefined' ) ? '(not available)' : data.consultant,
				'ClientID': ( typeof data.client === 'undefined' ) ? '(not available)' : data.client,
				'usuarioID': ( typeof data.user === 'undefined' ) ? '(not available)' : data.user
			});
		}
	};

	var dataLayerClickEvent = function( data ) {
		if ( typeof dataLayer !== 'undefined' && typeof data !== 'undefined' ) {
			dataLayer.push({
				'event': 'virtualEvent',
				'category': ( typeof data.category === 'undefined' ) ? '(not available)' : data.category,
				'action': ( typeof data.action === 'undefined' ) ? '(not available)' : data.action,
				'label': ( typeof data.label === 'undefined' ) ? '(not available)' : data.label
			});
		}
	};

	return {
		dataLayerUAB: dataLayerUAB,
		dataLayerClickEvent: dataLayerClickEvent
	};
}( jQuery ) );
