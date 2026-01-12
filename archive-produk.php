<?php

/**
 * The template for displaying archive pages
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package velocity
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

$container = velocitytheme_option('justg_container_type', 'container');
?>

<div class="wrapper" id="archive-wrapper">

    <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

        <div class="card shadow-sm bg-light pt-2 px-3 mb-3">
            <?php echo justg_breadcrumb(); ?>
        </div>

        <div class="row m-0">
            <!-- Do the left sidebar check -->
            <?php //do_action('justg_before_content'); ?>

            <main class="site-main col order-2 px-0" id="main">

                <?php

                if (have_posts()) {
                ?>
                    <header class="page-header block-primary">
                        <?php
						the_archive_title( '<h1 class="text-dark h4">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
						?>
                    </header><!-- .page-header -->

                    <div class="row m-0">
                    <?php
                    // Start the loop.
                    while (have_posts()) { the_post();
                        get_template_part( 'loop-templates/content', 'produk');
                    }?>
                    </div>
                
                <?php
                } else {
                    get_template_part('loop-templates/content', 'none');
                }
                ?>
                <!-- Display the pagination component. -->
                <?php justg_pagination(); ?>

            </main><!-- #main -->

            <!-- Do the right sidebar check. -->
            <?php //do_action('justg_after_content'); ?>

        </div><!-- .row -->

    </div><!-- #content -->

</div><!-- #archive-wrapper -->

<?php
get_footer();