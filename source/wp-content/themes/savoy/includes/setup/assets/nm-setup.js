(function($) {
    
	'use strict';
    
    function NM_Setup() {
        var self = this;
        
        // Form button callbacks
        self.callbacks = {
            do_next_step: function(btn) {
                self.stepShowNext(btn);
            },
            page_builder_select: function(btn) {
                self.pageBuilderSelect();
            },
            plugins_install: function(btn) {
                self.pluginsInstall();
            },
            content_install: function(btn) {
                self.contentInstall();
            }
        };
        
        self.init();
    }
    
    NM_Setup.prototype = {
    
        /**
         * Initialize
         */
        init: function() {
            var self = this;
            
            // Show initial step
            var pageUrl = new URL(window.location.href),
                pageBuilderSelectionQS = pageUrl.searchParams.get('pbselected');
            if (pageBuilderSelectionQS) {
                $('.nm-setup-steps li.step-plugins').addClass('active');
                self.stepSetActiveBreadcrumb();
            } else {
                $('.nm-setup-steps li.step:first-child').addClass('active');
            }

            // Bind: Setup buttons
            $('.nm-setup-button').on('click', function(e) {
                e.preventDefault();
                self.setupNoticeHide();
                $('.nm-setup-view').addClass('loading');
                self.callbacks[$(this).data('callback')](this);
            });
        },

        
        /**
         * Setup notice: Show
         */
        setupNoticeShow( notice, type ) {
            var $notice = $('#nm-setup-notice');
            $notice.children('p').html('Setup error: '+notice);
            $notice.removeClass().addClass('notice notice-'+type);
            
            console.log('NM Setup - '+notice);
        },
        
        
        /**
         * Setup notice: Hide
         */
        setupNoticeHide() {
            $('#nm-setup-notice').addClass('hide');
        },
        
        
        /**
         * Step: Show next step
         */
        stepShowNext: function(btn) {
            var self = this;
            setTimeout(function() {
                // Set active step
                var $stepActive = $('.nm-setup-steps').children('.active');
                $stepActive.removeClass('active');
                $stepActive.next().addClass('active');
                
                // Set active breadcrumb
                self.stepSetActiveBreadcrumb();
                
                // Hide loader
                self.stepHideLoader();
            }, 250);
        },
        
        
        /**
         * Step: Hide "loader"
         */
        stepHideLoader: function() {
            $('.nm-setup-view').removeClass('loading');
        },
        
        
        /**
         * Step: Set active breadcrumb
         */
        stepSetActiveBreadcrumb: function($stepActive) {
            var $breadcrumbs = $('.nm-setup-breadcrumbs'),
                $stepActive = $('.nm-setup-steps').children('.active'),
                $breadcrumbActive = $breadcrumbs.children('.nav-step-'+$stepActive.data('step'));
            
            $breadcrumbActive = ($breadcrumbActive.length) ? $breadcrumbActive : $breadcrumbs.children().first();
            
            $breadcrumbs.children('.active').removeClass('active');
            $breadcrumbActive.addClass('active');
        },
        
        
        /**
         * Page builder: Save selection
         */
        pageBuilderSelect: function() {
            var self = this,
                selection = $('#nm-setup-page-builder-select').find('input:checked').val();
            
            $.ajax({
                type: 'POST',
                url: nm_setup_params.ajaxurl,
                data: {
                    action: 'page_builder_save_selection',
                    wpnonce: nm_setup_params.wpnonce,
                    selection: selection
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    self.setupNoticeShow('pageBuilderSelect(): '+errorThrown, 'error');
                    self.stepHideLoader();
                },
                success: function(response) {
                    console.log('NM Setup - Task complete: Page builder selection');
                    console.log('NM Setup - Response: '+response);
                    
                    // Reload page to refresh TGMPA config - "pbselected" query string used to set "active" step
                    window.location.search += '&pbselected=1';
                }
            });
        },
        
        
        /**
         * Plugins: Install
         */
        pluginsInstall: function() {
            var self = this;
                
            var complete,
                items_completed = 0,
                current_item = '',
                $current_node,
                current_item_hash = '';

            function _ajaxCallback(response) {
                if (typeof response == 'object' && typeof response.message != 'undefined') {
                    $current_node.find('span').text(response.message);
                    if (typeof response.url != 'undefined') {
                        // we have an ajax url action to perform.

                        if (response.hash == current_item_hash) {
                            $current_node.find('span').text('Failed');
                            _findNext();
                        } else {
                            current_item_hash = response.hash;
                            jQuery.post(response.url, response, function(response2) {
                                _processCurrent();
                                //NM: $current_node.find('span').text(response.message + ' verifying');
                                $current_node.find('span').text('Verifying');
                            }).fail(_ajaxCallback);
                        }
                    } else if (typeof response.done != 'undefined') {
                        // Finished processing this plugin, move onto next
                        _findNext();
                    } else {
                        // Error processing this plugin
                        _findNext();
                    }
                } else {
                    // Error - try again with next plugin
                    $current_node.find('span').text('Ajax error');
                    _findNext();
                }
            };
            function _processCurrent() {
                if (current_item) {
                    // Query our ajax handler to get the ajax to send to TGM
                    // If we don't get a reply we can assume everything worked and continue onto the next one
                    jQuery.post(nm_setup_params.ajaxurl, {
                        action: 'plugins_install',
                        wpnonce: nm_setup_params.wpnonce,
                        slug: current_item
                    }, _ajaxCallback).fail(_ajaxCallback);
                }
            };
            function _findNext() {
                var do_next = false;
                if ($current_node) {
                    if (!$current_node.data('done_item')) {
                        items_completed++;
                        $current_node.data('done_item', 1);
                    }
                    $current_node.find('.spinner').css('visibility', 'hidden');
                    // NM: Hide plugin from list
                    $current_node.slideUp(200);
                }
                var $li = $('.nm-setup-tasks-plugins li');
                $li.each(function() {
                    if (current_item == '' || do_next) {
                        current_item = $(this).data('slug');
                        $current_node = $(this);
                        _processCurrent();
                        do_next = false;
                    } else if($(this).data('slug') == current_item) {
                        do_next = true;
                    }
                });
                if (items_completed >= $li.length) {
                    // finished all plugins!
                    _complete();
                }
            };
            function _complete() {
                self.stepShowNext();
            };
            
            //NM: $('.envato-wizard-plugins').addClass('installing');
            _findNext();
        },
        
        
        /**
         * Content: Install
         */
        contentInstall: function() {
            var self = this;
            
            /* Set progress messages */
            var _setProgressMessage = function(selector, message, hide) {
                var $taskElement = $(selector);
                $taskElement.find('span').html(message);
                if (hide) { $taskElement.slideUp(200); }
            },

            /* AJAX Callback */
            _ajaxCallback = function(response, taskComplete) {
                console.log('NM Setup - Task complete: '+taskComplete);
                console.log('NM Setup - Response: '+response);
            },

            /* AJAX: Install settings */
            _ajaxInstallSettings = function() {
                $.ajax({
                    type: 'POST',
                    url: nm_setup_params.ajaxurl,
                    data: {
                        action: 'content_install',
                        wpnonce: nm_setup_params.wpnonce,
                        task: 'settings'
                    },
                    beforeSend: function() {
                        _setProgressMessage('.nm-setup-task-settings', 'Configuring Settings...');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        self.setupNoticeShow('_ajaxInstallSettings(): '+errorThrown, 'error');
                        self.stepHideLoader();
                        _setProgressMessage('.nm-setup-task-settings', '<em class="error">Failed, please try again</em>');
                    },
                    success: function(response) {
                        _setProgressMessage('.nm-setup-task-settings', 'Done', true);

                        _ajaxCallback(response, 'settings');
                        self.stepShowNext();
                    }
                });
            },

            /* AJAX: Install widgets */
            _ajaxInstallWidgets = function() {
                $.ajax({
                    type: 'POST',
                    url: nm_setup_params.ajaxurl,
                    data: {
                        action: 'content_install',
                        wpnonce: nm_setup_params.wpnonce,
                        task: 'widgets'
                    },
                    beforeSend: function() {
                        _setProgressMessage('.nm-setup-task-content', 'Importing Widgets...');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        self.setupNoticeShow('_ajaxInstallWidgets(): '+errorThrown, 'error');
                        self.stepHideLoader();
                        _setProgressMessage('.nm-setup-task-content', '<em class="error">Failed, please try again</em>');
                    },
                    success: function(response) {
                        _setProgressMessage('.nm-setup-task-content', 'Done', true);

                        _ajaxCallback(response, 'widgets');
                        _ajaxInstallSettings();
                    }
                });
            },

            /* AJAX: Install content */
            _ajaxInstallContent = function() {
                $.ajax({
                    type: 'POST',
                    url: nm_setup_params.ajaxurl,
                    data: {
                        action: 'content_install',
                        wpnonce: nm_setup_params.wpnonce,
                        task: 'content'
                    },
                    beforeSend: function() {
                        _setProgressMessage('.nm-setup-task-content', 'Importing Content...');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        self.setupNoticeShow('_ajaxInstallContent(): '+errorThrown, 'error');
                        self.stepHideLoader();
                        _setProgressMessage('.nm-setup-task-content', '<em class="error">Failed, please try again</em>');
                    },
                    success: function(response) {
                        _setProgressMessage('.nm-setup-task-content', 'Done');

                        _ajaxCallback(response, 'content');
                        _ajaxInstallWidgets();
                    }
                });
            },

            /* AJAX: Install WooCommerce taxonomies */
            _ajaxInstallWooCommerceTaxonomies = function() {
                $.ajax({
                    type: 'POST',
                    url: nm_setup_params.ajaxurl,
                    data: {
                        action: 'content_install',
                        wpnonce: nm_setup_params.wpnonce,
                        task: 'woocommerce_taxonomies'
                    },
                    beforeSend: function() {
                        _setProgressMessage('.nm-setup-task-content', 'Installing WooCommerce Taxonomies...');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        self.setupNoticeShow('_ajaxInstallWooCommerceTaxonomies(): '+errorThrown, 'error');
                        self.stepHideLoader();
                        _setProgressMessage('.nm-setup-task-content', '<em class="error">Failed, please try again</em>');
                    },
                    success: function(response) {
                        // Make sure WooCommerce plugin is activated before continuing
                        if (response == 'woocommerce na') {
                            console.log('NM Setup - Error: WooCommerce not installed, stopping.');
                            _setProgressMessage('.nm-setup-task-content', '<em class="error">WooCommerce plugin not activated, please try again</em>');
                            setTimeout(function() { location.reload(); }, 2000); // Reload setup page
                            return;
                        }

                        _setProgressMessage('.nm-setup-task-content', 'Done');

                        _ajaxCallback(response, 'woocommerce_taxonomies');
                        _ajaxInstallContent();
                    }
                });
            };            
            
            // Start installation
            _ajaxInstallWooCommerceTaxonomies();
        }
    
    };
    
    
    $(function() { // Doc ready
		new NM_Setup();
	});
	
	
})(jQuery);