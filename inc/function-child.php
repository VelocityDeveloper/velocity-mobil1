<?php
/**
 * Fuction yang digunakan di theme ini.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

add_action( 'after_setup_theme', 'velocitychild_theme_setup', 9 );

function velocitychild_theme_setup() {
	
	// Load justg_child_enqueue_parent_style after theme setup
	add_action( 'wp_enqueue_scripts', 'justg_child_enqueue_parent_style', 20 );
	
	// Add theme support for custom logo
	add_theme_support('custom-logo', array(
		'height'      => 100,
		'width'       => 300,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array('site-title', 'site-description'),
	));
	
	add_action( 'customize_register', 'velocitychild_customize_register' );
	add_action( 'customize_controls_enqueue_scripts', 'velocitychild_customizer_assets' );
	add_action( 'wp_head', 'velocitychild_customizer_css' );

    //remove action from Parent Theme
    remove_action('justg_header', 'justg_header_menu');
    remove_action('justg_do_footer', 'justg_the_footer_open');
    remove_action('justg_do_footer', 'justg_the_footer_content');
    remove_action('justg_do_footer', 'justg_the_footer_close');
    remove_theme_support('widgets-block-editor');

}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Velocitychild_Slider_Repeater_Control' ) ) {
	class Velocitychild_Slider_Repeater_Control extends WP_Customize_Control {
		public $type = 'velocity_slider_repeater';

		public function render_content() {
			if ( empty( $this->label ) ) {
				return;
			}
			$value = $this->value();
			$urls  = velocitychild_slider_value_to_urls( $value );
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php endif; ?>
			</label>
			<div class="velocity-slider-repeater-control">
				<div class="velocity-slider-repeater-list">
					<?php
					if ( empty( $urls ) ) {
						$urls = array( '' );
					}
					foreach ( $urls as $url ) : ?>
						<div class="velocity-slider-repeater-row" style="border:1px solid #ccd0d4;padding:8px;margin-bottom:8px;">
							<div class="velocity-slider-repeater-preview" style="margin-bottom:6px;">
								<?php if ( $url ) : ?>
									<img src="<?php echo esc_url( $url ); ?>" style="max-width:100%;height:auto;display:block;">
								<?php endif; ?>
							</div>
							<input type="text" class="widefat velocity-slider-repeater-input" value="<?php echo esc_url( $url ); ?>" placeholder="<?php echo esc_attr__( 'URL gambar', 'justg' ); ?>">
							<div style="display:flex;gap:8px;margin-top:6px;">
								<button type="button" class="button velocity-slider-repeater-media"><?php echo esc_html__( 'Pilih', 'justg' ); ?></button>
								<button type="button" class="button button-link-delete velocity-slider-repeater-remove" aria-label="<?php echo esc_attr__( 'Hapus', 'justg' ); ?>"><?php echo esc_html__( 'Hapus', 'justg' ); ?></button>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<input type="hidden" class="velocity-slider-repeater-value" <?php $this->link(); ?> value="<?php echo esc_attr( implode( "\n", $urls ) ); ?>">
				<p><button type="button" class="button velocity-slider-repeater-add"><?php echo esc_html__( 'Tambah Slider', 'justg' ); ?></button></p>
			</div>
			<?php
		}
	}
}

function velocitychild_customize_register( $wp_customize ) {

	$wp_customize->add_panel( 'panel_mobil', array(
		'priority'    => 10,
		'title'       => esc_html__( 'Velocity Theme', 'justg' ),
		'description' => esc_html__( '', 'justg' ),
	) );

	$wp_customize->add_section( 'section_slider', array(
		'panel'    => 'panel_mobil',
		'title'    => __( 'Slider Home', 'justg' ),
		'priority' => 10,
	) );

	$wp_customize->add_setting( 'slider_repeat', array(
		'default'           => array(),
		'sanitize_callback' => 'velocitychild_sanitize_slider_repeat',
	) );
	if ( class_exists( 'Velocitychild_Slider_Repeater_Control' ) ) {
		$wp_customize->add_control( new Velocitychild_Slider_Repeater_Control(
			$wp_customize,
			'slider_repeat',
			array(
				'label'       => esc_html__( 'Slider Home', 'justg' ),
				'description' => esc_html__( 'Ukuran gambar 1366x585 pixel.', 'justg' ),
				'section'     => 'section_slider',
			)
		) );
	} else {
		$wp_customize->add_control( 'slider_repeat', array(
			'label'       => esc_html__( 'Slider Home', 'justg' ),
			'description' => esc_html__( 'Ukuran gambar 1366x585 pixel.', 'justg' ),
			'section'     => 'section_slider',
			'type'        => 'textarea',
		) );
	}

	$wp_customize->add_section( 'section_dealer', array(
		'panel'    => 'panel_mobil',
		'title'    => __( 'Data Dealer', 'justg' ),
		'priority' => 10,
	) );

	$wp_customize->add_setting( 'foto_sales', array(
		'default'           => '',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( new WP_Customize_Media_Control(
		$wp_customize,
		'foto_sales',
		array(
			'label'       => esc_html__( 'Foto Sales', 'justg' ),
			'description' => esc_html__( 'Upload gambar ukuran lebar 500x500.', 'justg' ),
			'section'     => 'section_dealer',
			'mime_type'   => 'image',
		)
	) );

	$wp_customize->add_setting( 'nama_sales', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'nama_sales', array(
		'label'    => esc_html__( 'Nama Sales', 'justg' ),
		'section'  => 'section_dealer',
		'type'     => 'text',
		'priority' => 10,
	) );

	$wp_customize->add_setting( 'notelp', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'notelp', array(
		'label'       => esc_html__( 'No Telephone', 'justg' ),
		'description' => esc_html__( 'Contoh. 085123456789', 'justg' ),
		'section'     => 'section_dealer',
		'type'        => 'text',
		'priority'    => 10,
	) );

	$wp_customize->add_setting( 'nowa', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'nowa', array(
		'label'       => esc_html__( 'No Whatsapp', 'justg' ),
		'description' => esc_html__( 'Contoh. 085123456789', 'justg' ),
		'section'     => 'section_dealer',
		'type'        => 'text',
		'priority'    => 10,
	) );

	$wp_customize->add_setting( 'email', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'email', array(
		'label'       => esc_html__( 'Email', 'justg' ),
		'description' => esc_html__( 'Contoh. info@velocitydeveloper.com', 'justg' ),
		'section'     => 'section_dealer',
		'type'        => 'text',
		'priority'    => 10,
	) );

	$wp_customize->add_setting( 'pesan_simulasi', array(
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
	) );

	$wp_customize->add_section( 'section_simulasi', array(
		'panel'    => 'panel_mobil',
		'title'    => __( 'Simulasi Kredit', 'justg' ),
		'priority' => 10,
	) );

	if ( get_theme_mod( 'home_simulasi', '' ) === '' ) {
		set_theme_mod( 'home_simulasi', 'on' );
	}
	$wp_customize->add_setting( 'home_simulasi', array(
		'default'           => 'on',
		'sanitize_callback' => 'velocitychild_sanitize_toggle',
	) );
	$wp_customize->add_control( 'home_simulasi', array(
		'label'       => esc_html__( 'Halaman Depan', 'justg' ),
		'description' => esc_html__( 'Aktifkan Simulasi Kredit di Halaman Depan.', 'justg' ),
		'section'     => 'section_simulasi',
		'type'        => 'radio',
		'choices'     => array(
			'on'  => esc_html__( 'On', 'justg' ),
			'off' => esc_html__( 'Off', 'justg' ),
		),
	) );

	if ( get_theme_mod( 'single_simulasi', '' ) === '' ) {
		set_theme_mod( 'single_simulasi', 'on' );
	}
	$wp_customize->add_setting( 'single_simulasi', array(
		'default'           => 'on',
		'sanitize_callback' => 'velocitychild_sanitize_toggle',
	) );
	$wp_customize->add_control( 'single_simulasi', array(
		'label'       => esc_html__( 'Single Page', 'justg' ),
		'description' => esc_html__( 'Aktifkan Simulasi Kredit di Single Deskripsi Produk.', 'justg' ),
		'section'     => 'section_simulasi',
		'type'        => 'radio',
		'choices'     => array(
			'on'  => esc_html__( 'On', 'justg' ),
			'off' => esc_html__( 'Off', 'justg' ),
		),

	) );
	$wp_customize->add_control( 'pesan_simulasi', array(
		'label'   => esc_html__( 'Pesan Simulasi Kredit', 'justg' ),
		'section' => 'section_simulasi',
		'type'    => 'textarea',
	) );

	$wp_customize->remove_panel( 'global_panel' );
	$wp_customize->remove_panel( 'panel_header' );
	$wp_customize->remove_panel( 'panel_footer' );
	$wp_customize->remove_control( 'display_header_text' );
}

function velocitychild_sanitize_slider_repeat( $value ) {
	if ( is_array( $value ) ) {
		return $value;
	}
	$items = array();
	$raw = trim( (string) $value );
	if ( $raw === '' ) {
		return $items;
	}
	$tokens = preg_split( '/[\r\n,]+/', $raw );
	foreach ( $tokens as $token ) {
		$token = trim( $token );
		if ( $token === '' ) {
			continue;
		}
		if ( ctype_digit( $token ) ) {
			$id = absint( $token );
			$url = $id ? wp_get_attachment_url( $id ) : '';
			if ( $url ) {
				$items[] = array(
					'id'        => $id,
					'imgslider' => $url,
				);
			}
		} else {
			$items[] = array( 'imgslider' => esc_url_raw( $token ) );
		}
	}
	return $items;
}

function velocitychild_sanitize_toggle( $value ) {
	return $value === 'off' ? 'off' : 'on';
}

function velocitychild_customizer_css() {
	$theme_color = get_theme_mod( 'primary_color', '#00a091' );
	?>
	<style>
		:root {
			--color-theme: <?php echo esc_html( $theme_color ); ?>;
			--bs-primary: <?php echo esc_html( $theme_color ); ?>;
		}
		.text-colortheme, .text-colortheme i, .page-link {
			color: <?php echo esc_html( $theme_color ); ?>;
		}
		.bg-colortheme, .page-item.active .page-link {
			background-color: <?php echo esc_html( $theme_color ); ?>;
			border-color: <?php echo esc_html( $theme_color ); ?>;
		}
		.border-color-theme {
			--bs-border-color: <?php echo esc_html( $theme_color ); ?>;
		}
	</style>
	<?php
}

function velocitychild_customizer_assets() {
	wp_enqueue_media();
	$script = <<<'JS'
jQuery(function($){
    function syncSliderValue(control) {
        var values = [];
        control.find('.velocity-slider-repeater-input').each(function(){
            var val = $(this).val().trim();
            if (val) {
                values.push(val);
            }
        });
        control.find('.velocity-slider-repeater-value').val(values.join('\n')).trigger('change');
    }

    function bindRowEvents(control, row) {
        row.find('.velocity-slider-repeater-input').on('input', function(){
            updatePreview(row);
            syncSliderValue(control);
        });
        row.find('.velocity-slider-repeater-remove').on('click', function(e){
            e.preventDefault();
            var rows = control.find('.velocity-slider-repeater-row');
            if (rows.length <= 1) {
                row.find('.velocity-slider-repeater-input').val('');
                syncSliderValue(control);
                return;
            }
            row.remove();
            syncSliderValue(control);
        });
        row.find('.velocity-slider-repeater-media').on('click', function(e){
            e.preventDefault();
            var frame = wp.media({
                title: 'Pilih Gambar Slider',
                button: { text: 'Gunakan' },
                multiple: false,
                library: { type: 'image' }
            });
            frame.on('select', function(){
                var attachment = frame.state().get('selection').first();
                if (!attachment) {
                    return;
                }
                var data = attachment.toJSON();
                row.find('.velocity-slider-repeater-input').val(data.url || '');
                updatePreview(row);
                syncSliderValue(control);
            });
            frame.open();
        });
    }

    function updatePreview(row) {
        var url = row.find('.velocity-slider-repeater-input').val().trim();
        var preview = row.find('.velocity-slider-repeater-preview');
        if (!preview.length) {
            return;
        }
        if (url) {
            preview.html('<img src="' + url + '" style="max-width:100%;height:auto;display:block;">');
        } else {
            preview.empty();
        }
    }

    $('.velocity-slider-repeater-control').each(function(){
        var control = $(this);
        control.find('.velocity-slider-repeater-row').each(function(){
            bindRowEvents(control, $(this));
        });
        control.find('.velocity-slider-repeater-add').on('click', function(e){
            e.preventDefault();
            var row = $(
                '<div class="velocity-slider-repeater-row" style="border:1px solid #ccd0d4;padding:8px;margin-bottom:8px;">' +
                '<div class="velocity-slider-repeater-preview" style="margin-bottom:6px;"></div>' +
                '<input type="text" class="widefat velocity-slider-repeater-input" placeholder="URL gambar">' +
                '<div style="display:flex;gap:8px;margin-top:6px;">' +
                '<button type="button" class="button velocity-slider-repeater-media">Pilih</button>' +
                '<button type="button" class="button-link-delete velocity-slider-repeater-remove" aria-label="Hapus">Hapus</button>' +
                '</div>' +
                '</div>'
            );
            control.find('.velocity-slider-repeater-list').append(row);
            bindRowEvents(control, row);
            syncSliderValue(control);
        });
        syncSliderValue(control);
    });
});
JS;
	wp_add_inline_script( 'customize-controls', $script );
}

function velocitychild_slider_value_to_ids( $value ) {
	if ( is_array( $value ) ) {
		$ids = array();
		foreach ( $value as $item ) {
			if ( is_array( $item ) && ! empty( $item['id'] ) ) {
				$ids[] = absint( $item['id'] );
				continue;
			}
			if ( is_array( $item ) && ! empty( $item['imgslider'] ) ) {
				$id = attachment_url_to_postid( $item['imgslider'] );
				if ( $id ) {
					$ids[] = $id;
				}
			}
		}
		return array_filter( $ids );
	}
	$raw = trim( (string) $value );
	if ( $raw === '' ) {
		return array();
	}
	$tokens = preg_split( '/[\r\n,]+/', $raw );
	$ids = array();
	foreach ( $tokens as $token ) {
		$token = trim( $token );
		if ( $token === '' ) {
			continue;
		}
		if ( ctype_digit( $token ) ) {
			$ids[] = absint( $token );
		} else {
			$id = attachment_url_to_postid( $token );
			if ( $id ) {
				$ids[] = $id;
			}
		}
	}
	return array_filter( $ids );
}

function velocitychild_slider_value_to_urls( $value ) {
	if ( is_array( $value ) ) {
		$urls = array();
		foreach ( $value as $item ) {
			if ( is_array( $item ) && ! empty( $item['imgslider'] ) ) {
				$urls[] = $item['imgslider'];
			}
		}
		return $urls;
	}
	$urls = array();
	$tokens = preg_split( '/[\r\n,]+/', (string) $value );
	foreach ( $tokens as $token ) {
		$token = trim( $token );
		if ( $token === '' ) {
			continue;
		}
		if ( ctype_digit( $token ) ) {
			$url = wp_get_attachment_url( absint( $token ) );
			if ( $url ) {
				$urls[] = $url;
			}
		} else {
			$urls[] = $token;
		}
	}
	return $urls;
}

function velocitychild_format_price( $value, $decimals = 2 ) {
	$raw = is_numeric( $value ) ? (string) $value : (string) $value;
	$raw = preg_replace( '/[^0-9]/', '', $raw );
	$number = $raw === '' ? 0 : (float) $raw;
	return number_format( $number, $decimals, ',', '.' );
}

function velocitychild_format_price_from_opsiharga( $harga_line, $decimals = 2 ) {
	if ( ! is_string( $harga_line ) ) {
		return velocitychild_format_price( 0, $decimals );
	}
	$parts = explode( '=', $harga_line, 2 );
	$value = isset( $parts[1] ) ? $parts[1] : '';
	return velocitychild_format_price( $value, $decimals );
}

function velocitychild_format_first_opsiharga( $opsiharga, $decimals = 2 ) {
	if ( is_array( $opsiharga ) ) {
		foreach ( $opsiharga as $line ) {
			if ( is_string( $line ) && trim( $line ) !== '' ) {
				return velocitychild_format_price_from_opsiharga( $line, $decimals );
			}
		}
		return velocitychild_format_price( 0, $decimals );
	}
	if ( is_string( $opsiharga ) && $opsiharga !== '' ) {
		return velocitychild_format_price_from_opsiharga( $opsiharga, $decimals );
	}
	return velocitychild_format_price( 0, $decimals );
}

///remove breadcrumbs
add_action('wp_head', function () {
	if (!is_single()) {
		remove_action('justg_before_title', 'justg_breadcrumb');
	}
});

if (!function_exists('justg_header_open')) {
	function justg_header_open()
	{
		echo '<header id="wrapper-header">';
		echo '<div id="wrapper-navbar" class="px-0" itemscope itemtype="http://schema.org/WebSite">';
	}
}
if (!function_exists('justg_header_close')) {
	function justg_header_close()
	{
		echo '</div>';
		echo '</header>';
	}
}


///add action builder part
add_action('justg_header', 'justg_header_mobil');
function justg_header_mobil()
{
	require_once(get_stylesheet_directory() . '/inc/part-header.php');
}
add_action('justg_do_footer', 'justg_footer_mobil');
function justg_footer_mobil() {
	require_once(get_stylesheet_directory() . '/inc/part-footer.php');
}
// add_action('justg_before_wrapper_content', 'justg_before_wrapper_content');
// function justg_before_wrapper_content() {
// 	echo '<div class="card rounded-0 border-0 px-0 container">';
// }
// add_action('justg_after_wrapper_content', 'justg_after_wrapper_content');
// function justg_after_wrapper_content() {
// 	echo '</div>';
// }

if (!function_exists('justg_right_sidebar_check')) {
    /**
     * Right sidebar check
     * 
     */
    function justg_right_sidebar_check()
    {
        $sidebar_pos            = velocitytheme_option('justg_sidebar_position', 'right');
        $pages_sidebar_pos      = velocitytheme_option('justg_pages_sidebar_position');
        $singular_sidebar_pos   = velocitytheme_option('justg_blogs_sidebar_position');
        $archives_sidebar_pos   = velocitytheme_option('justg_archives_sidebar_position');
        $shop_sidebar_pos       = velocitytheme_option('justg_shop_sidebar_position', 'default');

        if ($sidebar_pos === 'disable') {
            return;
        }

        if (is_page() && !in_array($pages_sidebar_pos, array('', 'default'))) {
            $sidebar_pos = $pages_sidebar_pos;
        }

        if (is_singular() && !in_array($singular_sidebar_pos, array('', 'default'))) {
            $sidebar_pos = $singular_sidebar_pos;
        }

        if (is_archive() && !in_array($archives_sidebar_pos, array('', 'default'))) {
            $sidebar_pos = $archives_sidebar_pos;
        }

        if (is_singular('fl-builder-template')) {
            return;
        }

        if ('right' === $sidebar_pos) {
            if (!is_active_sidebar('main-sidebar') && !has_action('justg_before_main_sidebar') && !has_action('justg_after_main_sidebar')) {
                return;
            }
        ?>
            <div class="widget-area right-sidebar col-sm-4 order-3" id="right-sidebar" role="complementary">
                <?php do_action('justg_before_main_sidebar'); ?>
                <?php dynamic_sidebar('main-sidebar'); ?>
                <?php do_action('justg_after_main_sidebar'); ?>
            </div>
            <?php
        }
    }
}

