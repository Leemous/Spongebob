<?php
/**
 * 定义Title显示方式
 *
 * @param $title
 * @param $sep
 *
 * @return string
 */
function az_theme_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// 添加站点名称.
	$title .= get_bloginfo( 'name' );

	// 首页：添加站点描述.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// 当需要的时候添加页数
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( '页数：%s', 'ty' ), max( $paged, $page ) );
	}

	return $title;
}

add_filter( 'wp_title', 'az_theme_wp_title', 10, 2 );

/**
 * Template for comments and pingbacks.
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
if ( ! function_exists( 'az_comment' ) ) {
	function az_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				?>
				<li class="post pingback">
				<p>Pingback:<?php comment_author_link(); ?><?php edit_comment_link( '编辑', ' ' ); ?></p>
				<?php
				break;
			default :
				?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment">

						<div class="comment-author">
							<?php echo get_avatar( $comment, 55 ); ?>
							<?php printf( __( '%s', 'ty' ), sprintf( '<cite class="commenter">%s</cite>', get_comment_author_link() ) ); ?>
							<?php if ( $comment->user_id == get_queried_object()->post_author ) { ?>
								&nbsp;&nbsp;<span class="label label-success">官方</span>
							<?php } ?>
						</div>
						<!-- .comment-author .vcard -->
						<div class="comment-meta">
							<time class="timeago"
							      datetime="<?php comment_time( 'Y年n月j ag:i' ); ?>"><?php comment_time( 'Y年n月j ag:i' ); ?></time>
						</div>
						<?php if ( $comment->comment_approved == '0' ) : ?>
							<em>您的回复正在审核中...</em>
							<br/>
						<?php endif; ?>

						<div class="comment-content"><?php comment_text(); ?></div>

						<div class="reply">
							<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
							<?php edit_comment_link( '编辑', '&nbsp;&nbsp;' ); ?>
						</div>
						<!-- .reply -->
					</article>
					<!-- #comment-## -->

				<?php
				break;
		endswitch;
	}
}

function az_theme_wp_seo() {
	global $page, $paged, $post, $tyopts;
	$default_keywords = $tyopts['seo-site-keywords']; // customize
	$output           = '';

	// description
	$seo_desc    = strip_tags( get_field( 'seo_description' ) );
	$description = get_bloginfo( 'description', 'display' );
	$pagedata    = get_post( $post->ID );
	if ( is_singular() ) {
		if ( ! empty( $seo_desc ) ) {
			$content = $seo_desc;
		} else if ( ! empty( $pagedata ) ) {
			$content = $description;
		}
	} else if ( is_category() ) {
		$tem_category = get_the_category();
		$content      = strip_tags( category_description( $tem_category[0]->id ) );
	} else if ( is_tag() ) {
		$content = strip_tags( term_description() );
	} else {
		$content = $description;
	}
	$output .= '<meta name="description" content="' . esc_attr( $content ) . '">';

	// keywords
	$keys = get_field( 'seo_keywords' );
	$cats = get_the_category();
	$tags = get_the_tags();
	if ( empty( $keys ) ) {
		if ( ! empty( $cats ) ) {
			foreach ( $cats as $cat ) {
				$keys .= $cat->name . ', ';
			}
		}
		if ( ! empty( $tags ) ) {
			foreach ( $tags as $tag ) {
				$keys .= $tag->name . ', ';
			}
		}

        $keys = $default_keywords;
	}

//    $keys .= "," . $default_keywords;
	$output .= '<meta name="keywords" content="' . esc_attr( $keys ) . '">';


	// title
	$title_custom = get_field( 'seo_title' );
	$url          = ltrim( esc_url( $_SERVER['REQUEST_URI'] ), '/' );
	$name         = get_bloginfo( 'name', 'display' );
	$title        = get_the_title();
	$cat          = single_cat_title( '', false );
	$tag          = single_tag_title( '', false );
	$search       = get_search_query();

	if ( ! empty( $title_custom ) ) {
		$title = $title_custom;
	}
	if ( $paged >= 2 || $page >= 2 ) {
		$page_number = ' | ' . sprintf( 'Page %s', max( $paged, $page ) );
	} else {
		$page_number = '';
	}

	if ( is_home() || is_front_page() ) {
		$seo_title = $name . ' | ' . $description;
	} elseif ( is_singular() ) {
		$seo_title = $title . ' | ' . $name;
	} elseif ( is_tag() ) {
		$seo_title = '' . $tag . ' | ' . $name;
	} elseif ( is_category() ) {
		$seo_title = '' . $cat . ' | ' . $name;
	} elseif ( is_archive() ) {
		$seo_title = '' . $title . ' | ' . $name;
	} elseif ( is_search() ) {
		$seo_title = '搜索: ' . $search . ' | ' . $name;
	} elseif ( is_404() ) {
		$seo_title = '404 - Not Found: ' . $url . ' | ' . $name;
	} else {
		$seo_title = $name . ' | ' . $description;
	}

	$output .= '<title>' . esc_attr( $seo_title . $page_number ) . '</title>';

	// robots
	if ( is_category() || is_tag() ) {
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		if ( $paged > 1 ) {
			$output .= '<meta name="robots" content="noindex,follow">';
		} else {
			$output .= '<meta name="robots" content="index,follow">';
		}
	} else if ( is_home() || is_singular() ) {
		$output .= '<meta name="robots" content="index,follow">';
	} else {
		$output .= '<meta name="robots" content="noindex,follow">';
	}

	return $output;
}

/**
 * 判断字符串是否包含
 * @param $content 检验内容
 * @param $str 目标字符串
 * @return bool 若包含返回true,否则返回false
 */
