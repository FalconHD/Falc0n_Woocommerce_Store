(function($) {
    
    'use strict';
    
    $(window).on('elementor:init', function() {
        
        var ControlBaseDataView = elementor.modules.controls.BaseData;
        
        /*
         * Control: Icons
         *
         * Based on the Elementor Choose control: https://github.com/elementor/elementor/blob/master/assets/dev/js/editor/controls/choose.js
         */
        var ControlIconsItemView = elementor.modules.controls.BaseData.extend( {
            ui: function() {
                var ui = ControlBaseDataView.prototype.ui.apply( this, arguments );

                ui.inputs = '[type="radio"]';
                // NM
                ui.nmSearchInput = '.nm-elementor-control-icon-search';
                // /NM

                return ui;
            },
            events: function() {
                return _.extend( ControlBaseDataView.prototype.events.apply( this, arguments ), {
                    'mousedown label': 'onMouseDownLabel',
                    'click @ui.inputs': 'onClickInput',
                    'change @ui.inputs': 'onBaseInputChange',
                    'input @ui.nmSearchInput': 'nmOnSearch',
                } );
            },
            applySavedValue: function() {
                const currentValue = this.getControlValue();

                if ( currentValue ) {
                    this.ui.inputs.filter( '[value="' + currentValue + '"]' ).prop( 'checked', true );
                } else {
                    this.ui.inputs.filter( ':checked' ).prop( 'checked', false );
                }
            },
            onMouseDownLabel: function( event ) {
                var $clickedLabel = this.$( event.currentTarget ),
                    $selectedInput = this.$( '#' + $clickedLabel.attr( 'for' ) );

                $selectedInput.data( 'checked', $selectedInput.prop( 'checked' ) );
            },
            onClickInput: function( event ) {
                if ( ! this.model.get( 'toggle' ) ) {
                    return;
                }

                var $selectedInput = this.$( event.currentTarget );

                if ( $selectedInput.data( 'checked' ) ) {
                    $selectedInput.prop( 'checked', false ).trigger( 'change' );
                }
            },
            // NM
            nmOnSearch: function(event) {
                var self = this,
                    timer = null;
                
                if (timer) { clearTimeout(timer); }
                timer = setTimeout(function() {
                    var $input = $(event.target),
                        searchKey = $input.val().replace(/ /g,''); // Whitespace removed                                        
                    
                    if (searchKey.length > 1) {
                        $input.next('.elementor-choices').addClass('is-search');
                        var iconTitle;
                        
                        for (var i = 0; i < self.ui.tooltipTargets.length; i++) {
                            iconTitle = self.ui.tooltipTargets[i].getAttribute('original-title').toLowerCase();
                            
                            if (iconTitle.includes(searchKey)) {
                                self.ui.tooltipTargets[i].classList.add('show');
                            } else {
                                self.ui.tooltipTargets[i].classList.remove('show');
                            }
                        }
                    } else {
                        $input.next('.elementor-choices').removeClass('is-search');
                    }
                }, 400);
            }
            // /NM
        }, {
            onPasteStyle: function( control, clipboardValue ) {
                return '' === clipboardValue || undefined !== control.options[ clipboardValue ];
            },
        } );
        
        elementor.addControlView(
            'nm-icons',
            ControlIconsItemView
        );
        
    });
    
})(jQuery);