function velocity_mobil1_recaptcha() {

    echo '<div class="velocitytoko-recaptcha my-2">';
        if (class_exists('Velocity_Addons_Captcha')){
            $captcha = new Velocity_Addons_Captcha;
            $captcha->display();
        }
    echo '</div>';

}

function velocitytoko_validate_recaptcha() {
    if (class_exists('Velocity_Addons_Captcha')) {
        $captcha = new Velocity_Addons_Captcha();
        $verify = $captcha->verify();
        
        if (!$verify['success']) {
            return $verify['message'];
        }
    }
    
    return true;
}

add_action('wp_head','velocity_ajaxurl');
function velocity_ajaxurl() {
    $html    = '<script type="text/javascript">';
    $html   .= 'var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '"';
    $html   .= '</script>';
    echo $html;
}
//register product template
add_filter( 'template_include', 'velocity_register_produk_template' );
function velocity_register_produk_template( $template ) {    
    if ( is_singular('produk') ) {
        $template = get_stylesheet_directory() . '/single-produk.php';
    }
    if ( is_post_type_archive('produk') || is_tax('kategori-produk') ) {
        $template = get_stylesheet_directory() . '/archive-produk.php';
    }
    return $template;
}
function vdberita_limit_text($text, $limit)
{
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos   = array_keys($words);
        $text  = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}
