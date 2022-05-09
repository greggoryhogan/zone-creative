<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action('zone_body_open'); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'lshlss' ); ?></a>

    <header class="header">
        <div class="container __header">
            
            <div class="site-branding <?php echo get_field('animate_logo','options'); ?>">
                <h1>
                    <a href="<?php echo get_bloginfo('url'); ?>">
                        <div class="z"><img src="<?php echo ZONE_THEME_URI; ?>/assets/img/z-header.png" alt="<?php echo get_bloginfo('name'); ?>" /></div>
                        <img src="<?php echo ZONE_THEME_URI; ?>/assets/img/zone.png" alt="<?php echo get_bloginfo('name'); ?>" class="zone-img"/>
                    </a>
                </h1>
            </div><!-- .site-branding -->
            
            <div class="mobile-nav">
                <button class="nav-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button><!-- #primary-mobile-menu -->
            </div>
           
            <?php if ( has_nav_menu( 'primary' ) ) : ?>
                <nav id="site-navigation" class="primary-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'zone' ); ?>">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'primary',
                            'menu_class'      => 'menu-wrapper',
                            'container_class' => 'header-menu primary-menu-container',
                            'items_wrap'      => '<ul id="primary-menu" class="%2$s">%3$s</ul>',
                            'fallback_cb'     => false,
                        )
                    );
                    ?>
                </nav><!-- #site-navigation -->
            <?php endif; ?>
            <?php if ( has_nav_menu( 'primary' ) ) : ?>
                <nav id="secondary-navigation" class="secondary-navigation" aria-label="<?php esc_attr_e( 'Secondary menu', 'zone' ); ?>">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'secondary',
                            'menu_class'      => 'menu-wrapper',
                            'container_class' => 'header-menu secondary-menu-container',
                            'items_wrap'      => '<ul id="secondary-menu" class="%2$s">%3$s</ul>',
                            'fallback_cb'     => false,
                        )
                    );
                    ?>
                </nav><!-- #site-navigation -->
            <?php endif; ?>
        </div>
    </header><!-- #masthead -->

    <main id="main" class="content">