<?php global $carspot_theme; ?>
    <a href="<?php echo home_url( '/' ); ?>">
        <?php 
		if ( is_singular( 'ad_post' ) && $carspot_theme['single_ad_style'] == 2 )
		{ ?>
			<img src="<?php echo esc_url( $carspot_theme['sb_site_logo_light']['url'] ); ?>" alt="<?php echo esc_html__('Logo Sticky', 'carspot' ); ?>" id="sb_site_logo">
		<?php 
		}
		else if(is_page_template( 'page-profile.php' ))
		{ ?>
			<img src="<?php echo esc_url( $carspot_theme['sb_site_logo_light']['url'] ); ?>" alt="<?php echo esc_html__('Logo Sticky', 'carspot' ); ?>" id="sb_site_logo">
		<?php
        }
		else if ( $carspot_theme['sb_sticky_header'] &&  $carspot_theme['sb_header'] == "transparent" || $carspot_theme['sb_header'] == "transparent2")
		{ ?>
			<img src="<?php echo esc_url( $carspot_theme['sb_site_logo']['url'] ); ?>" alt="<?php echo esc_html__('Logo Sticky', 'carspot' ); ?>" id="sb_site_logo">
		<?php 
		}
		else {
			if( isset( $carspot_theme['sb_site_logo']['url'] ) && $carspot_theme['sb_site_logo']['url'] != "" )
			{
			?>
			   <img src="<?php echo esc_url( $carspot_theme['sb_site_logo']['url'] ); ?>" alt="<?php echo esc_html__('Logo', 'carspot' ); ?>" id="sb_site_logo">
			<?php
			}
			else
			{
			?>
				<img src="<?php echo esc_url( trailingslashit( get_template_directory_uri () ) ). 'images/logo.png' ?>" alt="<?php echo esc_html__('Logo', 'carspot' ); ?>"  id="sb_site_logo" />
			<?php
			}
		}
        ?>
    </a>