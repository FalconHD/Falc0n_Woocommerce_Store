    </ul>

    <nav class="nm-portfolio-pagination">
    <?php
    echo paginate_links( apply_filters( 'nm_portfolio_pagination_args',
        array(
            'base'      => str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) ),
            'format'    => '?paged=%#%',
            'current'   => max( 1, get_query_var( 'paged' ) ),
            'prev_text' => '&larr;',
            'next_text' => '&rarr;',
            'type'      => 'list',
        )
    ) );
    ?>
    </nav>
    
</div>

<?php do_action( 'nm_portfolio_after' ); ?>
