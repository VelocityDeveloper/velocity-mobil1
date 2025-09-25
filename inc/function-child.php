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
	
	if (class_exists('Kirki')):
		
		/**
		* Customizer control in child themes
		* Sample Panel
		* 
		*/ 
		Kirki::add_panel('panel_velocity', [
			'priority'    => 10,
			'title'       => esc_html__('Velocity Theme', 'justg'),
			'description' => esc_html__('', 'justg'),
		]);

		// section title_tagline
		Kirki::add_section('title_tagline', [
			'panel'    => 'panel_velocity',
			'title'    => __('Site Identity', 'justg'),
			'priority' => 10,
		]);

		///Section Color
		Kirki::add_section('section_colorvelocity', [
			'panel'    => 'panel_velocity',
			'title'    => __('Color & Background', 'justg'),
			'priority' => 10,
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'color',
			'settings'    => 'color_theme',
			'label'       => __('Theme Color', 'kirki'),
			'description' => esc_html__('', 'kirki'),
			'section'     => 'section_colorvelocity',
			'default'     => '#00a091',
			'transport'   => 'auto',
			'output'      => [
				[
					'element'   => ':root',
					'property'  => '--color-theme',
				],
                [
                    'element'   => '.text-colortheme, .text-colortheme i, .page-link',
                    'property'  => 'color',
                ],
                [
                    'element'   => '.bg-colortheme, .page-item.active .page-link',
                    'property'  => 'background-color',
                ],
                [
                    'element'   => '.bg-colortheme, .page-item.active .page-link',
                    'property'  => 'border-color',
                ],
				[
					'element'   => ':root',
					'property'  => '--bs-primary',
				],
				[
					'element'   => '.border-color-theme',
					'property'  => '--bs-border-color',
				]
			],
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'background',
			'settings'    => 'background_themewebsite',
			'label'       => __('Website Background', 'kirki'),
			'description' => esc_html__('', 'kirki'),
			'section'     => 'section_colorvelocity',
			'default'     => [
				'background-color'      => '#F5F5F5',
				'background-image'      => '',
				'background-repeat'     => 'repeat',
				'background-position'   => 'center center',
				'background-size'       => 'cover',
				'background-attachment' => 'scroll',
			],
			'transport'   => 'auto',
			'output'      => [
				[
					'element'   => ':root[data-bs-theme=light] body',
				],
				[
					'element'   => 'body',
				],
			],
		]);

        Kirki::add_panel('panel_mobil', [
			'priority'    => 10,
			'title'       => esc_html__('Setting Mobil', 'justg'),
			'description' => esc_html__('', 'justg'),
		]);

        ///Section Slider Home
		Kirki::add_section('section_slider', [
			'panel'    => 'panel_mobil',
			'title'    => __('Slider Home', 'justg'),
			'priority' => 10,
		]);
        // field section
        new \Kirki\Field\Repeater(
            [
                'settings' => 'slider_repeat',
                'label'    => esc_html__('Slider Home', 'justg'),
                'section'  => 'section_slider',
                'priority' => 10,
                'row_label'    => [
                    'type'  => 'field',
                    'value' => esc_html__('Slider', 'justg'),
                ],
                'button_label' => esc_html__('"Add Slider" ', 'justg'),
                'fields'   => [
                    'imgslider'   => [
                        'type'        => 'image',
                        'label'       => esc_html__('Slider', 'justg'),
                        'description' => esc_html__('', 'justg'),
                        'default'     => '',
                    ],
                ],
            ]
        );

        ///Section Category
        // Kirki::add_section('section_category', [
		// 	'panel'    => 'panel_mobil',
		// 	'title'    => __('Kategori Home', 'justg'),
		// 	'priority' => 10,
		// ]);

        //field section
        // new Kirki\Field\Select(
        //     [
        //         'settings'    => 'category_home',
        //         'label'       => __( 'Kategori Post Home', 'justg' ),
        //         'section'     => 'section_category',
        //         'default'     => '',
        //         'priority'    => 10,
        //         'multiple'    => 1,
        //         'placeholder' => __( 'Pilih Kategori', 'justg' ),
        //         'choices'     => Kirki\Util\Helper::get_terms( array('taxonomy' => 'category') ),
        //     ]
        // );

        ///Section Dealer
		Kirki::add_section('section_dealer', [
			'panel'    => 'panel_mobil',
			'title'    => __('Data Dealer', 'justg'),
			'priority' => 10,
		]);

        // field section dealer
        new \Kirki\Field\Image(
            [
                'settings'    => 'foto_sales',
                'label'       => esc_html__( 'Foto Sales', 'justg' ),
                'description' => esc_html__( 'Upload gambar ukuran lebar 500x500.', 'justg' ),
                'section'     => 'section_dealer',
                'default'     => '',
                'choices'     => [
                    'save_as' => 'id',
                ],
            ]
        );
        new \Kirki\Field\Text(
            [
                'settings' => 'nama_sales',
                'label'    => esc_html__( 'Nama Sales', 'justg' ),
                'section'  => 'section_dealer',
                'default'  => esc_html__( '', 'justg' ),
                'priority' => 10,
            ]
        );
        new \Kirki\Field\Text(
            [
                'settings' => 'notelp',
                'label'    => esc_html__( 'No Telephone', 'justg' ),
                'section'  => 'section_dealer',
                'default'  => esc_html__( '', 'justg' ),
                'description' => esc_html__( 'Contoh. 085123456789', 'justg' ),
                'priority' => 10,
            ]
        );
        new \Kirki\Field\Text(
            [
                'settings' => 'nowa',
                'label'    => esc_html__( 'No Whatsapp', 'justg' ),
                'section'  => 'section_dealer',
                'default'  => esc_html__( '', 'justg' ),
                'description' => esc_html__( 'Contoh. 085123456789', 'justg' ),
                'priority' => 10,
            ]
        );
        new \Kirki\Field\Text(
            [
                'settings' => 'email',
                'label'    => esc_html__( 'Email', 'justg' ),
                'section'  => 'section_dealer',
                'default'  => esc_html__( '', 'justg' ),
                'description' => esc_html__( 'Contoh. info@velocitydeveloper.com', 'justg' ),
                'priority' => 10,
            ]
        );
        new \Kirki\Field\Editor(
            [
                'settings'    => 'pesan_simulasi',
                'label'       => esc_html__( 'Pesan Simulasi Kredit', 'justg' ),
                'description' => esc_html__( '', 'justg' ),
                'section'     => 'section_dealer',
                'default'     => '',
            ]
        );

        ///Section Dealer
		Kirki::add_section('section_simulasi', [
			'panel'    => 'panel_mobil',
			'title'    => __('Simulasi Kredit', 'justg'),
			'priority' => 10,
		]);

        // field seection simulasi
        new \Kirki\Field\Checkbox_Switch(
            [
                'settings'    => 'home_simulasi',
                'label'       => esc_html__( 'Halaman Depan', 'justg' ),
                'description' => esc_html__( 'Aktifkan Simulasi Kredit di Halaman Depan.', 'justg' ),
                'section'     => 'section_simulasi',
                'default'     => 'on',
                'choices'     => [
                    'on'  => esc_html__( 'On', 'justg' ),
                    'off' => esc_html__( 'Off', 'justg' ),
                ],
            ]
        );
        new \Kirki\Field\Checkbox_Switch(
            [
                'settings'    => 'single_simulasi',
                'label'       => esc_html__( 'Single Page', 'justg' ),
                'description' => esc_html__( 'Aktifkan Simulasi Kredit di Single Deskripsi Produk.', 'justg' ),
                'section'     => 'section_simulasi',
                'default'     => 'on',
                'choices'     => [
                    'on'  => esc_html__( 'On', 'justg' ),
                    'off' => esc_html__( 'Off', 'justg' ),
                ],
            ]
        );


		// remove panel in customizer 
		Kirki::remove_panel('global_panel');
		Kirki::remove_panel('panel_header');
		Kirki::remove_panel('panel_footer');
		Kirki::remove_panel('panel_antispam');
		Kirki::remove_control('display_header_text');
        
	endif;

    //remove action from Parent Theme
    remove_action('justg_header', 'justg_header_menu');
    remove_action('justg_do_footer', 'justg_the_footer_open');
    remove_action('justg_do_footer', 'justg_the_footer_content');
    remove_action('justg_do_footer', 'justg_the_footer_close');
    remove_theme_support('widgets-block-editor');

    //Inisialisasi theme child
    add_action('tgmpa_register', 'recmetabox_plugins');
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

function recmetabox_plugins() {
    $plugins = array(
        // Include Metabox plugin
        array(
            'name'     => 'Metabox',
            'slug'     => 'meta-box',
            'required' => true,
        ),
        // Tambahkan plugin wajib lainnya di sini
    );
    $config = array(
        'id'           => 'tgmpa',
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'parent_slug'  => 'themes.php',
        'capability'   => 'edit_theme_options',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '',
        'is_automatic' => false,
        'message'      => '',
    );

    tgmpa( $plugins, $config );
}