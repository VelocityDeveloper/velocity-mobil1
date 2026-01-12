<?php
/* Template Name: Home Template */ 

get_header();
$container = velocitytheme_option('justg_container_type', 'container');
$single_simulasikredit   = velocitytheme_option('single_simulasi');
$sliders = velocitytheme_option('slider_repeat');
$kategori = velocitytheme_option('category_home');
$imgUrl = wp_get_attachment_image_url(velocitytheme_option('foto_sales'), 'full');
$nowa = velocitytheme_option('nowa');
if (substr($nowa, 0, 1) === '0') {
    $nowa    = '62' . substr($nowa, 1);
} else if (substr($nowa, 0, 1) === '+') {
    $nowa    = '' . substr($nowa, 1);
}
?>

<div class="wrapper p-0" id="index-wrapper">
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

    <div class="" id="content" tabindex="-1">
        <main class="site-main col order-2" id="main">
            <div class="<?php echo esc_attr($container); ?> my-5">
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

            <div class="bg-light">
                <div class="<?php echo esc_attr($container); ?> bg-transparent">
                    <div class="row py-4 align-items-center mx-0">
                        <div class="col-lg-3 col-md-6">
                            <div class="mx-auto mb-3" style="background-image:url('<?php echo $imgUrl; ?>');height: 300px;width: 100%;background-size: cover;"></div>
                            <div class="alert alert-primary text-center p-2" role="alert">
                                <h4 class="fw-bold m-0"><?php echo velocitytheme_option('nama_sales');?></h4>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-2">
                                <p><a class="text-dark" href="tel:<?php echo velocitytheme_option('notelp');?>">
                                    <i class="bg-colortheme rounded-5 fa fa-phone text-white fa-2x" aria-hidden="true" style="padding: 10px 13px;"></i>
                                    <span class="h5 fw-bold"><?php echo velocitytheme_option('notelp');?></span>
                                </a></p>
                                <p><a class="text-dark" href="https://wa.me/<?php echo $nowa;?>">
                                    <i class="bg-colortheme rounded-5 fa fa-whatsapp text-white fa-2x" aria-hidden="true" style="padding: 10px 13px;"></i>
                                    <span class="h5 fw-bold">+<?php echo $nowa;?></span>
                                </a></p>
                                <p><a class="text-dark" href="https://wa.me/<?php echo $nowa;?>" target="_blank">
                                    <i class="bg-colortheme rounded-5 fa fa-envelope text-white fa-2x" aria-hidden="true" style="padding: 10px 13px;"></i>
                                    <span class="h5 fw-bold"><?php echo velocitytheme_option('email');?></span>
                                </a></p>
                            </div>
                        </div>
                        <?php if($single_simulasikredit == 'on'): ?>
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