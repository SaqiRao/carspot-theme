<?php
global $carspot_theme;
global $post;
?>
<?php 
    if ( is_page( 'rental-main-home' ) || is_shop() ) {
           
    }
    else
    {
   ?>
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
                            <?php echo carspot_breadcrumb(); ?>
                        </a>
                    </li>
               </ul>
             </div>
			 <?php
         
            if(  is_category() || is_tax() ||  is_author() || is_404() || ( isset( $carspot_theme['new_dashboard'] ) && $carspot_theme['new_dashboard'] != $post->ID) )
            {
            ?>
             <div class="header-page">
             <h1><?php echo carspot_bread_crumb_heading(); ?></h1>
             </div>
            <?php
            }
            ?> 
          </div>
       </div>
    </div>
 </div>
 
</div>
<?php
 }?>

