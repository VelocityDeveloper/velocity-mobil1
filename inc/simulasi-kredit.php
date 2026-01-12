<?php function velocity_simulasi(){ ?>
    <div class="form-simulasikredit">
    <?php
    $args = array(
    	'posts_per_page'   => -1,
    	'orderby'          => 'date',
    	'order'            => 'DESC',
    	'post_type'        => 'produk',
    );
    $posts = get_posts( $args );
    ?>
    <div class="simulasi-kredit">
        <!-- Hasil simulasi -->
        <?php echo velocitytheme_option('pesan_simulasi');?>
        <div class="hasilhitung mt-3"></div>
        <form>
            <select id="mobil" class="form-control mb-2" required>
                <?php
                    echo '<option value="">-Pilih Mobil-</option>';
                    foreach($posts as $post){
                        echo '<option value="'.$post->ID.'">'.$post->post_title.'</option>';
                    }
                ?>
            </select>
            <select id="tipe" class="form-control mb-2" required>
                <?php
                echo '<option value="">-Pilih Tipe-</option>';
                    foreach($posts as $post){
                        $hargas = get_post_meta($post->ID, 'opsiharga',true);
                        foreach($hargas as $harga){
                            echo '<option class="'.$post->ID.'" value="'.preg_replace("/[^0-9]/", "", explode('=', $harga)[1]).'">'.explode('=', $harga)[0].' - Rp '.velocitychild_format_price_from_opsiharga( $harga ).'-</option>';
                        }
                    }
                ?>
            </select>
            <input type="number" class="form-control mb-2" id="dp" placeholder="DP - Contoh: 80.000.000" required>
            <select id="tenor" class="form-control mb-2" required>
                <?php
                    for ($k = 1 ; $k < 7; $k++){
                        echo '<option value="'.$k.'">Tenor '.$k.' Tahun</option>';
                    }
                ?>
            </select>
            
            <?php echo velocity_mobil1_recaptcha();?>
            
            <div class="form-simulasikredit-alert"></div>
            
            <button id="hitungsimulasi" type="submit" class="btn btn-dark">Submit</button>
        </form>
    </div>
</div>
<?php
}
