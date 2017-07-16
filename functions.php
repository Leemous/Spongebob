<?php

/**
 * 设置主题默认选项，注册和加载WordPress的多种功能
 */

remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'start_post_rel_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'adjacent_posts_rel_link' );


function az_setup() {
	/*
	 * 声明主题支持多语言
	 * 翻译文件放在 /languages/ 文件夹下.
	 */
	load_theme_textdomain( 'tianyidesign', get_template_directory() . '/languages' );

	//添加文章和评论 RSS feed 链接到head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * 声明文章和页面支持缩略图
	 */
	add_theme_support( 'post-thumbnails' );
	//add_image_size( 'product-home-thumb', 370, 260, true );

	// 注册主菜单
	register_nav_menus( array(
		'primary' => __( '主导航', 'ty_primary' )
	) );

	//去掉前台管理工具条
	show_admin_bar(false);

	/*
	 * 声明支持的文章形式.
	 * 日志，图像，视频，引语，链接
	 */
	/*add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link'
	) );*/
}
add_action( 'after_setup_theme', 'az_setup' );

/**
 * 加载CSS和JS
 */
function az_enqueue_scripts() {
	if (!is_admin()) {
		//CSS
		wp_enqueue_style( 'az-bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '3.3.7', '' );
		wp_enqueue_style( 'az-base', get_template_directory_uri() . '/assets/css/base.css', array(), '1.0', '' );
		wp_enqueue_style( 'az-common', get_template_directory_uri()  . '/assets/css/common.css', array(), '1.0', '' );

		//JS
		//jQuery--替换Wordpress自带的jQuery
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', get_template_directory_uri() . '/assets/js/jquery.min.js', array(), '3.2.1', false );//jQuery must be imported on the head.
		wp_enqueue_script( 'jquery' );

		// modernizr 浏览器性能检测
		wp_enqueue_script( 'az-modernizr', get_template_directory_uri() . '/assets/js/modernizr.js', array( '' ), '2.8.3', true );

		// 自定义js
		wp_enqueue_script( 'az-main', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ), '1.0', true );
	}
}
add_action( 'init', 'az_enqueue_scripts' );

function az_enqueue_dynamic_css() {
//	wp_register_style( 'ty_dynamic_colors', get_template_directory_uri() . '/assets/css/color.css.php', 'style' );
//	wp_enqueue_style( 'ty_dynamic_colors' );
//
//	wp_register_style( 'ty_custom_css', get_template_directory_uri() . '/assets/css/custom.css.php', 'style' );
//	wp_enqueue_style( 'ty_custom_css' );
}

add_action( 'wp_print_styles', 'az_enqueue_dynamic_css' );
if ( ! function_exists( 'az_custom_admin_scripts' ) ) {
	function az_custom_admin_scripts() {
		wp_enqueue_media();
		wp_enqueue_script( 'ty-admin-js', get_template_directory_uri() . '/admin/assets/js/admin-script.js', array( 'jquery' ), null, true );

		wp_register_style( 'ty_wp_admin_css', get_template_directory_uri() . '/admin/assets/css/admin-style.css', false, '1.0.0' );
		wp_enqueue_style( 'ty_wp_admin_css' );
	}

	add_action( 'admin_enqueue_scripts', 'az_custom_admin_scripts' );
}

add_filter( 'body_class', 'az_body_classes' );
function az_body_classes( $classes ) {
//	$classes[] = 'boxedlayout';
//	$classes[] = 'orange';
//	$classes[] = 'bg2';

	return $classes;
}

//分页
function pagination($query_string){
	global $paged,$posts_per_page;
	$my_query = new WP_Query($query_string);
	$total_posts = $my_query->post_count;
	if(empty($paged))$paged = 1;
	$prev = $paged - 1;
	$next = $paged + 1;
	$range = 2; // only edit this if you want to show more page-links
	$showitems = ($range * 2)+1;

	$pages = ceil($total_posts/$posts_per_page);

	if(1 != $pages){
		$e = "<ul class='pagination'>";
		$e .= ($paged > 1 && $showitems < $pages)? "<li><a href='".get_pagenum_link($prev)."'>&laquo;</a></li>":"";

		for ($i = 1; $i <= $pages; $i++){
			if (1 != $pages &&( !($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )){
				$e .= "<li";
				if($paged == $i)
				{
					$e.=" class='active'";
				}
				$e.="><a href='".get_pagenum_link($i)."'>".$i."</a></li>";
			}
		}
		$e .= ($paged < $pages && $showitems < $pages) ? "<li><a href='".get_pagenum_link($next)."'>&raquo;</a></li>" :"";
		$e .= "</ul>";
		echo $e;
	}
}

require_once(get_template_directory() . '/include/az_libs.php');
require_once(get_template_directory() . '/include/az_menu_walker.php');
require_once(get_template_directory() . '/include/az_widgets.php');


//移除所有更新通知， 主题更新提示与插件更新提示，wordpress本身的更新
function remove_core_updates() {
	global $wp_version;
	return (object) array( 'last_checked' => time(), 'version_checked' => $wp_version, );
}
add_filter( 'pre_site_transient_update_core', 'remove_core_updates' );
add_filter( 'pre_site_transient_update_plugins', 'remove_core_updates' );
add_filter( 'pre_site_transient_update_themes', 'remove_core_updates' );


if (function_exists('add_theme_support') ) { // Added in 2.9

	add_theme_support('post-thumbnails');

    set_post_thumbnail_size(50, 50, true ); // Normal post thumbnails

    add_image_size('item-thumbnail', 350, 200, true );

	add_image_size('single-thumbnail', 750, 400, true );

	add_image_size('single-medicine-thumbnail', 550, 400, true );

	add_image_size('list-thumbnail', 300, 200, true );

	add_image_size('sidebar-list-thumbnail', 100, 80, true );
}