function az_contains($content, $str) {
    $tmparray = explode($str, $content);
    if(count($tmparray)>1){
        return true;
    } else{
        return false;
    }
}

//获得所有文章查看次数总和
function az_get_all_views() {
	global $wpdb;
	$count = 0;
	$views = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE meta_key='views'" );
	foreach ( $views as $key => $value ) {
		$meta_value = $value->meta_value;
		if ( $meta_value != '' ) {
			$count += (int) $meta_value;
		}
	}

	return $count;
}

//获得指定文章查看次数
function az_custom_the_views( $post_id, $echo = true, $views = '人查看' ) {
	$count_key = 'views';
	$count     = get_post_meta( $post_id, $count_key, true );
	if ( $count == '' ) {
		delete_post_meta( $post_id, $count_key );
		add_post_meta( $post_id, $count_key, '0' );
		$count = '0';
	}
	if ( $echo ) {
		echo number_format_i18n( $count ) . $views;
	} else {
		return number_format_i18n( $count ) . $views;
	}
}

//统计文章查看次数
function az_set_post_views() {
	global $post;
	$post_id   = $post->ID;
	$count_key = 'views';
	$count     = get_post_meta( $post_id, $count_key, true );
	if ( is_single() || is_page() ) {
		if ( isset( $_COOKIE[ 'post_view_count_' . $post_id ] ) ) {
			return;
		}
		if ( $count == '' ) {
			delete_post_meta( $post_id, $count_key );
			add_post_meta( $post_id, $count_key, '0' );
		} else {
			update_post_meta( $post_id, $count_key, $count + 1 );
		}
		setcookie( 'post_view_count_' . $post_id, $post_id, time() * 20, '/' );
	}
}

