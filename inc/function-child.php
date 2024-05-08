<?php

/**
 * Fuction yang digunakan di theme ini.
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

add_action('after_setup_theme', 'velocitychild_theme_setup', 9);

function velocitychild_theme_setup()
{

	// Load justg_child_enqueue_parent_style after theme setup
	add_action('wp_enqueue_scripts', 'justg_child_enqueue_parent_style', 20);

	if (class_exists('Kirki')) :

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
		Kirki::add_section('section_colorjustg', [
			'panel'    => 'panel_velocity',
			'title'    => __('Warna', 'justg'),
			'priority' => 10,
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'color',
			'settings'    => 'color_theme',
			'label'       => __('Warna Tema', 'kirki'),
			'description' => esc_html__('', 'kirki'),
			'section'     => 'section_colorjustg',
			'default'     => '#5A406A',
			'transport'   => 'auto',
			'output'      => [
				[
					'element'   => ':root',
					'property'  => '--color-theme',
				],
				[
					'element'   => ':root',
					'property'  => '--bs-primary',
				],
				[
					'element'   => '.border-color-theme',
					'property'  => '--bs-border-color',
				],
				[
					'element'   => '#primary-menu .dropdown-menu',
					'property'  => '--bs-dropdown-link-active-bg',
				]
			],
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'color',
			'settings'    => 'color_theme2',
			'label'       => __('Warna Tema 2', 'kirki'),
			'description' => esc_html__('', 'kirki'),
			'section'     => 'section_colorjustg',
			'default'     => '#46AEB9',
			'transport'   => 'auto',
			'output'      => [
				[
					'element'   => ':root',
					'property'  => '--color-theme-2',
				],
				[
					'element'   => ':root',
					'property'  => '--bs-secondary',
				]
			],
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'background',
			'settings'    => 'background_themewebsite',
			'label'       => __('Background Website', 'kirki'),
			'description' => esc_html__('', 'kirki'),
			'section'     => 'section_colorjustg',
			'default'     => [
				'background-color'      => 'rgb(235, 235, 235)',
				'background-image'      => get_stylesheet_directory_uri() . '/images/wall.webp',
				'background-repeat'     => 'repeat',
				'background-position'   => 'center center',
				'background-size'       => 'auto',
				'background-attachment' => 'fixed',
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

		// remove panel in customizer 
		Kirki::remove_panel('global_panel');
		Kirki::remove_panel('panel_header');
		Kirki::remove_panel('panel_footer');
		Kirki::remove_panel('panel_antispam');
		Kirki::remove_control('custom_logo');
		Kirki::remove_control('display_header_text');

	endif;

	//remove action from Parent Theme
	remove_action('justg_header', 'justg_header_menu');
	remove_action('justg_do_footer', 'justg_the_footer_open');
	remove_action('justg_do_footer', 'justg_the_footer_content');
	remove_action('justg_do_footer', 'justg_the_footer_close');
	remove_theme_support('widgets-block-editor');
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
		echo '<div id="wrapper-navbar" class="container px-2 px-md-0" itemscope itemtype="http://schema.org/WebSite">';
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
add_action('justg_header', 'justg_header_berita');
function justg_header_berita()
{
	require_once(get_stylesheet_directory() . '/inc/part-header.php');
}
add_action('justg_do_footer', 'justg_footer_berita');
function justg_footer_berita()
{
	require_once(get_stylesheet_directory() . '/inc/part-footer.php');
}
add_action('justg_before_wrapper_content', 'justg_before_wrapper_content');
function justg_before_wrapper_content()
{
	echo '<div class="px-2">';
	echo '<div class="card rounded-0 border-light border-top-0 border-bottom-0 shadow px-0 px-md-3 container">';
}
add_action('justg_after_wrapper_content', 'justg_after_wrapper_content');
function justg_after_wrapper_content()
{
	echo '</div>';
	echo '</div>';
}


//register widget
add_action('widgets_init', 'justg_widgets_init', 20);
if (!function_exists('justg_widgets_init')) {
	function justg_widgets_init()
	{
		register_sidebar(
			array(
				'name'          => __('Left Sidebar', 'justg'),
				'id'            => 'main-sidebar',
				'description'   => __('Left sidebar widget area', 'justg'),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title bg-theme-gradient text-white"><span>',
				'after_title'   => '</span></h3>',
				'show_in_rest'   => true,
			)
		);
		register_sidebar(
			array(
				'name'          => __('Right Sidebar', 'justg'),
				'id'            => 'right-sidebar',
				'description'   => __('Right sidebar widget area', 'justg'),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title bg-theme-gradient text-white"><span>',
				'after_title'   => '</span></h3>',
				'show_in_rest'   => true,
			)
		);
	}
}
if (!function_exists('justg_left_sidebar_check')) {
	function justg_left_sidebar_check()
	{
		if (is_singular('fl-builder-template')) {
			return;
		}
		if (!is_active_sidebar('main-sidebar')) {
			return;
		}
		echo '<div class="left-sidebar widget-area pe-md-2 ps-md-0 col-sm-12 col-md-3 order-md-1 order-4" id="left-sidebar" role="complementary">';
		do_action('justg_before_main_sidebar');
		dynamic_sidebar('main-sidebar');
		do_action('justg_after_main_sidebar');
		echo '</div>';
	}
}
if (!function_exists('justg_right_sidebar_check')) {
	function justg_right_sidebar_check()
	{
		if (is_singular('fl-builder-template')) {
			return;
		}
		if (!is_active_sidebar('right-sidebar')) {
			return;
		}
		echo '<div class="right-sidebar widget-area pe-md-0 ps-md-2 col-sm-12 col-md-3 order-md-4 order-5" id="left-sidebar" role="complementary">';
		do_action('justg_before_right_sidebar');
		dynamic_sidebar('right-sidebar');
		do_action('justg_after_right_sidebar');
		echo '</div>';
	}
}

add_action('wp_footer', 'justg_wp_footer');
function justg_wp_footer()
{
	$bgimg = velocitytheme_option('background_themewebsite', '');
?>
	<?php if (empty($bgimg) || $bgimg && empty($bgimg['background-image'])) : ?>
		<style>
			:root[data-bs-theme=light] body {
				background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/wall.webp);
				background-color: #FFF8EB;
				background-repeat: repeat;
				background-position: center;
				background-attachment: fixed;
				background-size: auto;
			}
		</style>
	<?php endif; ?>
<?php
}
