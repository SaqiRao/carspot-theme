<?php
global $carspot_theme;
if (isset($carspot_theme['top_bar_type']) && $carspot_theme['top_bar_type'] == "classified") {
    get_template_part('template-parts/layouts/top', 'bar');
} else {
    get_template_part('template-parts/layouts/top-bar', 'services');
}

// print_r($carspot_theme);
?>
<header class="header-area-new">
    <!-- Logo Bar -->
    <div class="logo-bar">
        <div class="container clearfix">
            <!-- Logo -->
            <div class="logo">
                <?php get_template_part('template-parts/layouts/site', 'logo'); ?>
            </div>
            <!--Info Outer-->
            <div class="information-content">
                <?php
                if (isset($carspot_theme["for_email"]) && $carspot_theme["for_email"] != '') {
                    ?>
                    <div class="info-box  hidden-sm">
                        <div class="icon"><span class="icon-envelope"></span></div>
                        <div class="text"><?php echo esc_html($carspot_theme["for_email"]['rane_field_1']); ?></div>
                        <a href="mailto:<?php echo esc_html($carspot_theme["for_email"]['rane_field_2']); ?>"><?php echo esc_html($carspot_theme["for_email"]['rane_field_2']); ?></a> 
                    </div>
                    <?php
                }
                ?>
                <?php
                if (isset($carspot_theme["for_call"]) && $carspot_theme["for_call"] != '') {
                    ?>
                    <!--Info Box-->
                    <div class="info-box">
                        <div class="icon"><span class="icon-phone"></span></div>
                        <div class="text"><?php echo esc_html($carspot_theme["for_call"]['rane_field_1']); ?></div>
                        <a class="location" href="javascript:void(0)"><?php echo esc_html($carspot_theme["for_call"]['rane_field_2']); ?></a> 
                    </div>
                    <?php
                }
                ?>
                <?php
                if (isset($carspot_theme["for_location"]) && $carspot_theme["for_location"] != '') {
                    ?>
                    <div class="info-box">
                        <div class="icon"><span class="icon-map-pin"></span></div>
                        <div class="text"><?php echo esc_html($carspot_theme["for_location"]['rane_field_1']); ?></div>
                        <a class="location" href="javascript:void(0)"><?php echo esc_html($carspot_theme["for_location"]['rane_field_2']); ?> </a> 
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Header Top End -->
    <!-- Menu Section -->
    <div class="navigation-2">
        <nav id="menu-1" class="mega-menu">
            <!-- menu list items container -->
            <section class="menu-list-items">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <!-- menu logo -->
                            <ul class="menu-logo">
                                <li> 

                                </li>
                            </ul>
                            <?php get_template_part('template-parts/layouts/main', 'nav'); ?>
                            <ul class="menu-search-bar">
                                <li>
                                    <?php
                                    get_template_part('template-parts/layouts/ad', 'button');
                                    ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>      
            </section>
        </nav>
    </div>
    <!-- /.navigation-end -->
    <!-- Menu  End -->
</header>
<!-- Navigation Menu End -->
<!-- =-=-=-=-=-=-= Light Header End  =-=-=-=-=-=-= -->



