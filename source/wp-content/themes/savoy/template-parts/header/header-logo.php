<?php
    $logo = nm_logo();
    $alt_logo = nm_alt_logo();
?>
<div class="nm-header-logo">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
        <img src="<?php echo esc_url( $logo['url'] ); ?>" class="nm-logo" width="<?php echo esc_attr( $logo['width'] ); ?>" height="<?php echo esc_attr( $logo['height'] ); ?>" alt="<?php bloginfo( 'name' ); ?>">
        <?php if ( $alt_logo ) : ?>
        <img src="<?php echo esc_url( $alt_logo['url'] ); ?>" class="nm-alt-logo" width="<?php echo esc_attr( $alt_logo['width'] ); ?>" height="<?php echo esc_attr( $alt_logo['height'] ); ?>" alt="<?php bloginfo( 'name' ); ?>">
        <?php endif; ?>
    </a>
</div>