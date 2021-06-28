var vc_js = function () {
	vc_toggleBehaviour();
	vc_tabsBehaviour();
	vc_accordionBehaviour();
	vc_pinterest();
	vc_progress_bar();
	vc_google_fonts();
    window.setTimeout(vc_waypoints, 500);
};
jQuery(function($) { // Doc ready
	window.vc_js();
});

/* Pinterest
 ---------------------------------------------------------- */
if ( typeof window[ 'vc_pinterest' ] !== 'function' ) {
	window.vc_pinterest = function () {
		if ( jQuery( '.wpb_pinterest' ).length > 0 ) {
			(function () {
				var po = document.createElement( 'script' );
				po.type = 'text/javascript';
				po.async = true;
				po.src = 'http://assets.pinterest.com/js/pinit.js';
				var s = document.getElementsByTagName( 'script' )[ 0 ];
				s.parentNode.insertBefore( po, s );
			})();
		}
	}
}

/* Progress bar
 ---------------------------------------------------------- */
if (typeof window['vc_progress_bar'] !== 'function') {
	window.vc_progress_bar = function() {
		if (void 0 !== jQuery.fn.vcwaypoint) {
            jQuery(".vc_progress_bar").each(function() {
                var $el = jQuery(this);
                $el.vcwaypoint(function() {
                    $el.find(".vc_single_bar").each(function(index) {
                        var bar = jQuery(this).find(".vc_bar"),
                            val = bar.data("percentage-value");
                        setTimeout(function() {
                            bar.css({width: val + "%"});
                        }, 200 * index);
                    });
                }, {offset: "85%"});
            });
		}
	}
}

/* Animations
 ---------------------------------------------------------- */
if (typeof window.vc_waypoints != 'function') {
    window.vc_waypoints = function() {
        if (void 0 !== jQuery.fn.vcwaypoint) {
            jQuery(".wpb_animate_when_almost_visible:not(.wpb_start_animation)").each(function() {
                var $el = jQuery(this);
                $el.vcwaypoint(function() {
                    $el.addClass("wpb_start_animation animated")
                }, { offset: "85%" });
            });
        }
    }
}

/* Toggle/FAQ
 ---------------------------------------------------------- */
if ( typeof window[ 'vc_toggleBehaviour' ] !== 'function' ) {
	window.vc_toggleBehaviour = function ( $el ) {
		var event = function ( e ) {
			e && e.preventDefault && e.preventDefault();
			var title = jQuery( this );
			var element = title.closest( '.vc_toggle' );
			var content = element.find( '.vc_toggle_content' );
			if ( element.hasClass( 'vc_toggle_active' ) ) {
				content.slideUp( {
					duration: 300,
					complete: function () {
						element.removeClass( 'vc_toggle_active' );
					}
				} );
			} else {
				content.slideDown( {
					duration: 300,
					complete: function () {
						element.addClass( 'vc_toggle_active' );
					}
				} );
			}
		};
		if ( $el ) {
			if ( $el.hasClass( 'vc_toggle_title' ) ) {
				$el.off( 'click' ).on('click', event );
			} else {
				$el.find( ".vc_toggle_title" ).off( 'click' ).on('click', event );
			}
		} else {
			jQuery( ".vc_toggle_title" ).off( 'click' ).on( 'click', event );
		}
	}
}

/* Tabs + Tours
 ---------------------------------------------------------- */
