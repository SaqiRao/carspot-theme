<?php global $carspot_theme; ?>
<div class="page-header-area-2 gray">
 <div class="container">
    <div class="row">
       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="small-breadcrumb">
          
             <div class="breadcrumb-link">
                <ul>
                    <li>                       
                         <a href="<?php echo home_url( '/' ); ?>">
                            <?php echo esc_html__('Home', 'carspot' ); ?> 
                        </a>
                    </li>
                    <li class="active">
                        <a href="javascript:void(0);" class="active">
                            <?php echo esc_html__('Reviews', 'carspot' ); ?> 
                        </a>
                    </li>
               </ul>
             </div>
			 <?php
            global $post;
            if( is_archive() || is_category() || is_tax() ||  is_author() || is_404() || ( isset( $carspot_theme['new_dashboard'] ) && $carspot_theme['new_dashboard'] != $post->ID) )
            {
            ?>
             <div class="header-page">
             <!-- <h1><?php echo carspot_bread_crumb_heading(); ?></h1> -->
             <div class="pro-rating ">
			  <?php
              for($i=1;$i<=5;$i++) {
              $star = "";
              if(!empty($post->review_rating) && $i<=$post->review_rating) {
                $star = "fa fa-star";
              }
              ?>
              <a href="javascript:void(0)"><i class="fa fa-star-o<?php echo "".($star); ?>"></i></a>
              <?php
               } 
              ?>
               <span class="star-score ">
               <strong><?php echo "".($post->review_rating) ; ?></strong>
               / <span> <?php echo esc_html__('5', 'carspot' ); ?> </span>
               </span>
                </div>
             </div>
            <?php
			}
			?> 
          </div>
       </div>
    </div>
 </div>
</div>

