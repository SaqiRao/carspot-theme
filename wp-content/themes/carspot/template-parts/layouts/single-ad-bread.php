<?php
	global $carspot_theme;
 if(isset($carspot_theme['style_ad_720_1']) && $carspot_theme['style_ad_720_1'] !=""){?>
<div class="car-detail  gray">
       <div class="advertising">
       <div class="container">
         <div class="banner">
            <?php echo "" . $carspot_theme['style_ad_720_1']; ?>
        </div>
        </div>
       </div>
        </div>
<?php } ?>
<div class="page-header-area-2 no-bottom gray">
 <div class="container">
    <div class="row">
    
    <div class="col-lg-12 no-padding  col-md-12 col-sm-12 col-xs-12">
                  <div class="small-breadcrumb">
                  <div class="col-md-12">
                     <div class=" breadcrumb-link">
                        <ul>
                    <li>                       
                         <a href="<?php echo home_url( '/' ); ?>">
                            <?php echo esc_html__('Home', 'carspot' ); ?> 
                        </a>
                    </li>
                    <?php do_action('carspot_cat_breadcrumb');?>
                    <li class="active">
                        <a href="javascript:void(0);" class="active">
                            <?php echo esc_html__('Ad Detail', 'carspot' ); ?> 
                        </a>
                    </li>
               </ul>
                     </div>
                     
                   </div>
                  </div>
               </div>
    </div>
 </div>
</div>