<?php global $carspot_theme; ?>
<section class="comming-soon-grid">
         <div class="container">
            <div class="row">
               <div class="col-xs-12 comming-soon">
                  <div class="theme-logo">
                  <a href="<?php echo home_url( '/' ); ?>" >
            <?php 
            if( isset( $carspot_theme['sb_comming_soon_logo']['url'] ) && $carspot_theme['sb_comming_soon_logo']['url'] != "" )
            {
            ?>
               <img src="<?php echo esc_url( $carspot_theme['sb_comming_soon_logo']['url'] ); ?>" alt="<?php echo esc_html__('Site Logo', 'carspot' ); ?>">
            <?php
            }
            else
            {
            ?>
                <img src="<?php echo esc_url( trailingslashit( get_template_directory_uri () ) ). 'images/logo.png' ?>"alt="<?php echo esc_html__('Site Logo', 'carspot' ); ?>" />
            <?php
            }
            ?>
            </a>
            <input type="hidden" id="when_live" value="<?php echo esc_attr($carspot_theme['sb_comming_soon_date']); ?>" />
            <input type="hidden" id="get_time" value="<span>%w</span><?php echo esc_html__( 'weeks', 'carspot' ); ?><span>%d</span> <?php echo esc_html__( 'days', 'carspot' ); ?> <span>%H</span> <?php echo esc_html__( 'hr', 'carspot' ); ?><span>%M</span> <?php echo esc_html__( 'min', 'carspot' ); ?> <span>%S</span><?php echo esc_html__( 'sec', 'carspot' ); ?></span>" />
                     
                  </div>
                  <div class="count-down">
                     <div id="clock"></div>
                  </div>
                  <div class="subscribe">
                     <p><?php echo wp_kses( $carspot_theme['sb_comming_soon_title'], carspot_required_tags() ); ?>
                     
                     </p>
                     <?php 
					 
					 	if( isset( $carspot_theme['coming_soon_notify'] ) && $carspot_theme['coming_soon_notify'] )
						{
					 ?>
                     <form onSubmit="return checkVals();" method="post">
                        <input type="text" name="sb_email" id="sb_email" placeholder="<?php echo esc_html__( 'Valid E-mail Address', 'carspot' ); ?>" autocomplete="off">
                        <button type="button" id="save_email">
                        <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                        <?php echo esc_html__( 'Notify Me', 'carspot' ); ?>
                        </button>
                        <button type="button" id="processing_req">
                        <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                        <?php echo esc_html__( 'Processing...', 'carspot' ); ?>
                        </button>
                        <input type="hidden" id="sb_action" value="coming_soon" />
                     </form>
                     <?php 
						}
					?>
                  </div>
                  <div class="social-area-share">
            <?php
                 foreach( $carspot_theme['social_media_soon']  as $index => $val)
                 {
            ?>
            <?php
                     if($val != "")
                     {
                        ?>
                        <a href="<?php echo esc_url($val); ?>" target="_blank">
                        <i class="<?php echo carspot_social_icons( $index ); ?>" aria-hidden="true"></i>
                        </a>
            <?php
                     }
                 }
			?>
                     
                  </div>
               </div>
            </div>
         </div>
      </section>
<?php wp_footer(); ?>
</body>
</html>