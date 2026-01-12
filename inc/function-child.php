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

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Velocitychild_Slider_Gallery_Control' ) ) {
	class Velocitychild_Slider_Gallery_Control extends WP_Customize_Control {
		public $type = 'velocity_slider_gallery';

		public function render_content() {
			if ( empty( $this->label ) ) {
				return;
			}
			$value = $this->value();
			$ids   = velocitychild_slider_value_to_ids( $value );
			$urls  = velocitychild_slider_value_to_urls( $value );
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php endif; ?>
			</label>
			<div class="velocity-slider-gallery-control" data-control="<?php echo esc_attr( $this->id ); ?>">
				<input type="hidden" class="velocity-slider-gallery-value" <?php $this->link(); ?> value="<?php echo esc_attr( implode( ',', $ids ) ); ?>">
				<p>
					<button type="button" class="button velocity-slider-gallery-button">
						<?php echo esc_html__( 'Pilih Gambar', 'justg' ); ?>
					</button>
				</p>
				<div class="velocity-slider-gallery-preview">
					<?php foreach ( $urls as $url ) : ?>
						<img src="<?php echo esc_url( $url ); ?>" style="width:80px;height:auto;margin:0 6px 6px 0;" alt="">
					<?php endforeach; ?>
				</div>
			</div>
			<?php
		}
	}
}

