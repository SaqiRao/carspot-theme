<?php global $carspot_theme; ?>
<section class="job-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-7 co-xs-12 text-center">
                <h2><?php echo carspot_bread_crumb_heading(); ?></h2>
                <div class="bread">
                    <ol class="breadcrumb">
                        <li>                       
                             <a href="<?php echo home_url( '/' ); ?>">
								<?php echo esc_html__('Home', 'carspot' ); ?> 
                            </a>
                        </li>
                        <li class="active">
							<?php echo carspot_breadcrumb(); ?>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
