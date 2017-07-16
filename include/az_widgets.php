<?php

/*
 * 注册小工具区域
 */
if (function_exists('register_sidebar')) {
	
	/* Side bar */
	register_sidebar(
		array(				
			'id' => 'sidebar_right', 					
			'name' => '右挂件区',
			'description' => '在文章和页面右边栏出现',
			'before_widget' => '<aside id="%1$s" class="widget  %2$s">',
			//'after_widget' => '<div class="top-line"><div style="background:rgba(255,255,255,0.0);"></div><div style="background:rgba(255,255,255,0.2);"></div><div style="background:rgba(255,255,255,0.4);"></div><div style="background:rgba(255,255,255,0.6);"></div></div></div>',	
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',		
			'empty_title'=> '',					
		)
	);
	register_sidebar(
		array(				
			'id' => 'sidebar_left', 					
			'name' => '左挂件区',
			'description' => '在文章和页面左边栏出现',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',		
			'empty_title'=> '',					
		)
	);

	/* Footer Widgets */
	$footer_widgets_num = wp_get_sidebars_widgets();
	$footer_widgets_num = (isset($footer_widgets_num['footer-widgets'])) ? count( $footer_widgets_num['footer-widgets']) : 0;

	switch ($footer_widgets_num) {
		case 1:
			$footer_widgets_num = '12';
		break;
		case 2:
			$footer_widgets_num = '6';
		break;
		case 3:
			$footer_widgets_num = '4';
		break;
		case 4:
			$footer_widgets_num = '3';
		break;
		case 5:
			$footer_widgets_num = '2 offset1';
		break;
		case 6:
			$footer_widgets_num = '2';
		break;
		case 7:
			$footer_widgets_num = '1';
		break;
		case 8:
			$footer_widgets_num = '1 offset2';
		break;
		case 11:
			$footer_widgets_num = '1';
		break;
		case 12:
			$footer_widgets_num = '1';
		break;
		default:
			$footer_widgets_num = '1';
		break;
	}

	register_sidebar(array(
	   'name' => '底部挂件区',
	   'id'   => 'footer-widgets',
		'description'   => '在网站页脚区域出现,最多可以放置四个小工具挂件',
		'before_widget' => '<div id="%1$s" class="widget span'.$footer_widgets_num.' %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
   	));
}