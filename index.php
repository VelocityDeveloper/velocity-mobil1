<?php
/**
 * The main template file
 *
 * @package justg
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
$container = velocitytheme_option('justg_container_type', 'container');
$home_simulasikredit   = velocitytheme_option('home_simulasi', 'on');
$sliders = velocitytheme_option('slider_repeat');
$kategori = velocitytheme_option('category_home');
$nama_sales = velocitytheme_option('nama_sales');
$notelp = velocitytheme_option('notelp');
$email = velocitytheme_option('email');
$nowa = velocitytheme_option('nowa');
$imgUrl = wp_get_attachment_image_url(velocitytheme_option('foto_sales'), 'full');
if (!empty($nowa)) {
    if (substr($nowa, 0, 1) === '0') {
        $nowa = '62' . substr($nowa, 1);
    } else if (substr($nowa, 0, 1) === '+') {
        $nowa = '' . substr($nowa, 1);
    }
}
?>

<div class="wrapper p-0" id="index-wrapper">
    <?php if( !empty( $sliders ) ): ?>
    <div id="carouselExampleInterval" class="carousel slide carousel-fade mb-4" data-bs-ride="carousel">
        <div class="carousel-inner">
        <?php $i = 0;
            foreach ($sliders as $slider) : $i++;
            $active = $i==1 ? 'active' : '';?>
                <div class="carousel-item <?php echo $active;?>" data-bs-interval="3000">
                    <img class="ratio ratio-16x9" src="<?php echo $slider['imgslider']; ?>" alt="...">
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <?php endif; ?>

    <div class="" id="content" tabindex="-1">
        <main class="site-main col order-2" id="main">
            <div class="<?php echo esc_attr($container); ?> my-5 py-2">
                <div class="produk-content">
                <?php
                    $args = [
                        'post_type' => 'produk', // Ganti 'produk' dengan nama post type custom Anda
                        'posts_per_page' => 6, // Jumlah post yang ingin ditampilkan
                        'order' => 'DESC',
                        'orderby' => 'date',
                    ];
                    
                    // Membuat instance WP_Query
                    $product_query = new WP_Query($args);
                    
                    // Loop untuk menampilkan post
                    if ($product_query->have_posts()) { ?>
                
                    <h3 class="titleProduk text-light text-center h4"><span>Pilih Model Terbaik</span></h3>
                        <div class="row mx-0 mt-5">
                        <?php
                            // Start the loop.
                            while ($product_query->have_posts()) : $product_query->the_post();
                            get_template_part( 'loop-templates/content', 'produk');
                            endwhile;
                        ?>
                        </div>
                        <div class="more-post text-center">
                            <a class="btn btn-primary fs-6 rounded-1" href="<?php echo get_home_url();?>/produk">Selengkapnya</a>
                        </div>
                
                <?php } else {
                        the_content();
                    }?>
                </div>
            </div>

            <div class="bg-light py-5">
                <div class="<?php echo esc_attr($container); ?> bg-transparent">
                    <div class="row py-4 align-items-center mx-0">
                        <div class="col-lg-3 col-md-6">
                            <?php if( !empty( $imgUrl ) ): ?>
                                <img src="<?php echo $imgUrl; ?>" class="rounded mb-2" alt="Sales Image">
                            <?php endif; ?>
                            <?php if( !empty( $nama_sales ) ): ?>
                                <div class="alert alert-primary text-center p-2" role="alert">
                                    <h5 class="fw-bold m-0"><?php echo $nama_sales;?></h5>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col">
                            <div class="p-2">
                                <?php if( !empty( $notelp ) ): ?>
                                    <p><a class="text-dark d-flex align-items-center gap-2" href="tel:<?php echo $notelp;?>" target="_blank">
                                        <span class="bg-colortheme text-white d-inline-flex align-items-center justify-content-center rounded-circle contact-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.01c-.362-1.03-.037-2.137.703-2.877z"/>
                                            </svg>
                                        </span>
                                        <span class="h5 fw-bold mb-0"><?php echo $notelp;?></span>
                                    </a></p>
                                <?php endif; ?>
                                <?php if( !empty( $nowa ) ): ?>
                                    <p><a class="text-dark d-flex align-items-center gap-2" href="https://api.whatsapp.com/send?phone=<?php echo $nowa;?>" target="_blank">
                                        <span class="bg-colortheme text-white d-inline-flex align-items-center justify-content-center rounded-circle contact-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                                                <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943.049-.084-.182-.133-.38-.232z"/>
                                            </svg>
                                        </span>
                                        <span class="h5 fw-bold mb-0">+<?php echo $nowa;?></span>
                                    </a></p>
                                <?php endif; ?>
                                <?php if( !empty( $email ) ): ?>
                                    <p><a class="text-dark d-flex align-items-center gap-2" href="mailto:<?php echo $email;?>" target="_blank">
                                        <span class="bg-colortheme text-white d-inline-flex align-items-center justify-content-center rounded-circle contact-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                                <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414z"/>
                                                <path d="M0 4.697v7.104l5.803-3.558z"/>
                                                <path d="M6.761 8.83 0 12.97A2 2 0 0 0 2 14h12a2 2 0 0 0 2-1.03l-6.761-4.14L8 9.586z"/>
                                                <path d="M10.197 8.243 16 11.801V4.697z"/>
                                            </svg>
                                        </span>
                                        <span class="h5 fw-bold mb-0"><?php echo $email;?></span>
                                    </a></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if($home_simulasikredit == 'on'): ?>
                            <div class="col-lg-5 col-md-12">
                                <div class="card my-3">
                                    <h4 class="text-dark h5 card-header">Simulasi kredit</h4>
                                    <div class="card-body">
                                    <?php velocity_simulasi(); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </main><!-- #main -->
    </div><!-- #content -->

</div><!-- #index-wrapper -->

<?php
get_footer();
