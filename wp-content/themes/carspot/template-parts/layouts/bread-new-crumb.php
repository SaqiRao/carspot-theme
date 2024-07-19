<section class="top-bread-crumb">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo home_url( '/' ); ?>"><?php echo esc_html__('Home', 'carspot' ); ?></a></li> /
                        <?php echo carspot_breadcrumb(); ?>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>