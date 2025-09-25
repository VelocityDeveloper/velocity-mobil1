<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package velocity
 */
$harga  = get_post_meta($post->ID, 'opsiharga', true);
$dp = get_post_meta($post->ID, 'dpminimal', true);
$cicilan = get_post_meta($post->ID, 'cicilanminimal', true); ?>

<article <?php post_class('col-md-4 col-6 mb-3 px-2 container'); ?> id="post-<?php the_ID(); ?>">
    <div class="card p-md-3 p-0 border-0">
    	<a href="<?php echo get_permalink();?>">
    	    <img src="<?php echo aq_resize( get_the_post_thumbnail_url(), 300, 180, true, true, true ); ?>" alt="<?php echo get_the_title(); ?>"/>
    	</a>
    	<?php the_title( sprintf( '<h2 class="entry-title text-center h4 fw-bold bg-light p-2 m-0"><a class="text-dark" href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
    		'</a></h2>' ); ?>
        <div class="detail-harga mb-2">
            <div class="bg-colortheme text-white p-md-2 p-1 mb-1">Harga Mulai Rp <?php echo number_format(preg_replace("/[^0-9]/", "", explode('=', $harga[0])[1]),'2',',','.'); ?></div>
            <div class="bg-colortheme text-white p-md-2 p-1 mb-1">DP Mulai <?php echo $dp; ?></div>
            <div class="bg-colortheme text-white p-md-2 p-1 mb-1">Cicilan Mulai <?php echo $cicilan; ?></div>
        </div>
    </div>
</article><!-- #post-## -->
