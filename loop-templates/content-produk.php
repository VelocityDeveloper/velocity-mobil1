<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package velocity
 */
$harga  = get_post_meta($post->ID, 'opsiharga', true);
$dp = get_post_meta($post->ID, 'dpminimal', true);
$cicilan = get_post_meta($post->ID, 'cicilanminimal', true);
$nowa = velocitytheme_option('nowa');
if (!empty($nowa)) {
    if (substr($nowa, 0, 1) === '0') {
        $nowa    = '62' . substr($nowa, 1);
    } else if (substr($nowa, 0, 1) === '+') {
        $nowa    = '' . substr($nowa, 1);
    }
}
?>

<?php
$article_classes = 'col-md-4 col-6 mb-3 px-2';
if ( is_singular( 'produk' ) ) {
    $article_classes = 'col-md-3 col-6 mb-3 px-2';
}
if ( ! is_post_type_archive( 'produk' ) && ! is_tax( 'kategori-produk' ) && ! is_singular( 'produk' ) ) {
    $article_classes .= ' container';
}
?>
<article <?php post_class( $article_classes ); ?> id="post-<?php the_ID(); ?>">
    <div class="card px-2 px-md-3 py-1 py-md-3 shadow-sm h-100">
        <?php if ( has_post_thumbnail() ) : ?>
            <a href="<?php echo get_permalink();?>">
                <div class="ratio ratio-16x9">
                    <img class="w-100 h-100" style="object-fit: contain;" src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"/>
                </div>
            </a>
        <?php endif; ?>
    	<?php the_title( sprintf( '<h2 class="entry-title text-center h4 fw-bold p-2 m-0"><a class="text-dark" href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
    		'</a></h2>' ); ?>
        <?php if(!empty($harga)) : ?>
        <div class="detail-harga">
            <div class="bg-colortheme text-white p-md-2 p-1 mb-1">Harga Mulai Rp <?php echo velocitychild_format_first_opsiharga( $harga ); ?></div>
            <div class="bg-colortheme text-white p-md-2 p-1 mb-1">DP Mulai <?php echo $dp; ?></div>
            <div class="bg-colortheme text-white p-md-2 p-1 mb-1">Cicilan Mulai <?php echo $cicilan; ?></div>
        </div>
        <?php else : ?>
            <?php if( !empty( $nowa ) ): ?>
            <a href="https://api.whatsapp.com/send?phone=<?php echo $nowa;?>?text=Hallo... Mohon info harga <?php echo get_the_title(); ?>" target="_blank" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                    <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"></path>
                </svg> Hubungi Admin
            </a>
            <?php endif; ?>
        <?php endif ; ?>
    </div>
</article><!-- #post-## -->
