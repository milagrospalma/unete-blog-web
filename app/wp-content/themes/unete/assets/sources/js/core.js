/* global */
var breakpoints = {
    xs: 480,
    sm: 768,
    md: 992,
    lg: 1200
};

// ==== MAIN core ==== //
( function( $ ) {
    var $articleContainer = $( '.unete-blog-article' );
    var $articleHeader = $articleContainer.find( '.article__content__header' );
    var $articleBody = $articleContainer.find( '.article__content__body' );
    var $articleFooter = $articleContainer.find( '.article__content__footer' );
    var $articleSide = $articleContainer.find( '.article__side-content' );
    var $contentTable = $articleContainer.find( '.content-table' );
    var $currentArticle = $articleContainer.find( '.current-article' );

    $( document ).ready( function() {
        var $body = $( 'body' );
        var $headerFull = $( '.unete-blog-header' );
        var $openButtonSidenav = $( '.sidenav-open' );
        var $closeButtonSidenav = $( '.sidenav-close' );
        var $containerSidenav = $( '.nav__side' );
        var $sidenav = $( '.nav__main__sidenav' );

        var $navCategoryOptions = $( '.nav-options' );
        var $navMainContainer = $( '.nav__main' );
        var $headerDefault = $( '.nav__main__initial' );
        var $headerFixed = $( '.nav__main__scroll' );
        var $navCategories = $( '.nav-blog' );
        var $navTitle = $( '.nav-text' );

        var didScroll;
        var lastScrollTop = 0;
        var delta = 152;
        var navbarHeight = $headerFull.outerHeight();

        var $mainContainer = $( 'main' );
        var $btnShare = $( '.js-share' );
        var $btnContentsContainer = $( '.button-contents-container' );
        var $btnCancelShare = $( '.js-cancel-share' );
        var $btnCopyLink = $( '.js-copy-link' );

        if ( ! $body.find( '.nav-blog' ).length ) {
            $headerFull.addClass( 'shadow-bottom' );
        }

        if ( $articleContainer.length > 0 ) {
            $contentTable.css( 'height', $articleHeader.height() );
        }

        $openButtonSidenav.on( 'click', function() {
			$containerSidenav.removeClass( 'hidden' );
            $body.addClass( 'overflow-hidden' );
            setTimeout( function() {
                $sidenav.addClass( 'visible' );
            }, 250 );

		});

        $closeButtonSidenav.on( 'click', function() {
            $sidenav.removeClass( 'visible' );
            $body.removeClass( 'overflow-hidden' );
            setTimeout( function() {
                $containerSidenav.addClass( 'hidden' );
            }, 500 );

        });

        if ( $navCategoryOptions.children().length > 3 ) {
            $navCategoryOptions.slick({
                arrows: false,
                infinite: false,
                speed: 500,
                slidesToShow: 2,
                variableWidth: true,
                mobileFirst: true,
                responsive: [
                    {
                        breakpoint: breakpoints.sm,
                        settings: 'unslick'
                    }
                ]
            });
        }

        /**
         * Scroll header and navbar
         */

        function hasScrolled() {
            var st = $( this ).scrollTop();

            if ( Math.abs( lastScrollTop - st ) <= delta ) {
                return;
            }

            if ( st > lastScrollTop && st > navbarHeight ) {
                $headerFull.removeClass( 'nav-down' );
                $navMainContainer.addClass( 'nav-up' ).fadeIn().slideDown();
                $navCategories.removeClass( 'nav-below' );
            } else {
                if ( st + $( window ).height() < $( document ).height() ) {
                    $headerFull.addClass( 'nav-down' ).fadeIn().slideDown();
                    $navMainContainer.removeClass( 'nav-up' );
                    $navCategories.addClass( 'nav-below' );
                }
            }

            lastScrollTop = st;
        }

        $.fn.isInViewport = function() {
            var elementTop = $( this ).offset().top;
            var elementBottom = elementTop + $( this ).outerHeight();

            var viewportTop = $( window ).scrollTop();
            var viewportBottom = viewportTop + $( window ).height();

            return elementBottom > viewportTop && elementTop < viewportBottom;
        };

        $( window ).scroll( function() {
            var scrollTop = $( window ).scrollTop();
            var positionTagMain = $mainContainer.offset();
            var positionArticleBody = $articleBody.offset();

            if ( $( window ).width() < breakpoints.md ) {

                didScroll = true;

                if ( didScroll ) {
                    hasScrolled();
                    didScroll = false;
                }

                if ( $navCategories.length ) {
                    if ( scrollTop > positionTagMain.top ) {
                        $navTitle.hide();
                        $navCategories.addClass( 'p-sticky shadow-bottom' ).delay( 500 ).fadeIn().slideDown();
                    }
                }

                if ( scrollTop === 0 ) {
                    $headerFull.removeClass( 'nav-down' ).slideDown();
                    $navCategories.removeClass( 'p-sticky shadow-bottom nav-below' ).removeAttr( 'style' ).fadeIn();
                    $navTitle.slideDown();
                }

            } else {

                if (  ! $navCategories.length ) {

                    if ( scrollTop > positionTagMain.top ) {
                        $headerFixed.slideDown();
                        $headerFixed.addClass( 'shadow-bottom' );
                    } else {
                        $headerFixed.slideUp();
                    }

                } else {

                    if ( scrollTop > positionTagMain.top ) {
                        $headerFixed.slideDown();
                        $headerFixed.addClass( 'border-bottom' );
                        $navTitle.hide();
                        $navCategories.addClass( 'p-sticky shadow-bottom' ).delay( 1000 ).fadeIn().slideDown();
                    } else {
                        $headerFixed.slideUp();
                        $navCategories.removeClass( 'p-sticky shadow-bottom' ).removeAttr( 'style' );
                        $navTitle.show();
                    }

                }

                if ( scrollTop === 0 ) {
                    $headerDefault.removeClass( 'hidden' );
                    $navTitle.removeClass( 'hidden' );
                    $navCategories.removeClass( 'p-fixed nav-fixed border-top shadow-bottom' );
                }

				if ( $articleContainer.length > 0 ) {
                    if ( $navCategories.length > 0 ) {
                        if ( scrollTop > positionArticleBody.top - 160 ) {
                            $currentArticle.addClass( 'p-sticky' );
                            $currentArticle.css( 'top', '130px' );
                            $contentTable.slideUp();
                        } else {
                            $currentArticle.removeClass( 'p-sticky' );
                            $contentTable.fadeIn();
                        }
                    } else {
                        if ( scrollTop > positionArticleBody.top - 80 ) {
                            $currentArticle.addClass( 'p-sticky' );
                            $currentArticle.css( 'top', '70px' );
                            $contentTable.slideUp();
                        } else {
                            $currentArticle.removeClass( 'p-sticky' );
                            $contentTable.fadeIn();
                        }
                    }
				}

                if ( $articleFooter.find( '.buttons' ).length > 0 && $articleFooter.find( '.buttons' ).isInViewport() ) {
                    $articleSide.find( '.buttons' ).fadeOut();
                    $articleSide.find( '.js-share' ).removeClass( 'active' );
                    $articleSide.find( '.button-contents-container' ).addClass( 'hidden' );
                } else {
                    $articleSide.find( '.buttons' ).fadeIn();
                    $articleFooter.find( '.js-share' ).removeClass( 'active' );
                    $articleFooter.find( '.button-contents-container' ).addClass( 'hidden' );
                }

            }
        });

        /**
         * Share
         */

        $btnShare.on( 'click', function() {
            $( this ).addClass( 'active' );
            $btnContentsContainer.addClass( 'hidden' );
            $( this ).parent().siblings().removeClass( 'hidden' );
            if ( $( window ).width() < breakpoints.md ) {
                $body.addClass( 'overflow-hidden' );
                setTimeout( function() {
                    $btnContentsContainer.find( '.group' ).addClass( 'visible-bottom' );
                }, 300 );
            }
        });

        $btnCancelShare.on( 'click', function() {
            $btnShare.removeClass( 'active' );
            if ( $( window ).width() < breakpoints.md ) {
                $btnContentsContainer.find( '.group' ).removeClass( 'visible-bottom' );
                $body.removeClass( 'overflow-hidden' );
                setTimeout( function() {
                    $btnContentsContainer.addClass( 'hidden' );
                }, 500 );
            } else {
                $( this ).closest( $btnContentsContainer ).addClass( 'hidden' );
            }
        });

        $btnCopyLink.on( 'click', function() {
            $body.append( '<input id="copyURL" type="text" value="" />' );
            $( '#copyURL' ).val( window.location.href ).select();
            document.execCommand( 'copy' );
            $( '#copyURL' ).remove();
        });

    });

    $( window ).load( function() {
        if ( $articleContainer.length > 0 ) {
            $articleSide.css( 'height', $articleBody.height() );
        }
    });

}( jQuery ) );
