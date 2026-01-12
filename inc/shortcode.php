<?php
/**
 * Shortcodes khusus child theme.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

add_shortcode( 'velocity-pricelist', 'velocity_pricelist_shortcode' );
function velocity_pricelist_shortcode() {
    ob_start();
    $query = new WP_Query( array( 'post_type' => 'produk', 'posts_per_page' => -1 ) );
    if ( $query->have_posts() ) : ?>
        <header class="page-header mb-3 text-end">
            <a onclick="printArea('printsaya')" class="btn btn-dark text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer-fill me-1" viewBox="0 0 16 16">
                    <path d="M5 1a2 2 0 0 0-2 2v1H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zm0 1h6a1 1 0 0 1 1 1v1H4V3a1 1 0 0 1 1-1"/>
                    <path d="M11 9a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1z"/>
                    <path d="M1 7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1z"/>
                </svg>
                Print
            </a>
        </header>
        <div id="printsaya">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <?php get_template_part( 'loop-templates/pricelist' ); ?>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <?php get_template_part( 'loop-templates/content', 'none' ); ?>
    <?php endif;
    wp_reset_postdata();
    return ob_get_clean();
}
