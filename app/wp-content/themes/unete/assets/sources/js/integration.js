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
