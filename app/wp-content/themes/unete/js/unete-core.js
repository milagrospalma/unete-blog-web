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

/* global Cookies, jsVars, grecaptcha */
( function( $ ) {
	$( function() {
		var _body = $( 'body' );
		var _token = jsVars.security;

		/**
		 *  add attribute href automatic
		 */
		function loadUrlButtonStart() {
			var iso = Cookies.get( 'countryIso' );
			var country;
			if ( iso ) {
				country = jsVars.buttonStart[iso];
				if ( country ) {
					$( '.btn-start' )
						.attr( 'href', country.link )
						.attr( 'target', '_blank' );
				}
			}
		}
		loadUrlButtonStart();

		/**
		 *  add attribute href automatic link MTO
		 */
		function loadUrlButtonMto() {
			var iso = Cookies.get( 'countryIso' );
			var _buttom = $( '.js-replace-mto' );
			var country;
			if ( iso ) {
				country = jsVars.mtoLinks[iso];
				_buttom.hide();
				if ( country ) {
					_buttom
						.attr( 'href', country.link )
						.attr( 'target', '_blank' )
						.css( 'display', 'inline-block' );
				}
			}
		}
		loadUrlButtonMto();

		/**
		 *  add phones automatic by country in mobile
		 */
		function loadPhonesByCountry() {
			var iso = Cookies.get( 'countryIso' );
			var container = $( '.js-phones-by-country' );
			var country, _data, _html;
			if ( iso ) {
				country = jsVars.phones[iso];
				if ( country && country.phones.length > 0 ) {
					_html = '';
					_data = container.find( '.contact-container' ).html();
					country.phones.map( function( items ) {
						_html += _data.replace( '<span></span>', '<span>' + items + '</span>' );
					});
					container.find( '.contact-container' ).html( _html ).parent().show();
				}
			}
		}
		loadPhonesByCountry();

		/**
		 * add function like to post
		 */
		function iLike() {
			var _likes = Cookies.get( 'likesPost' ) ?
				Cookies.get( 'likesPost' ) :
				'[]';
			_likes = JSON.parse( _likes );
			_likes.map( function( id ) {
				$( '[data-id_post="' + id + '"]' ).addClass( 'active' );
			});

			_body.on( 'click', '.js-like', function() {
				var _this = $( this );
				var _container = $( '.js-like' );
				var _id = _this.data( 'id_post' );
				var _slug = _this.data( 'slug' );
				grecaptcha.ready( function() {
					grecaptcha.execute( jsVars.recaptchaSiteKey ).then( function( token ) {
						$.ajax({
							url: jsVars.ajaxUrl,
							type: 'post',
							dataType: 'json',
							data: {
								action: 'postBlogLike',
								recaptcha: token,
								id: _id,
								slug: _slug,
								token: _token,
								option: _likes.includes( _id ) ? 'remove' : 'add'
							}
						}).done( function( response ) {
							if ( response.success ) {
								if ( _likes.includes( _id ) ) {
									_container.removeClass( 'active' );
								} else {
									_container.addClass( 'active' );
								}

								if ( _likes.includes( _id ) ) {
									_likes.splice( _likes.indexOf( _id ), 1 );
								} else {
									_likes.push( _id );
								}
								_container.find( 'span' ).html( response.data.likes );
								Cookies.set( 'likesPost', _likes, { expires: 500 });
							}
						});
					});
				});

			});
		}
		iLike();

		/**
		 * add function share to post
		 */
		function shareByPost() {
			_body.on( 'click', '.js-share-sm', function() {
				var _this = $( this );
				var _count = $( '.js-share span' );
				var _share = _this.data( 'share' );
				var _id = _this.data( 'id_post' );
				if ( typeof _id !== 'undefined' && typeof _id !== 'undefined' ) {
					$.ajax({
						url: jsVars.ajaxUrl,
						type: 'post',
						dataType: 'json',
						data: {
							action: 'postBlogShare',
							share: _share,
							id: _id,
							token: _token
						}
					}).done( function( response ) {
						if ( response.success ) {
							_count.html( parseInt( _count.html() ) + 1 );
						}
					});
				}

			});
		}
		shareByPost();

		/**
		 * Function add show more post home
		 */

		function loadPostDiscoverMore() {

			_body.on( 'click', '.js-discover-more', function() {
				var _this = $( this );
				var _page = _this.data( 'paged' );
				var _category = _this.data( 'category' );
				var _id = _this.data( 'idpost' );

				$.ajax({
					url: jsVars.ajaxUrl,
					type: 'post',
					dataType: 'json',
					data: {
						action: 'postDiscoverMore',
						token: _token,
						paged: _page,
						category: _category,
						id: _id
					}
				}).done( function( response ) {
					var _posts = null;
					var _html = '';
					var _paged = parseInt( _page ) + 1;
					var _value = 0;
					var _author = null;
					if ( response.success && response.data.data ) {
						_posts = response.data.data;
						_posts.map( function( _post ) {
							_author = ( _post.author && _post.author !== '' ) ? 'Por <span class="author">' + _post.author + '</span>' : '';
							_html += '<a class="article-card" id="post-' + _post.id + '" href="' + _post.link + '" style="display: none">';
							_html += '	<div class="cover">' + _post.image + '</div>';
							_html += '	<div class="category-label" style="background-color: ' + _post.category.background + '">' + _post.category.title + '</div>';
							_html += '	<h3 class="name">' + _post.title + '</h3>';
							_html += '	<div class="detail">';
							_html += '		<span class="date">' + _post.date + '</span> - <span class="reading-time">' + _post.time + '</span> min de lectura';
							_html += '	</div>';
							_html += '	<div class="authorship">' + _author + '</div>';
							_html += '</a>';
							$( '.discover-more .content' ).append( _html );
							$( '#post-' + _post.id ).delay( 350 * _value ).fadeIn();
							_value++;
						});
						_this.data( 'paged', _paged );
						if ( response.data.max_num_pages <  _paged ) {
							_this.fadeOut();
						}
					}
				});
			});

		}
		loadPostDiscoverMore();

		/**
		 * Function add show more post home
		 */

		function loadPostDiscoverMoreByCategory() {

			_body.on( 'click', '.js-category-discover-more', function() {
				var _this = $( this );
				var _page = _this.data( 'paged' );
				var _category = _this.data( 'category' );
				var _categoryId = _this.data( 'category-id' );
				var _name = _this.data( 'name' );
				var _ids = _this.data( 'idposts' );
				var _ispost = _this.data( 'ispost' );
				var _filter = _this.data( 'filter' );
				var _postsExclude = _this.data( 'posts-exclude' );
				$.ajax({
					url: jsVars.ajaxUrl,
					type: 'post',
					dataType: 'json',
					data: {
						action: 'postDiscoverMoreByCategory',
						token: _token,
						paged: _page,
						category: _category,
						name: _name,
						filter: _filter,
						ids: _ids,
						idCategory: _categoryId,
						isPost: _ispost,
						exclude: _postsExclude
					}
				}).done( function( response ) {
					var _posts = null;
					var _html = '';
					var _paged = parseInt( _page ) + 1;
					var _value = 0;
					var _author = null;
					var _category = '';
					var _idsExcludes = _postsExclude;
					if ( response.success && response.data.discover_more ) {
						_posts = response.data.discover_more;
						_posts.map( function( _post ) {
							_html = '';
							_author = ( _post.author && _post.author !== '' ) ? 'Por <span class="author">' + _post.author + '</span>' : '';
							_category = _ispost ? '<div class="category-label" style="background-color: ' + _post.category.background + '">' + _post.category.title + '</div>' : '';
							_html += '<a class="article article-card" id="post-' + _post.id + '" href="' + _post.link + '" style="display: none">';
							_html += '	<div class="article__content">';
							_html += 		_category;
							_html += '		<h3 class="name">' + _post.title + '</h3>';
							_html += '		<div class="detail">';
							_html += '			<span class="date">' + _post.date + '</span> - <span class="reading-time">' + _post.time + '</span> min de lectura';
							_html += '		</div>';
							_html += '		<div class="authorship">' + _author + '</div>';
							_html += '	</div>';
							_html += '	<div class="cover">' + _post.thumbnail + '</div>';
							_html += '</a>';
							if ( _ispost ) {
								$( '.recommended .content' ).append( _html );
							} else {
								$( '.discover-more .content' ).append( _html );
							}

							_idsExcludes = _idsExcludes + ',' + _post.id;

							$( '#post-' + _post.id ).delay( 350 * _value ).fadeIn();
							_value++;

						});
						if ( response.data.configuration.merge && response.data.configuration.more_page === true && _filter === 'tag' ) {
							_this.data( 'paged', 1 );
							_this.data( 'filter', 'category' );
							_this.data( 'category', _categoryId );
							_this.data( 'idposts', _ids + ',' +  _idsExcludes );
							return;
						}
						_this.data( 'paged', _paged );
						_this.data( 'posts-exclude', _idsExcludes );
						if ( ( response.data.configuration.max_num_pages <  _paged ) && response.data.configuration.more_page === false  ) {
							_this.fadeOut();
						}
					}
				});

			});


		}
		loadPostDiscoverMoreByCategory();

		/**
		 * Function add show more post single
		 */

		function loadPostDiscoverMorePosts() {

			_body.on( 'click', '.js-posts-discover-more', function() {
				var _this = $( this );
				var _idPost = _this.data( 'filter-post-id' );
				var _idCategory = _this.data( 'filter-category-id' );
				var _idsTags = _this.data( 'filter-tags-ids' );
				var _name = _this.data( 'filter-name' );
				var _page = _this.data( 'filter-page' );
				var _type = _this.data( 'filter-type' );
				var _postsExclude = _this.data( 'filter-posts-exclude' );
				$.ajax({
					url: jsVars.ajaxUrl,
					type: 'post',
					dataType: 'json',
					data: {
						action: 'postDiscoverMorePosts',
						token: _token,
						idPost: _idPost,
						idCategory: _idCategory,
						idsTags: _idsTags,
						name: _name,
						page: _page,
						type: _type,
						exclude: _postsExclude
					}
				}).done( function( response ) {
					var _posts = null;
					var _html = '';
					var _paged = parseInt( _page ) + 1;
					var _value = 0;
					var _author = null;
					var _idsExcludes = _postsExclude;
					if ( response.success && response.data.discover_more ) {
						_posts = response.data.discover_more;
						_posts.map( function( _post ) {
							_html = '';
							_author = ( _post.author && _post.author !== '' ) ? 'Por <span class="author">' + _post.author + '</span>' : '';
							_html += '<a class="article article-card" id="post-' + _post.id + '" href="' + _post.link + '" style="display: none">';
							_html += '	<div class="article__content">';
							_html +=  '		<div class="category-label" style="background-color: ' + _post.category.background + '">' + _post.category.title + '</div>';
							_html += '		<h3 class="name">' + _post.title + '</h3>';
							_html += '		<div class="detail">';
							_html += '			<span class="date">' + _post.date + '</span> - <span class="reading-time">' + _post.time + '</span> min de lectura';
							_html += '		</div>';
							_html += '		<div class="authorship">' + _author + '</div>';
							_html += '	</div>';
							_html += '	<div class="cover">' + _post.thumbnail + '</div>';
							_html += '</a>';
							$( '.recommended .content' ).append( _html );

							_idsExcludes = _idsExcludes + ',' + _post.id;

							$( '#post-' + _post.id ).delay( 350 * _value ).fadeIn();
							_value++;

						});
						if ( response.data.configuration.merge && response.data.configuration.more_page === true && _type === 'tag' ) {
							_this.data( 'filter-page', 1 );
							return;
						}
						_this.data( 'filter-page', _paged );
						if ( ( response.data.configuration.max_num_pages <  _paged ) && response.data.configuration.more_page === false  ) {
							_this.fadeOut();
						}
					}
				});

			});


		}
		loadPostDiscoverMorePosts();

		function scrollToSectionPost() {
			_body.on( 'click', '.js-post-scroll-section', function() {
				var _this = $( this );
				var _id = _this.data( 'id' );
				$( 'html,body' ).animate({
					scrollTop: $( '#section-' + _id ).offset().top - 150
				}, 1000 );
				return false;
			});
		}
		scrollToSectionPost();

		function scrollTopPost() {
			_body.on( 'click', '.js-scroll-top', function() {
				$( 'html,body' ).animate({
					scrollTop: $( 'body' ).offset().top - 90
				}, 1000 );
				return false;
			});
		}
		scrollTopPost();
	});
}( jQuery ) );

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

