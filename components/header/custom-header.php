<?php if ( get_header_image() ) : ?>
	<div class="custom-header" style="background-image:url(<?php header_image();?>);width:<?php echo esc_attr( get_custom_header()->width );?>px;height:<?php echo esc_attr( get_custom_header()->height ); ?>px">
	<?php endif; // End header image check. ?>
		<div class="site-branding">
			<?php dara_the_custom_logo(); ?>
			<?php
			if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
			endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php
			endif; ?>

			<?php dara_social_menu(); ?>
		</div><!-- .site-branding -->
	</div><!-- .custom-header -->
