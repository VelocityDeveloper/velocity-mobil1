<?php
/**
 * The template for displaying all single posts.
 *
 * @package just-f
 */

get_header();
$nama_sales = velocitytheme_option('nama_sales');
$notelp = velocitytheme_option('notelp');
$nowa = velocitytheme_option('nowa');
if (!empty($nowa)) {
    if (substr($nowa, 0, 1) === '0') {
        $nowa = '62' . substr($nowa, 1);
    } else if (substr($nowa, 0, 1) === '+') {
        $nowa = '' . substr($nowa, 1);
    }
}
$single_simulasikredit   = velocitytheme_option('single_simulasi', 'on');
$imgUrl = wp_get_attachment_image_url(velocitytheme_option('foto_sales'), 'full');
$hargas = get_post_meta($post->ID, 'opsiharga',true);?>

<div class="container px-3 bg-white" id="single-wrapper">
	<main class="site-main" id="main">
		<?php while ( have_posts() ) : the_post(); ?>
		<div class="row">
		    <div class="col-md-9 pr-md-0">
		        <h1 class="text-white bg-dark h4 p-2 rounded-top"><?php echo get_the_title(); ?></h1>
		        <div class="row mb-2">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="col-md-4">
							<a href="<?php echo get_permalink();?>">
								<img src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"/>
							</a>
						</div>
					<?php endif; ?>
		            <div class="col">
                    	<?php echo apply_filters('the_content', get_the_content()); ?>
		            </div>
		        </div>
                <?php if($hargas) :?>
			    <h4 class="text-dark h5">Pricelist</h4>
                <div class="table-responsive mb-3">
                    <table class="table">
                        <thead class="bg-secondary text-white">
                        <tr>
                          <th scope="col" class="text-white">Tipe</th>
                          <th scope="col" class="text-white">Harga</th>
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
                                            echo 'Rp ' . velocitychild_format_price_from_opsiharga( $harga );
                                        echo '</td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php endif;?>
		    </div>
		    <div class="col-md-3 text-center">
		        <div class="card mb-3 bg-light">
		            <div class="card-header bg-colortheme text-white">
		                Kontak kami
		            </div>
					<?php if( !empty( $imgUrl ) ): ?>
			        	<img src="<?php echo $imgUrl; ?>" alt="Sales Image">
					<?php endif; ?>
			        <div class="p-2">
				        <?php if( !empty( $nama_sales ) ): ?>
				        <h6 class="text-dark"><?php echo $nama_sales;?></h6>
				        <?php endif; ?>
				        <?php if( !empty( $notelp ) ): ?>
				        <p><a class="text-colortheme" href="tel:<?php echo $notelp;?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-telephone-fill me-1" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.01c-.362-1.03-.037-2.137.703-2.877z"/>
                            </svg>
                            <?php echo $notelp;?></a></p>
				        <?php endif; ?>
				        <?php if( !empty( $nowa ) ): ?>
				        <p><a class="text-colortheme" href="https://wa.me/<?php echo $nowa;?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-whatsapp me-1" viewBox="0 0 16 16">
                                <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                            </svg>
                            <?php echo $nowa;?></a></p>
				        <?php endif; ?>
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
				            <?php echo velocity_mobil1_recaptcha();?>
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

		<?php endwhile; // end of the loop. ?>


	</main><!-- #main -->
    <div class="mt-3 card">
        <h4 class="text-dark card-header">Produk Terkait</h4>
        <div class="row card-body">
            <?php 
            $the_query = new WP_Query( array( 'post_type' => 'produk', 'posts_per_page' => 4, 'post__not_in' => array( get_the_ID() ) ) );
            if ( $the_query->have_posts() ) {
            	while ( $the_query->have_posts() ) {
            		$the_query->the_post(); 
					get_template_part( 'loop-templates/content', 'produk'); 
        		} // end while
            } // end if
            ?>
        </div>
        
    </div>
</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
