<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package justg
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
$container = velocitytheme_option('justg_container_type', 'container');
$single_simulasikredit   = velocitytheme_option('single_simulasi');
$sliders = velocitytheme_option('slider_repeat');
$kategori = velocitytheme_option('category_home');
?>

<div class="wrapper p-0" id="index-wrapper">

    <div id="carouselExampleInterval" class="carousel slide carousel-fade" data-bs-ride="carousel">
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

    <div class="<?php echo esc_attr($container); ?> p-3" id="content" tabindex="-1">
            
    <main class="site-main col order-2" id="main">
        <div class="produk-content">
            <h3 class="px-2 text-dark h5">Daftar Produk</h3>
            <?php
                $args = array(
                    'post_type' => 'produk', // Ganti 'produk' dengan nama post type custom Anda
                    'posts_per_page' => 9, // Jumlah post yang ingin ditampilkan
                    'order' => 'DESC',
                    'orderby' => 'date',
                );
                
                // Membuat instance WP_Query
                $product_query = new WP_Query($args);
                
                // Loop untuk menampilkan post
                if ($product_query->have_posts()) { ?>
                
                <div class="row m-0">
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
                get_template_part( 'loop-templates/content', 'none');
            }?>
            
        </div>
        
        <?php if($single_simulasikredit == 'on'): ?>
            <div class="card my-3">
                <h4 class="text-dark h5 card-header">Simulasi kredit</h4>
                <div class="card-body">
                <?php velocity_simulasi(); ?>
                </div>
            </div>
        <?php endif;?>

        <div class="blog-content">
            <?php $category = get_category($kategori);?>
            <h3 class="px-2 text-dark h5"><?php echo $category->name;?></h3>
            <?php
                $args = array(
                    'post_type' => 'post', // Ganti 'produk' dengan nama post type custom Anda
                    'posts_per_page' => 3, // Jumlah post yang ingin ditampilkan
                    'order' => 'DESC',
                    'orderby' => 'date',
                    'cat' => $kategori,
                );
                
                // Membuat instance WP_Query
                $product_query = new WP_Query($args);
                
                // Loop untuk menampilkan post
                if ($product_query->have_posts()) { ?>
                
                <div class="row m-0">
                <?php
                    // Start the loop.
                    while ($product_query->have_posts()) : $product_query->the_post();
                    get_template_part('loop-templates/content');
                    endwhile;
                ?>
                </div>
            <?php } else {
                get_template_part( 'loop-templates/content', 'none');
            }?>
        </div>
    </main><!-- #main -->

    </div><!-- #content -->

</div><!-- #index-wrapper -->

<?php
get_footer();