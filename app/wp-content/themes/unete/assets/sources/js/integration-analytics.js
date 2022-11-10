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
