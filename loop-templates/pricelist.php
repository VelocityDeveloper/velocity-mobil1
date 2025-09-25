<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package velocity
 */
$hargas = get_post_meta($post->ID, 'opsiharga',true);
?>

<article <?php post_class('card container mb-3 px-0'); ?> id="post-<?php the_ID(); ?>">
    <div class="card-header mx-0 bg-dark">
        <?php the_title( sprintf( '<h2 class="entry-title h5 text-left"><a href="%s" class="text-white" rel="bookmark">Harga ', esc_url( get_permalink() ) ),'</a></h2>' ); ?>
    </div>
    <div class="card-body row">
        <div class="col-md-4">
        	<a href="<?php echo get_permalink();?>">
        	    <img src="<?php echo aq_resize( get_the_post_thumbnail_url(), 300, 180, true, true, true ); ?>" alt="<?php echo get_the_title(); ?>"/>
        	</a>
        </div>
        <div class="col-md-8">
            <table class="table">
                <thead class="bg-colortheme text-white">
                <tr>
                  <th scope="col">Tipe</th>
                  <th scope="col">Harga</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    if($hargas) {
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
                    } else {
                        echo '<tr><td colspan="2">Tidak Ada Data.</td></tr>';
                    }
                    
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</article><!-- #post-## -->
