<?php global $carspot_theme;
$style = '';
if( isset( $carspot_theme['footer_bg']['url'] ) && $carspot_theme['footer_bg']['url'] != "" )
{
	$style = 'style=" background: url('. esc_url( $carspot_theme['footer_bg']['url'] ). '); background-repeat: no-repeat; background-attachment: scroll; background-size: cover; background-position: bottom center;"';	
}
?>
 <section class="footer-transparent" <?php echo ($style); ?>>
         <div class="container">
            <div class="row">
               <div class="col-lg-5 col-sm-6 col-md-5 col-xs-12">
                  <div class="footer-block">
                     <?php 
						if( isset( $carspot_theme['footer_logo']['url'] ) && $carspot_theme['footer_logo']['url'] != "" )
						{
						?>
						   <img src="<?php echo esc_url( $carspot_theme['footer_logo']['url'] ); ?>" class="img-responsive footer-logo" alt="<?php echo esc_html__('Site Logo', 'carspot' ); ?>">
						<?php
						}
						else
						{
						?>
							<img src="<?php echo esc_url( trailingslashit( get_template_directory_uri () ) ). 'images/logo.png' ?>" class="img-responsive" alt="<?php echo esc_html__('Logo', 'carspot' ); ?>" />
						<?php
						}
					 ?>
                     <p><?php echo esc_html( $carspot_theme['footer_text_under_logo'] ); ?></p>
                     <div class="social-bar">
                        <ul>
                        <?php
							if(isset($carspot_theme['social_media']) && $carspot_theme['social_media'] !="")
							{
								 foreach( $carspot_theme['social_media']  as $index => $val)
								 {
							?>
							<?php
									 if($val != "")
									 {
							?>
										<li> <a class="<?php echo carspot_social_icons( $index ); ?>" href="<?php echo esc_url($val); ?>"></a> </li>
							<?php
									 }
								 }
							}
							?>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="col-sm-6 col-md-4 col-lg-4 col-xs-12">
                  <div class="footer-block">
                     <h4><?php echo esc_html( $carspot_theme['section_4_title'] ); ?></h4>
                     <ul class="page-links multiple">
                     	<?php
                            if( isset($carspot_theme['sb_footer_pages']) )
                            {
                                foreach ( $carspot_theme['sb_footer_pages'] as $foot_page)
                                {
									echo '<li><a href="' . esc_url( get_the_permalink( $foot_page ) ) . '">'. esc_html__( get_the_title($foot_page) ,'carspot') . '</a></li>';
                                }
                              
                            }
                            ?>
                     </ul>
                  </div>
               </div>
               <div class="col-sm-12 col-md-3 col-lg-3 col-xs-12">
                  <div class="footer-block">
                     <h4><?php echo esc_html( $carspot_theme['app_main_title'] ); ?></h4>
                     <?php
				   	if( isset( $carspot_theme['footer_android_app'] ) && $carspot_theme['footer_android_app'] != "" )
					{
						echo '<div class="app-btn">
								<a href="'. esc_url( $carspot_theme['footer_android_app'] ) .'">
									<div class="icon">
										  <i class="fa fa-play"></i>
									   </div>
									   <div class="icon-text">
										  <small> '.esc_html__( 'Get it On', 'carspot' ).' </small>
										  <h5> '.esc_html__( 'Google Play', 'carspot' ).'</h5>
									   </div>
								</a>
							</div>';
					}
					if( isset( $carspot_theme['footer_ios_app'] ) && $carspot_theme['footer_ios_app'] != "" )
					{
						echo '<div class="app-btn">
								<a href="'. esc_url( $carspot_theme['footer_ios_app'] ) .'">
									<div class="icon">
										  <i class="fa fa-apple"></i>
									   </div>
									   <div class="icon-text">
										  <small> '.esc_html__( 'Get it On', 'carspot' ).' </small>
										  <h5> '.esc_html__( 'App Store', 'carspot' ).'</h5>
									   </div>
								</a>
							</div>';
					}
				   
				   ?>
                  </div>
               </div>
            </div>
         </div>
<?php
   if( isset( $carspot_theme['sb_footer'] ) && $carspot_theme['sb_footer'] != "" )
	{ ?>
		<div class="footer-bottom">
            <div class="container">
               <div class="row">
                  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
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
	<?php 
    }
    ?>
</section>	