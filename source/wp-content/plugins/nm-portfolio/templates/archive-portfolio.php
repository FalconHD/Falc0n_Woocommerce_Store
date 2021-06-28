<?php
global $nm_portfolio_options, $nm_theme_options;

// Portfolio options
$nm_portfolio_options = array(
    'page_layout'           => $nm_theme_options['portfolio_page_layout'],
    'categories'            => $nm_theme_options['portfolio_categories'],
    'categories_alignment'  => $nm_theme_options['portfolio_categories_alignment'],
    'categories_js'         => $nm_theme_options['portfolio_categories_js'],
    'layout'                => $nm_theme_options['portfolio_layout'],
    'packery'               => $nm_theme_options['portfolio_packery'],
    'columns'               => $nm_theme_options['portfolio_columns']
);

get_header(); ?>

<div class="nm-portfolio-wrap">
    <div class="nm-row nm-row-<?php echo esc_attr( $nm_portfolio_options['page_layout'] ); ?>">
        <div class="col-xs-12">
        
        <?php 
            if ( have_posts() ) :

                include( nm_portfolio_include_dir( 'content-portfolio-before.php' ) );

                while ( have_posts() ) : the_post(); // Start the Loop
                    include( nm_portfolio_include_dir( 'content-portfolio.php' ) );
                endwhile;

                include( nm_portfolio_include_dir( 'content-portfolio-after.php' ) );

            else :

                include( nm_portfolio_include_dir( 'content-portfolio-empty.php' ) );

            endif; 
        ?>
    
        </div>
    </div>
</div>

<?php get_footer(); ?>