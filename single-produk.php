<?php
/**
 * The template for displaying all single posts.
 *
 * @package just-f
 */

get_header();
$nowa = velocitytheme_option('nowa');
    if (substr($nowa, 0, 1) === '0') {
       $nowa    = '62' . substr($nowa, 1);
    } else if (substr($nowa, 0, 1) === '+') {
        $nowa    = '' . substr($nowa, 1);
    }
$single_simulasikredit   = velocitytheme_option('single_simulasi');
$imgUrl = wp_get_attachment_image_url(velocitytheme_option('foto_sales'), 'full');
$hargas = get_post_meta($post->ID, 'opsiharga',true);?>

<div class="container p-3 bg-white" id="single-wrapper">
	<main class="site-main" id="main">
		<?php while ( have_posts() ) : the_post(); ?>
		<div class="row">
		    <div class="col-md-8 pr-md-0">
		        <h3 class="text-white bg-dark h4 p-2 rounded-top"><?php echo get_the_title(); ?></h3>
		        <h4 class="text-dark h5">Deskripsi</h4>
		        <div class="row mb-2">
		            <div class="col-md-4">
                    	<a href="<?php echo get_permalink();?>">
                    	    <img src="<?php echo aq_resize( get_the_post_thumbnail_url(), 300, 180, true, true, true ); ?>" alt="<?php echo get_the_title(); ?>"/>
                    	</a>
		            </div>
		            <div class="col-md-8">
                    	<?php echo apply_filters('the_content', get_the_content()); ?>
		            </div>
		        </div>
                <?php if($hargas) :?>
			    <h4 class="text-dark h5">Pricelist</h4>
                <div class="">
                    <table class="table">
                        <thead class="bg-secondary text-white">
                        <tr>
                          <th scope="col">Tipe</th>
                          <th scope="col">Harga</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($hargas as $harga){
                                    echo '<tr>';
                                        echo '<td>';
                                            echo explode('=', $harga)[0];
                                        echo '</td>';
                                        echo '<td>';
                                            echo 'Rp '.number_format(preg_replace("/[^0-9]/", "", explode('=', $harga)[1]),'2',',','.').'';
                                        echo '</td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php endif;?>
		    </div>
		    <div class="col-md-4 text-center">
		        <div class="card mb-3 bg-light">
		            <div class="card-header bg-colortheme text-white">
		                Kontak kami
		            </div>
			        <div class="mx-auto" style="background-image:url('<?php echo $imgUrl; ?>');height: 350px;width: 100%;background-size: cover;"></div>
			        <div class="p-2">
				        <h6 class="text-dark"><?php echo velocitytheme_option('nama_sales');?></h6>
				        <p><a class="text-colortheme" href="tel:<?php echo velocitytheme_option('notelp');?>"><i class="fa fa-phone" aria-hidden="true"></i> <?php echo velocitytheme_option('notelp');?></a><br>
				        <a class="text-colortheme" href="https://wa.me/<?php echo $nowa;?>"><i class="fa fa-whatsapp" aria-hidden="true"></i> <?php echo $nowa;?></a></p>
			        </div>
		        </div>
		        <div class="card bg-light">
		            <div class="card-header bg-colortheme text-white">
		                Hubungi Kami
		            </div>
			        <div class="p-2">
				        <form id="ordermobil" method="POST">
				            <input name="nama" class="form-control mb-2" type="text" placeholder="Nama" required/>
				            <input name="hp" class="form-control mb-2" type="text" placeholder="No HP" required/>
				            <input name="email" class="form-control mb-2" type="text" placeholder="Email" required/>
				            <textarea class="form-control mb-2" name="pesan">Saya mohon informasi lebih lanjut terkait <?php echo get_the_title();?></textarea>
				            <?php echo velocitytoko_display_recaptcha();?>
				            <input type="submit" class="btn btn-dark mb-2" value="Kirim">
				        </form>
				        <div class="respon">
				            <?php
				            // print_r($_SESSION);
				            ?>
				        </div>
			        </div>
		        </div>
		    </div>
		</div>
		
    <?php if($single_simulasikredit == 'on'): ?>
		<div class="card my-3">
		    <h4 class="text-dark h5 card-header">Simulasi kredit</h4>
		    <div class="card-body">
            <?php velocity_simulasi(); ?>
		    </div>
		</div>
    <?php endif;?>

			<?php
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
		// 		comments_template();
			endif;
			?>

		<?php endwhile; // end of the loop. ?>


	</main><!-- #main -->
    <div class="mt-3 card">
        <h4 class="text-dark card-header">Produk Terkait</h4>
        <div class="row card-body">
            <?php 
            $the_query = new WP_Query( array( 'post_type' => 'produk', 'posts_per_page' => 4 ) );
            if ( $the_query->have_posts() ) {
            	while ( $the_query->have_posts() ) {
            		$the_query->the_post();  
        			$harga  = get_post_meta($post->ID, 'opsiharga', true);
					$dp = get_post_meta($post->ID, 'dpminimal', true);
					$cicilan = get_post_meta($post->ID, 'cicilanminimal', true); ?>

					<article <?php post_class('col-md-3 col-6 mb-3 px-2 container'); ?> id="post-<?php the_ID(); ?>">
						<div class="card p-md-1 p-0 border-0">
							<a href="<?php echo get_permalink();?>">
								<img src="<?php echo aq_resize( get_the_post_thumbnail_url(), 300, 180, true, true, true ); ?>" alt="<?php echo get_the_title(); ?>"/>
							</a>
							<?php the_title( sprintf( '<h2 class="entry-title text-center h5 fw-bold bg-light p-2 m-0"><a class="text-dark" href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
								'</a></h2>' ); ?>
							<div class="detail-harga mb-2">
								<div class="bg-colortheme text-white p-md-2 p-1 mb-1">Harga Mulai Rp <?php echo number_format(preg_replace("/[^0-9]/", "", explode('=', $harga[0])[1]),'2',',','.'); ?></div>
								<div class="bg-colortheme text-white p-md-2 p-1 mb-1">DP Mulai <?php echo $dp; ?></div>
								<div class="bg-colortheme text-white p-md-2 p-1 mb-1">Cicilan Mulai <?php echo $cicilan; ?></div>
							</div>
						</div>
					</article><!-- #post-## -->
            	<?php } // end while
            } // end if
            ?>
        </div>
        
    </div>
</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
