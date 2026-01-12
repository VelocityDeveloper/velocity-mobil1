<?php
// Register post type function
add_action('init', 'produk_post_type');
function produk_post_type()
{
    register_post_type('produk', [
        'labels' => [
            'name' => 'Produk',
            'singular_name' => 'produk',
        ],
        'menu_icon'     => 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-car-front" viewBox="0 0 16 16"><path d="M4 9a1 1 0 1 1-2 0 1 1 0 0 1 2 0m10 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM4.862 4.276 3.906 6.19a.51.51 0 0 0 .497.731c.91-.073 2.35-.17 3.597-.17s2.688.097 3.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 10.691 4H5.309a.5.5 0 0 0-.447.276"/><path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679q.05.242.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.8.8 0 0 0 .381-.404l.792-1.848ZM4.82 3a1.5 1.5 0 0 0-1.379.91l-.792 1.847a1.8 1.8 0 0 1-.853.904.8.8 0 0 0-.43.564L1.03 8.904a1.5 1.5 0 0 0-.03.294v.413c0 .796.62 1.448 1.408 1.484 1.555.07 3.786.155 5.592.155s4.037-.084 5.592-.155A1.48 1.48 0 0 0 15 9.611v-.413q0-.148-.03-.294l-.335-1.68a.8.8 0 0 0-.43-.563 1.8 1.8 0 0 1-.853-.904l-.792-1.848A1.5 1.5 0 0 0 11.18 3z"/></svg>'),
        'public' => true,
        'has_archive' => true,
        'show_in_rest'  => true,
        'taxonomies' => ['produk'],
        'supports' => [
            'title',
            'editor',
            'thumbnail',
        ],
    ]);
}

add_action('init', 'ak_add_produk');
function ak_add_produk()
{
    register_taxonomy(
        'kategori-produk',
        'produk',
        [
            'label' => __('Kategori Produk'),
            'rewrite' => ['slug' => 'kategori-produk'],
            'hierarchical' => true,
            'public' => true,
            'show_in_rest'  => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
        ],
    );
}

add_action( 'add_meta_boxes', 'velocity_produk_register_meta_boxes' );
function velocity_produk_register_meta_boxes() {
    add_meta_box(
        'detail',
        'Detail Produk',
        'velocity_produk_detail_metabox',
        'produk',
        'normal',
        'high'
    );
}

function velocity_produk_detail_metabox( $post ) {
    wp_nonce_field( 'velocity_produk_detail', 'velocity_produk_detail_nonce' );
    $dpminimal      = get_post_meta( $post->ID, 'dpminimal', true );
    $cicilanminimal = get_post_meta( $post->ID, 'cicilanminimal', true );
    $opsiharga      = get_post_meta( $post->ID, 'opsiharga', true );
    if ( ! is_array( $opsiharga ) ) {
        $opsiharga = $opsiharga ? array( $opsiharga ) : array();
    }
    if ( empty( $opsiharga ) ) {
        $opsiharga = array( '' );
    }
    ?>
    <p>
        <label for="dpminimal"><strong><?php echo esc_html__( 'DP Minimal', 'velocity' ); ?></strong></label>
        <input type="text" class="widefat" id="dpminimal" name="dpminimal" value="<?php echo esc_attr( $dpminimal ); ?>" placeholder="<?php echo esc_attr__( 'Rp 20 Jutaan', 'velocity' ); ?>">
    </p>
    <p>
        <label for="cicilanminimal"><strong><?php echo esc_html__( 'Cicilan Minimal', 'velocity' ); ?></strong></label>
        <input type="text" class="widefat" id="cicilanminimal" name="cicilanminimal" value="<?php echo esc_attr( $cicilanminimal ); ?>" placeholder="<?php echo esc_attr__( 'Rp 3 Jutaan', 'velocity' ); ?>">
    </p>
    <hr>
    <p><strong><?php echo esc_html__( 'Pricelist', 'velocity' ); ?></strong></p>
    <div id="velocity-opsiharga-list">
        <?php foreach ( $opsiharga as $item ) : ?>
            <p class="velocity-opsiharga-row">
                <input type="text" class="widefat" name="opsiharga[]" value="<?php echo esc_attr( $item ); ?>" placeholder="<?php echo esc_attr__( 'Contoh: INNOVA 2.0 G M/T=309.300.000', 'velocity' ); ?>">
                <button type="button" class="button-link-delete velocity-remove-opsiharga" style="margin-top:6px;"><?php echo esc_html__( 'Hapus', 'velocity' ); ?></button>
            </p>
        <?php endforeach; ?>
    </div>
    <p>
        <button type="button" class="button" id="velocity-add-opsiharga"><?php echo esc_html__( 'Tambah Opsi', 'velocity' ); ?></button>
        <span class="description" style="margin-left: 8px;">
            <?php echo esc_html__( 'Tuliskan Type = harga. Contoh: INNOVA 2.0 G M/T=309.300.000', 'velocity' ); ?>
        </span>
    </p>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var addBtn = document.getElementById('velocity-add-opsiharga');
            if (!addBtn) {
                return;
            }
            addBtn.addEventListener('click', function (event) {
                event.preventDefault();
                var list = document.getElementById('velocity-opsiharga-list');
                if (!list) {
                    return;
                }
                var wrap = document.createElement('p');
                wrap.className = 'velocity-opsiharga-row';
                var input = document.createElement('input');
                input.type = 'text';
                input.name = 'opsiharga[]';
                input.className = 'widefat';
                input.placeholder = '<?php echo esc_attr__( 'Contoh: INNOVA 2.0 G M/T=309.300.000', 'velocity' ); ?>';
                var remove = document.createElement('button');
                remove.type = 'button';
                remove.className = 'button-link-delete velocity-remove-opsiharga';
                remove.style.marginTop = '6px';
                remove.textContent = '<?php echo esc_html__( 'Hapus', 'velocity' ); ?>';
                wrap.appendChild(input);
                wrap.appendChild(remove);
                list.appendChild(wrap);
            });
            document.addEventListener('click', function (event) {
                var target = event.target;
                if (!target.classList.contains('velocity-remove-opsiharga')) {
                    return;
                }
                event.preventDefault();
                var row = target.closest('.velocity-opsiharga-row');
                if (!row) {
                    return;
                }
                var list = document.getElementById('velocity-opsiharga-list');
                if (!list) {
                    return;
                }
                var rows = list.querySelectorAll('.velocity-opsiharga-row');
                if (rows.length <= 1) {
                    var input = row.querySelector('input[name="opsiharga[]"]');
                    if (input) {
                        input.value = '';
                    }
                    return;
                }
                row.remove();
            });
        });
    </script>
    <?php
}