function velocitychild_customize_register( $wp_customize ) {
	$wp_customize->add_panel( 'panel_velocity', array(
		'priority'    => 10,
		'title'       => esc_html__( 'Velocity Theme', 'justg' ),
		'description' => esc_html__( '', 'justg' ),
	) );

	if ( $wp_customize->get_section( 'title_tagline' ) ) {
		$wp_customize->get_section( 'title_tagline' )->panel = 'panel_velocity';
		$wp_customize->get_section( 'title_tagline' )->priority = 10;
	}

	$wp_customize->add_section( 'section_colorvelocity', array(
		'panel'    => 'panel_velocity',
		'title'    => __( 'Color & Background', 'justg' ),
		'priority' => 10,
	) );

	$wp_customize->add_setting( 'color_theme', array(
		'default'           => '#00a091',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'color_theme',
		array(
			'label'   => __( 'Theme Color', 'justg' ),
			'section' => 'section_colorvelocity',
		)
	) );

	$wp_customize->add_setting( 'background_theme_color', array(
		'default'           => '#F5F5F5',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'background_theme_color',
		array(
			'label'   => __( 'Background Color', 'justg' ),
			'section' => 'section_colorvelocity',
		)
	) );

	$wp_customize->add_setting( 'background_theme_image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'background_theme_image',
		array(
			'label'   => __( 'Background Image', 'justg' ),
			'section' => 'section_colorvelocity',
		)
	) );

	$wp_customize->add_setting( 'background_theme_repeat', array(
		'default'           => 'repeat',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'background_theme_repeat', array(
		'label'   => __( 'Background Repeat', 'justg' ),
		'section' => 'section_colorvelocity',
		'type'    => 'select',
		'choices' => array(
			'no-repeat' => __( 'No Repeat', 'justg' ),
			'repeat'    => __( 'Repeat', 'justg' ),
			'repeat-x'  => __( 'Repeat X', 'justg' ),
			'repeat-y'  => __( 'Repeat Y', 'justg' ),
		),
	) );

	$wp_customize->add_setting( 'background_theme_position', array(
		'default'           => 'center center',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'background_theme_position', array(
		'label'   => __( 'Background Position', 'justg' ),
		'section' => 'section_colorvelocity',
		'type'    => 'select',
		'choices' => array(
			'left top'      => __( 'Left Top', 'justg' ),
			'left center'   => __( 'Left Center', 'justg' ),
			'left bottom'   => __( 'Left Bottom', 'justg' ),
			'center top'    => __( 'Center Top', 'justg' ),
			'center center' => __( 'Center Center', 'justg' ),
			'center bottom' => __( 'Center Bottom', 'justg' ),
			'right top'     => __( 'Right Top', 'justg' ),
			'right center'  => __( 'Right Center', 'justg' ),
			'right bottom'  => __( 'Right Bottom', 'justg' ),
		),
	) );

	$wp_customize->add_setting( 'background_theme_size', array(
		'default'           => 'cover',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'background_theme_size', array(
		'label'   => __( 'Background Size', 'justg' ),
		'section' => 'section_colorvelocity',
		'type'    => 'select',
		'choices' => array(
			'cover'   => __( 'Cover', 'justg' ),
			'contain' => __( 'Contain', 'justg' ),
			'auto'    => __( 'Auto', 'justg' ),
		),
	) );

	$wp_customize->add_setting( 'background_theme_attachment', array(
		'default'           => 'scroll',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'background_theme_attachment', array(
		'label'   => __( 'Background Attachment', 'justg' ),
		'section' => 'section_colorvelocity',
		'type'    => 'select',
		'choices' => array(
			'scroll' => __( 'Scroll', 'justg' ),
			'fixed'  => __( 'Fixed', 'justg' ),
		),
	) );

	$wp_customize->add_panel( 'panel_mobil', array(
		'priority'    => 10,
		'title'       => esc_html__( 'Setting Mobil', 'justg' ),
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
	if ( class_exists( 'Velocitychild_Slider_Gallery_Control' ) ) {
		$wp_customize->add_control( new Velocitychild_Slider_Gallery_Control(
			$wp_customize,
			'slider_repeat',
			array(
				'label'       => esc_html__( 'Slider Home', 'justg' ),
				'description' => esc_html__( 'Pilih beberapa gambar untuk slider.', 'justg' ),
				'section'     => 'section_slider',
			)
		) );
	} else {
		$wp_customize->add_control( 'slider_repeat', array(
			'label'       => esc_html__( 'Slider Home', 'justg' ),
			'description' => esc_html__( 'Pilih beberapa gambar untuk slider.', 'justg' ),
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
	$wp_customize->add_control( 'pesan_simulasi', array(
		'label'   => esc_html__( 'Pesan Simulasi Kredit', 'justg' ),
		'section' => 'section_dealer',
		'type'    => 'textarea',
	) );

	$wp_customize->add_section( 'section_simulasi', array(
		'panel'    => 'panel_mobil',
		'title'    => __( 'Simulasi Kredit', 'justg' ),
		'priority' => 10,
	) );

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

	$wp_customize->remove_panel( 'global_panel' );
	$wp_customize->remove_panel( 'panel_header' );
	$wp_customize->remove_panel( 'panel_footer' );
	$wp_customize->remove_panel( 'panel_antispam' );
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
	$ids = preg_split( '/\s*,\s*/', $raw );
	foreach ( $ids as $id ) {
		$id = absint( $id );
		if ( ! $id ) {
			continue;
		}
		$url = wp_get_attachment_url( $id );
		if ( $url ) {
			$items[] = array(
				'id'        => $id,
				'imgslider' => $url,
			);
		}
	}
	return $items;
}

function velocitychild_sanitize_toggle( $value ) {
	return $value === 'off' ? 'off' : 'on';
}

function velocitychild_customizer_css() {
	$theme_color = get_theme_mod( 'color_theme', '#00a091' );
	$bg_fallback = get_theme_mod( 'background_themewebsite' );
	$bg_color    = get_theme_mod( 'background_theme_color', '#F5F5F5' );
	$bg_image    = get_theme_mod( 'background_theme_image', '' );
	$bg_repeat   = get_theme_mod( 'background_theme_repeat', 'repeat' );
	$bg_pos      = get_theme_mod( 'background_theme_position', 'center center' );
	$bg_size     = get_theme_mod( 'background_theme_size', 'cover' );
	$bg_attach   = get_theme_mod( 'background_theme_attachment', 'scroll' );

	if ( is_array( $bg_fallback ) ) {
		$bg_color  = isset( $bg_fallback['background-color'] ) ? $bg_fallback['background-color'] : $bg_color;
		$bg_image  = isset( $bg_fallback['background-image'] ) ? $bg_fallback['background-image'] : $bg_image;
		$bg_repeat = isset( $bg_fallback['background-repeat'] ) ? $bg_fallback['background-repeat'] : $bg_repeat;
		$bg_pos    = isset( $bg_fallback['background-position'] ) ? $bg_fallback['background-position'] : $bg_pos;
		$bg_size   = isset( $bg_fallback['background-size'] ) ? $bg_fallback['background-size'] : $bg_size;
		$bg_attach = isset( $bg_fallback['background-attachment'] ) ? $bg_fallback['background-attachment'] : $bg_attach;
	}

	$bg_image_css = $bg_image ? "background-image: url('" . esc_url( $bg_image ) . "');" : 'background-image: none;';
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
		:root[data-bs-theme=light] body,
		body {
			background-color: <?php echo esc_html( $bg_color ); ?>;
			<?php echo $bg_image_css; ?>
			background-repeat: <?php echo esc_html( $bg_repeat ); ?>;
			background-position: <?php echo esc_html( $bg_pos ); ?>;
			background-size: <?php echo esc_html( $bg_size ); ?>;
			background-attachment: <?php echo esc_html( $bg_attach ); ?>;
		}
	</style>
	<?php
}

function velocitychild_customizer_assets() {
	wp_enqueue_media();
	$script = <<<'JS'
jQuery(function($){
    $('.velocity-slider-gallery-control').each(function(){
        var control = $(this);
        var button = control.find('.velocity-slider-gallery-button');
        var input = control.find('.velocity-slider-gallery-value');
        var preview = control.find('.velocity-slider-gallery-preview');
        var frame;
        button.on('click', function(e){
            e.preventDefault();
            if (frame) {
                frame.open();
                return;
            }
            frame = wp.media({
                title: 'Pilih Gambar Slider',
                button: { text: 'Gunakan' },
                multiple: true,
                library: { type: 'image' }
            });
            frame.on('select', function(){
                var selection = frame.state().get('selection');
                var ids = [];
                var html = '';
                selection.each(function(attachment){
                    var data = attachment.toJSON();
                    if (data.id) {
                        ids.push(data.id);
                    }
                    if (data.url) {
                        html += '<img src="' + data.url + '" style="width:80px;height:auto;margin:0 6px 6px 0;" alt="">';
                    }
                });
                input.val(ids.join(',')).trigger('change');
                preview.html(html);
            });
            frame.open();
        });
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
	$ids = preg_split( '/\s*,\s*/', $raw );
	return array_filter( array_map( 'absint', $ids ) );
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
	foreach ( velocitychild_slider_value_to_ids( $value ) as $id ) {
		$url = wp_get_attachment_url( $id );
		if ( $url ) {
			$urls[] = $url;
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

function velocitytoko_display_recaptcha() {

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
