wp.domReady(() => {
    // Utility: Uncomment to log available blocks styles
    /*wp.blocks.getBlockTypes().forEach((block) => {
        if (_.isArray(block['styles'])) {
            console.log(block.name, _.pluck(block['styles'], 'name'));
        }
    });*/
    
    // Remove block styles
	wp.blocks.unregisterBlockStyle( 'core/quote', [ 'default', 'large' ] );
    wp.blocks.unregisterBlockStyle( 'core/pullquote', [ 'default', 'solid-color' ] );
});

/* Add custom class-name to blocks: https://poolghost.com/add-custom-default-class-names-to-gutenberg-blocks/ */
var nmBlocksAddClassName = function(props, blockType, attributes) {
    var notDefined = (typeof props.className === 'undefined' || !props.className) ? true : false;
    
    if (blockType.name === 'core/heading') {
        return Object.assign(props, { className: notDefined ? 'nm-block-heading' : 'nm-block-heading ' + props.className });
    }
    
    if (blockType.name === 'core/list') {
        return Object.assign(props, {
            className: notDefined ? 'nm-block-list' : 'nm-block-list ' + props.className
        });
    }
    
    return props;
}
wp.hooks.addFilter('blocks.getSaveContent.extraProps', 'nm-theme/blocks-add-class-name', nmBlocksAddClassName); // Hook