if ( typeof window[ 'vc_tabsBehaviour' ] !== 'function' ) {
	window.vc_tabsBehaviour = function ( $tab ) {
		if ( jQuery.ui ) {
			var $call = $tab || jQuery( '.wpb_tabs, .wpb_tour' ),
				ver = jQuery.ui && jQuery.ui.version ? jQuery.ui.version.split( '.' ) : '1.10',
				old_version = parseInt( ver[ 0 ] ) == 1 && parseInt( ver[ 1 ] ) < 9;
			$call.each( function ( index ) {
				var $tabs,
					interval = jQuery( this ).attr( "data-interval" ),
					tabs_array = [];
				//
				$tabs = jQuery( this ).find( '.wpb_tour_tabs_wrapper' ).tabs( {
					show: function ( event, ui ) {
						wpb_prepare_tab_content( event, ui );
					},
					beforeActivate: function ( event, ui ) {
						ui.newPanel.index() !== 1 && ui.newPanel.find( '.vc_pie_chart:not(.vc_ready)' );
					},
					activate: function ( event, ui ) {
						wpb_prepare_tab_content( event, ui );
					}
				} );
				if ( interval && interval > 0 ) {
					try {
						$tabs.tabs( 'rotate', interval * 1000 );
					} catch ( e ) {
						// nothing.
						window.console && window.console.log && console.log( e );
					}
				}

				jQuery( this ).find( '.wpb_tab' ).each( function () {
					tabs_array.push( this.id );
				} );

				jQuery( this ).find( '.wpb_tabs_nav li' ).click( function ( e ) {
					e.preventDefault();
					if ( old_version ) {
						$tabs.tabs( "select", jQuery( 'a', this ).attr( 'href' ) );
					} else {
						$tabs.tabs( "option", "active", jQuery( this ).index() );
					}
					return false;
				} );

				jQuery( this ).find( '.wpb_prev_slide a, .wpb_next_slide a' ).click( function ( e ) {
					e.preventDefault();
					if ( old_version ) {
						var index = $tabs.tabs( 'option', 'selected' );
						if ( jQuery( this ).parent().hasClass( 'wpb_next_slide' ) ) {
							index ++;
						}
						else {
							index --;
						}
						if ( index < 0 ) {
							index = $tabs.tabs( "length" ) - 1;
						}
						else if ( index >= $tabs.tabs( "length" ) ) {
							index = 0;
						}
						$tabs.tabs( "select", index );
					} else {
						var index = $tabs.tabs( "option", "active" ),
							length = $tabs.find( '.wpb_tab' ).length;

						if ( jQuery( this ).parent().hasClass( 'wpb_next_slide' ) ) {
							index = (index + 1) >= length ? 0 : index + 1;
						} else {
							index = index - 1 < 0 ? length - 1 : index - 1;
						}

						$tabs.tabs( "option", "active", index );
					}

				} );

			} );
		}
	}
}
;

/* Tabs + Tours
 ---------------------------------------------------------- */
if ( typeof window[ 'vc_accordionBehaviour' ] !== 'function' ) {
	window.vc_accordionBehaviour = function () {
		jQuery( '.wpb_accordion' ).each( function ( index ) {
			var $this = jQuery( this );
			var $tabs,
				interval = $this.attr( "data-interval" ),
				active_tab = ! isNaN( jQuery( this ).data( 'active-tab' ) ) && parseInt( $this.data( 'active-tab' ) ) > 0 ? parseInt( $this.data( 'active-tab' ) ) - 1 : false,
				collapsible = active_tab === false || $this.data( 'collapsible' ) === 'yes';
			//
			$tabs = $this.find( '.wpb_accordion_wrapper' ).accordion( {
				header: "> div > h3",
				autoHeight: false,
				heightStyle: "content",
				active: active_tab,
				collapsible: collapsible,
				navigation: true,

				activate: vc_accordionActivate,
				change: function ( event, ui ) {
					if ( jQuery.fn.isotope != undefined ) {
						ui.newContent.find( '.isotope' ).isotope( "layout" );
					}
				}
			} );
			if ( true === $this.data( 'vcDisableKeydown' ) ) {
				$tabs.data( 'uiAccordion' )._keydown = function () {
				};
			}
		} );
	}
}

if ( typeof window[ 'vc_google_fonts' ] !== 'function' ) {
	window.vc_google_fonts = function () {
		return false; // @todo check this for what this is needed
	}
}

/* Helper
 ---------------------------------------------------------- */
if ( typeof window[ 'wpb_prepare_tab_content' ] !== 'function' ) {
	/**
	 * Prepare html to correctly display inside tab container
	 *
	 * @param event - ui tab event 'show'
	 * @param ui - jquery ui tabs object
	 */
	window.wpb_prepare_tab_content = function ( event, ui ) {
		var panel = ui.panel || ui.newPanel,
			$pie_charts = panel.find( '.vc_pie_chart:not(.vc_ready)' );
		$pie_charts.length && jQuery.fn.vcChat && $pie_charts.vcChat();
		$ui_panel = panel.find( '.isotope, .wpb_image_grid_ul' ); // why var name '$ui_panel'?
		if ( $ui_panel.length > 0 ) {
			$ui_panel.isotope( "layout" );
		}
		if ( panel.parents( '.isotope' ).length ) {
			panel.parents( '.isotope' ).each( function () {
				jQuery( this ).isotope( "layout" );
			} );
		}
	}
}

