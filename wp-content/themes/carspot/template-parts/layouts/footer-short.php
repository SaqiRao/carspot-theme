<?php global $carspot_theme;
$style = '';
if( isset( $carspot_theme['footer_bg']['url'] ) && $carspot_theme['footer_bg']['url'] != "" )
{
	$style = 'style=" background: url('. esc_url( $carspot_theme['footer_bg']['url'] ). '); background-repeat: no-repeat; background-attachment: scroll; background-size: cover; background-position: bottom center;"';	
}

?>

 <section class="carspot-footer-section section-style-divider-3" <?php echo ($style); ?> >
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12">
        <div class="get-our-apps-section">
          <div class="get-our-apss-text-section">
            <h2><?php echo esc_html( $carspot_theme['app_main_title'] ); ?></h2>
          </div>
          <div class="apps-short-text">
            <p><?php echo esc_html( $carspot_theme['footer_text_under_apps_btn'] ); ?></p>
          </div>
        </div>
        <div class="new-get-apps-section">
          <?php
				   	if( isset( $carspot_theme['footer_android_app'] ) && $carspot_theme['footer_android_app'] != "" )
					{
						echo '<div class="get-apps"><a href="'. esc_url( $carspot_theme['footer_android_app'] ) .'"><img src="' .  esc_url( trailingslashit( get_template_directory_uri () ) ) .'images/playstore-white.png" alt="'.esc_html__( 'Android App', 'carspot' ).'"></a></div>';
					}
					if( isset( $carspot_theme['footer_ios_app'] ) && $carspot_theme['footer_ios_app'] != "" )
					{
						echo '<div class="get-apps"><a href="'. esc_url( $carspot_theme['footer_ios_app'] ) .'"><img src="' .  esc_url( trailingslashit( get_template_directory_uri () ) ) .'images/appstore-white.png" alt="'.esc_html__( 'IOS App', 'carspot' ).'"></a></div>';
					}
				   
				   ?>
        </div>
      </div>
    </div>
  </div>
            <?php
			   if( isset( $carspot_theme['sb_footer'] ) && $carspot_theme['sb_footer'] != "" )
				{ ?>
					<div class="footer-alignment">
            <div class="container">
               <div class="row">
                  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                     <div class="footer-bottom-new-text-section">
                         <p>  
                            <?php
                                if( isset( $carspot_theme['sb_footer'] ) && $carspot_theme['sb_footer'] != "" )
                                {
                                    echo wp_kses( $carspot_theme['sb_footer'], carspot_required_tags() );
                                }
								else 
								{
							   echo wp_kses( "Copyright 2019 &copy; Theme Created By <a href='https://themeforest.net/user/scriptsbundle/portfolio'>ScriptsBundle</a> All Rights Reserved.", carspot_required_tags() );
								}
							?>
                        </p>
                    </div>
                  </div>
               </div>
            </div>
         </div>
				<?php }
			?>
</section>