add_action( 'save_post_produk', 'velocity_produk_save_detail_metabox' );
function velocity_produk_save_detail_metabox( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! isset( $_POST['velocity_produk_detail_nonce'] ) || ! wp_verify_nonce( $_POST['velocity_produk_detail_nonce'], 'velocity_produk_detail' ) ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $text_fields = array( 'dpminimal', 'cicilanminimal' );
    foreach ( $text_fields as $field ) {
        if ( isset( $_POST[ $field ] ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
        }
    }

    if ( isset( $_POST['opsiharga'] ) && is_array( $_POST['opsiharga'] ) ) {
        $opsiharga = array();
        foreach ( $_POST['opsiharga'] as $item ) {
            $item = sanitize_text_field( wp_unslash( $item ) );
            if ( $item !== '' ) {
                $opsiharga[] = $item;
            }
        }
        if ( ! empty( $opsiharga ) ) {
            update_post_meta( $post_id, 'opsiharga', $opsiharga );
        } else {
            delete_post_meta( $post_id, 'opsiharga' );
        }
    } else {
        delete_post_meta( $post_id, 'opsiharga' );
    }
}

//Displaying kategori-produk Columns
add_filter( 'manage_taxonomies_for_produk_columns', 'kategori_produk_columns' );
function kategori_produk_columns( $taxonomies ) {
    $taxonomies[] = 'kategori-produk';
    return $taxonomies;
}

// manage column produk list
add_filter('manage_produk_posts_columns' , 'produk_custom_columns');
function produk_custom_columns($defaults,$post_id='') {
    $screen = get_current_screen();
	if($screen->post_type == 'produk'){
        $columns = array(
            'cb'                => '<input type="checkbox" />',
            'featured_image'    => 'Image',
            'title'             => 'Title',
            'taxonomy-kategori-produk'  => 'Kategori',
            'varian'        => 'Varian',
            'date'      => 'Tanggal',
         );
        if( !function_exists( 'WP_Statistics' ) ) {
            $columns['hit'] = 'Hits';
        }
        $columns['varian'] = __( 'Varian', 'velocity' );
        return $columns;
	} else {
		return $defaults;
	}
}

add_action( 'manage_posts_custom_column' , 'custom_columns_data', 10, 2 );
function custom_columns_data( $column, $post_id ) {
    switch ( $column ) {
    case 'featured_image':
        echo '<img style="width: 75px;height: auto;" src="'.get_the_post_thumbnail_url($post_id ,'thumbnail').'" alt="" />';
        break;
    case 'varian':
        $opsiharga = get_post_meta($post_id, 'opsiharga',true);
        if($opsiharga) {
            echo count($opsiharga).' Opsi';
        } else {echo '0 Opsi';}
        break;
    case 'hit' :
        if(!function_exists( 'WP_Statistics' ) ) {
            echo get_post_meta($post_id,'hit',true);
        }
        break; 
    }
}

///fungsi tambah HIT di product single
add_action( 'wp_head', 'velocity_hit_produk' );
function velocity_hit_produk(){    
    if ( is_singular('produk') ) {
        global $wpdb,$post;
        $postID = $post->ID;
        $count_key = 'hit';
        if( function_exists( 'WP_Statistics' ) ) {
            $table_name = $wpdb->prefix . "statistics_pages";
            $results    = $wpdb->get_results("SELECT sum(count) as result_value FROM $table_name WHERE id = $postID");
            $count      = $results?$results[0]->result_value:'0';
        } else if (class_exists('Velocity_Addons_Statistic')) {
            $table_name = $wpdb->prefix . 'vd_statistic';
            $totals     = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE post_id = %s", $postID));
            $count      = $totals?$totals:'0';
        } else {
            $count      = get_post_meta($postID, $count_key, true);
            $count++;
        } 
        
        if($count==''){
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        } else {
            update_post_meta($postID, $count_key, $count);
        }
    }
}
