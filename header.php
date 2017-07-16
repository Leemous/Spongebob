<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <title>海绵BB的BB站</title>
    <link href="<?php echo esc_url(get_option( 'favicon', '' )) ?>" rel="icon" type="image/png" />
    <link rel="shortcut icon" href="<?php echo esc_url(get_option( 'favicon', '' )) ?>" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale = 1.0">
    <?php wp_enqueue_script("jquery"); ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<canvas id="myCanvas"></canvas>
<div class="az-main-wrapper">
    <div class="az-nav-wrapper">
        <h1>Yungjen</h1>
        <?php
        $options = array(
            'theme_location'  => 'primary',
            'menu'            => '',
            'container'       => 'nav',
            'container_class' => 'az-nav-bar',
            'container_id'    => '',
            'menu_id'         => 'az-menu',
            'menu_class'      => '',
            'echo'            => true,
            'fallback_cb'     => 'wp_page_menu',
            'before'          => '',
            'after'           => '',
            'link_before'     => '',
            'link_after'      => '',
            'items_wrap'      => '<ul id="%1$s">%3$s</ul>',
            'depth'           => 0,
            'walker'          => new AZ_Menu_Walker()
        );
        wp_nav_menu($options);
        ?>
<!--        <nav class="az-nav-bar">-->
<!--            <ul>-->
<!--                <li>-->
<!--                    <a href="javascript:void(0);">-->
<!--                        <span class="az-nav-text">design</span>-->
<!--                        <span class="az-nav-shadow">vision</span>-->
<!--                    </a>-->
<!--                </li>-->
<!--                <li class="az-active">-->
<!--                    <a href="javascript:void(0);">-->
<!--                        <span class="az-nav-text">ux</span>-->
<!--                        <span class="az-nav-shadow">user x</span>-->
<!--                    </a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="javascript:void(0);">-->
<!--                        <span class="az-nav-text">lab</span>-->
<!--                        <span class="az-nav-shadow">lab</span>-->
<!--                    </a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="javascript:void(0);">-->
<!--                        <span class="az-nav-text">movie</span>-->
<!--                        <span class="az-nav-shadow">movie</span>-->
<!--                    </a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="javascript:void(0);">-->
<!--                        <span class="az-nav-text">music</span>-->
<!--                        <span class="az-nav-shadow">music</span>-->
<!--                    </a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="javascript:void(0);">-->
<!--                        <span class="az-nav-text">about me</span>-->
<!--                        <span class="az-nav-shadow">Yungjen</span>-->
<!--                    </a>-->
<!--                </li>-->
<!--            </ul>-->
<!--        </nav>-->
    </div>
    <div class="az-main-content">