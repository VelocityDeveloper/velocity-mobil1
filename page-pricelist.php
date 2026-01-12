<?php /* Template Name: Pricelist */ 
get_header();
$container   = get_theme_mod( 'just_f_container_type' );
?>

<div class="container p-3 bg-white" id="archive-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

			<main class="site-main" id="main">

				<?php 
				$query = new WP_Query( array( 'post_type' => 'produk', 'posts_per_page' => '-1' ) );
				if ( $query->have_posts() ) : ?>

					<header class="page-header row mb-3">
					    <div class="col-md-8">
    						<?php
    						the_title( '<h1 class="text-dark h4">', '</h1>' );
    						?>
					    </div>
					    <div class="col-md-4 text-end">
					        <a onclick="printArea('printsaya')" class="btn btn-dark text-white"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
					    </div>

					</header><!-- .page-header -->

					<div id="printsaya">
    					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
    
    						<?php
    						get_template_part( 'loop-templates/pricelist');
    						?>
    
    					<?php endwhile; ?>
					</div> <!-- .row -->

				<?php else : ?>

					<?php get_template_part( 'loop-templates/content', 'none' ); ?>

				<?php endif; ?>

			</main><!-- #main -->

			<!-- The pagination component -->
			<?php justg_pagination(); ?>

		</div><!-- #primary -->


	

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