function az_the_breadcrumb() {
	global $post;
	if ( ! is_home() && ! is_front_page() ) {
		echo '<div class="ty-breadcrumb">';
		echo '<hr class="nobottommargin">';
		echo '<div class="inner">';
		echo '<div class="pull-right">';
		echo '您的位置';
//		echo '<h1>';
//		if ( is_category() || is_single() ) {
//			the_category( '' );
//			if ( is_single() ) {
//				the_title();
//			}
//		} elseif ( is_page() ) {
//			if ( $post->post_parent ) {
//				$anc   = get_post_ancestors( $post->ID );
//				$title = get_the_title();
//				foreach ( $anc as $ancestor ) {
//					$output = '<a href="' . get_permalink( $ancestor ) . '" title="' . get_the_title( $ancestor ) . '">' . get_the_title( $ancestor ) . '</a>';
//				}
//				echo $output;
//				echo '' . $title . '';
//			} else {
//				echo '' . get_the_title() . '';
//			}
//		} elseif ( is_tag() ) {
//			single_tag_title();
//		} elseif ( is_day() ) {
//			echo "归档：";
//			the_time( 'F jS, Y' );
//		} elseif ( is_month() ) {
//			echo "归档：";
//			the_time( 'F, Y' );
//		} elseif ( is_year() ) {
//			echo "归档：";
//			the_time( 'Y' );
//		} elseif ( is_author() ) {
//			echo "作者：";
//		} elseif ( isset( $_GET['paged'] ) && ! empty( $_GET['paged'] ) ) {
//			echo "博客归档：";
//		} elseif ( is_search() ) {
//			echo "搜索结果：";
//		}
//		echo '</h1>';
		echo '</div>';
		echo '<div class="pull-left">';
		echo '<ol>';
		echo '<li><a href="';
		echo get_option( 'home' );
		echo '">';
		echo '首页';
		echo '</a></li>';
		if ( is_category() || is_single() ) {
			echo '<li>';
			the_category( ' </li>&nbsp;<i class="fa fa-angle-double-right"></i>&nbsp;<li> ' );
			if ( is_single() ) {
				echo '</li>&nbsp;<i class="fa fa-angle-double-right"></i>&nbsp;<li>';
				the_title();
				echo '</li>';
			}
		} elseif ( is_page() ) {
			if ( $post->post_parent ) {
				$anc   = get_post_ancestors( $post->ID );
				$title = get_the_title();
				foreach ( $anc as $ancestor ) {
					$output = '<li><a href="' . get_permalink( $ancestor ) . '" title="' . get_the_title( $ancestor ) . '">' . get_the_title( $ancestor ) . '</a></li>';
				}
				echo $output;
				echo $title;
			} else {
				echo '<li>&nbsp;<i class="fa fa-angle-double-right"></i>&nbsp; ' . get_the_title() . '</li>';
			}
		} elseif ( is_tag() ) {
			single_tag_title();
		} elseif ( is_day() ) {
			echo '&nbsp;<i class="fa fa-angle-double-right"></i>&nbsp;<li>归档';
			the_time( 'F jS, Y' );
			echo '</li>';
		} elseif ( is_month() ) {
			echo "<li>归档";
			the_time( 'F, Y' );
			echo '</li>';
		} elseif ( is_year() ) {
			echo "<li>归档";
			the_time( 'Y' );
			echo '</li>';
		} elseif ( is_author() ) {
			echo "<li>归档";
			echo '</li>';
		} elseif ( isset( $_GET['paged'] ) && ! empty( $_GET['paged'] ) ) {
			echo "<li>归档";
			echo '</li>';
		} elseif ( is_search() ) {
			echo "<li>搜索结果";
			echo '</li>';
		}
		echo '</ol>';
		echo '</div>';
		echo '<div class="clearfix"></div>';
		echo '</div>';
		echo '<hr class="nobottommargin">';
		echo '</div>';
	}
}

function get_real_title($title) {
    $text = '';
    $shadow = '';
    if (az_contains($title, '|')) {
        $arr = preg_split('/\|/', $title);
        $text = $arr[0];
        $shadow = $arr[1];
    } else {
        $text = $title;
        $shadow = $title;
    }
    return '<span class="az-nav-text">'.$text.'</span><span class="az-nav-shadow">'.$shadow.'</span>';
}