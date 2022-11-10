/* global Cookies, jsVars, grecaptcha */
( function( $ ) {
	$( function() {
        var $body = $( 'body' );
        var $headerFull = $( '.unete-blog-header' );
        var $headerFixed = $( '.nav__main__scroll' );
        var $btnOpen = $( '.js-comment' );
        var $btnClose = $( '.js-comment-close' );
        var $btnComment = $( '.js-comment-start' );
        var $btnCancel = $( '.js-comment-cancel' );
        var $btnSubmit = $( '.js-comment-submit' );
        var $btnNewComment = $( '.js-new-comment' );
        var $overlay = $( '.js-overlay' );
        var $containerComment = $( '.comment-container' );
        var $formDefault = $containerComment.find( '.initial' );
        var $formOpened = $containerComment.find( '.opened' );
        var $formConfirmation = $containerComment.find( '.confirmation' );
        var $inputForm = $containerComment.find( '.input-form' );
        var $inputComment = $containerComment.find( '.input-comment' );
        var $inputEmail = $containerComment.find( '.input-email' );
        var $inputFullname = $containerComment.find( '.input-fullname' );
        var $btnContentsContainer = $( '.button-contents-container' );
        var $btnShare = $( '.js-share' );
        var $navCategories = $( '.nav-blog' );

        var heightViewport = $( window ).height();
        var heightHeaderScroll = $headerFixed.height();
        var heightHeaderDefault = $headerFull.height();
        var heightNavCategories = $navCategories.height();
        var heightCalculated;

        function validateEmail( str ) {
            var regex = /^[^\s@]+@[^\s@]+$/;
            return regex.test( str );
        }

        function onlyLetters( str ) {
            var regex = /^[A-Za-zÁÉÍÓÚáéíóúñÑ ]+$/g;
            return regex.test( str );
        }

        $btnOpen.on( 'click', function() {
            var scrollTop = $( window ).scrollTop();
            var heightInitialHeaderNav = heightHeaderDefault + heightNavCategories;
            var heightFixedHeaderNav = heightHeaderScroll + heightNavCategories;
            var heightSeenWithNav = heightInitialHeaderNav - scrollTop;
            var heightSeenWithoutNav = heightHeaderDefault - scrollTop;

            $btnOpen.addClass( 'active' );
            $btnContentsContainer.addClass( 'hidden' );
            $btnShare.removeClass( 'active' );
            $body.addClass( 'overflow-hidden' );
            $overlay.removeClass( 'hidden' );
            $containerComment.scrollTop( 0 );
            $formOpened.addClass( 'hidden' );
            $formConfirmation.addClass( 'hidden' );
            $formDefault.removeClass( 'hidden' );

            if ( $( window ).width() > breakpoints.md ) {
                if ( $navCategories.length > 0 ) {

                    if ( $headerFixed.css( 'display' ) === 'block' ) {
                        heightCalculated = heightViewport - heightFixedHeaderNav;
                        $containerComment.css({ 'top': heightFixedHeaderNav - 1 + 'px', 'height': heightCalculated + 'px' });
                    } else {
                        $navCategories.addClass( 'shadow-bottom' ).css( 'top', '0px' );

                        if ( scrollTop > 0 && scrollTop <= heightInitialHeaderNav ) {
                            heightCalculated = heightViewport - heightSeenWithNav;
                            $containerComment.css({ 'top': heightSeenWithNav + 'px', 'height': heightCalculated + 'px' });
                        }

                        if ( scrollTop === 0 )  {
                            heightCalculated = heightViewport - heightInitialHeaderNav;
                            $containerComment.css({ 'top': heightInitialHeaderNav - 1 + 'px', 'height': heightCalculated + 'px' });
                        }
                    }

                } else {
                    if ( $headerFixed.css( 'display' ) === 'block' ) {
                        heightCalculated = heightViewport - heightHeaderScroll;
                        $containerComment.css({ 'top': heightHeaderScroll + 'px', 'height': heightCalculated + 'px' });
                    } else {

                        if ( scrollTop > 0 && scrollTop <= heightHeaderDefault ) {
                            heightCalculated = heightViewport - heightSeenWithoutNav;
                            $containerComment.css({ 'top': heightSeenWithoutNav + 'px', 'height': heightCalculated + 'px' });
                        }

                        if ( scrollTop === 0 )  {
                            heightCalculated = heightViewport - heightHeaderDefault;
                            $containerComment.css({ 'top': heightHeaderDefault + 'px', 'height': heightCalculated + 'px' });
                        }

                    }
                }
            }

            setTimeout( function() {
                $containerComment.addClass( 'visible-right' );
            }, 300 );
        });

        $btnClose.on( 'click', function() {
            $btnOpen.removeClass( 'active' );
            $containerComment.removeClass( 'visible-right' );
            $body.removeClass( 'overflow-hidden' );
            $inputForm.removeClass( 'invalid' ).val( '' );
            $btnSubmit.addClass( 'disabled' );

            setTimeout( function() {
                $overlay.addClass( 'hidden' );
                if ( $headerFixed.css( 'display' ) !== 'block' ) {
                    $navCategories.removeClass( 'shadow-bottom' );
                }
            }, 500 );

        });

        $btnComment.on( 'click', function() {
            $formDefault.addClass( 'hidden' );
            $formOpened.removeClass( 'hidden' );
            $inputComment.focus();
            $containerComment.scrollTop( 0 );
        });

        $btnCancel.on( 'click', function() {
            $containerComment.scrollTop( 0 );
            $formOpened.addClass( 'hidden' );
            $formConfirmation.addClass( 'hidden' );
            $formDefault.removeClass( 'hidden' );
            $inputForm.removeClass( 'invalid' ).val( '' );
            $btnSubmit.addClass( 'disabled' );
        });

        $btnSubmit.on( 'click', function() {
            var valComment = $inputComment.val().trim();
            var valEmail = $inputEmail.val().trim();
            var valFullname = $inputFullname.val().trim();
			var newEvent = null;
			var valId = $( this ).data( 'id' );

            $inputForm.removeClass( 'invalid' );

            if ( validateEmail( valEmail ) && onlyLetters( valFullname ) ) {
				grecaptcha.ready( function() {
					grecaptcha.execute( jsVars.recaptchaSiteKey ).then( function( token ) {
						$.ajax({
							url: jsVars.ajaxUrl,
							type: 'post',
							dataType: 'json',
							data: {
								action: 'postCommentsInsert',
								token: jsVars.security,
								recaptcha: token,
								email: valEmail,
								name: valFullname,
								comment: valComment,
								country: Cookies.get( 'countryIso' ),
								id: valId
							}
						}).done( function( response ) {
							if ( response.success ) {
								$containerComment.scrollTop( 0 );
								$formOpened.addClass( 'hidden' );
								$formConfirmation.removeClass( 'hidden' );
								newEvent = new CustomEvent( 'eventRegisterComments', response );
								document.dispatchEvent( newEvent );
								return true;
							}
						});
					});
				});
            } else {

                if ( ! validateEmail( valEmail ) ) {
                    $inputEmail.addClass( 'invalid' );
                }
                if ( ! onlyLetters( valFullname ) ) {
                    $inputFullname.addClass( 'invalid' );
                }

                $btnSubmit.addClass( 'disabled' );
            }

        });

        $btnNewComment.on( 'click', function() {
            $formConfirmation.addClass( 'hidden' );
            $formOpened.removeClass( 'hidden' );
            $inputForm.val( '' );
            $btnSubmit.addClass( 'disabled' );
            $inputComment.focus();
            $containerComment.scrollTop( 0 );
        });

        $inputForm.on( 'input', function() {
            var valComment = $inputComment.val().trim();
            var valEmail = $inputEmail.val().trim();
            var valFullname = $inputFullname.val().trim();

            $( this ).removeClass( 'invalid' );

            if ( valComment !== '' && valEmail !== '' && valFullname !== '' ) {
                $btnSubmit.removeClass( 'disabled' );
            } else {
                $btnSubmit.addClass( 'disabled' );
            }
        });

	});
}( jQuery ) );
