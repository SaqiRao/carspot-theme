<?php
global $carspot_theme;
?>
<section class="job-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-7 co-xs-12 text-left">
                <h3><?php echo carspot_bread_crumb_heading(); ?></h3>
            </div>
            <div class="col-md-6 col-sm-5 co-xs-12 text-right">
                <div class="bread">
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo home_url('/'); ?>">
                                <?php echo esc_html__('Home', 'carspot'); ?>
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
