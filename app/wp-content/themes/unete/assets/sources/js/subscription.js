/* global Cookies, jsVars, grecaptcha */
( function( $ ) {
	$( function() {
        var $containerMembership = $( '.membership' );
		var $btnSubscription =  $( '#js-subscription' );
        var $subscription = $containerMembership.find( '.subscription' );
        var $confirmation = $containerMembership.find( '.confirmation' );
        var $inputEmail = $subscription.find( '.input-email' );
        var $msgError = $subscription.find( '.error-message' );

        function validateEmail( email ) {
            var regex = /^[^\s@]+@[^\s@]+$/;
            return regex.test( email );
        }

		$btnSubscription.on( 'click', function() {
            var email = $inputEmail.val();
			var origin = $containerMembership.find( 'input[name="origin"]' ).val();
			var newEvent = null;
            if ( validateEmail( email ) ) {
                $inputEmail.removeClass( 'invalid' );
                $msgError.addClass( 'hidden' );
				grecaptcha.ready( function() {
					grecaptcha.execute( jsVars.recaptchaSiteKey ).then( function( token ) {
						$.ajax({
							url: jsVars.ajaxUrl,
							type: 'post',
							dataType: 'json',
							data: {
								action: 'emailRegisterSubscription',
								email: email,
								recaptcha: token,
								token: jsVars.security,
								country: Cookies.get( 'countryIso' ),
								origin: origin
							}
						}).done( function( response ) {
							if ( response.success && response.data.status ) {
								$subscription.fadeOut();
								$confirmation.delay( 500 ).fadeIn();
								newEvent = new CustomEvent( 'eventRegisterSubscription', response.data );
								document.dispatchEvent( newEvent );
								return true;
							}
							$inputEmail.addClass( 'invalid' );
							$msgError.find( 'p' ).text( 'Este correo electrónico ya está suscrito, ingresa otro' );
							$msgError.removeClass( 'hidden' );
						});
					});
				});
            } else {

				if ( email === '' ) {
					$msgError.find( 'p' ).text( 'Ingresa un correo electrónico' );
				} else {
					$msgError.find( 'p' ).text( 'Ingresa un correo electrónico válido' );
				}

				$inputEmail.addClass( 'invalid' );
                $msgError.removeClass( 'hidden' );
            }
        });

		$inputEmail.on( 'input', function() {
            $( this ).removeClass( 'invalid' );
			$msgError.addClass( 'hidden' );
        });

	});
}( jQuery ) );