/* global Cookies, Analytics */
( function( $ ) {
	$( function() {

		function getClientId() {
			var clientID;
			var _ga = Cookies.get( '_ga' );
			if ( typeof _ga !== 'undefined' ) {
				_ga = _ga.split( '.' );
				clientID = _ga[2] + '.' + _ga[3];
			}
			return clientID;
		}

		function dlInital() {
			var iso = Cookies.get( 'countryIso' );
			var clientID = getClientId();

			Analytics.dataLayerUAB({'country': iso, 'client': clientID});
		}
		dlInital();

		function getCategoryLabel() {
			var _category = 'Blog UAB';
			if ( $( '[data-is-category="true"]' ).length > 0 ) {
				_category = 'Blog UAB - Categoria';
			} else if ( $( '[data-is-single="true"]' ).length > 0 ) {
				_category = 'Blog UAB - Articulo';
			}

			return _category;
		}

		function dlHome() {
			var _category = getCategoryLabel();
			var _label = null;
			$( '.sidenav-open' ).click( function() {
				Analytics.dataLayerClickEvent({'category': _category, 'action': 'menu desplegable'});
			});

			$( '.sidenav a' ).click( function() {
				_label = $( this ).html().trim();
				Analytics.dataLayerClickEvent({'category': _category, 'action': 'menu desplegable', 'label': _label});
			});

			$( '.menu-options a' ).click( function() {
				_label = $( this ).html().trim();
				Analytics.dataLayerClickEvent({'category': _category, 'action': 'menu', 'label': _label});
			});

			$( '.nav-options a' ).click( function() {
				_label = $( this ).html().trim();
				Analytics.dataLayerClickEvent({'category': _category, 'action': 'secciones Blog', 'label': _label});
			});

			$( '.most-recent a.article, .most-important a.article' ).click( function() {
				_label = $( this ).find( 'h3' ).html().trim();
				Analytics.dataLayerClickEvent({'category': _category, 'action': 'Lo mas reciente', 'label': _label});
			});

			$( '.discover-more' ).on( 'click', '.article-card', function() {
				_label = $( this ).find( 'h3' ).html().trim();
				Analytics.dataLayerClickEvent({'category': _category, 'action': 'Descubre mas', 'label': _label});
			});

			$( '.discover-more .button, .recommended .button' ).on( 'click', '.js-discover-more, .js-category-discover-more, .js-posts-discover-more', function() {
				Analytics.dataLayerClickEvent({'category': _category, 'action': 'Mostrar mas Blog'});
			});

			$( '.nav__main .btn-start' ).click( function() {
				Analytics.dataLayerClickEvent({'category': _category, 'action': 'Menú', 'label': 'Inicia Ya!'});
			});

			$( '.unete-blog-footer .btn-start' ).click( function() {
				Analytics.dataLayerClickEvent({'category': _category, 'action': 'Footer', 'label': 'Inicia Ya!'});
			});

			$( '.recommended' ).on( 'click', 'a.article', function() {
				_label = $( this ).find( 'h3' ).html().trim();
				Analytics.dataLayerClickEvent({'category': _category, 'action': 'Tambien te gustara', 'label': _label});
			});

			$( '.article' ).on( 'click', '.like, .comment, .share', function() {
				var _action = 'me gusta';
				var _this = $( this );
				if ( _this.hasClass( 'comment' ) ) {
					_action = 'comentar';
				} else if ( _this.hasClass( 'share' ) ) {
					_action = 'compartir';
				}
				_label = $( '.article__content__header .title' ).html().trim();
				Analytics.dataLayerClickEvent({'category': _category, 'action': _action, 'label': _label});
			});

			$( '.comment-container' ).on( 'click', '.js-comment-cancel', function() {
				_label = $( '.article__content__header .title' ).html().trim();
				Analytics.dataLayerClickEvent({'category': _category, 'action': 'Cancelar comentario', 'label': _label});
			});

			$( '.share-options' ).on( 'click', '.js-share-sm', function() {
				_label = $( this ).find( 'span' ).html().trim();
				Analytics.dataLayerClickEvent({'category': _category, 'action': 'Compartir Blog', 'label': _label});
			});

			document.addEventListener( 'eventRegisterSubscription', function() {
				Analytics.dataLayerClickEvent({'category': _category, 'action': 'Suscribirse'});
				Analytics.dataLayerClickEvent({'category': _category, 'action': 'Suscripción Completa'});
			});

			document.addEventListener( 'eventRegisterComments', function() {
				_label = $( '.article__content__header .title' ).html().trim();
				Analytics.dataLayerClickEvent({'category': _category, 'action': 'Enviar comentario', 'label': _label});
				Analytics.dataLayerClickEvent({'category': _category, 'action': 'Gracias por comentar'});
			});

			$( '.comment-container' ).on( 'click', '.js-new-comment', function() {
				_label = $( this ).find( 'p' ).html().trim();
				Analytics.dataLayerClickEvent({'category': _category, 'action': 'Gracias por comentar', 'label': _label});
			});
		}
		dlHome();
	});
}( jQuery ) );

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