var vc_accordionActivate = function ( event, ui ) {
	if ( ui.newPanel.length && ui.newHeader.length ) {
		var $pie_charts = ui.newPanel.find( '.vc_pie_chart:not(.vc_ready)' );
		if ( jQuery.fn.isotope != undefined ) {
			ui.newPanel.find( '.isotope, .wpb_image_grid_ul' ).isotope( "layout" );
		}
		$pie_charts.length && jQuery.fn.vcChat && $pie_charts.vcChat();
		if ( ui.newPanel.parents( '.isotope' ).length ) {
			ui.newPanel.parents( '.isotope' ).each( function () {
				jQuery( this ).isotope( "layout" );
			} );
		}
	}
};

/**
 * Insert youtube video into element.
 *
 * Video will be w/o controls, muted, autoplaying and looping.
 */
function insertYoutubeVideoAsBackground( $element, youtubeId, counter ) {
	if ( 'undefined' === typeof( YT.Player ) ) {
		// wait for youtube iframe api to load. try for 10sec, then abort
		counter = 'undefined' === typeof( counter ) ? 0 : counter;
		if ( 100 < counter ) {
			console.warn( 'Too many attempts to load YouTube api' );
			return;
		}

		setTimeout( function () {
			insertYoutubeVideoAsBackground( $element, youtubeId, counter ++ );
		}, 100 );

		return;
	}

	var $container = $element.prepend( '<div class="vc_video-bg"><div class="inner"></div></div>' ).find( '.inner' );

	new YT.Player( $container[ 0 ], {
		width: '100%',
		height: '100%',
		videoId: youtubeId,
		playerVars: {
			playlist: youtubeId,
			iv_load_policy: 3, // hide annotations
			enablejsapi: 1,
			disablekb: 1,
			autoplay: 1,
			controls: 0,
			showinfo: 0,
			rel: 0,
			loop: 1
		},
		events: {
			onReady: function ( event ) {
				event.target.mute().setLoop( true );
			}
		}
	} );

	vcResizeVideoBackground( $element );

	jQuery( window ).on( 'resize', function () {
		vcResizeVideoBackground( $element );
	} );
}

/**
 * Resize background video iframe so that video content covers whole area
 */
function vcResizeVideoBackground( $element ) {
	var iframeW,
		iframeH,
		marginLeft,
		marginTop,
		containerW = $element.innerWidth(),
		containerH = $element.innerHeight(),
		ratio1 = 16,
		ratio2 = 9;

	if ( ( containerW / containerH ) < ( ratio1 / ratio2 ) ) {
		iframeW = containerH * (ratio1 / ratio2);
		iframeH = containerH;

		marginLeft = - Math.round( ( iframeW - containerW ) / 2 ) + 'px';
		marginTop = - Math.round( ( iframeH - containerH ) / 2 ) + 'px';

		iframeW += 'px';
		iframeH += 'px';
	} else {
		iframeW = containerW;
		iframeH = containerW * (ratio2 / ratio1);

		marginTop = - Math.round( ( iframeH - containerH ) / 2 ) + 'px';
		marginLeft = - Math.round( ( iframeW - containerW ) / 2 ) + 'px';

		iframeW += 'px';
		iframeH += 'px';
	}

	$element.find( '.vc_video-bg iframe' ).css( {
		maxWidth: '1000%',
		marginLeft: marginLeft,
		marginTop: marginTop,
		width: iframeW,
		height: iframeH
	} );
}

/**
 * Extract video ID from youtube url
 */
function vcExtractYoutubeId( url ) {
	if ( 'undefined' === typeof(url) ) {
		return false;
	}

	var id = url.match( /(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/ );

	if ( null !== id ) {
		return id[ 1 ];
	}

	return false;
}